<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['slugurl']) && !empty($_GET['slugurl']) && isset($_GET['category']) && !empty($_GET['category'])){
	$dbhelper = new dbHelper('user');
	$webhelper = new WebHelper();
	$slugurl = $webhelper->RequestFilter("slugurl", 255, false);
  $cmscat = $webhelper->RequestFilter("category", 50, false);
    $pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl = ? AND cat='$cmscat'", 's', $slugurl);
  if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
    $input = $_SESSION['user'];
      if($input == 0){
        header('Location: /admin/');
        exit;
    }else{
      $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
      if(!empty($username)){
        if($pageId > 0){
          if($cmscat == 'main'){
            header('Location: /admin/cmsmodel/main-page/preview');
            exit;
          }
      		$PageUrl = "admin/cmsmodel/page-module/preview";
          $hasResources = false;
          switch($cmscat){
            case 'home':
              $PageCode = "000000";
              break;
            case 'applications':
              $PageCode = "010105";
              $hasResources = true;
              break;
            case 'company':
              $PageCode = "060101";
              break;
            case 'products':
              $PageCode = "020105";
              $hasResources = true;
              break;
            case 'services':
              $PageCode = "070105";
              $hasResources = true;
              break;
            case 'technical-notes':
              $PageCode = "040102";
              $hasResources = true;
              break;
          }
      		$bodyid = $cmscat;
      		$bodyClass= "clear-header";
          $FirstPageCode = substr($PageCode, 0, 2);
          $SecodeCode = substr($PageCode, 2, 2);
          $ThirdCode = substr($PageCode, 4, 2);

      		$pageInfo = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl, description FROM web_page WHERE pkid = $pageId AND cat='$cmscat'");
      		$PageName = $pageInfo['title'];
          $watermarkClass='cdilabs-watermark';
          $watermarkIcon='';
          $heroIcon='';
          $watermarkIcon = 'Icon-CDI-Labs-Watermark-10.svg';
          switch($pageInfo['slugurl']){
              case 'lab-services':
                $watermarkIcon = 'Icon-CDI-Labs-Watermark-Gray-01.svg';
                $heroIcon = '';
                $customerSlide = false;
              break;
              case 'autoantibody-seromics':
                  $watermarkIcon = 'Icon-CDI-Labs-Watermark-10.svg';
                  $heroIcon = '';
                  $catName = 'Antygen';
              case 'huprot-microarray':
                  $watermarkIcon = 'Icon-CDI-Labs-HuScan-10.svg';
                  $watermarkClass='human-icon';
                  $heroIcon = 'Icon-HuProt-Blue.svg';
                  $heroIconAlt = 'HuProt Icon';
                  $pageCatName = 'HuProt';
                  break;
              case 'vird-membrane-protein-array':
                  $watermarkIcon = 'Icon-CDI-Labs-VirScan-10.svg';
                  $heroIcon = 'Icon-VirD-Green.svg';
                  $heroIconAlt = 'VirD Icon';
                  $pageCatName = 'VirD';
                  $pageQuestion = 'Have any questions about our VirD array?';
                  break;
              case 'antibody-development':
                  $watermarkIcon = 'Icon-CDI-Labs-Watermark-10.svg';
                  $heroIcon = '';
                  $catName = 'Antygen';
                  break;
          }
      		$pageHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM web_page_hero WHERE page_id = $pageId");
      		if($pageHero["desktop"] != 'none') $heroExt = pathinfo($pageHero["desktop"], PATHINFO_EXTENSION);
      		$pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = $pageId ORDER BY position ASC");
          $formInc = $dbhelper->numOfRows("SELECT pkid FROM page_form_lookup WHERE page_id = ?", 'i', $pageId);
          if($formInc > 0){
            $pageForm = $dbhelper->RunSQLReturnOneRow("SELECT * FROM page_form_lookup WHERE page_id = $pageId");
            $formId = $pageForm['form_name'];
          }
          switch($formId){
            case 'grant-form':
              $FormSubject = "New Grant Program Submission";
              $FormTitle = 'New Grant Program Submission';
              break;
            case 'contact-form':
              $FormSubject = "New Lead from US website";
              $FormTitle = "New Web Lead / Inquiry";
              break;
          }

          $samplereqs = $dbhelper->selectAll("SELECT sample_requirements.pkid, sample_requirements.product, web_page_sample_req.req_id FROM sample_requirements, web_page_sample_req WHERE web_page_sample_req.page_id = '$pageId' AND sample_requirements.pkid = web_page_sample_req.req_id");

          $resources = $dbhelper->selectAll("SELECT doc_id, null AS pub_id, null AS video_id, pkid, type, title, slugurl, null AS link, thumbnail, orgfilename, filename, body FROM sub_category, lit_cat_lookup, literatures WHERE sub_category.cat_name = '$catName' AND lit_cat_lookup.cat_id = sub_category.cat_id AND literatures.pkid = lit_cat_lookup.doc_id UNION 
            SELECT null AS doc_id, pub_id, null AS video_id, pkid, null AS type, title, slugurl, link, null AS thumbnail, null AS orgfilename, filename, body FROM sub_category, pub_cat_lookup, publications WHERE sub_category.cat_name = '$catName' AND pub_cat_lookup.cat_id = sub_category.cat_id AND publications.pkid = pub_cat_lookup.pub_id 
            UNION
            SELECT null AS doc_id, null AS pub_id, video_id, pkid, type, title, slugurl, null AS link, null AS thumbnail, null AS orgfilename, null AS filename, body FROM sub_category, video_cat_lookup, videos WHERE sub_category.cat_name = '$catName' AND video_cat_lookup.cat_id = sub_category.cat_id AND videos.pkid = video_cat_lookup.video_id");
        
          $cmsCatTitle = ucfirst($cmscat);
        }else{
        	header('Location: /admin/cmsmodel/errorPage?reason=no-page-found');
          exit;
        }
      }else{
        header('Location: /admin/');
        exit;
      }
    }
  }else{
    header('Location: /admin/');
    exit;
  }
}else{
    header('Location: /404');
    exit;
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $pageInfo['title']; ?> | CDI Labs</title>
<meta name="description" content="<?php echo $pageInfo['description']; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-sectionHide.php'); ?>
<style>
.hero-section{background-repeat:no-repeat;background-position:left top;background-size:cover}
<?php 
 if(!empty($pageHero["desktop"]) && $heroExt !='mp4'){
 	$desktopHero = $pageHero["desktop"];
 	echo ".hero-section{
 		background-image: url('/files/hero/$cmscat/$desktopHero');
 	}";
 }
 if(!empty($pageHero["mobile"])){
 	$desktopMobile = $pageHero["mobile"];
 	echo "@media all and (max-width: 845px) {
 	.hero-section{background-image:url('/files/hero/$cmscat/$desktopMobile');
 	}}";
 }
