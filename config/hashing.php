<?php

return [

    'driver' => 'argon2id',

    'bcrypt' => [
        'rounds' => 10,
    ],

    'argon' => [
        'memory' => 65536,
        'threads' => 2,
        'time' => 4,
    ],

];
// This file is part of the Laravel framework.
// (c) Laravel LLC <https://laravel.com>