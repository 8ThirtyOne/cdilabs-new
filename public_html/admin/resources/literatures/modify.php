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
$deleteCats = false;
$insertCats = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   if($input == 0){
     header('Location: /admin/');
     exit;
   }else{
    if(!empty($_POST['type'])){
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $resource = $dbhelper->numOfRows('SELECT title FROM literatures WHERE pkid = ?', 'i', $pkid);
     if($resource > 0){
       if(($_FILES['thumbnail']['size'] == 0 && $_FILES['up_file']['size'] == 0) && (empty($_POST['oldthumbnail']) && empty($_POST['oldfile']))){
          header('Location: /admin/resources/literatures/list?error=missingupload');
          exit;
       }else{
          $expected = array('type', 'title', 'slugurl', 'description', 'keywords');
          $required = array('type', 'title', 'slugurl', 'keywords');
          $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
          $date = explode('-', $fulldate);
          $permission = $webhelper->RequestFilter("permission", 0, false);
          foreach($_POST as $key => $value){
            if($key != 'pkid' && $key != 'permission' && $key != 'fulldate' && $key != 'categories'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if($key == 'page' && $key == 'order'){
                $input = $webhelper->RequestFilter($key, 0, false);
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
            $doc = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl FROM literatures WHERE pkid = '$pkid'");
            $titleExists = 0;
            $urlExists = 0;
            if($doc['title'] != $data[7]){
              $titleExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE title = ?', 's', $data[7]);
            }
            if($doc['slugurl'] != $data[8]){
               $urlExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE slugurl = ?', 's', $data[8]);
            }
            if($urlExists > 0){
                header('Location: /admin/resources/literatures/list?error=Slug-Url-Found');
                exit;
            }else{
                $slugUrl = $webhelper->validSlugUrl($data[8]);
                $uploads = array('thumbnail', 'up_file');
                $i=0;
                $newFileName=array();
                foreach($uploads as $file){
                  if($file == 'up_file'){
                    $newFile = $webhelper->UploadFile($file, "/literatures/");
                  }else{
                    $newFile = $webhelper->UploadFile($file, "/literatures/", true);
                  }
                  //old files data ids are 3 and 4
                  $oldImage = $data[$i+3];
                  if($newFile != null){
                    if(!empty($oldImage)) $webhelper->DeleteFile("/literatures/", $oldImage);
                    $newFileName[$i] = $newFile["filename"];
                    if($file == 'up_file') $newOrgFileName = $newFile["orgfilename"];
                  }else{
                    $newFileName[$i] = $oldImage;
                    if($file == 'up_file') $newOrgFileName = $data[5];
                  }
                  $i++;
                }

                $params = array(&$data[6], &$data[7], &$slugUrl, &$data[9], &$data[10], &$data[11], &$data[12], &$data[13], &$newFileName[0], &$newFileName[1], &$newOrgFileName, &$permission, &$pkid);
                $update = $dbhelper->processQuery("UPDATE literatures SET type=?, title=?, slugurl=?, body=?, keywords=?, month=?, day=?, year=?, thumbnail=?, filename=?, orgfilename=?, permission=?, updatedate = NOW() WHERE pkid=?", "issssssssssii", $params);

                if($update){
                  if($data[1] == 'none') $data[1] = "";
                  if($data[2] == 'none') $data[2] = 0;
                  //First delete lit id from lookup table
                  $deleteCats = $dbhelper->deleteAll("DELETE FROM lit_cat_lookup WHERE doc_id = '$pkid'");
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
                    $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                    if(!$catsEmpty){
                       $insertCats = $dbhelper->insertAll("INSERT INTO lit_cat_lookup (doc_id, cat_id) VALUES $categories");
                       header('Location: /admin/resources/literatures/list'.$Parameter);
                       exit;
                    }
                  }
                  header('Location: /admin/resources/literatures/list'.$Parameter);
                  exit;
                }else{
                  header('Location: /admin/resources/literatures/list?error=technicalissue');
                  exit;
                }
             }//title or url already exists
         }else{
           header('Location: /admin/resources/literatures/list?error=infomissing');
           exit;
         }
       }//check if file is uploaded
     }else{
       header('Location: /admin/resources/literatures/list');
       exit;
     }//check if resource exists
    }else{
      header('Location: /admin/resources/literatures/list?error=typemissing');
      exit;
    }//check which type
  }
}else{
  header('Location: /admin/');
  exit;
}