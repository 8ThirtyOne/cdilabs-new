<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
include_once('../../lcmodel/configMail.php'); 
require ZENDDIR.'vendor/autoload.php';
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;
$PageUrl = "/admin/resetpwd";
$PageCode = "000000";

if(isset($_GET['c']) && !empty($_GET['c'])){
  $token = $webhelper->RequestFilter('c', 255, false);
  if($token == ''){
     header('Location: /admin/');
     exit;
  }
  $PageUrl = "/admin/resetpwd";
  $PageCode = "000000";
  $update = false;
  $delete = false;
  $error = array();
  $missing = array();

  $id = $dbhelper->selectOne('SELECT user_id FROM admin_confirm WHERE token = ? AND expired > NOW()','s', $token);
  if($id == 0 || $id ==''){
    header('Location: /admin/');
    exit;
  }else{
    $sql = "SELECT email, firstname, lastname FROM admin WHERE pkid = ".$id;
    $member = $dbhelper->RunSQLReturnOneRow($sql);
  }

  if(array_key_exists('reset', $_POST)){ 
    if(!empty($_POST['new_pass'])){
       $new = $webhelper->RequestFilter('new_pass', 30, false);
       if(!$webhelper->validPwd($new)){
          $error[] = "Password does not meet requirements";
       }
      }

     if(!empty($_POST['confirm_new'])){
       $confirm = $webhelper->RequestFilter('confirm_new', 30, false);
       if($new != $confirm){
         $error[] = "Your passwords do not match";
       }
      }
     if($missing){
        $error[] = "Both fields are required";
     }
   if(empty($missing) && !$error){
      $salt = time();
      $newpwd = sha1($new.$salt);
      $update = $dbhelper->updateAll("UPDATE admin SET pass = '$newpwd', salt = '$salt' WHERE pkid = '$id'");
      if($update){
         $delete = $dbhelper->deleteOne("DELETE FROM admin_confirm WHERE user_id = ?", 'i', $id);
         if(!$delete){
            header('Location: /admin/index?error=del');
         }
       unset($missing);
       $fullname = $member['firstname'].' '.$member['lastname'];
       $cdiDomain = $webhelper->Domain;
       $content = "
          <!DOCTYPE html>
          <html lang='en'>
            <head>
              <title>ADMIN PORTAL RESET SUCCESSFUL | CDI Labs</title>
              <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
              <meta name='viewport' content='width=device-width, initial-scale=1'>
              <meta http-equiv='X-UA-Compatible' content='IE=edge' />
              <style type='text/css'>
                  /* CLIENT-SPECIFIC STYLES */
                  body, table, td, a {-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
                  table, td{mso-table-lspace:0pt;mso-table-rspace:0pt;}
                  img{-ms-interpolation-mode:bicubic;}

                  /* RESET STYLES */
                  img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}
                  table{border-collapse:collapse !important;}
                  body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important;}
              </style>
            </head>
            <body style='background-color:#eeeeee;margin:0 !important;padding:60px 0 60px 0 !important;'>
              <table border='0' cellspacing='0' cellpadding='0' role='presentation' width='100%'>
                <tr>
                    <td bgcolor='#eeeeee'></td>
                    <td class='content' bgcolor='white' width='600' style='border-radius:4px;color:#7d868c;font-family:sans-serif;font-size:17px;line-height:28px;padding:20px 30px;'>
                      <article>
                        <p style='text-align: center;'>
                        <img src='{$cdiDomain}/img/common/Logo-CDI-Labs-Main.png' width='300' height='67' style='height:auto;max-width:300px;width:30%;min-width:200px;text-align:center;'>
                        </p>
                        <h1 style='margin-top:30px;color:black;font-size:18px;font-weight:bold;line-height:20px;'>Hi $fullname,</h1>
                        <p style='margin:10px 0 10px 0;'>You have recently changed password for your CDI Labs Admin Account. You can now login to Admin Portal using your new password.</p>
                        <p style='margin:10px 0 30px 0;'>
                          If you did not reset your password, please contact Administrator/Developer immediately.
                        </p>
                        <p style='margin:20px 0 0 0;'>Kind Regards,</p>
                        <p style='margin:0;font-weight:bold; color:rgba(0,0,0,1.00);'>CDI Labs Team</p>
                        <p style='margin:20px 0 2px 0;font-size:13px;line-height:15px;'>
                        Please do not reply directly to this e-mail as it has been sent from a notification-only email address that cannot accept incoming email. We exclude any responsibility and liability for emails being sent notwithstanding.
                        </p>
                      </article>
                    </td>
                    <td bgcolor='#eeeeee'></td>
                </tr>
                <tr>
                <td bgcolor='#eeeeee'></td>
                <td bgcolor='#33393e' width='600' style='margin:20px 0;border-bottom-left-radius:4px;border-bottom-right-radius:4px;color:#bababa;font-family:sans-serif;font-size:12px;line-height:15px; padding:10px 30px;'>
                <p>
                 This message is intended only for the recipient. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.
                </p>
                </td>
                <td bgcolor='#eeeeee'></td>
                </tr>
                <tr>
                <td bgcolor='#eeeeee'></td>
                <td bgcolor='#eeeeee' width='600' height='50'>
                <td bgcolor='#eeeeee'></td>
                </tr>
              </table>
            </body>
          </html>";

          $textContent = "Please do not reply directly to this email. Thank you for your interest with CDI Labs. Kind Regards, CDI Labs Team. This message is intended only for the use of the named recipient(s) and may contain confidential, personal and/or privileged information. If you are not the intended recipient, please delete this message. Any unauthorized use of the information contained in this message is prohibited.";

            $text = new MimePart($textContent);
            $text->type = Mime::TYPE_TEXT;
            $text->charset = 'utf-8';
            $text->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
            $html = new MimePart($content);
            $html->type = Mime::TYPE_HTML;
            $html->charset = 'utf-8';
            $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
            $body = new MimeMessage();
            $body->setParts([$text, $html]);
            $message = new Message();
            $message->setBody($body);
            $contentTypeHeader = $message->getHeaders()->get('Content-Type');
            $contentTypeHeader->setType('multipart/alternative');
            $message->setSender(REPLYEMAIL, 'CDI Labs NoReply');
            $message->addReplyTo(REPLYEMAIL, 'CDI Labs NoReply');
            $message->addFrom(REPLYEMAIL, 'CDI Labs NoReply');
            $message->addTo($member['email'], $fullname);
            $message->setSubject('CDI Labs Admin Password Changed');
            $transport = new SmtpTransport();
            $options   = new SmtpOptions([
                'name'              => SERVER,
                'host'              => SERVER,
                'port'              => 587,
                'connection_class'  => 'login',
                'connection_config' => [
                    'username' => EUSER,
                    'password' => EPASS,
                    'ssl'      => 'tls',
                ],
            ]);
            $transport->setOptions($options);
            $transport->send($message);
            header('Location: /admin/');
            exit;
      }else{
        $error[] = "We are having some technical difficulties. Please try again.";
      }
    }
  }
}else{
 header('Location: /');
 exit();
}

$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ADMIN PORTAL RESET | CDI Labs</title>
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
                  
                   <h2>Admin Reset Password</h2>

            </div>

            <form method="post" name="resetFrm">

                    <?php
                        if(isset($error)) {
                           echo '<ul id="error-box">';
                           foreach($error as $item) {
                              echo "<li>$item</li>";
                           }
                           echo '</ul>';
                        } 
                    ?>

                    <fieldset>
                        <label for="Password">New Password<span>*</span></label>
                        <input type="password" name="new_pass" id="new-pass" placeholder="Password" maxlength="30" tabindex="1" />
                        <p>Must be at least 8 characters and contain at least one letter and one number.</p>
                    </fieldset>

                    <fieldset>
                        <label for="Password">Confirm New Password<span>*</span></label>
                        <input type="password" name="confirm_new" placeholder="Confirm New Password" maxlength="30" tabindex="2" />
                    </fieldset>

                    <fieldset id="login-submit">
                        <input type="submit" name="reset" value="RESET" class="global-btn blue-btn smooth-hover" />
                    </fieldset>

                </form>

               </div>
 
            </div>

        </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
</body>
</html>