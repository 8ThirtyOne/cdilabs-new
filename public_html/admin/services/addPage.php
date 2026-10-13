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
$insertHero = false;
$insertSection = false;
$updateSection = false;
$insertBtn = false;
$insertCol = false;

if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    $expected = array('pagetitle', 'slugurl', 'pagedesc');
    $required = array('pagetitle', 'slugurl', 'pagedesc');
    $heroOutbound= isset($_POST['hero-outbound']) ? 1 : 0;
    $btnOutbound = isset($_POST['btn-outbound']) ? 1 : 0;
    foreach($_POST as $key => $value){
      if($key != 'hero-outbound' && $key != 'btn-outbound' && $key != 'colcontent' && $key != 'create'){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        if($key == 'pagetitle' || $key == 'slugurl' || $key == 'pagedesc'){
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
     $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
     $cleanurl = str_replace($chars,"",$data[1]);
     $cleanurl = strtolower($cleanurl);
     $cleanurl = str_replace(" ","-",$cleanurl);
     if(!empty($_FILES['herodesktop']['name']) && !empty($_FILES['heromobile']['name'])){ 
       $insertPage = $dbhelper->webPageIn($data[0], $cleanurl, $data[2], 'services');
       if($insertPage){
         $pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl = ? AND cat='services'", 's', $cleanurl);
         $ext = pathinfo($_FILES['herodesktop']['name'], PATHINFO_EXTENSION);
         if($ext == 'mp4'){
           $heroDesktopImg = $webhelper->UploadFile("herodesktop", "/hero/services/");
         }else{
           $heroDesktopImg = $webhelper->UploadFile("herodesktop", "/hero/services/", true);
         }
         $heroMobileImg = $webhelper->UploadFile("heromobile", "/hero/services/", true);
         $insertHero = $dbhelper->webPageHeroIn($pageId, $data[3], $heroDesktopImg['filename'], $heroDesktopImg['orgfilename'], $heroMobileImg['filename'], $data[4], $data[5], $data[6], $data[7], $data[8], $heroOutbound);
         if($insertHero){
            if($_FILES['section-bg']['size'] == 0){
              $sectionBgImg['filename'] = 'none';
            }else{
              $sectionBgImg = $webhelper->UploadFile("section-bg", "/services/", true);
            }
            if($_FILES['section-bg-mobile']['size'] == 0){
              $sectionMobileImg['filename'] = 'none';
            }else{
              $sectionMobileImg = $webhelper->UploadFile("section-bg-mobile", "/services/", true);
            }
            $extCustom = pathinfo($_FILES['videocustom']['name'], PATHINFO_EXTENSION);
            if($_FILES['videocustom']['size'] == 0){
              $videoImg['filename'] = 'none';
              $videoImg['orgfilename'] = 'none';
            }else{
              if($extCustom == 'mp4'){
                 $videoImg = $webhelper->UploadFile("videocustom", "/services/");
              }else{
                $videoImg = $webhelper->UploadFile("videocustom", "/services/", true);
              }
            }
            if($data[9] == 'none') $data[9] = 'left';
              $insertSection = $dbhelper->webPageSectionIn($pageId, $data[9], $data[10], $data[11], '', '', $sectionBgImg['filename'], $sectionMobileImg['filename'], $data[12], $data[13], $data[14], $data[15], $videoImg['filename'], $videoImg['orgfilename'], $data[16], 1);
            if($insertSection){
              $sectionId = $dbhelper->getLastId();
              $updateSection = $dbhelper->updateOne("UPDATE web_page_section SET class_name = ? WHERE pkid = ?", 'si', "services-$pageId-section-$sectionId", $sectionId);
              $updateSection = $dbhelper->updateOne("UPDATE web_page_section SET id_name = ? WHERE pkid = ?", 'si', "services-$pageId-section-$sectionId", $sectionId);
              if($updateSection){
                //it's default global button
                if($data[18] == 'none' || $data[18] == 'global-btn'){
                  $btnClass = '';
                }else{
                  $btnClass = $data[18];
                }
                $insertBtn = $dbhelper->webPageBtnIn($sectionId, 'services-section-btn global-btn '.$btnClass.' smooth-hover', 'services-section-'.$sectionId.'-btn-1', $data[17], $data[18], $data[19], $btnOutbound);
                if($insertBtn){
                  $newSecColTotal = 0;
                  foreach($_POST['colcontent'] as $colnum => $content){
                      $colBg = $_POST['new-column-'.($colnum+1).'-color'];
                      $colBg = $colBg == 0 ? '' : $colBg; 
                      $insertCol = $dbhelper->webPageColIn($sectionId, $colBg, $content);
                      if(!empty($content)) $newSecColTotal++;
                        $dbhelper->updateOne('UPDATE web_page_section SET numofcols = ? WHERE pkid =?', 'ii', $newSecColTotal, $sectionId);
                  }
                  if($insertCol){
                    header('Location: /admin/services/list');
                    exit;
                  }else{
                    header('Location: /admin/services/list?error=Add-Section-Column-Failed');
                    exit;
                  }
                }else{
                  header('Location: /admin/services/list?error=Add-Section-Button-Failed');
                  exit;
                }
              }else{
                header('Location: /admin/services/list?error=Update-Section-Class-Failed');
                exit;
              }
            }else{
              header('Location: /admin/services/pageForm?error=Add-Section-Failed');
              exit;
            }
         }else{
            header('Location: /admin/services/pageForm?error=Insert-Hero-Section-Failed');
            exit;
         }
       }else{
         header('Location: /admin/services/pageForm?error=Technical-Issue-Error');
         exit;
       }
     }else{
       header('Location: /admin/services/pageForm?error=Both-Hero-Images-Are-Required');
       exit;
     }
   }//check if missing
  }//check username
}else{
  header('Location: /admin/');
  exit;
}
