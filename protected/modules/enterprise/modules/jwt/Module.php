<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\jwt;

use Yii;

/**
 * Space Types
 *
 * @author Luke
 */
class Module extends \humhub\components\Module
{

    /**
     * JWT Handling on login page
     * 
     * @since 1.1
     * @param \yii\base\ActionEvent $event
     */
    public static function onAuthClientCollectionInit($event)
    {
        if (!Yii::$app->user->isGuest) {
            return;
        }

        if (Yii::$app->authClientCollection->hasClient('jwt')) {
            $jwtAuth = Yii::$app->authClientCollection->getClient('jwt');

            if ($jwtAuth->checkIPAccess()) {
                if ($jwtAuth->autoLogin && $event->action->id == 'login') {
                    $event->isValid = false;
                    return $jwtAuth->redirectToBroker();
                }
            } else {
                // Not allowed, remove authClient 
                Yii::$app->authClientCollection->removeClient('jwt');
            }
        }
    }

}
