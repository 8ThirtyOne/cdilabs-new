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
if(isset($_SESSION['feedbackset']) && !empty($_SESSION['feedbackset'])){
  $missing = array();
  $error = array();
  $cnt = 0;
  $input='';
  $platform = '';
  $data = array();
  $maxInput = false;
  $insert = false;
  if(!empty($_POST['first']) && !empty($_POST['email']) && !empty($_POST['servicefeedback'])){
    if(!$webhelper->validEmail($_POST['email'])){
      echo '2';
    }else{
      $expected = array('first', 'last', 'email', 'company', 'jobtitle', 'projectsatisfy', 'servicefeedback', 'recommendation', 'sharefeedback');
      $required = array('first', 'last', 'email', 'company', 'jobtitle', 'projectsatisfy', 'servicefeedback', 'recommendation', 'sharefeedback');
      $subscriber = isset($_POST['newsupdates']) ? 1 : 0;
      foreach($_POST as $key => $value){
          if($key != 'newsupdates' && $key != 'g-recaptcha-response' && $key != 'submit'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if(strlen($value) > 2950) $maxInput = true;
              if($key == 'email'){
               $input = $webhelper->RequestFilter($key, 254, false);
              }elseif($key == 'pageid' || $key == 'projectsatisfy' || ($cnt > 11 && $cnt < 18) ||  $key == 'sharefeedback'){
                $input = (int)$key;
                $input = $webhelper->RequestFilter($key, 0, false);
              }elseif($key == 'servicefeedback'){
                 $input = $webhelper->RequestFilter($key, -1, false);
              }else{
                 $input = $webhelper->RequestFilter($key, 100, false);
              }
            }else{
              $input='none';
            }
            $data[$cnt] = $webhelper->safeOutput($input);
            $cnt++;
         }
        }//for loop
        if($maxInput){//input too long
          echo "3";
        }else{
	        if(empty($missing)){
	          $formSubject = $data[1];
	          $formTitle = $data[2];
	        //   if($data[17] == -1) $data[17] = 0; //change to 0
	          if($subscriber == 1){
	           $emailExists = $dbhelper->numOfRows('SELECT pkid FROM web_subscribers WHERE email = ?', 's', $data[7]);
	           $status = 1;
	           $subParams = array(&$data[5], &$data[6], &$data[7], &$status);
	           if($emailExists == 0) $webSub = $dbhelper->processQuery("INSERT INTO web_subscribers (firstname, lastname, email, status, updated, created) VALUES (?,?,?,?, NOW(), NOW())","sssi",$subParams);
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
	              	$formName = 'customer-feedback-form';
	                $transport = new SmtpTransport();
	                $options   = new SmtpOptions([
	                    'name'              => SERVER,
	                    'host'              => SERVER,
	                    'port'              => 2525,
	                    'connection_class'  => 'login',
	                    'connection_config' => [
	                        'username' => EUSER,
	                        'password' => EPASS,
	                        'ssl'      => 'tls',
	                    ],
	                ]);
	                $transport->setOptions($options);
	                $shareFeedback = $data[13] == 1 ? 'YES' : 'NO';
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
	                $leadMessage->addTo(PAUL, 'Paul Moon');
	                // $leadMessage->addCc(array(EDISA, CHRIS));
	                $leadMessage->setSubject($formSubject);
	                $transport->send($leadMessage);
	                unset($_SESSION['feedbackset']);
	                session_regenerate_id();
	                $_SESSION['donefeedback'] = true;
	                echo "1";
	            }//block generic emails
	          }else{
	            echo "5"; //recaptcha wrong
	          }
	        }else{
	          echo "4"; //some of the input is missing
	        }
	    }//maxInput check
    }// 2 email not valid
  }else{
    echo "Nothing Here.";
  }
}else{
  echo "This is an empty page.";
}
