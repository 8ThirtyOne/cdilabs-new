<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$updateMeta = false;
$updateHero = false;
$updateSection = false;
$updateButton = false;
$updateColumn = false;
$insertPage = false;
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
     $pageExists = $dbhelper->numOfRows("SELECT slugurl FROM web_page WHERE pkid = ? AND cat='applications'", 'i', $pageId);
     if($pageExists > 0){
       $title = $webhelper->RequestFilter("pagetitle", 200, false);
       $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
       $slugurl = $webhelper->RequestFilter("slugurl", 250, false);
       $cleanurl = str_replace($chars,"",$slugurl);
       $cleanurl = strtolower($cleanurl);
       $cleanurl = str_replace(" ","-",$cleanurl);
       $pagedesc = $webhelper->RequestFilter("pagedesc", 250, false);
       $updateMeta = $dbhelper->updateAll("UPDATE web_page SET title='$title', slugurl='$cleanurl', description='$pagedesc', updatedate = NOW() WHERE pkid = $pageId");
          $heroLayout = $webhelper->RequestFilter("herolayout", 10, false);
          $oldHeroDesktop = $webhelper->RequestFilter("oldHeroDesktop", 255, false);
          $oldHeroMobile = $webhelper->RequestFilter("oldHeroMobile", 255, false);
          $oldHeroOrgName = $webhelper->RequestFilter("oldHeroOrgName", 255, false);

          if($_FILES['herodesktop']['size'] == 0){
            $newHeroDesktopName = $oldHeroDesktop;
            $newHeroOrgName = $oldHeroOrgName;
          }else{
            $ext = pathinfo($_FILES['herodesktop']['name'], PATHINFO_EXTENSION);
            $webhelper->DeleteFile("/hero/applications/", $oldHeroDesktop);
            if($ext == 'mp4'){
              $newHeroDesktop = $webhelper->UploadFile("herodesktop", "/hero/applications/");
              $newHeroOrgName = $newHeroDesktop['orgfilename'];
            }else{
              $newHeroDesktop = $webhelper->UploadFile("herodesktop", "/hero/applications/", true);
              $newHeroOrgName = 'none';
            }
            $newHeroDesktopName = $newHeroDesktop["filename"];
          }
          if($_FILES['heromobile']['size'] == 0){
             $newMobileFileName = $oldHeroMobile;
          }else{
            $webhelper->DeleteFile("/hero/applications/", $oldHeroMobile);
            $newHeroMobile = $webhelper->UploadFile("heromobile", "/hero/applications/", true);
            $newMobileFileName = $newHeroMobile["filename"];
          }

          $heroSubtitle = $webhelper->RequestFilter("herosubtitle", 100, true);
          $heroTitle = $webhelper->RequestFilter("herotitle", 100, true);
          $heroParagraph = $webhelper->RequestFilter("heroparagraph", -1, true);
          $heroBtnText = $webhelper->RequestFilter("herosectionbtn", 60, false);
          $heroBtnUrl = $webhelper->RequestFilter("herotargeturl", 255, false);
          $heroBtnTarget= isset($_POST['hero-outbound']) ? 1 : 0;
          $updateHero = $dbhelper->updateWebPageHero($heroLayout, $newHeroDesktopName, $newHeroOrgName, $newMobileFileName, $heroSubtitle, $heroTitle, $heroParagraph, $heroBtnText, $heroBtnUrl, $heroBtnTarget, $pageId);
          if(isset($_POST['new-section']) && $_POST['new-section'] > 0){
              $newSectionPos = $webhelper->RequestFilter('new-section', 0, false);
              $newLayout = $webhelper->RequestFilter("new-layout", 10, false);
              $newLayout = $newLayout > 0 ? $newLayout : 'left';
              $newBgColor = $webhelper->RequestFilter("new-bgcolor", 60, false);
              $newBgColor = $newBgColor > 0 ? $newBgColor : 'none';
              $newColNum =  $webhelper->RequestFilter("new-colnum", 0, false);
              $newHeading = $webhelper->RequestFilter("new-section-heading", -1, true);
              $newHeading = !empty($newHeading) ? $newHeading : 'none';
              $newSubheading = $webhelper->RequestFilter("new-section-subheading", -1, true);
              $newSubheading = !empty($newSubheading) ? $newSubheading : 'none';
              $newSectionPara = $webhelper->RequestFilter("new-section-paragraph", -1, true);
              $newSectionBody = $webhelper->RequestFilter("new-section-body", -1, true);
              $newYouTube = $webhelper->RequestFilter("new-section-youtubeurl", 20, false);
              $newYouTube = !empty($newYouTube) ? $newYouTube : 'none';
              
              if($_FILES['new-section-bgimg']['size'] == 0){
                $newSectionBgImg['filename'] = 'none';
              }else{
                $newSectionBgImg = $webhelper->UploadFile("new-section-bgimg", "/applications/", true);
              }
              if($_FILES['new-section-bgmobile']['size'] == 0){
                $newSectionMobileImg['filename'] = 'none';
              }else{
                $newSectionMobileImg = $webhelper->UploadFile("new-section-bgmobile", "/applications/", true);
              }
              $extCustom = pathinfo($_FILES['new-section-videocustom']['name'], PATHINFO_EXTENSION);
              if($_FILES['new-section-videocustom']['size'] == 0){
                $newVideoCustom['filename'] = 'none';
                $newVideoCustom['orgfilename'] = 'none';
              }else{
                if($extCustom == 'mp4'){
                  $newVideoCustom = $webhelper->UploadFile("new-section-videocustom", "/applications/");
                }else{
                  $newVideoCustom = $webhelper->UploadFile("new-section-videocustom", "/applications/", true);
                }
              }
              $insertNewSection = $dbhelper->webPageSectionIn($pageId, $newLayout, $newBgColor, $newColNum, '', '', $newSectionBgImg['filename'], $newSectionMobileImg['filename'], $newHeading, $newSubheading, $newSectionPara, $newSectionBody, $newVideoCustom['filename'], $newVideoCustom['orgfilename'], $newYouTube, $newSectionPos);
              if($insertNewSection){
                $newSectionId = $dbhelper->getLastId();
                $updateNewSection = $dbhelper->updateAll("UPDATE web_page_section SET class_name = 'applications-$pageId-section-$newSectionId', id_name='applications-$pageId-section-$newSectionId', updatedate = NOW() WHERE pkid = '$newSectionId'");
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
                  $insertNewBtn = $dbhelper->webPageBtnIn($newSectionId, 'applications-section'.$newSectionId.'-btn global-btn'.$newBtnClass.' smooth-hover', 'applications-section-'.$newSectionId.'-btn-'.$newSectionPos, $newBtnText, $newBtnColor, $newBtnUrl, $newbtnOutbound);
                  if($insertNewBtn){
                    $newSecColTotal = 0;
                    foreach($_POST['new-section-column-content'] as $newColNum => $newContent){
                        $newColBg = $_POST['new-column-'.($newColNum+1).'-color'];
                        $insertNewCol = $dbhelper->webPageColIn($newSectionId, $newColBg, $newContent);
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
                $sectionDesktop = $webhelper->UploadFile("section-".($key+1)."-bgimg", "/applications/", true);
                if($sectionOldDesktop != 'none'){
                  $webhelper->DeleteFile("/applications/", $sectionOldDesktop);
                }
                $sectionDesktopNewName = $sectionDesktop["filename"];
              }else{
                $sectionDesktopNewName = $sectionOldDesktop;
              }
              $sectionOldMobile = $_POST['section-'.($key+1).'-oldBgMobile'];
              if($_FILES['section-'.($key+1).'-bgmobile']['size'] > 0){
                $sectionMobile = $webhelper->UploadFile("section-".($key+1)."-bgmobile", "/applications/", true);
                if($sectionOldMobile != 'none'){
                  $webhelper->DeleteFile("/applications/", $sectionOldMobile);
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
              $sectionPara = empty($getPara) ? 'none' : $getPara;
              $getBody =  $_POST['section-'.($key+1).'-body'];
              $sectionBody = empty($getBody) ? 'none' : $getBody;
              $oldVideoImgCustom = $_POST['section-'.($key+1).'-oldVideoCustom'];
              $oldVideoImgCustomOrg = $_POST['section-'.($key+1).'-oldVideoCustomOrg'];
              if($_FILES['section-'.($key+1).'-videocustom']['size'] == 0){
                $newVidCustomName = $oldVideoImgCustom;
                $newVidCustomOrgName = $oldVideoImgCustomOrg;
              }else{
                $vcExt = pathinfo($_FILES['section-'.($key+1).'-videocustom']['name'], PATHINFO_EXTENSION);
                $webhelper->DeleteFile("/applications/", $oldVideoImgCustom);
                if($vcExt == 'mp4'){
                  $newVidCustom = $webhelper->UploadFile("section-".($key+1)."-videocustom", "/applications/");
                  $newVidCustomOrgName = $newVidCustom['orgfilename'];
                }else{
                  $newVidCustom = $webhelper->UploadFile("section-".($key+1)."-videocustom", "/applications/", true);
                  $newVidCustomOrgName = 'none';
                }
                $newVidCustomName = $newVidCustom["filename"];
              }
              $getYouTube = $_POST['section-'.($key+1).'-youtubeurl'];
              $sectionYouTube = empty($getYouTube) ? 'none' : $getYouTube;
              $updateSection = $dbhelper->updateWebPageSection($sectionLayout, $sectionBg, $sectionDesktopNewName, $sectionMobileNewName, $sectionHeading, $sectionSubheading, $sectionPara, $sectionBody, $newVidCustomName, $newVidCustomOrgName, $sectionYouTube, $sectionId);
              if($updateSection){
                foreach($_POST['section-'.($key+1).'-btn'] as $secBtnId){
                   $getBtnText =  $_POST['section-'.($key+1).'-btn-text-'.$secBtnId];
                   $sectionBtnText = empty($getBtnText) ? 'none' : $getBtnText;
                   $getBtnColor = $_POST['section-'.($key+1).'-btncolor-'.$secBtnId];
                   $sectionBtnColor = empty($getBtnColor) ? 'none' : $getBtnColor;
                   $btnOutbound = isset($_POST['section-'.($key+1).'-outbound-'.$secBtnId]) ? 1 : 0;
                   $getBtnUrl = $_POST['section-'.($key+1).'-btnurl-'.$secBtnId];
                   $btnUrl = empty($getBtnUrl) ? 'none' : $getBtnUrl;
                   $updateButton = $dbhelper->updateWebPageBtn($sectionBtnText, $sectionBtnColor, $btnUrl, $btnOutbound, $sectionId, $secBtnId);
                }
                if($updateButton){
                  $updateColTotal = 0;
                  foreach($_POST['section-'.($key+1).'-column'] as $colNum => $colId){
                     $colBg = $_POST['section-'.($key+1).'-column-'.($colNum+1).'-color'];
                     $sectionColumn = $_POST['section-'.($key+1).'-column-'.($colNum+1).'-content'];
                     $updateColumn = $dbhelper->updateWebPageColumn($colBg, $sectionColumn, $sectionId, $colId);
                     if(!empty($sectionColumn)) $updateColTotal++;
                        $dbhelper->updateOne('UPDATE web_page_section SET numofcols = ? WHERE pkid = ?', 'ii', $updateColTotal, $sectionId);
                  }
                }else{
                  header('Location: /admin/applications/list?error=Section-Button-Update-Failed');
                  exit;
                }
              }else{
                header('Location: /admin/applications/list?error=Section-Update-Failed');
                exit;
              }
           }//close foreach section loop
           if($insertNewBtn || $updateColumn){
              header('Location: /admin/applications/list');
              exit;
            }else{
              header('Location: /admin/applications/list?error=Add-New-Section-or-Section-Update-Failed');
              exit;
            }
     }else{
      header('Location: /admin/applications/list');
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