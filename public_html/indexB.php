<?php
include_once('../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/";
$PageCode = "000000";
$bodyid = "main";
$bodyClass= "clear-header";
$PageName = "HOME";
$formId = "contact-form";
$FormSubject = "New Lead from US website";
$FormTitle = "New Web Lead / Inquiry";
$FormCat = "request";
$pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl=? AND cat='main'", 's', 'home');
$pageInfo = $dbhelper->RunSQLReturnOneRow("SELECT title, description FROM web_page WHERE pkid ='$pageId' AND cat='main'");
$slides = $dbhelper->selectAll("SELECT * FROM web_page_hero WHERE page_id = '$pageId' AND status = 1 ORDER BY hero_pos ASC");
$banner = $dbhelper->selectAll("SELECT type, title, eventurl as slugurl, NULL AS url,                              startmonth AS month, startday AS day, endday, year
                                FROM events WHERE status = 1 AND isSlide = 1
                                AND CONCAT(year, '-', endmonth, '-', endday) >= CURDATE()
                                UNION
                                SELECT type, title, slugurl, url, month, day, 
                                NULL AS endday, year
                                FROM articles WHERE status = 1 AND isSlide = 1
                                ORDER BY year DESC, month DESC, day DESC");
//CHANGE SECTION STATUS TO 1
$pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = '$pageId' ORDER BY position ASC");
$formInc = $dbhelper->numOfRows("SELECT pkid FROM page_form_lookup WHERE page_id = ?", 'i', $pageId);
if($formInc > 0){
  $pageForm = $dbhelper->RunSQLReturnOneRow("SELECT * FROM page_form_lookup WHERE page_id = '$pageId'");
  $formId = $pageForm['form_name'];
  $_SESSION['formset'] = true;
}
$publications = $dbhelper->selectAll("SELECT * FROM publications WHERE featured = 1 AND status = 1 ORDER BY year DESC, month DESC, day DESC");
$news = $dbhelper->selectAll("SELECT * FROM articles WHERE status = 1 ORDER BY year DESC, month DESC, day DESC LIMIT 4");
$events = $dbhelper->selectAll("SELECT * FROM events WHERE status = 1 ORDER BY year ASC, startmonth ASC, startday ASC LIMIT 4");
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $pageInfo['title']; ?></title>
<meta name="description" content="<?php echo $pageInfo['description']; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-sectionHide.php'); ?>
<style>
<?php 
foreach($slides as $key => $slideCss){
 $key++;
 $heroExt = pathinfo($slideCss["desktop"], PATHINFO_EXTENSION);
 if(!empty($slideCss["desktop"]) && $heroExt !='mp4'){
  echo "#main-hero .slide-$key{
        background-image: url('/files/hero/main/{$slideCss['desktop']}');
  }";
 }
  echo "@media all and (max-width: 845px) {
    #main-hero .slide-$key{background-image:url('/files/hero/main/{$slideCss['mobile']}');
  }}";
}
foreach($pageSection as $rowCss){
    if($rowCss['bgimg'] != 'none' && $rowCss['bgMobileImg'] != 'none'){
      echo "#main-$pageId-section-{$rowCss['pkid']}{
        background-image: url('/files/main/{$rowCss['bgimg']}');
      }";
      echo "@media all and (max-width: 845px) {
        #main-$pageId-section-{$rowCss['pkid']}{background-image:url('/files/main/{$rowCss['bgMobileImg']}');
      }}";
    }
}
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/headerB.php'); ?>
<main role="main">
   
    <section class="hero-section tall-hero slider" id="main-hero">

     <?php 
       foreach($slides as $sKey => $slide){
         $sKey++;
         if($sKey == 1){
           $playing = 'playing';
           $fadeOut = '';
         }else{
           $playing = '';
           $fadeOut = 'fade-out';
         }
         $target = $slide['btn_target'] == 0 ? '' : "target='_blank'";
         echo "<div class='slide slide-$sKey $fadeOut $playing'>";
     ?>

         <div class='page-inner'>

         <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/cdilabs-watermark-logo.php');

               echo "<section class='{$slide['align']}-hero-content'>";
       
                    if($slide['subheading'] != 'none') echo "<p class='subtitle'>{$slide['subheading']}</p>";
                    if($slide['heading'] != 'none') echo "<h1>{$slide['heading']}</h1>";
                    if($slide['paragraph'] != 'none') echo "{$slide['paragraph']}";
                    if($slide['btn_text'] != 'none' && $slide['btn_url'] != 'none') echo "<a href='{$slide['btn_url']}' $target class='global-btn smooth-hover'>{$slide['btn_text']}</a>";

               echo "</section>";
         ?>

         </div>

     <?php 
         echo "</div>";
       } 
     ?>

      <div class="slide-nav-wrap">

        <div class="page-inner">

          <div class="slide-nav"></div>

        </div>

      </div>

    </section>   
    
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/press-sticker.php');

    foreach ($pageSection as $section){
           $lazy = '';
           $sectionId = $section['pkid'];
           $sectionAlign = $section['align'];
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

           echo "<section class='wide-section {$section['class_name']} $sectionBg$videoSection $formSection section-margins' id='{$section['id_name']}' $lazy >";

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
                       echo "<div class='custom-video'><img src='/files/main/{$section['videoimg']}' /></div>";
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
                if($sectionId == 107){
                    echo "<div class='center-paragraph footnote'>
                          <p><svg viewBox='0 0 30.31 30.44'><title lang='en'>CDI Labs Canada</title><desc>Canada Flag</desc><defs><path id='CAFID_1_' d='M29.4 25.83c0 2-1.64 3.63-3.63 3.63H4.57c-2 0-3.63-1.64-3.63-3.63V4.63C.94 2.63 2.58 1 4.57 1h21.2c2 0 3.63 1.64 3.63 3.63v21.2z'/></defs><use xlink:href='#CAFID_1_' class='caf2'/><clipPath id='CAFID_00000019663224982801303200000007939510897080060301_'><use xlink:href='#CAFID_1_' class='caf3'/></clipPath><g class='caf4'><path d='M-.46-.39h7.35v31.25H-.46zM23.44-.39h7.35v31.25h-7.35zM21.38 15.51l-.62-.3c-.27-.1-.2-.26-.1-.64l.46-1.72-1.73.38a.272.272 0 0 1-.31-.19l-.22-.81-1.37 1.6c-.19.25-.59.25-.47-.34l.58-3.24-.78.42c-.22.13-.44.15-.56-.08l-1.08-2.11-1.08 2.11c-.12.23-.34.21-.56.08l-.78-.42.58 3.24c.12.59-.27.59-.47.34l-1.37-1.6-.22.81c-.03.11-.14.22-.31.19l-1.73-.38.46 1.72c.1.38.17.54-.1.64l-.62.3 2.98 2.52c.12.1.18.27.14.42l-.26.89c1.03-.12 1.95-.23 2.97-.36.09 0 .24.08.24.19l-.14 3.27h.5l-.08-3.26c0-.11.14-.2.23-.2 1.03.12 1.95.23 2.97.36l-.26-.89c-.04-.15.02-.33.14-.42l2.97-2.52z' class='caf1'/></g></svg><small>VirScan, HuScan and MouseScan are provided exclusively by CDI Labs Canada.</small></p>

                    </div>";
                   }
            }
         }

       echo "</section>";

     } 

     include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/section-slides/customer-quote.php');
    ?>

    <section id="contact-form-section" class="wide-section form-section hide-section" data-info="lazy-load">
 
      <div class="page-inner">

        <h2>Ask about our seromics products and services</h2>

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/forms/contact-form.php'); ?>

      </div>

    </section>

    <?php if(!empty($publications)){ ?>

      <section class="wide-section section-slider listing-section hide-section no-margin" id="publications-slide" data-info="lazy-load">

      <div class="page-inner">

        <div class="featured-title">

          <h3>Featured Publications</h3>

          <a href="/resources/publications" class="paragraph-link smooth-hover">View all publications<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

        </div>

      <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/section-slides/pubs.php'); ?>

        <div class="slide-nav"></div>

      </div>

    </section>

    <?php }
 
    if(!empty($news)){ ?>

    <section class="wide-section section-slider listing-section hide-section no-margin" id="news-slide" data-info="lazy-load">

      <div class="page-inner">

        <div class="featured-title">

          <h3>News</h3>

          <a href="/news-events/news" class="paragraph-link smooth-hover">View all news<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

        </div>

      <?php
       $newsCount = 1;
       foreach(array_chunk($news, 2) as $group){
          $nSlide = $newsCount > 1 ? ' slide-'.$newsCount.' fade-out' : ' slide-'.$newsCount.' playing';
          echo "<div class='slide$nSlide'>";
            echo "<div class='card-layout card2-wrapper'>";
            foreach($group as $nRow){
              $newsCat = $nRow['type'] == 1 ? 'News' : 'Press Release'; //Change this if more than 2 categories
              if($nRow['type']== 1){
                $newsCat = 'News';
                $newsUrl = $nRow['filename'] == 'none' ? "target='_blank' href='" . $nRow['url'] . "'" : "href='/content/articles/" . $nRow['slugurl'] . "'";
              }
              if($nRow['type'] == 2){
                $newsCat = 'Press Release';
                $newsUrl = "href='/news-events/" . $nRow['slugurl'] . "'";
              } ?>
              <article>
                <div class="left news-thumb">
                  <ul>
                    <li><?php echo $webhelper->GetMonthShortName($nRow["month"]).' '; ?><span><?php echo ltrim($nRow['day'],'0'); ?></span></li>
                    <li>|</li>
                    <li><?php echo $nRow["year"]; ?></li>
                  </ul>
                  <picture>
                     <source class="lazy" srcset="/img/common/placeholder2.jpg" data-lazy="/files/news/<?php echo $nRow["thumbnail"]; ?>" media="(min-width: 1200px)">
                     <img class="lazy" src="/img/common/placeholder2.jpg" data-lazy="/files/news/<?php echo $nRow["thumbnail"]; ?>" width="250" height="150" alt="<?php echo $nRow['source']; ?>" />
                  </picture>

                </div>
                <div class="left news-info">
                  <?php 
                  echo '<p>'.$newsCat.'</p>';
                  echo '<h4>'.$nRow['title'].'</h4>'; 
                  echo "<a $newsUrl class='paragraph-link smooth-hover'>Read More<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>";
                  ?>
                </div>
              </article>
          <?php } ?>
          </div>

        </div>
        <?php $newsCount++; } ?>

        <div class="slide-nav"></div>

      </div>

    </section>

    <?php }

    if(!empty($events)){ ?>

    <section class="wide-section listing-section hide-section no-margin" id="events-section" data-info="lazy-load">

      <div class="page-inner">

        <div class="listing-heading">

          <h3>Upcoming Events</h3>

          <p>Join us at these upcoming events.</p>

          <a href="/news-events/events" class="paragraph-link smooth-hover">View all events<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

        </div>

        <div class="card-layout card4-wrapper">

        <?php 
          foreach($events as $eRow){ 
            $eventUrl = $eRow['eventurl'];
            switch($eRow['type']){
              case 1:
                  $cat = 'Conference';
                  break;
              case 2:
                  $cat = 'Meeting';
                  break;
              case 3:
                  $cat = 'Webinar';
                  break;
            }
        ?>

          <div class="column-box">

            <div class="event-box">
              <p><?php echo strtoupper($cat); ?></p>
              <ul>
                <li><?php echo $webhelper->GetMonthShortName($eRow["startmonth"]).' '; ?><span><?php echo ltrim($eRow['startday'],'0'); ?></span></li>
                <li>-</li>
                <li><?php echo $webhelper->GetMonthShortName($eRow["endmonth"]).' '; ?><span><?php echo ltrim($eRow['endday'],'0'); ?></span></li>
                <li><?php echo $eRow['address']; ?></li>
              </ul>
              <picture>
                 <source class="lazy" srcset="<?php echo cdn ?>/img/common/placeholder1.jpg" data-lazy="/files/events/<?php echo $eRow["thumbnail"]; ?>" media="(min-width: 1200px)">
                 <img class="lazy" src="<?php echo cdn ?>/img/common/placeholder1.jpg" data-lazy="/files/events/<?php echo $eRow["thumbnail"]; ?>" width="235" height="150" alt="<?php echo $eRow['title']; ?>" />
              </picture>

              <h4><?php echo $eRow['title']; ?></h4>

              <?php 
               if($eRow['type'] == 2 || $eRow['type'] == 3){
                 echo "<h5><span>ONLINE</span></h5>";
               }else{
                 echo "<h5>Booth <span>".$eRow['booth']."</span></h5>";
               }

               echo "<a href='/event/$eventUrl' class='paragraph-link smooth-hover'>More Info<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>";
               ?>
            </div>
          
          </div>

        <?php } ?>

        </div>

      </div>

    </section>

  <?php } ?>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scriptsHide.php'); ?>
