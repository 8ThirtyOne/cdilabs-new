<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
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
       $profile = $dbhelper->numOfRows("SELECT first_name FROM employee_page WHERE pkid = ?", 'i', $pkid);
       if($profile > 0){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       if(isset($page) && isset($order) && isset($searchKey)){
          if($webhelper->isNull($page)) $page = 1;
          if($webhelper->isNull($searchKey)) $searchKey = "";
          if($webhelper->isNull($order)) $order = 0;       
          $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

          $sql = "INSERT INTO employee_page(first_name, last_name, job_pos, job_loc, profile_quote, hero_img, mobile_img, page_body, slugurl, updated, created, status) SELECT first_name, last_name, job_pos, job_loc, profile_quote, hero_img, mobile_img, page_body, slugurl, NOW(), NOW(), status FROM employee_page WHERE pkid = $pkid";
            $inserpkid = $dbhelper->RunSQLReturnID($sql);
            if(!empty($inserpkid) && $inserpkid > 0){
              $sql = "SELECT hero_img, mobile_img FROM employee_page WHERE pkid = $pkid";
              $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
              if(!empty($ViewData["hero_img"]) && $ViewData["hero_img"] != 'none'){
                 $newHeroImg = $webhelper->CopyFile("/team/", $ViewData["hero_img"]);
              }else{
                 $newHeroImg = 'none';
              }
              if(!empty($ViewData["mobile_img"]) && $ViewData["mobile_img"] != 'none'){
                 $newMobileImg = $webhelper->CopyFile("/team/", $ViewData["mobile_img"]);
              }else{
                 $newMobileImg = 'none';
              }
              $update = $dbhelper->updateAll("UPDATE employee_page SET hero_img = '$newHeroImg', mobile_img = '$newMobileImg' WHERE pkid = '$inserpkid'");
              if($update){
                header('Location: /admin/company/team/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/company/team/list?error=technical_issue');
                exit;
              }
           }
         }
       }//check if no literature
     }else{
        header('Location: /admin/company/team/list?error=profile_not_found');
        exit;
     }//check if pkid is set
   }
}else{
  header('Location: /admin/');
  exit;
}