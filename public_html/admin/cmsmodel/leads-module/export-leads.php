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
            if(isset($_GET['category']) && !empty($_GET['category'])){
                $PageUrl = "/admin/cmsmodel/leads-module/export-leads";
                $PageCode = "000000";
                $cmscat = $webhelper->RequestFilter("category", 50, false);
                $catExists = $dbhelper->numOfrows('SELECT pkid FROM web_page WHERE cat=?', 's', $cmscat);
                if($catExists > 0){
                    switch($cmscat){
                        case 'promo': 
                            $cat = 'promotions';
                            $catTitle = ucfirst($cat);
                            break;
                    }
                    $contactData = $dbhelper->selectAll("SELECT firstname, lastname, email, company, occupation, zip, country, phone, sample_num, platform, assay_goal, inquiry, referrer, heard_from, newsletter, DATE_FORMAT(created,'%b %d, %Y') AS created FROM cdivisitor WHERE category = '$cat' ORDER BY created DESC");
                    $promoData = $dbhelper->selectAll("SELECT firstname, lastname, email, company, jobtitle, country, product, sampleavail, sampletype, abstract, description, newsletter, referrer, DATE_FORMAT(created,'%b %d, %Y') AS created FROM promotion_leads WHERE category = '$cat' ORDER BY created DESC");
                    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8");
                    header( "Content-Disposition: attachment; filename = CDI-Labs-".$catTitle."-Leads.xls" );
                    echo "<meta http-equiv=\"Content-Type\" content=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8\">";
                }
            }else{
                header('Location: /admin/cmsmodel/leads');
                exit;
            }
        }else{
            header('Location: /admin/cmsmodel/leads');
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
<style>
td {
  vertical-align:top;
}
</style>
<table border="1">
    <?php 
        if(!empty($promoData) && count($promoData) > 0){
        echo "<th colspan='15' style='background:#ccc;text-align:left'><strong>GRANT FORM</strong></th>
         <tr>
            <td><strong>Date</strong></td>
            <td><strong>First Name</strong></td>
            <td><strong>Last Name</strong></td>
            <td><strong>Email</strong></td>
            <td><strong>Company</strong></td>
            <td><strong>Job Title</strong></td>
            <td><strong>Country</strong></td>
            <td><strong>Product</strong></td>
            <td><strong>Sample Availability</strong></td>
            <td><strong>Sample Type</strong></td>
            <td><strong>Abstract Title</strong></td>
            <td><strong>Project Description</strong></td>
            <td><strong>Referrer</strong></td>
            <td><strong>Receive Newsletter?</strong></td>
        </tr>"; 
        foreach ($promoData as $Prow){
          $Psubscribed = $Prow['newsletter'] == 1 ? 'YES' : 'NO';
          echo "<tr>
            <td>{$Prow['created']}</td>
            <td>{$Prow['firstname']}</td>
            <td>{$Prow['lastname']}</td>
            <td>{$Prow['email']}</td>
            <td>{$Prow['company']}</td>
            <td>{$Prow['jobtitle']}</td>
            <td>{$Prow['country']}</td>
            <td>{$Prow['product']}</td>
            <td>{$Prow['sampleavail']}</td>
            <td>{$Prow['sampletype']}</td>
            <td>{$Prow['abstract']}</td>
            <td>{$Prow['description']}</td>
            <td>{$Prow['referrer']}</td>
            <td>$Psubscribed</td>
          </tr>";
        }
    }
    if(!empty($contactData) && count($contactData) > 0){
        echo "<th colspan='15' style='background:#ccc;text-align:left'><strong>CONTACT FORM</strong></th>
          <tr>
            <td><strong>Date</strong></td>
            <td><strong>Name</strong></td>
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
        </tr>"; 
        foreach ($contactData as $row){
          $name = $row['firstname'].' '.$row['lastname'];
          $subscribed = $row['newsletter'] == 1 ? 'YES' : 'NO';
          $phone = trim($row['phone']);
          echo "<tr>
            <td>{$row['created']}</td>
            <td>$name</td>
            <td>{$row['email']}</td>
            <td>{$row['company']}</td>
            <td>{$row['occupation']}</td>
            <td>{$row['zip']}</td>
            <td>{$row['country']}</td>
            <td>$phone</td>
            <td>{$row['sample_num']}</td>
            <td>{$row['platform']}</td>
            <td>{$row['assay_goal']}</td>
            <td>{$row['inquiry']}</td>
            <td>{$row['heard_from']}</td>
            <td>{$row['referrer']}</td>
            <td>$subscribed</td>
          </tr>";
        }
    }
    ?>
</table>
