<?php 
include_once('../../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$deleteHero = false;
$deleteSection = false;
$deleteButton = false;
$deleteColumn = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_POST['secid']) && isset($_POST['pgid'])){
      $pkid = $webhelper->RequestFilter("secid", 0, false);
      $pageId = $webhelper->RequestFilter("pgid", 0, false);
      $sectionExists = $dbhelper->numOfRows('SELECT id_name FROM faqs_page_section WHERE pkid = ?', 'i', $pkid);
      if($sectionExists > 0){
         $deleteSection = $dbhelper->deleteAll("DELETE FROM faqs_page_section WHERE pkid = $pkid AND page_id = $pageId");
         if($deleteSection){
	          echo "1";
          }else{
            echo "3";
          }
      }else{
      	echo "2";
      }
    }else{
     echo "0"; //if isset pkid
    }
  }//check input
}else{
  echo "0";
}