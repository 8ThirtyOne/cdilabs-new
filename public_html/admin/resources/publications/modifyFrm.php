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
          $PageUrl = "/admin/resources/publications/modifyFrm";
          $PageCode = "000000";
          $bodyid = "resources";
          $FirstPageCode = substr($PageCode, 0, 2);
          $SecodeCode = substr($PageCode, 2, 2);
          $ThirdCode = substr($PageCode, 4, 2);
          if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
           $pkid = $webhelper->RequestFilter('pkid', 0, false);   
           $exists = $dbhelper->numOfRows('SELECT title FROM publications WHERE pkid = ?', 'i', $pkid); 
           if($exists > 0){
            $page = $webhelper->RequestFilter("page", 0, false);
            $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
            $order = $webhelper->RequestFilter("order", 0, false);
            $Parameter = "&searchKey=$searchKey&order=$order";
            $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM publications WHERE pkid = $pkid ");
           }else{
            header('Location: /admin/news/publications/list');
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
<title>Edit Publication | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT PUBLICATION</h2>

            <form method="post" name="modifyForm" action="/admin/resources/publications/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldthumbnail" value="<?php echo $ViewData["thumbnail"]; ?>" />
                <input type="hidden" name="oldfeaturedthumb" value="<?php echo $ViewData["featuredthumb"]; ?>" />
                <input type="hidden" name="oldFile" value="<?php echo $ViewData["filename"]; ?>" />
                <input type="hidden" name="oldOrgFile" value="<?php echo $ViewData["orgfilename"]; ?>" />

            <fieldset>
                <label for="Title"><span>*</span>Title</label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="500" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Authors">Authors<span>*</span> <span class="field-eg">(Use em tag for et.al.)</span></label>
                <textarea name="authors" class="get-value tall-field" id="authors" rows="1" cols="1" minlength="10" maxlength="699" tabindex="2"><?php echo $ViewData['authors']; ?></textarea>
            </fieldset>

            <fieldset>
                <label for="Publisher">Publisher<span>*</span></label>
                <input type="text" name="publisher" value="<?php echo $ViewData['publisher']; ?>" class="get-value" id="publisher" placeholder="<?php echo $ViewData['publisher']; ?>" maxlength="500" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Institution">Institution<span>*</span></label>
                <input type="text" name="institution" value="<?php echo $ViewData['institution']; ?>" class="get-value" id="institution" placeholder="<?php echo $ViewData['institution']; ?>" maxlength="500" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Date"><span>*</span>Date</label>
                <input type="text" name="fulldate" id="fulldate" value="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" class="date-field get-value" placeholder="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" maxlength="4" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Url">Url<span>*</span></label>
                <input type="text" name="url" value="<?php echo $ViewData['link']; ?>" id="url" class="get-value" placeholder="<?php echo $ViewData['link']; ?>" maxlength="255" tabindex="6" />
            </fieldset>

            <fieldset class="request-checkboxes" id="permission-fileds">
                <?php $public = $ViewData["permission"] == 1 ? "checked='checked'" : ''; 
                      $notpublic = $ViewData["permission"] == 0 ? "checked='checked'" : ''; 
                ?>

                <div>
                <input type="radio" name="permission" value="1" <?php echo $public; ?> tabindex="7" /><label for="Public">Public</label>
                </div>
                <div>
                <input type="radio" name="permission" value="0" <?php echo $notpublic; ?> tabindex="8" /><label for="User Account">User Account</label>
                </div>
             
            </fieldset>

            <fieldset>
                 <label for="Description"><span>*</span>Description</label>
                   <textarea name="description" class="get-value" id="description" rows="1" cols="1" minlength="10" maxlength="800" tabindex="9"><?php if($ViewData['body'] != 'none') echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset>
                <label for="Keywords"><span>*</span>Keywords</label>
                <input type="text" name="keywords" id="keywords" value="<?php echo $ViewData['keywords']; ?>" class="get-value" placeholder="<?php echo $ViewData['keywords']; ?>" maxlength="255" tabindex="11" />
            </fieldset>

            <fieldset>
                <label for="Main Product">Main Product<span>*</span></label>
                <input type="text" name="product" class="get-value short-input" id="product" value="<?php echo $ViewData['main_product']; ?>"placeholder="<?php echo $ViewData['main_product']; ?>" maxlength="200" tabindex="12" />
            </fieldset>

            <fieldset id="field-one">
                <div id="select-type">
                    <?php 
                    $subCats = array('Articles', 'Antibody Specificity', 'Autoantibody Profiling', 'Focused Array', 'HuProt Binding', 'Methods and Reviews', 'MonoMabs', 'Non-HuProt', 'PhIP-Seq', 'PPI', 'RNA Binding', 'Small Molecule Binding', 'none');
                    $currentSub = $ViewData['sub_cat'];
                    echo "<input type='hidden' name='subcat' id='type' value='$currentSub' />"; 
                    echo "<div class='select-box' id='filter'>";
                         echo "<ul>"; 
                              if($currentSub != 'none'){
                                 echo "<li class='current choice'><a href='#$currentSub'>$currentSub<i class='fa fa-chevron-circle-down'></i></a></li>";
                                 foreach($subCats as $sRow){
                                   if($currentSub != $sRow){
                                      echo "<li class='choice'><a href='#$sRow'>$sRow</a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li class='current'><a href='#'>Publication Subcategory<i class='fa fa-chevron-circle-down'></i></a></li>";
                                  foreach($subCats as $sRow){
                                    echo "<li class='choice'><a href='#$sRow'>$sRow</a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    ?>
                </div>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE <span class="field-eg">(610x790)</span></label>
            <input type="file" name="thumbnail" tabindex="12" />
            <?php 
             if(!empty($ViewData["thumbnail"])){
                 echo "<div>";
                 echo "<img src=\"/files/publications/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset>
                <div class="request-checkboxes" id="featured">
                    <?php $featured = $ViewData["featured"] == 1 ? "checked='checked'" : ''; ?>
                    <div>
                    <input type="checkbox" name="featured" value="1" <?php echo $featured; ?> tabindex="10" /><label for="Featured Publication">Featured Publication</label>
                    </div>
                </div>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Featured Thumbnail">FEATURED THUMBNAIL <span class="field-eg">(800x600)</span></label>
            <?php 
             if($ViewData["featuredthumb"] !='none'){
                 echo "<div>";
                 echo "<img src=\"/files/publications/" . $ViewData["featuredthumb"] . "\">";
                 echo "<p class='del-thumb' id='{$ViewData["featuredthumb"]}'>Delete</p>";
                 echo "</div>";
                }else{
                 echo "<input type='file' name='featuredthumb' tabindex='13' />";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File">UPLOAD FILE</label>
            <?php
              if($ViewData["filename"] !='none'){
                 echo "<div>";
                 echo $ViewData["orgfilename"];
                 echo "<p class='del-thumb' id='{$ViewData["filename"]}'>Delete</p>";
                 echo "</div>";
               }else{
                 echo "<input type='file' name='up_file' id='up_file' tabindex='14' />";
               }
            ?>
            </fieldset>

            <fieldset id="select-categories">
                <label for="Categories">ADD LITERATURE TO PAGES<span class="hint line-break">(Hold down Command on Mac or Ctrl on Win to select/deselect options)</span></label>
                <select name="categories[]" size="6" multiple>
                    <?php 
                        $select = array();
                        $currents = $dbhelper->selectAll("SELECT sub_category.cat_id, sub_category.cat_name, pub_cat_lookup.pub_id FROM sub_category, pub_cat_lookup WHERE pub_cat_lookup.cat_id = sub_category.cat_id AND pub_cat_lookup.pub_id = {$ViewData['pkid']}");
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
                <input type="submit" name="create" value="SAVE" class="global-btn blue-btn smooth-hover" id="submit-btn" tabindex="14" />
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

    <dialog class="dialog delete-dialog delete-thumb-dialog">
        <div class="delete-inner">
            <form method="post" name="deleteThumb" id="del-thumb-form">
              <input type="hidden" name="docid" id="doc-id" value=<?php echo $pkid; ?> /> 
              <input type="hidden" name="thumbname" id="del-thumb-name" />      
              <input type="submit" name="delThumbImg" value="YES" class='global-btn blue-btn smooth-hover' id="del-thumb-yes-btn" tabindex="1" />
             </form>
             <button class='global-btn' id="close-del-thumb">NO</button>
         </div>
    </dialog>

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
       var f = document.modifyForm;
       f.submit();
     }
 });
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

   const delThumbDialog = document.querySelector(".delete-thumb-dialog");
    const closeThumbDelete = document.getElementById("close-del-thumb");

    $('.del-thumb').click(function(e){
        e.preventDefault();
        var getThumbName=$(this).attr('id');
        $('.delete-thumb-dialog p').remove();
        const overlay = document.createElement('div');
        overlay.setAttribute('id', 'overlay');
        document.getElementsByTagName('main')[0].append(overlay);
        $('#del-thumb-name').val(getThumbName);
        var warning = $(document.createElement('p'));
        warning.text("Are you sure you want to delete this image?");
        warning.insertBefore($('.delete-thumb-dialog .delete-inner'));
        delThumbDialog.showModal();
    });

    $('form#del-thumb-form').submit(function(){
      var query = $('#del-thumb-form').serializeArray();
      $.ajax({
         type: 'POST',
         url: '/admin/resources/publications/deleteThumb',
         data: query,
         async : false,
           success: function(res){
            var res = res.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(res == "1"){
              location.href="/admin/resources/publications/modifyFrm?pkid=<?php echo $pkid.'&page='.$page.$Parameter; ?>";
             }else if(res == "2"){
               alert('Thumb not found.');
             }else{
               alert('Something went wrong. Try again.');
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
        });
       return false;
    });

    closeThumbDelete.addEventListener("click", () => {
      delThumbDialog.close();
      overlay.remove();
    });
});
</script>
