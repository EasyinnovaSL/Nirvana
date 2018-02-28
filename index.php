<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/protected/vendor/autoload.php');
require(__DIR__ . '/protected/vendor/yiisoft/yii2/Yii.php');


$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/protected/humhub/config/common.php'),
    require(__DIR__ . '/protected/humhub/config/web.php'),
    (is_readable(__DIR__ . '/protected/config/dynamic.php')) ? require(__DIR__ . '/protected/config/dynamic.php') : [],
    require(__DIR__ . '/protected/config/common.php'),
    require(__DIR__ . '/protected/config/web.php')
);

/* Best place to define global variables http://www.yiiframework.com/doc-2.0/guide-structure-entry-scripts.html*/
defined('INNOVATION_ADVISOR_GROUP_ID') or define('INNOVATION_ADVISOR_GROUP_ID', 3);
defined('INNOVATOR_GROUP_ID') or define('INNOVATOR_GROUP_ID', 4);
defined('LINKEDIN_VALUE') or define('LINKEDIN_VALUE', 'linkedin');
defined('LINKEDIN_CLIENT_ID') or define('LINKEDIN_CLIENT_ID', '78wmsist1ah7b0');
defined('LINKEDIN_SECRET_CLIENT_ID') or define('LINKEDIN_SECRET_CLIENT_ID', 'FG6WUxuMsyNTL7gv');

(new humhub\components\Application($config))->run();
