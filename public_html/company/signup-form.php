<?php
include_once('../../lcmodel/loadPage.inc.php');

use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;

$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/signup-form";
$PageCode = "060101";
$bodyid = "company";
$bodyClass = "clear-header";
$PageName = "Sign-up for Our Emails";
$PageTitle = 'Sign-up for Our Emails | CDI Labs';
$metaDesc = 'Sign-up for Our Emails';
$formId = "signup-form";
$FormSubject = "New Lead from US website";
$FormTitle = "New Web Lead / Signup";
$FormCat = "request";
$_SESSION['signupformset'] = true;
$pageId = 0;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
  <title>Sign-up for Our eNews | CDI Labs</title>
  <meta name="description" content="Sign-up for Our Emails" />
  <link rel="canonical" href="<?php echo $webhelper->Domain; ?>/company/signup-form" />
  <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
  <style>
    #form-error {
      position: absolute;
      top: -18px;
      left: 85px
    }
  </style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">

  <section id="contact-form-section" class="wide-section form-section signup-section">

    <div class="page-inner">

      <div class="center-paragraph">
        <h1>Sign Up for Our eNews</h1>
        <h2>Stay in touch to receive the latest news and updates <span class="line-break">on our technologies, platforms and services.</span></h2>
      </div>

      <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/forms/signup-form.php'); ?>

    </div>

  </section>

