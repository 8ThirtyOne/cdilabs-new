<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
$webhelper = new WebHelper();
$PageUrl = "/admin/cmsmodel/errorPage";
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
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="not-found">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>404</h2>
                    <?php
                       if(isset($_GET['reason'])) {
                           $error = $webhelper->RequestFilter("reason", 100, false);
                           $error = str_replace("-"," ",$error);
                           $error = strtoupper($error);
                           echo "<h3>$error</h3>";
                       } 
                   ?>

             </div>
 
          </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>
