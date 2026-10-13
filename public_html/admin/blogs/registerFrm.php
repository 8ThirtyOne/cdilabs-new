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
    $PageUrl = "/admin/blogs/registerFrm";
    $PageCode = "000000";
    $bodyid = "blogs";
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
<title>Add New Blog Post | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
 #enter-data{width:100%}
  #enter-data fieldset{width:60%}
  #enter-data .upload-tmb{width:44%}
  #enter-data #upload-desktop{width:32.5%;clear:left}
  #enter-data .body-field{width:90%}
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

         <div id="admin-panel">

            <h2>ADD NEW BLOG POST</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = strtoupper($error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/blogs/register" id="enter-data" enctype="multipart/form-data">

            <fieldset id="field-one">
                <div id="select-type">
                <?php 
                $types = array('event', 'news', 'publication spotlight', 'technology');
                echo "<input type='hidden' name='type' id='type' value='' />"; 
                echo "<div class='select-box' id='filter'>";
                     echo "<ul>"; 
                        echo "<li class='current'><a href='#remove'>SelectType*<i class='fa fa-chevron-circle-down'></i></a></li>";
                          foreach($types as $type){
                            $choice = ucwords($type);
                            echo "<li class='choice'><a href='#$type'>$choice</a></li>";
                        }
                        echo "</ul>"; 
                    echo "</div>";
                ?>
              </div>
            </fieldset>

            <fieldset>
                <label for="Date">Date<span>*</span></label>
            <input type="text" name="fulldate" id="fulldate" class="date-field get-value" placeholder="Date*" maxlength="1" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Title">Main Title<span>*</span></label>
                <input type="text" name="title" class="get-value" id="main-title" placeholder="Main Title*" maxlength="500" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Subtitle">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" placeholder="Subtitle" maxlength="500" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Author">Author</label>
                <input type="text" name="author" class="get-value" id="author" placeholder="Author*" maxlength="120" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Job Title">Job Title</label>
                <input type="text" name="jobtitle" class="get-value" id="job-title" placeholder="Job Title*" maxlength="150" tabindex="5" />
            </fieldset>

            <fieldset class="upload-field upload-tmb" id="upload-avatar">
                <label for="AUTHOR AVATAR">AUTHOR AVATAR<span>*</span></label>
                <input type="file" name="avatar" tabindex="6" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" class="get-value" placeholder="Slug Url*" maxlength="255" tabindex="7" />
            </fieldset>

            <fieldset>
                <label for="Keywords">Keywords<span>*</span></label>
                <input type="text" name="keywords" id="keywords" class="get-value" placeholder="Keywords*" maxlength="255" tabindex="8" />
            </fieldset>

            <fieldset class="upload-field upload-tmb" id="upload-thumb">
                <label for="HERO IMAGE">LISTING THUMBNAIL<span>*</span></label>
                <input type="file" name="thumbnail" tabindex="9" />
            </fieldset>

            <fieldset class="upload-field upload-tmb" id="upload-desktop">
                <label for="HERO IMAGE">HERO IMAGE<span>*</span></label>
                <input type="file" name="hero_img" tabindex="10" />
            </fieldset>

            <fieldset class="upload-field upload-tmb">
                <label for="MOBILE HERO IMAGE">MOBILE HERO IMAGE<span>*</span></label>
                <input type="file" name="mobile_img" tabindex="11" />
            </fieldset>

            <fieldset class="body-field">
               <label for="page body">Page Body</label>
               <textarea id="post-body" name="pagebody" class='page-body' tabindex="12"></textarea>
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
$(function(){
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
</body>
</html>
