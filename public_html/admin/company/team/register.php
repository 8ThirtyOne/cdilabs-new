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
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if($_FILES['hero_img']['size'] == 0 && $_FILES['mobile_img']['size'] == 0){
         header('Location: /admin/company/team/registerFrm?error=missingupload');
         exit;
      }else{
        $expected = array('first', 'last', 'jobtitle', 'joblocation', 'quote', 'pagebody');
        $required = array('first', 'last', 'jobtitle', 'joblocation', 'quote', 'pagebody');
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
        }//for loop
        if(empty($missing)){
          $employee = $data[0].' '.$data[1];
          $slugUrl = $webhelper->validSlugUrl($employee);
          $urlExists = $dbhelper->numOfRows('SELECT pkid FROM employee_page WHERE slugurl = ?', 's', $slugUrl);
          if($urlExists > 0){
            header('Location: /admin/company/team/list?error=Slug-Url-Found');
            exit;
          }else{
              $images = array('hero_img', 'mobile_img');
              $i=0;
              $newImageName=array();
              foreach($images as $image){
                $newImage = $webhelper->UploadFile($image, "/team/", true);
                if($newImage != null){
                  $newImageName[$i] = $newImage["filename"];
                }else{
                  $newImageName[$i] = 'none';
                }
                $i++;
              }
              $params = array(&$data[0], &$data[1], &$data[2], &$data[3], &$data[4], &$data[5], &$newImageName[0], &$newImageName[1], $slugUrl);
              $insert = $dbhelper->processQuery("INSERT INTO employee_page (first_name, last_name, job_pos, job_loc, profile_quote, page_body, hero_img, mobile_img, slugurl, updated, created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 0)", "sssssssss", $params);
            if($insert){
              header('Location: /admin/company/team/list');
              exit;
            }else{
              header('Location: /admin/company/team/list?error=technical-issue');
              exit;
            }
         }//slug url already exists
         }else{
            header('Location: /admin/company/team/list?error=info-missing');
            exit;
         }
     }//check if headshot is uploaded
   }
}else{
  header('Location: /admin/');
  exit;
}