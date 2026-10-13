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
$insertPage = false;
$insertHero = false;
$insertSection = false;
$updateSection = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    $expected = array('pagetitle', 'slugurl');
    $required = array('pagetitle', 'slugurl');
    $heroOutbound= isset($_POST['hero-outbound']) ? 1 : 0;
    foreach($_POST as $key => $value){
      if($key != 'create' && $key != 'hero-outbound'){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        if($key == 'pagetitle' || $key == 'slugurl'){
           $input = $webhelper->RequestFilter($key,  255, true);
        }else{
           $input = $webhelper->RequestFilter($key, -1, true);
        }
      }else{
        $input='none';
      }
      $data[$cnt] = $input;
      $cnt++;
     }
   }//for loop
   if(empty($missing)){
     $cmscat = $data[0];
     $cleanurl = $webhelper->validSlugUrl($data[2]);
     $pageParams = array(&$data[1], &$cleanurl);
     $insertPage = $dbhelper->processQuery("INSERT INTO faqs_page (title, slugurl, cat, updated, created, status) VALUES(?,?,'faqs',NOW(),NOW(),0)", "ss", $pageParams);
     if($insertPage){
        $pageId = $dbhelper->selectOne("SELECT pkid FROM faqs_page WHERE slugurl = ? AND cat='faqs'", 's', $cleanurl);
        $uploads = array('herodesktop', 'heromobile');
        $i=0;
        $newFileName=array();
        foreach($uploads as $file){
          if($_FILES[$file]['size'] == 0){
             $newFileName[$i] = 'none';
             if($file == 'herodesktop') $newOrgFileName = 'none';
          }else{
             $ext = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
             if($ext == 'mp4'){
               $newFile = $webhelper->UploadFile($file, "/hero/faqs/");
             }else{
               $newFile = $webhelper->UploadFile($file, "/hero/faqs/", true);
             }
             $newFileName[$i] = $newFile["filename"];
             if($file == 'herodesktop') $newOrgFileName = $newFile["orgfilename"];
          }
          $i++;
        }
        $heroHeading = 'Frequently Asked Questions';
        $heroPos = 1;
        $heroParams = array(&$pageId, &$data[3], &$newFileName[0], &$newOrgFileName, &$newFileName[1], &$heroHeading, &$data[6], &$data[7], &$data[8], &$data[9], &$heroOutbound, &$heroPos, &$data[4], &$data[5]);
        $insertHero = $dbhelper->processQuery("INSERT INTO faqs_page_hero (page_id, align, desktop, orgfilename, mobile, heading, subheading, paragraph, btn_text, btn_url, btn_target, hero_pos, height, bg, updated, created) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())", "isssssssssiiss", $heroParams);
        if($insertHero){
          $sectionPos = 1;
          $excludedWords = array(
            "and",
            "reactivity"
          );
          $string = str_replace("-"," ",$data[10]);
          $catName = ucwords($string);
          $catName = str_ireplace($excludedWords, $excludedWords, $catName);
          $sectionParams = array(&$pageId, &$catName, &$data[11], &$data[10]);
          $insertSection = $dbhelper->processQuery("INSERT INTO faqs_page_section (page_id, category, cat_body, bgColor, class_name, id_name, position, updated, created, status) VALUES (?,?,?,'white','faqs-category',?,1,NOW(),NOW(),0)", "isss", $sectionParams);
          if($insertSection){
              header('Location: /admin/resources/faqs/list');
              exit;
          }else{
            header('Location: /admin/resources/faqs/pageForm?error=Add-Section-Failed');
            exit;
          }
       }else{
          header('Location: /admin/resources/faqs/pageForm?error=Add-Hero-Section-Failed');
          exit;
       }
     }else{
       header('Location: /admin/resources/faqs/pageForm?error=Technical-Issue-Error');
       exit;
     }
   }//check if missing
  }//check username
}else{
  header('Location: /admin/');
  exit;
}
