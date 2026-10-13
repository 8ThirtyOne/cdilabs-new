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

if(!empty($_POST['fullname']) && !empty($_POST['email']) && !empty($_POST['instituion'])){
  if(!$webhelper->validEmail($_POST['email'])){
    echo '2';
  }else{
    $expected = array('fullname', 'jobtitle', 'instituion', 'email', 'whichevent', 'questions');
    $required = array('fullname', 'instituion', 'email', 'whichevent');
    foreach($_POST as $key => $value){
      if($key != 'g-recaptcha-response' && $key != 'submit'){
        $temp = is_array($value) ? $value : trim($value);
        if(empty($temp) && in_array($key, $required)){
          array_push($missing, $key);
        }elseif(in_array($key, $expected)){
          ${$key} = $temp;
        }
        if(!empty($value)){
          if($key == 'phone'){
           $input = $webhelper->RequestFilter($key, 50, false);
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
        if(preg_match($removeEmail, $data[3]) || preg_match($removeInq, $data[6])){
         echo "0";
        }else{
          //send email to CDI LABS
          $cdiDomain = $webhelper->Domain;
          $questions = htmlentities($data[6], ENT_QUOTES, 'utf-8');
          $leadContent="
            <!DOCTYPE html>
            <html lang='en'>
              <head>
                <title>Registered for Workshop OR Scheduled a Meeting with Us Notification | CDI Labs</title>
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
                            <h1 style='margin:40px 0 30px 20px;padding-bottom:10px;color:#181818;border-bottom:1px solid #e0e0e0;'>Registered for Workshop OR Scheduled a Meeting</h1>
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
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Full Name</p>
                            </td>
                            <td widt='300'>
                              <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
                            </td>
                          </tr>
                          <tr>
                            <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Job Title / Role</p>
                            </td>
                            <td widt='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[1]</p>
                            </td>
                          </tr>
                          <tr>
                           <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Organization / Institution</p>
                            </td>
                             <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[2]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Email</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[3]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Phone</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[4]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>At which event did you register for, OR want to meet?</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$data[5]</p>
                            </td>
                          </tr>
                          <tr>
                          <td width='250'>
                              <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Questions or requests?</p>
                            </td>
                            <td width='320'>
                              <p style='margin:5px 20px 10px 20px;'>$questions</p>
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
          $leadMessage->setSender(REPLYEMAIL, 'CDI Labs NoReply');
          $leadMessage->addReplyTo(REPLYEMAIL, 'CDI Labs NoReply');
          $leadMessage->addFrom(REPLYEMAIL, 'CDI Labs Webmaster');
          $leadMessage->addTo(PAUL, 'Paul Moon');
          $leadMessage->addCc(array(CHRIS, BAKIR, IAN, MIKE));
          //$leadMessage->addCc(array(CHRIS, IAN, SCOTT, MIKE));
          $leadMessage->setSubject("Registered for Workshop OR Scheduled a Meeting Notification");
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
          $transport->send($leadMessage);
          $_SESSION['meeting'] = true;
          echo "1";
        }//block generic emails
      }else{
        echo "3"; //recaptcha wrong
      }
    }else{
      echo '0';
    }
  }// 2 email not valid
}else{
  echo 'Nothing Here.';
}
