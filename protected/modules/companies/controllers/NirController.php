<?php

namespace humhub\modules\companies\controllers;

use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\models\SpaceUserRole;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cards\widgets\ContentCard;
use humhub\modules\companies\models\Company;
use humhub\modules\companies\models\CompanySpace;
use humhub\modules\companies\models\NirRelated;
use humhub\modules\companies\models\SpaceTypeRelationship;
use humhub\modules\polls\models\Poll;
use humhub\modules\polls\permissions\CreatePoll;
use humhub\modules\space\models\Membership;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\Profile;
use humhub\modules\user\models\User;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;


/**
 * Default controller for the `example` module
 */
class NirController extends ContentContainerController
{

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }


    public function actionCreate()
    {
        $company_id =  Yii::$app->request->get('company_id');
        $card_id =  Yii::$app->request->get('card_id');
        $prev_space_id = Yii::$app->request->get('space_id');

        if (Yii::$app->request->method == 'POST') {

            $space_name =  Yii::$app->request->post('space_name');
            $space = new Space();

            $space->load(Yii::$app->request->post()) ;

            $company = Company::findOne($company_id);

            $prev_space = Space::findOne($prev_space_id);

            $space_related_type = SpaceTypeRelationship::findOne(array('category_id' => $prev_space->space_type_id));

            // Creamos un Nuevo Space
            if (!$space_related_type) return;

            $user = User::findOne(Yii::$app->user->id);

            if (!$prev_space) return;

            // Yii::$app->user->switchIdentity(User::findOne(['id' => 1]));

            $space->scenario = 'create';
            $space->space_type_id = $space_related_type->category_related;
            $space->visibility = Space::VISIBILITY_NONE;
            $space->join_policy = $prev_space->join_policy;
            $space->created_by = $user->id;
            $space->color = '#6fdbe8';
            $space->save();

            // Yii::$app->user->switchIdentity($user);

            if (!$space->id) return;

            foreach ($space->getAvailableModules() as $module) {
                $space->enableModule($module->id);
            }

            //Asociar el espacio con el pre-nir
            $nir_related = new NirRelated();
            $nir_related->id_space_pre_nir = $prev_space->id;
            $nir_related->id_space_nir = $space->id;
            $nir_related->save();

            $r_space = Space::findOne($space->id);
            //Invitar al Advisor al Espacio a partir de los miembros actuales de este espacio.
            $user_ids = [];
            $user_ids[2] = $user->id;

            foreach ($prev_space->getMemberships()->all() as $membership ) {
                if ($membership->user_id != Yii::$app->user->id) {
                    $user_ids[3] = $membership->user_id;
//                    $space->inviteMember($membership->user_id, Yii::$app->user->id);
                    $space->addMember($membership->user_id);
                }
            }

            // Invite Company

            $user_company = User::findOne(array('email' => $company->contact_email));
            if (!$user_company)
                $space->inviteMemberByEMail($company->contact_email, Yii::$app->user->id);
            else {
                $user_ids[5] = $user_company->id;

//            $space->inviteMember($user_company->id, Yii::$app->user->id);
                $space->addMember($user_company->id);

            }

            $company_space = new CompanySpace();
            $company_space->company_id = $company->id;
            $company_space->space_id = $space->id;

            //Roles de Usuario

            foreach ($user_ids as $key => $user_id) {

                $current_user_space_role = SpaceUserRole::findOne(array('space_id' => $space->id, 'user_id' => $user_id));

                $current_user_space_role->user_role_id = $key;

                if ($current_user_space_role->update()) {

                    StepFlow::deleteFlow($current_user_space_role->user_id, $current_user_space_role->space_id);

                    StepFlow::insertFlow($current_user_space_role->user_id, $current_user_space_role->space_id);
                }

            }

            //Carta Completada ( Estado Active )

            $this->updateFlowStatus($card_id,  UserCard::STATUS_COMPLETED);

            $result=CompanySpace::find()->where(['company_id' => $_GET['company_id'], 'space_id' => $_GET['space_id']])->all();
            $id=$result[0]->id;

            $cSpace_nir  = CompanySpace::findOne($id);
            $cSpace_nir->status = 2;
            $cSpace_nir->save();

            return;

        }

        return $this->renderAjax('create', array(
            'contentContainer' => $this->contentContainer,
            'space' => new Space(),
            'card_id' =>  $card_id,
            'company_id' => $company_id,
            'space_id' => $prev_space_id

        ));
    }


    public function actionAddTo()
    {
        if (Yii::$app->request->method == 'POST') {

            $nir_id     = Yii::$app->request->post('nir');
            $space_nir  = Space::findOne($nir_id);

            $company_id =  Yii::$app->request->get('company_id');
            $company = Company::findOne($company_id);

            $space_nir->inviteMemberByEMail($company->contact_email, Yii::$app->user->id);

            $company_space = new CompanySpace();
            $company_space->company_id = $company->id;
            $company_space->space_id = $space_nir->id;

            $result=CompanySpace::find()->where(['company_id' => $_GET['company_id'], 'space_id' => $_GET['space_id']])->all();
            $id=$result[0]->id;

            $cSpace_nir  = CompanySpace::findOne($id);
            $cSpace_nir->status = 2;
            $cSpace_nir->save();
            return;

        }

        return $this->renderAjax('show', array(
            'contentContainer' => $this->contentContainer,
            'card_id' =>  Yii::$app->request->get('card_id')
        ));
    }

    public function actionDismis()
    {
        $result = CompanySpace::find()->where(['company_id' => $_GET['company_id'], 'space_id' => $_GET['space_id']])->all();
        $id = $result[0]->id;
        if (Yii::$app->request->method == 'POST') {

            $cSpace_nir = CompanySpace::findOne($id);
            $cSpace_nir->status = 1;
            $cSpace_nir->reason = $_GET['reason'];
            $cSpace_nir->save();

            return;
        }
        return $this->renderAjax('dismis', array(
            'contentContainer' => $this->contentContainer,
            'space' => new Space(),
            'card_id' =>  $id,
            'space_id' =>  $_GET['space_id'],
            'company_id' => $_GET['company_id'],
            'reason' => $_GET['reason']
        ));
    }

    public  function actionCloseNir() {
        $card_id =  Yii::$app->request->get('card_id');

        $space_id     = Yii::$app->request->get('space_id');
        $space_nir  = Space::findOne($space_id);
        if (!$space_nir) return;
        $space_nir->space_type_id = 11;
        $space_nir->save();

        $this->updateFlowStatus($card_id,  UserCard::STATUS_COMPLETED);
    }

    public function actionUpdateAdvisor () {

        $card_id =  Yii::$app->request->get('card_id');
        $user_role = SpaceUserRole::findOne(array('user_id' => Yii::$app->request->get('user_id'),
            'space_id' => Yii::$app->request->get('space_id')) );

        if (!$user_role) return;

        $user_role->load(Yii::$app->request->post());

        if ($user_role->validate() && $user_role->update()) {
            StepFlow::deleteFlow($user_role->user_id, $user_role->space_id);

            StepFlow::insertFlow($user_role->user_id, $user_role->space_id);
        }


        $this->updateFlowStatus($card_id,  UserCard::STATUS_COMPLETED);
    }

}
