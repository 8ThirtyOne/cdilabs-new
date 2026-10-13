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
$missing = array();
$error = array();
$cnt = 0;
$input='';
$data = array();
$insert = false;

if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])){
  if(!$webhelper->validEmail($_POST['email'])){
    echo '2';
  }else{
    $expected = array('firstname', 'lastname', 'email', 'phone', 'organization', 'country', 'questions');
    $required = array('firstname', 'lastname', 'email', 'organization', 'country');
    $subscriber = isset($_POST['newsletters']) ? 1 : 0;
	  foreach($_POST as $key => $value){
	    if($key != 'newsletters' && $key != 'g-recaptcha-response' && $key != 'register'){
	      $temp = is_array($value) ? $value : trim($value);
	      if(empty($temp) && in_array($key, $required)){
	        array_push($missing, $key);
	      }elseif(in_array($key, $expected)){
	        ${$key} = $temp;
	      }
	      if(!empty($value)){
	        if($key == 'phone'){
	           $input = $webhelper->RequestFilter($key, 50, false);
	        }elseif($key == 'email'){
               $input = $webhelper->RequestFilter($key, 255, false);
	        }elseif($key == 'questions'){
	           $input = $webhelper->RequestFilter($key,  -1, true);
	        }else{
	           $input = $webhelper->RequestFilter($key, 100, false);
	        }
	      }else{
	        $input='none';
	      }
	      $data[$cnt] = $input;
	      $cnt++;
	   }
	  }//for loop
	  if(empty($missing)){
	    if($subscriber == 1){
	     $emailExists = $dbhelper->numOfRows('SELECT pkid FROM web_subscribers WHERE email = ?', 's', $data[7]);
	     $status = 1;
	     if($emailExists == 0) $webSub = $dbhelper->cdiSubscriber($data[5], $data[6], $data[7], $status);
	    }
	    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) $captcha = $_POST['g-recaptcha-response'];
	      $response = file_get_contents(
	        'https://www.google.com/recaptcha/api/siteverify?'.http_build_query([
	            'secret'   => $webhelper->invCaptchaPrivate,
	            'response' => $captcha,
	            'remoteip' => $_SERVER['REMOTE_ADDR'],
	        ])
	     );
	    $obj = json_decode($response);
	    if($obj->success == true){
	      $removeEmail = "(Cleaners|cleaners|janitorial|www.mail.ru|mailinator.com|mfunza.com|orsbap.com|myfreshspokane.com|glenellenvillagemarket.org|gfiga.com)";
	      $removeInq = "(Cleaners|cleaners|janitorial|www.mail.ru)";
	      if(preg_match($removeEmail, $data[7]) || preg_match($removeInq, $data[11])){
	       echo "0";
	      }else{
	      	$formSubject = $data[1];
          $formTitle = $data[2];
          $formName = 'reg-form';
	        $insert = $dbhelper->registerIn($data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $subscriber, $data[0], $data[3], $data[4]);
	        if($insert){
	           $fullname = $data[5].' '.$data[6];
			   $cdiDomain = $webhelper->Domain;
			   $questions = htmlentities($data[11], ENT_QUOTES, 'utf-8');
			   $content = "
			  <!DOCTYPE html>
			  <html lang='en'>
			    <head>
			      <title>Registration Email | CDI LABS</title>
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
			            <td class='content' bgcolor='white' width='600' style='color:#54565b;font-family:sans-serif;font-size:17px;line-height:28px;padding:20px 30px;'>
			              <article>
			                <p style='text-align: center;'>
			                <img src='{$cdiDomain}/img/common/Logo-CDI-Labs-Main.png' width='300' height='44' style='height:44px;max-width:300px;width:300px;min-width:300px;text-align:center;'>
			                </p>
			                <h1 style='margin-top:30px;color:#181818;font-size:18px;font-weight:bold;line-height:20px;'>Thank You from CDI Labs</h1>
			                <h2 style='margin-top:30px;color:#181818;font-size:16px;font-weight:bold;line-height:20px;'>Confirmation on form submission</h2>
			                <p style='margin:10px 0 30px 0;'>Dear $fullname, Thank you for your interest in our video. We hope that you find the information helpful in your research. If you have any questions or requests, please contact us and one of our experts will get in touch as soon as possible.</p>
			                <p style='margin:10px 0 30px 0;'><a style='color:#346c97;font-size:18px;font-weight:bold;text-decoration:none;' href='{$cdiDomain}/company/contact-cdi'>> CONTACT US</a></p>
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

			  $textContent = "Thank you for your interest in our webinar. We hope that you find the information helpful in your research. If you have any questions or requests, please contact us and one of our experts will get in touch as soon as possible. Kind Regards, CDI Labs Team. Please do not reply directly to this email. Thank you for your interest in CDI Labs. Our representative will get in touch soon. Kind Regards, CDI LABS Team. This message is intended only for the use of the named recipient(s) and may contain confidential, personal and/or privileged information. If you are not the intended recipient, please delete this message. Any unauthorized use of the information contained in this message is prohibited.";

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
	          $message->addTo($data[7], $fullname);
	          $message->setSubject('Thank you for registering with CDI Labs');
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
	          $newsletter = $subscriber == 1 ? 'YES' : 'NO';
	          //send email to CDI LABS
	          $leadContent="
            <!DOCTYPE html>
            <html lang='en'>
              <head>
                <title>$formTitle | CDI Labs</title>
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
                    h1{font-size:20px;}
                    td{font-size:14px;}
                    @media all and (max-width: 550px) {
                        h1{font-size:30px}
                  td{
                    font-size:21px;
                  }
                }
                </style>
              </head>
              <body style='background-color:#eeeeee;margin:0 !important;padding:60px 0 60px 0 !important;'>
                <table border='0' cellspacing='0' cellpadding='0' role='presentation' width='100%'>
                  <tr>
                    <td bgcolor='#eeeeee'></td>
                    <td align='center' valign='bottom'>
                      <table cellpadding='0' cellspacing='0' border='0' width='600' style='max-width:600px; width: 600px;'>
                        <tr>
                        <td bgcolor='white' style='font-family:sans-serif;line-height:28px'>
                            <p style='text-align:center;'>
                            <img src='{$cdiDomain}/img/common/Logo-CDI-Labs-Main.png' width='300' height='44' style='margin-top:30px;height:44px;max-width:300px;width:300px;min-width:300px;text-align:center;'>
                            </p>
                            <h1 style='margin:40px 0 30px 20px;padding-bottom:10px;color:#181818;border-bottom:1px solid #e0e0e0;'>$formSubject</h1>
                        </td>
                        </tr>
                      </table>
                    </td>
                    <td bgcolor='#eeeeee'></td>
                  </tr>
                  <tr>
                    <td bgcolor='#eeeeee'></td>
                    <td align='center' valign='top'>
                    <table cellpadding='0' cellspacing='0' border='0' width='600' style='max-width:600px; width:600px;'>
                        <tr>
                        <td class='content' bgcolor='white' style='color:#54565b;font-family:sans-serif;line-height:20px;'>
                          <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                            <tr>
                              <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>First Name</p>
                            </td>
                            <td widt='300'>
                              <p style='margin:5px 20px 10px 20px;'>$data[5]</p>
                            </td>
                          </tr>
                          <tr>
                            <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Last Name</p>
                            </td>
                            <td widt='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[6]</p>
                            </td>
                          </tr>
                          <tr>
                           <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Email</p>
                            </td>
                             <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[7]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Phone</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[8]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Company</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[9]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Country</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[10]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Question / Requests</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$questions</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Page Title</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
                            </td>
                          </tr>
                        </table>
                        </td>
                    </tr>
                   </table>
                  </td>
                  <td bgcolor='#eeeeee'></td>
                 </tr>
                </table>
              </body>
            </html>";
	          $leadTextContent = "You must have html capable email client in order to see lead content.";
	          $leadText = new MimePart($leadTextContent);
	          $leadText->type = Mime::TYPE_TEXT;
	          $leadText->charset = 'utf-8';
	          $leadText->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
	          $leadHtml = new MimePart($leadContent);
	          $leadHtml->type = Mime::TYPE_HTML;
	          $leadHtml->charset = 'utf-8';
	          $leadHtml->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
	          $leadBody = new MimeMessage();
	          $leadBody->setParts([$leadText, $leadHtml]);
	          $leadMessage = new Message();
	          $leadMessage->setBody($leadBody);
	          $leadTypeHeader = $leadMessage->getHeaders()->get('Content-Type');
	          $leadTypeHeader->setType('multipart/alternative');
	          $leadMessage->setSender(REPLYEMAIL, 'CDI Labs Webmaster');
	          $leadMessage->addReplyTo(REPLYEMAIL, 'CDI Labs Webmaster');
	          $leadMessage->addFrom(REPLYEMAIL, 'CDI Labs Webmaster');
	          $leadMessage->addTo(PAUL, 'Paul Moon');
	          $leadMessage->addCc(array(CHRIS, BAKIR));
            //$leadMessage->addCc(array(MIKE, CHRIS, IAN, TYLER, SCOTT, BAKIR));
	          $leadMessage->setSubject($formSubject);
	          $transport->send($leadMessage);
	          $_SESSION['regok'] = true;
	          echo "1";
	       }else{
	        echo "0";
	       }
	      }//block generic emails
	    }else{
	      echo "4"; //recaptcha wrong
	    }
	  }else{
	    echo '3'; //info missing
	  }
  }// 2 email not valid
}else{
  echo 'Nothing Here.';
}