<script>
if(document.getElementById('press-release')) document.getElementById('press-release').classList.add('show-it');
let video;let source;let captions;
<?php if(!$detect->isMobile() && !$detect->isTablet()){ 
  foreach($slides as $vKey => $sVideo){ 
    $vKey++;    
    $vExt = pathinfo($sVideo["desktop"], PATHINFO_EXTENSION);
    if(!empty($sVideo["desktop"]) && $vExt =='mp4'){
?>
    video = document.createElement("video");
    source = document.createElement("source"); 
    captions = document.createElement('track'); 
    source.src = '/files/hero/main/<?php echo $sVideo['desktop']; ?>';
    source.type = "video/mp4";
    video.autoplay = true;
    video.muted = true;
    video.playsinline = true;
    video.loop = true;
    video.setAttribute('aria-label', 'CDI Labs slide video <?php echo $vKey; ?>');
    video.setAttribute('id', 'hero-slide-video-<?php echo $vKey; ?>');
    captions.setAttribute('src','/media/videos/captions_slide_video_en.vtt');
    captions.setAttribute('kind','captions');
    captions.setAttribute('srclang','en');
    captions.setAttribute('label','english_captions');
    video.appendChild(source);
    video.appendChild(captions);
    document.querySelector('#main-hero .slide-<?php echo $vKey; ?>').prepend(video);
<?php 
    }
  }
?>

<?php } ?>

