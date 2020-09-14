<?php
//______________________Save ID when user choose `edit` button_________________________________
//_________________________ ( request comes here from ajax ) _____________________________________

$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
require_once($path . 'wp-load.php');
require_once(dirname(__FILE__) . '/functions.php');

$_SESSION['bsba_item_id'] = $_POST['id'];
