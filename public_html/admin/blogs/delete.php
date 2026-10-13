<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$dir = "blogs";
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $images = array('avatar', 'thumbnail', 'desktop_hero', 'mobile_hero');
      if(isset($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter("pkid", 0, false);
        $exists = $dbhelper->numOfRows('SELECT slugurl FROM posts WHERE pkid = ?', 'i', $pkid);
        if($exists > 0){
          $post = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, avatar, thumbnail, desktop_hero, mobile_hero, status FROM posts WHERE pkid = '$pkid'");
          $slugurl = $post['slugurl'];
          foreach($images as $image){
            if(!empty($post[$image]) && $post[$image] != 'none'){
              $webhelper->DeleteFile("/blogs/", $post[$image]);
            }
          }
          $delete = $dbhelper->deleteAll("DELETE FROM posts WHERE pkid = '$pkid'");
          if($delete){
            if($post['status'] == 1) include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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
            $sql = "SELECT pkid, slugurl, avatar, thumbnail, desktop_hero, mobile_hero, status FROM posts WHERE pkid IN( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['slugurl'];
                foreach($images as $image){
                  if(!empty($row[$image]) && $row[$image] != 'none'){
                    $webhelper->DeleteFile("/blogs/", $row[$image]);
                  }
                }
                $delete = $dbhelper->deleteAll("DELETE FROM posts WHERE pkid = ".$row["pkid"]);
                if($row['status'] == 1) include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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
