<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
     if(!empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter("pkid", 0, false);
       $exists = $dbhelper->numOfRows("SELECT slugurl FROM testimonials WHERE pkid = ?", 'i', $pkid);
       if($exists > 0){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       if(isset($page) && isset($order) && isset($searchKey)){
          if($webhelper->isNull($page)) $page = 1;
          if($webhelper->isNull($searchKey)) $searchKey = "";
          if($webhelper->isNull($order)) $order = 0;       
          $Parameter = "?page=$page&searchKey=$searchKey&order=$order";
          $sql = "INSERT INTO testimonials(company, customer, job_title, quote, thumbnail, hero_img, mobile_img, page_body, slugurl, updated, created, status) SELECT company, customer, job_title, quote, thumbnail, hero_img, mobile_img, page_body, slugurl, NOW(), NOW(), status FROM testimonials WHERE pkid = $pkid";
            $inserpkid = $dbhelper->RunSQLReturnID($sql);
            if(!empty($inserpkid) && $inserpkid > 0){
              $sql = "SELECT thumbnail, hero_img, mobile_img, slugurl FROM testimonials WHERE pkid = $pkid";
              $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
              $images = array('thumbnail', 'hero_img', 'mobile_img');
              $i=0;
              $newImage=array();
              foreach($images as $image){
                if(!empty($ViewData[$image]) && $ViewData[$image] != 'none'){
                  $newImage[$i] = $webhelper->CopyFile("/testimonials/", $ViewData[$image]);
                }else{
                  $newImage[$i] = 'none';
                }
                $i++;
              }
              $total=$dbhelper->safeRows('SELECT * FROM testimonials');
              $newSlugUrl = $ViewData["slugurl"].'-'.$total;
              $update = $dbhelper->updateAll("UPDATE testimonials SET thumbnail = '$newImage[0]', hero_img = '$newImage[1]', mobile_img = '$newImage[2]', slugurl='$newSlugUrl' WHERE pkid = '$inserpkid'");;
              if($update){
                header('Location: /admin/testimonials/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/testimonials/list?error=technical-issue');
                exit;
              }
           }
         }
       }//check if no literature
     }else{
        header('Location: /admin/testimonials/list?error=testimonial-not-found');
        exit;
     }//check if pkid is set
   }
}else{
  header('Location: /admin/');
  exit;
}