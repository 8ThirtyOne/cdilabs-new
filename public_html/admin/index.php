<?php
include_once('../../lcmodel/loadRegister.inc.php');
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
$PageUrl = "/admin/";
$PageCode = "000000";

$ip = $webhelper->catchIP();
$checkIp = $dbhelper->numOfRows('SELECT pkid FROM ipblock WHERE ipnum = ?', 's', $ip);

if(isset($_SESSION['user'])){
  header('Location: /admin/manager/list');
  exit; 
}else{
  if(!isset($_SESSION['lstart'])) $_SESSION['lstart'] = 0;
}

if(array_key_exists('login', $_POST)){
  $_SESSION['lstart']++;
  $update = false;
  $expected = array('email', 'login_pass');
  $required = array('email', 'login_pass');
  $missing = array();
  $error=array();
  $cnt = 0;
  $input='';
  $data = array();
  foreach($_POST as $key => $value){
   $temp = is_array($value) ? $value : trim($value);
   if($key != 'login' && $key != 'returnUrl'){
     if(empty($temp) && in_array($key, $required)){
      array_push($missing, $key);
     }
     elseif(in_array($key, $expected)){
      ${$key} = $temp;
     }
     if(!empty($value)){
         if($key == 'login_id'){ 
            $input = $webhelper->RequestFilter($key, 60, false);
            $id = strpos($input, '@') ? 'email' : 'id';
            $userId = $dbhelper->selectOne('SELECT pkid FROM admin WHERE '.$id.' = ?', 's', $input);
            if($userId > 0){
              $member = $dbhelper->RunSQLReturnOneRow("SELECT id, email, firstname, lastname, pass, salt, isAdministrator, status FROM admin WHERE pkid = $userId");
            }
            else{
              $note = $id == 'email' ? 'Email' : 'Username';
              $error[] = "This ".$note." is not registered with Elegen.";
            }
         }
         if($key == 'login_pass'){
            $input = $webhelper->RequestFilter($key, 30, false);
         }
     }
     else{
       $input = "";
     }
     $data[$cnt] = $input;
     $cnt++;
   }
  }

  if($missing) $error[] = "Both fields are required";

  if(empty($missing) && !$error){
     if(sha1($data[1].$member['salt']) == $member['pass'] || $data[1] == $member["pass"]){
        if($member['status'] == 0){
           $error[] = "Sorry, this username is not yet active.";
        }else{
           $fullname = $member['firstname'].' '.$member['lastname'];
           $email = $member['email'];
           $cdiDomain = $webhelper->Domain;
           $code = random_int(100000, 999999);
           $codeExists = $dbhelper->numOfRows('SELECT num FROM admincode WHERE user_id=?','i',$userId);
           if($codeExists > 0) $delete = $dbhelper->deleteAll("DELETE FROM admincode WHERE user_id = '$userId'");
           $insert = $dbhelper->insertAll("INSERT INTO admincode (user_id, num, expired, created) VALUES ('$userId', '$code', DATE_ADD(NOW(), INTERVAL 5 minute), NOW())");
           $content = "
              <!DOCTYPE html>
              <html lang='en'>
                <head>
                  <title>ADMIN PORTAL ENTER CODE | CDI Labs</title>
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
                            <p style='margin:10px 0 10px 0;'>This is your code:</p>
                            <p style='margin:10px 0 10px 0;font-weight:bold; color:rgba(0,0,0,1.00);'>$code</p>
                            <p style='margin:10px 0 30px 0;'>
                              If you did not request code, please contact Administrator/Developer immediately.
                            </p>
                            <p style='margin:20px 0 0 0;'>Kind Regards,</p>
                            <p style='margin:0;font-weight:bold; color:rgba(0,0,0,1.00);'>CDI Labs Team</p>
                            <p style='margin:20px 0 2px 0;font-size:13px;line-height:15px;'>
                            Please do not reply directly to this e-mail as it has been sent from a notification-only email address that cannot accept incoming email.
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
              $textContent = "You must have html capable email client in order to see lead content. Please do not reply directly to this email.";
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
                $message->addFrom(REPLYEMAIL, 'CDI Labs Webmaster');
                $message->addTo($email, $fullname);
                $message->setSubject('CDI Labs US Admin Verification Code');
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
                session_regenerate_id();
                $_SESSION['checkuser'] = $userId;
                unset($_SESSION['lstart']);
                header('Location: /admin/enter-code');
                exit;
         }
     }else{
        $error[] = "Incorrect password";
        $error[] = "Attempts remaining ". 3 - $_SESSION['lstart'];
        if($_SESSION['lstart'] > 2){ 
         $insert = $dbhelper->insertAll("INSERT INTO ipblock (ipnum, updated, created) VALUES ('$ip', NOW(), NOW() )");
         $error[] = "You have reached login attempt limit. Please contact Web Admin.";
        }
     }
  }
}
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Admin Portal | CDI Labs</title>
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

                <h2>Admin Login</h2>

            </div>

            <form method="post" name="loginFrm">

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
                        <label for="Email">Username or Email Address<span>*</span></label>
                        <input type="text" name="login_id" placeholder="Username or Email Address" maxlength="60"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['login_id']).'"';
                             } ?> tabindex="1" />
                    </fieldset>

                    <fieldset>
                        <label for="Password">Password<span>*</span></label>
                        <input type="password" name="login_pass" placeholder="Password" maxlength="30" tabindex="2" />
                    </fieldset>

                    <fieldset id="login-submit">
                        <input type="submit" name="login" value="LOGIN" class="gloabal-btn blue-btn smooth-hover" <?php if($checkIp > 0 || $_SESSION['lstart'] > 2) echo 'disabled' ?> />
                    </fieldset>

                    <fieldset>
                      <a href="/admin/forgotpwd" class="smooth-hover">Forgot your password?</a>
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