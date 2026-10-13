<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['slugurl']) && !empty($_GET['slugurl'])){
    $dbhelper = new dbHelper('user');
    $webhelper = new WebHelper();
    $input = $webhelper->RequestFilter("slugurl", 255, false);
    $pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl = ? AND cat='applications'", 's', $input);
    if($pageId > 0){
        $PageUrl = "/applications/";
        $PageCode = "010105";
        $bodyid = "applications";
        $bodyClass= "clear-header";
        $pageInfo = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl, description FROM web_page WHERE pkid = $pageId AND cat='applications'");
        $PageName = $pageInfo['title'];
        $pageHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM web_page_hero WHERE page_id = $pageId");
        if($pageHero["desktop"] != 'none') $heroExt = pathinfo($pageHero["desktop"], PATHINFO_EXTENSION);
        $pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = $pageId ORDER BY position ASC");
        $FirstPageCode = substr($PageCode, 0, 2);
        $SecodeCode = substr($PageCode, 2, 2);
        $ThirdCode = substr($PageCode, 4, 2);
      $watermarkClass='';
      switch($pageInfo['slugurl']){
          case 'autoantibody-seromics':
              $watermarkIcon = 'Icon-CDI-Labs-Watermark-10.svg';
              $heroIcon = '';
              $catName = 'Antygen';
      }
    }else{
        header('Location: /404');
        exit;
    }
}else{
    header('Location: /');
    exit;
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $pageInfo['title']; ?> | CDI Labs</title>
<meta name="description" content="<?php echo $pageInfo['description']; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain.'/applications/'.$pageInfo['slugurl']; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
.hero-section{background-repeat:no-repeat;background-position:left top;background-size:cover}
<?php 
 if(!empty($pageHero["desktop"]) && $heroExt !='mp4'){
    $desktopHero = $pageHero["desktop"];
    echo ".hero-section{
        background-image: url('/files/hero/applications/$desktopHero');
    }";
 }
 if(!empty($pageHero["mobile"])){
    $desktopMobile = $pageHero["mobile"];
    echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/hero/applications/$desktopMobile');
    }}";
 }
