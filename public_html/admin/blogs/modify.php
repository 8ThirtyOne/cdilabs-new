<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$cnt = 0;
$input='';
$data = array();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $blogExists = $dbhelper->numOfRows('SELECT slugurl FROM posts WHERE pkid = ?', 'i', $pkid);
     if($blogExists > 0){
        $status = $dbhelper->selectOne('SELECT status FROM posts WHERE pkid = ?', 'i', $pkid);
        $expected = array('type', 'title', 'subtitle', 'author', 'jobtitle', 'slugurl', 'keywords', 'pagebody');
        $required = array('type', 'title', 'author', 'jobtitle', 'slugurl', 'keywords', 'pagebody');
        $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
        $date = explode('-', $fulldate);
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'fulldate'){
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
          $slugUrl = $webhelper->validSlugUrl($data[12]);
          $urlExists = 0;
          $record = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM posts WHERE pkid = '$pkid'");
          if($record['slugurl'] != $slugUrl){
            $urlExists = $dbhelper->numOfRows('SELECT pkid FROM posts WHERE slugurl = ?', 's', $slugUrl);
          }
          if($urlExists > 0){
            header('Location: /admin/blogs/modifyFrm?error=Slug-Url-Exists');
            exit;
          }else{
            //file upload
            $images = array('avatar', 'thumbnail', 'hero_img', 'mobile_img');
            $i=0;
            $newImageName=array();
            foreach($images as $image){
              $newImage = $webhelper->UploadFile($image, "/blogs/", true);
              //old images data ids are 3, 4 and 5
              $oldImage = $data[$i+3];
              if($newImage != null){
                if(!empty($oldImage)) $webhelper->DeleteFile("/blogs/", $oldImage);
                $newImageName[$i] = $newImage["filename"];
              }else{
                $newImageName[$i] = $oldImage;
              }
              $i++;
            }
            $params = array(&$data[7], &$data[8], &$data[9], &$data[10], &$data[11], &$data[13], &$data[14], &$data[15], &$data[16], &$data[17], &$newImageName[0], &$newImageName[1], &$newImageName[2], &$newImageName[3], &$slugUrl, &$pkid);
            $update = $dbhelper->processQuery("UPDATE posts SET type = ?, title=?, subtitle=?, author=?, job_title=?, keywords=?, body=?, month=?, day=?, year=?, avatar=?, thumbnail=?, desktop_hero=?, mobile_hero=?, slugurl=?, updated = NOW() WHERE pkid = ?", "sssssssssssssssi", $params);
            if($update){
              if($data[1] == 'none') $data[1] = "";
              if($data[2] == 'none') $data[2] = 0;
              $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
              header('Location: /admin/blogs/list'.$Parameter);
              exit;
            }else{
              header('Location: /admin/blogs/list?error=technicalissue');
              exit;
            }
          }//check duplicate slugurl
       }else{
         header('Location: /admin/blogs/list?error=infomissing');
         exit;
       }
     }else{
       header('Location: /admin/blogs/list');
       exit;
     }//check if profile exists
   }//check user
}else{
  header('Location: /admin/');
  exit;
}