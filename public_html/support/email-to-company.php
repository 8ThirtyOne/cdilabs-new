<?php
$cdiDomain = $webhelper->Domain;
if($formName == 'contact-form'){
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
	                  <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>First Name</p>
		              </td>
		              <td widt='300' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[5]</p>
		              </td>
		            </tr>
		            <tr>
		              <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Last Name</p>
		              </td>
		              <td widt='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[6]</p>
		              </td>
		            </tr>
		            <tr>
			           <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Email</p>
		              </td>
		               <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[7]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Company</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[10]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Job Title</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[11]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Zip Code</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[9]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Country</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[12]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Phone</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[8]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Estimated Sample Number</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[13]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Platform of Interest</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$platform</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Assay Goal</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[15]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Questions / Requests</p>
		              </td>
		              <td width='320' valign='top' style='word-break:break-all;'>
		                <p style='margin:5px 20px 10px 20px;'>$data[16]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Referrer Page:</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How did you hear about us?</p>
		              </td>
		             <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[14]</p>
		              </td> 
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='margin:5px 20px 50px 20px;'>I would like to receive the latest news and updates from CDI Labs.</p>
		              </td>
		             <td width='320' valign='top'>
		                <p style='margin:5px 20px 50px 20px;'>$newsletter</p>
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
}elseif($formName == 'customer-survey-form'){
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
	                  <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>First Name</p>
		              </td>
		              <td widt='300' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[5]</p>
		              </td>
		            </tr>
		            <tr>
		              <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Last Name</p>
		              </td>
		              <td widt='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[6]</p>
		              </td>
		            </tr>
		            <tr>
			           <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Email</p>
		              </td>
		               <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[7]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Company</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[8]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Job Title</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[9]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>What is your overall satisfaction level working with CDI Labs on your latest project?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[10]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Please provide additional feedback regarding the aspects of the service with which you were particularly satisfied or dissatisfied.</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[11]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How would you rate the onboarding / sample submission process?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[12]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How would you rate the timeliness of receiving results from our service?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[13]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How satisfied are you with the quality of, and information contained in, the data reports provided as part of our service?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[14]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Would you be interested in additional data analysis services?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$dataAnalysis</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How responsive and helpful have you found our team in addressing your inquires or issues related to our service?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[16]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How likely are you to recommend our proteomics service to others in your field?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[17]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Will your research need additional studies on our platforms, such as the same service with a larger sample number, validation services (fewer targets/more samples) or a different service offering?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[18]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Are there any new products or services that you think CDI Labs should consider offering?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[19]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>If you are able to share, how do you think that the results from these services will further your research?</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[20]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Would you consider allowing us to share your feedback in our marketing materials (including social media, web, and collateral)? If yes, we will conatct you to discuss specifics before using your feedback.</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$shareFeedback</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Referrer Page:</p>
		              </td>
		              <td width='320' valign='top'>
		                <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250' valign='top'>
		                <p style='margin:5px 20px 50px 20px;'>I would like to receive the latest news and updates from CDI Labs.</p>
		              </td>
		             <td width='320' valign='top'>
		                <p style='margin:5px 20px 50px 20px;'>$newsletter</p>
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

}
elseif($formName == 'customer-feedback-form'){
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
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>First Name</p>
						</td>
						<td widt='300' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[5]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Last Name</p>
						</td>
						<td widt='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[6]</p>
						</td>
					  </tr>
					  <tr>
						 <td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Email</p>
						</td>
						 <td width='320'>
						  <p style='margin:5px 20px 10px 20px;'>$data[7]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Company</p>
						</td>
						<td width='320'>
						  <p style='margin:5px 20px 10px 20px;'>$data[8]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Job Title</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[9]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>What is your overall satisfaction level with CDI Labs?</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[10]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>In 2–3 sentences, please share your experience working with CDI Labs.</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[11]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>How likely are you to recommend CDI Labs?</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[12]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Will you allow us to share your feedback in our marketing materials? (i.e., social media, web, and collateral)</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$shareFeedback</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Referrer Page:</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='margin:5px 20px 50px 20px;'>I would like to receive the latest news and updates from CDI Labs.</p>
						</td>
					   <td width='320' valign='top'>
						  <p style='margin:5px 20px 50px 20px;'>$newsletter</p>
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
  }
elseif($formName == 'signup-form'){
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
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>First Name</p>
						</td>
						<td widt='300' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[5]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Last Name</p>
						</td>
						<td widt='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[6]</p>
						</td>
					  </tr>
					  <tr>
						 <td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Email</p>
						</td>
						 <td width='320'>
						  <p style='margin:5px 20px 10px 20px;'>$data[7]</p>
						</td>
					  </tr>
					  <tr>
						 <td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Phone</p>
						</td>
						 <td width='320'>
						  <p style='margin:5px 20px 10px 20px;'>$data[8]</p>
						</td>
					  </tr>
					  <tr>
						 <td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Zip Code</p>
						</td>
						 <td width='320'>
						  <p style='margin:5px 20px 10px 20px;'>$data[9]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Company</p>
						</td>
						<td width='320'>
						  <p style='margin:5px 20px 10px 20px;'>$data[10]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Job Title</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[11]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Country</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[12]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Referrer Page:</p>
						</td>
						<td width='320' valign='top'>
						  <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
						</td>
					  </tr>
					  <tr>
						<td width='250' valign='top'>
						  <p style='margin:5px 20px 50px 20px;'>I would like to receive the latest news and updates from CDI Labs.</p>
						</td>
					   <td width='320' valign='top'>
						  <p style='margin:5px 20px 50px 20px;'>$newsletter</p>
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
  }
  else{
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
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Company</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[8]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Job Title</p>
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
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Product Choice</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[11]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Sample Availability</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[12]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Sample Type</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$platform</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Abstract</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[13]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Project Description</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[14]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='font-weight:bold;margin:5px 20px 10px 20px;'>Referrer Page:</p>
		              </td>
		              <td width='320'>
		                <p style='margin:5px 20px 10px 20px;'>$data[0]</p>
		              </td>
		            </tr>
		            <tr>
			          <td width='250'>
		                <p style='margin:5px 20px 50px 20px;'>I would like to receive the latest news and updates from CDI Labs.</p>
		              </td>
		             <td width='320'>
		                <p style='margin:5px 20px 50px 20px;'>$newsletter</p>
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
}
