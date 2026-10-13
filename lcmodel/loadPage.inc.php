<?php
ini_set('session.use_only_cookies', TRUE);
ini_set('session.use_trans_sid', FALSE);
session_start();
ob_start();
ini_set("display_errors", 1);
header("Pragma: no-cache");
header("Cache: no-cache");
define('cdn', '');
date_default_timezone_set('america/los_angeles');
include_once('use_ssl.php');
include_once('load.inc.php');
include_once('webTools/Mobile_Detect.php');
$detect = new Mobile_Detect;
$allowed_domains = ['https://cdn.8romans.com', 'https://www.google.com/recaptcha/api.js'];
if (array_key_exists('HTTP_ORIGIN', $_SERVER)) { 
  $origin = $_SERVER['HTTP_ORIGIN']; 
} 
else if (array_key_exists('HTTP_REFERER', $_SERVER)){
    $origin = $_SERVER['HTTP_REFERER']; 
}else{
    $origin = $_SERVER['REMOTE_ADDR']; 
}
if (in_array($origin, $allowed_domains)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}

$_SESSION['return'] = $_SERVER['REQUEST_URI'];

if(isset($_GET['lng']) && basename($_GET['lng']) == $_GET['lng']){
  $lng = $_GET['lng'] == 'en' ? 'english' : '';
  $_SESSION['lng-pref'] = $lng;
}
