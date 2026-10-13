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
        $PageUrl = "/admin/resources/publications";
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
<title>Add Publication | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>ADD NEW PUBLICATION</h2>

            <form method="post" name="regFrm" action="/admin/resources/publications/register" id="enter-data" enctype="multipart/form-data">

            <fieldset>
                <label for="Title">Title<span>*</span></label>
                <input type="text" name="title" class="get-value" id="title" placeholder="*Title" maxlength="500" tabindex="1" />
            </fieldset>

            <fieldset>
                <p class="field-eg">Use em tag for et.al.</p>
                <label for="Authors">Authors<span>*</span></label>
                <textarea name="authors" id="authors" class="get-value tall-field" placeholder="*Authors" rows="1" cols="1" minlength="10" maxlength="699" tabindex="2"></textarea>
            </fieldset>

            <fieldset>
                <label for="Publisher">Publisher<span>*</span></label>
                <input type="text" name="publisher" class="get-value" id="publisher" placeholder="*Publisher" maxlength="500" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Institution">Institution<span>*</span></label>
                <input type="text" name="institution" class="get-value" id="institution" placeholder="*Institution" maxlength="500" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Date">Date<span>*</span></label>
                <input type="text" name="fulldate" id="fulldate" class="date-field get-value" placeholder="*Date" maxlength="4" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Url">Url<span>*</span></label>
                <input type="text" name="url" id="url" class="get-value" placeholder="*Url" maxlength="255" tabindex="6" />
            </fieldset>

            <fieldset class="request-checkboxes" id="permission-fileds">

                <div>
                <input type="radio" name="permission" value="1" checked="checked" tabindex="7" /><label for="Public">Public</label>
                </div>
                <div>
                <input type="radio" name="permission" value="0" tabindex="8" /><label for="User Account">User Account</label>
                </div>
             
            </fieldset>

            <fieldset>
                 <label for="Description">Description</label>
                   <textarea name="description" id="description" class="get-value" placeholder="*Description" rows="1" cols="1" minlength="10" maxlength="1000" tabindex="9"></textarea>
            </fieldset>

            <fieldset>
                <label for="Keywords">Keywords<span>*</span></label>
                <input type="text" name="keywords" id="keywords" class="get-value" placeholder="*Keywords" maxlength="255" tabindex="11" />
            </fieldset>

            <fieldset>
                <label for="Main Product">Main Product<span>*</span></label>
                <input type="text" name="product" class="get-value short-input" id="product" placeholder="*Main Product" maxlength="200" tabindex="12" />
            </fieldset>

            <fieldset id="field-one">
                <input type="hidden" name="subcat" id="type" value="" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current"><a href="#">Publication Subcategory<i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#Articles">Articles</a></li>
                    <li class="choice"><a href="#Antibody Specificity">Antibody Specificity</a></li>
                    <li class="choice"><a href="#Autoantibody Profiling">Autoantibody Profiling</a></li>
                    <li class="choice"><a href="#Focused Array">Focused Array</a></li>
                    <li class="choice"><a href="#HuProt Binding">HuProt Binding</a></li>
                    <li class="choice"><a href="#Methods and Reviews">Methods and Reviews</a></li>
                    <li class="choice"><a href="#MonoMabs">MonoMabs</a></li>
                    <li class="choice"><a href="#Non-HuProt">Non-HuProt</a></li>
                    <li class="choice"><a href="#PhIP-Seq">PhIP-Seq</a></li>
                    <li class="choice"><a href="#PPI">PPI</a></li>
                    <li class="choice"><a href="#RNA Binding">RNA Binding</a></li>
                    <li class="choice"><a href="#Small Molecule Binding">Small Molecule Binding</a></li>
                  </ul>
                </div>

              </div>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE <span class="field-eg">(610x790)</span></label>
            <input type="file" name="thumbnail" tabindex="13" />
            </fieldset>

            <fieldset>
                <div class="request-checkboxes" id="featured">
                    <div>
                    <input type="checkbox" name="featured" value="1" tabindex="10" /><label for="Featured Publication">Featured Publication</label>
                    </div>
                </div>
            </fieldset>

            <fieldset class="upload-field">
                <label for="Featured Thumbnail">FEATURED THUMBNAIL <span class="field-eg">(800x600)</span></label>
                <input type="file" name="featuredthumb" tabindex="13" />
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File">UPLOAD FILE</label>
            <input type="file" name="up_file" id="up_file" tabindex="14" />
            </fieldset>

            <fieldset id="select-categories">
                <label for="Categories">PAGE CATEGORIES</label>
                <select name="categories[]" size="6" multiple tabindex="15">
                    <?php 
                        $categories = $dbhelper->selectAll('SELECT * FROM sub_category');
                        foreach($categories as $cat){
                            echo "<option value='{$cat['cat_id']}'>{$cat['cat_name']}</option>";
                        }
                    ?>
                </select>
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="global-btn blue-btn smooth-hover" id="submit-btn" tabindex="16" />
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
<script>
$(function(){
 $( "#fulldate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });
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
       $('#submit-btn').val('Please Wait').css('background','#7c878e');
       var f = document.regFrm;
       f.submit();
     }
 });

 var selectBox = $('.select-box');
 $('.select-box .current').click(function(e){
    selectChoice($(this));
    e.preventDefault();
 });

 $(window).click(function(e) {
      var link = $('.select-box li');
      selectBox.each(function(index){
        var box = this.id;
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
