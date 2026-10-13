<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
include_once('../../../../lcmodel/configEnv.php');
require AWSSDK.'vendor/autoload.php';
use Aws\S3\S3Client;
include_once('../../../../lcmodel/awsUpload.php');
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
  if(!empty($_POST['type'])){
   if($_FILES['thumbnail']['size'] == 0 && $_FILES['up_file']['size'] == 0){
      header('Location: /admin/resources/literatures/registerFrm?error=Thumbnail-and-File-are-both-required');
      exit;
   }else{
    $expected = array('type', 'title', 'slugurl', 'description', 'keywords');
    $required = array('type', 'title', 'slugurl', 'keywords');
    $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
    $date = explode('-', $fulldate);
    $permission = $webhelper->RequestFilter("permission", 0, false);
    foreach($_POST as $key => $value){
      if($key != 'permission' && $key != 'fulldate' && $key != 'categories'){
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
        }elseif($key == 'description'){
           if(is_string($_POST[$key]) && strlen($_POST[$key]) < 1000){
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
      $urlExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE slugurl = ?', 's', $data[2]);
      if($urlExists > 0){
         header('Location: /admin/resources/literatures/list?error=Slug-Url-Exists');
        exit;
      }else{
          $slugUrl = $webhelper->validSlugUrl($data[2]);
          $uploads = array('thumbnail', 'up_file');
          $i=0;
          $newFileName=array();
          foreach($uploads as $file){
            if($file == 'up_file'){
              $newFile = $webhelper->UploadFile($file, "/literatures/");
            }else{
              $newFile = $webhelper->UploadFile($file, "/literatures/", true);
            }
            if($newFile != null){
              $newFileName[$i] = $newFile["filename"];
              if($file == 'up_file') $newOrgFileName = $newFile["orgfilename"];
            }else{
              $newFileName[$i] = 'none';
              if($file == 'up_file') $newOrgFileName = 'none';
            }
            $i++;
          }

          $params = array(&$data[0], &$data[1], &$data[2], &$data[3], &$data[4], &$data[5], &$data[6], &$data[7], &$newFileName[0], &$newFileName[1], &$newOrgFileName, &$permission);
          $insert = $dbhelper->processQuery("INSERT INTO literatures (type, title, slugurl, body, keywords, month, day, year, thumbnail, filename, orgfilename, permission, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW())", "issssssssssi", $params);

          if($insert){
             $docId = $dbhelper->selectOne('SELECT pkid FROM literatures WHERE slugurl = ?', 's', $slugUrl);
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
                  $insertCats = $dbhelper->insertAll("INSERT INTO lit_cat_lookup (doc_id, cat_id) VALUES $categories");
                  header('Location: /admin/resources/literatures/list');
                  exit;
               }
             }
             header('Location: /admin/resources/literatures/list');
             exit;
          }else{
            header('Location: /admin/resources/literatures/list?error=Literature-Upload-Failed');
            exit;
          }
       }//slug url already exists
     }else{
        header('Location: /admin/resources/literatures/list?error=Required-Info-Missing');
        exit;
     }
    }//check if file is uploaded
  }else{
     header('Location: /admin/resources/literatures/registerFrm?error=Type-Missing');
     exit;
  }//check if type is set
 }//check id seesion is not 0
}else{
  header('Location: /admin/');
  exit;
}