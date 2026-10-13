<?php
include_once('../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
$webhelper = new WebHelper();
$PageUrl = "/404";
$PageCode = "000000";
$bodyClass= "clear-header";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Page Not Found | CDI Labs</title>
<meta name="robots" CONTENT="noindex,nofollow">
<meta name="AdsBot-Google" content="noindex,nofollow">
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="not-found">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>404</h2>
                    <h3>This page is not available.</h3>

             </div>
 
          </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script type='text/javascript' src="/js/load-footer.js"></script>
</body>
</html>
