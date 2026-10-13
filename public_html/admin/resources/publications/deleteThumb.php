<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_POST['docid']) && isset($_POST['thumbname'])){
      $pkid = $webhelper->RequestFilter("docid", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM publications WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $thumbName = $webhelper->RequestFilter("thumbname", 255, false);
        $publication = $dbhelper->RunSQLReturnOneRow("SELECT featuredthumb, filename FROM publications WHERE pkid = '$pkid'");
        if($thumbName == $publication["featuredthumb"]){
          $webhelper->DeleteFile("/publications/", $publication["featuredthumb"]);
          $update = $dbhelper->updateAll("UPDATE publications SET featuredthumb='none' WHERE pkid='$pkid'");
        }
        if($thumbName == $publication["filename"]){
          $webhelper->DeleteFile("/publications/", $publication["filename"]);
          $update = $dbhelper->updateAll("UPDATE publications SET filename='none', orgfilename='none' WHERE pkid = '$pkid'");
        }
        if($update){
          echo "1";
        }else{
          echo "0";
        }
      }else{
        echo "2";
      }
    }else{
     echo "0";
    }
  }
}else{
  echo "0";
}

