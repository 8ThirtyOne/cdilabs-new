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
$insertHero = false;

if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    $pageId = $webhelper->RequestFilter("pkid", 0, false);
    $cmscat = $webhelper->RequestFilter("cmscategory", 50, false);
    $pageExists = $dbhelper->numOfRows("SELECT slugurl FROM web_page WHERE pkid = ? AND cat='$cmscat'", 'i', $pageId);
    if($pageExists > 0){
      $expected = array('herosubtitle', 'herotitle', 'heroparagraph', 'herobtn', 'hero-outbound', 'herourl');
      $required = array('');
      $heroOutbound = isset($_POST['hero-outbound']) ? 1 : 0;
      foreach($_POST as $key => $value){
        if($key != 'pkid' && $key != 'create'){
        $temp = is_array($value) ? $value : trim($value);
        if(empty($temp) && in_array($key, $required)){
          array_push($missing, $key);
        }elseif(in_array($key, $expected)){
          ${$key} = $temp;
        }
        if(!empty($value)){
          $input = $webhelper->RequestFilter($key,  255, true);
        }else{
          $input='none';
        }
        $data[$cnt] = $input;
        $cnt++;
       }
     }//for loop
     $heroes = $dbhelper->selectAll("SELECT * FROM web_page_hero WHERE page_id = $pageId");
     if(count($heroes) > 0){
       $heroPos = count($heroes) + 1;
     }else{
       $heroPos = 1;
     }
     if(empty($missing)){
        if($_FILES['herodesktop']['size'] == 0){
           $heroDesktopImg['filename'] = 'none';
           $heroDesktopImg['orgfilename'] = 'none';
        }else{
           $ext = pathinfo($_FILES['herodesktop']['name'], PATHINFO_EXTENSION);
           if($ext == 'mp4'){
             $heroDesktopImg = $webhelper->UploadFile("herodesktop", "/hero/".$cmscat."/");
           }else{
             $heroDesktopImg = $webhelper->UploadFile("herodesktop", "/hero/".$cmscat."/", true);
           }
        }
        $desktopHero = $heroDesktopImg['filename'];
        $desktopOrgName = $heroDesktopImg['orgfilename'];

        if($_FILES['heromobile']['size'] == 0){
           $heroMobileImg['filename'] = 'none';
        }else{
           $heroMobileImg = $webhelper->UploadFile("heromobile", "/hero/".$cmscat."/", true);
        }
        $mobileHero = $heroMobileImg['filename'];

        $params = array(&$pageId, &$data[1], &$data[2], &$desktopHero, &$desktopOrgName, &$mobileHero, &$data[3], &$data[4], &$data[5], &$data[6], &$data[7], &$heroOutbound, &$heroPos);
        $insertHero = $dbhelper->processQuery("INSERT INTO web_page_hero (page_id, align, bg, desktop, orgfilename, mobile, subheading, heading, paragraph, btn_text, btn_url, btn_target, hero_pos, height, updated, created) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,'tall', NOW(),NOW())", "issssssssssii", $params);

        if($insertHero){
           header('Location: /admin/cmsmodel/page-module/pageWithSlides?pkid='.$pageId.'&category='.$cmscat);
           exit;
        }else{
           header('Location: /admin/cmsmodel/page-module/pageWithSlides?pkid='.$pageId.'&category='.$cmscat.'&error=Technical-Issue-Error');
           exit;
       }
     }//check if missing
    }else{
      header('Location: /admin/cmsmodel/errorPage?reason=No-Page-or-Category-Found');
      exit;
    }//check if page exists
  }else{
    header('Location: /admin/');
    exit;
  }//check username
}else{
  header('Location: /admin/');
  exit;
}
