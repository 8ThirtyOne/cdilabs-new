<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
//if(isset($_SESSION['donefeedback']) && !empty($_SESSION['donefeedback'])){
    $webhelper = new WebHelper();
    $PageUrl = "/support/feedback-thank-you";
    $PageCode = "050107";
    $bodyid = "support";
    $bodyClass= "clear-header";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
/*}else{
     header('Location: /');
     exit();
}*/
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Thank You | CDI Labs</title>
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/support/feedback-thank-you" />
<meta name="robots" CONTENT="noindex,nofollow">
<meta name="AdsBot-Google" content="noindex,nofollow">
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
#thank-you-section{
    background:url('../img/common/bg-cdi-thank-you-03b.jpg') no-repeat left top;
    background-size: cover
}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="thank-you-section">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>Thank You!</h2>
                    <h3>Thank you for taking the time to complete our customer feedback.</h3>

                    <?php 
                     if(isset($_SESSION['request'])){
                       unset($_SESSION['request']);
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
