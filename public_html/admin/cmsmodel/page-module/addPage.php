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
$insertReqs = false;
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
    $newSectionIncForm = isset($_POST['new-section-includeform']) ? 1 : 0;
    foreach($_POST as $key => $value){
      if($key != 'chooseform' && $key != 'hero-outbound' && $key != 'btn-outbound' && $key != 'new-section-includeform' && $key != 'colcontent' && $key != 'samplereqs' && $key != 'create'){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        if($key == 'cmscategory'){
            $input = $webhelper->RequestFilter($key, 50, false);
        }elseif($key == 'pagetitle' || $key == 'slugurl'){
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
     $pageParams = array(&$data[1], &$cleanurl, &$data[3], &$cmscat);
     $insertPage = $dbhelper->processQuery("INSERT INTO web_page (title, slugurl, description, cat, updatedate, created, status) VALUES(?,?,?,?,NOW(),NOW(),0)", "ssss", $pageParams);
     if($insertPage){
       $pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl = ? AND cat='$cmscat'", 's', $cleanurl);
       if(isset($_POST['samplereqs'])){
         foreach($_POST['samplereqs'] as $req_id){
          if(is_numeric($req_id)){
            $requirements[] = "($pageId,$req_id)";
          }
         }
         if(!empty($requirements)){
            $requirements = implode(',', $requirements);
            $reqsEmpty = false;
         }else{
            $reqsEmpty = true;
         }
         if(!$reqsEmpty){
            $insertReqs = $dbhelper->insertAll("INSERT INTO web_page_sample_req (page_id, req_id) VALUES $requirements");
         }
       }
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
       $heroPos = 1;
 
       $heroParams = array(&$pageId, &$data[4], &$desktopHero, &$desktopOrgName, &$mobileHero, &$data[7], &$data[8], &$data[9], &$data[10], &$data[11], &$heroOutbound, &$heroPos, &$data[5], $data[6]);
       $insertHero = $dbhelper->processQuery("INSERT INTO web_page_hero (page_id, align, desktop, orgfilename, mobile, subheading, heading, paragraph, btn_text, btn_url, btn_target, hero_pos, height, bg, updated, created) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())", "isssssssssiiss", $heroParams);
       if($insertHero){
          $pageForm = $webhelper->RequestFilter("chooseform", 50, false);
          if(isset($pageForm) && $pageForm == 'remove'){
           $deletePageForm = $dbhelper->deleteOne('DELETE FROM page_form_lookup WHERE page_id = ?', 'i', $pageId);
          }else{
           $formLookupId = $dbhelper->RunSQLReturnOneRow("SELECT pkid FROM page_form_lookup WHERE page_id = $pageId");
           if($formLookupId > 0){
             $updatePageForm = $dbhelper->updateOne("UPDATE page_form_lookup SET form_name=? WHERE page_id=?", 'si', $pageForm, $pageId);
           }else{
             $insertFormLookup = $dbhelper->updateOne("INSERT INTO page_form_lookup (page_id, form_name) VALUES (?,?)", 'is', $pageId, $pageForm); 
           }
          }

          if($_FILES['section-bg']['size'] == 0){
            $sectionBgImg['filename'] = 'none';
          }else{
            $sectionBgImg = $webhelper->UploadFile("section-bg", "/".$cmscat."/", true);
          }
          $sectionDesktop = $sectionBgImg['filename'];

          if($_FILES['section-bg-mobile']['size'] == 0){
            $sectionMobileImg['filename'] = 'none';
          }else{
            $sectionMobileImg = $webhelper->UploadFile("section-bg-mobile", "/".$cmscat."/", true);
          }
          $sectionMob = $sectionMobileImg['filename'];

          $extCustom = pathinfo($_FILES['videocustom']['name'], PATHINFO_EXTENSION);
          if($_FILES['videocustom']['size'] == 0){
            $videoImg['filename'] = 'none';
            $videoImg['orgfilename'] = 'none';
          }else{
            if($extCustom == 'mp4'){
               $videoImg = $webhelper->UploadFile("videocustom", "/".$cmscat."/");
            }else{
              $videoImg = $webhelper->UploadFile("videocustom", "/".$cmscat."/", true);
            }
          }
          $sectionVid = $videoImg['filename'];
          $sectionVidOrg = $videoImg['orgfilename'];
          $sectionClassName = '';
          $sectionIdName = '';
          $sectionPos = 1;

          if($data[11] == 'none') $data[11] = 'left';
          $sectionParams = array(&$pageId, &$data[11], &$data[12], &$data[13], &$sectionClassName, &$sectionIdName, &$sectionDesktop, &$sectionMob, &$data[14], &$data[15], &$data[16], &$newSectionIncForm , &$data[17], &$sectionVid, &$sectionVidOrg, &$data[18], &$sectionPos);
          $insertSection = $dbhelper->processQuery("INSERT INTO web_page_section (page_id, align, bgColor, numofcols, class_name, id_name, bgimg, bgMobileImg, heading, subheading, section_paragraph, hasForm, section_body, videoimg, videoimgorgname, ytvideo, position, updatedate, created, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),0)", "ississsssssissssi", $sectionParams);

          if($insertSection){
            $sectionId = $dbhelper->getLastId();
            if($newSectionIncForm == 1 && $pageForm != 'remove'){
               $sectionClassName = 'form-section '.$pageForm;
            }else{
               $sectionClassName = $cmscat.'-'.$pageId.'-section-'.$sectionId;
            }
            $updateSection = $dbhelper->updateAll("UPDATE web_page_section SET class_name='$sectionClassName', id_name='$cmscat-$pageId-section-$sectionId', updatedate = NOW() WHERE pkid = '$sectionId'");
            if($updateSection){
              //it's default global button
              if($data[20] == 'none' || $data[20] == 'global-btn'){
                $btnClass = '';
              }else{
                $btnClass = $data[20];
              }
              $btnClassName = $cmscat.'-section-btn global-btn '.$btnClass.' smooth-hover';
              $btnIdName = $cmscat.'-section-'.$sectionId.'-btn-1';
              $btnParams = array(&$sectionId, &$btnClassName, &$btnIdName, &$data[19], &$data[20], &$data[21], &$btnOutbound);
              $insertBtn = $dbhelper->processQuery("INSERT INTO web_page_btn (section_id, btn_class, btn_id, btn_text, btn_bg, btn_url, btn_target, updatedate, created) VALUES (?,?,?,?,?,?,?,NOW(),NOW())", "isssssi", $btnParams);
              if($insertBtn){
                $newSecColTotal = 0;
                foreach($_POST['colcontent'] as $colnum => $content){
                    $colBg = $_POST['new-column-'.($colnum+1).'-color'];
                    $colBg = $colBg == 0 ? '' : $colBg;
                    $colParams = array(&$sectionId, &$colBg, &$content);
                    $insertCol = $dbhelper->processQuery("INSERT INTO web_page_column (section_id, bgColor, body, updated, created) VALUES (?,?,?,NOW(),NOW())", "iss", $colParams);
                    if(!empty($content)) $newSecColTotal++;
                      $dbhelper->updateOne('UPDATE web_page_section SET numofcols = ? WHERE pkid =?', 'ii', $newSecColTotal, $sectionId);
                }
                if($insertCol){
                  header('Location: /admin/cmsmodel/page-module/list?category='.$cmscat);
                  exit;
                }else{
                  header('Location: /admin/cmsmodel/page-module/list?category='.$cmscat.'&error=Add-Section-Column-Failed');
                  exit;
                }
              }else{
                header('Location: /admin/cmsmodel/page-module/list?category='.$cmscat.'&error=Add-Section-Button-Failed');
                exit;
              }
            }else{
              header('Location: /admin/cmsmodel/page-module/list?category='.$cmscat.'&error=Update-Section-Class-Failed');
              exit;
            }
          }else{
            header('Location: /admin/cmsmodel/page-module/pageForm?category='.$cmscat.'&error=Add-Section-Failed');
            exit;
          }
       }else{
          header('Location: /admin/cmsmodel/page-module/pageForm?category='.$cmscat.'&error=Insert-Hero-Section-Failed');
          exit;
       }
     }else{
       header('Location: /admin/cmsmodel/page-module/pageForm?category='.$cmscat.'&error=Technical-Issue-Error');
       exit;
     }
   }//check if missing
  }//check username
}else{
  header('Location: /admin/');
  exit;
}