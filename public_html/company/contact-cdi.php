<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/contact-cdi";
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "clear-header";
$PageName = "CONTACT US";
$PageTitle = 'Contact Us | CDI Labs';
$metaDesc = 'Contact Us';
$PageUrl = 'company/contact-cdi';
$formId = "contact-form";
$FormSubject = "New Lead from US website";
$FormTitle = "New Web Lead / Inquiry";
$FormCat = "request";
$_SESSION['formset'] = true;
$pageId = 0;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Contact Us | CDI Labs</title>
<meta name="description" content="Contact Us" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/company/contact-cdi" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>#form-error{position: absolute;top:-18px;left: 85px}</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

  <section id="contact-form-section" class="wide-section form-section">
 
    <div class="page-inner">
        
      <div class="center-paragraph">
        <h1>Contact Us</h1>
        <h2>Please share a few details about yourself and your research (or request)<span class="line-break"> and our team of experts will respond shortly.</span></h2>
      </div>

      <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/forms/contact-form.php'); ?>
        
    </div>

  </section>

  <section class="wide-section" id="contact-distributors">

    <div class="page-inner">
      <div class="center-paragraph">
        <h2>CDI Labs Locations</h2>
      </div>
        
    <div class="card-layout card3-wrapper">

        <div class="col">
          <h4>Mayagüez, Puerto Rico</h4>
          <address>
            <ul>
              <li><em>CDI Labs - Mayagüez</em></li>
              <li>12 W Mendez Vigo Avenue</li>
              <li>2nd Floor</li>
              <li>Mayagüez, PR 00680</li>
              <li>Tel: +1 939-280-5293</li>
            </ul>
          </address>
            
          <address>
            <ul>
              <br><br>
              <li><em>Mailing and Billing Address</em></li>
              <li>CDI Labs</li>
              <li>P.O. Box 569</li>
              <li>Mayagüez, PR 00681-0569</li>
              <br>
              <li><em>General Inquiries:</em> <a href="mailto:info@cdilabs.com" class="smooth-hover">info@cdilabs.com</a></li>
              <li><em>Technical Support:</em> <a href="mailto:support@cdilabs.com" class="smooth-hover">support@cdilabs.com</a></li>
            </ul>
          </address>
            
        </div>

        <div class="col">
          <h4>Baltimore, Maryland</h4>
          <address>
            <ul>
              <li><em>CDI Labs - Baltimore</em></li>
              <li>1 N Haven Street</li>
              <li>Suite BO01</li>
              <li>Baltimore, MD 21224</li>
              <li>Tel: +1 844-539-6296</li>
            </ul>
          </address>
        </div>

        <div class="col">
          <h4>Toronto, Canada</h4>
          <address>
            <ul>
              <li><em>CDI Labs - Toronto</em></li>
              <li>MaRS Centre - West Tower</li>
              <li>661 University Ave</li>
              <li>Suite 1300</li>
              <li>Toronto, ON</li>
              <li>Canada M5G 0B7</li>
              <li>Tel: +1 647-243-5289</li>
            </ul>
          </address>
        </div>

      </div>
        
      <div class="center-paragraph">
          <h2>Partners and Distribution</h2>
      </div>

      <div class="card-layout card3-wrapper">

        <div class="col">
          <h4>United Kingdom</h4>
          <address>
            <ul>
              <a href="https://arrayjet.com" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-arrayjet-01a.png" alt="arrayjet"></a>
              <li><em>Arrayjet Ltd.</em></li>
              <li>Stobo House</li>
              <li>Midlothian Innovation Centre Pentlandfield</li>
              <li>Roslin CB22 3AT, UK</li>
              <li><a href="https://arrayjet.com" class="paragraph-link smooth-hover" target="_blank">arrayjet.com</a></li>
            </ul>
          </address>
        </div>

        <div class="col">
          <h4>Europe</h4>
          <address>
            <ul>
              <a href="https://cambridgeproteinarrays.com/" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-cambridge-protein-01a.png" alt="cambridge protein arrays"></a>
              <li><em>Cambridge Protein Arrays Ltd.</em></li>
              <li>Building 405, Babraham Research Campus</li>
              <li>Cambridge, CB22 3AT, UK</li>
              <li><a href="https://cambridgeproteinarrays.com/" class="paragraph-link smooth-hover" target="_blank">cambridgeproteinarrays.com</a></li>
            </ul>
              
            <ul>
              <a href="https://www.pepperprint.com/" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-pepperprint-01a.jpg" alt="pepperprint"></a>
              <li><em>PEPperPRINT GmbH</em></li>
              <li>Tullastr. 2</li>
              <li>69126 Heidelberg</li>
              <li>Germany</li>
              <li><a href="https://www.pepperprint.com/" class="paragraph-link smooth-hover" target="_blank">pepperprint.com</a></li>
              <p>&nbsp;</p>
            </ul>
          </address>
        </div>

        <div class="col">
          <h4>Japan</h4>
          <address>
            <ul>
              <a href="https://www.filgen.jp" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-filgen-01a.png" alt="filgen"></a>
              <li><em>Filgen, Inc.</em></li>
              <li>1-1409, Jonoyama, Midori-ku</li>
              <li>Nagoya, Aichi-pref. 459-8011 Japan</li>
              <li><a href="https://www.filgen.jp" class="paragraph-link smooth-hover" target="_blank">filgen.jp</a></li>
            </ul>
          </address>
        </div>

      </div>

      <div class="card-layout card3-wrapper">

      <div class="col">
          <h4>China</h4>
          <address>
            <ul>
              <a href="http://www.proteomics.org.cn/" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-beijing-protein-innovation-01a.jpg" alt="beijing protein innovation bpi"></a>
              <li><em>Beijing Protein Innovation Co., Ltd.</em></li>
              <li>B-8, Airport Industrial Zone</li>
              <li>Beijing, 101318 China</li>
              <li><em>Tel:</em> 86-10-80493132, 86-800-810-0873</li>
              <li><em>Fax:</em> 86-10-80485460</li>
              <li><a href="http://www.proteomics.org.cn/" class="paragraph-link smooth-hover" target="_blank">proteomics.org.cn</a></li>
            </ul>

            <ul>
              <a href="https://www.wayenbio.com" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-wayen-01a.png" alt="wayen bio"></a>
              <li><em>Wayen Biotechnologies Inc.</em></li>
              <li>Suite 805, #781 Cailun Rd.</li>
              <li>ZJ InnoPark, Pudong</li>
              <li>Shanghai, 201203, China</li>
              <li><a href="https://www.wayenbio.com" class="paragraph-link smooth-hover" target="_blank">wayenbio.com</a></li>
            </ul>

          </address>
      </div>

      <div class="col">
        <h4>South Korea</h4>
        <address>
          <ul>
            <a href="https://www.bosungsci.com" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-bosung-01a.png" alt="bosung scientific"></a>
            <li><em>Bosung Scientific Co„Ltd</em></li>
            <li>408 (Guro-dong, Kolon Digitaltower)</li>
            <li>30 Digital-ro 32-gil, Guro-gu</li>
            <li>Seoul, 152-777, Korea</li>
            <li><a href="https://www.bosungsci.com" class="paragraph-link smooth-hover" target="_blank">bosungsci.com</a></li>
          </ul>

          <ul>
            <a href="https://www.geneon.kr" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-gene-on-01a.png" alt="gene on biotech"></a>
            <li><em>Gene On Biotech</em></li>
            <li>514-ho IBPIA</li>
            <li>14-3 Yeouido-dong</li>
            <li>Yeongdeungpo-gu, Seoul, Korea</li>
            <li><a href="https://www.geneon.kr" class="paragraph-link smooth-hover" target="_blank">geneon.kr</a></li>
          </ul>

          <ul>
            <a href="http://www.dm4you.com/seach.list?key=str_text1&keyword=HuProt&x=0&y=0" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-daemyung-01a.jpg" alt="daemyung science"></a>
            <li><em>Daemyung Science Co.,Ltd</em></li>
            <li>DM Bldg 4F 128-9 Garack-Dong</li>
            <li>Songpa-Ku, Seoul, Korea</li>
            <li><a href="http://www.dm4you.com/seach.list?key=str_text1&keyword=HuProt&x=0&y=0" class="paragraph-link smooth-hover" target="_blank">dm4you.com</a></li>
          </ul>
        </address>
      </div>

      <div class="col">
          <h4>Singapore</h4>
          <address>
            <ul>
              <a href="https://www.probioscience.org" class="paragraph-link smooth-hover" target="_blank"><img src="/img/company/logo-probioscience-01a.png" alt="arrayjet"></a>
              <li><em>ProBioscience Technologies Pte Ltd</em></li>
              <li>Address: 62 Ubi Road 1, #08-22</li>
              <li>Oxley Bizhub 2, Singapore 408734</li>
              <li>Skype: mingjoon_0324</li>
              <li><em>Tel:</em> (+65) 9119 1050</li>
              <li><em>Fax:</em> (+65) 6725 8438</li>
              <li><a href="https://www.probioscience.org" class="paragraph-link smooth-hover" target="_blank">www.probioscience.org</a></li>
            </ul>
          </address>
        </div>

      </div>

    </div>

  </section>

