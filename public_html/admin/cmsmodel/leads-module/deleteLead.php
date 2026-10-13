<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
if(isset($_POST['pkid']) && !empty($_POST['pkid']) && isset($_POST['pageid']) && !empty($_POST['pageid']) && isset($_POST['cmscat']) && !empty($_POST['cmscat'])){
   $pkid = $webhelper->RequestFilter('pkid', 0, false);
   $pageId = $webhelper->RequestFilter('pageid', 0, false); 
   $cmscat = $webhelper->RequestFilter("cmscat", 50, false);
   $cat = $cmscat == 'promo' ? 'promotions' : $cmscat;
   $formName = $dbhelper->selectOne('SELECT form_name FROM page_form_lookup WHERE page_id = ?', 'i', $pageId);
   if(isset($formName) && !empty($formName)){
      if($formName == 'grant-form'){
        $dbTable = 'promotion_leads';
      }else{
        $dbTable = 'cdivisitor';
      }
      $emailExists = $dbhelper->numOfRows("SELECT email FROM $dbTable WHERE pkid = ? AND category='$cat'", 'i', $pkid);
	  if($emailExists > 0){
	     $delete = $dbhelper->deleteAll("DELETE FROM $dbTable WHERE pkid='$pkid' AND page_id='$pageId' AND category='$cat'");
	     if($delete){
	        echo "1";
	     }else{
	     	echo "0";
	     }
	   }else{
		  echo "0";
	   }
	}else{
	   echo "0";
	}
}else{
	echo "Nothing Here";
}
