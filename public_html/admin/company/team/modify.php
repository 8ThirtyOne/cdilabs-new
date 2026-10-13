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
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $profile = $dbhelper->numOfRows('SELECT first_name FROM employee_page WHERE pkid = ?', 'i', $pkid);
     if($profile > 0){
        $status = $dbhelper->selectOne('SELECT status FROM employee_page WHERE pkid = ?', 'i', $pkid);
        $expected = array('first', 'last', 'jobtitle', 'joblocation', 'quote', 'pagebody');
        $required = array('first', 'last', 'jobtitle', 'joblocation', 'quote', 'pagebody');
        foreach($_POST as $key => $value){
          if($key != 'pkid'){
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
         }
       }//for loop
       if(empty($missing)){
          $employee = $data[5].' '.$data[6];
          $slugUrl = $webhelper->validSlugUrl($employee);
          $urlExists = 0;
          $record = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM employee_page WHERE pkid = '$pkid'");
          if($record['slugurl'] != $slugUrl){
            $urlExists = $dbhelper->numOfRows('SELECT pkid FROM employee_page WHERE slugurl = ?', 's', $slugUrl);
          }
          if($urlExists > 0){
            header('Location: /admin/company/team/modifyFrm?error=slugurl-exists');
            exit;
          }else{
            $images = array('hero_img', 'mobile_img');
            $i=0;
            $newImageName=array();
            foreach($images as $image){
              $newImage = $webhelper->UploadFile($image, "/team/", true);
              //old images data ids are 3, 4 and 5
              $oldImage = $data[$i+3];
              if($newImage != null){
                if(!empty($oldImage)) $webhelper->DeleteFile("/team/", $oldImage);
                $newImageName[$i] = $newImage["filename"];
              }else{
                $newImageName[$i] = $oldImage;
              }
              $i++;
            }
            $params = array(&$data[5], &$data[6], &$data[7], &$data[8], &$data[9], &$data[10], &$newImageName[0], &$newImageName[1], &$slugUrl, &$pkid);
            $update = $dbhelper->processQuery("UPDATE employee_page SET first_name = ?, last_name=?, job_pos=?, job_loc=?, profile_quote=?, page_body=?, hero_img=?, mobile_img=?, slugurl=?, updated = NOW() WHERE pkid = ?", "sssssssssi", $params);
            if($update){
              if($data[1] == 'none') $data[1] = "";
              if($data[2] == 'none') $data[2] = 0;
              $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
              header('Location: /admin/company/team/list'.$Parameter);
              exit;
            }else{
              header('Location: /admin/company/team/list?error=technical-issue');
              exit;
            }
          }//check duplicate slugurl
       }else{
         header('Location: /admin/company/team/list?error=info-missing');
         exit;
       }
     }else{
       header('Location: /admin/company/team/list');
       exit;
     }//check if profile exists
   }//check user
}else{
  header('Location: /admin/');
  exit;
}