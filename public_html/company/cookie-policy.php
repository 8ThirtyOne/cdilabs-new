<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "company/cookie-policy";
$PageTitle = 'Cookie Policy | CDI Labs';
$metaDesc = 'CDI Labs Cookie Policy';
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "full-header";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Cookie Policy | CDI Labs</title>
<meta name="description" content="CDI Labs Cookie Policy" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/company/cookie-policy" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

<section class="wide-section" id="privacy-policy">
 
            <div class="page-inner">

              <div class="center-paragraph">

                <p id="policy-date"><em>UPDATED: September 18, 2024</em></p>

                <h1>COOKIE POLICY</h1>

                <div class="text-paragraph">
          
          <p>This policy explains what HTTP cookies and similar technologies are, why we use them, and how you can manage their use.</p>

                <h4><span class="policy-number">1.</span> What is a cookie?</h4>
          
          <p class="indent-policy no-margin">A cookie is a small piece of data sent from our webpage and stored in your web browser, mobile phone, or other device while you are using our websites. It helps the page recognise your device the next time you visit, provides you with access to certain functions and understands your website journey. Cookies are common web technology, and most websites use them.</p>
                    
                <p class="indent-policy no-margin">There are two types of cookies:</p>
                <ul>
                    <li><em>Session cookies</em> – which are deleted when you close your browser; and</li>
                    <li><em>Persistent cookies</em> – which stay in your browser’s sub folders until you delete them, or they expire.</li>        
                </ul>
                    
                <p class="indent-policy no-margin">You can find out more about cookies at <a href="https://www.allaboutcookies.org" target="_blank">www.allaboutcookies.org</a>.</p>
        
          
        <h4><span class="policy-number">2.</span> What are first- and third-party cookies?</h4>
          
        <p>First-party cookies are cookies that belong to us; third-party cookies are cookies that another party places on your device through our website. Third-party cookies may be placed on your device by someone providing a service for us, for example to help us understand how our service is being used.</p>
  
  
        <h4><span class="policy-number">3.</span> Why do we use cookies?</h4>
          
        <p>Our websites use cookies to distinguish you from other users on our website. This helps us to provide you with a better experience when you browse our website and allows us to make improvements to our site and user experience.</p>


        <h4><span class="policy-number">4.</span> What cookies do we use?</h4>
          
        <p>There are four different groups of cookies:</p>
                    
                <ul>
                    <li class="policy-list"><em>Strictly Necessary Cookies:</em> These are essential and without them you would not be able to use our website as expected.</li>
                    
                    <li class="policy-list"><em>Analytical Cookies:</em> These cookies collect information about how visitors use our websites, such as which pages are viewed most often. These cookies do not collect your personal information but are used to help us improve and to determine the most popular areas of our website.</li>
                    
                    <li class="policy-list"><em>Functionality or Performance Cookies:</em> These cookies enable a website to save information which has already been entered (such as usernames, language choices and your location), so that it can offer you improved and more personalised functions. Functional cookies are also used to enable features you request such as playing videos. These cookies collect anonymous information and cannot track your movements on other websites.</li>
                    
                    <li class="policy-list" style="padding-bottom: 60px"><em>Targeting or Advertising Cookies:</em> These cookies are used to deliver adverts more relevant to you and your interests. </li>      
                </ul>


        <h4><span class="policy-number">5.</span> Our cookies</h4>
          
        <p>If you decide to ‘allow all’ cookies from the banner displayed when first landing on our site, we will use all of those listed in the table below; however, if you select ‘do not allow’ we will only use strictly necessary cookies which are required to make the website function properly. </p>

        <table class="data_table cookies-table">
          <caption>Strictly Necessary Cookies</caption>
                  <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                  </colgroup>
                  <thead>
                  <tr>
                    <th>Cookie Name</th>
                    <th>Description</th>
                    <th>1<sup>st</sup> or 3<sup>rd</sup> Party</th>
                    <th>Duration</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>CDICA or CDIUS</td>
                    <td>This cookie stores and identifies a user's unique session ID to manage user sessions on the website.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>Session</td>
                  </tr>
                  <tr>
                    <td>cookieyes-consent</td>
                    <td>CookieYes sets this cookie to remember users' consent preferences so that their preferences are respected on subsequent visits to this site. It does not collect or store any personal information about the site visitors.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>1 year</td>
                  </tr>
                  <tr>
                    <td>ssi--lastlnteraction</td>
                    <td>Site Search sets this cookie as necessary to optimize the website's search-bar function. The cookie ensures accurate and fast search results.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>10 minutes</td>
                  </tr>
                  <tr>
                    <td>ssi--sessionld</td>
                    <td>Site Search sets this cookie to save information about actions that have been carried out by the user during the current visit to the website, including searches with keywords included.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>1 year</td>
                  </tr>
                  </tbody>
                </table>
                    
                <table class="data_table cookies-table">
          <caption>Analytical Cookies</caption>
                  <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                  </colgroup>
                  <thead>
                  <tr>
                    <th>Cookie Name</th>
                    <th>Description</th>
                    <th>1<sup>st</sup> or 3<sup>rd</sup> Party</th>
                    <th>Duration</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>_ga</td>
                    <td>Google Analytics sets this cookie to calculate visitor, session and campaign data and track site usage for the site's analytics report. The cookie stores information anonymously and assigns a randomly generated number to recognise unique visitors.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>1 year 1 month 4 days</td>
                  </tr>
                  <tr>
                    <td>_ga_*</td>
                    <td>Google Analytics sets this cookie to store and count page views.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>1 year 1 month 4 days</td>
                  </tr>
                  <tr>
                    <td>_gcl_au</td>
                    <td>Google Tag Manager sets the cookie to experiment advertisement efficiency of websites using their services.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>3 months</td>
                  </tr>
                  <tr>
                    <td>li_gc</td>
                    <td>LinkedIn set this cookie for storing visitor's consent regarding using cookies for non-essential purposes.</td>
                    <td>1<sup>st</sup> Party</td>
                    <td>6 months</td>
                  </tr>
                  <tr>
                    <td>lidc</td>
                    <td>LinkedIn sets the cookie to provide load balancing functionality and facilitate data center selection.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>1 day</td>
                  </tr>
                  <tr>
                    <td>yt-player-headers-readable</td>
                    <td>The cookie is used by YouTube to store user preferences related to video playback and interface, enhancing the user's viewing experience.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Persistent</td>
                  </tr>
                  <tr>
                    <td>Ytidb:: Last_result_entry_key</td>
                    <td>The cookie is used by YouTube to store the last search result entry that was clicked by the user. This information is used to improve the user experience by providing more relevant search results in the future.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Persistent</td>
                  </tr>
                  <tr>
                    <td>yt-remote-cast-available</td>
                    <td>The cookie is used to store the user's preferences regarding whether casting is available on their YouTube video player.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Persistent</td>
                  </tr>
                  <tr>
                    <td>yt-remote-cast-installed</td>
                    <td>The cookie is used to store the user's video player preferences using embedded YouTube video.</td>
                    <td>3<sup>rd</sup> party</td>
                    <td>Session</td>
                  </tr>
                  <tr>
                    <td>yt-remote-connected-devices</td>
                    <td>YouTube sets this cookie to store the user's video preferences using embedded YouTube videos.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Persistent</td>
                  </tr>
                  <tr>
                    <td>yt-remote-device-id</td>
                    <td>YouTube sets this cookie to store the user's video preferences using embedded YouTube videos.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>1 year</td>
                  </tr>
                  <tr>
                    <td>yt-remote-fast-check-period</td>
                    <td>The cookie is used by YouTube to store the user's video player preferences for embedded YouTube videos.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Session</td>
                  </tr>
                  <tr>
                    <td>yt-remote-session-app</td>
                    <td>The cookie is used by YouTube to store user preferences and information about the interface of the embedded YouTube video player.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Session</td>
                  </tr>
                  <tr>
                    <td>yt-remote-session-name</td>
                    <td>The cookie is used by YouTube to store the user's video player preferences using embedded YouTube video.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Session</td>
                  </tr>
                  </tbody>
                </table>
                
                <table class="data_table cookies-table">
          <caption>Targeting or Advertising Cookies</caption>
                  <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                  </colgroup>
                  <thead>
                  <tr>
                    <th>Cookie Name</th>
                    <th>Description</th>
                    <th>1<sup>st</sup> or 3<sup>rd</sup> Party</th>
                    <th>Duration</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>bcookie</td>
                    <td>LinkedIn sets this cookie from LinkedIn share buttons and ad tags to recognize browser IDs.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>1 year</td>
                  </tr>
                  <tr>
                    <td>muc_ads</td>
                    <td>X (Twitter) sets this cookie to collect user behaviour and interaction data to optimize the website.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>1 year 1 month 4 days</td>
                  </tr>
                  <tr>
                    <td>personalization_id</td>
                    <td>X (Twitter) sets this cookie to integrate and share features for social media and store information about how the user uses the website, for tracking and targeting.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>1 year 1 month 4 days</td>
                  </tr>
                  <tr>
                    <td>test_cookie</td>
                    <td>doubleclick.net sets this cookie to determine if the user's browser supports cookies.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>15 minutes</td>
                  </tr>
                  <tr>
                    <td>VISITOR_INFO1_LIVE</td>
                    <td>YouTube sets this cookie to measure bandwidth, determining whether the user gets the new or old player interface.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>6 months</td>
                  </tr>
                  <tr>
                    <td>VISITOR_PRIVACY_METADATA</td>
                    <td>YouTube sets this cookie to store the user's cookie consent state for the current domain.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>6 months</td>
                  </tr>
                  <tr>
                    <td>YSC</td>
                    <td>YouTube sets this cookie to track the views of embedded videos on YouTube pages.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>Session</td>
                  </tr>
                  <tr>
                    <td>yt.innertube:nextID</td>
                    <td>YouTube sets this cookie to register a unique ID to store data on what videos from YouTube the user has seen.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>6 months</td>
                  </tr>
                  <tr>
                    <td>yt.innertube:requests</td>
                    <td>YouTube sets this cookie to register a unique ID to store data on what videos from YouTube the user has seen.</td>
                    <td>3<sup>rd</sup> Party</td>
                    <td>6 months</td>
                  </tr>
                  </tbody>
                </table>

        <h4><span class="policy-number">6.</span> How do I change my cookies settings manage cookies?</h4>
                    
        <p>When you access our website for the first time, and occasionally after that, we will display a cookie banner which allows you to accept all the cookies we use or to deny their use. You can also manage your cookie choices by toggling the sliders that are next to the cookie categories.</p>
                    
        <p>You change your mind at any time and can access your cookie choices via the cookie icon that is at the bottom right hand of the screen.</p>
                    
        <p>Alternatively, most web browsers allow some control of most cookies through the browser settings. To find out more about cookies, including how to see what cookies have been set, visit <a href="https://www.aboutcookies.org" target="_blank">www.aboutcookies.org</a>  or <a href="https://www.allaboutcookies.org" target="_blank">www.allaboutcookies.org</a>.</p>
                    
        <p>Find out how to manage cookies on popular browsers:</p>
                <ul>
                    <li class="policy-list"><a href="https://support.google.com/accounts/answer/61416?co=GENIE.Platform%3DDesktop&hl=en" target="_blank"><b>Google Chrome</b></a></li>
                    <li class="policy-list"><a href="https://support.microsoft.com/en-us/windows/microsoft-edge-browsing-data-and-privacy-bb8174ba-9d73-dcf2-9b4a-c582b4e640dd" target="_blank"><b>Microsoft Edge</b></a></li>
                    <li class="policy-list"><a href="https://support.mozilla.org/en-US/kb/enhanced-tracking-protection-firefox-desktop?redirectslug=enable-and-disable-cookies-website-preferences&redirectlocale=en-US" target="_blank"><b>Mozilla Firefox</b></a></li>
                    <li class="policy-list"><a href="https://support.microsoft.com/en-gb/windows/manage-cookies-in-microsoft-edge-view-allow-block-delete-and-use-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank"><b>Microsoft Internet Explorer</b></a></li> 
                    <li class="policy-list"><a href="https://help.opera.com/en/latest/web-preferences/" target="_blank"><b>Opera</b></a></li>
                    <li class="policy-list" style="padding-bottom: 30px"><a href="https://support.apple.com/en-gb/safari" target="_blank"><b>Apple Safari</b></a></li>
                </ul>
                    
        <p>To find information relating to other browsers, visit the browser developer's website.</p>
                    
                <p style="padding-bottom: 65px">To opt out of being tracked by Google Analytics across all websites, visit <a href="http://tools.google.com/dlpage/gaoptout" target="_blank">http://tools.google.com/dlpage/gaoptout</a>.</p>


                </div>
              
            </div>

         </section>
</main>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>

</script>
</body>
</html>
