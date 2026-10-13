<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
  $urlName = trim($_GET['name']);
  $dbhelper = new dbHelper('user');
  $webhelper = new WebHelper();
  $id = $dbhelper->selectOne("SELECT pkid FROM videos WHERE slugurl = ? AND type != 2", 's', $urlName);
  if($id == 0){
    header('Location: /resources/videos'); 
    exit;
  }else{
    $dbhelper = new dbHelper('user');
    $webhelper = new WebHelper();
    $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM videos WHERE pkid = $id AND status = 1");
    if(!empty($ViewData)){
      $PageCode = "040102";
      $bodyid = "resources";
      $bodyClass= "full-header";
      $PageName = "VIDEO";
      $PageTitle = $ViewData['title'].' | CDI Labs';
      $metaDesc = 'Watch '.$ViewData['title'].' Video';
      $PageUrl = 'resources/videos/'.$ViewData['slugurl'];
      $formId = "reg-form";
      $FormSubject = "New Content Registration";
      $FormTitle = 'New Content Registration from Web';
      $FormCat = "registration";
      $pageId = $ViewData['pkid'];
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
    }else{
      header('Location: /'); 
      exit;
    }
  }
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $PageTitle; ?></title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain.'/'.$PageUrl; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">

  <?php if($ViewData['permission'] == 1 || isset($_SESSION['regok'])){ ?>

    <section id="video-section" class="wide-section">

        <div class="page-inner">

          <div class="center-paragraph">

             <h4><?php echo $ViewData['title']; ?></h4>

             <div class="iframe-video">
               <iframe id="ytplayer"
              src="https://www.youtube.com/embed/<?php echo $ViewData['youtube_url']; ?>?rel=0"></iframe>
             </div>
          </div>

          <div class="center-paragraph">
             <p><?php echo nl2br($ViewData['body']); ?></p>

           </div>
          
        </div>

        <div class="section-footer">

          <h3>Have any questions about our seromics products and/or services?</h3>
          <a href="/company/contact-cdi" class="global-btn blue-btn smooth-hover">CONTACT US</a>
        </div>

     </section>

      <?php }else{ ?>

      <section id="webinar-section" class="wide-section">

        <div class="page-inner narrow-section">

          <div class="left-paragraph">

             <p class="global-btn blue-btn">VIEW</p>

             <h1><?php echo $ViewData['title']; ?></h1>

             <?php if($ViewData['subtitle'] != "none") echo "<p id='webinar-sub'>{$ViewData['subtitle']}</p>";

             if(!empty($ViewData['page_body'])) echo nl2br(stripcslashes($ViewData["page_body"]));  

             ?>

          </div>

          <div class="right-paragraph">

            <img src="/files/videos/<?php echo $ViewData['thumbnail']; ?>" alt="<?php echo $ViewData['title']; ?>" />

          </div>

          <div id="webinar-abstract">

            <?php echo "<p>{$ViewData['body']}</p>"; ?>

          </div>
          
        </div>

     </section>

      <section id="webinar-form-section" class="wide-section form-section no-margin">

        <div class="page-inner narrow-section">

            <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/forms/registration-form.php'); ?>
              
        </div>

      </section>

      <?php } ?>

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
<script>
  const formId = "<?php echo $formId; ?>";
  const regForm = document.getElementById(formId);
  const formInputs = document.querySelectorAll('#'+formId+' .get-value');
  const submitBtn = document.getElementById('register-btn');

  regForm.addEventListener('submit', async e => {
    let isNotEmpty = true;
    e.preventDefault();
    formInputs.forEach(field => {
      if(field.value.length === 0){
        field.style.border = '1px solid red';
        isNotEmpty = false;
      }
    });
     let eDiv = document.createElement('div');
     eDiv.setAttribute('id', 'RecaptchaReg');
     document.getElementById('questions').after(eDiv);
     var widgetE = grecaptcha.render(document.getElementById('RecaptchaReg'), {
      'sitekey' : '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback' : regSubmit,
      'size' : "invisible"
    });

    if(isNotEmpty){
      grecaptcha.execute(widgetE);
    }else{
      eDiv.remove();
      grecaptcha.reset(widgetE);
    }
  });

  async function regSubmit(){
    const url = '/support/process-register-form';
    submitBtn.disabled = true;
    submitBtn.style.backgroundColor = '#7c878e';
    const formData = new FormData(regForm);
    try {
      const response = await fetch(url, {
        method: 'post',
        body: formData
      });
      const result = await response.text();
      if(result == 0){
        processError("We have noticed an error. Please try again.");
      }else if(result == 2){
        processError("Please provide a valid email address.");
      }else if(result == 3){
        processError("Some information is missing. Please check.");
      }else if(result == 4){
        processError("The reCAPTCHA wasn't entered correctly. Please try again.");
      }else if(result == 5){
        location.href = '/404';
      }else{
        window.scrollTo(0,0);
        window.location.reload();
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
</script>
</body>
</html>
