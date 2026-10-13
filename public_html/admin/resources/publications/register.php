<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$error = array();
$input='';
$data = array();
$cnt = 0;
$insert = false;
$insertCats = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
   if($_FILES['thumbnail']['size'] == 0){
      header('Location: /admin/resources/publications/list?error=Missing-Thumbnail');
      exit;
   }else{
    $expected = array('title', 'authors', 'publisher', 'institution', 'url', 'description', 'keywords');
    $required = array('title', 'authors', 'publisher', 'institution', 'url', 'description', 'keywords');
    $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
    $date = explode('-', $fulldate);
    $permission = $webhelper->RequestFilter("permission", 0, false);
    $featured = isset($_POST['featured']) ? 1 : 0;
    foreach($_POST as $key => $value){
      if($key != 'permission' && $key != 'fulldate' && $key != 'featured' && $key != 'categories'){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        if($key== 'title' || $key == 'publisher' || $key == 'institution'){
           if(is_string($_POST[$key]) && strlen($_POST[$key]) < 500){
             $input = $_POST[$key];
           }else{
            $error = true;
           }
        }elseif($key == 'authors'){
           if(is_string($_POST[$key]) && strlen($_POST[$key]) < 700){
             $input = $_POST[$key];
           }else{
            $error = true;
           }
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
      $thumbnail = $webhelper->UploadFile("thumbnail", "/publications/", true);
      if($_FILES['featuredthumb']['size'] == 0){
        $featuredThumb["filename"] = 'none';
      }else{
        $featuredThumb = $webhelper->UploadFile("featuredthumb", "/publications/", true);
      }
      if($_FILES['up_file']['size'] == 0){
        $slugUrl = 'none';
        $file["filename"] = 'none';
        $file["orgfilename"] = 'none';
      }else{
        $file = $webhelper->UploadFile("up_file", "/publications/");
        $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–','+','*');
        $title = str_replace($chars,"",$file["orgfilename"]);
        $title = basename($file['orgfilename'], '.pdf');
        $noExt = preg_replace('/\.\w+$/', '', $title);
        $slugUrl = strtolower($noExt);
        $slugUrl = str_replace(" ","-",$slugUrl);
      }
      $urlExists = $dbhelper->numOfRows('SELECT pkid FROM publications WHERE slugurl = ?', 's', $slugUrl);
      if($urlExists > 0 && $slugUrl != 'none'){
         $webhelper->DeleteFile("/publications/", $thumbnail["filename"]);
         $webhelper->DeleteFile("/publications/", $featuredThumb["filename"]);
         $webhelper->DeleteFile("/publications/", $file["filename"]);
         header('Location: /admin/resources/publications/list?error=Slug-Url-Found');
         exit;
      }else{
         $thumb = $thumbnail["filename"];
         $ft = $featuredThumb["filename"];
         $fname = $file["filename"];
         $forg = $file["orgfilename"];

         $params = array(&$data[0], &$data[1], &$data[2], &$data[3], &$data[4], &$data[5], &$data[6], &$data[7], &$data[8], &$data[9], &$data[10], &$data[11], &$thumb, &$ft, &$fname, &$forg, &$slugUrl, &$permission, &$featured);
         $insert = $dbhelper->processQuery("INSERT INTO publications (title, authors, publisher, institution, link, body, keywords, main_product, sub_cat, month, day, year, thumbnail, featuredthumb, filename, orgfilename, slugurl, permission, featured, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())", "sssssssssssssssssii", $params);

          if($insert){
            $docId = $dbhelper->selectOne('SELECT pkid FROM publications WHERE thumbnail = ?', 's', $thumbnail["filename"]);
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
                  $insertCats = $dbhelper->insertAll("INSERT INTO pub_cat_lookup (pub_id, cat_id) VALUES $categories");
                  header('Location: /admin/resources/publications/list');
                  exit;
               }
             }
            header('Location: /admin/resources/publications/list');
            exit;
          }else{
            header('Location: /admin/resources/publications/list?error=Upload-Failed');
            exit;
          }
        }
     }else{
        header('Location: /admin/resources/publications/list?error=Info-Missing');
        exit;
     }
    }//check if file is uploaded
  }//check id seesion is not 0
}else{
  header('Location: /admin/');
  exit;
}