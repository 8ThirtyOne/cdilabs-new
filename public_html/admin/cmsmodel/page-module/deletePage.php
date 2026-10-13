<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$deleteHero = false;
$deleteSection = false;
$deleteButton = false;
$deleteColumn = false;
$deletePage = false;
$delete = false;
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_GET['pkid']) && isset($_GET['cmscat'])){
      $pageId = $webhelper->RequestFilter("pkid", 0, false);
      $cmscat = $webhelper->RequestFilter("cmscat", 50, false);
      $dir = $cmscat;
      $slugurl = $dbhelper->selectOne("SELECT slugurl FROM web_page WHERE pkid = ? AND cat ='$cmscat'", 'i', $pageId);
      if($slugurl == ''){
      	echo "2";
      }else{
        $pageHero = $dbhelper->RunSQLReturnOneRow("SELECT desktop, mobile FROM web_page_hero 
                                                     WHERE page_id = $pageId");
        if(!empty($pageHero['desktop'])) $webhelper->DeleteFile("/hero/".$cmscat."/", $pageHero['desktop']);
        if(!empty($pageHero['mobile'])) $webhelper->DeleteFile("/hero/".$cmscat."/", $pageHero['mobile']);
        $deleteHero = $dbhelper->deleteOne('DELETE FROM web_page_hero WHERE page_id = ?', 'i', $pageId);
        if($deleteHero){
	       $pageSections = $dbhelper->selectAll("SELECT pkid, bgimg, bgMobileImg, videoimg FROM web_page_section WHERE page_id = $pageId");
	       foreach($pageSections as $section){
           if(count($pageSections) > 0){
  	       	 $sectionId = $section['pkid'];
  	       	 //delete all section buttons
  	       	 $pageButtons = $dbhelper->selectAll("SELECT * FROM web_page_btn WHERE section_id = $sectionId");
  	       	 if(count($pageButtons) > 0){ 
  		       	 foreach($pageButtons as $button){
  		            $deleteButton = $dbhelper->deleteAll("DELETE FROM web_page_btn WHERE section_id = $sectionId");
  		         }
  		         if(!$deleteButton) echo "5"; //delete button failed
  	         }
             //then delete all section columns
             $pageColumns = $dbhelper->selectAll("SELECT * FROM web_page_column WHERE section_id = $sectionId");
             if(count($pageColumns) > 0){ 
  	           foreach($pageColumns as $column){
  	                $deleteColumn = $dbhelper->deleteAll("DELETE FROM web_page_column WHERE section_id = $sectionId");
  	           }
  	           if(!$deleteColumn) echo "6"; //delete column failed
             }
           	 if($section["bgimg"] != "none")
                $webhelper->DeleteFile("/".$cmscat."/", $section["bgimg"]);
             if($section["bgMobileImg"] != "none")
                $webhelper->DeleteFile("/".$cmscat."/", $section["bgMobileImg"]);
             if($section["videoimg"] != "none")
                $webhelper->DeleteFile("/".$cmscat."/", $section["videoimg"]);
             $deleteSection = $dbhelper->deleteAll("DELETE FROM web_page_section WHERE page_id = $pageId");
             if(!$deleteSection) echo "4"; //delete section failed
            }
	        }//sections loop
	        $deletePage = $dbhelper->deleteOne('DELETE FROM web_page WHERE pkid = ?', 'i', $pageId);
          if($deletePage){
	          include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
	          echo "1";
          }else{
            echo "7";
          }
        }else{
          echo "3"; //delete hero failed
        }
      }
    }else{
     echo "0"; //if isset GET[pkid]
    }
  }//check input
}else{
  echo "0";
}