foreach($pageSection as $rowCss){
    if($rowCss['bgimg'] != 'none' && $rowCss['bgMobileImg'] != 'none'){
      echo "#applications-$pageId-section-{$rowCss['pkid']}{
        background-image: url('/files/applications/{$rowCss['bgimg']}');
      }";
      echo "@media all and (max-width: 845px) {
        #applications-$pageId-section-{$rowCss['pkid']}{background-image:url('/files/applications/{$rowCss['bgMobileImg']}');
      }";
    }
}
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <?php
    $target = $pageHero['btn_target'] == 0 ? '' : "target='_blank'";
  echo "<section class='hero-section tall-hero applications-hero' id='{$pageInfo['slugurl']}'>

          <div class='page-inner'>";

          echo "<img src='/img/common/$watermarkIcon' class='cdilabs-watermark $watermarkClass' />

              <section class='{$pageHero['align']}-hero-content'>";
     
                  if(!empty($heroIcon)) echo "<img src='/img/common/$heroIcon' class='application-icon' />";
                  if($pageHero['subheading'] != 'none') echo "<p class='subtitle'>{$pageHero['subheading']}</p>";
                  echo "<h1>{$pageHero['heading']}</h1>";
                  if($pageHero['paragraph'] != 'none') echo "{$pageHero['paragraph']}";
                  if($pageHero['paragraph'] != 'none') echo "<a href='{$pageHero['btn_url']}' $target class='global-btn smooth-hover'>{$pageHero['btn_text']}</a>";

           echo "</section>

      </div>
 
  </section>";

     foreach ($pageSection as $section){
       $sectionId = $section['pkid'];
       $sectionBg = $section['bgColor'] == 'white' ? '' : $section['bgColor'].'-section ';
       if($section['align'] == 'center'){
          $layout = $section['align'].'-paragraph';
       }else{
          $layout = 'full-width';
       }
       if($section['videoimg'] == 'none' && $section['ytvideo'] == 'none'){
          $videoSection = '';
       }else{
          $videoSection = 'video-section';
       }
     ?>
     <section class="wide-section <?php echo $section['class_name'].' '.$sectionBg.$videoSection; ?> section-margins" id="<?php echo $section['id_name']; ?>">
           <div class="page-inner"> 

             <div class="<?php echo $layout; ?>">
               <h2><?php echo $section['heading']; ?></h2>
               <?php if($section['subheading'] != 'none') echo '<h3>'.$section['subheading'].'</h3>';
                 if($section['section_paragraph'] != 'none') echo $section['section_paragraph'];
                 if($section['ytvideo'] != 'none'){
                  echo "<div class='iframe-video'>
                   <iframe id='ytplayer'
                  src='https://www.youtube.com/embed/{$section['ytvideo']}?rel=0'></iframe>
              </div>";
                 }
               ?>
               <?php
               $buttons = $dbhelper->selectAll("SELECT * FROM web_page_btn WHERE section_id = '$sectionId'");
               foreach ($buttons as $btn){ 
                $btnUrl = $btn['btn_url'];
                $btnClass = $btn['btn_class'];
                $btnText = $btn['btn_text'];
                $btnTarget = $btn['btn_target'] == '_blank' ? 'target='.$btn['btn_target'] : '';
                if($btnText != 'none') echo "<a href='$btnUrl' class='global-btn $btnClass smooth-hover' $btnTarget>$btnText</a>";
                }
               ?>
             </div>
             <?php if($section['section_body'] != 'none') echo $section['section_body']; ?>
             <?php
               $sectionColumns= $dbhelper->selectAll("SELECT * FROM web_page_column WHERE section_id = '$sectionId'");
                 if(count($sectionColumns) > 0){ 
                 $colCounter = 1;
                 $colNum = $section['numofcols'];
                 echo "<div class='col-wrapper'>";
                 foreach ($sectionColumns as $col){
                   if(!empty($col['body'])){
                     echo "<div class='col$colNum'>
                             {$col['body']}
                           </div>";
                     $colCounter++;
                     }
                 } 
                 echo "</div>";
               }
              ?>

           </div>

     </section>
     <?php } ?>

      <section class="wide-section related-resources no-margin" id="related-literatures">

        <div class="section-footer">
          <?php $qText = isset($pageQuestion) ? $pageQuestion : 'Have any questions about our seromics applications and/or services?'; 
          echo "<h3>$qText</h3>"; ?>
          <a href="/company/contact-cdi" class="global-btn blue-btn smooth-hover">REQUEST INFO</a>
        </div>

        <?php 
           $literature = $dbhelper->selectAll("SELECT sub_category.cat_id, sub_category.cat_name, lit_cat_lookup.doc_id, literatures.pkid, literatures.type, literatures.title, literatures.slugurl, literatures.thumbnail, literatures.orgfilename, literatures.filename, literatures.body FROM sub_category, lit_cat_lookup, literatures WHERE sub_category.cat_name = '$catName' AND lit_cat_lookup.cat_id = sub_category.cat_id AND literatures.pkid = lit_cat_lookup.doc_id ORDER BY literatures.type");
           if($literature != null && count($literature) > 0){
           $total = count($literature);
           $narrow = $total < 4 ? ' narrow-section' : '';
           $col = $total > 1 && $total > 4 ? 4 : $total;
        ?>

        <div class="page-inner<?php echo $narrow; ?>">

             <div class="docs-wrap docs-wrap-<?php echo $col; ?>col left">

              <h3>Related Resources</h3>

              <?php 
              $num=0;
              foreach ($literature as $row){
                $fullTitle = $row["title"];
                $shortTitle = $webhelper->CurRightString($fullTitle, "107");
                $titleLength = strlen($fullTitle);
                if($titleLength > 50){
                   $endOfTitle = strrpos($shortTitle,' ');
                   $docTitle = substr($shortTitle,0,$endOfTitle).'...';
                }else{
                   $docTitle = $fullTitle;
                }
                $fileType = $webhelper->GetFileType($row["orgfilename"]);
                $fileSize = $webhelper->GetFileSize("/literatures/" . $row["filename"]);
                $litUrl = $fileType == 'PDF' ? "/inc/lib/download_literatures?pkid=".$row["pkid"]."&title=".$row["slugurl"] : cdn.'/files/literatures/'.$row["filename"];
                switch($row['type']){
                    case 1:
                        $docType = 'Brochure';
                        break;
                    case 2:
                        $docType = 'Flyer';
                        break;
                    case 3:
                        $docType = 'White Paper';
                        break;
                    case 4:
                        $docType = 'Poster';
                        break;
                    case 5:
                        $docType = 'Technical Doc';
                        break;
                    case 6:
                        $docType = 'Content';
                        break;
                }
                $shortDesc = $webhelper->CurRightString($row["body"],200);
                $endOfDesc = strrpos($shortDesc,' ');
                $abstract = substr($shortDesc,0,$endOfDesc).'...';
                if($num == 4){
                  $num = 1;
                  $colClear = 'col4-docs-start';
                }else if($num == 3){
                  $colClear = "col4-docs-outer";
                  $num++;
                }else{
                  $colClear = '';
                  $num++;
                }
              ?>

                <div class="docs col<?php echo $col.'-docs '.$colClear; ?> left">

                  <div class="docs-section left">
                    <?php echo "<p class='doc-type'><img class='pdf-icon' src='/img/common/file-text.svg' />".$docType."</p>"; ?>
                    <p class="support-file"><?php echo $fileType; ?> | <?php echo $fileSize; ?></p>
                     <div class="brochures-text left">
                       <h4><?php echo $docTitle; ?></h4>
                       <p class="doc-abstract"><?php if(!empty($abstract) && $abstract != 'none') echo $abstract;?></p>
                       <a href="<?php echo $litUrl; ?>" class="global-btn smooth-hover">VIEW | DOWNLOAD</a>
                     </div>
                  </div>

                </div>

             <?php
                  }
              ?>

          </div>

        <?php } ?>

     </section>

     <section class="wide-section related-resources no-margin" id="related-publications">

        <?php 
           $publications = $dbhelper->selectAll("SELECT sub_category.cat_id, sub_category.cat_name, pub_cat_lookup.pub_id, publications.pkid, publications.title, publications.link, publications.filename, publications.body FROM sub_category, pub_cat_lookup, publications WHERE sub_category.cat_name = '$catName' AND pub_cat_lookup.cat_id = sub_category.cat_id AND publications.pkid = pub_cat_lookup.pub_id");
           if($publications != null && count($publications) > 0){
           $totalPub = count($publications);
           $narrowPub = $totalPub < 4 ? ' narrow-section' : '';
           $pubCol = $totalPub > 1 && $totalPub > 4 ? 4 : $totalPub;
        ?>

        <div class="page-inner<?php echo $narrowPub; ?>">

             <div class="docs-wrap docs-wrap-<?php echo $pubCol; ?>col left">

              <?php 
              $pubNum=0;
              foreach ($publications as $rowPub){
                $pubTitle = $rowPub["title"];
                $shortPubTitle = $webhelper->CurRightString($pubTitle, "107");
                $pubTitleLength = strlen($pubTitle);
                if($pubTitleLength > 50){
                   $endOfPubTitle = strrpos($shortPubTitle,' ');
                   $pubDocTitle = substr($shortPubTitle,0,$endOfPubTitle).'...';
                }else{
                   $pubDocTitle = $pubTitle;
                }
                $pubUrl = $rowPub["filename"] == 'none' ? $rowPub['link'] : "/inc/lib/download_publications?pkid=".$rowPub["pkid"];
                $shortPubDesc = $webhelper->CurRightString($rowPub["body"],200);
                $endOfPubDesc = strrpos($shortPubDesc,' ');
                $pubAbstract = substr($shortPubDesc,0,$endOfPubDesc).'...';
                if($pubNum == 4){
                  $pubNum = 1;
                  $pubColClear = 'col4-docs-start';
                }else if($pubNum == 3){
                  $pubColClear = "col4-docs-outer";
                  $pubNum++;
                }else{
                  $pubColClear = '';
                  $pubNum++;
                }
              ?>

                <div class="docs col<?php echo $pubCol.'-docs '.$pubColClear; ?> left">

                  <div class="docs-section left">
                    <?php echo "<p class='doc-type'><img class='link-icon' src='/img/common/file-text.svg' />Publication</p>"; ?>
                     <div class="brochures-text left">
                       <h4><?php echo $pubDocTitle; ?></h4>
                       <p class="doc-abstract"><?php if(!empty($pubAbstract) && $pubAbstract != 'none') echo $pubAbstract;?></p>
                       <a href="<?php echo $pubUrl; ?>" class="global-btn smooth-hover">VIEW | DOWNLOAD</a>
                     </div>
                  </div>

                </div>

             <?php
                  }
              ?>

          </div>

        <?php } ?>

     </section>

     <section class="wide-section related-resources no-margin" id="related-videos">

        <?php 
           $videos = $dbhelper->selectAll("SELECT sub_category.cat_id, sub_category.cat_name, video_cat_lookup.video_id, videos.pkid, videos.type, videos.title, videos.slugurl, videos.body FROM sub_category, video_cat_lookup, videos WHERE sub_category.cat_name = '$catName' AND video_cat_lookup.cat_id = sub_category.cat_id AND videos.pkid = video_cat_lookup.video_id");
           if($videos != null && count($videos) > 0){
           $totalVideos = count($videos);
           $narrowVideos = $totalVideos < 4 ? ' narrow-section' : '';
           $videoCol = $totalVideos > 1 && $totalVideos > 4 ? 4 : $totalVideos;
        ?>

        <div class="page-inner<?php echo $narrowVideos; ?>">

             <div class="docs-wrap docs-wrap-<?php echo $videoCol; ?>col left">

              <?php 
              $videosNum=0;
              foreach ($videos as $rowVideo){
                $videoTitle = $rowVideo["title"];
                $shortVideoTitle = $webhelper->CurRightString($videoTitle, "107");
                $vidTitleLength = strlen($videoTitle);
                if($vidTitleLength > 50){
                   $endOfVidTitle = strrpos($shortVideoTitle,' ');
                   $videoDocTitle = substr($shortVideoTitle,0,$endOfVidTitle).'...';
                }else{
                   $videoDocTitle = $videoTitle;
                }
                $shortVideoDesc = $webhelper->CurRightString($rowVideo["body"],200);
                $endOfVideoDesc = strrpos($shortVideoDesc,' ');
                $videoAbstract = substr($shortVideoDesc,0,$endOfVideoDesc).'...';
                if($videosNum == 4){
                  $videosNum = 1;
                  $vidColClear = 'col4-docs-start';
                }else if($videosNum == 3){
                  $vidColClear = "col4-docs-outer";
                  $videosNum++;
                }else{
                  $vidColClear = '';
                  $videosNum++;
                }
                switch($rowVideo['type']){
                    case 1:
                        $videoType = 'Technology';
                        break;
                    case 2:
                        $videoType = 'Webinars';
                        break;
                    case 3:
                        $videoType = 'Events';
                        break;
                    case 4:
                        $videoType = 'Others';
                        break;
                    }
                ?>

                <div class="docs col<?php echo $videoCol.'-docs '.$vidColClear; ?> left">

                  <div class="docs-section left">
                    <?php echo "<p class='doc-type'><img class='film-icon' src='/img/common/film.svg' />".$videoType."</p>"; ?>
                     <div class="brochures-text left">
                       <h4><?php echo $videoDocTitle; ?></h4>
                       <p class="doc-abstract"><?php if(!empty($videoAbstract) && $videoAbstract != 'none') echo $videoAbstract;?></p>
                       <a href="/resources/videos/<?php echo $rowVideo["slugurl"]; ?>" class="global-btn smooth-hover">VIEW | DOWNLOAD</a>
                     </div>
                  </div>

                </div>

             <?php
                  }
              ?>

          </div>

        <?php } ?>

     </section>

