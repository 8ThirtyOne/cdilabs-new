<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
if(isset($_SESSION['meeting']) && !empty($_SESSION['meeting'])){
    $webhelper = new WebHelper();
    $PageUrl = "/support/meeting-thank-you";
    $PageCode = "050107";
    $bodyid = "support";
    $bodyClass= "clear-header";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
}else{
     header('Location: /');
     exit();
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Meeting Thank You | CDI Labs</title>
<meta name="description" content="Meeting Thank You" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/support/meeting-thank-you" />
<meta name="robots" CONTENT="noindex,nofollow">
<meta name="AdsBot-Google" content="noindex,nofollow">
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="thank-you-section">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>Thank You!</h2>
                    <h3>Thank you for registering for our workshop OR requesting a meeting at our event.<br><span style="font-family:Camber Semibold; font-size:23px; line-height:2">We have received your submission.</span> <br><br><span style="padding-bottom: 10px">If you registered for our workshop, we look forward to seeing you at our event.</span> <br>If you are requesting a meeting at an event, one of our team member will get in touch soon.</h3>

                    <?php 
                     if(isset($_SESSION['meeting'])){
                       unset($_SESSION['meeting']);
                     }
                    ?>

             </div>
 
          </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script type='text/javascript' src="/js/load-footer.js"></script>
</body>
</html>