<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$updateMeta = false;
$updateHero = false;
$updateSection = false;
$insertPage = false;
$insertSection = false;
$insertNewSection = false;
$excludedWords = array(
  "and",
  "reactivity"
);
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
     $pageId = $webhelper->RequestFilter("pkid", 0, false);
     $pageExists = $dbhelper->numOfRows("SELECT slugurl FROM faqs_page WHERE pkid = ? AND cat='faqs'", 'i', $pageId);
     if($pageExists > 0){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       $Parameter = "&searchKey=$searchKey&order=$order";
       $title = $webhelper->RequestFilter("pagetitle", 200, false);
       $slugurl = $webhelper->RequestFilter("slugurl", 250, false);
       $cleanurl = $webhelper->validSlugUrl($slugurl);
       $pageParams = array(&$title, &$cleanurl, &$pageId);
       $updateMeta = $dbhelper->processQuery("UPDATE faqs_page SET title=?, slugurl=?, updated = NOW() WHERE pkid = ?", "ssi", $pageParams);
       $heroLayout = $webhelper->RequestFilter("herolayout", 10, false);
       $oldHeroDesktop = $webhelper->RequestFilter("oldHeroDesktop", 255, false);
       $oldHeroMobile = $webhelper->RequestFilter("oldHeroMobile", 255, false);
       $oldHeroOrgName = $webhelper->RequestFilter("oldHeroOrgName", 255, false);

       $uploads = array('herodesktop', 'heromobile');
        $i=0;
        $newFileName=array();
        foreach($uploads as $file){
          if($_FILES[$file]['size'] == 0){
             if($file == 'herodesktop'){
              $newFileName[$i] = $oldHeroDesktop;
              $newOrgFileName = $oldHeroOrgName;
             }else{
              $newFileName[$i] = $oldHeroMobile;
             }
          }else{
             $ext = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
             if($file == 'herodesktop'){
               $webhelper->DeleteFile("/hero/faqs/", $oldHeroDesktop);
             }else{
               $webhelper->DeleteFile("/hero/faqs/", $oldHeroMobile);
             }
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
        $heroTitle = 'Frequently Asked Questions';
        $heroSubtitle = $webhelper->RequestFilter("herosubtitle", 100, true);
        $heroSubtitle = !empty($heroSubtitle) ? $heroSubtitle : 'none';
        $heroParagraph = !empty($_POST['heroparagraph']) ? $_POST['heroparagraph'] : 'none';
        $heroBtnText = $webhelper->RequestFilter("herosectionbtn", 60, false);
        $heroBtnText = !empty($heroBtnText) ? $heroBtnText : 'none';
        $heroBtnUrl = $webhelper->RequestFilter("herotargeturl", 255, false);
        $heroBtnUrl = !empty($heroBtnUrl) ? $heroBtnUrl : 'none';
        $heroBtnTarget= isset($_POST['hero-outbound']) ? 1 : 0;
        $heroPos = 1;
        $heroHeight = $webhelper->RequestFilter("heroheight", 10, false);
        $heroBg = $webhelper->RequestFilter("herobg", 20, false);

        $heroParams = array(&$heroLayout, &$newFileName[0], &$newOrgFileName, &$newFileName[1], &$heroSubtitle, &$heroTitle, &$heroParagraph, &$heroBtnText, &$heroBtnUrl, &$heroBtnTarget, &$heroPos, &$heroHeight, &$heroBg, &$pageId);
        $updateHero = $dbhelper->processQuery("UPDATE faqs_page_hero SET align=?, desktop=?, orgfilename=?, mobile=?, subheading=?, heading=?, paragraph=?, btn_text=?, btn_url=?, btn_target=?, hero_pos=?, height=?, bg=?, updated = NOW() WHERE page_id = ?", "sssssssssiissi", $heroParams);

          if(isset($_POST['new-section']) && $_POST['new-section'] > 0){
              $newSectionPos = $webhelper->RequestFilter('new-section', 0, false);
              $newCat = $webhelper->RequestFilter("new-category", 100, false);
              $string = str_replace("-"," ",$newCat);
              $catName = ucwords($string);
              $catName = str_ireplace($excludedWords, $excludedWords, $catName);
              $newSectionBody = $_POST['new-section-body'];
              $newSectionBody = !empty($newSectionBody) ? $newSectionBody : 'none';
              $newSectionIdName = $_POST['new-category'];;
              $newSectionParams = array(&$pageId, &$catName, &$newSectionBody, &$newSectionIdName, &$newSectionPos);
              $insertNewSection = $dbhelper->processQuery("INSERT INTO faqs_page_section (page_id, category, cat_body, bgColor, class_name, id_name, position, updated, created, status) VALUES (?,?,?,'white','faqs-category',?,?,NOW(),NOW(),0)", "isssi", $newSectionParams);
              if(!$insertNewSection){
                header('Location: /admin/resources/faqs/list?error=Could-Not-Add-New-Section&page='.$page.$Parameter);
                 exit;
              }
           }
           $totalSections = count($_POST['section']);
           foreach($_POST['section'] as $key => $sectionId){
              $sectionCat = $_POST['section-'.($key+1).'-category'];
              $getCat = str_replace("-"," ",$sectionCat);
              $catName = ucwords($getCat);
              $catName = str_ireplace($excludedWords, $excludedWords, $catName);
              $sectionBg = 'white';
              $getBody =  $_POST['section-'.($key+1).'-body'];
              $sectionBody = empty($getBody) ? 'none' : $getBody;
              $sectionParams = array(&$sectionCat, &$sectionBg, &$catName, &$sectionBody, &$sectionId, &$pageId);
              $updateSection = $dbhelper->processQuery("UPDATE faqs_page_section SET id_name=?, bgColor=?, category=?, cat_body=?, updated = NOW() WHERE pkid = ? AND page_id = ?", "ssssii", $sectionParams);
           }//close foreach section loop
           if($updateSection){
               header('Location: /admin/resources/faqs/list?page='.$page.$Parameter);
               exit;
           }else{
              header('Location: /admin/resources/faqs/list?error=Category-Section-Update-Failed&page='.$page.$Parameter);
              exit;
           }
     }else{
	    header('Location: /admin/resources/faqs/list?error=Page-Not-Found&page='.$page.$Parameter);
        exit;
     }//check pkid
   }else{
    header('Location: /admin/');
    exit;
   }//check username
}else{
  header('Location: /admin/');
  exit;
}