const slides = Array.from(document.querySelectorAll("#main-hero .slide"));
const slideNav = document.querySelector("#main-hero .slide-nav");
const slideBtn = "#main-hero .slide-btn";
const currSlide = "#main-hero .slide.playing";
const heroSlider = new Slider('#main-hero', slides, currSlide, slideNav, slideBtn, 'fade', 7000);
heroSlider.getPos();
heroSlider.playLoop();
heroSlider.setNav();
heroSlider.processNav();
heroSlider.currNavBtn();
heroSlider.setArrows();
heroSlider.getArrows();

const sliders = document.querySelectorAll('.section-slider');

sliders.forEach((slide, i) => {
 i > 0 ? slide.addEventListener("transitionend", trEnd) : trEnd(i);
});

function trEnd(e){
    if(e != 0){
      if(e.target === this){
        let sectionId = document.getElementById(this.id);
        let id = '#'+sectionId.getAttribute('id');
        sectionSlider(id, 10000);
        //if(sectionId=='customer-slider') this.removeEventListener("transitionend", trEnd);
      }
    }
    if(e == 0){
      id="#press-release";
      sectionSlider(id, 5000);
    }
}

function sectionSlider(id, time){
  const slides = Array.from(document.querySelectorAll(id+' .slide'));
  let slider = new Slider(id, slides, id+' .slide.playing' , document.querySelector(id+' .slide-nav'), id+' .slide-btn', 'fade', time);
  slider.getPos();
  slider.playLoop();
  slider.setNav();
  slider.currNavBtn();
  slider.processNav();
  slider.setArrows();
  slider.getArrows();
}

