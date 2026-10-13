<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/custom-phip-seq-contact";
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "clear-header";
$PageName = "Custom PhIP-Seq Contact";
$formId = "custom-phip-seq-contact-form";
$FormSubject = "New Lead Custom PhIP-Seq Contact";
$FormTitle = "New Web Lead / Custom PhIP-Seq Contact";
$FormCat = "custom-phip-seq-contact";
$pageId = 0;
$_SESSION['formset'] = true;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Custom PhIP-Seq Contact Form | CDI Labs Canada</title>
<meta name="description" content="Custom PhIP-Seq Contact" />
<link rel="canonical" href="<?php echo $webhelper->DomainCA; ?>/company/custom-phip-seq-contact" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>#form-error{position:absolute;top:-18px;left:85px}</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

  <section id="custom-phip-seq-contact-form-section" class="wide-section form-section">
 
    <div class="page-inner">
        
      <div class="center-paragraph">
        <h1>Custom PhIP-Seq Contact Form</h1>
        <h2>Please share a few details about yourself and your research (or request)<span class="line-break"> and our team of experts will respond shortly.</span></h2>
      </div>

      <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/forms/custom-phip-seq-contact-form.php'); ?>
        
    </div>

  </section>

</main>

<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>
<script type='text/javascript' src="/js/smooth-scroll.js"></script>
<script>
const contactForm=document.getElementById("custom-phip-seq-contact-form"),contactInputs=document.querySelectorAll("#custom-phip-seq-contact-form .get-value"),contactBtn=document.getElementById("register-btn"),errorNote=document.getElementById("form-note");let formTop=errorNote.getBoundingClientRect();async function formSubmit(){contactBtn.disabled=!0,contactBtn.value="Please Wait";const e=new FormData(contactForm);try{const t=await fetch("/support/process-custom-phip-seq-contact-form",{method:"post",body:e}),o=await t.text();0==o?processError("We have noticed an error. Please try again."):2==o?processError("Please provide a valid email address."):3==o?processError("The reCAPTCHA wasn't entered correctly. Please try again."):4==o?processError("Some required info is missing."):location.href="/support/thank-you"}catch(e){processError("We have noticed an error. Please try again.")}}function processError(e){var t=document.createElement("p");t.setAttribute("id","form-error");const o=document.getElementById("form-note");document.getElementById("RecaptchaContact")&&document.getElementById("RecaptchaContact").remove();const r=document.createTextNode(e);t.appendChild(r),o.append(t),contactBtn.disabled=!1,contactBtn.value="Submit"}contactForm.addEventListener("submit",(async e=>{e.preventDefault();let t=!0;document.getElementById("form-error")&&document.getElementById("form-error").remove();var o=document.createElement("p");o.setAttribute("id","form-error"),contactInputs.forEach((e=>{0!==e.value.length&&e.value.trim()||(e.style.boxShadow="inset 0 0 0 2px #FF5C00",t=!1)}));var r=document.createElement("div");r.setAttribute("id","RecaptchaContact"),document.getElementById("questions").after(r);var c=grecaptcha.render("RecaptchaContact",{sitekey:"6LdtfVUpAAAAAKDdSNhgae_-XItWjA3_mr-2GVik",callback:formSubmit,size:"invisible"});if(document.querySelectorAll("#hear-about .select-selected").forEach((e=>{"Select One"===e.textContent&&(e.style.boxShadow="inset 0 0 0 2px #FF5C00",t=!1)})),t)grecaptcha.execute(c);else{const e=document.createTextNode("Some required information is missing. Please review below.");o.appendChild(e),errorNote.append(o),r.remove(),grecaptcha.reset(c),smoothScroll({yPos:formTop.y-200,duration:500})}}));var x,i,j,l,ll,selElmnt,a,b,c;for(l=(x=document.getElementsByClassName("select-box")).length,i=0;i<l;i++){for(ll=(selElmnt=x[i].getElementsByTagName("select")[0]).length,(a=document.createElement("DIV")).setAttribute("class","select-selected"),a.innerHTML=selElmnt.options[selElmnt.selectedIndex].innerHTML,x[i].appendChild(a),(b=document.createElement("DIV")).setAttribute("class","select-items select-hide"),j=1;j<ll;j++)(c=document.createElement("DIV")).innerHTML=selElmnt.options[j].innerHTML,c.addEventListener("click",(function(e){var t,l,s,n,i,c,a;for(c=(n=this.parentNode.parentNode.getElementsByTagName("select")[0]).length,i=this.parentNode.previousSibling,l=0;l<c;l++)if(n.options[l].innerHTML==this.innerHTML){for(n.selectedIndex=l,i.innerHTML=this.innerHTML,a=(t=this.parentNode.getElementsByClassName("same-as-selected")).length,s=0;s<a;s++)t[s].removeAttribute("class");this.setAttribute("class","same-as-selected");break}i.click()})),b.appendChild(c);x[i].appendChild(b),a.addEventListener("click",(function(e){e.stopPropagation(),closeAllSelect(this),this.nextSibling.classList.toggle("select-hide"),this.classList.toggle("select-arrow-active")}))}function closeAllSelect(e){var t,l,s,n,i,c=[];for(t=document.getElementsByClassName("select-items"),l=document.getElementsByClassName("select-selected"),n=t.length,i=l.length,s=0;s<i;s++)e==l[s]?c.push(s):l[s].classList.remove("select-arrow-active");for(s=0;s<n;s++)c.indexOf(s)&&t[s].classList.add("select-hide")}document.addEventListener("click",closeAllSelect);
</script>
</body>
</html>

