<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$delFromCats = false;
$dir = "content/publications";
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_GET['pkid'])){
      $pkid = $webhelper->RequestFilter("pkid", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM publications WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $publication = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, thumbnail, filename, status FROM publications WHERE pkid = '$pkid'");
        $slugurl = $publication['slugurl'];
        if(!empty($publication['thumbnail'])) $webhelper->DeleteFile("/publications/", $publication["thumbnail"]);
        if(!empty($publication['filename'])) $webhelper->DeleteFile("/publications/", $publication["filename"]);
        $delete = $dbhelper->deleteAll("DELETE FROM publications WHERE pkid = '$pkid'");
        if($delete){
          $cat = $dbhelper->numOfRows("SELECT cat_id FROM pub_cat_lookup WHERE pub_id = ?", 'i', $pkid);
          if($cat > 0){
            $delFromCats = $dbhelper->deleteAll("DELETE FROM pub_cat_lookup WHERE pub_id = '$pkid'");
            if($delFromCats){
              if($publication['status'] == 1 && $slugurl != 'none'){
                include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
            }else{
              echo "3";
            }
          }
          if($publication['status'] == 1 && $slugurl != 'none'){
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
          $sql = "SELECT pkid, slugurl, thumbnail, filename, status FROM publications WHERE pkid IN( $pkid )";
          $List = $dbhelper->RunSQLReturnRows($sql);
          if(!empty($List)){
            foreach ($List as $row){
              $slugurl = $row['slugurl'];
              if($row["thumbnail"] != "")
                $webhelper->DeleteFile("/publications/", $row["thumbnail"]);
              if($row["filename"] != "")
                $webhelper->DeleteFile("/publications/", $row["filename"]);
              $delete = $dbhelper->deleteAll("DELETE FROM publications WHERE pkid = "  . $row["pkid"]);
              $cat = $dbhelper->numOfRows("SELECT cat_id FROM pub_cat_lookup WHERE pub_id = ?", 'i', $row["pkid"]);
              if($cat > 0){
                $delFromCats = $dbhelper->deleteAll("DELETE FROM lit_cat_lookup WHERE pub_id = " . $row["pkid"]);
              }
              if($row['status'] == 1 && $slugurl != 'none'){
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