//---------------- CONTACT FORM ------------------//

const formId = "<?php echo $pageForm['form_name']; ?>";
const contactForm = document.getElementById(formId);
const contactInputs = document.querySelectorAll('#'+formId+' .get-value');
const contactBtn = document.getElementById('register-btn');

contactForm.addEventListener('submit', async event => {
  event.preventDefault();
  let isNotEmpty = true;
  if(document.getElementById('form-error')) document.getElementById('form-error').remove();
  var formError = document.createElement('p');
  formError.setAttribute('id', 'form-error');
  const errorNote = document.getElementById('form-note');
  contactInputs.forEach(field => {
    if(field.value.length === 0 || !field.value.trim()){
      field.style.boxShadow = 'inset 0 0 0 2px #FF5C00';
      isNotEmpty = false;
    }
  });
  var rcDiv = document.createElement('div');
  rcDiv.setAttribute('id', 'RecaptchaContact');
  contactBtn.after(rcDiv);
  var widgetId1 = grecaptcha.render('RecaptchaContact', {
      'sitekey' : '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback' : formSubmit,
      'size' : "invisible"
  });

  if(isNotEmpty){
    grecaptcha.execute(widgetId1);
  }else{
    const txt = document.createTextNode('Some required information is missing. Please review below.');
    formError.appendChild(txt);
    errorNote.append(formError);
    rcDiv.remove();
    grecaptcha.reset(widgetId1);
  }
});

