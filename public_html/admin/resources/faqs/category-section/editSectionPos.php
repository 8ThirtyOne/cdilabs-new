<?php 
include_once('../../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
$updateSectionPos = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_POST['sectionposid']) && isset($_POST['sectionpageid']) && isset($_POST['newsectionpos'])){
      $pkid = $webhelper->RequestFilter("sectionposid", 0, false);
      $pageId = $webhelper->RequestFilter("sectionpageid", 0, false);
      $newPos = $webhelper->RequestFilter("newsectionpos", 0, false);
      $sectionExists = $dbhelper->numOfRows('SELECT page_id FROM faqs_page_section WHERE pkid = ?', 'i', $pkid);
      if($sectionExists > 0){
         $oldPos = $dbhelper->RunSQLReturnOneRow("SELECT position FROM faqs_page_section WHERE pkid = $pkid AND page_id = $pageId");
         $sections = $dbhelper->selectAll("SELECT * FROM faqs_page_section WHERE page_id = $pageId ORDER BY position ASC");
         $total = count($sections);
         if($newPos > 0 && $newPos <= $total){
           if($oldPos['position'] > 0){
            if($oldPos['position'] > $newPos){
              foreach($sections as $key => $value){
                $num = $key+1;
                if($num >= $newPos && $num < $oldPos['position']){
                  $updateOther = $dbhelper->updateOne("UPDATE faqs_page_section SET position= ? WHERE pkid=? AND page_id=$pageId", 'ii', $num+1, $value['pkid']);
                }
              }
            }
            if($oldPos['position'] < $newPos){
              foreach($sections as $key => $value){
                $num = $key+1;
                if($num > $oldPos['position'] && $num <= $newPos){
                  $updateOther = $dbhelper->updateOne("UPDATE faqs_page_section SET position= ? WHERE pkid=? AND page_id=$pageId", 'ii', $num-1, $value['pkid']);
                }
              }
            }
            if($updateOther){
              $updateSectionPos = $dbhelper->updateOne("UPDATE faqs_page_section SET position= ? WHERE pkid=? AND page_id=$pageId", 'ii', $newPos, $pkid);
              if($updateSectionPos){
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
