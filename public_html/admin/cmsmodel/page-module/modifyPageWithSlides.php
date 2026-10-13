<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$updateMeta = false;
$updatePageForm = false;
$updateHero = false;
$updateSection = false;
$updateButton = false;
$updateColumn = false;
$insertPage = false;
$insertFormLookup = false;
$deletePageForm = false;
$insertHero = false;
$insertSection = false;
$insertBtn = false;
$insertCol = false;
$insertNewSection = false;
$insertNewBtn = false;
$insertNewCol = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
     $pageId = $webhelper->RequestFilter("pkid", 0, false);
     $cmscat = $webhelper->RequestFilter("cmscategory", 50, false);
     $slugurl = $dbhelper->selectOne("SELECT slugurl FROM web_page WHERE pkid = ? AND cat='$cmscat'", 'i', $pageId);
     if(!empty($slugurl)){
         $page = $webhelper->RequestFilter("page", 0, false);
         $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
         $order = $webhelper->RequestFilter("order", 0, false);
         $Parameter = "&searchKey=$searchKey&order=$order";
         $title = $webhelper->RequestFilter("pagetitle", 200, false);
         $pagedesc = $webhelper->RequestFilter("pagedesc", 250, false);
         $pageParams = array(&$title, &$pagedesc, &$pageId);
         $updateMeta = $dbhelper->processQuery("UPDATE web_page SET  title=?, description=?, updatedate = NOW() WHERE pkid = ? AND cat = '$cmscat'", "ssi", $pageParams);

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

         $totalHeroes = count($_POST['hero']);
         foreach($_POST['hero'] as $hKey => $heroId){
            $heroPos = $_POST['hero-'.($hKey+1).'-position'];
            $heroHeight = "tall";
            $heroBg = $_POST['hero-'.($hKey+1).'-bg'];
            $heroLayout = $_POST['hero-'.($hKey+1).'-layout'];
            $oldHeroDesktop = $_POST['hero-'.($hKey+1).'-oldDesktop'];
            $oldHeroMobile = $_POST['hero-'.($hKey+1).'-oldMobile'];
            $oldHeroOrgName = $_POST['hero-'.($hKey+1).'-oldOrgFilename'];
            if($_FILES['hero-'.($hKey+1).'-desktop']['size'] == 0){
              $newHeroDesktopName = $oldHeroDesktop;
              $newHeroOrgName = $oldHeroOrgName;
            }else{
              $heroExt = pathinfo($_FILES['hero-'.($hKey+1).'-desktop']['name'], PATHINFO_EXTENSION);
              $webhelper->DeleteFile("/hero/".$cmscat."/", $oldHeroDesktop);
              if($heroExt == 'mp4'){
                $newHeroDesktop = $webhelper->UploadFile('hero-'.($hKey+1).'-desktop', "/hero/".$cmscat."/");
                $newHeroOrgName = $newHeroDesktop['orgfilename'];
              }else{
                $newHeroDesktop = $webhelper->UploadFile('hero-'.($hKey+1).'-desktop', "/hero/".$cmscat."/", true);
                $newHeroOrgName = 'none';
              }
              $newHeroDesktopName = $newHeroDesktop["filename"];
            }
            if($_FILES['hero-'.($hKey+1).'-mobile']['size'] == 0){
               $newMobileFileName = $oldHeroMobile;
            }else{
              $webhelper->DeleteFile("/hero/".$cmscat."/", $oldHeroMobile);
              $newHeroMobile = $webhelper->UploadFile('hero-'.($hKey+1).'-mobile', "/hero/".$cmscat."/", true);
              $newMobileFileName = $newHeroMobile["filename"];
            }

            $heroSubtitle = !empty($_POST["hero-".($hKey+1)."-subtitle"]) ? $webhelper->RequestFilter("hero-".($hKey+1)."-subtitle", 200, true) : 'none';
            $heroTitle = !empty($_POST["hero-".($hKey+1)."-title"]) ? $webhelper->RequestFilter("hero-".($hKey+1)."-title", 200, true) : 'none';
            $heroParagraph = !empty($_POST["hero-".($hKey+1)."-paragraph"]) ? $_POST["hero-".($hKey+1)."-paragraph"] : 'none';
            $heroBtnText = !empty($_POST["hero-".($hKey+1)."-btn"]) ? $webhelper->RequestFilter("hero-".($hKey+1)."-btn", 60, false) : 'none';
            $heroBtnTarget= isset($_POST["hero-".($hKey+1)."-outbound"]) ? 1 : 0;
            $heroBtnUrl = !empty($_POST["hero-".($hKey+1)."-targeturl"]) ? $webhelper->RequestFilter("hero-".($hKey+1)."-targeturl", 255, false) : 'none';

            $heroBtnText2 = !empty($_POST["hero-".($hKey+1)."-btn2"]) ? $webhelper->RequestFilter("hero-".($hKey+1)."-btn2", 60, false) : 'none';
            $heroBtnTarget2= isset($_POST["hero-".($hKey+1)."-outbound2"]) ? 1 : 0;
            $heroBtnUrl2 = !empty($_POST["hero-".($hKey+1)."-targeturl2"]) ? $webhelper->RequestFilter("hero-".($hKey+1)."-targeturl2", 255, false) : 'none';

            $heroParams = array(&$heroLayout, &$newHeroDesktopName, &$newHeroOrgName, &$newMobileFileName, &$heroSubtitle, &$heroTitle, &$heroParagraph, &$heroBtnText, &$heroBtnUrl, &$heroBtnTarget, &$heroBtnText2, &$heroBtnUrl2, &$heroBtnTarget2, &$heroPos, &$heroHeight, &$heroBg, &$heroId, &$pageId);
            $updateHero = $dbhelper->processQuery("UPDATE web_page_hero SET align=?, desktop=?, orgfilename=?, mobile=?, subheading=?, heading=?, paragraph=?, btn_text=?, btn_url=?, btn_target=?, btn2_text=?, btn2_url=?, btn2_target=?, hero_pos=?, height=?, bg=?, updated=NOW() WHERE pkid = ? AND page_id = ?", "sssssssssissiissii", $heroParams);
          }
          
          if(isset($_POST['new-section']) && $_POST['new-section'] > 0){
            $newSectionPos = $webhelper->RequestFilter('new-section', 0, false);
            $newLayout = $webhelper->RequestFilter("new-layout", 10, false);
            $newLayout = $newLayout > 0 ? $newLayout : 'left';
            $newBgColor = $webhelper->RequestFilter("new-bgcolor", 60, false);
            $newBgColor = $newBgColor > 0 ? $newBgColor : 'none';
            $newColNum =  $webhelper->RequestFilter("new-colnum", 0, false);
            $newHeading = !empty($_POST['new-section-heading']) ? $_POST['new-section-heading'] : 'none';
            $newSubheading = !empty($_POST['new-section-subheading']) ? $_POST['new-section-subheading'] : 'none';
            $newSectionPara = !empty($_POST['new-section-paragraph']) ? $webhelper->RequestFilter("new-section-paragraph", -1, true) : 'none';
            $newSectionIncForm = isset($_POST['new-section-includeform']) ? 1 : 0;
            $newSectionBody = !empty($_POST['new-section-body']) ? $webhelper->RequestFilter("new-section-body", -1, true) : 'none';
            $newYouTube = $webhelper->RequestFilter("new-section-youtubeurl", 20, false);
            $newYouTube = !empty($newYouTube) ? $newYouTube : 'none';
            
            if($_FILES['new-section-bgimg']['size'] == 0){
              $newSectionBgImg['filename'] = 'none';
            }else{
             $newSectionBgImg = $webhelper->UploadFile("new-section-bgimg", "/".$cmscat."/", true);
            }
            if($_FILES['new-section-bgmobile']['size'] == 0){
              $newSectionMobileImg['filename'] = 'none';
            }else{
              $newSectionMobileImg = $webhelper->UploadFile("new-section-bgmobile", "/".$cmscat."/", true);
            }
            $extCustom = pathinfo($_FILES['new-section-videocustom']['name'], PATHINFO_EXTENSION);
            if($_FILES['new-section-videocustom']['size'] == 0){
              $newVideoCustom['filename'] = 'none';
              $newVideoCustom['orgfilename'] = 'none';
            }else{
              if($extCustom == 'mp4'){
                $newVideoCustom = $webhelper->UploadFile("new-section-videocustom", "/".$cmscat."/");
              }else{
                $newVideoCustom = $webhelper->UploadFile("new-section-videocustom", "/".$cmscat."/", true);
              }
            }

            $newSectionDesktop = $newSectionBgImg['filename'];
            $newSectionMobile = $newSectionMobileImg['filename'];
            $newSectionVid = $newVideoCustom['filename'];
            $newSectionVidOrg = $newVideoCustom['orgfilename'];
            $newSectionClassName = '';
            $newSectionIdName = '';

            $newSectionParams = array(&$pageId, &$newLayout, &$newBgColor, &$newColNum, &$newSectionClassName, &$newSectionIdName, &$newSectionDesktop, &$newSectionMobile, &$newHeading, &$newSubheading, &$newSectionPara, &$newSectionIncForm, &$newSectionBody, &$newSectionVid, &$newSectionVidOrg, &$newYouTube, &$newSectionPos);
            $insertNewSection = $dbhelper->processQuery("INSERT INTO web_page_section (page_id, align, bgColor, numofcols, class_name, id_name, bgimg, bgMobileImg, heading, subheading, section_paragraph, hasForm, section_body, videoimg, videoimgorgname, ytvideo, position, updatedate, created, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),0)", "ississsssssissssi", $newSectionParams);

            if($insertNewSection){
              $newSectionId = $dbhelper->getLastId();
              if($newSectionIncForm == 1 && $pageForm != 'remove'){
                $sectionClassName = 'form-section '.$pageForm;
              }else{
                $sectionClassName = $cmscat.'-'.$pageId.'-section-'.$newSectionId;
              }
              $updateNewSection = $dbhelper->updateAll("UPDATE web_page_section SET class_name='$sectionClassName', id_name='$cmscat-$pageId-section-$newSectionId', updatedate=NOW() WHERE pkid='$newSectionId'");
              if($updateNewSection){
                $newBtnColor = $webhelper->RequestFilter("new-btncolor", 20, false);
                $newBgColor = $newBtnColor > 0 ? $newBtnColor : 'none';
                $newBtnText = $webhelper->RequestFilter("new-section-btn-text", -1, true);
                $newBtnText = !empty($newBtnText) ? $newBtnText : 'none';
                $newBtnUrl = $webhelper->RequestFilter("new-section-btnurl", 255, false);
                $newBtnUrl = !empty($newBtnUrl) ? $newBtnUrl : 'none';
                $newbtnOutbound = isset($_POST['new-section-btnoutbound']) ? 1 : 0;
                //if clear it's default global button
                $newBtnClass = $newBtnColor == 'global-btn' ? '' : $newBtnColor; 
                //prepare for params
                $newBtnClassName = $cmscat.'-section'.$newSectionId.'-btn global-btn'.$newBtnClass.' smooth-hover';
                $newBtnIdName = $cmscat.'-section-'.$newSectionId.'-btn-'.$newSectionPos;

                $newBtnParams = array(&$newSectionId, &$newBtnClassName, &$newBtnIdName, &$newBtnText, &$newBtnColor, &$newBtnUrl, &$newbtnOutbound);
                $insertNewBtn = $dbhelper->processQuery("INSERT INTO web_page_btn (section_id, btn_class, btn_id, btn_text, btn_bg, btn_url, btn_target, updatedate, created) VALUES (?,?,?,?,?,?,?,NOW(),NOW())", "isssssi", $newBtnParams);
                
                if($insertNewBtn){
                  $newSecColTotal = 0;
                  foreach($_POST['new-section-column-content'] as $newColNum => $newContent){
                      $newColBg = $_POST['new-column-'.($newColNum+1).'-color'];
                      $newColParams = array(&$newSectionId, &$newColBg, &$newContent);
                      $insertNewCol = $dbhelper->processQuery("INSERT INTO web_page_column (section_id, bgColor, body, updated, created) VALUES (?,?,?,NOW(),NOW())", "iss", $newColParams);
                      if(!empty($newContent)) $newSecColTotal++;
                      $dbhelper->updateOne('UPDATE web_page_section SET numofcols = ? WHERE pkid =?', 'ii', $newSecColTotal, $newSectionId);
                  }
                }
              }
            }
         }
         if(isset($_POST['section'])){
           $totalSections = count($_POST['section']);
           if($totalSections > 0){
             foreach($_POST['section'] as $key => $sectionId){
                $sectionLayout = $_POST['section-'.($key+1).'-layout'];
                $sectionBg = $_POST['section-'.($key+1).'-bgcolor'];
                $sectionOldDesktop = $_POST['section-'.($key+1).'-oldBgImg'];
                if($_FILES['section-'.($key+1).'-bgimg']['size'] > 0){
                  $sectionDesktop = $webhelper->UploadFile("section-".($key+1)."-bgimg", "/".$cmscat."/", true);
                  if($sectionOldDesktop != 'none'){
                    $webhelper->DeleteFile("/".$cmscat."/", $sectionOldDesktop);
                  }
                  $sectionDesktopNewName = $sectionDesktop["filename"];
                }else{
                  $sectionDesktopNewName = $sectionOldDesktop;
                }
                $sectionOldMobile = $_POST['section-'.($key+1).'-oldBgMobile'];
                if($_FILES['section-'.($key+1).'-bgmobile']['size'] > 0){
                  $sectionMobile = $webhelper->UploadFile("section-".($key+1)."-bgmobile", "/".$cmscat."/", true);
                  if($sectionOldMobile != 'none'){
                    $webhelper->DeleteFile("/".$cmscat."/", $sectionOldMobile);
                  }
                  $sectionMobileNewName = $sectionMobile["filename"];
                }else{
                  $sectionMobileNewName = $sectionOldMobile;
                }
                $getHeading =  $_POST['section-'.($key+1).'-heading'];
                $sectionHeading = empty($getHeading) ? 'none' : $getHeading;
                $getSubheading =  $_POST['section-'.($key+1).'-subheading'];
                $sectionSubheading = empty($getSubheading) ? 'none' : $getSubheading;
                $getPara =  $_POST['section-'.($key+1).'-paragraph'];
                $sectionParagraph = empty($getPara) ? 'none' : $getPara;
                $sectionIncForm = isset($_POST['section-'.($key+1).'-incform']) ? 1 : 0;
                $getBody =  $_POST['section-'.($key+1).'-body'];
                $sectionBody = empty($getBody) ? 'none' : $getBody;
                $oldVideoImgCustom = $_POST['section-'.($key+1).'-oldVideoCustom'];
                $oldVideoImgCustomOrg = $_POST['section-'.($key+1).'-oldVideoCustomOrg'];
                if($_FILES['section-'.($key+1).'-videocustom']['size'] == 0){
                  $newVidCustomName = $oldVideoImgCustom;
                  $newVidCustomOrgName = $oldVideoImgCustomOrg;
                }else{
                  $vcExt = pathinfo($_FILES['section-'.($key+1).'-videocustom']['name'], PATHINFO_EXTENSION);
                  $webhelper->DeleteFile("/".$cmscat."/", $oldVideoImgCustom);
                  if($vcExt == 'mp4'){
                    $newVidCustom = $webhelper->UploadFile("section-".($key+1)."-videocustom", "/".$cmscat."/");
                    $newVidCustomOrgName = $newVidCustom['orgfilename'];
                  }else{
                    $newVidCustom = $webhelper->UploadFile("section-".($key+1)."-videocustom", "/".$cmscat."/", true);
                    $newVidCustomOrgName = 'none';
                  }
                  $newVidCustomName = $newVidCustom["filename"];
                }
                $getYouTube = $_POST['section-'.($key+1).'-youtubeurl'];
                $sectionYouTube = empty($getYouTube) ? 'none' : $getYouTube;

                $sectionParams = array(&$sectionLayout, &$sectionBg, &$sectionDesktopNewName, &$sectionMobileNewName, &$sectionHeading, &$sectionSubheading, &$sectionParagraph, &$sectionIncForm, &$sectionBody, &$newVidCustomName, &$newVidCustomOrgName, &$sectionYouTube, &$sectionId);
                $updateSection = $dbhelper->processQuery("UPDATE web_page_section SET align=?, bgColor=?, bgimg=?, bgMobileImg=?, heading=?, subheading=?, section_paragraph=?, hasForm=?, section_body=?, videoimg=?, videoimgorgname=?, ytvideo=?, updatedate = NOW() WHERE pkid = ?", "sssssssissssi", $sectionParams);

                if($updateSection){
                  foreach($_POST['section-'.($key+1).'-btn'] as $secBtnId){
                     $getBtnText =  $_POST['section-'.($key+1).'-btn-text-'.$secBtnId];
                     $sectionBtnText = empty($getBtnText) ? 'none' : $getBtnText;
                     $getBtnColor = $_POST['section-'.($key+1).'-btncolor-'.$secBtnId];
                     $sectionBtnColor = empty($getBtnColor) ? 'none' : $getBtnColor;
                     $btnOutbound = isset($_POST['section-'.($key+1).'-outbound-'.$secBtnId]) ? 1 : 0;
                     $getBtnUrl = $_POST['section-'.($key+1).'-btnurl-'.$secBtnId];
                     $btnUrl = empty($getBtnUrl) ? 'none' : $getBtnUrl;
                     $btnParams = array(&$sectionBtnText, &$sectionBtnColor, &$btnUrl, &$btnOutbound, &$sectionId, &$secBtnId);
                     $updateButton = $dbhelper->processQuery("UPDATE web_page_btn SET btn_text=?, btn_bg=?, btn_url=?, btn_target=?, updatedate = NOW() WHERE section_id = ? AND pkid = ?", "sssiii", $btnParams);
                  }
                  if($updateButton){
                    $updateColTotal = 0;
                    foreach($_POST['section-'.($key+1).'-column'] as $colNum => $colId){
                       $colBg = $_POST['section-'.($key+1).'-column-'.($colNum+1).'-color'];
                       $sectionColumn = $_POST['section-'.($key+1).'-column-'.($colNum+1).'-content'];
                       $colParams=array(&$colBg, &$sectionColumn, &$sectionId, &$colId);
                       $updateColumn = $dbhelper->processQuery("UPDATE web_page_column SET bgColor = ?, body=?, updated = NOW() WHERE section_id = ? AND pkid = ?", "ssii", $colParams);
                       if(!empty($sectionColumn)) $updateColTotal++;
                          $dbhelper->updateOne('UPDATE web_page_section SET numofcols = ? WHERE pkid = ?', 'ii', $updateColTotal, $sectionId);
                    }
                  }else{
                    header('Location: /admin/cmsmodel/page-module/pageWithSlides?error=Section-Button-Update-Failed&category='.$cmscat.'&page='.$page.$Parameter);
                    exit;
                  }
                }else{
                  header('Location: /admin/cmsmodel/page-module/pageWithSlides?error=Section-Update-Failed&category='.$cmscat.'&page='.$page.$Parameter);
                  exit;
                }
           }//close foreach section loop
         }//check sections total
         if($insertNewBtn || $updateColumn){
            header('Location: /admin/cmsmodel/page-module/pageWithSlides?pkid='.$pageId.'&category='.$cmscat.'&page='.$page.$Parameter);
            exit;
          }else{
            header('Location: /admin/cmsmodel/page-module/pageWithSlides?error=Add-New-Section-or-Section-Update-Failed&category='.$cmscat.'&page='.$page.$Parameter);
            exit;
          }
       }else{
         header('Location: /admin/cmsmodel/page-module/pageWithSlides?pkid='.$pageId.'&category='.$cmscat.'&page='.$page.$Parameter);
         exit;
       }//check if any sections
     }else{
        header('Location: /admin/cmsmodel/errorPage?reason=no-page-found');
        exit; 
     }//check slugurl
   }else{
    header('Location: /admin/');
    exit;
   }//check username
}else{
  header('Location: /admin/');
  exit;
}