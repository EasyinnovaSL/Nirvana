<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\help\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use humhub\modules\user\models\GroupUser;
use humhub\modules\help\models\UserInteractiveTutorialState;
use yii\helpers\ArrayHelper;

/**
 * EenForm Widget
 *
 * @author Jordi
 */
class InteractiveGuidedTourPage extends Widget
{
    public $contentContainer;

    const PAGE_DASHBOARD = "DASHBOARD";

    const PAGE_CARDS_PRE_ACCEPT_INVITE = "PAGE_CARDS_PRE_ACCEPT_INVITE";
    const PAGE_CARDS_PRE_START_BUTTON = "PAGE_CARDS_PRE_START_BUTTON";
    const PAGE_CARDS_PRE_BEFORE_CARDS = "PAGE_CARDS_PRE_BEFORE_CARDS";
    const PAGE_CARDS_PRE_WITH_CARDS = "PAGE_CARDS_PRE_WITH_CARDS";

    const PAGE_PRENIR = "PRE-NIR";
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    const LOAD_AND_RUN = 1;
    const ONLY_LOAD = 0;

    const LOAD_GENERAL_INTERACTIVE_TUTORIAL_FOR_SPACE = 0;
    const LOAD_INTERACTIVE_TUTORIAL_PRE_ACCEPT_INVITE= 1;
    const LOAD_INTERACTIVE_TUTORIAL_PRE_START_BUTTON= 2;
    const LOAD_INTERACTIVE_TUTORIAL_PRE_BEFORE_CARDS= 3;

    public function init(){}

    public function run()
    {
        if (!Yii::$app->user->isGuest){
            /* Check if the user is innovator Advisor */
            $userGroup = GroupUser::find()->where(['user_id' => Yii::$app->user->id])->one();

            $home = Url::home();

            if($home == Yii::$app->request->url || strpos(rawurldecode(Yii::$app->request->url), 'dashboard') !== false){

                $current_user_step_active = UserInteractiveTutorialState::find()->where(array('user_id' => Yii::$app->user->id, 'status' => 1, 'tutorial_page_name' => InteractiveGuidedTourPage::PAGE_DASHBOARD))->one();

                if(empty($current_user_step_active)){
                    return $this->render('interactiveGuidedTourPage',['userGroupId' =>  $userGroup->group_id, 'loadAndRunTutorialScript' => InteractiveGuidedTourPage::LOAD_AND_RUN,'page_url' => Yii::$app->request->url]);
                }else{
                    return $this->render('interactiveGuidedTourPage',['userGroupId' =>  $userGroup->group_id, 'loadAndRunTutorialScript' => InteractiveGuidedTourPage::ONLY_LOAD,'page_url' => Yii::$app->request->url]);
                }

            }else if(strpos(rawurldecode(Yii::$app->request->url), 'cards/card/show') !== false){

                $current_user_step_active = UserInteractiveTutorialState::find()->where(array('user_id' => Yii::$app->user->id, 'status' => 1))->orderBy("created DESC")->all();

                $listOfInteractiveTurorialName = ArrayHelper::getColumn($current_user_step_active, 'tutorial_page_name');

                if(empty($current_user_step_active)){
                    return $this->render('interactiveGuidedTourPreNir',['userGroupId' =>  $userGroup->group_id, 'loadAndRunTutorialScript' => InteractiveGuidedTourPage::LOAD_AND_RUN, 'lastInteractiveTutorialShowed' => "NO_PREVIOUS_PAGE", 'page_url' => Yii::$app->request->url]);
                }else{
                    return $this->render('interactiveGuidedTourPreNir',['userGroupId' =>  $userGroup->group_id, 'loadAndRunTutorialScript' => InteractiveGuidedTourPage::ONLY_LOAD, 'lastInteractiveTutorialShowed' => $listOfInteractiveTurorialName, 'page_url' => Yii::$app->request->url]);
                }
            }
        }
    }

}


