<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\loginUsers\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\authclient\ClientInterface;
use humhub\components\Controller;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Invite;
use humhub\modules\loginUsers\models\forms\Registration;
use humhub\modules\user\authclient\interfaces\ApprovalBypass;
use humhub\modules\loginUsers\models\UserInviteGroup;

/**
 * RegistrationController handles new user registration
 *
 * @since 1.1
 */
class RegistrationController extends Controller
{

    /**
     * @inheritdoc
     */
    public $layout = "@humhub/modules/user/views/layouts/main";

    /**
     * @inheritdoc
     */
    public $subLayout = "_layout";

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            throw new HttpException(401, 'Your are already logged in! - Logout first!');
        }

        return parent::beforeAction($action);
    }

    /**
     * Registration Form
     *
     * @return type
     * @throws HttpException
     */
    public function actionIndex()
    {
        $registration = new Registration();

        /**
         * @var \yii\authclient\BaseClient
         */
        $authClient = null;
        $inviteToken = Yii::$app->request->get('token', '');

        $viewToShow = null;

        if ($inviteToken != '') {
            /* If The user comes from a email validation enters here */
            $this->handleInviteRegistration($inviteToken, $registration);


            /* Check the type of the user */
            $userInvite = Invite::findOne(['token' => $inviteToken]);

            if (!$userInvite) {
                throw new HttpException(404, 'Invalid registration token!');
            }


            /* Check the group of the user who receive the email validation */
            $userInviteGroup = UserInviteGroup::findOne(['user_invite_id' => $userInvite->id]);
            if (!$userInviteGroup) {
                throw new HttpException(404, 'Invalid registration, the user is not assigned to a group');
            }

            $viewToShow = $userInviteGroup->group_id;

            $session = Yii::$app->session;
            $session->set('linkedinUserType', $viewToShow);


        } elseif (Yii::$app->session->has('authClient')) {
            $authClient = Yii::$app->session->get('authClient');
            $this->handleAuthClientRegistration($authClient, $registration);
        } else {
            Yii::$app->session->setFlash('error', 'Registration failed.');
            return $this->redirect(['/user/auth/login']);
        }

        if ($registration->submitted('save') && $registration->validate() && $registration->register($authClient)) {
            Yii::$app->session->remove('authClient');

            // Autologin when user is enabled (no approval required)
            if ($registration->getUser()->status === User::STATUS_ENABLED) {
                Yii::$app->user->switchIdentity($registration->models['User']);
                return $this->redirect(['/dashboard/dashboard']);
            }

            return $this->render('success', [
                'form' => $registration,
                'needApproval' => ($registration->getUser()->status === User::STATUS_NEED_APPROVAL)
            ]);
        }


        if($viewToShow == INNOVATION_ADVISOR_GROUP_ID){
            return $this->render('innovationAdvisor', ['hForm' => $registration]);
        }else if($viewToShow == INNOVATOR_GROUP_ID){
            return $this->render('innovator', ['hForm' => $registration]);
        }else{
            Yii::$app->session->setFlash('error', 'Registration failed.');
            return $this->redirect(['/dashboard/dashboard']);
        }
    }

    protected function handleInviteRegistration($inviteToken, Registration $form)
    {
        $userInvite = Invite::findOne(['token' => $inviteToken]);

        if (!$userInvite) {
            throw new HttpException(404, 'Invalid registration token!');
        }

        /* If this is from invitation for a specific space, we need to create the  */
        if($userInvite != null && $userInvite->space_invite_id != null){

            $userInviteGroup = UserInviteGroup::findOne(['user_invite_id' => $userInvite->id]);
            if (!$userInviteGroup) {
                /* We need to create a UserInviteGroup and save it the group of the user */
                $newUserInviteGroup = new UserInviteGroup();
                $newUserInviteGroup->user_invite_id = $userInvite->id;
                $newUserInviteGroup->group_id = INNOVATOR_GROUP_ID;

                $resultSaveInUserInviteGroup = $newUserInviteGroup->save();

                if (!$resultSaveInUserInviteGroup) {
                    throw new HttpException(404, 'Invalid registration, the user is not assigned to a group');
                }
            }
        }

        /* Check the group of the user who receive the email validation */
        $userInviteGroup = UserInviteGroup::findOne(['user_invite_id' => $userInvite->id]);
        if (!$userInviteGroup) {
            throw new HttpException(404, 'Invalid registration, the user is not assigned to a group');
        }

        if ($userInvite->language) {
            Yii::$app->language = $userInvite->language;
        }
        $form->getUser()->email = $userInvite->email;

        /* If the action is save enter setGroupUserId */
        if($form->submitted('save')){
            $form->setGroupUserId($userInviteGroup->group_id);
        }
    }

    /**
     * @param \yii\authclient\BaseClient $authClient
     * @param Registration $registration
     * @return boolean already all registration data gathered
     * @throws Exception
     */
    protected function handleAuthClientRegistration(ClientInterface $authClient, Registration $registration)
    {
        $attributes = $authClient->getUserAttributes();

        if (!isset($attributes['id'])) {
            throw new Exception("No user id given by authclient!");
        }

        $registration->enablePasswordForm = false;
        if ($authClient instanceof ApprovalBypass) {
            $registration->enableUserApproval = false;
        }

        // do not store id attribute
        unset($attributes['id']);

        $registration->getUser()->setAttributes($attributes, false);
        $registration->getProfile()->setAttributes($attributes, false);
    }

}

?>
