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
        $PageUrl = "/admin/support/request-info/export-leads.php";
        $PageCode = "000000";
        $bodyid = "support";
        $data = $dbhelper->selectAll("SELECT firstname, lastname, email, company, occupation, zip, country, phone, sample_num, platform, assay_goal, inquiry, referrer, heard_from, newsletter, DATE_FORMAT(created,'%b %d, %Y') AS created FROM cdivisitor ORDER BY created DESC");
        header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8");
        header( "Content-Disposition: attachment; filename = CDI-Labs-US-leads.xls" );
        echo "<meta http-equiv=\"Content-Type\" content=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8\">";
        }else{
           header('Location: /admin/support/request-info/list');
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
        <td><strong>Date</strong></td>
        <td><strong>First Name</strong></td>
        <td><strong>Last Name</strong></td>
        <td><strong>Email</strong></td>
        <td><strong>Company</strong></td>
        <td><strong>Job Title</strong></td>
        <td><strong>Zip Code</strong></td>
        <td><strong>Country</strong></td>
        <td><strong>Phone</strong></td>
        <td><strong>Estimated Sample Number</strong></td>
        <td><strong>Platform of Interest</strong></td>
        <td><strong>Assay Goal</strong></td>
        <td><strong>Questions / Requests</strong></td>
        <td><strong>How did you hear about us?</strong></td>
        <td><strong>Referrer</strong></td>
        <td><strong>Receive Newsletter?</strong></td>
    </tr>
    <?php 
        if(!empty($data) && count($data) > 0){
            foreach ($data as $row){
              $subscribed = $row['newsletter'] == 1 ? 'YES' : 'NO';
              $phone = trim($row["phone"]);
    ?>
    <tr>
        <td><?php echo $row["created"]; ?></td>
        <td><?php echo $row["firstname"]; ?></td>
        <td><?php echo $row["lastname"]; ?></td>
        <td><?php echo $row["email"]; ?></td>
        <td><?php echo $row["company"]; ?></td>
        <td><?php echo $row["occupation"]; ?></td>
        <td><?php echo $row["zip"]; ?></td>
        <td><?php echo $row["country"]; ?></td>
        <td><?php echo $phone; ?></td>
        <td><?php echo $row["sample_num"]; ?></td>
        <td><?php echo $row["platform"]; ?></td>
        <td><?php echo $row["assay_goal"]; ?></td>
        <td><?php echo $row["inquiry"]; ?></td>
        <td><?php echo $row["heard_from"]; ?></td>
        <td><?php echo $row["referrer"]; ?></td>
        <td><?php echo $subscribed; ?></td>
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
