<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $update = $dbhelper->updateAll("UPDATE publications SET featuredthumb = 'none'");
   if($update){
   	header('Location: /admin/resources/publications/list');
  exit;
   }
}else{
  header('Location: /admin/');
  exit;
}