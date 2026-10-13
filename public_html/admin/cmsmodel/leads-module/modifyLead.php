<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
   $input = trim($_SESSION['user']);
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $PageUrl = "/admin/cmsmodel/leads-module/modifyLead";
      $PageCode = "000000";
      $bodyid = "support";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid']) && isset($_GET['pageid']) && isset($_GET['category']) && !empty($_GET['category'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);
       $pageId = $webhelper->RequestFilter('pageid', 0, false); 
       $cmscat = $webhelper->RequestFilter("category", 50, false);
       $cmsTitle = strtoupper($cmscat);
       $formName = $dbhelper->selectOne('SELECT form_name FROM page_form_lookup WHERE page_id = ?', 'i', $pageId);
       if(isset($formName) && !empty($formName)){
          if($formName == 'grant-form'){
            $dbTable = 'promotion_leads';
          }else{
            $dbTable = 'cdivisitor';
          }
          $exists = $dbhelper->numOfRows("SELECT email FROM $dbTable WHERE pkid = ?", 'i', $pkid); 
          if($exists > 0){
            $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM $dbTable WHERE pkid = $pkid");
           }else{
             header('Location: /admin/cmsmodel/leads-module/leads');
             exit;
           }
       }else{
         header('Location: /admin/cmsmodel/leads-module/leads');
         exit;
       }
      }else{
        header('Location: /admin/cmsmodel/leads-module/leads');
        exit;
      }
    }else{
      header('Location: /admin/');
      exit;
    }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Edit <?php echo ucfirst($cmscat); ?> Lead | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
<style>
    label{display:block;color:#000}
    #enter-data textarea{height:250px}
    #enter-data #abstract{height:60px}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php'); ?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2><?php echo $cmsTitle; ?> LEAD</h2>

            <?php 
                if($formName == 'grant-form'){
                  include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/cmsmodel/leads-module/leads-forms/grant-form-lead.php');
                }else{
                  include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/cmsmodel/leads-module/leads-forms/contact-form-lead.php'); 
                }
            ?>

    </div>
    <!-- Page Inner -->

</section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
