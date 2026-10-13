<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$cnt = 0;
$input='';
$data = array();
$update = false;
$deleteCats = false;
$insertCats = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   if($input == 0){
     header('Location: /admin/');
     exit;
   }else{
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $video = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid);
     if($video > 0){
        $expected = array('type', 'title', 'subtitle', 'youtubeurl', 'slugurl', 'pagebody', 'description');
        $required = array('type', 'title', 'youtubeurl', 'slugurl', 'pagebody');
        $permission = $webhelper->RequestFilter("permission", 0, false);
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'categories' && $key != 'permission'){
          $temp = is_array($value) ? $value : trim($value);
          if(empty($temp) && in_array($key, $required)){
            array_push($missing, $key);
          }elseif(in_array($key, $expected)){
            ${$key} = $temp;
          }
          if(!empty($value)){
            if($key == 'page' || $key == 'order' || $key == 'type'){
              $input = $webhelper->RequestFilter($key, 0, false);
            }elseif($key == 'searchKey' || $key == 'pagebody' || $key == 'description'){
               if(is_string($_POST[$key]) && strlen($_POST[$key]) < 800){
                 $input = $_POST[$key];
               }else{
                $error = true;
               }
            }else{
               $input = $webhelper->RequestFilter($key, 255, false);
            }
          }else{
            $input='none';
          }
          $data[$cnt] = $input;
          $cnt++;
         }
       }//for loop
       if(empty($missing)){
          $doc = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM videos WHERE pkid = '$pkid'");
          $urlExists = 0;
          if($doc['slugurl'] != $data[8]){
             $urlExists = $dbhelper->numOfRows('SELECT pkid FROM videos WHERE slugurl = ?', 's', $data[8]);
          }
          if($urlExists > 0){
              header('Location: /admin/resources/videos/list?error=Slugurl-Found');
              exit;
          }else{
              $slugUrl = $webhelper->validSlugUrl($data[8]);
              $thumbnail = $webhelper->UploadFile("thumbnail", "/videos/", true);
              $oldthumbnail = $data[3];
              if($thumbnail != null){
                if(!empty($oldthumbnail))
                   $webhelper->DeleteFile("/videos/", $oldthumbnail);
                   $newThumbnailFileName = $thumbnail["filename"];
              }else{
                $newThumbnailFileName = $oldthumbnail;
              }
              $params = array(&$data[4], &$data[5], &$data[6], &$data[7], &$slugUrl, &$data[9], &$data[10], &$data[11], &$newThumbnailFileName, &$permission, &$pkid);
              $update = $dbhelper->processQuery("UPDATE videos SET type = ?, title=?, subtitle=?, youtube_url=?, slugurl=?, page_body=?, body=?, keywords=?, thumbnail=?, permission=?,  updated = NOW() WHERE pkid = ?", "issssssssii", $params);
              if($update){
                if($data[1] == 'none') $data[1] = "";
                if($data[2] == 'none') $data[2] = 0;
                //First delete lit id from lookup table
                $deleteCats = $dbhelper->deleteAll("DELETE FROM video_cat_lookup WHERE video_id = '$pkid'");
                //then check if any are selected
                if(isset($_POST['categories'])){
                  foreach($_POST['categories'] as $cat_id){
                    if(is_numeric($cat_id)){
                      $categories[] = "($pkid,$cat_id)";
                    }
                  }
                  if(!empty($categories)){
                     $categories = implode(',', $categories);
                     $catsEmpty = false;
                  }else{
                     $catsEmpty = true;
                  }
                  $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                  if(!$catsEmpty){
                     $insertCats = $dbhelper->insertAll("INSERT INTO video_cat_lookup (video_id, cat_id) VALUES $categories");
                     header('Location: /admin/resources/videos/list'.$Parameter);
                     exit;
                  }
                }
                header('Location: /admin/resources/videos/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/resources/videos/list?error=Technical-Issue');
                exit;
              }
           }//title or url already exists
       }else{
         header('Location: /admin/resources/videos/list?error=Info-Missing');
         exit;
       }
     }else{
       header('Location: /admin/resources/videos/list');
       exit;
     }//check if video exists
  }
}else{
  header('Location: /admin/');
  exit;
}