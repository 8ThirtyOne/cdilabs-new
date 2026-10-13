<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$deleteHero = false;
$deleteSection = false;
$deletePage = false;
$delete = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_GET['pkid'])){
      $pageId = $webhelper->RequestFilter("pkid", 0, false);
      $dir = 'faqs';
      $slugurl = $dbhelper->selectOne("SELECT slugurl FROM faqs_page WHERE pkid = ? AND cat ='faqs'", 'i', $pageId);
      if($slugurl == ''){
      	echo "2";
      }else{
        $pageHero = $dbhelper->RunSQLReturnOneRow("SELECT desktop, mobile FROM faqs_page_hero WHERE page_id = $pageId");
        if(!empty($pageHero['desktop'])) $webhelper->DeleteFile("/hero/faqs/", $pageHero['desktop']);
        if(!empty($pageHero['mobile'])) $webhelper->DeleteFile("/hero/faqs/", $pageHero['mobile']);
        $deleteHero = $dbhelper->deleteOne('DELETE FROM faqs_page_hero WHERE page_id = ?', 'i', $pageId);
        if($deleteHero){
  	       $pageSections = $dbhelper->selectAll("SELECT pkid FROM faqs_page_section WHERE page_id = $pageId");
  	       foreach($pageSections as $section){
             if(count($pageSections) > 0){
    	       	 $sectionId = $section['pkid'];
               $deleteSection = $dbhelper->deleteAll("DELETE FROM faqs_page_section WHERE page_id = $pageId");
               if(!$deleteSection) echo "4"; //delete section failed
              }
  	        }//sections loop
  	        $deletePage = $dbhelper->deleteOne('DELETE FROM faqs_page WHERE pkid = ?', 'i', $pageId);
            if($deletePage){
  	          echo "1";
            }else{
              echo "4";
            }
        }else{
          echo "3";
        }
      }
    }else{
     echo "0"; //if isset pkid
    }
  }//check input
}else{
  echo "0";
}