foreach($pageSection as $rowCss){
    if($rowCss['bgimg'] != 'none' && $rowCss['bgMobileImg'] != 'none'){
      echo "#$cmscat-$pageId-section-{$rowCss['pkid']}{
        background-image: url('/files/$cmscat/{$rowCss['bgimg']}');
      }";
      echo "@media all and (max-width: 845px) {
        #$cmscat-$pageId-section-{$rowCss['pkid']}{background-image:url('/files/$cmscat/{$rowCss['bgMobileImg']}');
      }}";
    }
}
 ?>
 #searchBox{display:none} /*remove this*/
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 <main role="main">
 
   <?php
     if($pageHero["desktop"] != 'none' || $pageHero["heading"] != "none"){
     $target = $pageHero['btn_target'] == 0 ? '' : "target='_blank'";
     echo "<section class='hero-section {$pageHero['height']}-hero {$pageHero['bg']}-bg $cmscat-hero' id='{$pageInfo['slugurl']}'>

          <div class='page-inner'>";

          if(!empty($watermarkClass)){
            echo "<img src='/img/common/$watermarkIcon' class='cdilabs-watermark $watermarkClass' alt='$cmscat watermark icon' />";
          }

          echo "<section class='{$pageHero['align']}-hero-content'>";

                  if(!empty($heroIcon)) echo "<img src='/img/common/$heroIcon' class='$cmscat-icon' />";
                  if($pageHero['subheading'] != 'none') echo "<p class='subtitle'>{$pageHero['subheading']}</p>";
                  echo "<h1>{$pageHero['heading']}</h1>";
                  if($pageHero['paragraph'] != 'none') echo "{$pageHero['paragraph']}";
                  if(!empty($pageHero['btn_text']) && $pageHero['btn_text'] != 'none') echo "<a href='{$pageHero['btn_url']}' $target class='global-btn smooth-hover'>{$pageHero['btn_text']}</a>";

           echo "</section>

      </div>
 
     </section>";
    }

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

     if(!empty($samplereqs) && count($samplereqs) > 0){
        foreach($samplereqs as $sr){
          $sampleName = strtolower($sr['product']);
          include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/sample-req/'.$sampleName.'.php');
        }
     }

     if(!empty($resources) && count($resources) > 0){
               echo "<section class='wide-section related-resources related-altbg no-margin' id='related-title'>
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

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scriptsHide.php'); ?>
<script type='text/javascript' src="/js/custom.js"></script>
<script>
let pos = 0;
let timer;
var winW = window.innerWidth;
if(winW < 515){
  pos = 850 - winW;
}else{
  pos = 910 - winW;
}
if(document.getElementById("static-ticker")) document.getElementById("static-ticker").style.display='block';
<?php 
if(!$detect->isMobile() && !$detect->isTablet()){ 
   if($pageHero['desktop'] != 'none' && $heroExt == 'mp4'){
     $vid = $pageHero['desktop'];
?>
var video = document.createElement("video");
var source = document.createElement("source"); 
let captions = document.createElement('track');
source.src = "/files/hero/<?php echo $cmscat.'/'.$vid; ?>";
source.type = "video/mp4";
video.autoplay = true;
video.muted = true;
video.playsinline = true;
video.loop = true;
video.setAttribute('aria-label', '<?php echo $cmsCatTitle; ?> presentation video');
captions.setAttribute('src','/media/videos/captions_product_video_en.vtt');
captions.setAttribute('kind','captions');
captions.setAttribute('srclang','en');
captions.setAttribute('label','english_captions');
video.appendChild(source);
video.appendChild(captions);
document.querySelector('.hero-section').prepend(video);
<?php 
    } ?>
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
<?php 
}
?>

let heroBtn = document.querySelector('.hero-section .global-btn');
if(heroBtn){
  heroBtn.addEventListener('click', function(event){
      event.preventDefault();
      let newId = heroBtn.getAttribute('href').split('#');
      window.scrollTo(0, 0);
      let newContainer = document.getElementById(newId[1]).getBoundingClientRect();
      smoothScroll({yPos: newContainer.y - 120, duration: 500});
  });
}

const sliders = document.querySelectorAll('.section-slider');

sliders.forEach((slide, i) => {
 slide.addEventListener("transitionend", trEnd);
});

function trEnd(e){
        let sectionId = document.getElementById(this.id);
        let id = '#'+sectionId.getAttribute('id');
        sectionSlider(id, 10000);
        //if(sectionId=='customer-slide') this.removeEventListener("transitionend", trEnd);
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

//----------- PROCESS MOBILE DIRECTIONAL DIAGRAM ARROWS ---------//

  document.querySelectorAll('.diagram-mobile-nav li').forEach(dnav => {
    dnav.addEventListener('click', function(e){
      e.preventDefault();
      clearInterval(timer);
      document.querySelectorAll('.mobile-wrap').forEach((dm) => { 
        dm.style.transform = 'translateX(0)';
      });
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

//---------------- PROCESS FORM ------------------//

<?php if(!empty($pageForm) && $section["hasForm"] == 1){ ?>

const formId = "<?php echo $pageForm['form_name']; ?>";
const contactForm = document.getElementById(formId);
const contactInputs = document.querySelectorAll('#'+formId+' .get-value');
const contactBtn = document.getElementById('register-btn');

if(formId == 'grant-form'){
  document.getElementById('project-description').onkeyup = function () {
    document.getElementById('desc-count').innerHTML = "Characters left: " + (10000 - this.value.length);
  }
}

contactForm.addEventListener('submit', async event => {
  event.preventDefault();
  let isNotEmpty = true;
  if(document.getElementById('form-error')) document.getElementById('form-error').remove();
  var platformError = document.createElement('p');
  platformError.setAttribute('id', 'form-error');
  const platformNote = document.getElementById('form-note');
  let checkboxesWrapper = document.querySelector('.checkboxes-wrapper .fieldset-heading');
  let checkboxesTitle = checkboxesWrapper.textContent;
  contactInputs.forEach(field => {
    if(field.value.length === 0){
      field.style.border = '1px solid #e66b63';
      isNotEmpty = false;
    }
  });
  if(formId == 'grant-form'){
    document.querySelectorAll('.select-box .select-selected').forEach(sb => {
      if(sb.textContent === "Select One"){
        sb.style.border = '1px solid #e66b63';
        isNotEmpty = false;
      }
    });
  }
  var rcDiv = document.createElement('div');
  rcDiv.setAttribute('id', 'RecaptchaContact');
  contactBtn.after(rcDiv);
  var widgetId1 = grecaptcha.render('RecaptchaContact', {
      'sitekey' : '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback' : formSubmit,
      'size' : "invisible"
  });

  if(isNotEmpty){
    let platform = document.querySelectorAll('.checkboxes-wrapper input[type="checkbox"]');
    let checkedOne = Array.prototype.slice.call(platform).some(p => p.checked);
    if(checkedOne == false){
      const txt = document.createTextNode('Please select at least one '+checkboxesTitle);
      platformError.appendChild(txt);
      platformNote.append(platformError);
      rcDiv.remove();
      grecaptcha.reset(widgetId1);
    }else{
      if(formId == 'grant-form'){
        let consentChecked = document.getElementById('process-data').checked;
        if(consentChecked){
          grecaptcha.execute(widgetId1);
        }else{
          rcDiv.remove();
          grecaptcha.reset(widgetId1);
          const consentTxt = document.createTextNode('You must agree to CDI Labs privacy policies.');
          platformError.appendChild(consentTxt);
          platformNote.append(platformError);
        }
      }else{ 
        grecaptcha.execute(widgetId1); //process other forms
      }
    }
  }else{
    rcDiv.remove();
    grecaptcha.reset(widgetId1);
  }
});

async function formSubmit(){
  const url = "/support/process-<?php echo $pageForm['form_name']; ?>";
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
    }else if(result == 5){
      processError('Please select Sample Type.');
    }else if(result == 6){
      processError('You must agree to CDI Labs privacy policies.');
    }else{
      location.href = '/support/grant-program-thank-you';
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

<?php } ?>


var x,i,j,l,ll,selElmnt,a,b,c;for(l=(x=document.getElementsByClassName("select-box")).length,i=0;i<l;i++){for(ll=(selElmnt=x[i].getElementsByTagName("select")[0]).length,(a=document.createElement("DIV")).setAttribute("class","select-selected"),a.innerHTML=selElmnt.options[selElmnt.selectedIndex].innerHTML,x[i].appendChild(a),(b=document.createElement("DIV")).setAttribute("class","select-items select-hide"),j=1;j<ll;j++)(c=document.createElement("DIV")).innerHTML=selElmnt.options[j].innerHTML,c.addEventListener("click",(function(e){var t,l,s,n,i,c,a;for(c=(n=this.parentNode.parentNode.getElementsByTagName("select")[0]).length,i=this.parentNode.previousSibling,l=0;l<c;l++)if(n.options[l].innerHTML==this.innerHTML){for(n.selectedIndex=l,i.innerHTML=this.innerHTML,a=(t=this.parentNode.getElementsByClassName("same-as-selected")).length,s=0;s<a;s++)t[s].removeAttribute("class");this.setAttribute("class","same-as-selected");break}i.click()})),b.appendChild(c);x[i].appendChild(b),a.addEventListener("click",(function(e){e.stopPropagation(),closeAllSelect(this),this.nextSibling.classList.toggle("select-hide"),this.classList.toggle("select-arrow-active")}))}function closeAllSelect(e){var t,l,s,n,i,c=[];for(t=document.getElementsByClassName("select-items"),l=document.getElementsByClassName("select-selected"),n=t.length,i=l.length,s=0;s<i;s++)e==l[s]?c.push(s):l[s].classList.remove("select-arrow-active");for(s=0;s<n;s++)c.indexOf(s)&&t[s].classList.add("select-hide")}document.addEventListener("click",closeAllSelect);
</script>
</body>
</html>
