<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['url']) && !empty($_GET['url'])){
    $dbhelper = new dbHelper('user');
    $webhelper = new WebHelper();
    $input = $webhelper->RequestFilter("url", 255, false);
    $pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl = ? AND status = 1 AND cat='products'", 's', $input);
    if($pageId > 0){
        $PageCode = "020105";
        $bodyid = "products";
        $bodyClass= "clear-header";
        $pageInfo = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl, description FROM web_page WHERE pkid = $pageId AND cat='products'");
        $PageName = $pageInfo['title'];
        $PageTitle = $pageInfo['title'].' | CDI Labs';
        $metaDesc = $pageInfo['description'];
        $PageUrl = "products/".$pageInfo['slugurl'];
        $pageHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM web_page_hero WHERE page_id = $pageId");
        if($pageHero["desktop"] != 'none') $heroExt = pathinfo($pageHero["desktop"], PATHINFO_EXTENSION);
        $pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = $pageId AND status = 1 ORDER BY position ASC");
        $formInc = $dbhelper->numOfRows("SELECT pkid FROM page_form_lookup WHERE page_id = ?", 'i', $pageId);
        if($formInc > 0){
          $pageForm = $dbhelper->RunSQLReturnOneRow("SELECT * FROM page_form_lookup WHERE page_id = $pageId");
          $formId = $pageForm['form_name'];
        }
        $FormSubject = "";
        $FormTitle = "";
        $FirstPageCode = substr($PageCode, 0, 2);
        $SecodeCode = substr($PageCode, 2, 2);
        $ThirdCode = substr($PageCode, 4, 2);
      $watermarkClass='';
      switch($pageInfo['slugurl']){
          case 'huprot-microarray':
              $watermarkIcon = 'Icon-CDI-Labs-HuScan-10.svg';
              $watermarkClass='human-icon';
              $heroIcon = 'Icon-HuProt-Blue.svg';
              $heroIconAlt = 'HuProt Icon';
              $catName = 'HuProt';
              break;
          case 'vird-membrane-protein-array':
              $watermarkIcon = 'Icon-CDI-Labs-VirScan-10.svg';
              $heroIcon = 'Icon-VirD-Green.svg';
              $heroIconAlt = 'VirD Icon';
              $catName = 'VirD';
              $pageQuestion = 'Have any questions about our VirD array?';
              break;
          case 'huscan-phip-seq':
              $watermarkIcon = 'Icon-CDI-Labs-HuScan-10.svg';
              $watermarkClass='human-icon';
              $heroIcon = 'Icon-HuScan-Purple.svg';
              $catName = 'HuScan';
              break;
          case 'mousescan-phip-seq':
              $watermarkIcon = 'Icon-CDI-Labs-MouseScan-10.svg';
              $heroIcon = 'Icon-MouseScan-Purple.svg';
              $catName = 'MouseScan';
              break;
          case 'virscan-phip-seq':
              $watermarkIcon = 'Icon-CDI-Labs-VirScan-10.svg';
              $heroIcon = 'Icon-VirScan-Purple-Registered-01a.svg';
              $catName = 'VirScan';
              break;
      }
      if(isset($catName)){
         $resources = $dbhelper->selectAll("SELECT doc_id, null AS pub_id, null AS video_id, pkid, type, title, slugurl, null AS link, thumbnail, orgfilename, filename, body FROM sub_category, lit_cat_lookup, literatures WHERE sub_category.cat_name = '$catName' AND lit_cat_lookup.cat_id = sub_category.cat_id AND literatures.pkid = lit_cat_lookup.doc_id UNION 
          SELECT null AS doc_id, pub_id, null AS video_id, pkid, null AS type, title, slugurl, link, null AS thumbnail, null AS orgfilename, filename, body FROM sub_category, pub_cat_lookup, publications WHERE sub_category.cat_name = '$catName' AND pub_cat_lookup.cat_id = sub_category.cat_id AND publications.pkid = pub_cat_lookup.pub_id 
          UNION
          SELECT null AS doc_id, null AS pub_id, video_id, pkid, type, title, slugurl, null AS link, null AS thumbnail, null AS orgfilename, null AS filename, body FROM sub_category, video_cat_lookup, videos WHERE sub_category.cat_name = '$catName' AND video_cat_lookup.cat_id = sub_category.cat_id AND videos.pkid = video_cat_lookup.video_id");
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
<title><?php echo $PageTitle; ?> | CDI Labs</title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain.'/'.$PageUrl; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
.hero-section{background-repeat:no-repeat;background-position:left top;background-size:cover}
<?php 
 if(!empty($pageHero["desktop"]) && $heroExt !='mp4'){
    $desktopHero = $pageHero["desktop"];
    echo ".hero-section{
        background-image: url('/files/hero/products/$desktopHero');
    }";
 }
 if(!empty($pageHero["mobile"])){
    $desktopMobile = $pageHero["mobile"];
    echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/hero/products/$desktopMobile');
    }}";
 }
foreach($pageSection as $rowCss){
    if($rowCss['bgimg'] != 'none' && $rowCss['bgMobileImg'] != 'none'){
      echo "#products-$pageId-section-{$rowCss['pkid']}{
        background-image: url('/files/products/{$rowCss['bgimg']}');
      }";
      echo "@media all and (max-width: 845px) {
        #products-$pageId-section-{$rowCss['pkid']}{background-image:url('/files/products/{$rowCss['bgMobileImg']}');
      }}";
    }
}
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <?php
    $target = $pageHero['btn_target'] == 0 ? '' : "target='_blank'";
      echo "<section class='hero-section {$pageHero['height']}-hero products-hero' id='{$pageInfo['slugurl']}'>

              <div class='page-inner'>";

              echo "<img src='/img/common/$watermarkIcon' class='cdilabs-watermark $watermarkClass' alt='Product Watermark Icon' />

                  <section class='{$pageHero['align']}-hero-content'>
         
                      <img src='/img/common/$heroIcon' class='products-icon' alt='$heroIconAlt' />";
                      if($pageHero['subheading'] != 'none') echo "<p class='subtitle'>{$pageHero['subheading']}</p>";
                      echo "<h1>{$pageHero['heading']}</h1>";
                      if($pageHero['paragraph'] != 'none') echo "{$pageHero['paragraph']}";
                      if(!empty($pageHero['btn_text']) && $pageHero['btn_text'] != 'none') echo "<a href='{$pageHero['btn_url']}' $target class='global-btn smooth-hover'>{$pageHero['btn_text']}</a>";

               echo "</section>

          </div>
     
      </section>";

     foreach ($pageSection as $section){
       $lazy = '';
       $sectionId = $section['pkid'];
       $sectionAlign = $section['align'];
       $featuredCol = $sectionAlign == 'center' ? '' : 'featured-'.$sectionAlign;
       $colNum = $section['numofcols'];
       $sectionBg = $section['bgColor'] == 'white' ? '' : $section['bgColor'].'-section';
       $videoSection = '';
       $formSection = '';
       if($section['hasForm'] == 1 ){
         $formSection = ' hide-section form-section';
         $lazy = "data-info='lazy-load'";
       }
       if($section['videoimg'] != 'none' || $section['ytvideo'] != 'none'){
          $videoSection = ' hide-section video-section';
          $lazy = "data-info='lazy-load'";
          $ytid = $section['ytvideo'];
       }
       $OK = $section['heading'] == 'none' && $section['subheading'] == 'none' && $section['section_paragraph'] ? false : true;

       echo "<section class='wide-section {$section['class_name']} $featuredCol $sectionBg$videoSection $formSection section-margins' id='{$section['id_name']}' $lazy >";

               echo "<div class='page-inner'>";

                   if($OK){ //show center-paragraph if any content

                   echo "<div class='$sectionAlign-paragraph'>";

                     if($section['heading'] != 'none') echo '<h2>'.$section['heading'].'</h2>';
                     if($section['subheading'] != 'none') echo '<h3>'.$section['subheading'].'</h3>';
                     if($section['section_paragraph'] != 'none') echo $section['section_paragraph'];
                     if($section['ytvideo'] != 'none'){
                      echo "<div class='iframe-video' data-src='{$ytid}'></div>";
                     }
                     if($section['ytvideo'] == 'none' && $section['videoimg'] != 'none'){
                       echo "<div class='custom-video'><img src='/files/services/{$section['videoimg']}' /></div>";
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

                    echo "</div>";

                    }

                    if($section['section_body'] != 'none') echo $section['section_body'];

                    if($formInc > 0 && $section["hasForm"] == 1) include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/forms/".$pageForm['form_name'].".php");

               echo "</div>";

         if($colNum > 0){
            $sectionColumns= $dbhelper->selectAll("SELECT * FROM web_page_column WHERE section_id = '$sectionId'");
            if(count($sectionColumns) > 0){ 
               echo "<div class='page-inner card-layout card$colNum-wrapper'>";
                 $colCounter = 1;
                 foreach ($sectionColumns as $col){
                   if(!empty($col['body'])){
                     echo "<div class='column-box'>
                             {$col['body']}
                           </div>";
                     $colCounter++;
                     }
                 } 
                echo "</div>";
            }
         }

       echo "</section>";
     } 

     include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/section-slides/customer-quote.php');

     if(!empty($resources) && count($resources) > 0){
               echo "<section class='wide-section related-resources related-altbg no-margin'>
                   <div class='page-inner'>
                       <h3>Related Resources</h3>
                   </div>
               </section>";
               $total = count($resources);
               if($total > 3){
                $cardName = 'card4-wrapper';
               }else{
                $cardName = 'card'.$total.'-wrapper';
               }
              $num=0;
              foreach(array_chunk($resources, 4) as $group){
                $altbg = $num%2 == 0 ? 'related-altbg' : '';
              echo "<section class='wide-section related-resources $altbg no-margin'>";
              echo "<div class='page-inner card-layout $cardName docs-wrapper'>";
              foreach ($group as $key => $row){
                $docDir='';
                $slugUrl = $row['slugurl'];
                $outbound = '';
                if($row['doc_id'] != null){
                  $docName = "literatures";
                  $docDir = "/content/literatures/";
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
                }elseif($row['pub_id'] != null){
                  $docName = "publications";
                  $docType = "Publication";
                  if($row["filename"] == 'none'){
                    $slugUrl = $row['link'];
                    $outbound = 'target=_blank';
                  }else{
                    $slugUrl = "/content/publications/" . $row["slugurl"];
                  }
                }else{
                  $docName = "videos";
                  $docDir = "/resources/videos/";
                  switch($row['type']){
                    case 1:
                        $docType = 'Technology';
                        break;
                    case 2:
                        $docType = 'Webinars';
                        $docDir = "/resources/webinar/";
                        break;
                    case 3:
                        $docType = 'Events';
                        break;
                    case 4:
                        $videoType = 'Others';
                        break;
                  }
                }
                $fullTitle = $row["title"];
                $shortTitle = $webhelper->CurRightString($fullTitle, "107");
                $titleLength = strlen($fullTitle);
                if($titleLength > 50){
                   $endOfTitle = strrpos($shortTitle,' ');
                   $docTitle = substr($shortTitle,0,$endOfTitle).'...';
                }else{
                   $docTitle = $fullTitle;
                }
                $shortDesc = $webhelper->CurRightString($row["body"],200);
                $endOfDesc = strrpos($shortDesc,' ');
                $abstract = substr($shortDesc,0,$endOfDesc).'...';

                echo" <div class='document-box'>
                        <p class='doc-type left'><img class='pdf-icon' src='/img/common/file-text.svg' alt='pdf icon' />$docType</p>"; 
                        if($row["orgfilename"] != null){
                          $fileType = $webhelper->GetFileType($row["orgfilename"]);
                          $fileSize = $webhelper->GetFileSize("/".$docName."/" . $row["filename"]);
                          echo "<p class='support-file left'>$fileType | $fileSize</p>";
                        }
                        echo  "<div class='brochures-text left'>
                           <h4>$docTitle</h4>
                           <p class='doc-abstract'>$abstract</p>
                           <a href='$docDir$slugUrl' class='global-btn smooth-hover' $outbound>VIEW | DOWNLOAD</a>
                           </div>
                       </div>";
                }
                echo "</div>";
                echo "</section>";
                $num++;
             }
        } ?>

</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
if(document.getElementById("static-ticker"))document.getElementById("static-ticker").style.display='block';let timer,pos=0;var winW=window.innerWidth;pos=winW<515?850-winW:910-winW;<?php if(!$detect->isMobile() && !$detect->isTablet()){ if($pageHero['desktop'] != 'none' && $heroExt == 'mp4'){$vid = $pageHero['desktop']; ?>var video=document.createElement("video"),source=document.createElement("source");let captions=document.createElement("track");source.src="/files/hero/products/<?php echo $vid; ?>",source.type="video/mp4",video.autoplay=!0,video.muted=!0,video.playsinline=!0,video.loop=!0,video.setAttribute("aria-label","Product presentation video"),captions.setAttribute("src","/media/videos/captions_product_video_en.vtt"),captions.setAttribute("kind","captions"),captions.setAttribute("srclang","en"),captions.setAttribute("label","english_captions"),video.appendChild(source),video.appendChild(captions),document.querySelector(".hero-section").prepend(video);<?php } ?>function toggleDiagram(){pos=0,winW=window.innerWidth,winW<515?pos=850-winW:pos=910-winW,clearInterval(timer),document.querySelectorAll(".mobile-wrap").forEach((e=>{e.style.transform="translateX(0)"}))}window.addEventListener("resize",(function(){toggleDiagram()}));<?php } ?>function animate(e,t,a){var n=0;timer=setInterval((function(){n++,"+"==t&&(e.style.transform="translateX(0)"),"-"==t&&(e.style.transform="translateX("+t+n+"px)"),n==a&&clearInterval(timer)}),10)}document.querySelectorAll(".diagram-mobile-nav li").forEach((e=>{e.addEventListener("click",(function(e){e.preventDefault(),clearInterval(timer),document.querySelectorAll(".mobile-wrap").forEach((e=>{e.style.transform="translateX(0)"}));var t=this.parentElement.parentElement.querySelector(".mobile-wrap");let a=t.getBoundingClientRect();this.classList.contains("slide-left")&&a.x<0&&animate(t,"+",pos),this.classList.contains("slide-right")&&a.x>0&&animate(t,"-",pos)}))}));const sliders=document.querySelectorAll(".section-slider");function trEnd(e){sectionSlider("#"+document.getElementById(this.id).getAttribute("id"),13e3)}function sectionSlider(e,t){const r=Array.from(document.querySelectorAll(e+" .slide"));let n=new Slider(e,r,e+" .slide.playing",document.querySelector(e+" .slide-nav"),e+" .slide-btn","fade",t);n.getPos(),n.playLoop(),n.setNav(),n.currNavBtn(),n.processNav(),n.setArrows(),n.getArrows()}sliders.forEach(((e,t)=>{e.addEventListener("transitionend",trEnd)}));
</script>
</body>
</html>
