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
if(isset($_SESSION['formset']) && !empty($_SESSION['formset'])){
  $missing = array();
  $error = array();
  $cnt = 0;
  $input='';
  $platform = '';
  $data = array();
  $insert = false;
  if(!empty($_POST['first']) && !empty($_POST['email']) && !empty($_POST['questions'])){
    if(!$webhelper->validEmail($_POST['email'])){
      echo '2';
    }else{
      $expected = array('first', 'last', 'email', 'phone', 'organization', 'zip', 'country', 'sample-number', 'foundout', 'assay-goal', 'questions');
      $required = array('first', 'last', 'email', 'organization', 'zip', 'country', 'questions');
      $subscriber = isset($_POST['newsletters']) ? 1 : 0;
      if(isset($_POST['platform'])){
        foreach ($_POST['platform'] as $selected) {
            $platform .= $selected.", ";
        }
        foreach($_POST as $key => $value){
          if($key != 'platform' && $key != 'newsletters' && $key != 'g-recaptcha-response' && $key != 'register'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if($key == 'zip' || $key == 'phone'){
               $input = $webhelper->RequestFilter($key, 50, false);
              }elseif($key == 'questions'){
                 $input = $webhelper->RequestFilter($key,  -1, true);
              }else{
                 $input = $webhelper->RequestFilter($key, 190, false);
              }
            }else{
              $input='none';
            }
            $data[$cnt] = $input;
            $cnt++;
         }
        }//for loop
        if(empty($missing)){
          $formSubject = $data[1];
          $formTitle = $data[2];
          $platform = rtrim($platform, ', '); //remove last comma space
          if($data[14] != 'none'){
            switch($data[14]){
              case 1:
                  $data[14]= 'Referral';
                  break;
              case 2:
                  $data[14] = 'Web search';
                  break;
              case 3:
                  $data[14] = 'Google search ad';
                  break;
              case 4:
                  $data[14]= 'Publication';
                  break;
              case 5:
                  $data[14] = 'Social media';
                  break;
              case 6:
                  $data[14] = 'CDI Labs email';
                  break;
              case 7:
                  $data[14] = 'Event / meeting';
                  break;
              case 8:
                  $data[14] = 'Other';
                  break;
            }
          }
          if($data[15] != 'none'){
            switch($data[15]){
                case 1:
                    $data[15] = 'Seromics (antibody responses and biomarkers)';
                    break;
                case 2:
                    $data[15] = 'TargetID (determine binding target or specificity)';
                    break;
                case 3:
                    $data[15] = 'Other';
                    break;
            }
          }
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
            if(preg_match($removeEmail, $data[7]) || preg_match($removeInq, $data[16])){
             echo "0";
            }else{
              $insert = $dbhelper->contactIn($data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $platform, $subscriber, $data[0], $data[3], $data[4]);
              if($insert){
                $fullname = $data[5].' '.$data[6];
                $formName = 'contact-form';
                include_once('email-to-visitor.php');
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
                $message->addTo($data[7], $fullname);
                $message->setSubject('Thank you for your interest in CDI Labs');
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
                //send email to CDI LABS
                $newsletter = $subscriber == 1 ? 'YES' : 'NO';
                include_once('email-to-company.php');
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
                $leadMessage->addTo(IN, 'Bakir');
                $leadMessage->setSubject($formSubject);
                $transport->send($leadMessage);
                unset($_SESSION['formset']);
                session_regenerate_id();
                $_SESSION['request'] = true;
                echo "1";
             }else{
              echo "0";
             }
            }//block generic emails
          }else{
            echo "3"; //recaptcha wrong
          }
        }else{
          echo '0';
        }
      }else{
        echo "5";
      }//platform checkbox empty check
    }// 2 email not valid
  }else{
    echo 'Nothing Here.';
  }
}else{
  echo "This is an empty page.";
}