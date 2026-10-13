<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$unpublish = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $idExists = $dbhelper->numOfRows('SELECT id_name FROM web_page_section WHERE pkid = ?', 'i', $pkid);
        if($idExists > 0){
          $unpublish = $dbhelper->updateAll("UPDATE web_page_section SET status = 0 WHERE pkid = $pkid");
          if($unpublish){
            echo "1";
          }else{
            echo "0";
          }
        }else{
          echo "2";
        }
      }
    }//check username
}else{
  echo "Nothing Here";
}

