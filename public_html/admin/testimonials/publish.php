<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$publish = false;
$dir = "testimonials";
$addurl = 'newurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $exists = $dbhelper->numOfRows('SELECT slugurl FROM testimonials WHERE pkid = ?', 'i', $pkid);
        if($exists > 0){
          $publish = $dbhelper->updateAll("UPDATE testimonials SET status = 1 WHERE pkid = '$pkid'");
          $slugurl = $dbhelper->selectOne('SELECT slugurl FROM testimonials WHERE pkid = ?', 'i', $pkid);
          if($publish){
            //include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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
            $sql = "select pkid, slugurl from testimonials where pkid in( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                  $slugurl = $row['slugurl'];
                  $publish = $dbhelper->updateAll("UPDATE testimonials SET status = 1 WHERE pkid = " . $row["pkid"]);
                  //include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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