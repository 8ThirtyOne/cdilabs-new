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
    $PageUrl = "/admin/testimonials/registerFrm";
    $PageCode = "000000";
    $bodyid = "company";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
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
<title>Add New Customer Testimonial | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
 #enter-data{width:100%}
  #enter-data fieldset{width:60%}
  #enter-data .upload-tmb{width:44%}
  #enter-data #upload-desktop{width:32.5%;clear:left}
  #enter-data .page-field{width:90%}
 .page-field .jodit-workplace{height:500px !important}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>ADD NEW CUSTOMER TESTIMONIAL</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = strtoupper($error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/testimonials/register" id="enter-data" enctype="multipart/form-data">

            <fieldset>
                <label for="Company / Organization">Company / Organization<span>*</span></label>
                <input type="text" name="companyname" id="company-name" class="get-value" placeholder="Company / Organization*" minlength="5" maxlength="200" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Customer Name">Customer Name<span>*</span></label>
                <input type="text" name="customer" id="customer" class="get-value" placeholder="Customer Name*" minlength="5" maxlength="200" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Job Title">Job Title<span>*</span></label>
                <input type="text" name="jobtitle" id="job-title" class="get-value" placeholder="Job Title*" minlength="5" maxlength="200" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Customer Quote">Customer Quote<span>*</span></label>
                <textarea name="quote" class="get-value" id="quote" placeholder="Customer Quote*" rows="1" cols="1" minlength="10" maxlength="4000" class="get-value" tabindex="4"></textarea>
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" class="get-value" placeholder="Slug Url*" maxlength="255" tabindex="5" />
            </fieldset>

            <fieldset class="upload-field upload-tmb" id="upload-thumb">
                <label for="THUMBNAIL"><span>*</span>THUMBNAIL</label>
                <input type="file" name="thumbnail" tabindex="6" />
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="7" />
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
 $('#error-box').remove();
 var errorBox = $(document.createElement('fieldset'));
 var errorText = $(document.createElement('li'));
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
   var f = document.regFrm;
   f.submit();
 }
});
</script>
</body>
</html>
