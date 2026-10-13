<?php 
include_once('../../../lcmodel/loadPage.inc.php');
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

if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    $expected = array('pagetitle', 'slugurl', 'pagedesc', 'pagecat');
    $required = array('pagetitle', 'slugurl', 'pagedesc', 'pagecat');
    foreach($_POST as $key => $value){
      if($key != 'create'){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        $input = $webhelper->RequestFilter($key,  255, true);
      }
      $data[$cnt] = $input;
      $cnt++;
     }
   }//for loop
   if(empty($missing)){
       $slugUrl = $webhelper->validSlugUrl($data[1]);
       $params = array(&$data[0], &$slugUrl, &$data[2], &$data[3]);
       $insertPage = $dbhelper->processQuery("INSERT INTO web_page (title, slugurl, description, cat, updatedate, created, status) VALUES(?,?,?,?,NOW(),NOW(),0)", "ssss", $params);
       if($insertPage){
         $newPageId = $dbhelper->selectOne('SELECT pkid FROM web_page WHERE slugurl = ?', 's', $slugUrl);
         $insertHero = $dbhelper->insertAll("INSERT INTO web_page_hero (page_id, align, desktop, orgfilename, mobile, subheading, heading, paragraph, btn_text, btn_url, btn_target, hero_pos, height, bg, updated, created) VALUES($newPageId, 'left', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 0, 1, 'tall', 'white', NOW(),NOW())");
         header('Location: /admin/cmsmodel/page-module/list?category='.$data[3]);
         exit;
       }else{
         header('Location: /admin/cmsmodel?errorPage=Technical-Issue-Error');
         exit;
       }
   }//check if missing
  }//check username
}else{
  header('Location: /admin/');
  exit;
}
