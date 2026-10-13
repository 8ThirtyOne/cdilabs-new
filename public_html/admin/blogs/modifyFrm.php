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
      $PageUrl = "/admin/blogs/modifyFrm";
      $PageCode = "000000";
      $bodyid = "company";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT slugurl FROM posts WHERE pkid = ?', 'i', $pkid);
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM posts WHERE pkid = $pkid");
       }else{
        header('Location:/admin/blogs/list');
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
<title>Edit Blog Post | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" /> 
<style>
 #enter-data{width:100%}
  #enter-data fieldset{width:60%}
  #enter-data .upload-tmb{width:44%}
  #enter-data .upload-tmb div, #enter-data .body-field{width:90%}
  .upload-avatar div{width:50%}
 .body-field .jodit-workplace{height:1100px !important}
 #enter-data .body-field h4{font-size:13px}
 .jodit-icon_paragraph{fill:#e03c31}
 .jodit-toolbar-button_classSpan svg{fill:#346c97}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT BLOG POST</h2>

            <form method="post" name="modifyForm" action="/admin/blogs/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldavatar" value="<?php echo $ViewData["avatar"]; ?>" />
                <input type="hidden" name="oldthumbnail" value="<?php echo $ViewData["thumbnail"]; ?>" />
                <input type="hidden" name="oldheroimg" value="<?php echo $ViewData["desktop_hero"]; ?>" />
                <input type="hidden" name="oldmobileheroimg" value="<?php echo $ViewData["mobile_hero"]; ?>" />

          <fieldset id="field-one">

              <div id="select-type">
                <?php 
                $types = array('event', 'news', 'publication spotlight', 'technology');
                $currentType = $ViewData['type'];
                $currentChoice = ucfirst($currentType);
                echo "<input type='hidden' name='type' id='type' value='$currentType' />"; 
                echo "<div class='select-box' id='filter'>";
                     echo "<ul>"; 
                             echo "<li class='current'><a href='#$currentType'>$currentChoice<i class='fa fa-chevron-circle-down'></i></a></li>";
                             foreach($types as $type){
                               $choice = ucwords($type);
                               if($currentType != $type){
                                echo "<li class='choice'><a href='#$type'>$choice</a></li>";
                               }
                             }
                        echo "</ul>"; 
                    echo "</div>";
                ?>
               </div>

           </fieldset>

           <fieldset>
                <label for="Date">Date<span>*</span></label>
                <input type="text" name="fulldate" id="fulldate" value="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" class="date-field get-value" placeholder="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" maxlength="4" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Title">Title<span>*</span></label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="500" tabindex="2" />
            </fieldset>

            <fieldset>
              <?php $subtitle = $ViewData['subtitle'] == 'none' ? '' : $ViewData['subtitle']; ?>
                <label for="Subitle">Subtitle</label>
                <input type="text" name="subtitle" value="<?php echo $subtitle; ?>" id="subtitle" placeholder="<?php echo $subtitle; ?>" maxlength="500" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Author">Author<span>*</span></label>
                <input type="text" name="author" value="<?php echo $ViewData['author']; ?>" id="author" class="get-value" placeholder="<?php echo $ViewData['author']; ?>" maxlength="120" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Job Title">Job Title<span>*</span></label>
                <input type="text" name="jobtitle" value="<?php echo $ViewData['job_title']; ?>" id="job-title" class="get-value" placeholder="<?php echo $ViewData['job_title']; ?>" maxlength="150" tabindex="5" />
            </fieldset>

            <fieldset class="upload-field upload-avatar">
            <label for="avatar">AUTHOR AVATAR<span>*</span></label>
            <input type="file" name="avatar" tabindex="7" />
            <?php 
             if(!empty($ViewData["avatar"]) && $ViewData["avatar"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/blogs/" . $ViewData["avatar"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['slugurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['slugurl']; ?>" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Keywords">Keywords<span>*</span></label>
                <input type="text" name="keywords" id="keywords" value="<?php echo $ViewData['keywords']; ?>" class="get-value" placeholder="<?php echo $ViewData['keywords']; ?>" maxlength="500" tabindex="6" />
            </fieldset>

            <fieldset class="upload-field">
            <label for="Thumbnail">LISTING THUMBNAIL<span>*</span></label>
            <input type="file" name="thumbnail" tabindex="7" />
            <?php 
             if(!empty($ViewData["thumbnail"]) && $ViewData["thumbnail"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/blogs/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Hero Image">DESKTOP HERO IMAGE<span>*</span></label>
            <input type="file" name="hero_img" tabindex="8" />
            <?php 
             if(!empty($ViewData["desktop_hero"]) && $ViewData["desktop_hero"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/blogs/" . $ViewData["desktop_hero"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Mobile Hero Image">MOBILE HERO IMAGE<span>*</span></label>
            <input type="file" name="mobile_img" tabindex="9" />
            <?php 
             if(!empty($ViewData["mobile_hero"]) && $ViewData["mobile_hero"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/blogs/" . $ViewData["mobile_hero"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

           <fieldset class="body-field">
             <label for="Page Body">Page Body<span>*</span></label>
               <textarea name="pagebody" id="post-body" class='page-body' tabindex="10"><?php echo $ViewData['body']; ?></textarea>
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
 $( "#fulldate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });
var sectionEditors = [];
var Editors = ['#body'];
var editor = [];
$.each($('.body-field .page-body'),function(i){
  sectionEditors[i] = '#' + $(this).attr('id');
  editor[i] = new Jodit(sectionEditors[i],{
    controls: {
        classSpan: {
          list: {
            boldCambSemB: 'Camber Semibold',
            medCamb: 'Camber Medium',
            lightCamb: 'Camber Light',
            lightItCamb: 'Camber Light It',
            regCamb: 'Camber Regular',
            boldDecSemB: 'Decagram Semibold'
          }
        }
      },
    buttons: [
        ...Jodit.defaultOptions.buttons,
        {
            name: 'List with Circles',
            tooltip: 'Insert bullets (circles)',
            exec: (editor) => {
                editor.s.insertHTML("<ul class='ul-with-circles'><li></li></ul>");
            }
        },
        {
            name: 'Numbers List',
            tooltip: 'Insert numbers list',
            exec: (editor) => {
                editor.s.insertHTML("<ol><li></li></ol>");
            }
        },
        {
            name: 'Graph Wrapper',
            tooltip: 'Insert Diagram Wrapper',
            exec: (editor) => {
                editor.s.insertHTML("<div class='diagrams-wrapper'><ul class='diagram-mobile-nav'><li class='slide-left'><img src='/img/common/fig-slide-left.svg'></li><li class='slide-right'><img src='/img/common/fig-slide-right.svg'></li></ul><div class='mobile-fig-wrapper'><div class='mobile-wrap'><img src='/img/products/GRH-HuProt-General-02c.svg' alt='CDI Image'></div></div></div>");
            }
        },
        {
            name: 'Graph Wrapper 75%',
            tooltip: 'Insert Diagram Wrapper 75 Width',
            exec: (editor) => {
                editor.s.insertHTML("<div class='diagrams-wrapper diagram-75w'><ul class='diagram-mobile-nav'><li class='slide-left'><img src='/img/common/fig-slide-left.svg'></li><li class='slide-right'><img src='/img/common/fig-slide-right.svg'></li></ul><div class='mobile-fig-wrapper'><div class='mobile-wrap'><img src='/img/products/GRH-HuProt-General-02c.svg' alt='CDI Image'></div></div></div>");
            }
        }
    ]
  });
});
 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     var regField = [];
     if($('#type').val()===''){
       $('#filter').css('border','1px solid red');
       isValid = false;
     }else{
         $.each($('.get-value'),function(){
           regField.push($('#'+this.id).val());
             if($('#'+this.id).val() === ''){
               $(this).css('border','1px solid red');
               isValid = false;
             }
         });
     }
     if(isValid){
       for(var j=0; j<Editors.length; j++){
         if(isBodyEmpty(editor[j].value)) editor[j].value = '';
       }
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
</script>

