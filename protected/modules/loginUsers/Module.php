<?php

namespace humhub\modules\loginUsers;

use Yii;

class Module extends \humhub\components\Module
{
    public $controllerNamespace = 'humhub\modules\loginUsers\controllers';

    public function getName()
    {
        return Yii::t('LoginUsersModule.base', 'loginUsers');
    }
}
