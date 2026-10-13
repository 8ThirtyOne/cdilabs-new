<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$dir = "event";
$addurl = 'removeurl';
$publish = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $titleExists = $dbhelper->numOfRows('SELECT title FROM events WHERE pkid = ?', 'i', $pkid);
        if($titleExists > 0){
          $unpublish = $dbhelper->updateAll("UPDATE events SET status = 0 WHERE pkid = '$pkid'");
          $slugurl = $dbhelper->selectOne('SELECT eventurl FROM events WHERE pkid = ?', 'i', $pkid);
          if($unpublish){
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
            $sql = "SELECT pkid, eventurl FROM events WHERE pkid IN( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['eventurl'];
                $unpublish = $dbhelper->updateAll("UPDATE events SET status = 0 WHERE pkid = " . $row["pkid"]);
                include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
              if($unpublish){
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