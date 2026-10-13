<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$dir = "testimonials";
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $images = array('thumbnail', 'hero_img', 'mobile_img');
      if(isset($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter("pkid", 0, false);
        $exists = $dbhelper->numOfRows('SELECT slugurl FROM testimonials WHERE pkid = ?', 'i', $pkid);
        if($exists > 0){
          $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, thumbnail, hero_img, mobile_img FROM testimonials WHERE pkid = '$pkid'");
          $slugurl = $ViewData['slugurl'];
          foreach($images as $image){
            if(!empty($ViewData[$image]) && $ViewData[$image] != 'none'){
              $webhelper->DeleteFile("/testimonials/", $ViewData[$image]);
            }
          }
          $delete = $dbhelper->deleteAll("DELETE FROM testimonials WHERE pkid = '$pkid'");
          if($delete){
            include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
            echo "1";
          }else{
            echo "0";
          }
        }else{
          echo "2";
        }
      }elseif(isset($_POST['pkids'])){
         $pkids = $webhelper->RequestFilterMulti("pkids", 0, false);
         if(count($pkids)>0){
            $pkid = implode(",", $pkids);
            $sql = "SELECT pkid, slugurl, thumbnail, hero_img, mobile_img FROM testimonials WHERE pkid IN( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['slugurl'];
                foreach($images as $image){
                  if(!empty($row[$image]) && $row[$image] != 'none'){
                    $webhelper->DeleteFile("/testimonials/", $row[$image]);
                  }
                }
                $delete = $dbhelper->deleteAll("DELETE FROM testimonials WHERE pkid = "  . $row["pkid"]);
                include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
              if($delete){
                echo "1";
              }else{
                echo "0";
              }
            }
         }else{
           echo "-1";
         }
      }else{
       echo "0";
      }
  }
}else{
  echo "Nothing Here.";
}
