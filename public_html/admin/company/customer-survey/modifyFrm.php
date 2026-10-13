<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
   $input = trim($_SESSION['user']);
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $PageUrl = "/admin/company/customer-survey/list";
      $PageCode = "000000";
      $bodyid = "support";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT email FROM cdi_customer_survey WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM cdi_customer_survey WHERE pkid = $pkid ");
       }else{
        header('Location: /admin/company/customer-survey/list');
        exit;
       }
      }
    }else{
        header('Location: /admin/');
        exit;
    }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Edit Customer Survey Lead | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
<style>
    label{display:block;color:#000}
    .short-field{width:30px}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>CUSTMOER SURVEY LEAD</h2>

            <form method="post" name="registerFrm" id="enter-data">
             <input type="hidden" name="pkid"  value="<?php echo $pkid; ?>" />

            <fieldset>
                <label for="First Name">First Name</label>
                <input type="text" name="first" id="first"
                    <?php
                      echo 'value="'.htmlentities($ViewData["firstname"]).'"';
                    ?> tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Last Name">Last Name</label>
                <input type="text" name="last" id="last"
                    <?php
                      echo 'value="'.htmlentities($ViewData["lastname"]).'"';
                    ?> tabindex="2" />
            </fieldset>

            <fieldset>
            <label for="Email Address">Email Address</label>
                <input type="email" name="email" class="get-value" id="email" 
                    <?php
                      echo 'value="'.htmlentities($ViewData["email"]).'"';
                    ?> tabindex="3" />
            </fieldset>

            <fieldset>
            <label for="Company / Organization">Company / Organization</label>
            <input type="text" name="organization" id="organization"
                  <?php
                  echo 'value="'.htmlentities($ViewData["organization"]).'"';
                  ?> tabindex="4" />
            </fieldset>

            <fieldset>
            <label for="job-title">Job Title</label>
            <input type="text" name="jobtitle" id="job-title"
             <?php 
                  echo 'value="'.htmlentities($ViewData["occupation"]).'"';
             ?> tabindex="5" />
            </fieldset>

            <fieldset>
            <label for="project-satisfy">What is your overall satisfaction level working with CDI Labs on your latest project?</label>
            <input type="text" name="projectsatisfy" id="project-satisfy" disabled class="short-field"
                <?php
                  echo 'value="'.htmlentities($ViewData["rate_proj_satisfy"]).'"';
                ?> tabindex="6" />
            </fieldset>

            <fieldset>
            <label for="service-feedback">Please provide additional feedback regarding the aspects of the service with which you were particularly satisfied or dissatisfied.</label>
            <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" tabindex="7"><?php if($ViewData['feedback_on_service'] != 'none') echo stripcslashes($ViewData['feedback_on_service']); ?></textarea>
            </fieldset>

            <fieldset>
            <label for="rate-onboarding">How would you rate the onboarding / sample submission process?</label>
            <input type="text" name="onboarding" id="onboarding" disabled class="short-field"
                <?php
                  echo 'value="'.htmlentities($ViewData["rate_onboarding"]).'"';
                ?> tabindex="8" />
            </fieldset>

            <fieldset>
            <label for="timeliness">How would you rate the timeliness of receiving results from our service?</label>
            <input type="text" name="timeliness" id="timeliness" disabled class="short-field"
                <?php
                  echo 'value="'.htmlentities($ViewData["rate_timeliness"]).'"';
                ?> tabindex="9" />
            </fieldset>

            <fieldset>
            <label for="quality">How satisfied are you with the quality of, and information contained in, the data reports provided as part of our service?</label>
            <input type="text" name="quality" id="quality" disabled class="short-field" <?php
                  echo 'value="'.htmlentities($ViewData["rate_quality"]).'"';
                ?> tabindex="10" />
            </fieldset>

            <fieldset>
            <label for="data-analysis">Would you be interested in additional data analysis services?</label>
            <input type="text" name="dataanalysis" id="data-analysis" disabled class="short-field" <?php
                  $dataanalysis = $ViewData["data_a_services"] == 1 ? 'YES' : 'NO';
                  echo 'value="'.htmlentities($dataanalysis).'"';
                ?> tabindex="11" />
            </fieldset>

            <fieldset>
            <label for="service-inquires">How responsive and helpful have you found our team in addressing your inquires or issues related to our service?</label>
            <input type="text" name="serviceinquires" id="service-inquires" disabled class="short-field"
                <?php
                  echo 'value="'.htmlentities($ViewData["rate_responsivness"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="recommendation">How likely are you to recommend our proteomics service to others in your field?</label>
            <input type="text" name="recommendation" id="recommendation" disabled class="short-field"
                <?php
                  echo 'value="'.htmlentities($ViewData["rate_recommendation"]).'"';
                ?> tabindex="13" />
            </fieldset>

            <fieldset>
                 <label for="additional-studies">Will your research need additional studies on our platforms, such as the same service with a larger sample number, validation services (fewer targets/more samples) or a different service offering?</label>
                   <textarea name="additionalstudies" id="additional-studies" rows="1" cols="1" tabindex="14"><?php if($ViewData['add_studies'] != 'none') echo stripcslashes($ViewData['add_studies']); ?></textarea>
            </fieldset>

            <fieldset>
                 <label for="new-prodservices">Will your research need additional studies on our platforms, such as the same service with a larger sample number, validation services (fewer targets/more samples) or a different service offering?</label>
                   <textarea name="newprodservices" id="new-prodservices" rows="1" cols="1" tabindex="15"><?php if($ViewData['new_pr_services'] != 'none') echo stripcslashes($ViewData['new_pr_services']); ?></textarea>
            </fieldset>

            <fieldset>
                 <label for="service-results">If you are able to share, how do you think that the results from these services will further your research?</label>
                   <textarea name="serviceresults" id="service-results" rows="1" cols="1" tabindex="16"><?php if($ViewData['on_research_results'] != 'none') echo stripcslashes($ViewData['on_research_results']); ?></textarea>
            </fieldset>

            <fieldset>
            <label for="share-feedback">Would you consider allowing us to share your feedback in our marketing materials (including social media, web, and collateral)? If yes, we will conatct you to discuss specifics before using your feedback.</label>
            <input type="text" name="sharefeedback" id="share-feedback" disabled class="short-field" <?php
                  $share = $ViewData["share_on_social"] == 1 ? 'YES' : 'NO';
                  echo 'value="'.htmlentities($share).'"';
                ?> tabindex="17" />
            </fieldset>

            <fieldset>
            <label for="Referrer Page">Referrer Page</label>
            <input type="text" name="referrer" id="referrer"
                <?php
                  echo 'value="'.htmlentities($ViewData["referrer"]).'"';
                ?> tabindex="18" />
            </fieldset>

            <fieldset>
            <label for="newsupdates">Would you consider allowing us to share your feedback in our marketing materials (including social media, web, and collateral)? If yes, we will conatct you to discuss specifics before using your feedback.</label>
            <input type="text" name="newsupdates" id="newsupdates" disabled class="short-field" <?php
                  $news = $ViewData["receive_news"] == 1 ? 'YES' : 'NO';
                  echo 'value="'.htmlentities($share).'"';
                ?> tabindex="19" />
            </fieldset>

            <fieldset id="user-submit">
                
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>

