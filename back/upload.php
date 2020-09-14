<?php
//______________________Upload pictures to server_________________________________

$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
require_once($path . 'wp-load.php');
require_once(dirname(__FILE__) . '/functions.php');

if(photoUpload()){
    wp_redirect($_SERVER['HTTP_REFERER']);
}




