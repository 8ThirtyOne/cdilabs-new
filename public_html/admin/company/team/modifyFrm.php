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
      $PageUrl = "/admin/company/team/modifyFrm";
      $PageCode = "000000";
      $bodyid = "company";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT first_name FROM employee_page WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM employee_page WHERE pkid = $pkid ");
       }else{
        header('Location:/admin/company/team/list');
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
<title>Edit Team | CDI Labs</title>
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

            <h2>EDIT EMPLOYEE PROFILE</h2>

            <form method="post" name="modifyForm" action="/admin/company/team/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldheroimg" value="<?php echo $ViewData["hero_img"]; ?>" />
                <input type="hidden" name="oldmobileheroimg" value="<?php echo $ViewData["mobile_img"]; ?>" />

            <fieldset>
                <label for="First Name"><span>*</span>First Name</label>
                <input type="text" name="first" id="first" value="<?php echo $ViewData['first_name']; ?>" class="get-value" placeholder="<?php echo $ViewData['first_name']; ?>" maxlength="50" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Last Name"><span>*</span>Last Name</label>
                <input type="text" name="last" id="last" value="<?php echo stripcslashes($ViewData['last_name']); ?>" class="get-value" placeholder="<?php echo stripcslashes($ViewData['last_name']); ?>" maxlength="50" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Job Title"><span>*</span>Job Title</label>
                <input type="text" name="jobtitle" id="job-title" value="<?php echo $ViewData['job_pos']; ?>" class="get-value" placeholder="<?php echo $ViewData['job_pos']; ?>" maxlength="250" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Job Location"><span>*</span>Job Location</label>
                <input type="text" name="joblocation" id="job-location" value="<?php echo $ViewData['job_loc']; ?>" class="get-value" placeholder="<?php echo $ViewData['job_loc']; ?>" maxlength="250" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Quote"><span>*</span>Employee Quote</label>
                 <textarea name="quote" value="<?php echo $ViewData['profile_quote']; ?>" class="get-value" id="quote" placeholder="*Enter employee quote text without quotes" rows="1" cols="1" minlength="50" maxlength="300" class="get-value" tabindex="4"><?php echo $ViewData['profile_quote']; ?></textarea>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Hero Image"><span>*</span>DESKTOP HERO IMAGE</label>
            <input type="file" name="hero_img" tabindex="11" />
            <?php 
             if(!empty($ViewData["hero_img"]) && $ViewData["hero_img"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/team/" . $ViewData["hero_img"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Mobile Hero Image"><span>*</span>THUMB/MOBILE HERO IMAGE</label>
            <input type="file" name="mobile_img" tabindex="11" />
            <?php 
             if(!empty($ViewData["mobile_img"]) && $ViewData["mobile_img"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/team/" . $ViewData["mobile_img"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>


            <fieldset class="page-field">
               <label for="page body">Page Body</label>
               <textarea id="page-body" name="pagebody" tabindex="7"><?php echo stripcslashes($ViewData['page_body']); ?></textarea>
            </fieldset>

            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="13" />
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
       var f = document.modifyForm;
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

