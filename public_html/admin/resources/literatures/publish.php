<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$publish = false;
$dir = "content/literatures";
$addurl = 'newurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
    if(isset($_GET['id'])){
      $pkid = $webhelper->RequestFilter("id", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM literatures WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $publish = $dbhelper->updateAll("UPDATE literatures SET status = 1 WHERE pkid = '$pkid'");
        $doc = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, orgfilename FROM literatures WHERE pkid = $pkid");
        $fileType = $webhelper->GetFileType($doc["orgfilename"]);
        $slugurl = $doc["slugurl"];
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
          $sql = "select pkid, slugurl, orgfilename from literatures where pkid in( $pkid )";
          $List = $dbhelper->RunSQLReturnRows($sql);
          if(!empty($List)){
            foreach ($List as $row){
              $slugurl = $row['slugurl'];
              $fileType = $webhelper->GetFileType($row["orgfilename"]);
              $publish = $dbhelper->updateAll("UPDATE literatures SET status = 1 WHERE pkid = " . $row["pkid"]);
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
  header('Location: /admin/');
  exit;
}