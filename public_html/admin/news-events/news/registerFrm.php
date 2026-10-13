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
    $PageUrl = "/admin/news-events/news/registerFrm";
    $PageCode = "000000";
    $bodyid = "news";
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
<title>Add News | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
 #enter-data{width:100%}
  #enter-data fieldset{width:60%}
  #enter-data .upload-tmb{width:44%}
  #enter-data #upload-desktop{width:32.5%;clear:left}
  #enter-data .body-field{width:90%}
 .body-field .jodit-workplace{height:500px !important}
</style>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>ADD NEWS</h2>

            <form method="post" name="regFrm" action="/admin/news-events/news/register" id="enter-data" enctype="multipart/form-data">

            <fieldset id="field-one">
                <input type="hidden" name="type" id="type" value="" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current"><a href="#0">*Select Type<i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#1">News</a></li>
                    <li class="choice"><a href="#2">Press</a></li>
                  </ul>
                </div>

              </div>

              <div class="request-checkboxes">
                <div>
                <input type="checkbox" name="sticker" value="1" tabindex="1" /><label for="Homepage Sticker">Homepage Sticker</label>
                </div>
              </div>

            </fieldset>

             <fieldset>
                <label for="Date">Date<span>*</span></label>
            <input type="text" name="fulldate" id="fulldate" class="date-field get-value" placeholder="*Date" maxlength="4" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Source">Source<span>*</span></label>
                <input type="text" name="source" class="get-value" id="source" placeholder="*Source" maxlength="500" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Url">Url<span>*</span></label>
                <input type="text" name="url" class="get-value" id="url" placeholder="*Url" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Title">Main Title<span>*</span></label>
                <input type="text" name="title" class="get-value" id="main-title" placeholder="*Main Title" maxlength="255" tabindex="6" />
            </fieldset>

            <fieldset>
                <label for="Subtitle">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" placeholder="Subtitle" maxlength="1200" tabindex="7" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" class="get-value" placeholder="*Slug Url (eg. main-title-url)" maxlength="500" tabindex="8" />
            </fieldset>

            <fieldset class="body-field">
               <label for="page body">Description</label>
               <textarea id="post-body" name="description" tabindex="9"></textarea>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Thumbnail File">THUMBNAIL FILE <span class="field-eg">(600x600)</span></label>
            <input type="file" name="thumbnail" tabindex="10" />
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File">UPLOAD FILE</label>
            <input type="file" name="up_file" id="up_file" tabindex="11" />
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="12" />
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
document.querySelector('#field-one .request-checkboxes').style.display = 'block';
 $( "#fulldate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });
var bodyEditor = Jodit.make('#post-body');
 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     $('#error-box').remove();
     var errorBox = $(document.createElement('fieldset'));
     var errorText = $(document.createElement('li'));
     var isType = $('#filter a').attr('href').split("#").pop();
     if(isType == 0){
       errorBox.attr('id','error-box').insertBefore($('#field-one'));
       errorText.text('Please select News Type.').appendTo(errorBox);
       isValid = false;
     }
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
      document.querySelector('#field-one .request-checkboxes').style.display = 'block';
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
</body>
</html>