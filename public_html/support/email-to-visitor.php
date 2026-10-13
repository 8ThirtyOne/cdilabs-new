<?php
$cdiDomain = $webhelper->Domain;
if($formName == 'customer-survey-form'){
  $content = "
    <!DOCTYPE html>
    <html lang='en'>
      <head>
        <title>Thank You | CDI LABS</title>
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
                  <h1 style='margin-top:30px;color:#181818;font-size:18px;font-weight:bold;line-height:20px;'>Dear $fullname,</h1>
                  <p style='margin:10px 0 30px 0;'>Thank you for taking the time to complete our customer survey! We truly value your support and the partnership we've built together.</p>
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

    $textContent = "Thank you for your interest in CDI Labs. Our representative will get in touch soon. Kind Regards, CDI Labs Team. Please do not reply directly to this email. Thank you for your interest in CDI Labs. Our representative will get in touch soon. Kind Regards, CDI LABS Team. This message is intended only for the use of the named recipient(s) and may contain confidential, personal and/or privileged information. If you are not the intended recipient, please delete this message. Any unauthorized use of the information contained in this message is prohibited.";
}else{
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
      <head>
        <title>Website Lead | CDI LABS</title>
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
                  <h1 style='margin-top:30px;color:#181818;font-size:18px;font-weight:bold;line-height:20px;'>Dear $fullname,</h1>
                  <p style='margin:10px 0 30px 0;'>Thank you for your interest in CDI Labs. Our representative will get in touch soon.</p>
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

    $textContent = "Thank you for your interest in CDI Labs. Our representative will get in touch soon. Kind Regards, CDI Labs Team. Please do not reply directly to this email. Thank you for your interest in CDI Labs. Our representative will get in touch soon. Kind Regards, CDI LABS Team. This message is intended only for the use of the named recipient(s) and may contain confidential, personal and/or privileged information. If you are not the intended recipient, please delete this message. Any unauthorized use of the information contained in this message is prohibited.";
}
