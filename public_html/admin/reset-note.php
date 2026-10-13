<?php
include_once('../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/admin/reset-note";
$PageCode = "000000";

if(isset($_SESSION['return']) && !empty($_SESSION['return'])){
  $returnUrl = $_SESSION['return']; 
}else{
  $returnUrl = '/';
}

if(isset($_SESSION['sentok']) && !empty($_SESSION['sentok'])){
   $token = $webhelper->RequestFilter('sentok', 255, false);
   $id =  $dbhelper->selectOne('SELECT user_id FROM admin_confirm WHERE token = ?', 's', $token);
   $email =  $dbhelper->selectOne('SELECT email FROM admin WHERE pkid = ?', 'i', $id);
   unset($_SESSION['sentok']);
   $FirstPageCode = substr($PageCode, 0, 2);
   $SecodeCode = substr($PageCode, 2, 2);
   $ThirdCode = substr($PageCode, 4, 2);
}else{
   header('Location: /admin/');
   exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ADMIN PORTAL Email Sent | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<body id="admin-login">
<main role="main">
  
    <section class="wide-section" id="login-page">
 
        <div class="page-inner narrow-section">

          <div class="center-box">

            <div id="login-form-wrap">

               <div class="center-icon">
                <img src="/admin/img/Icon-CDI-Labs-Watermark-Logo-10.svg" />

                <h2>Email Sent</h2>

            </div>

             <div id="reset-message">
              <p>We sent an email to <em><?php echo $email; ?></em>. Please follow instructions in your email on how to reset your password.</p>
              </p>
              <p><em>PLEASE NOTE:</em> Depending on the personal security level of your email client, you may need to look for our email in your "JUNK" mailbox.</p>
              </div>

         </div>

        </div>
        
      </div> 

   </section>
       
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
</body>
</html>