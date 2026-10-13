<?php 
include_once('../../../lcmodel/loadPage.inc.php');
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
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if($_FILES['thumbnail']['size'] == 0 && $_FILES['hero_img']['size'] == 0 && $_FILES['mobile_img']['size'] == 0){
         header('Location: /admin/blogs/registerFrm?error=Missing-Image-Upload');
         exit;
      }else{
        $expected = array('type', 'title', 'subtitle', 'author', 'jobtitle', 'slugurl', 'keywords', 'pagebody');
        $required = array('type', 'title', 'author', 'jobtitle', 'slugurl', 'keywords', 'pagebody');
        $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
        $date = explode('-', $fulldate);
        foreach($_POST as $key => $value){
          if($key != 'fulldate'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if($key == 'page' || $key == 'order'){
               $input = (int)$key;
               $input = $webhelper->RequestFilter($key, 0, false);
              }elseif($key == 'title' || $key == 'subtitle'){
                 if(is_string($_POST[$key]) && strlen($_POST[$key]) < 500){
                   $input = $_POST[$key];
                 }else{
                  $error = true;
                 }
              }elseif($key == 'pagebody'){
                 if(is_string($_POST[$key]) && strlen($_POST[$key]) < 30000){
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
        array_push($data, $date[0], $date[1], $date[2]);
        if(empty($missing)){
           $slugUrl = $webhelper->validSlugUrl($data[5]);
           $urlExists = $dbhelper->numOfRows('SELECT pkid FROM posts WHERE slugurl = ?', 's', $slugUrl);
            if($urlExists > 0){
              header('Location: /admin/blogs/list?error=Slug-Url-Found');
              exit;
            }else{
                $images = array('avatar', 'thumbnail', 'hero_img', 'mobile_img');
                $i=0;
                $newImageName=array();
                foreach($images as $image){
                  $newImage = $webhelper->UploadFile($image, "/blogs/", true);
                  if($newImage != null){
                    $newImageName[$i] = $newImage["filename"];
                  }else{
                    $newImageName[$i] = 'none';
                  }
                  $i++;
                }
                $params = array(&$data[0], &$data[1], &$data[2], &$data[3], &$data[4], &$slugUrl, &$data[6], &$data[7], &$data[8], &$data[9], &$data[10], &$newImageName[0], &$newImageName[1], &$newImageName[2], &$newImageName[3]);
                $insert = $dbhelper->processQuery("INSERT INTO posts (type, title, subtitle, author, job_title, slugurl, keywords, body, month, day, year, avatar, thumbnail, desktop_hero, mobile_hero, updated, created, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),0)", "sssssssssssssss", $params);
              if($insert){
                header('Location: /admin/blogs/list');
                exit;
              }else{
                header('Location: /admin/blogs/list?error=Technical-Issue');
                exit;
              }
           }//slug url already exists
         }else{
            header('Location: /admin/blogs/list?error=Info-Missing');
            exit;
         }
     }//check if hero images are uploaded
   }
}else{
  header('Location: /admin/');
  exit;
}