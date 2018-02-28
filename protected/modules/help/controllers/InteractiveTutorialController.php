<?php

namespace humhub\modules\help\controllers;

use Yii;
use yii\helpers\Url;
use humhub\modules\help\models\UserInteractiveTutorialState;
use humhub\components\Controller;
use humhub\modules\help\widgets\InteractiveGuidedTourPage;


class InteractiveTutorialController extends Controller
{
    public function actionSaveStateInteractiveTutorial()
    {
        if (!Yii::$app->user->isGuest){

            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                $tutorial_page_name =  $data['tutorial_page_name'];
                $page_url =  $data['page_url'];

                $home = Url::home();

                if($home == $page_url || strpos(rawurldecode($page_url), 'dashboard') !== false) {

                    $loadEnjoyHintJavascript =  $this->checkIntectactiveTutorialStateTable(Yii::$app->user->id, InteractiveGuidedTourPage::PAGE_DASHBOARD);

                    return $loadEnjoyHintJavascript;

                }else if(strpos(rawurldecode($page_url), 'cards/card/show') !== false){
                    $loadEnjoyHintJavascript = $this->checkIntectactiveTutorialStateTable(Yii::$app->user->id, $tutorial_page_name);

                    return $loadEnjoyHintJavascript;
                }
            }
        }
    }

    private function checkIntectactiveTutorialStateTable($user_id, $tutorial_page_name){

        $userInteractiveTutorialStateExist = UserInteractiveTutorialState::find()->where(['user_id' => $user_id, 'tutorial_page_name' => $tutorial_page_name])->one();

        if(empty($userInteractiveTutorialStateExist) || $userInteractiveTutorialStateExist->status == InteractiveGuidedTourPage::STATE_INACTIVE){

            $newUserInteractiveTutorialState = new UserInteractiveTutorialState();

            if(empty($userInteractiveTutorialStateExist)){

                $newUserInteractiveTutorialState->user_id = $user_id;
                $newUserInteractiveTutorialState->status = InteractiveGuidedTourPage::STATE_ACTIVE;
                $newUserInteractiveTutorialState->tutorial_page_name = $tutorial_page_name;

                $newUserInteractiveTutorialState->save();
            }else{
                $userInteractiveTutorialStateExist->status = InteractiveGuidedTourPage::STATE_ACTIVE;
                $userInteractiveTutorialStateExist->update();
            }

            return InteractiveGuidedTourPage::LOAD_AND_RUN;
        }else{
            return InteractiveGuidedTourPage::ONLY_LOAD;
        }
    }

    
}
