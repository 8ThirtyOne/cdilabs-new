<?php
include_once('../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/";
$PageCode = "000000";
$bodyid = "main";
$bodyClass= "full-header";
$PageName = "Customer Feedback";
$formId = "customer-feedback-form";
$FormSubject = "New Customer Feedback from US website";
$FormTitle = "New Web Customer Feedback";
$FormCat = "customer-feedback";
$pageId = -1;
$_SESSION['feedbackset'] = true;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Customer Feedback | CDI Labs</title>
<meta name="description" content="Customer Feedback Form" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/customer-feedback" />
<link rel="preconnect" href="https://cdn-cookieyes.com/">
<link rel="preload" href="https://cdn-cookieyes.com/client_data/82ec697cfddb35173fe88a41/script.js" as="script" />
<script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/82ec697cfddb35173fe88a41/script.js"></script>
<meta charset="utf-8">
<meta name="robots" CONTENT="noindex,nofollow">
<meta name="AdsBot-Google" content="noindex,nofollow">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
<meta name="format-detection" content="telephone=no" />
<link rel="icon" type="image/png" href="/img/common/icon-cdilabs-64.png">
<link rel="shortcut icon" href="/img/common/icon-cdilabs-64.ico">
<link rel="apple-touch-icon" href="/img/common/cdilabs-icon.png">
<link rel="preload" href="https://use.typekit.net/mtm1gsv.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
 <noscript><link rel="stylesheet" href="https://use.typekit.net/mtm1gsv.css"></noscript>
 <?php 
 $ip = $webhelper->catchIP();
 $minjs = '.min'; // .min FOR JS ONLY
 if($detect->isMobile()){ ?>
  <link rel="dns-prefetch" href="<?php echo cdn ?>/js/mainMobile<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/mainMobile'.$minjs.'.js'); ?>" as="script">
 <?php }else{ ?>
  <link rel="dns-prefetch" href="<?php echo cdn ?>/js/main<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/main'.$minjs.'.js'); ?>" as="script">
  <?php 
  }
  $minCss = '.min'; // .min FOR CSS
  ?>
      <link rel="preload" href="/css/global<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/global'.$minCss.'.css'); ?>" as="style">
      <link rel="stylesheet" type="text/css" href="/css/global<?php echo $minCss ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/global'.$minCss.'.css'); ?>" />
      <?php
      if($FirstPageCode == "00"){ 
      ?>
         <link rel="preload" href="/css/main<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/main'.$minCss.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/css/main<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/main'.$minCss.'.css'); ?>" />
      <?php 
      }else if($FirstPageCode == "01"){ 
      ?> 
         <link rel="preload" href="/css/applications<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/applications'.$minCss.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/css/applications<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/applications'.$minCss.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "02"){ 
      ?>
         <link rel="preload" href="/css/products<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/products'.$minCss.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/css/products<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/products'.$minCss.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "03"){
      ?>
         <link rel="preload" href="/css/news<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/news'.$minCss.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/css/news<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/news'.$minCss.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "04"){
      ?>
         <link rel="preload" href="/css/resources<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/resources'.$minCss.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/css/resources<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/resources'.$minCss.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "05"){ 
      ?> 
         <link rel="preload" href="/css/support<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/support'.$minCss.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/css/support<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/support'.$minCss.'.css'); ?>" />
       <?php 
      }else if($FirstPageCode == "06"){ 
      ?>
          <link rel="preload" href="/css/company<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/company'.$minCss.'.css'); ?>" as="style">
          <link rel="stylesheet" type="text/css" href="/css/company<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/company'.$minCss.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "07"){ 
      ?>
          <link rel="preload" href="/css/services<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/services'.$minCss.'.css'); ?>" as="style">
          <link rel="stylesheet" type="text/css" href="/css/services<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/services'.$minCss.'.css'); ?>" />
      <?php
      }
  ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">

	  <section id="customer-survey-section" class="wide-section form-section">
 
      <div class="page-inner">

        <h2>Customer Feedback</h2>

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/forms/customer-feedback-form.php'); ?>

      </div>

    </section>

</main>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script type='text/javascript' src="/js/custom.js"></script>
<script>
var sl = document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;
if(sl === 0){
    var sc = document.createElement('script');
    sc.src = 'https://www.google.com/recaptcha/api.js';
    sc.defer = true;
    document.getElementsByTagName('body')[0].appendChild(sc);
}
const stars = document.querySelectorAll('.star-rating li svg');
stars.forEach(starIcon => {
    starIcon.onclick = () => {
    	let starNum = Number(starIcon.parentElement.getAttribute('data-num'));
    	const ratingId = starIcon.parentElement.parentElement.getAttribute('id');
    	const ratingInput = document.getElementById(ratingId).parentElement;
      let num = starNum == 0 ? -1 : starNum;
    	ratingInput.querySelector('input').value= num;
    	const currentStars = document.querySelectorAll('#'+ratingId+' li svg');
        currentStars.forEach(el => {
           let starState = el.childNodes[0];
           if(starNum < el.parentElement.getAttribute('data-num')) {
           	  starState.setAttribute('xlink:href', '#star-off');
           }else {
              starState.setAttribute('xlink:href', '#star-on');
           }
        });
    }
});

const surveyForm = document.getElementById('<?php echo $formId; ?>');
const surveyFields = document.querySelectorAll('#<?php echo $formId; ?>'+' .get-value');
const surveyBtn = document.getElementById('submit-btn');
const formNote = document.getElementById('form-note');
let formTop = formNote.getBoundingClientRect();

const textBoxes = document.querySelectorAll('#<?php echo $formId; ?> .textBox textarea');
textBoxes.forEach(tb => {
   tb.onkeyup = function (){
      let tbId = this.parentElement.getAttribute('id');
      let wCount = document.querySelector('#'+tbId+' .word-count');
      wCount.innerHTML = "Characters left: " + (1000 - this.value.length);
    }
});

surveyForm.addEventListener('submit', async event => {
  event.preventDefault();
  let isNotEmpty = true;
  let uiErr = false;
  let requiredQ = [];
  if(document.getElementById('form-error')) document.getElementById('form-error').remove();
  var formError = document.createElement('p');
  formError.setAttribute('id', 'form-error');
  surveyFields.forEach(field => {
    if(field != 'recommendation' && (field.value.length === 0 || !field.value.trim())){
      field.style.border = '2px solid #FF5C00';
      let requiredId = field.parentElement.getAttribute('id');
      let requiredNum = '';
      if(requiredId != 'user-info' && requiredId){
        //just get missing rating fields
        requiredNum = requiredId.split("-");
        requiredQ.push(requiredNum[1]);
      }else{
         //get missing user info fields
         uiErr = true;
      }
      isNotEmpty = false;
    }
  });

  var rcDiv = document.createElement('div');
  rcDiv.setAttribute('id', 'RecaptchaSurvey');
  surveyBtn.after(rcDiv);
  var widgetId1 = grecaptcha.render('RecaptchaSurvey', {
      'sitekey' : '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback' : formSubmit,
      'size' : "invisible"
  });
  if(isNotEmpty){
    let checkedOne = true;
    let questionNum = [];
    let radioBoxes = document.querySelectorAll('.survey-radios input[type="radio"]');
    radioBoxes.forEach(function(rBox, i) {
        let fieldId = rBox.parentElement.parentElement.getAttribute('id');
        let fieldNum = fieldId.split("-");
        let currField = document.querySelectorAll('#'+fieldId+' input[type="radio"]');
        checkedOne = Array.prototype.slice.call(currField).some(rb => rb.checked);
        if(!checkedOne){
           //there are 2 radio boxes per field, just store 1 question number when index is even number.  
           if(i%2 === 0) questionNum.push(fieldNum[1]);
        }
    });
    if(questionNum.length > 0){
      const radioErrText = questionNum.length > 1 ? questionNum.join(' and ') : questionNum;
      const radioError = document.createTextNode('Please provide an answer to Questions '+ radioErrText);
      formError.appendChild(radioError);
      formNote.append(formError);
      rcDiv.remove();
      grecaptcha.reset(widgetId1);
      smoothScroll({yPos: formTop.y - 200, duration: 500});
    }else{
      grecaptcha.execute(widgetId1);
    }
  }else{
    let requiredErrText = '';
    if(uiErr){
       requiredErrText = 'Some required information is missing. Please review below.';
    }else{
       requiredErrors = requiredQ.length > 1 ? requiredQ.join(', ') : requiredQ;
       requiredErrText = 'Please answer questions: '+ requiredErrors;
    }
    const txt = document.createTextNode(requiredErrText);
    formError.appendChild(txt);
    formNote.append(formError);
    rcDiv.remove();
    grecaptcha.reset(widgetId1);
    smoothScroll({yPos: formTop.y - 200, duration: 500});
  }
});

async function formSubmit(){
  const url = '/support/process-customer-feedback-form';
  surveyBtn.disabled = true;
  surveyBtn.value = 'Please Wait';
  const formData = new FormData(surveyForm);
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
      processError('Some of your input is too long. Please no more than 1000 characters.');
    }else if(result == 4){
      processError('Some required info is missing. Please review all of your information and answers.');
    }else if(result == 5){
      processError("The reCAPTCHA wasn't entered correctly. Please try again.");
    }else{
      location.href = '/support/feedback-thank-you';
    }
  }catch (error){
    processError('We are having some technical difficulties. Please try again later.');
  }
}

function processError(msg){
  var errorBox = document.createElement('p');
  errorBox.setAttribute('id', 'form-error');
  if(document.getElementById('RecaptchaSurvey')) document.getElementById('RecaptchaSurvey').remove();
    const txt = document.createTextNode(msg);
    errorBox.appendChild(txt);
    formNote.append(errorBox);
    surveyBtn.disabled = false;
    surveyBtn.value = 'Submit';
}
</script>
</body>
</html>
