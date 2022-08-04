<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\basic\template
 * @category   CategoryName
 */

//$googleMapsApiKey = '';

return [
    'adminEmail' => 'webdevelopmentpoc@gmail.com',
    'supportEmail' => 'webdevelopmentpoc@gmail.com',
    'user.passwordResetTokenExpire' => 86400,
    'loginTimeout' => 3600 * 3, //3 Hours

//    'google_places_api_key' => '',
//    'google_recaptcha_site_key' => '',
//    'google-maps' => [
//        'key' => $googleMapsApiKey
//    ],
//    'googleMapsApiKey'=> $googleMapsApiKey,

   'platform' => [
       'backendUrl' => 'http://127.0.0.0',         //TODO REPLACE YOUR URL
       'frontendUrl' => 'http://127.0.0.0',       //TODO REPLACE YOUR URL
   ],

    'logoMail' => '/img/amos-logo.png',
    'logo' => '/img/amos-logo.png',
    'favicon' => 'amos-favicon.jpg',
];