async function formSubmit(){
  const url = '/support/process-contact-form';
  contactBtn.disabled = true;
  contactBtn.value = 'Please Wait';
  const formData = new FormData(contactForm);
  try {
    const response = await fetch(url, {
      method: 'post',
      body: formData
    });
    const result = await response.text();
    if(result == 0){
      processError('We have noticed an error. Please try again.');
    }else if(result == 2){
      processError('Please provide a valid email address.');
    }else if(result == 3){
      processError("The reCAPTCHA wasn't entered correctly. Please try again.");
    }else if(result == 4){
      processError('Some required info is missing.');
    }else{
      location.href = '/support/thank-you';
    }
  } catch (error) {
      processError('We have noticed an error. Please try again.');
  }
}

function processError(msg){
  var errorBox = document.createElement('p');
  errorBox.setAttribute('id', 'form-error');
  const note = document.getElementById('form-note');
  if(document.getElementById('RecaptchaContact')) document.getElementById('RecaptchaContact').remove();
    const txt = document.createTextNode(msg);
    errorBox.appendChild(txt);
    note.append(errorBox);
    contactBtn.disabled = false;
    contactBtn.value = 'Submit';
}

var x,i,j,l,ll,selElmnt,a,b,c;for(l=(x=document.getElementsByClassName("select-box")).length,i=0;i<l;i++){for(ll=(selElmnt=x[i].getElementsByTagName("select")[0]).length,(a=document.createElement("DIV")).setAttribute("class","select-selected"),a.innerHTML=selElmnt.options[selElmnt.selectedIndex].innerHTML,x[i].appendChild(a),(b=document.createElement("DIV")).setAttribute("class","select-items select-hide"),j=1;j<ll;j++)(c=document.createElement("DIV")).innerHTML=selElmnt.options[j].innerHTML,c.addEventListener("click",(function(e){var t,l,s,n,i,c,a;for(c=(n=this.parentNode.parentNode.getElementsByTagName("select")[0]).length,i=this.parentNode.previousSibling,l=0;l<c;l++)if(n.options[l].innerHTML==this.innerHTML){for(n.selectedIndex=l,i.innerHTML=this.innerHTML,a=(t=this.parentNode.getElementsByClassName("same-as-selected")).length,s=0;s<a;s++)t[s].removeAttribute("class");this.setAttribute("class","same-as-selected");break}i.click()})),b.appendChild(c);x[i].appendChild(b),a.addEventListener("click",(function(e){e.stopPropagation(),closeAllSelect(this),this.nextSibling.classList.toggle("select-hide"),this.classList.toggle("select-arrow-active")}))}function closeAllSelect(e){var t,l,s,n,i,c=[];for(t=document.getElementsByClassName("select-items"),l=document.getElementsByClassName("select-selected"),n=t.length,i=l.length,s=0;s<i;s++)e==l[s]?c.push(s):l[s].classList.remove("select-arrow-active");for(s=0;s<n;s++)c.indexOf(s)&&t[s].classList.add("select-hide")}document.addEventListener("click",closeAllSelect);
</script>
</body>
</html>