</main>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php');
?>
<script type='text/javascript' src="/js/custom.js"></script>
<script>
  var sl = document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;
  if (0 === sl) {
    var sc = document.createElement("script");
    sc.src = "https://www.google.com/recaptcha/api.js", sc.defer = !0, document.getElementsByTagName("body")[0].appendChild(sc)
  }
  const signupForm = document.getElementById("<?php echo $formId; ?>"),
    signupInputs = document.querySelectorAll("#<?php echo $formId; ?> .get-value"),
    signupBtn = document.getElementById("signup-btn"),
    errorNote = document.getElementById("<?php echo $formId; ?>-form-note");
  let formTop = errorNote.getBoundingClientRect();



  async function formSubmit() {
    const url = '/support/process-signup-form';
    signupBtn.disabled = true;
    signupBtn.value = 'Please Wait';
    const formData = new FormData(signupForm);
    try {
      const response = await fetch(url, {
        method: 'post',
        body: formData
      });
      const result = await response.text();
      if (result == 0) {
        processError('We have noticed an error. Please try again.');
      } else if (result == 2) {
        processError('Please provide a valid email address.');
      } else if (result == 3) {
        processError('Some of your input is too long. Please no more than 1000 characters.');
      } else if (result == 4) {
        processError('Some required info is missing. Please review all of your information and answers.');
      } else if (result == 5) {
        processError("The reCAPTCHA wasn't entered correctly. Please try again.");
      } else {
        location.href = '/support/thank-you';
      }
    } catch (error) {
      processError('We are having some technical difficulties. Please try again later.');
    }
  }

  function processError(msg) {
    var errorBox = document.createElement('p');
    errorBox.setAttribute('id', 'form-error');
    if (document.getElementById('RecaptchaSignup')) document.getElementById('RecaptchaSignup').remove();
    const txt = document.createTextNode(msg);
    errorBox.appendChild(txt);
    errorNote.append(errorBox);
    signupBtn.disabled = false;
    signupBtn.value = 'SUBMIT';
  }

  signupForm.addEventListener('submit', async event => {
    event.preventDefault();
    let isNotEmpty = true;
    let uiErr = false;
    let requiredQ = [];
    if (document.getElementById('form-error')) document.getElementById('form-error').remove();
    var formError = document.createElement('p');
    formError.setAttribute('id', 'form-error');
    signupInputs.forEach(field => {
      if (field.value.length === 0 || !field.value.trim()) {
        field.style.border = '2px solid #FF5C00';
        let requiredId = field.parentElement.getAttribute('id');
        let requiredNum = '';
        if (requiredId != 'user-info' && requiredId) {
          //just get missing rating fields
          requiredNum = requiredId.split("-");
          requiredQ.push(requiredNum[1]);
        } else {
          //get missing user info fields
          uiErr = true;
        }
        isNotEmpty = false;
      }
    });

    var rcDiv = document.createElement('div');
    rcDiv.setAttribute('id', 'RecaptchaSignup');
    signupBtn.after(rcDiv);
    var widgetId1 = grecaptcha.render('RecaptchaSignup', {
      'sitekey': '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback': formSubmit,
      'size': "invisible"
    });
    if (isNotEmpty) {
        grecaptcha.execute(widgetId1);
    } else {
      let requiredErrText = '';
      if (uiErr) {
        requiredErrText = 'Some required information is missing. Please review below.';
      } else {
        requiredErrors = requiredQ.length > 1 ? requiredQ.join(', ') : requiredQ;
        requiredErrText = 'Please answer questions: ' + requiredErrors;
      }
      const txt = document.createTextNode(requiredErrText);
      formError.appendChild(txt);
      errorNote.append(formError);
      rcDiv.remove();
      grecaptcha.reset(widgetId1);
      smoothScroll({
        yPos: formTop.y - 200,
        duration: 500
      });
    }
  });













  ////////////////////////////////////////////////////////////////////////
  // async function formSubmit() {
  //   signupBtn.disabled = !0, signupBtn.value = "Please Wait";
  //   const e = new FormData(signupForm);
  //   try {
  //     const t = await fetch("/support/process-signup-form", {
  //         method: "post",
  //         body: e
  //       }),
  //       n = await t.text();
  //     0 == n ? processError("We have noticed an error. Please provide all required information.") : 2 == n ? processError("Please provide a valid email address.") : 3 == n ? processError("The reCAPTCHA wasn't entered correctly. Please try again.") : 4 == n ? processError("Some required info is missing.") : location.href = "/support/thank-you"
  //   } catch (e) {
  //     processError("We have noticed an error. Please try again.")
  //   }
  // }

  // function processError(e) {
  //   var t = document.createElement("p");
  //   t.setAttribute("id", "form-error");
  //   const n = document.getElementById("form-note");
  //   document.getElementById("RecaptchaContact") && document.getElementById("RecaptchaContact").remove();
  //   const o = document.createTextNode(e);
  //   t.appendChild(o), n.append(t), signupBtn.disabled = !1, signupBtn.value = "Submit"
  // }

  // signupForm.addEventListener("submit", (async e => {
  //   e.preventDefault();
  //   let t = !0;
  //   document.getElementById("form-error") && document.getElementById("form-error").remove();
  //   var n = document.createElement("p");
  //   n.setAttribute("id", "form-error"), signupInputs.forEach((e => {
  //     0 !== e.value.length && e.value.trim() || (e.style.boxShadow = "inset 0 0 0 2px #FF5C00", t = !1)
  //   }));
  //   var o = document.createElement("div");
  //   o.setAttribute("id", "RecaptchaContact"), document.getElementById("questions").after(o);
  //   var c = grecaptcha.render("RecaptchaContact", {
  //     sitekey: "6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE",
  //     callback: formSubmit,
  //     size: "invisible"
  //   });
  //   if (document.querySelectorAll("#hear-about .select-selected").forEach((e => {
  //       console.log(e.textContent), "Select One" === e.textContent && (e.style.boxShadow = "inset 0 0 0 2px #FF5C00", t = !1)
  //     })), t) grecaptcha.execute(c);
  //   else {
  //     const e = document.createTextNode("Some required information is missing. Please review below.");
  //     n.appendChild(e), errorNote.append(n), o.remove(), grecaptcha.reset(c), smoothScroll({
  //       yPos: formTop.y - 200,
  //       duration: 500
  //     })
  //   }
  // }))
</script>
</body>

</html>