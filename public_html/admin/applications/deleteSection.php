<?php 
include_once('../../../lcmodel/loadPage.inc.php');
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
      $sectionExists = $dbhelper->numOfRows('SELECT id_name FROM web_page_section WHERE pkid = ?', 'i', $pkid);
      if($sectionExists > 0){
       	//delete all section buttons
       	$pageButtons = $dbhelper->selectAll("SELECT * FROM web_page_btn WHERE section_id = $pkid");
       	 if(count($pageButtons) > 0){ 
	       	 foreach($pageButtons as $button){
	            $deleteButton = $dbhelper->deleteAll("DELETE FROM web_page_btn WHERE section_id = $pkid");
	         }
	         if(!$deleteButton) echo "3"; //delete button failed
         }
         //then delete all section columns
         $pageColumns = $dbhelper->selectAll("SELECT * FROM web_page_column WHERE section_id = $pkid");
         if(count($pageColumns) > 0){ 
         foreach($pageColumns as $column){
            $deleteColumn = $dbhelper->deleteAll("DELETE FROM web_page_column WHERE section_id = $pkid");
         }
         if(!$deleteColumn) echo "4"; //delete column failed
         }
         $section = $dbhelper->RunSQLReturnOneRow("SELECT bgimg, bgMobileImg, videoimg FROM web_page_section WHERE pkid = $pkid AND page_id = $pageId");
         if($section["bgimg"] != "none")
              $webhelper->DeleteFile("/applications/", $section["bgimg"]);
         if($section["bgMobileImg"] != "none")
              $webhelper->DeleteFile("/applications/", $section["bgMobileImg"]);
         if($section["videoimg"] != "none")
              $webhelper->DeleteFile("/applications/", $section["videoimg"]);
         $deleteSection = $dbhelper->deleteAll("DELETE FROM web_page_section WHERE pkid = $pkid AND page_id = $pageId");
         if($deleteSection){
	          echo "1";
          }else{
            echo "5";
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


