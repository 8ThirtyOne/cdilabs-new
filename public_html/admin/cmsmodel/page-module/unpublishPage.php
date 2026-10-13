<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$unpublish = false;
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
    if(isset($_GET['cmscat']) || isset($_POST['cmscat'])){
      $cmscat = $webhelper->RequestFilter("cmscat", 50, false);
      $dir = $cmscat;
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $slugurl = $dbhelper->selectOne("SELECT slugurl FROM web_page WHERE pkid = ? AND cat = '$cmscat'", 'i', $pkid);
        if($slugurl == ''){
          echo "2";
        }else{
          $unpublish = $dbhelper->updateAll("UPDATE web_page SET status = 0 WHERE pkid = '$pkid' AND cat='$cmscat'");
          if($unpublish){
            include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
            echo "1";
          }else{
            echo "0";
          }
        }
      }elseif(isset($_POST['pkids'])){
         $pkids = $webhelper->RequestFilterMulti("pkids", 0, false);
         if(count($pkids)>0){
            $pkid = implode(",", $pkids);
            $sql = "select pkid, slugurl from web_page where pkid in( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['slugurl'];
                $unpublish = $dbhelper->updateAll("UPDATE web_page SET status = 0 WHERE cat='$cmscat' AND pkid = " . $row["pkid"]);
                include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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
       echo "2";
      }
    }
  }
}else{
  echo "Nothing Here.";
}
