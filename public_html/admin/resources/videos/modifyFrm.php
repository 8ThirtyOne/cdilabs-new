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
          $PageUrl = "/admin/resources/videos/modifyFrm";
          $PageCode = "000000";
          $bodyid = "resources";
          $FirstPageCode = substr($PageCode, 0, 2);
          $SecodeCode = substr($PageCode, 2, 2);
          $ThirdCode = substr($PageCode, 4, 2);
          if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
           $pkid = $webhelper->RequestFilter('pkid', 0, false);   
           $exists = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid); 
           if($exists > 0){
            $page = $webhelper->RequestFilter("page", 0, false);
            $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
            $order = $webhelper->RequestFilter("order", 0, false);
            $Parameter = "&searchKey=$searchKey&order=$order";
            $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT pkid, title, subtitle, youtube_url, page_body, body, keywords, slugurl, thumbnail, status, type, permission, DATE_FORMAT(updated,'%b %d, %Y') AS updated FROM videos WHERE pkid = $pkid ");
           }else{
            header('Location: /admin/resources/videos/list');
            exit;
           }
          }
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
<title>Edit Video | CDI Labs</title>
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

         <div id="admin-panel" class="modify-data">

            <h2>EDIT VIDEO</h2>

            <form method="post" name="modifyForm" action="/admin/resources/videos/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldthumbnail" value="<?php echo $ViewData["thumbnail"]; ?>" />

             <fieldset id="field-one">
                
                <?php 
                switch($ViewData['type']){
                    case 1:
                        $currentChoice = 'Technology';
                        $currentType = '1';
                        $secondChoice = 'Webinar';
                        $secondType = '2';
                        $thirdChoice = 'Event';
                        $thirdType = '3';
                        $fourthChoice = 'Other';
                        $fourthType = '4';
                        break;
                   case 2:
                        $currentChoice = 'Webinar';
                        $currentType = '2';
                        $secondChoice = 'Technology';
                        $secondType = '1';
                        $thirdChoice = 'Event';
                        $thirdType = '3';
                        $fourthChoice = 'Other';
                        $fourthType = '4';
                        break;
                    case 3:
                        $currentChoice = 'Event';
                        $currentType = '3';
                        $secondChoice = 'Technology';
                        $secondType = '1';
                        $thirdChoice = 'Webinar';
                        $thirdType = '2';
                        $fourthChoice = 'Other';
                        $fourthType = '4';
                        break;
                    case 4:
                        $currentChoice = 'Other';
                        $currentType = '4';
                        $secondChoice = 'Technology';
                        $secondType = '1';
                        $thirdChoice = 'Webinar';
                        $thirdType = '2';
                        $fourthChoice = 'Event';
                        $fourthType = '3';
                        break;
                } ?>
                <input type="hidden" name="type" id="type" value="<?php echo strtolower($currentType); ?>" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current"><a href="#<?php echo $currentType; ?>"><?php echo $currentChoice; ?><i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#<?php echo $secondType; ?>"><?php echo $secondChoice; ?></a></li>
                    <li class="choice"><a href="#<?php echo $thirdType; ?>"><?php echo $thirdChoice; ?></a></li>
                    <li class="choice"><a href="#<?php echo $fourthType; ?>"><?php echo $fourthChoice; ?></a></li>
                  </ul>
                </div>

              </div>
            </fieldset>

            <fieldset class="request-checkboxes" id="permission-fileds">
                <?php $public = $ViewData["permission"] == 1 ? "checked='checked'" : ''; 
                      $notpublic = $ViewData["permission"] == 0 ? "checked='checked'" : ''; 
                ?>

                <div>
                <input type="radio" name="permission" value="1" <?php echo $public; ?> tabindex="7" /><label for="Public">Public</label>
                </div>
                <div>
                <input type="radio" name="permission" value="0" <?php echo $notpublic; ?> tabindex="8" /><label for="Register">Register</label>
                </div>
             
            </fieldset>

            <fieldset>
                <label for="Title">Title<span>*</span></label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="255" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Subtitle">Subtitle</label>
                <input type="text" name="subtitle" value="<?php echo $ViewData['subtitle']; ?>" id="subtitle" placeholder="<?php echo $ViewData['subtitle']; ?>" maxlength="500" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="YouTube">YouTube Url<span>*</span></label>
                <input type="text" name="youtubeurl" id="youtube-url" value="<?php echo $ViewData['youtube_url']; ?>" class="get-value" placeholder="<?php echo $ViewData['youtube_url']; ?>" maxlength="255" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <p class="field-eg">If slugurl is changed, Save and then Upublish / Publish again.</p>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['slugurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['slugurl']; ?>" maxlength="255" tabindex="3" />
            </fieldset>

            <fieldset class="body-field">
                 <label for="Page Body">Page Body</label>
                 <p class="field-eg">Enter Speaker, institution, lists, other info. (NO ABSTRACT)</p>
                 <textarea id="video-body" name="pagebody" tabindex="10"><?php echo stripcslashes($ViewData['page_body']); ?></textarea>
            </fieldset>

            <fieldset>
                 <label for="Description">Description<span>*</span></label>
                   <textarea name="description" id="description" rows="1" cols="1" minlength="10" maxlength="800" tabindex="4"><?php if($ViewData['body'] != 'none') echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset>
                <label for="Keywords">Keywords</label>
                <input type="text" name="keywords" id="keywords" value="<?php echo $ViewData['keywords']; ?>" placeholder="<?php echo $ViewData['keywords']; ?>" maxlength="255" tabindex="3" />
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Thumbnail File">THUMBNAIL FILE<span>*</span> <span class="field-eg">(800x400)</span></label>
            <input type="file" name="thumbnail" tabindex="5" />
            <?php 
             if(!empty($ViewData["thumbnail"])){
                 echo "<div>";
                 echo "<img src=\"/files/videos/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset id="select-categories">
                <label for="Categories">ADD VIDEO TO CATEGORIES<span class="hint line-break">(Hold down Command on Mac or Ctrl on Win to select/deselect options)</span></label>
                <select name="categories[]" size="6" multiple>
                    <?php 
                        $select = array();
                        $currents = $dbhelper->selectAll("SELECT sub_category.cat_id, sub_category.cat_name, video_cat_lookup.video_id FROM sub_category, video_cat_lookup WHERE video_cat_lookup.cat_id = sub_category.cat_id AND video_cat_lookup.video_id = {$ViewData['pkid']}");
                        $categories = $dbhelper->selectAll('SELECT * FROM sub_category');
                        foreach($categories as $cat){
                            if(count($currents) > 0){
                              foreach($currents as $current){
                                array_push($select, $current['cat_id']);
                              }
                            }
                            echo "<option value='{$cat['cat_id']}' ".( in_array($cat['cat_id'],$select) ? "SELECTED ": "" ) .">{$cat['cat_name']}</option>";
                        }
                    ?>
                </select>
            </fieldset>


            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="global-btn blue-btn smooth-hover" id="submit-btn" tabindex="6" />
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
/*$( "form#enter-data" ).submit(function( event ) {
  console.log( $( this ).serializeArray() );
  event.preventDefault();
});*/
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
