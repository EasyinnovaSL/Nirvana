<?php return array (
  'components' => 
  array (
    'db' => 
    array (
      'class' => 'yii\\db\\Connection',
      'dsn' => 'mysql:host=localhost;dbname=nirvana',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
    ),
    'user' => 
    array (
    ),
    'mailer' => 
    array (
      'transport' => 
      array (
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'username' => 'blueroominnovation@gmail.com',
        'password' => 'BlueVision2015',
        'encryption' => 'tls',
        'port' => '587',
        'streamOptions' => [
              'ssl' => [
                  'allow_self_signed' => true,
                  'verify_peer' => false,
                  'verify_peer_name' => false,
              ],
        ],
      ),
      'view' => 
      array (
        'theme' => 
        array (
          'name' => 'enterprise',
          'basePath' => 'C:\\wamp64\\www\\nirvana-web\\protected\\modules\\enterprise\\themes\\enterprise',
          'publishResources' => true,
        ),
      ),
    ),
    'cache' => 
    array (
      'class' => 'yii\\caching\\FileCache',
      'keyPrefix' => 'humhub',
    ),
    'view' => 
    array (
      'theme' => 
      array (
        'name' => 'enterprise',
        'basePath' => 'C:\\wamp64\\www\\nirvana-web\\protected\\modules\\enterprise\\themes\\enterprise',
        'publishResources' => true,
      ),
    ),
    'formatter' => 
    array (
      'defaultTimeZone' => 'Europe/Madrid',
    ),
    'formatterApp' => 
    array (
      'defaultTimeZone' => 'Europe/Madrid',
      'timeZone' => 'Europe/Madrid',
    ),
  ),
  'params' => 
  array (
    'installer' => 
    array (
      'db' => 
      array (
        'installer_hostname' => 'localhost',
        'installer_database' => 'humhub',
      ),
    ),
    'config_created_at' => 1481809658,
    'horImageScrollOnMobile' => '1',
    'databaseInstalled' => true,
    'installed' => true,
  ),
  'name' => 'nirvana',
  'language' => 'en',
  'timeZone' => 'Europe/Madrid',
); ?>