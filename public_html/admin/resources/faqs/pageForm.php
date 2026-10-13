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
	    $cmsCatExists = $dbhelper->numOfRows('SELECT pkid FROM faqs_page WHERE cat = ?', 's', 'faqs');
	    if($cmsCatExists > 0){
	        $PageUrl = "/admin/resources/faqs/pageForm";
	        $PageCode = "000000";
	        $bodyid = 'faqs';
	        $FirstPageCode = substr($PageCode, 0, 2);
	        $SecodeCode = substr($PageCode, 2, 2);
	        $ThirdCode = substr($PageCode, 4, 2);
	    }else{
	        header('Location: /admin/resources/faqs/errorPage?reason=no-faqs-page-found');
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
<title>Add FAQS Page | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
    #module-data .select-type{width:280px}
    #module-data #page-hero .select-type{width:200px}
	.faqs-paragraph{background:#eee;height:auto;padding:2% 0}
    .jodit-toolbar-button_classSpan svg{fill:#e03c31}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main>
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="module-section">

            <h2>Add FAQS Product</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/resources/faqs/addPage" id="module-data" enctype="multipart/form-data">
                <input type="hidden" name="cmscategory"  value="faqs" />

            <section class="page-section">

                <div class="section-heading">
                    <h3>PRODUCT INFO</h3>
                    <ul class="section-go">
                        <li class="toggle-section fa fa-minus-circle"></li>
                    </ul>
                </div>

                <div class="section-part section-on">

                    <fieldset>
                        <label for="pagetitle">Product Name<span>*</span></label>
                        <input type="text" name="pagetitle" id="page-title" class="get-value page-short-input"  maxlength="150" tabindex="1" />
                    </fieldset>

                    <fieldset>
                        <label for="slugurl">Slug Url<span>*</span><span class="hint"> (Only letters, numbers and hyphens allowed)</span></label>
                        <input type="text" name="slugurl" id="slugurl" class="get-value page-short-input" pattern="[a-zA-Z0-9\-\s]+" title="Only letters, numbers and hyphens are allowed." maxlength="200" tabindex="2" />
                    </fieldset>

                 </div>

            </section>

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
                        <input type="hidden" name="heroheight" id="hero-height" value="tall" />
                        <div class="select-box" id="select-hero-height">
                          <ul>
                            <li><a href="#tall" class="current choice">Tall Hero<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#short" class="smooth-hover choice">Short Hero<i class="fa fa-caret-down"></i></a></li>
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

                    <ul class="section-go">
                        <li class="toggle-section fa fa-minus-circle"></li>
                    </ul>

                </div>

                <div class="section-part section-on hero-part">

                    <fieldset class="upload-field img-upload">
                        <label for="Desktop Hero">Desktop</label>
                        <input type="file" name="herodesktop" tabindex="4">
                        <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Hero">Mobile</label>
                        <input type="file" name="heromobile" tabindex="5">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset>
                        <label for="hero-subtitle">Subheading</label>
                        <input type="text" name="herosubtitle" id="hero-subtitle" class="page-short-input" maxlength="100" tabindex="7" />
                    </fieldset>

                    <fieldset>
                     <label for="hero paragraph">Paragraph</label>
                     <textarea id="hero-body" name="heroparagraph" tabindex="8"></textarea>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="section-cta">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name="herosectionbtn" class="section-cta" id="hero-section-cta" maxlength="20" tabindex="9" />
                        </div>
                        <div class="request-checkboxes">
                              <div>
                                <label for="Outbound Link?">Outbound Link?</label>
                                <input type="checkbox" name="hero-outbound" value="1" tabindex="10" />
                              </div>
                            </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name="herotargeturl" class="page-short-input" maxlength="255" tabindex="11" />
                        </div>
                    </fieldset>

                </div>

            </section>

            <section class="page-section" id="new-section">

                <div class="section-heading tall-heading">

                	<h3>ADD CATEGORY</h3>
                
                    <div class="select-type">
                        <input type="hidden" name="category" id="category" value="0" />
	                    <div class="select-box" id="faqs-category">
	                      <ul>
	                        <li><a href="#0" class="current choice">Select Category<i class="fa fa-caret-down"></i></a></li>
	                        <li><a href="#applications" class="smooth-hover choice">Applications<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#assay-methodology" class="smooth-hover choice">Assay Methodology<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#storage-stability-and-documentation" class="smooth-hover choice">Storage, Stability and Documentation<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#shipping" class="smooth-hover choice">Shipping<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#content" class="smooth-hover choice">Content<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#production-and-quality" class="smooth-hover choice">Production and Quality<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#serum-profiling" class="smooth-hover choice">Serum Profiling<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#array-controls" class="smooth-hover choice">Array Controls<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#data-analysis" class="smooth-hover choice">Data Analysis<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#gst-staining-and-gridding" class="smooth-hover choice">GST Staining and Gridding<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#antibody-specificity-and-cross-reactivity-testing" class="smooth-hover choice">Antibody Specificity and Cross-reactivity Testing<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#additional-resources" class="smooth-hover choice">Additional Resources<i class="fa fa-caret-down"></i></a></li>
	                      </ul>
	                    </div>
                    </div>

                    <div class="section-go">
                    	<a href="#" class="global-btn clear-btn go-btn">DONE</a>
                    </div>

                </div>

                <div class="section-part section-off main-column">

                    <fieldset class="body-field">
                     <label for="Page paragraph">Body</label>
                     <textarea id="body" name="new-section-paragraph" class='page-body' tabindex="16"></textarea>
                    </fieldset>

                </div>

            </section>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="24" />
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

<dialog class="dialog error-dialog">
  <p>Must Select Category</p>
  <button class="global-btn blue-btn">OK</button>
</dialog>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script src="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js"></script>
<script>
var heroEditor = Jodit.make('#hero-body');
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
            name: 'New Answer',
            tooltip: 'Insert Answer',
            exec: (editor) => {
                editor.s.insertHTML("<div class='faqs-paragraph answer-closed'><p></p></div>");
            }
        },
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
        }
    ]
  });
});
$('#submit-btn').click(function(e){
 e.preventDefault();
 var isValid = true;
 var catSection = true;
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
   for(var j=0; j<Editors.length; j++){
     if(isBodyEmpty(editor[j].value)){
        alert('You must add at least one category section.');
        catSection = false;
     }
   }
   if(catSection){
       $('#submit-btn').prop('disabled', true);
       $('#submit-btn').val('Please Wait').css('background','#7d868c');
       var f = document.regFrm;
       f.submit();
   }
 }
});