</main>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>
<script type='text/javascript' src="/js/custom.js"></script>
<script>
var sl=document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;if(0===sl){var sc=document.createElement("script");sc.src="https://www.google.com/recaptcha/api.js",sc.defer=!0,document.getElementsByTagName("body")[0].appendChild(sc)}const contactForm=document.getElementById("contact-form"),contactInputs=document.querySelectorAll("#contact-form .get-value"),contactBtn=document.getElementById("register-btn"),errorNote=document.getElementById("form-note");let formTop=errorNote.getBoundingClientRect();async function formSubmit(){contactBtn.disabled=!0,contactBtn.value="Please Wait";const e=new FormData(contactForm);try{const t=await fetch("/support/process-contact-form",{method:"post",body:e}),n=await t.text();0==n?processError("We have noticed an error. Please provide all required information."):2==n?processError("Please provide a valid email address."):3==n?processError("The reCAPTCHA wasn't entered correctly. Please try again."):4==n?processError("Some required info is missing."):location.href="/support/thank-you"}catch(e){processError("We have noticed an error. Please try again.")}}function processError(e){var t=document.createElement("p");t.setAttribute("id","form-error");const n=document.getElementById("form-note");document.getElementById("RecaptchaContact")&&document.getElementById("RecaptchaContact").remove();const c=document.createTextNode(e);t.appendChild(c),n.append(t),contactBtn.disabled=!1,contactBtn.value="Submit"}var x,i,j,l,ll,selElmnt,a,b,c;for(contactForm.addEventListener("submit",(async e=>{e.preventDefault();let t=!0;document.getElementById("form-error")&&document.getElementById("form-error").remove();var n=document.createElement("p");n.setAttribute("id","form-error"),contactInputs.forEach((e=>{0!==e.value.length&&e.value.trim()||(e.style.boxShadow="inset 0 0 0 2px #FF5C00",t=!1)}));var c=document.createElement("div");c.setAttribute("id","RecaptchaContact"),document.getElementById("questions").after(c);var r=grecaptcha.render("RecaptchaContact",{sitekey:"6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE",callback:formSubmit,size:"invisible"});if(t)grecaptcha.execute(r);else{const e=document.createTextNode("Some required information is missing. Please review below.");n.appendChild(e),errorNote.append(n),c.remove(),grecaptcha.reset(r),smoothScroll({yPos:formTop.y-200,duration:500})}})),l=(x=document.getElementsByClassName("select-box")).length,i=0;i<l;i++){for(ll=(selElmnt=x[i].getElementsByTagName("select")[0]).length,(a=document.createElement("DIV")).setAttribute("class","select-selected"),a.innerHTML=selElmnt.options[selElmnt.selectedIndex].innerHTML,x[i].appendChild(a),(b=document.createElement("DIV")).setAttribute("class","select-items select-hide"),j=1;j<ll;j++)(c=document.createElement("DIV")).innerHTML=selElmnt.options[j].innerHTML,c.addEventListener("click",(function(e){var t,n,c,r,o,s,a;for(s=(r=this.parentNode.parentNode.getElementsByTagName("select")[0]).length,o=this.parentNode.previousSibling,n=0;n<s;n++)if(r.options[n].innerHTML==this.innerHTML){for(r.selectedIndex=n,o.innerHTML=this.innerHTML,a=(t=this.parentNode.getElementsByClassName("same-as-selected")).length,c=0;c<a;c++)t[c].removeAttribute("class");this.setAttribute("class","same-as-selected");break}o.click()})),b.appendChild(c);x[i].appendChild(b),a.addEventListener("click",(function(e){e.stopPropagation(),closeAllSelect(this),this.nextSibling.classList.toggle("select-hide"),this.classList.toggle("select-arrow-active")}))}function closeAllSelect(e){var t,n,c,r,o,s=[];for(t=document.getElementsByClassName("select-items"),n=document.getElementsByClassName("select-selected"),r=t.length,o=n.length,c=0;c<o;c++)e==n[c]?s.push(c):n[c].classList.remove("select-arrow-active");for(c=0;c<r;c++)s.indexOf(c)&&t[c].classList.add("select-hide")}document.addEventListener("click",closeAllSelect);
</script>
</body>
</html>
