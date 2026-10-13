<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$updateSection = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_POST['secimgid']) && isset($_POST['pgimgid']) && isset($_POST['imgname']) && isset($_POST['delsecimgcat'])){
      $pkid = $webhelper->RequestFilter("secimgid", 0, false);
      $pageId = $webhelper->RequestFilter("pgimgid", 0, false);
      $imgName = $webhelper->RequestFilter("imgname", 10, false);
      $cmscat = $webhelper->RequestFilter("delsecimgcat", 50, false);
      $sectionExists = $dbhelper->numOfRows('SELECT id_name FROM web_page_section WHERE pkid = ?', 'i', $pkid);
      if($sectionExists > 0){
      	 switch($imgName){
           case 'secbgimg':
             $dbName = 'bgimg';
             break;
           case 'secmobimg':
             $dbName = 'bgMobileImg';
             break;
           case 'secvidimg':
             $dbName = 'videoimg';
             break;
      	 }
         $section = $dbhelper->RunSQLReturnOneRow("SELECT bgimg, bgMobileImg, videoimg FROM web_page_section WHERE pkid = $pkid AND page_id = $pageId");
         if($section[$dbName] != "none") $webhelper->DeleteFile("/".$cmscat."/", $section[$dbName]);
         if($dbName == 'videoimg'){
            $updateSection = $dbhelper->updateAll("UPDATE web_page_section SET $dbName='none', videoimgorgname='none' WHERE pkid = $pkid AND page_id = $pageId");
         }else{
	        $updateSection = $dbhelper->updateAll("UPDATE web_page_section SET $dbName='none' WHERE pkid = $pkid AND page_id = $pageId");
         }
         if($updateSection){
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
