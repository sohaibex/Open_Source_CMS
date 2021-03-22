<?php

use classes\{Cookie, DB, Config, Session};
use models\User;

// Check if session is not started, to start it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
    Later we gonna use an env file to store all config data, and then create ENV class to get config from there,
    but for now let's use global config along with Config class to make the job done !
*/
$GLOBALS["config"] = array(
    'mysql' => array(
        'host'=>'127.0.0.1',
        'username'=>'root',
        'password'=>'',
        'db'=>'educ_cms'
    ),
    'remember'=> array(
        'cookie_name'=>'remember_cookie',
        'cookie_expiry'=>604800
    ),
    'root'=> array(
        'path'=>'http://127.0.0.1/RESEARCH_GATE/',
        'project_name'=>'educ_cms'
    ),
    'session'=>array(
        'session_name'=>'user'
    ),
);