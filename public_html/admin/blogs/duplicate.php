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
       $blogExists = $dbhelper->numOfRows("SELECT slugurl FROM posts WHERE pkid = ?", 'i', $pkid);
       if($blogExists > 0){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       if(isset($page) && isset($order) && isset($searchKey)){
          if($webhelper->isNull($page)) $page = 1;
          if($webhelper->isNull($searchKey)) $searchKey = "";
          if($webhelper->isNull($order)) $order = 0;       
          $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

          $sql = "INSERT INTO posts(type, title, subtitle, author, job_title, slugurl, month, day, year, body, keywords, avatar, thumbnail, desktop_hero, mobile_hero, updated, created, status) SELECT type, title, subtitle, author, job_title, slugurl, month, day, year, body, keywords, avatar, thumbnail, desktop_hero, mobile_hero, NOW(), NOW(), status FROM posts WHERE pkid = $pkid";
            $inserpkid = $dbhelper->RunSQLReturnID($sql);
            if(!empty($inserpkid) && $inserpkid > 0){
              $sql = "SELECT avatar, thumbnail, desktop_hero, mobile_hero, slugurl FROM posts WHERE pkid = $pkid";
              $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
              $images = array('avatar', 'thumbnail', 'desktop_hero', 'mobile_hero');
              $i=0;
              $newImage=array();
              foreach($images as $image){
                if(!empty($ViewData[$image]) && $ViewData[$image] != 'none'){
                  $newImage[$i] = $webhelper->CopyFile("/blogs/", $ViewData[$image]);
                }else{
                  $newImage[$i] = 'none';
                }
                $i++;
              }
              $total=$dbhelper->safeRows('SELECT * FROM testimonials');
              $newSlugUrl = $ViewData["slugurl"].'-'.$total;
              $update = $dbhelper->updateAll("UPDATE posts SET avatar='$newImage[0]', thumbnail = '$newImage[1]', desktop_hero = '$newImage[2]', mobile_hero = '$newImage[3]', slugurl='$newSlugUrl' WHERE pkid = '$inserpkid'");
              if($update){
                header('Location: /admin/blogs/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/blogs/list?error=technical-issue');
                exit;
              }
           }
         }
       }//check if no literature
     }else{
        header('Location: /admin/blogs/list?error=post-not-found');
        exit;
     }//check if pkid is set
   }
}else{
  header('Location: /admin/');
  exit;
}