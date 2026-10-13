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
      if($_FILES['thumbnail']['size'] == 0 && $_FILES['heroimg']['size'] == 0){
        header('Location: /admin/news-events/events/list?error=Missing-Thumbnail');
        exit;
      }else{
       if(!empty($_POST['type'])){
          $expected = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
          $required = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
          $isSlide = isset($_POST['sticker']) ? 1 : 0;
          $startdate = $webhelper->RequestFilter("startdate", 10, false);
          $enddate = $webhelper->RequestFilter("enddate", 10, false);
          $start = explode('-', $startdate);
          $end = explode('-', $enddate);
          foreach($_POST as $key => $value){
            if($key != 'startdate' && $key != 'enddate' && $key != 'sticker'){
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
              }elseif($key== 'title' || $key == 'subtitle' || $key == 'address' || $key == 'locationone'){
                 if(is_string($_POST[$key]) && strlen($_POST[$key]) < 300){
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
                 $input = $webhelper->RequestFilter($key, 255, false);
              }
            }else{
              $input='none';
            }
            $data[$cnt] = $input;
            $cnt++;
           }
         }//end loop
         //add strat date and end date at the end of data array
         array_push($data, $start[0], $start[1], $start[2], $end[0], $end[1]);
         if(empty($missing)){
            $titleExists = $dbhelper->numOfRows('SELECT pkid FROM events WHERE title = ?', 's', $data[1]);
            if($titleExists){
               header('Location: /admin/news-events/events?listerror=Title-Found');
               exit;
            }else{
              $urlExists = $dbhelper->numOfRows('SELECT pkid FROM events WHERE eventurl = ?', 's', $data[7]);
              if($urlExists > 0){
                header('Location: /admin/news-events/events/list?error=Slugurl-Found');
                exit;
              }else{
                $slugUrl = $webhelper->validSlugUrl($data[7]);
                $uploads = array('thumbnail', 'heroimg', 'heromobile', 'up_file');
                $i=0;
                $newFileName=array();
                foreach($uploads as $file){
                  if($file == 'up_file'){
                    $newFile = $webhelper->UploadFile($file, "/events/");
                  }else{
                    $newFile = $webhelper->UploadFile($file, "/events/", true);
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
                $params = array(&$data[0], &$data[9], &$data[10], &$data[11], &$data[12], &$data[13], &$data[1], &$data[2], &$data[3], &$data[4], &$data[5], &$data[6], &$slugUrl, &$data[8], &$newFileName[0], &$newFileName[1], &$newFileName[2], &$newFileName[3], &$newOrgFileName, $isSlide);
                $insert = $dbhelper->processQuery("INSERT INTO events (type, startmonth, startday, year, endmonth, endday, title, subtitle, address, location1, url, booth, eventurl, body, thumbnail, heroimg, heromobile, filename, orgfilename, status, isSlide, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, '0', ?, NOW(), NOW())", "issssssssssssssssssi", $params);
                if($insert){
                  header('Location: /admin/news-events/events/list');
                  exit;
                }else{
                  header('Location: /admin/news-events/events?error=Technical-Issue');
                  exit;
                }
             }//slug url already exists
            }//title already exists
           }else{
              header('Location: /admin/news-events/events/list?error=Info-Missing');
              exit;
           }
        }else{
           header('Location: /admin/news-events/events/list?error=Type-Missing');
           exit;
        }//check if type is set
      }
    }
}else{
  header('Location: /admin/');
  exit;
}