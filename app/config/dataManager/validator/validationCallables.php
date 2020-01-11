<?php

return [
    'email' => function($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);          
    },
    'date' => function($value) {
        return filter_var($value, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => '/^[0-9]{4}(\/|-)[0-9]{2}(\/|-)[0-9]{2}$/'
            ]
        ]);
    }
];