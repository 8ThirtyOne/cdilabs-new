<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
if(isset($_SESSION['signup']) && !empty($_SESSION['signup'])){
$webhelper = new WebHelper();
$PageUrl = "/support/signup-thank-you";
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
<title>Thank You for Signing Up | CDI Labs</title>
<meta name="description" content="Subscriber Email Confirmation" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/support/signup-thank-you" />
<meta name="robots" CONTENT="noindex,nofollow">
<meta name="AdsBot-Google" content="noindex,nofollow">
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="thank-you-section">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>You're In!</h2>
                    <h3>Thank you for subscribing to our email list. Please check your inbox for a confirmation email.</h3>

                    <?php 
                     if(isset($_SESSION['signup'])){
                       unset($_SESSION['signup']);
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
