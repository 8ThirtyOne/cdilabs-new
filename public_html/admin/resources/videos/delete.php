<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$delFromCats = false;
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_GET['pkid'])){
      $pkid = $webhelper->RequestFilter("pkid", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $videos = $dbhelper->RunSQLReturnOneRow("SELECT type, slugurl, thumbnail, status FROM videos WHERE pkid = '$pkid'");
        $dir = $videos['type'] == 2 ? "resources/webinar" : "resources/videos";
        $slugurl = $videos['slugurl'];
        $webhelper->DeleteFile("/videos/", $videos["thumbnail"]);
        $delete = $dbhelper->deleteAll("DELETE FROM videos WHERE pkid = '$pkid'");
        if($delete){
          $cat = $dbhelper->numOfRows("SELECT cat_id FROM video_cat_lookup WHERE video_id = ?", 'i', $pkid);
          if($cat > 0){
            $delFromCats = $dbhelper->deleteAll("DELETE FROM video_cat_lookup WHERE video_id = '$pkid'");
            if($delFromCats){
              if($videos['status'] == 1){
                include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
              echo "1";
            }else{
              echo "3";
            }
          }
          if($videos['status'] == 1){
            include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
          }
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
          $sql = "SELECT pkid, type, slugurl, thumbnail, status FROM videos WHERE pkid IN( $pkid )";
          $List = $dbhelper->RunSQLReturnRows($sql);
          if(!empty($List)){
            foreach ($List as $row){
              $dir = $row['type'] == 2 ? "resources/webinar" : "resources/videos";
              $slugurl = $row['slugurl'];
              $webhelper->DeleteFile("/videos/", $row["thumbnail"]);
              $delete = $dbhelper->deleteAll("DELETE FROM videos WHERE pkid = "  . $row["pkid"]);
              $cat = $dbhelper->numOfRows("SELECT cat_id FROM video_cat_lookup WHERE video_id = ?", 'i', $row["pkid"]);
              if($cat > 0){
                $delFromCats = $dbhelper->deleteAll("DELETE FROM video_cat_lookup WHERE video_id = " . $row["pkid"]);
              }
              if($row['status'] == 1){
                include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
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
  echo "0";
}
