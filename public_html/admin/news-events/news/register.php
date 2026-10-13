<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$error = false;
$cnt = 0;
$input='';
$data = array();
$insert = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
       if(!empty($_POST['type'])){
          $expected = array('type', 'source', 'url', 'title', 'slugurl', 'description');
          $required = array('type', 'source', 'url', 'title', 'slugurl', 'description');
          $isSlide = isset($_POST['sticker']) ? 1 : 0;
          $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
          $date = explode('-', $fulldate);
          foreach($_POST as $key => $value){
            if($key != 'fulldate' && $key != 'sticker'){
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
                $titleExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE title = ?', 's', $data[3]);
                if($titleExists){
                   header('Location: /admin/news-events/news?listerror=titlefound');
                   exit;
                }else{
                  $urlExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE slugurl = ?', 's', $data[5]);
                  if($urlExists > 0){
                    header('Location: /admin/news-events/news/list?error=slugurl-found');
                    exit;
                  }else{
                      $slugUrl = $webhelper->validSlugUrl($data[5]);
                        $uploads = array('thumbnail', 'up_file');
                        $i=0;
                        $newFileName=array();
                        foreach($uploads as $file){
                          if($file == 'up_file'){
                            $newFile = $webhelper->UploadFile($file, "/news/");
                          }else{
                            $newFile = $webhelper->UploadFile($file, "/news/", true);
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

                      $params = array(&$data[7], &$data[8], &$data[9], &$data[1], &$data[2], &$data[3], &$data[4], &$data[5], &$data[6], &$newFileName[0], &$newFileName[1], &$newOrgFileName, &$data[0], &$isSlide);
                      $insert = $dbhelper->processQuery("INSERT INTO articles (month, day, year, source, url, title, subtitle, slugurl, body, thumbnail, filename, orgfilename, type, status, updatedate, created, permission, isSlide) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW(), 1, ?)", "ssssssssssssii", $params);
                    if($insert){
                      header('Location: /admin/news-events/news/list');
                      exit;
                    }else{
                      header('Location: /admin/news-evetns/newslist?error=Technical-Issue');
                      exit;
                    }
                  }//slug url already exists
                }//title already exists
              }//input length error
           }else{
              header('Location: /admin/news-events/news/list?error=Info-Missing');
              exit;
           }
        }else{
           header('Location: /admin/news-events/news/list?error=Type-Missing');
           exit;
        }//check if type is set
    }
}else{
  header('Location: /admin/');
  exit;
}