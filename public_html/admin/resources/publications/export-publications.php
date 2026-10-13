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
        $PageUrl = "/admin/resources/publications/export-publications";
        $PageCode = "000000";
        $bodyid = "support";
        $data = $dbhelper->selectAll("SELECT title, authors, publisher, institution, link, body, keywords, main_product, sub_cat, month, day, year, orgfilename, DATE_FORMAT(created,'%b %d, %Y') AS created FROM publications ORDER BY year DESC, month DESC, day DESC");
        header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8");
        header( "Content-Disposition: attachment; filename = CDI-Labs-US-Publications.xls" );
        echo "<meta http-equiv=\"Content-Type\" content=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8\">";
        }else{
           header('Location: /admin/resources/publications/list');
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
        <td><strong>Title</strong></td>
        <td><strong>Authors</strong></td>
        <td><strong>Publisher</strong></td>
        <td><strong>Institution</strong></td>
        <td><strong>Date</strong></td>
        <td><strong>Url</strong></td>
        <td><strong>Description</strong></td>
        <td><strong>Keywords</strong></td>
        <td><strong>Main Product</strong></td>
        <td><strong>Sub Category</strong></td>
        <td><strong>File Name</strong></td>
        <td><strong>Created</strong></td>
    </tr>
    <?php 
        if(!empty($data) && count($data) > 0){
            foreach ($data as $row){
    ?>
    <tr>
        <td><?php echo $row["title"]; ?></td>
        <td><?php echo $row["authors"]; ?></td>
        <td><?php echo $row["publisher"]; ?></td>
        <td><?php echo $row["institution"]; ?></td>
        <td><?php echo $row['month'].'-'.$row['day'].'-'.$row['year']; ?></td>
        <td><?php echo $row["link"]; ?></td>
        <td><?php echo $row["body"]; ?></td>
        <td><?php echo $row["keywords"]; ?></td>
        <td><?php echo $row["main_product"]; ?></td>
        <td><?php echo $row["sub_cat"]; ?></td>
        <td><?php echo $row["orgfilename"]; ?></td>
        <td><?php echo $row["created"]; ?></td>
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

