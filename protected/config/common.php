<?php

return [


    'params' => [
        'allowedLanguages' => ['en']
    ],
    // ...
 /*   'components' => [
        // ...
        'authClientCollection' => [
            'clients' => [
                // ...
                'facebook' => [
                    'class' => 'humhub\modules\user\authclient\Facebook',
                    'clientId' => '1235624886452239',
                    'clientSecret' => '8aebdda09eb5726cfe82233969947a29',
                ],
            ],
        ],
        // ...
    ],*/
    'components' => [
        'authClientCollection' => [
            'clients' => [
                'linkedin' => [
                    'class' => 'humhub\modules\loginUsers\authclient\Linkedin',
                    'clientId' => '78wmsist1ah7b0',
                    'clientSecret' => 'FG6WUxuMsyNTL7gv',
                ],
            ],
        ]
    ]


];