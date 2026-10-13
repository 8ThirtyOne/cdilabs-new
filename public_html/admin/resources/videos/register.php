<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$error = array();
$cnt = 0;
$input='';
$data = array();
$insert = false;
$insertCats = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
   if($_FILES['thumbnail']['size'] == 0){
      header('Location: /admin/resources/videos/list?error=Missing-Upload');
      exit;
   }else{
    $expected = array('type', 'title', 'subtitle', 'youtubeurl', 'slugurl', 'pagebody', 'description');
    $required = array('type', 'title', 'youtubeurl', 'slugurl', 'pagebody');
    $permission = $webhelper->RequestFilter("permission", 0, false);
    foreach($_POST as $key => $value){
      if($key != 'categories' && $key != 'permission'){
        $temp = is_array($value) ? $value : trim($value);
        if(empty($temp) && in_array($key, $required)){
          array_push($missing, $key);
        }elseif(in_array($key, $expected)){
          ${$key} = $temp;
        }
        if(!empty($value)){
          if($key == 'type'){
             $input = (int)$key;
             $input = $webhelper->RequestFilter($key,  0, true);
          }elseif($key == 'pagebody' || $key == 'description'){
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
      $slugUrl = $webhelper->validSlugUrl($data[4]);
      $urlExists = $dbhelper->numOfRows('SELECT pkid FROM videos WHERE slugurl = ?', 's', $data[4]);
      if($urlExists > 0){
        header('Location: /admin/resources/videos/list?error=Slugurl-Found');
        exit;
      }else{
        $thumbnail = $webhelper->UploadFile("thumbnail", "/videos/", true);
        $thumb = $thumbnail["filename"];
        $params = array(&$data[0], &$data[1], &$data[2], &$data[3], &$slugUrl, &$data[5], &$data[6], &$data[7], &$thumb, &$permission);
        $insert = $dbhelper->processQuery("INSERT INTO videos (type, title, subtitle, youtube_url, slugurl, page_body, body, keywords, thumbnail, updated, created, status, permission) VALUES (?,?,?,?,?,?,?,?,?,NOW(),NOW(),0,?)", "issssssssi", $params);
        if($insert){
          $docId = $dbhelper->selectOne('SELECT pkid FROM videos WHERE slugurl = ?', 's', $slugurl);
          if(isset($_POST['categories'])){
             foreach($_POST['categories'] as $cat_id){
              if(is_numeric($cat_id)){
                $categories[] = "($docId,$cat_id)";
              }
             }
             if(!empty($categories)){
                $categories = implode(',', $categories);
                $catsEmpty = false;
             }else{
                $catsEmpty = true;
             }
             if(!$catsEmpty){
                $insertCats = $dbhelper->insertAll("INSERT INTO video_cat_lookup (video_id, cat_id) VALUES $categories");
                header('Location: /admin/resources/videos/list');
                exit;
             }
          }
          header('Location: /admin/resources/videos/list');
          exit;
        }else{
          header('Location: /admin/resources/videos/list?error=Technical-Issue');
          exit;
        }
       }//slug url already exists
     }else{
        header('Location: /admin/resources/videos/list?error=Info-Missing');
        exit;
     }
    }//check if file is uploaded
 }//check if logged in
}else{
  header('Location: /admin/');
  exit;
}