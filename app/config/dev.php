<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',
    'port'     => '3306',
    'dbname'   => 'gsb',
    'user'     => 'gsb_user',
    'password' => 'secret',
);

// enable the debug mode
$app['debug'] = true;


// define log parameters
$app['monolog.level'] = 'INFO';
