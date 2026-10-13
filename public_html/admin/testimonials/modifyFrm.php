<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $PageUrl = "/admin/testimonials/modifyFrm";
      $PageCode = "000000";
      $bodyid = "company";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT slugurl FROM testimonials WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM testimonials WHERE pkid = $pkid ");
       }else{
        header('Location:/admin/testimonials/list');
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
<title>Edit Testimonial | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" /> 
<style>
 #enter-data{width:100%}
  #enter-data fieldset{width:60%}
  #enter-data .upload-tmb{width:44%}
  #enter-data .page-field{width:90%}
 .page-field .jodit-workplace{height:500px !important}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT TESTIMONIAL</h2>

            <form method="post" name="modifyForm" action="/admin/testimonials/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldthumbnail" value="<?php echo $ViewData["thumbnail"]; ?>" />
                <input type="hidden" name="oldheroimg" value="<?php echo $ViewData["hero_img"]; ?>" />
                <input type="hidden" name="oldmobileimg" value="<?php echo $ViewData["mobile_img"]; ?>" />

            <fieldset>
                <label for="Company / Organization">Company / Organization<span>*</span></label>
                <input type="text" name="companyname" id="company-name" value="<?php echo $ViewData['company']; ?>" class="get-value" placeholder="<?php echo $ViewData['company']; ?>" maxlength="200" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Customer">Customer<span>*</span></label>
                <input type="text" name="customer" id="customer" value="<?php echo $ViewData['customer']; ?>" class="get-value" placeholder="<?php echo $ViewData['customer']; ?>" maxlength="200" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Job Title">Job Title<span>*</span></label>
                <input type="text" name="jobtitle" id="job-title" value="<?php echo $ViewData['job_title']; ?>" class="get-value" placeholder="<?php echo $ViewData['job_title']; ?>" maxlength="200" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Quote">Customer Quote<span>*</span></label>
                 <textarea name="quote" value="<?php echo $ViewData['quote']; ?>" class="get-value" id="quote" placeholder="Enter quote text without quotes*" rows="1" cols="1" minlength="50" maxlength="4000" class="get-value" tabindex="4"><?php echo stripcslashes($ViewData['quote']); ?></textarea>
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['slugurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['slugurl']; ?>" maxlength="255" tabindex="5" />
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="THUMBNAIL">THUMBNAIL<span>*</span></label>
            <input type="file" name="thumbnail" tabindex="6" />
            <?php 
             if(!empty($ViewData["thumbnail"]) && $ViewData["thumbnail"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/testimonials/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="5" />
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
<script src="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js"></script>
<script>
 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     var regField = [];
     $.each($('.get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       $('#submit-btn').prop('disabled', true);
       $('#submit-btn').val('Please Wait').css('background','#7d868c');
       var f = document.modifyForm;
       f.submit();
     }
 });
</script>

