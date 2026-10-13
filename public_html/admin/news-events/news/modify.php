<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$error = false;
$missing = array();
$cnt = 0;
$input='';
$data = array();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    if(!empty($_POST['type'])){
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $press = $dbhelper->numOfRows('SELECT title FROM articles WHERE pkid = ?', 'i', $pkid);
     if($press > 0){
        $status = $dbhelper->selectOne('SELECT status FROM articles WHERE pkid = ?', 'i', $pkid);
        $expected = array('type', 'source', 'url', 'title', 'slugurl', 'description');
        $required = array('type', 'source', 'url', 'title', 'slugurl', 'description');
        $isSlide = isset($_POST['sticker']) ? 1 : 0;
        $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
        $date = explode('-', $fulldate);
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'fulldate' && $key != 'sticker'){
            $temp = is_array($value) ? $value : trim($value);
          if(empty($temp) && in_array($key, $required)){
            array_push($missing, $key);
          }elseif(in_array($key, $expected)){
            ${$key} = $temp;
          }
          if(!empty($value)){
            if($key == 'page' || $key == 'order' || $key == 'type'){
              $input = (int)$key;
              $input = $webhelper->RequestFilter($key, 0, false);
            }elseif($key == 'title' || $key == 'subtitle'){
               if(is_string($_POST[$key]) && strlen($_POST[$key]) < 1200){
                 $input = $_POST[$key];
               }else{
                 $error = true;
               }
            }elseif($key == 'description'){
               if(is_string($_POST[$key]) && strlen($_POST[$key]) < 30000){
                 $input = $_POST[$key];
               }else{
                 $error = true;
               }
            }elseif($key == 'searchKey'){
               if(is_string($_POST[$key]) && strlen($_POST[$key]) < 1200){
                 $input = $_POST[$key];
               }else{
                 $error = true;
               }
            }else{
               $input = $webhelper->RequestFilter($key, 500, false);
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
           if($error){
              header('Location: /admin/news-events/news/list?error=Input-Too-Long');
              exit;
            }else{
              $doc = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl FROM articles WHERE pkid = '$pkid'");
              $titleExists = 0;
              $urlExists = 0;
              if($doc['title'] != $data[9]){
                $titleExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE title = ?', 's', $data[9]);
              }
              if($doc['slugurl'] != $data[11]){
                 $urlExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE slugurl = ?', 's', $data[11]);
              }
              if($urlExists > 0){
                  header('Location: /admin/news-events/news/list?error=titleurlfound');
                  exit;
              }else{
                  $slugUrl = $webhelper->validSlugUrl($data[11]);
                  //file upload
                  $uploads = array('thumbnail', 'up_file');
                  $i=0;
                  $newFileName=array();
                  foreach($uploads as $file){
                    if($file == 'up_file'){
                      $newFile = $webhelper->UploadFile($file, "/news/");
                    }else{
                      $newFile = $webhelper->UploadFile($file, "/news/", true);
                    }
                    //old files data ids are 3 and 4
                    $oldImage = $data[$i+3];
                    if($newFile != null){
                      if(!empty($oldImage)) $webhelper->DeleteFile("/news/", $oldImage);
                      $newFileName[$i] = $newFile["filename"];
                      if($file == 'up_file') $newOrgFileName = $newFile["orgfilename"];
                    }else{
                      $newFileName[$i] = $oldImage;
                      if($file == 'up_file') $newOrgFileName = $data[5];
                    }
                    $i++;
                  }

                  $params = array(&$data[6], &$data[7], &$data[8], &$data[9], &$data[10], &$slugUrl, &$data[12], &$data[13], &$data[14], &$data[15], &$newFileName[0], &$newFileName[1], &$newOrgFileName, &$pkid);
                  $update = $dbhelper->processQuery("UPDATE articles SET type=?, source=?, url=?, title=?, subtitle=?, slugurl=?, body=?, month=?, day=?, year=?, thumbnail=?, filename=?, orgfilename=?, permission=1, status = '$status', isSlide = '$isSlide', updatedate = NOW() WHERE pkid=?", "issssssssssssi", $params);
                    if($update){
                      if($data[1] == 'none') $data[1] = "";
                      if($data[2] == 'none') $data[2] = 0;
                      $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                      header('Location: /admin/news-events/news/list'.$Parameter);
                      exit;
                    }else{
                      header('Location: /admin/news-events/news/list?error=Technical-Issue');
                      exit;
                    }
               }//title or url already exists
           }//input error check
         }else{
           header('Location: /admin/news-events/news/list?error=Info-Missing');
           exit;
         }
     }else{
       header('Location: /admin/news-events/news/list');
       exit;
     }//check if resource exists
    }else{
      header('Location: /admin/news-events/news/list?error=Type-Missing');
      exit;
    }//check which type
  }//check user
}else{
  header('Location: /admin/');
  exit;
}