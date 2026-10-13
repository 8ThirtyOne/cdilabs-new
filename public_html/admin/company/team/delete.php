<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$dir = "company/team";
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter("pkid", 0, false);
        $profile = $dbhelper->numOfRows('SELECT first_name FROM employee_page WHERE pkid = ?', 'i', $pkid);
        if($profile > 0){
          $record = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, hero_img, mobile_img FROM employee_page WHERE pkid = '$pkid'");
          $slugurl = $record['slugurl'];
          if(!empty($record['hero_img'])) $webhelper->DeleteFile("/team/", $record["hero_img"]);
          if(!empty($record['mobile_img'])) $webhelper->DeleteFile("/team/", $record["mobile_img"]);
          $delete = $dbhelper->deleteAll("DELETE FROM employee_page WHERE pkid = '$pkid'");
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
            $sql = "SELECT pkid, slugurl, hero_img, mobile_img FROM employee_page WHERE pkid IN( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['slugurl'];
                if($row["hero_img"] != "none") $webhelper->DeleteFile("/team/", $row["hero_img"]);
                if($row["mobile_img"] != "none") $webhelper->DeleteFile("/team/", $row["mobile_img"]);
                  $delete = $dbhelper->deleteAll("DELETE FROM employee_page WHERE pkid = "  . $row["pkid"]);
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