</main>
 
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
<?php 
if(!$detect->isMobile() && !$detect->isTablet()){ 
   if($pageHero['desktop'] != 'none' && $heroExt == 'mp4'){
     $vid = $pageHero['desktop'];
?>
var video = document.createElement("video");
var source = document.createElement("source"); 
source.src = '/files/hero/applications/<?php echo $vid; ?>';
source.type = "video/mp4";
video.autoplay = true;
video.muted = true;
video.playsinline = true;
video.loop = true;
video.appendChild(source);
document.querySelector('.hero-section').prepend(video);
<?php 
    } 
}
?>
//----------- PROCESS MOBILE DIRECTIONAL DIAGRAM ARROWS ---------//
  let pos = 0;
  let timer;
  var winW = window.innerWidth;
  if(winW < 515){
    pos = 850 - winW;
  }else{
    pos = 910 - winW;
  }

  window.addEventListener("resize", function() {
    toggleDiagram();
  });

  function toggleDiagram(){
    pos = 0;
    winW = window.innerWidth;
    if(winW < 515){
      pos = 850 - winW;
    }else{
      pos = 910 - winW;
    }
    clearInterval(timer);
    document.querySelectorAll('.mobile-wrap').forEach((dm) => { 
      dm.style.transform = 'translateX(0)';
    });
  }

  document.querySelectorAll('.diagram-mobile-nav li').forEach(dnav => {
    dnav.addEventListener('click', function(e){
      e.preventDefault();
      var diagram = this.parentElement.parentElement.querySelector('.mobile-wrap');
      let coord = diagram.getBoundingClientRect();
      if(this.classList.contains('slide-left') && coord.x < 0){
        animate(diagram, '+', pos);
      }
      if(this.classList.contains('slide-right') && coord.x > 0){
        animate(diagram, '-', pos);
      }
    });
  });

function animate(elem, dir, limit){
    var cnt = 0;
    function frame(){
        cnt++;
        if(dir=='+') elem.style.transform = 'translateX(0)';
        if(dir=='-') elem.style.transform = 'translateX('+dir+cnt + 'px)';
        if(cnt == limit) clearInterval(timer);
    }
    timer = setInterval(frame, 10);
 }
</script>
</body>
</html>
