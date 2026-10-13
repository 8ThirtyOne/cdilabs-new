<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$dir = "event";
$addurl = 'newurl';
$publish = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $titleExists = $dbhelper->numOfRows('SELECT title FROM events WHERE pkid = ?', 'i', $pkid);
        if($titleExists > 0){
          $publish = $dbhelper->updateAll("UPDATE events SET status = 1 WHERE pkid = '$pkid'");
          $slugurl = $dbhelper->selectOne('SELECT eventurl FROM events WHERE pkid = ?', 'i', $pkid);
          if($publish){
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
            $sql = "select pkid, eventurl from events where pkid in( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['eventurl'];
                $publish = $dbhelper->updateAll("UPDATE events SET status = 1 WHERE pkid = " . $row["pkid"]);
                include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
              if($publish){
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
  echo "Nothing Here";
}