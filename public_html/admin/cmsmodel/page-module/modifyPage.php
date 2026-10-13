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
$deleteReqs = false;
$insertReqs = false;
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
     $pageExists = $dbhelper->numOfRows("SELECT slugurl FROM web_page WHERE pkid = ? AND cat='$cmscat'", 'i', $pageId);
     if($pageExists > 0){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       $Parameter = "&searchKey=$searchKey&order=$order";
       $title = $webhelper->RequestFilter("pagetitle", 200, false);
       $slugurl = $webhelper->RequestFilter("slugurl", 250, false);
       $cleanurl = $webhelper->validSlugUrl($slugurl);
       $pagedesc = $_POST['pagedesc'];
       $pageParams = array(&$title, &$cleanurl, &$pagedesc, &$pageId);
       $updateMeta = $dbhelper->processQuery("UPDATE web_page SET  title=?, slugurl=?, description=?, updatedate = NOW() WHERE pkid = ?", "sssi", $pageParams);
       //First delete lit id from lookup table
       $deleteReqs = $dbhelper->deleteAll("DELETE FROM web_page_sample_req WHERE page_id = '$pageId'");
        //then check if any are selected
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

        $heroLayout = $webhelper->RequestFilter("herolayout", 10, false);
        $oldHeroDesktop = $webhelper->RequestFilter("oldHeroDesktop", 255, false);
        $oldHeroMobile = $webhelper->RequestFilter("oldHeroMobile", 255, false);
        $oldHeroOrgName = $webhelper->RequestFilter("oldHeroOrgName", 255, false);

          if($_FILES['herodesktop']['size'] == 0){
            $newHeroDesktopName = $oldHeroDesktop;
            $newHeroOrgName = $oldHeroOrgName;
          }else{
            $ext = pathinfo($_FILES['herodesktop']['name'], PATHINFO_EXTENSION);
            $webhelper->DeleteFile("/hero/".$cmscat."/", $oldHeroDesktop);
            if($ext == 'mp4'){
              $newHeroDesktop = $webhelper->UploadFile("herodesktop", "/hero/".$cmscat."/");
              $newHeroOrgName = $newHeroDesktop['orgfilename'];
            }else{
              $newHeroDesktop = $webhelper->UploadFile("herodesktop", "/hero/".$cmscat."/", true);
              $newHeroOrgName = 'none';
            }
            $newHeroDesktopName = $newHeroDesktop["filename"];
          }
          if($_FILES['heromobile']['size'] == 0){
             $newMobileFileName = $oldHeroMobile;
          }else{
            $webhelper->DeleteFile("/hero/".$cmscat."/", $oldHeroMobile);
            $newHeroMobile = $webhelper->UploadFile("heromobile", "/hero/".$cmscat."/", true);
            $newMobileFileName = $newHeroMobile["filename"];
          }
          $heroSubtitle = $webhelper->RequestFilter("herosubtitle", 100, true);
          $heroSubtitle = !empty($heroSubtitle) ? $heroSubtitle : 'none';
          $heroTitle = $webhelper->RequestFilter("herotitle", 100, true);
          $heroTitle = !empty($heroTitle) ? $heroTitle : 'none';
          $heroParagraph = !empty($_POST['heroparagraph']) ? $_POST['heroparagraph'] : 'none';
          $heroBtnText = $webhelper->RequestFilter("herosectionbtn", 60, false);
          $heroBtnText = !empty($heroBtnText) ? $heroBtnText : 'none';
          $heroBtnUrl = $webhelper->RequestFilter("herotargeturl", 255, false);
          $heroBtnUrl = !empty($heroBtnUrl) ? $heroBtnUrl : 'none';
          $heroBtnTarget= isset($_POST['hero-outbound']) ? 1 : 0;
          $heroPos = 1;
          $heroHeight = $webhelper->RequestFilter("heroheight", 10, false);
          $heroBg = $webhelper->RequestFilter("herobg", 20, false);

          $heroParams = array(&$heroLayout, &$newHeroDesktopName, &$newHeroOrgName, &$newMobileFileName, &$heroSubtitle, &$heroTitle, &$heroParagraph, &$heroBtnText, &$heroBtnUrl, &$heroBtnTarget, &$heroPos, &$heroHeight, &$heroBg, &$pageId);
          $updateHero = $dbhelper->processQuery("UPDATE web_page_hero SET align=?, desktop=?, orgfilename=?, mobile=?, subheading=?, heading=?, paragraph=?, btn_text=?, btn_url=?, btn_target=?, hero_pos=?, height=?, bg=?, updated = NOW() WHERE page_id = ?", "sssssssssiissi", $heroParams);

          if(isset($_POST['new-section']) && $_POST['new-section'] > 0){
              $newSectionPos = $webhelper->RequestFilter('new-section', 0, false);
              $newLayout = $webhelper->RequestFilter("new-layout", 10, false);
              $newLayout = $newLayout > 0 ? $newLayout : 'left';
              $newBgColor = $webhelper->RequestFilter("new-bgcolor", 60, false);
              $newBgColor = $newBgColor > 0 ? $newBgColor : 'none';
              $newColNum =  $webhelper->RequestFilter("new-colnum", 0, false);
              $newHeading = $_POST['new-section-heading'];
              $newHeading = !empty($newHeading) ? $newHeading : 'none';
              $newSubheading = $_POST['new-section-subheading'];
              $newSubheading = !empty($newSubheading) ? $newSubheading : 'none';
              $newSectionPara = $_POST['new-section-paragraph'];
              $newSectionPara = !empty($newSectionPara) ? $newSectionPara : 'none';
              $newSectionIncForm = isset($_POST['new-section-includeform']) ? 1 : 0;
              $newSectionBody = $_POST['new-section-body'];
              $newSectionBody = !empty($newSectionBody) ? $newSectionBody : 'none';
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
                  $newBtnText = $_POST['new-section-btn-text'];
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
           $totalSections = count($_POST['section']);
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
                  header('Location: /admin/cmsmodel/page-module/list?error=Section-Button-Update-Failed&category='.$cmscat.'&page='.$page.$Parameter);
                  exit;
                }
              }else{
                header('Location: /admin/cmsmodel/page-module/list?error=Section-Update-Failed&category='.$cmscat.'&page='.$page.$Parameter);
                exit;
              }
           }//close foreach section loop
           if($insertNewBtn || $updateColumn){
              header('Location: /admin/cmsmodel/page-module/list?category='.$cmscat.'&page='.$page.$Parameter);
              exit;
            }else{
              header('Location: /admin/cmsmodel/page-module/list?error=Add-New-Section-or-Section-Update-Failed&category='.$cmscat.'&page='.$page.$Parameter);
              exit;
            }
     }else{
      header('Location: /admin/cmsmodel/page-module/list?category='.$cmscat.'&page='.$page.$Parameter);
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