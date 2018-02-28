JWT SSO - Authentication
========================


Installation
------------

1.) Install JWT endpoint 

You can find some example scripts at: protected/modules/enterprise/modules/jwt/examples.

2.) Add following configuration to /protected/config/common.php

```php
return [
    // ...
    'components' => [
        // ...
        'authClientCollection' => [
            'clients' => [
                // ...
                'jwt' => [
                    'class' => 'humhub\modules\enterprise\modules\jwt\authclient\JWT',
					'url' => 'Enter your JWT endpoint url here',
                    'sharedKey' => 'Enter your shared key here',
					// Other configuration options
                ],
            ],
        ],
        // ...
    ],
    // ...
];
```

Advanced configuration
----------------------

Example with all possible configuration options:

```php
'jwt' => [
    'class' => 'humhub\modules\enterprise\modules\jwt\authclient\JWT',
	'url' => 'http://ntlm.example.com/jwtclient/index.php',
    'sharedKey' => 'XKqSoxWRcLVDtveMbhQ3oxgvogWT2ef3KpKLOF_gZgwTJyznr6UDi2SCWgSeaEUo5T1_bBYbR_blojv94Sr523zDQ_CzTETN4gMYyx6xU4hsF6HGnCdoFwmd9rOTY5MiIdGX1wdwP3FvpyS0bbmG17xfTtU87gySiQaJjQWq9J2SdLOu73xPej5l1k5BA2ab-taXogZi-STi1q30w0T0kU3SGJ-fYSZO5lGNI3pws313oh83Wby8IJxhS9GZjLjOHpMO7rveoUHE6cGOXm8SjuxsJTfChPl3sGhiA2Wc-cJ-uKaN37T7qQxKeZNjXFtNGTbXwOhXbtELP_ZUy66zPg',
	// Other configuration options
	// Title of JWT Button (if autologin is disabled)
	'title' => 'Company SSO Login',
	// Automatic login, when allowed IP matches
    'autoLogin' => true,
	// Limit allowed JWT IPs
    'allowedIPs' => ['192.168.69.1', '192.168.1.*'],
    // Leeway (seconds) for token validation
	'leeway' => 660,
],
```

Notes
-----

- Shared Key Generator: https://mkjwk.org/


ToDos
-----
- Ensure toke expire
- Update user attributes?
- Disable Logout
 



