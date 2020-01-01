<?php

return [
    '/usuarios' => [
        'GET' => 'Teste@foo'
    ],
    '/' => [
        'GET' => function(){
            echo "oi";
        }

    ]
]