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
    if(!empty($_POST['type'])){
      $pkid = $webhelper->RequestFilter("pkid", 0, false);
      $event = $dbhelper->numOfRows('SELECT title FROM events WHERE pkid = ?', 'i', $pkid);
      if($event > 0){
        $status = $dbhelper->selectOne('SELECT status FROM events WHERE pkid = ?', 'i', $pkid);
        $expected = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
          $required = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
        $isSlide = isset($_POST['sticker']) ? 1 : 0;
        $startdate = $webhelper->RequestFilter("startdate", 10, false);
        $enddate = $webhelper->RequestFilter("enddate", 10, false);
        $start = explode('-', $startdate);
        $end = explode('-', $enddate);
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'startdate' && $key != 'enddate' && $key != 'sticker'){
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
            }elseif($key == 'searchKey'){
               if(is_string($_POST[$key]) && strlen($_POST[$key]) < 1200){
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
         //add strat date and end date at the end of data array
         array_push($data, $start[0], $start[1], $start[2], $end[0], $end[1]);
         if(empty($missing)){
            $doc = $dbhelper->RunSQLReturnOneRow("SELECT title, eventurl FROM events WHERE pkid = '$pkid'");
            $urlExists = 0;
            if($doc['eventurl'] != $data[13]){
               $urlExists = $dbhelper->numOfRows('SELECT pkid FROM events WHERE eventurl = ?', 's', $data[13]);
            }
            if($urlExists > 0){
                header('Location: /admin/news-events/events/list?error=titleurlfound');
                exit;
            }else{
              $slugUrl = $webhelper->validSlugUrl($data[15]);
              $uploads = array('thumbnail', 'heroimg', 'heromobile', 'up_file');
              $i=0;
              $newFileName=array();
              foreach($uploads as $file){
                if($file == 'up_file'){
                  $newFile = $webhelper->UploadFile($file, "/events/");
                }else{
                  $newFile = $webhelper->UploadFile($file, "/events/", true);
                }
                //old files data ids are 3,4,5,6
                $oldImage = $data[$i+3];
                if($newFile != null){
                  if(!empty($oldImage)) $webhelper->DeleteFile("/events/", $oldImage);
                  $newFileName[$i] = $newFile["filename"];
                  if($file == 'up_file') $newOrgFileName = $newFile["orgfilename"];
                }else{
                  $newFileName[$i] = $oldImage;
                  if($file == 'up_file') $newOrgFileName = $data[5];
                }
                $i++;
              }
              $params = array(&$data[8], &$data[9], &$data[10],&$data[11], &$data[12], &$data[13], &$data[14], &$slugUrl, &$data[16], &$data[17], &$data[18], &$data[19], &$data[20], &$data[21], &$newFileName[0], &$newFileName[1], &$newFileName[2], &$newFileName[3], &$newOrgFileName, &$status, &$isSlide, &$pkid);
                  $update = $dbhelper->processQuery("UPDATE events SET type=?, title=?, subtitle=?, address=?, location1=?, url=?, booth=?, eventurl=?, body=?, startmonth=?, startday=?, year=?, endmonth=?, endday=?, thumbnail=?, heroimg=?, heromobile=?, filename=?, orgfilename=?, status=?, isSlide=?, updatedate = NOW() WHERE pkid=?", "issssssssssssssssssiii", $params);

                if($update){
                  if($data[1] == 'none') $data[1] = "";
                  if($data[2] == 'none') $data[2] = 0;
                  $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                  header('Location: /admin/news-events/events/list'.$Parameter);
                  exit;
                }else{
                  header('Location: /admin/news-events/events/list?error=technicalissue');
                  exit;
                }
            }//title or url already exists
         }else{
           header('Location: /admin/news-events/events/list?error=infomissing');
           exit;
         }
       }else{
         header('Location: /admin/news-events/events/list');
         exit;
       }//check if event exists
     }else{
       header('Location: /admin/news-events/events/list?error=typemissing');
       exit;
     }//check if type
   }//check user
}else{
  header('Location: /admin/');
  exit;
}