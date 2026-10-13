<?php
include_once('../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update=false;
$delete=false;
if(isset($_SESSION['user'])){
  header('Location: /admin/manager/list');
  exit; 
}else{
  if(!isset($_SESSION['codetry'])) $_SESSION['codetry'] = 0;
}
if(isset($_SESSION['checkuser']) && !empty($_SESSION['checkuser']) && is_int($_SESSION['checkuser'])){
    $userId = $_SESSION['checkuser'];
    $code = $dbhelper->selectOne('SELECT num FROM admincode WHERE user_id=? AND expired > NOW()','i',$userId);
    if(empty($code)){
       header('Location: /admin');
	   exit;
	}
	if(array_key_exists('submit', $_POST)){
	   $_SESSION['codetry']++;
	   $error=array();
	   $input = $webhelper->RequestFilter('codenum', 6, false);
   	   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $userId);
   	   if(!empty($username)){
		   if($code > 0 && $code == $input){
			   $status = $dbhelper->selectOne('SELECT isAdministrator FROM admin WHERE id = ?', 's', $username);
			   $update = $dbhelper->updateAll("UPDATE admin SET logindate = NOW() WHERE pkid = '$userId'");
			   if($update){
			   	   $delete = $dbhelper->deleteAll("DELETE FROM admincode WHERE user_id = '$userId'");
			   	   unset($_SESSION['checkuser']);
			   	   unset($_SESSION['codetry']);
				   session_regenerate_id();
				   $_SESSION['user'] = $userId;
				   if($status == 1){
				      header('Location: /admin/manager/list');
				      exit;
				   }else{
				      header('Location: /admin/resources/literatures/list');
				      exit;
				   }
			   }else{
				   header('Location: /500');
				   exit;
			   }
			}else{
				$error[] = "That code was incorrect. Try again.";
				$error[] = "Attempts remaining ". 3 - $_SESSION['codetry'];
		        if($_SESSION['codetry'] > 2){ 
		         unset($_SESSION['codetry']);
		         $delete = $dbhelper->deleteAll("DELETE FROM admincode WHERE user_id = '$userId'");
		         header('Location: /admin');
				 exit;
		        }
			}
	    }else{
	    	header('Location: /admin');
		    exit;
	    }
	}
}else{
	header('Location: /admin');
	exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Enter Verification Code | ADMIN PORTAL CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
<style>
	#login-form-wrap{width:400px}
</style>
</head>
<body id="admin-login">
<main role="main">
  
   <section class="wide-section" id="login-page">
  
    <div class="page-inner narrow-section">

            <div class="center-box">

               <div id="login-form-wrap">

                 <div class="center-icon">
                   <img src="/admin/img/Icon-CDI-Labs-Watermark-Logo-10.svg" />

                <p>Enter the code sent to your admin email address. Code expires in 5 minutes.</p>

                <!-- Resend Code button -->

            </div>

            <form method="post" name="codeFrm" id="user-form">

                <?php
                  if(isset($error)){
                     echo '<ul id="error-box">';
                     foreach($error as $item) {
                        echo "<li>$item</li>";
                     }
                     echo '</ul>';
                  } 
                ?>

                <fieldset>
                    <label for="Username">Code<span>*</span></label>
                    <input type="text" name="codenum" placeholder="Code" maxlength="6" tabindex="1" />
                </fieldset>

                <fieldset id="login-submit">
                    <input type="submit" name="submit" value="Submit" class="global-btn blue-btn smooth-hover" tabindex="2" />
                </fieldset>

              </form>

            </div>
 
         </div>

      </div>
 
   </section>
       
</main>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>
