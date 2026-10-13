<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['name']) && !empty($_GET['name'])){
	$dbhelper = new dbHelper('user');
	$webhelper = new WebHelper();
	$input = $webhelper->RequestFilter("name", 255, false);
    $pageId = $dbhelper->selectOne("SELECT pkid FROM web_page WHERE slugurl = ? AND cat='promo'", 's', $input);
    if($pageId > 0){
  		$PageCode = "060101";
  		$bodyid = "promo";
  		$bodyClass= "clear-header";
  		$pageInfo = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl, description FROM web_page WHERE pkid = $pageId AND cat='promo'");
  		$PageName = $pageInfo['title'];
      $PageTitle = $pageInfo['title'].' | CDI Labs';
      $metaDesc = $pageInfo['description'];
      $PageUrl = "promo/".$pageInfo['slugurl'];
    	$pageHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM web_page_hero WHERE page_id = $pageId");
    	if($pageHero["desktop"] != 'none') $heroExt = pathinfo($pageHero["desktop"], PATHINFO_EXTENSION);
  		$pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = $pageId ORDER BY position ASC");
      $formInc = $dbhelper->numOfRows("SELECT pkid FROM page_form_lookup WHERE page_id = ?", 'i', $pageId);
      if($formInc > 0){
        $pageForm = $dbhelper->RunSQLReturnOneRow("SELECT * FROM page_form_lookup WHERE page_id = $pageId");
        $formId = $pageForm['form_name'];
        $FormSubject = "New ".$pageInfo['title']." Submission";
        $FormTitle = "New ".$pageInfo['title']." Submission";
        $FormCat = "promotions";
        $_SESSION['formset'] = true;
      }
  		$FirstPageCode = substr($PageCode, 0, 2);
  		$SecodeCode = substr($PageCode, 2, 2);
  		$ThirdCode = substr($PageCode, 4, 2);
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
<title><?php echo $PageTitle; ?></title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain.'/'.$PageUrl; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
.hero-section{background-repeat:no-repeat;background-position:left top;background-size:cover}
<?php 
 if($pageHero["desktop"] != 'none' && $heroExt !='mp4'){
 	$desktopHero = $pageHero["desktop"];
 	echo ".hero-section{
 		background-image: url('/files/hero/promo/$desktopHero');
 	}";
 }
 if(!empty($pageHero["mobile"])){
 	$desktopMobile = $pageHero["mobile"];
 	echo "@media all and (max-width: 845px) {
 	.hero-section{background-image:url('/files/hero/promo/$desktopMobile');
 	}}";
 }
foreach($pageSection as $rowCss){
    if($rowCss['bgimg'] != 'none' && $rowCss['bgMobileImg'] != 'none'){
      echo "#promo-$pageId-section-{$rowCss['pkid']}{
        background-image: url('/files/promo/{$rowCss['bgimg']}');
      }";
      echo "@media all and (max-width: 845px) {
        #promo-$pageId-section-{$rowCss['pkid']}{background-image:url('/files/promo/{$rowCss['bgMobileImg']}');
      }}";
    }
}
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">
  <?php
  if($pageHero["desktop"] != 'none' || $pageHero["heading"] != "none"){
    $target = $pageHero['btn_target'] == 0 ? '' : "target='_blank'";
    echo "<section class='hero-section tall-hero promo-hero' id='{$pageInfo['slugurl']}'>

          <div class='page-inner'>";

          echo "<section class='{$pageHero['align']}-hero-content'>";
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
       $colNum = $section['numofcols'];
       $sectionBg = $section['bgColor'] == 'white' ? '' : $section['bgColor'].'-section';
       $videoSection = '';
       $formSection = '';
       if($section['hasForm'] == 1 ){
         $formSection = 'form-section '.$pageForm['form_name'];
       }
       if($section['videoimg'] != 'none' && $section['ytvideo'] != 'none'){
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
                       echo "<div class='custom-video'><img src='/files/promo/{$section['videoimg']}' /></div>";
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

     ?>

</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
<script>
var l = document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;
  if(l === 0){
    var s = document.createElement('script');
    s.src = 'https://www.google.com/recaptcha/api.js';
    s.defer = true;
    document.getElementsByTagName('body')[0].appendChild(s);
  }
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
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
<?php 
if(!$detect->isMobile() && !$detect->isTablet()){ 
   if($pageHero['desktop'] != 'none' && $heroExt == 'mp4'){
     $vid = $pageHero['desktop'];
?>
var video = document.createElement("video");
var source = document.createElement("source"); 
source.src = '/files/hero/promo/<?php echo $vid; ?>';
source.type = "video/mp4";
video.autoplay = true;
video.muted = true;
video.playsinline = true;
video.loop = true;
video.appendChild(source);
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
      let newContainer = document.querySelector('.'+newId[1]).getBoundingClientRect();
      smoothScroll({yPos: newContainer.y - 120, duration: 500});
  });
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

const formId = "<?php echo $pageForm['form_name']; ?>";
const contactForm = document.getElementById(formId);
const contactInputs = document.querySelectorAll('#'+formId+' .get-value');
const contactBtn = document.getElementById('register-btn');

if(formId == 'grant-form'){
  document.getElementById('abstract').onkeyup = function () {
    document.getElementById('abstract-count').innerHTML = "Characters left: " + (500 - this.value.length);
  }
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
      field.style.border = '2px solid #FF5C00';
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
      if(formId == 'grant-form'){
        location.href = '/support/grant-program-thank-you';
      }else{
        location.href = '/support/promo-thank-you';
      }
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

