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
        $PageUrl = "/admin/resources/videos/export-leads";
        $PageCode = "040000";
        $bodyid = "resources";
        $data = $dbhelper->selectAll("SELECT first, last, email, company, phone, country, inquiry, newsletter, referrer, DATE_FORMAT(created,'%b %d, %Y') AS created FROM registration_users ORDER BY created DESC");
        header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8");
        header( "Content-Disposition: attachment; filename = CDI-Labs-US-Registration-Users.xls" );
        echo "<meta http-equiv=\"Content-Type\" content=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8\">";
        }else{
           header('Location: /admin/resources/videos/list');
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
        <td><strong>Phone</strong></td>
        <td><strong>Country</strong></td>
        <td><strong>Inquiry</strong></td>
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
        <td><?php echo $row["first"]; ?></td>
        <td><?php echo $row["last"]; ?></td>
        <td><?php echo $row["email"]; ?></td>
        <td><?php echo $row["company"]; ?></td>
        <td><?php echo $phone; ?></td>
        <td><?php echo $row["country"]; ?></td>
        <td><?php echo $row["inquiry"]; ?></td>
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

