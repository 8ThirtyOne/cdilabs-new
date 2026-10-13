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
if(isset($_SESSION['surveyset']) && !empty($_SESSION['surveyset'])){
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
      $expected = array('first', 'last', 'email', 'phone', 'company', 'jobtitle', 'projectsatisfy', 'servicefeedback', 'onboarding', 'timeliness', 'quality', 'dataanalysis', 'serviceinquires', 'recommendation', 'additionalstudies', 'newprodservices', 'serviceresults', 'sharefeedback');
      $required = array('first', 'last', 'email', 'phone', 'company', 'jobtitle', 'projectsatisfy', 'servicefeedback', 'onboarding', 'timeliness', 'quality', 'dataanalysis', 'serviceinquires', 'recommendation', 'additionalstudies', 'newprodservices', 'serviceresults', 'sharefeedback');
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
              }elseif($key == 'servicefeedback' || 'additionalstudies' || 'newprodservices' || 'serviceresults'){
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
	          if($data[17] == -1) $data[17] = 0; //change to 0
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
	            if(preg_match($removeEmail, $data[7]) || preg_match($removeInq, $data[11]) || preg_match($removeInq, $data[18]) || preg_match($removeInq, $data[19]) || preg_match($removeInq, $data[20])){
	             echo "0";
	            }else{
	              $params = array(&$data[0], &$data[3], &$data[4], &$data[5], &$data[6], &$data[7], &$data[8], &$data[9], &$data[10], &$data[11], &$data[12], &$data[13], &$data[14], &$data[15], &$data[16], &$data[17], &$data[18], &$data[19], &$data[20], &$data[21], &$subscriber);
	              $insert = $dbhelper->processQuery("INSERT INTO cdi_customer_survey (referrer, category, page_id, firstname, lastname, email, organization, occupation, rate_proj_satisfy, feedback_on_service, rate_onboarding, rate_timeliness, rate_quality, data_a_services, rate_responsivness, rate_recommendation, add_studies, new_pr_services, on_research_results, share_on_social, receive_news, updated, created) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())", "ssisssssisiiiiiisssii", $params);
	              if($insert){
	              	$formName = 'customer-survey-form';
	                $fullname = $data[5].' '.$data[6];
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
	                    'port'              => 2525,
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
	                $dataAnalysis = $data[15] == 1 ? 'YES' : 'NO';
	                $shareFeedback = $data[21] == 1 ? 'YES' : 'NO';
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
	                $leadMessage->addTo(CHRIS, 'Chris Grimley');
	                $leadMessage->addCc(array(EDISA, PAUL));
	                $leadMessage->setSubject($formSubject);
	                $transport->send($leadMessage);
	                unset($_SESSION['surveyset']);
	                session_regenerate_id();
	                $_SESSION['donesurvey'] = true;
	                echo "1";
	             }else{
	              echo "0";
	             }
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
