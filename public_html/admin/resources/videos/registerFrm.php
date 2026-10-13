<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   if($input == 0){
     header('Location: /admin/');
     exit;
   }else{
       $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
       if(!empty($username)){
        $PageUrl = "/admin/resources/videos";
        $PageCode = "000000";
        $bodyid = "resources";
        $FirstPageCode = substr($PageCode, 0, 2);
        $SecodeCode = substr($PageCode, 2, 2);
        $ThirdCode = substr($PageCode, 4, 2);
        }else{
            header('Location: /admin/');
            exit;
        }
   }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Add Video | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
    #enter-data .jodit-workplace{height:250px !important}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>ADD NEW VIDEO</h2>

            <form method="post" name="regFrm" action="/admin/resources/videos/register" id="enter-data" enctype="multipart/form-data">

            <fieldset id="field-one">

                <input type="hidden" name="type" id="type" value="" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current"><a href="#">Select Type*<i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#1">Techology</a></li>
                    <li class="choice"><a href="#2">Webinar</a></li>
                    <li class="choice"><a href="#3">Event</a></li>
                    <li class="choice"><a href="#4">Other</a></li>
                  </ul>
                </div>
              </div>
              
            </fieldset>

            <fieldset class="request-checkboxes" id="permission-fileds">

                <div>
                <input type="radio" name="permission" value="1" checked="checked" tabindex="1" /><label for="Public">Public</label>
                </div>
                <div>
                <input type="radio" name="permission" value="0" tabindex="2" /><label for="Register">Register</label>
                </div>
             
            </fieldset>

            <fieldset>
                <label for="Title">Title<span>*</span></label>
                <input type="text" name="title" class="get-value" id="title" placeholder="Title*" maxlength="255" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Subtitle">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" placeholder="Subtitle" maxlength="500" tabindex="4" />
            </fieldset>

            <fieldset>
                <p class="field-eg">Only copy and paste id in red. Eg. https://www.youtube.com/watch?v=<span style="color:red;">abcd1234</span></p>
                <label for="YouTube Video Id">YouTube Video Id<span>*</span></label>
                <input type="text" name="youtubeurl" id="youtube-url" class="get-value" placeholder="YouTube Video Id*" maxlength="255" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" class="get-value" placeholder="Slug Url*" maxlength="255" tabindex="6" />
            </fieldset>

            <fieldset class="body-field">
                 <p class="field-eg">Page Body for Speaker, institution, lists, other info. (NO ABSTRACT)</p>
                 <label for="Page Body">Page Body</label>
                 <textarea id="video-body" name="pagebody" tabindex="7"></textarea>
            </fieldset>

            <fieldset>
                 <label for="Description"><span>*</span>Abstract (short info)</label>
                   <textarea name="description" id="description" placeholder="Abstract* (short info)" rows="1" cols="1" minlength="10" maxlength="800" tabindex="8"></textarea>
            </fieldset>

            <fieldset>
                <label for="Keywords">Keywords</label>
                <input type="text" name="keywords" id="keywords" placeholder="Keywords" maxlength="255" tabindex="9" />
            </fieldset>

            <fieldset class="upload-field">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE <span class="field-eg">(800x400)</span></label>
            <input type="file" name="thumbnail" tabindex="10" />
            </fieldset>

            <fieldset id="select-categories">
                <label for="Categories">ADD VIDEO TO CATEGORIES<span class="hint line-break">(Hold down Command on Mac or Ctrl on Win to select/deselect options)</span></label>
                <select name="categories[]" size="6" multiple>
                    <?php 
                        $categories = $dbhelper->selectAll('SELECT * FROM sub_category');
                        foreach($categories as $cat){
                            echo "<option value='{$cat['cat_id']}'>{$cat['cat_name']}</option>";
                        }
                    ?>
                </select>
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="11" />
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
$(function(){
 var bodyEditor = Jodit.make('#video-body');
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
 $('.select-box .current').click(function(e){
    selectChoice($(this));
    //stop propagation cause of window click
    e.preventDefault();
 });

 $(window).click(function(e) {
      var link = $('.select-box li');
      selectBox.each(function(index){
        var box = this.id;
        //if clicked anywhere on window but dropbox link
        if(!link.is(e.target)){
           if($('#'+box).height() > 40){
            $('#'+box).animate({
               height: "40px"
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

 $('.select-box .choice').click(function(e){
      e.preventDefault();
      var icon = $(document.createElement('i'));
      icon.attr('class','fa fa-chevron-circle-down');
      var choice = $(this).find('a').attr('href');
      var filter = choice.split("#").pop();
      $('#type').val(filter);
      $('.select-box .current').find('i').remove();
      $('.select-box .current')
       .removeClass('current')
       .addClass('choice')
       .insertAfter($(this));
       $(this).removeClass('choice').addClass('current');
       icon.appendTo('.current a');
       $('.select-box ul').prepend($(this));
       $('.select-box .current').click(function(event){
         selectChoice($(this));
         event.preventDefault();
       });
  });

 function selectChoice(elem){
        var $this = elem;
        var opened = $this.closest('div').find('.select-open').attr('id');
        if(opened){
          $('#'+opened).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
          $('#'+opened).removeClass('select-open');
        }
        var id = $this.closest('div').attr('id');
        var dropdownH = $('#'+id)[0].scrollHeight;

        if($('#'+id).height() > 40){
          $('#'+id).animate({
             height: "40px"
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
   }
});
</script>
