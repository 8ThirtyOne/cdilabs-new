<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $input = $webhelper->RequestFilter('user', 255, false);
    $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
    if(!empty($username)){
        $isAdmin = $dbhelper->selectOne('SELECT isAdministrator FROM admin WHERE pkid = ?', 'i', $input);
        if($isAdmin == 1){
        $PageUrl = "/admin/company/customer-survey/export-leads";
        $PageCode = "000000";
        $bodyid = "support";
        $data = $dbhelper->selectAll("SELECT firstname, lastname, email, organization, occupation, rate_proj_satisfy, feedback_on_service, rate_onboarding, rate_timeliness, rate_quality, data_a_services, rate_responsivness, rate_recommendation, add_studies, new_pr_services, on_research_results, share_on_social, receive_news, referrer, DATE_FORMAT(created,'%b %d, %Y') AS created FROM cdi_customer_survey ORDER BY created DESC");
        header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8");
        header( "Content-Disposition: attachment; filename = CDI-Labs-Customer-Survey-Leads.xls" );
        echo "<meta http-equiv=\"Content-Type\" content=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8\">";
        }else{
           header('Location: /admin/company/customer-survey/list');
           exit; 
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
<table border="1">
    <tr>
        <td valign='top'><strong>Date</strong></td>
        <td valign='top'><strong>Name</strong></td>
        <td valign='top'><strong>Email</strong></td>
        <td valign='top'><strong>Company Name</strong></td>
        <td valign='top'><strong>Job Title</strong></td>
        <td valign='top'><strong>What is your overall satisfaction level working with CDI Labs on your latest project?</strong></td>
        <td valign='top'><strong>Please provide additional feedback regarding the aspects of the service with which you were particularly satisfied or dissatisfied.</strong></td>
        <td valign='top'><strong>How would you rate the onboarding / sample submission process?</strong></td>
        <td valign='top'><strong>How would you rate the timeliness of receiving results from our service?</strong></td>
        <td valign='top'><strong>How satisfied are you with the quality of, and information contained in, the data reports provided as part of our service?</strong></td>
        <td valign='top'><strong>Would you be interested in additional data analysis services?</strong></td>
        <td valign='top'><strong>How responsive and helpful have you found our team in addressing your inquires or issues related to our service?</strong></td>
        <td valign='top'><strong>How likely are you to recommend our proteomics service to others in your field?</strong></td>
        <td valign='top'><strong>Will your research need additional studies on our platforms, such as the same service with a larger sample number, validation services (fewer targets/more samples) or a different service offering?</strong></td>
        <td valign='top'><strong>Are there any new products or services that you think CDI Labs should consider offering?</strong></td>
        <td valign='top'><strong>If you are able to share, how do you think that the results from these services will further your research?</strong></td>
        <td valign='top'><strong>Would you consider allowing us to share your feedback in our marketing materials (including social media, web, and collateral)? If yes, we will conatct you to discuss specifics before using your feedback.</strong></td>
        <td valign='top'><strong>Referrer</strong></td>
        <td valign='top'><strong>Receive Newsletter?</strong></td>
    </tr>
    <?php 
        if(!empty($data) && count($data) > 0){
            foreach ($data as $row){
              $dataanalysis = $row['data_a_services'] == 1 ? 'YES' : 'NO';
              $share = $row['share_on_social'] == 1 ? 'YES' : 'NO';
              $subscribed = $row['receive_news'] == 1 ? 'YES' : 'NO';
    ?>
    <tr>
        <td valign='top'><?php echo $row["created"]; ?></td>
        <td valign='top'><?php echo $row["firstname"].' '.$row["lastname"]; ?></td>
        <td valign='top'><?php echo $row["email"]; ?></td>
        <td valign='top'><?php echo $row["organization"]; ?></td>
        <td valign='top'><?php echo $row["occupation"]; ?></td>
        <td valign='top'><?php echo $row["rate_proj_satisfy"]; ?></td>
        <td valign='top'><?php echo $row["feedback_on_service"]; ?></td>
        <td valign='top'><?php echo $row["rate_onboarding"]; ?></td>
        <td valign='top'><?php echo $row["rate_timeliness"]; ?></td>
        <td valign='top'><?php echo $row["rate_quality"]; ?></td>
        <td valign='top'><?php echo $dataanalysis; ?></td>
        <td valign='top'><?php echo $row["rate_responsivness"]; ?></td>
        <td valign='top'><?php echo $row["rate_recommendation"]; ?></td>
        <td valign='top'><?php echo $row["add_studies"]; ?></td>
        <td valign='top'><?php echo $row["new_pr_services"]; ?></td>
        <td valign='top'><?php echo $row["on_research_results"]; ?></td>
        <td valign='top'><?php echo $share; ?></td>
        <td valign='top'><?php echo $row["referrer"]; ?></td>
        <td valign='top'><?php echo $subscribed; ?></td>
    </tr>
    <?php
            }
        }
        else{
    ?>
        <tr>
            <td colspan="5" align="center">No data found.</td>
        </tr>
    <?php
        }
    ?>
</table>
