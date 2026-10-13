<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
$updateSlidePos = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_POST['slideid']) && isset($_POST['slidepageid']) && isset($_POST['newslidepos'])){
      $pkid = $webhelper->RequestFilter("slideid", 0, false);
      $pageId = $webhelper->RequestFilter("slidepageid", 0, false);
      $newPos = $webhelper->RequestFilter("newslidepos", 0, false);
      $slideExists = $dbhelper->numOfRows('SELECT desktop FROM web_page_hero WHERE pkid = ?', 'i', $pkid);
      if($slideExists > 0){
         $oldPos = $dbhelper->RunSQLReturnOneRow("SELECT hero_pos FROM web_page_hero WHERE pkid = $pkid AND page_id = $pageId");
         $slides = $dbhelper->selectAll("SELECT * FROM web_page_hero WHERE page_id = $pageId ORDER BY hero_pos ASC");
         $total = count($slides);
         if($newPos > 0 && $newPos <= $total){
           if($oldPos['hero_pos'] > 0){
            if($oldPos['hero_pos'] > $newPos){
              foreach($slides as $key => $value){
                $num = $key+1;
                if($num >= $newPos && $num < $oldPos['hero_pos']){
                  $updateOther = $dbhelper->updateOne("UPDATE web_page_hero SET hero_pos= ? WHERE pkid=? AND page_id=$pageId", 'ii', $num+1, $value['pkid']);
                }
              }
            }
            if($oldPos['hero_pos'] < $newPos){
              foreach($slides as $key => $value){
                $num = $key+1;
                if($num > $oldPos['hero_pos'] && $num <= $newPos){
                  $updateOther = $dbhelper->updateOne("UPDATE web_page_hero SET hero_pos= ? WHERE pkid=? AND page_id=$pageId", 'ii', $num-1, $value['pkid']);
                }
              }
            }
            if($updateOther){
              $updateSlidePos = $dbhelper->updateOne("UPDATE web_page_hero SET hero_pos= ? WHERE pkid=? AND page_id=$pageId", 'ii', $newPos, $pkid);
              if($updateSlidePos){
                 echo "1";
              }else{
                echo "5";
              } 
            }else{
              echo "4";
            }
          }else{
            echo "3";
          }
        }else{
          echo "6"; //check if new pos is zero or bigger than total
        }
      }else{
        echo "2";
      }
    }else{
     echo "0"; //if isset pkid
    }
  }//check input
}else{
  echo "0";
}