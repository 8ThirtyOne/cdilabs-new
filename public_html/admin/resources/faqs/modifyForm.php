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
      $PageUrl = "/admin/resources/faqs/modifyForm";
      $PageCode = "000000";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter('pkid', 0, false);   
        $exists = $dbhelper->numOfRows("SELECT slugurl FROM faqs_page WHERE pkid = ? AND cat='faqs'", 'i', $pkid);
        if($exists > 0){
          $bodyid = 'faqs';
          $page = $webhelper->RequestFilter("page", 0, false);
          $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
          $order = $webhelper->RequestFilter("order", 0, false);
          $Parameter = "&searchKey=$searchKey&order=$order";
          $ViewPage = $dbhelper->RunSQLReturnOneRow("SELECT * FROM faqs_page WHERE pkid = $pkid AND cat='faqs'");
          $ViewHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM faqs_page_hero WHERE page_id = $pkid");
          $pageSection = $dbhelper->selectAll("SELECT * FROM faqs_page_section WHERE page_id = $pkid ORDER BY position ASC");
        }else{
         header('Location: /admin/resources/faqs/errorPage?reason=no-page-found');
         exit;
        }
      }else{
         header('Location: /admin/resources/faqs/list');
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
<title>Modify FAQS Page | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
    #module-data .upload-field div input{margin-top:15px}
    #module-data .upload-field div input{width:92px}
    #module-data .select-type{width:280px}
    #module-data #page-hero .select-type{width:200px}
    .faqs-paragraph{background:#eee;height:auto;padding:2% 0}
    .jodit-icon_paragraph{fill:#e03c31}
    .jodit-toolbar-button_classSpan svg{fill:#346c97}
    .jodit-toolbar-button__text{color:#346c97;font-family:Camber Medium !important}
    #module-data .jodit-workplace{height:800px !important}
    #module-data #page-hero .jodit-workplace{height:200px !important}
    #module-data .jodit-workplace h3{color:#181818;float:none}
    #module-data .jodit-workplace h4{font:16px Camber Medium}
    table th{background:#020D1E}
    .data_table th, .data_table td{text-align:left}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main>
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="module-section">

            <h2>Modify FAQS Page</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/resources/faqs/modifyPage" id="module-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid" value="<?php echo $ViewPage["pkid"]; ?>" />
                <input type="hidden" name="page" value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey" value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order" value="<?php echo $order; ?>" />

            <section class="page-section">

                <div class="section-heading">
                    <h3>PRODUCT INFO</h3>
                    <ul class="section-go">
                        <li class="toggle-section fa fa-minus-circle"></li>
                    </ul>
                </div>

                <div class="section-part section-on">

                    <fieldset>
                        <label for="pagetitle">Title<span>*</span></label>
                        <input type="text" name="pagetitle" id="page-title" class="get-value page-short-input" value="<?php echo $ViewPage['title']; ?>" maxlength="150" tabindex="1" />
                    </fieldset>

                    <fieldset>
                        <label for="slugurl">Slug Url<span>*</span><span class="hint"> (Only letters, numbers and hyphens allowed)</span></label>
                        <input type="text" name="slugurl" id="slugurl" class="get-value page-short-input" pattern="[a-zA-Z0-9\-\s]+" title="Only letters, numbers and hyphens are allowed." value="<?php echo $ViewPage['slugurl']; ?>" maxlength="200" tabindex="2" />
                    </fieldset>

                 </div>

            </section>

            <section class="page-section" id="page-hero">

                <div class="section-heading tall-heading">

                    <h3>HERO SECTION</h3>

                    <div class="select-type">
                    <?php 
                    $heroLayouts = array('left', 'center', 'right');
                    $heroAlign = $ViewHero['align'];
                    $heroSubeading = $ViewHero['subheading'] == 'none' ? '' : htmlentities($ViewHero['subheading']);
                    $heroHeading = $ViewHero['heading'] == 'none' ? '' : htmlentities($ViewHero['heading']);
                    echo "<input type='hidden' name='herolayout' id='hero-layout' value='$heroAlign' />"; 
                    echo "<div class='select-box' id='select-hero-layout'>";
                         echo "<ul>"; 
                              if($heroAlign != 'none'){
                                 echo "<li><a href='#$heroAlign' class='current choice'>$heroAlign<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($heroLayouts as $lRow){
                                   if($heroAlign != $lRow){
                                      echo "<li><a href='#$lRow' class='smooth-hover choice'>$lRow<i class='fa fa-caret-down'></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($heroLayouts as $lRow){
                                    echo "<li><a href='#$lRow' class='smooth-hover choice'>$lRow<i class='fa fa-caret-down'></i></a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    ?>
                    </div>

                    <div class="select-type">
                    <?php 
                    $heroHeights = array('tall', 'short');
                    $heroHeight = $ViewHero['height'];
                    echo "<input type='hidden' name='heroheight' id='hero-height' value='$heroHeight' />"; 
                    echo "<div class='select-box' id='select-hero-height'>";
                         echo "<ul>"; 
                              if($heroHeight != 'none'){
                                 echo "<li><a href='#$heroHeight' class='current choice'>$heroHeight<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($heroHeights as $htRow){
                                   if($heroHeight != $htRow){
                                      echo "<li><a href='#$htRow' class='smooth-hover choice'>$htRow<i class='fa fa-caret-down'></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Height<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($heroHeights as $htRow){
                                    echo "<li><a href='#$htRow' class='smooth-hover choice'>$htRow<i class='fa fa-caret-down'></i></a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    ?>
                    </div>

                    <div class="select-type">
                    <?php 
                    $heroColors = array('white', 'dark');
                    $heroBg = $ViewHero['bg'];
                    echo "<input type='hidden' name='herobg' id='hero-bg' value='$heroBg' />"; 
                    echo "<div class='select-box' id='select-hero-bg'>";
                         echo "<ul>"; 
                              if($heroBg != 'none'){
                                 echo "<li><a href='#$heroBg' class='current choice'>$heroBg<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($heroColors as $bgRow){
                                   if($heroBg != $bgRow){
                                      echo "<li><a href='#$bgRow' class='smooth-hover choice'>$bgRow<i class='fa fa-caret-down'></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($heroColors as $bgRow){
                                    echo "<li><a href='#$bgRow' class='smooth-hover choice'>$bgRow<i class='fa fa-caret-down'></i></a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    ?>
                    </div>

                    <ul class="section-go">
                        <li class="toggle-section fa fa-minus-circle"></li>
                    </ul>
                </div>

                <div class="section-part section-on hero-part">
                    <input type="hidden" name="oldHeroDesktop" value="<?php echo $ViewHero["desktop"]; ?>" />
                    <input type="hidden" name="oldHeroMobile" value="<?php echo $ViewHero["mobile"]; ?>" />
                    <input type="hidden" name="oldHeroOrgName" value="<?php echo $ViewHero["orgfilename"]; ?>" />
                    <fieldset class="upload-field img-upload">
                        <label for="Desktop Hero">Desktop</label>
                        <?php
                        echo "<div>";
                          if($ViewHero["desktop"] !='none'){
                            $ext = pathinfo($ViewHero["desktop"], PATHINFO_EXTENSION);
                               if($ext == 'mp4'){
                                  echo "<p>".$ViewHero["orgfilename"]."</p>";
                               }else{
                                  echo "<img src=\"/files/hero/faqs/" . $ViewHero["desktop"] . "\">";
                               }
                           }
                           echo "<input type='file' name='herodesktop' tabindex='3'>
                          <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>";
                        echo "</div>";
                        ?>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Hero">Mobile</label>
                        <?php
                             echo "<div>";
                             if($ViewHero["mobile"] != 'none'){
                                echo "<img src=\"/files/hero/faqs/" . $ViewHero["mobile"] . "\">";
                             }
                             echo "<input type='file' name='heromobile' tabindex='4'>
                             <p>Accepted file types: <span>jpg, png, gif</span></p>";
                             echo "</div>";
                        ?>
                    </fieldset>

                    <fieldset>
                        <label for="hero-subtitle">Subtitle</label>
                        <input type="text" name="herosubtitle" id="hero-subtitle" class="page-short-input" value="<?php if($ViewHero['subheading'] !='none') echo $ViewHero['subheading']; ?>"  maxlength="100" tabindex="5" />
                    </fieldset>

                    <fieldset id="hero-para-field">
                     <label for="hero paragraph">Paragraph</label>
                     <textarea id="hero-body" name="heroparagraph" tabindex="7"><?php if($ViewHero['paragraph'] !='none') echo stripcslashes($ViewHero['paragraph']); ?></textarea>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="section-cta">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name="herosectionbtn" class="section-cta" id="hero-section-cta" value="<?php if($ViewHero['btn_text'] !='none') echo $ViewHero['btn_text']; ?>" maxlength="20" tabindex="8" />
                        </div>
                        <div class="request-checkboxes">
                            <?php  
                              $heroTarget = $ViewHero["btn_target"] == 1 ? "checked='checked'" : '';?>
                            <div>
                             <label for="Outbound Link?">Outbound Link?</label>
                             <input type="checkbox" name="hero-outbound" value="1" <?php echo $heroTarget; ?> tabindex="9" />
                            </div>
                        </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name="herotargeturl" class="page-short-input" value="<?php if($ViewHero['btn_url'] !='none') echo $ViewHero['btn_url']; ?>"maxlength="255" tabindex="10" />
                        </div>
                    </fieldset>

                </div>

            </section>

            <?php 
             $sectionNum = 1;
             $sectionTotal = count($pageSection);
             $newSectionNum = $sectionTotal + 1;
             foreach ($pageSection as $section){ 
               $sectionId = $section['pkid'];
               $sectionPos = $section['position'];
               $sectionClass = $section['class_name'];
               $sectionIdName = $section['id_name'];
               $sectionBody = $section['cat_body'] == 'none' ? '' : $section['cat_body'];
               if($section["status"] == 1){
                 $status = "Unpublish";
                 $statusClass="publish";
                }else{
                 $status = "Publish"; 
                 $statusClass="unpublish";
                }

               echo "<section class='page-section $sectionClass' id='$sectionIdName'>
                  <input name='section[]' value='$sectionId' type='hidden' />
                  <input name='section-$sectionNum-position' value='$sectionPos' type='hidden' />"; 
               echo "<div class='section-heading tall-heading'>
                    <h3 class='section-pos' id='sectionpos$sectionId'>CAT SECTION $sectionNum</h3>";
                    echo "<div class='select-type'>";
                    $sectionCats = array('What is PhIP-Seq?','applications','array-controls','assay-methodology','storage-stability-and-documentation','shipping','content','production-and-quality','serum-profiling','data-analysis-and-deliverables','gst-staining-and-gridding','antibody-specificity-and-cross-reactivity-testing','additional-resources');
                    echo "<input type='hidden' name='section-$sectionNum-category' value='$sectionIdName' />"; 
                    echo "<div class='select-box' id='section-$sectionNum-category'>";
                         echo "<ul>";
                              if($sectionIdName != 'none'){
                              	 $secCurrCat = $section['category'];
                                 echo "<li><a href='#$sectionIdName' class='current choice'>$secCurrCat<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($sectionCats as $scRow){
                                 	if($sectionIdName != $scRow){
                                      $excludedWords = array(
                                        "and"
                                      );
                                 	  $string = str_replace("-"," ",$scRow);
                              	      $scRowName = ucwords($string);
                                      $scRowName = str_ireplace($excludedWords, $excludedWords, $scRowName);
                                      echo "<li><a href='#$scRow' class='smooth-hover choice'>$scRowName<i class='fa fa-caret-down'></i></i></a></li>";
                                    }
                                  }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Category<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($sectionCats as $scRow){
                                    echo "<li><a href='#$scRow' class='smooth-hover choice'>$scRow<i class='fa fa-caret-down'></i></a></li>";
                                  }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    echo "</div>";
                    echo "<ul class='section-go'>
                          <li id='deletesec$sectionId' class='global-btn clear-btn delete-section smooth-hover'>Delete</li>
                        <li id='statussec$sectionId' class='global-btn blue-btn smooth-hover status $statusClass'>$status</li>
                        <li class='toggle-section fa fa-minus-circle'></li>
                         </ul>";
                   echo "</div>";
                ?>

                    <fieldset class='body-field'>
                     <label for='Page Body'>Page Body <span class='hint'>(H3 for Questions, New Answer for all content, H4 for subheadings in Answer paragraph)</span></label>
                     <?php echo"<textarea id='section-$sectionNum-body' class='page-body' name='section-$sectionNum-body' tabindex='11'>$sectionBody</textarea>"; ?>
                    </fieldset>

            </section>
            <?php
             $sectionNum++;
            } ?>

            <section class="page-section" id="new-section">
                <input name='new-section' id="new-section-num" value='0' type='hidden' />

                <div class="section-heading tall-heading">

                    <h3>ADD CATEGORY</h3>
                
                    <div class="select-type">
                        <input type="hidden" name="new-category" id="new-category" value="0" />
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
                     <label for="Page paragraph">Body <span class='hint'>(Select H3 from Red Icon for Questions, Blue Icon for more fonts)</span></label>
                     <textarea id="body" name="new-section-body" class='page-body' tabindex="12"></textarea>
                    </fieldset>

                </div>

            </section>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="13" />
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

<dialog class="dialog error-dialog">
  <p>Must select Category</p>
  <button class="global-btn blue-btn">OK</button>
</dialog>

<dialog class="dialog modify-pos-dialog" id="section-pos-dialog">
    <div class="delete-inner">
        <form method="post" name="editSectionPos" id="section-pos-form">
          <input type="hidden" name="sectionposid" id="section-pos-id" />
          <input type="hidden" name="sectionpageid" id="section-page-pos-id" />
          <input type="text" name="newsectionpos" class="new-pos-box" />       
          <input type="submit" name="submitSectionPos" value="GO" class='modify-pos-btn global-btn blue-btn smooth-hover' />
          <input type="text" class='global-btn close-modify-pos' value="Cancel" id="close-section-pos">
         </form>
         
     </div>
</dialog>

<dialog class="dialog delete-dialog delete-section-dialog">
    <div class="delete-inner">
        <form method="post" name="deleteSection" id="del-section-form">
          <input type="hidden" name="secid" id="del-section-id" /> 
          <input type="hidden" name="pgid" id="del-page-id" />       
          <input type="submit" name="delSection" value="YES" class='global-btn blue-btn smooth-hover' id="del-yes-btn" tabindex="1" />
         </form>
         <button class='global-btn' id="close-del-section">NO</button>
     </div>
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
   if(isEditorEmpty(heroEditor.value)) heroEditor.value = '';
   for(var j=0;j<sectionEditors.length;j++){
      if(isEditorEmpty(editor[j].value)) editor[j].value = '';
   }
   $('#submit-btn').prop('disabled', true);
   $('#submit-btn').val('Please Wait').css('background','#7d868c');
   var f = document.regFrm;
   f.submit();
 }
});

function isEditorEmpty(input) {
   if(input.replace(/<(.|\n)*?>/g, '').trim().length === 0 && !input.includes("<div")){
      return true;
   }
  return false;
}

/*-------- TOGGLE SECTION ---------*/
$('.toggle-section').click(function(e){
  var expandOne = $(this);
  if(expandOne.hasClass('fa-plus-circle')){
     expandOne.removeClass('fa-plus-circle').addClass('fa-minus-circle');
  }else{
     expandOne.removeClass('fa-minus-circle').addClass('fa-plus-circle');
  }

  var sectionPart = expandOne.closest('section').find('.section-part');
  var divsOpened = $('.section-on').length;

    if(sectionPart.hasClass('section-off')){
        sectionPart.slideToggle(400, function(){
            sectionPart.addClass('section-on').removeClass('section-off');
        });
    }else{
        sectionPart.slideToggle(400, function(){
            sectionPart.addClass('section-off').removeClass('section-on');
        });
    }
    e.preventDefault();
});

/*-------------- SELECT SECTION PROPERTIES ------------*/

$('.go-btn').click(function(e){
  e.preventDefault();
  var goBtn = $(this);
  if(goBtn.closest('.section-heading').find('#new-category').val() == 0){
      dialog.showModal();
      const overlay = document.createElement('div');
      overlay.setAttribute('id', 'overlay');
      document.getElementsByTagName('main')[0].append(overlay);
  }else{
      if(goBtn.text() == 'DONE'){
          goBtn.text('CANCEL');
          $('#new-section-num').val(<?php echo $newSectionNum; ?>);
          goBtn.closest('section').find('.section-part').addClass('section-on').removeClass('section-off');
      }else{
        goBtn.text('DONE');
        $('#new-section-num').val(0);
        goBtn.closest('section').find('.section-part').addClass('section-off').removeClass('section-on');
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

      if($('#'+id).height() > 40){
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
       if($('#'+box).height() > 40){
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

const dialog = document.querySelector(".error-dialog");
const closeButton = document.querySelector(".error-dialog button");

closeButton.addEventListener("click", () => {
  dialog.close();
  overlay.remove();
});

/*----------- Change Section Position ---------*/
var cmsCat = 'faqs';
const sectionPosDialog = document.getElementById("section-pos-dialog");
const closeSectionPos = document.getElementById("close-section-pos");

$('.section-pos').click(function(e){
    e.preventDefault();
    $('#section-pos-dialog p').remove();
    const overlay = document.createElement('div');
    overlay.setAttribute('id', 'overlay');
    document.getElementsByTagName('main')[0].append(overlay);
    var getId=$(this).attr('id');
    var id = getId.split("sectionpos").pop();
    $('#section-pos-id').val(id);
    $('#section-page-pos-id').val('<?php echo $pkid; ?>');
    var sectionName = $(this).text();
    var warning = $(document.createElement('p'));
    warning.text("Enter new position number for "+sectionName);
    warning.insertBefore($('#section-pos-id'));
    sectionPosDialog.showModal();
});

$('form#section-pos-form').submit(function(){
  var query = $('#section-pos-form').serializeArray(); 
  $.ajax({
     type: 'POST',
     url: '/admin/resources/faqs/category-section/editSectionPos',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/resources/faqs/modifyForm?pkid=<?php echo $pkid.'&page='.$page.$Parameter; ?>";
         }else if(result == "2"){
            alert('Category section not found.');
         }else if(result == "3"){
            alert('Category section Position could not be changed.');
         }else if(result == "4"){
            alert('Other category sections could not be updated. Try again.');
         }else if(result == "5"){
            alert('Category section position update failed. Try again.');
         }else if(result == "6"){
           alert('Position number you entered is either 0 or bigger than number of sections.');
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

closeSectionPos.addEventListener("click", () => {
  sectionPosDialog.close();
  overlay.remove();
});

/*-------- publish/unpublish ---------*/
 $('.status').click(function(e){
      e.preventDefault();
      var getId = $(this).attr('id'); 
      var id = getId.split("statussec").pop();
      var getStatus = $(this).attr('class'); 
      getStatus = getStatus.split("status ").pop();
      var status = getStatus == 'unpublish' ? 'publish' : 'unpublish';
      var capitalized = getStatus.charAt(0).toUpperCase() + getStatus.slice(1);
      $.ajax({
           type: 'GET',
           url: '/admin/resources/faqs/category-section/'+status+'Section?id='+id, 
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#statussec'+id).removeClass(getStatus).addClass(status);
              $('#statussec'+id).text(capitalized);
            }else if(result == "2"){
             alert('Category section does not exist.');
            }else{
              alert('Something went wrong. Try again.');
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
       });
  });

const delDialog = document.querySelector(".delete-section-dialog");
const closeDelete = document.getElementById("close-del-section");

$('.delete-section').click(function(e){
    e.preventDefault();
    $('.delete-section-dialog p').remove();
    const overlay = document.createElement('div');
    overlay.setAttribute('id', 'overlay');
    document.getElementsByTagName('main')[0].append(overlay);
    var getId=$(this).attr('id');
    var id = getId.split("deletesec").pop();
    $('#del-section-id').val(id);
    $('#del-page-id').val(<?php echo $pkid; ?>);
    var sectionName = $(this).closest('.section-heading').find('h3').text();
    var warning = $(document.createElement('p'));
    warning.text("Are you sure you want to delete "+sectionName);
    warning.insertBefore($('.delete-section-dialog .delete-inner'));
    delDialog.showModal();
});

$('form#del-section-form').submit(function(){
  var query = $('#del-section-form').serializeArray(); 
  $.ajax({
     type: 'POST',
     url: '/admin/resources/faqs/category-section/deleteSection',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/resources/faqs/modifyForm?pkid=<?php echo $pkid.'&page='.$page.$Parameter; ?>";
         }else if(result == "2"){
            alert('Category section not found.');
         }else if(result == "3"){
            alert('Category section could not be deleted.');
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

closeDelete.addEventListener("click", () => {
  delDialog.close();
  overlay.remove();
});
</script>
</script>
</body>
</html>

