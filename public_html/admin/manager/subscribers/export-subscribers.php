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
        $PageUrl = "/admin/manager/subscribers/export-subscribers";
        $PageCode = "000000";
        $bodyid = "support";
        $data = $dbhelper->selectAll("SELECT firstname, lastname, email, DATE_FORMAT(created,'%b %d, %Y') AS created FROM web_subscribers ORDER BY created DESC");
        header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8");
        header( "Content-Disposition: attachment; filename = CDI-Labs-US-subscribers.xls" );
        echo "<meta http-equiv=\"Content-Type\" content=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8\">";
        }else{
           header('Location: /admin/manager/subscribers/list');
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
    </tr>
    <?php 
        if(!empty($data) && count($data) > 0){
          foreach ($data as $row){
    ?>
    <tr>
        <td><?php echo $row["created"]; ?></td>
        <td><?php echo $row["firstname"]; ?></td>
        <td><?php echo $row["lastname"]; ?></td>
        <td><?php echo $row["email"]; ?></td>
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

