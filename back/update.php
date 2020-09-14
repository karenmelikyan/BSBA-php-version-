<?php
//______________________Update pictures on server & database_________________________________

$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
require_once($path . 'wp-load.php');
require_once(dirname(__FILE__) . '/functions.php');

if(photoUpdate()){
    wp_redirect($_SERVER['HTTP_REFERER']);
}


