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
     $exists = $dbhelper->numOfRows('SELECT slugurl FROM testimonials WHERE pkid = ?', 'i', $pkid);
     if($exists > 0){
        $status = $dbhelper->selectOne('SELECT status FROM testimonials WHERE pkid = ?', 'i', $pkid);
        $expected = array('companyname', 'customer', 'jobtitle', 'quote', 'slugurl');
        $required = array('companyname', 'customer', 'jobtitle', 'quote', 'slugurl');
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
               $input = $webhelper->RequestFilter($key,  4000, true);
            }else{
               $input = $webhelper->RequestFilter($key, 200, false);
            }
          }else{
            $input='none';
          }
          $data[$cnt] = $input;
          $cnt++;
         }
       }//for loop
       if(empty($missing)){
          $slugUrl = $webhelper->validSlugUrl($data[10]);
          $urlExists = 0;
          $record = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM testimonials WHERE pkid = '$pkid'");
          if($record['slugurl'] != $slugUrl){
            $urlExists = $dbhelper->numOfRows('SELECT pkid FROM testimonials WHERE slugurl = ?', 's', $slugUrl);
          }
          if($urlExists > 0){
            header('Location: /admin/testimonials/modifyFrm?error=slugurl-exists');
            exit;
          }else{
            //file upload
            $images = array('thumbnail', 'hero_img', 'mobile_img');
            $i=0;
            $newImageName=array();
            foreach($images as $image){
              $newImage = $webhelper->UploadFile($image, "/testimonials/", true);
              //old images data ids are 3, 4 and 5
              $oldImage = $data[$i+3];
              if($newImage != null){
                if(!empty($oldImage)) $webhelper->DeleteFile("/testimonials/", $oldImage);
                $newImageName[$i] = $newImage["filename"];
              }else{
                $newImageName[$i] = $oldImage;
              }
              $i++;
            }
            $params = array(&$data[6], &$data[7], &$data[8], &$data[9], &$slugUrl, &$newImageName[0], &$newImageName[1], &$newImageName[2], &$pkid);
            $update = $dbhelper->processQuery("UPDATE testimonials SET company=?, customer=?, job_title=?, quote=?, slugurl=?, thumbnail=?, hero_img=?, mobile_img=?, updated = NOW() WHERE pkid = ?", "ssssssssi", $params);
            if($update){
              if($data[1] == 'none') $data[1] = "";
              if($data[2] == 'none') $data[2] = 0;
              $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
              header('Location: /admin/testimonials/list'.$Parameter);
              exit;
            }else{
              header('Location: /admin/testimonials/list?error=technical-issue');
              exit;
            }
          }//check duplicate slugurl
       }else{
         header('Location: /admin/testimonials/list?error=info-missing');
         exit;
       }
     }else{
       header('Location: /admin/testimonials/list');
       exit;
     }//check if profile exists
   }//check user
}else{
  header('Location: /admin/');
  exit;
}