<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Authenticating
   |--------------------------------------------------------------------------
   */

    'auth' => [

        'method' => 'email',

    ],

    /*
   |--------------------------------------------------------------------------
   | folder views and compile views
   |--------------------------------------------------------------------------
   */

    'views' => [

        'folder'   => '../resources/views',

        'compiler' => '../storage/views',

    ],

    /*
    |--------------------------------------------------------------------------
    | validations and translations
    |--------------------------------------------------------------------------
    */

    'validation' => [

        'folder'      => '../resources/lang',

        'translation' => 'es',

    ],

    /*
    |--------------------------------------------------------------------------
    | Sessions
    |--------------------------------------------------------------------------
    */

    'session' => [

        'tpm' => '../storage/tpm/session',

    ],

];