function isBodyEmpty(input) {
   if(input.replace(/<(.|\n)*?>/g, '').trim().length === 0 && !input.includes("<div")){
      return true;
   }
  return false;
}

/*-------- TOGGLE SECTION ---------*/
$('.toggle-section').click(function(e){
  var expandOne = $(this);
  if(expandOne.hasClass('fa-minus-circle')){
     expandOne.removeClass('fa-minus-circle').addClass('fa-plus-circle');
  }else{
     expandOne.removeClass('fa-plus-circle').addClass('fa-minus-circle');
  }

  var sectionPart = expandOne.closest('section').find('.section-part');
  var divsOpened = $('.section-off').length;

    if(sectionPart.hasClass('section-on')){
        sectionPart.slideToggle(400, function(){
            sectionPart.addClass('section-off').removeClass('section-on');
        });
    }else{
        sectionPart.slideToggle(400, function(){
            sectionPart.addClass('section-on').removeClass('section-off');
        });
    }
    e.preventDefault();
});

/*-------------- SELECT SECTION PROPERTIES ------------*/

$('.go-btn').click(function(e){
  e.preventDefault();
  var goBtn = $(this);
  if(goBtn.closest('.section-heading').find('#category').val() == 0){
      dialog.showModal();
      const overlay = document.createElement('div');
      overlay.setAttribute('id', 'overlay');
      document.getElementsByTagName('main')[0].append(overlay);
  }else{
      if(goBtn.text() == 'DONE'){
          goBtn.text('CANCEL');
          goBtn.closest('section').find('.section-part').addClass('section-on').removeClass('section-off');
          for(var i=0; i<Editors.length; i++){
              editor[i] = new Jodit(Editors[i],{
              });
          }
      }else{
        goBtn.text('DONE');
        goBtn.closest('section').find('.section-part').addClass('section-off').removeClass('section-on');
        goBtn.closest('.section-heading').find('.select-type input').each(function(j){
        });
      }
    }
});

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

const dialog = document.querySelector("dialog");
const showButton = document.querySelector("dialog + button");
const closeButton = document.querySelector("dialog button");

closeButton.addEventListener("click", () => {
  dialog.close();
  overlay.remove();
});
</script>
</script>
</body>
</html>

