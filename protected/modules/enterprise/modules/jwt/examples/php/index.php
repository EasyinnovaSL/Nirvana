<?php

// Load JWT Libary
require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;

// Configuration
$key = 'your shared key';
$domain = "http://humhub.example.com";
$urlRewritingEnabled = false;

// Build token including your user data
$now = time();
$token = array(
    'iss' => 'example',
    'jti' => md5($now . rand()),
    'iat' => $now,
    'exp' => $now + 60,
    'username' => 'j.doe',
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john.doe@example.com',
);

// Create JWT token
$jwt = JWT::encode($token, $key);

// Redirect user back to humhub
if ($urlRewritingEnabled) {
    $location = $domain . '/user/auth/external?authclient=jwt';
} else {
    $location = $domain . '/index.php?r=/user/auth/external&authclient=jwt';
}
$location .= "&jwt=" . $jwt;

header("Location: " . $location);
?>