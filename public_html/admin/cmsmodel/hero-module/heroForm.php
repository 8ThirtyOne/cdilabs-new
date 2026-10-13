<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username) && $username > 0){
       if(isset($_GET['pkid']) && !empty($_GET['pkid']) && isset($_GET['category'])){
            $pageId = $webhelper->RequestFilter("pkid", 0, false);
            $cmscat = $webhelper->RequestFilter("category", 50, false);
            $PageUrl = "/admin/cmsmodel/hero-module/heroForm";
            $pageExists = $dbhelper->numOfRows("SELECT slugurl FROM web_page WHERE pkid = ? AND cat='$cmscat'", 's', $pageId);
            if($pageExists > 0){
                $PageCode = "000000";
                $bodyid = $cmscat;
                $FirstPageCode = substr($PageCode, 0, 2);
                $SecodeCode = substr($PageCode, 2, 2);
                $ThirdCode = substr($PageCode, 4, 2);
            }else{
                header('Location: /admin/cmsmodel/errorPage?reason=no-page-found');
                exit;
            }
        }else{
           header('Location: /admin/cmsmodel/errorPage?reason=no-page-found');
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
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Add New Hero Slide | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main>
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="module-section">

            <h2>Add New Hero Slide</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/cmsmodel/hero-module/addHero" id="module-data" enctype="multipart/form-data">
            <input type="hidden" name="pkid" value="<?php echo $pageId; ?>" />
            <input type="hidden" name="cmscategory" value="<?php echo $cmscat; ?>" />

            <section class="page-section" id="page-hero">

                <div class="section-heading tall-heading">
                    <h3>HERO SECTION</h3>
                    <div class="select-type">
                        <input type="hidden" name="herolayout" id="hero-layout" value="left" />
                        <div class="select-box" id="select-hero-layout">
                          <ul>
                            <li><a href="#left" class="current choice">Left Alignment<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#center" class="smooth-hover choice">Center Alignment<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#right" class="smooth-hover choice">Right Alignment<i class="fa fa-caret-down"></i></a></li>
                          </ul>
                        </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="herobg" id="hero-bg" value="white" />
                        <div class="select-box" id="select-hero-bg">
                          <ul>
                            <li><a href="#white" class="current choice">White<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#dark" class="smooth-hover choice">Dark<i class="fa fa-caret-down"></i></a></li>
                          </ul>
                        </div>
                    </div>
                    
                </div>

                <div class="section-part section-on hero-part">

                    <fieldset class="upload-field img-upload">
                        <label for="Desktop Hero">Desktop<span>*</span></label>
                        <input type="file" name="herodesktop" tabindex="4">
                        <p>Accepted file types: <span>mp4, mov, jpg, gif, webp</span></p>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Hero">Mobile<span>*</span></label>
                        <input type="file" name="heromobile" tabindex="5">
                        <p>Accepted file types: <span>jpg, png, gif, webp</span></p>
                    </fieldset>

                    <fieldset>
                        <label for="hero-subtitle">Subtitle</label>
                        <input type="text" name="herosubtitle" id="hero-subtitle" class="page-short-input" maxlength="100" tabindex="6" />
                    </fieldset>

                    <fieldset>
                        <label for="hero-title">Main Title</label>
                        <input type="text" name="herotitle" id="hero-title" class="page-short-input" maxlength="100" tabindex="7" />
                    </fieldset>

                    <fieldset>
                     <label for="hero paragraph">Paragraph</label>
                     <textarea id="hero-body" name="heroparagraph" tabindex="8"></textarea>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="section-cta">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name="herobtn" class="section-cta" maxlength="20" tabindex="9" />
                        </div>
                        <div class="request-checkboxes">
                              <div>
                                <label for="Outbound Link?">Outbound Link?</label>
                                <input type="checkbox" name="hero-outbound" value="1" tabindex="10" />
                              </div>
                        </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name="herourl" class="page-short-input" maxlength="255" tabindex="11" />
                        </div>
                    </fieldset>

                </div>

            </section>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="12" />
            </fieldset>

        </form>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script src="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js"></script>
<script>
var heroEditor = Jodit.make('#hero-body');
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
   if(isBodyEmpty(heroEditor.value)) heroEditor.value = '';
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

var selectBox = $('.select-box');
var selectBoxUl = $('.select-box ul');

$('.select-box a').each(function(index){
    $(this).click(function(e){
      var $this = $(this);
      var opened = $this.closest('.page-section').find('.select-open').attr('id');
      if(opened){
        $('#'+opened).animate({
           height: "30px"
          }, {
          duration: 200,
          specialEasing:{
          width: 'linear'
          }
        });
        $('#'+opened).removeClass('select-open');
      }
      var choiceName = $this.attr('class');
      var id = $this.closest('div').attr('id');
      var dropdownH = $('#'+id)[0].scrollHeight;

      if(choiceName = 'smooth-hover choice'){
        var current = $this.closest('div').find('.current');
        $this.insertBefore(current);
        current.removeClass('current').addClass('smooth-hover');
        current.find('.fa').hide();
        $this.removeClass('smooth-hover').addClass('current');
        $this.find('.fa').show();
      }
        var choice = $this.attr('href');
        var filter = choice.split("#").pop();
        var choiceInput = $this.closest('.select-type').find('input');
        choiceInput.val(filter);

      if($('#'+id).height() > 30){
        $('#'+id).animate({
           height: "30px"
          }, {
          duration: 200,
          specialEasing:{
          width: 'linear'
          }
        });
      }else{
        $('#'+id).animate({
           height: dropdownH+'px'
          }, {
          duration: 200,
          specialEasing:{
          width:'linear'
          }
        });
        $('#'+id).addClass('select-open');
      }
      e.preventDefault();
  });

});

$(window).click(function(e) {
  var link = $('.select-box li');
  var selectBox = $(".select-box");

  selectBox.each(function(index){
    var box = this.id;
    //if clicked anywhere on window but dropbox link
    if(!link.is(e.target)){
       if($('#'+box).height() > 30){
        $('#'+box).animate({
           height: "30px"
          }, {
          duration: 200,
          specialEasing:{
          width: 'linear'
          }
        });
       }
    }
  });
});
</script>
</script>
</body>
</html>
