<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\help\widgets;

use Yii;
use yii\helpers\Url;

/**
 * InteractiveTutorialButton Widget for TopMenu
 */
class InteractiveTutorialButton extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest){

            $home = Url::home();

            $urlOfThePage = rawurldecode(Yii::$app->request->url);

            if(!empty($urlOfThePage)){
                if($home == Yii::$app->request->url || strpos($urlOfThePage, 'cards/card/show') !== false || strpos(Yii::$app->request->url, 'dashboard') !== false ){
                    return $this->render('interactiveTutorialButton', array());
                }
            }
        }
    }

}
