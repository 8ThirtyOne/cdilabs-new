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
       if(isset($_GET['category']) && !empty($_GET['category'])){
            $cmscat = $webhelper->RequestFilter("category", 50, false);
            $cmsCatExists = $dbhelper->numOfRows('SELECT pkid FROM web_page WHERE cat = ?', 's', $cmscat);
            if($cmsCatExists > 0){
                $cmsTitle = strtoupper($cmscat);
                $PageUrl = "/admin/cmsmodel/pageForm";
                $PageCode = "000000";
                $bodyid = $cmscat;
                $FirstPageCode = substr($PageCode, 0, 2);
                $SecodeCode = substr($PageCode, 2, 2);
                $ThirdCode = substr($PageCode, 4, 2);
            }else{
                header('Location: /admin/cmsmodel/errorPage?reason=no-cms-category-found');
                exit;
            }
        }else{
           header('Location: /admin/cmsmodel/errorPage?reason=no-cms-category-found');
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
<title>Add <?php echo ucfirst($cmscat); ?> Page | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main>
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="module-section">

            <h2>Add <?php echo ucfirst($cmscat); ?> Page</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/cmsmodel/page-module/addPage" id="module-data" enctype="multipart/form-data">
                <input type="hidden" name="cmscategory"  value="<?php echo $cmscat; ?>" />

            <section class="page-section">

                <div class="section-heading">
                    <h3>PAGE INFO</h3>
                    <ul class="section-go">
                        <li class="toggle-section fa fa-minus-circle"></li>
                    </ul>
                </div>

                <div class="section-part section-on">

                    <fieldset>
                        <label for="pagetitle">Page Title<span>*</span></label>
                        <input type="text" name="pagetitle" id="page-title" class="get-value page-short-input"  maxlength="150" tabindex="1" />
                    </fieldset>

                    <fieldset>
                        <label for="slugurl">Slug Url<span>*</span><span class="hint"> (Only letters, numbers and hyphens allowed)</span></label>
                        <input type="text" name="slugurl" id="slugurl" class="get-value page-short-input" pattern="[a-zA-Z0-9\-\s]+" title="Only letters, numbers and hyphens are allowed." maxlength="200" tabindex="2" />
                    </fieldset>

                    <fieldset>
                     <label for="Description">Page Meta Description<span>*</span></label>
                       <textarea name="pagedesc" id="page-desc" class="meta-desc get-value" rows="1" cols="1" minlength="10" maxlength="250" tabindex="3"></textarea>
    	             </fieldset>

                     <fieldset>

                        <div class="select-type" id="select-page-form">
                            <?php 
                            $pageForms = array('contact-form', 'grant-form');
                            echo "<input type='hidden' name='chooseform' id='choose-form' value='remove' />"; 
                            echo "<div class='select-box' id='select-box-form'>";
                                 echo "<ul>"; 
                                          echo "<li><a href='#remove' class='current choice'>Add Form<i class='fa fa-caret-down'></i></a></li>";
                                          foreach($pageForms as $pfRow){
                                            echo "<li><a href='#$pfRow' class='smooth-hover choice'>$pfRow<i class='fa fa-caret-down'></i></i></a></li>";
                                        }
                                    echo "</ul>"; 
                                echo "</div>";
                            ?>
                            </div>

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

                	<h3>ADD SECTION</h3>
                
                    <div class="select-type">
                        <input type="hidden" name="layout" id="layout" value="0" />
	                    <div class="select-box" id="page-layout">
	                      <ul>
	                        <li><a href="#0" class="current choice">Select Layout<i class="fa fa-caret-down"></i></a></a></li>
	                        <li><a href="#left" class="smooth-hover choice">Left<i class="fa fa-caret-down"></i></a></a></li>
	                        <li><a href="#center" class="smooth-hover choice">Center<i class="fa fa-caret-down"></i></a></li>
	                        <li><a href="#right" class="smooth-hover choice">Right<i class="fa fa-caret-down"></i></a></li>
	                      </ul>
	                    </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="bgcolor" id="bgcolor" value="0" />
                        <div class="select-box" id="section-bg">
                          <ul>
	                        <li><a href="#0" class="current choice">Select Background Color<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#white" class="smooth-hover choice">White<i class="fa fa-caret-down"></i></a></a></li>
	                        <li><a href="#blue" class="smooth-hover choice">Dark Blue<i class="fa fa-caret-down"></i></a></a></li>
	                        <li><a href="#black" class="smooth-hover choice">Black<i class="fa fa-caret-down"></i></a></li>
	                        <li><a href="#gray" class="smooth-hover choice">Gray<i class="fa fa-caret-down"></i></a></li>
	                      </ul>
                        </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="colnum" id="colnum" value="0" />
                        <div class="select-box" id="page-cols">
                         <ul>
	                        <li><a href="#0" class="current choice">Select # of columns<i class="fa fa-caret-down"></i></a></a></li>
	                        <li><a href="#2" class="smooth-hover choice">2 columns<i class="fa fa-caret-down"></i></a></a></li>
	                        <li><a href="#3" class="smooth-hover choice">3 columns<i class="fa fa-caret-down"></i></a></li>
	                        <li><a href="#4" class="smooth-hover choice">4 columns<i class="fa fa-caret-down"></i></a></li>
	                        <li><a href="#5" class="smooth-hover choice">5 columns<i class="fa fa-caret-down"></i></a></li>
	                      </ul>
                        </div>
                    </div>

                    <div class="section-go">
                    	<a href="#" class="global-btn clear-btn go-btn">DONE</a>
                    </div>

                </div>

                <div class="section-part section-off main-column">

                    <fieldset class="upload-field img-upload">
                        <label for="Desktop Hero">Desktop Background Image</label>
                        <input type="file" name="section-bg" tabindex="12">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Hero">Mobile Background Image</label>
                        <input type="file" name="section-bg-mobile" tabindex="13">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset>
                        <label for="section-1-heading">Main Heading</label>
                        <input type="text" name="section-1-heading" id="section-1-heading" maxlength="200" tabindex="14" />
                    </fieldset>

                    <fieldset>
                        <label for="section-1-subheading">Subheading</label>
                        <input type="text" name="section-1-subheading" id="section-1-subheading"  maxlength="500" tabindex="15" />
                    </fieldset>

                    <fieldset class="body-field">
                     <label for="Page paragraph">Page Paragraph</label>
                     <textarea id="part-1-paragraph" name="new-section-paragraph" tabindex="16"></textarea>
                    </fieldset>

                    <fieldset class="field-checkbox">
                        <div class="request-checkboxes">
                            <div>
                             <label for="Include Form">INCLUDE FORM (Make sure to select form in Page Info Section above)</label>
                             <input type="checkbox" name="new-section-includeform" value="1" tabindex="17" />
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="body-field">
                     <label for="Page Body">Page Body</label>
                     <textarea id="part-1-body" name="new-section-body" tabindex="18"></textarea>
                    </fieldset>

                    <fieldset class="upload-field custom-video">
                        <label for="Desktop Hero">Image / Video Insert <span>(optional)</span></label>
                        <input type="file" name="videocustom" tabindex="19">
                        <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field">
                        <label for="YouTube Video Id">Enter YouTube URL</label>
                        <input type="text" name="youtubeurl" id="youtube-url" placeholder="abcd1234" maxlength="255" tabindex="20" />
                        <p class="field-eg">Eg. https://www.youtube.com/watch?v=<span>abcd1234</span></p>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="section-cta">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name="sectionbtn" class="section-cta" id="section-cta" maxlength="20" tabindex="21" />
                        </div>
                        <div class="request-checkboxes choose-btn-color">
                            <div class="select-type">
                            <input type="hidden" name="btncolor" id="btncolor" value="0" />
                            <div class="select-box" id="btn-bg">
                              <ul>
                                <li><a href="#0" class="current choice">Choose Color<i class="fa fa-caret-down"></i></a></a></li>
                                <li><a href="#blue-btn" class="smooth-hover choice">Blue<i class="fa fa-caret-down"></i></a></a></li>
                                <li><a href="#global-btn" class="smooth-hover choice">Transparent<i class="fa fa-caret-down"></i></a></li>
                              </ul>
                            </div>
                        </div>
                        </div>
                        <div class="request-checkboxes">
                            <div>
                             <label for="Outbound Link?">Outbound Link?</label>
                             <input type="checkbox" name="btn-outbound" value="1" tabindex="22" />
                            </div>
                        </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name="targeturl" class="page-short-input" maxlength="255" tabindex="23" />
                        </div>
                    </fieldset>

                </div>

                <div class="section-part columns-box">

                    <h4>Columns section</h4>

                    <?php 
                    for($i=1;$i<6;$i++){ 
                       echo "<fieldset class='body-field column-fieldset'>
                         <legend>Column $i</legend>
                         <div class='select-type'>
                             <input type='hidden' name='new-column-$i-color' id='new-column-$i-color' value='0' />
                             <div class='select-box' id='new-column-$i-bg'>
                               <ul>
                                <li><a href='#0' class='current choice'>Select Color<i class='fa fa-caret-down'></i></a></li>
                                <li><a href='#white' class='smooth-hover choice'>white<i class='fa fa-caret-down'></i></a></li>
                                <li><a href='#transparent' class='smooth-hover choice'>transparent<i class='fa fa-caret-down'></i></a></li>
                              </ul>
                             </div>
                         </div>
                         <label for='Column $i Content'>Content</label>
                         <textarea id='column-$i-body' name='colcontent[]'></textarea>
                        </fieldset>";
                    } ?>

                </div>

            </section>

            <section>
                
                <fieldset id="select-categories">
                    <label for="sample-reqs">SAMPLE REQUIREMENTS<span class="hint line-break">(Hold down Command on Mac or Ctrl on Win to select/deselect options)</span></label>
                    <select name="samplereqs[]" size="3" multiple>
                        <?php 
                            $sampleReqs = $dbhelper->selectAll('SELECT * FROM sample_requirements');
                            foreach($sampleReqs as $sr){
                                echo "<option value='{$sr['pkid']}'>{$sr['product']}</option>";
                            }
                        ?>
                    </select>
                </fieldset>

            </section>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="24" />
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

<dialog class="dialog error-dialog">
  <p>Must select Layout</p>
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
var Editors = ['#part-1-paragraph', '#part-1-body', '#column-1-body', '#column-2-body', '#column-3-body', '#column-4-body', '#column-5-body'];
var editor = [];

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
   for(var j=0; j<Editors.length; j++){
     if(isBodyEmpty(editor[j].value)) editor[j].value = '';
   }
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
      //$('.section-off').parent().find('.toggle-section').removeClass('fa-plus-circle').addClass('fa-minus-circle');
      //$('.section-off').addClass('section-on').removeClass('section-off').slideToggle();
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
  if(goBtn.closest('.section-heading').find('#layout').val() == 0 && goBtn.closest('.section-heading').find('#colnum').val() == 0){
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
          goBtn.closest('.section-heading').find('.select-type input').each(function(i){
            if($(this).attr('id') == 'colnum'){
              var colNum = $(this).val();
              var columns = goBtn.closest('section').find('.column-fieldset');
              var colLenght = columns.length;
              if(colNum > 0){
                goBtn.closest('section').find('.columns-box').fadeIn();
                for(k=0;k < colNum;k++){
                   columns[k].style.display = 'block';
                }
              }
            }
          });
      }else{
        goBtn.text('DONE');
        goBtn.closest('section').find('.section-part').addClass('section-off').removeClass('section-on');
        goBtn.closest('section').find('.columns-box').hide();
        goBtn.closest('.section-heading').find('.select-type input').each(function(j){
            //$(this).val(0); //rest select values to 0
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
