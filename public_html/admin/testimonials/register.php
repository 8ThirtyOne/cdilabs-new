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
      if($_FILES['thumbnail']['size'] == 0){
         header('Location: /admin/testimonials/registerFrm?error=Missing-Thumbnail');
         exit;
      }else{
        $expected = array('companyname', 'customer', 'jobtitle', 'quote', 'slugurl');
        $required = array('companyname', 'customer', 'jobtitle', 'quote', 'slugurl');
        foreach($_POST as $key => $value){
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
            }elseif($key == 'quote'){
               $input = $webhelper->RequestFilter($key,  4000, true);
            }else{
               $input = $webhelper->RequestFilter($key, 200, false);
            }
          }else{
            $input='none';
          }
          $data[$cnt] = $input;
          $cnt++;
        }//for loop
        if(empty($missing)){
          $slugUrl = $webhelper->validSlugUrl($data[4]);
          $urlExists = $dbhelper->numOfRows('SELECT pkid FROM testimonials WHERE slugurl = ?', 's', $slugUrl);
          if($urlExists > 0){
            header('Location: /admin/testimonials/list?error=slug-url-found');
            exit;
          }else{
            /* UNCOMMENT THIS WHEN ADDING SINGLE PAGE
            $images = array('thumbnail', 'hero_img', 'mobile_img');
            $i=0;
            $newImageName=array();
            foreach($images as $image){
              $newImage = $webhelper->UploadFile($image, "/testimonials/", true);
              if($newImage != null){
                $newImageName[$i] = $newImage["filename"];
              }else{
                $newImageName[$i] = 'none';
              }
              $i++;
            }*/
            $thumbnail = $webhelper->UploadFile("thumbnail", "/testimonials/", true);
            $thumb=$thumbnail["filename"];
            $params = array(&$data[0], &$data[1], &$data[2], &$data[3], &$thumb, &$slugUrl);
            $insert = $dbhelper->processQuery("INSERT INTO testimonials (company, customer, job_title, quote, thumbnail, slugurl, hero_img, mobile_img, updated, created, status) VALUES(?,?,?,?,?,?,'none','none',NOW(),NOW(),0)", "ssssss", $params);
            if($insert){
              header('Location: /admin/testimonials/list');
              exit;
            }else{
              header('Location: /admin/testimonials/list?error=technical-issue');
              exit;
            }
          }//slug url already exists
        }else{
          header('Location: /admin/testimonials/list?error=info-missing');
          exit;
        }
     }//check if headshot is uploaded
   }
}else{
  header('Location: /admin/');
  exit;
}