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
$insertCats = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   if($input == 0){
     header('Location: /admin/');
     exit;
   }else{
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $publication = $dbhelper->numOfRows('SELECT title FROM publications WHERE pkid = ?', 'i', $pkid);
     if($publication > 0){
       if(($_FILES['thumbnail']['size'] == 0 && (empty($_POST['oldthumbnail'])))){
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
            if($key != 'pkid' && $key != 'permission' && $key != 'featured' && $key != 'fulldate' && $key != 'categories'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if($key == 'page' && $key == 'order'){
                $input = $webhelper->RequestFilter($key, 0, false);
              }elseif($key== 'title' || $key == 'publisher' || $key == 'institution'){
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
            //file upload
            $thumbnail = $webhelper->UploadFile("thumbnail", "/publications/", true);
            $oldthumbnail = $data[3];
            if($thumbnail != null){
              if(!empty($oldthumbnail))
                  $webhelper->DeleteFile("/publications/", $oldthumbnail);
                  $newThumbnailFileName = $thumbnail["filename"];
            }else{
              $newThumbnailFileName = $oldthumbnail;
            }
            if($_FILES['featuredthumb']['size'] > 0){
             $featuredThumb = $webhelper->UploadFile("featuredthumb", "/publications/", true);
            }
            $doc = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM publications WHERE pkid = '$pkid'");
            if($_FILES['up_file']['size'] > 0){
              $file = $webhelper->UploadFile("up_file", "/publications/");
              $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–','+','*');
              $title = str_replace($chars,"",$file["orgfilename"]);
              $title = basename($file['orgfilename'], '.pdf');
              $noExt = preg_replace('/\.\w+$/', '', $title);
              $slugUrl = strtolower($noExt);
              $slugUrl = str_replace(" ","-",$slugUrl);
            }else{
              $slugUrl = $doc['slugurl'];
            }
            $urlExists = 0;
            if($doc['slugurl'] != $slugUrl){
              $urlExists = $dbhelper->numOfRows('SELECT pkid FROM publications WHERE slugurl = ?', 's', $slugUrl);
            }
            if($urlExists > 0){
               $webhelper->DeleteFile("/publications/", $featuredThumb["filename"]);
               $webhelper->DeleteFile("/publications/", $file["filename"]);
               header('Location: /admin/resources/publications/list?error=Slug-Url-Found');
               exit;
            }else{
              $oldFeaturedThumb = $data[4];
              if(isset($featuredThumb) && $featuredThumb != null){
                if(!empty($oldFeaturedThumb))
                    $webhelper->DeleteFile("/publications/", $oldFeaturedThumb);
                    $newFeaturedThumb = $featuredThumb["filename"];
              }else{
                $newFeaturedThumb = $oldFeaturedThumb;
              }
              $oldfile = $data[5];
              if(isset($file) && $file != null){
                 if(!empty($oldfile))
                    $webhelper->DeleteFile("/publications/", $oldfile);
                    $newFileName = $file["filename"];
                    $newOrgFileName = $file["orgfilename"];
              }else{
                  $newFileName = $oldfile;
                  $newOrgFileName = $data[6]; //old orgfile name
              }
              
              $params = array(&$data[7], &$data[8], &$data[9], &$data[10], &$data[11], &$data[12], &$data[13], &$data[14], &$data[15], &$data[16], &$data[17], &$data[18], &$newThumbnailFileName, &$newFeaturedThumb, &$newFileName, &$newOrgFileName, &$slugUrl, &$permission, &$featured, &$pkid);
                $update = $dbhelper->processQuery("UPDATE publications SET title=?, authors=?, publisher=?, institution=?, link=?, body=?, keywords=?, main_product=?, sub_cat=?, month=?, day=?, year=?, thumbnail=?, featuredthumb=?, filename=?, orgfilename=?, slugurl=?, permission=?, featured=?, updatedate=NOW() WHERE pkid=?", "sssssssssssssssssiii", $params);

              if($update){
                if($data[1] == 'none') $data[1] = "";
                if($data[2] == 'none') $data[2] = 0;
                $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                //First delete lit id from lookup table
                $deleteCats = $dbhelper->deleteAll("DELETE FROM pub_cat_lookup WHERE pub_id = '$pkid'");
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
                  if(!$catsEmpty){
                     $insertCats = $dbhelper->insertAll("INSERT INTO pub_cat_lookup (pub_id, cat_id) VALUES $categories");
                     header('Location: /admin/resources/publications/list'.$Parameter);
                     exit;
                  }
                }
                header('Location: /admin/resources/publications/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/resources/publications/list?error=Technical-Issue');
                exit;
              }
            }//check if slugurl exists
         }else{
           header('Location: /admin/resources/publications/list?error=Info-Missing');
           exit;
         }
       }//check if file is uploaded
     }else{
       header('Location: /admin/resources/publications/list');
       exit;
     }//check if publication exists
  }
}else{
  header('Location: /admin/');
  exit;
}