<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$deleteHero = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_POST['heroid']) && isset($_POST['page-id']) && isset($_POST['delherocat'])){
      $pkid = $webhelper->RequestFilter("heroid", 0, false);
      $pageId = $webhelper->RequestFilter("page-id", 0, false);
      $cmscat = $webhelper->RequestFilter("delherocat", 50, false);
      $cmsCatExists = $dbhelper->numOfRows('SELECT pkid FROM web_page WHERE cat=?', 's', $cmscat);
      if($cmsCatExists > 0){
        $heroExists = $dbhelper->numOfRows('SELECT desktop FROM web_page_hero WHERE pkid = ?', 'i', $pkid);
        if($heroExists > 0){
           $hero = $dbhelper->RunSQLReturnOneRow("SELECT desktop, mobile FROM web_page_hero WHERE pkid = $pkid AND page_id = $pageId");
           if($hero["desktop"] != "none") $webhelper->DeleteFile("/hero/".$cmscat."/", $hero["desktop"]);
           if($hero["mobile"] != "none") $webhelper->DeleteFile("/hero/".$cmscat."/", $hero["mobile"]);
           $deleteHero = $dbhelper->deleteAll("DELETE FROM web_page_hero WHERE pkid = $pkid AND page_id = $pageId");
           if($deleteHero){
              echo "1";
            }else{
              echo "3";
            }
        }else{
          echo "2";
        }
      }else{
        echo "0";
      }
    }else{
     echo "0"; //if isset pkid
    }
  }//check input
}else{
  echo "0";
}