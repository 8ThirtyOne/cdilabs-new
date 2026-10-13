<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    $PageUrl = "/admin/company/team/registerFrm";
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
<title>Add New Employee Spotlight | CDI Labs</title>
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

            <h2>ADD NEW EMPLOYEE SPOTLIGHT</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = strtoupper($error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/company/team/register" id="enter-data" enctype="multipart/form-data">

            <fieldset>
                <label for="First Name">First Name<span>*</span></label>
                <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" maxlength="100" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Last Name">Last Name<span>*</span></label>
                <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" maxlength="100" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Job Title">Job Title<span>*</span></label>
                <input type="text" name="jobtitle" id="job-title" class="get-value" placeholder="*Job Title" maxlength="150" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Job Location">Job Location<span>*</span></label>
                <input type="text" name="joblocation" id="job-location" class="get-value" placeholder="*Job Location" maxlength="50" tabindex="4" />
            </fieldset>

            <fieldset class="upload-field upload-tmb" id="upload-desktop">
                <label for="HERO IMAGE"><span>*</span>HERO IMAGE</label>
                <input type="file" name="hero_img" tabindex="5" />
            </fieldset>

            <fieldset class="upload-field upload-tmb">
                <label for="MOBILE HERO IMAGE"><span>*</span>THUMB/MOBILE HERO IMAGE</label>
                <input type="file" name="mobile_img" tabindex="6" />
            </fieldset>

            <fieldset>
                <label for="Quote">Employee Quote<span>*</span></label>
                <textarea name="quote" class="get-value" id="quote" placeholder="*Enter employee quote" rows="1" cols="1" minlength="50" maxlength="300" class="get-value" tabindex="7"></textarea>
            </fieldset>

            <fieldset class="page-field">
               <label for="page body">Page Body</label>
               <textarea id="page-body" name="pagebody" class="get-value" tabindex="8"></textarea>
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="9" />
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
var bodyEditor = Jodit.make('#page-body');

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
   if(isBodyEmpty(bodyEditor.value)) bodyEditor.value = '';
   $('#submit-btn').prop('disabled', true);
   $('#submit-btn').val('Please Wait').css('background','#7d868c');
   var f = document.regFrm;
   f.submit();
 }
});

function isBodyEmpty(input) {
   if(input.replace(/<(.|\n)*?>/g, '').trim().length === 0 && !input.includes("<div")){
      return true;
   }
  return false;
}
</script>
</body>
</html>
