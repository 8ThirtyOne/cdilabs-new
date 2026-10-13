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
      if(isset($_GET['category']) && !empty($_GET['category']) && isset($_GET['pkid']) && !empty($_GET['pkid'])){
         $pageId = $webhelper->RequestFilter("pkid", 0, false);
         $cmscat = $webhelper->RequestFilter("category", 50, false);
         $slugurl = $dbhelper->selectOne("SELECT slugurl FROM web_page WHERE pkid = ? AND cat = '$cmscat'", 's', $pageId);
         if(!empty($slugurl) && $slugurl != ''){
           $PageUrl = "/admin/cmsmodel/page-module/pageWithSlides";
           $PageCode = "000000";
           $bodyid = $cmscat;
           $FirstPageCode = substr($PageCode, 0, 2);
           $SecodeCode = substr($PageCode, 2, 2);
           $ThirdCode = substr($PageCode, 4, 2);
           $page = $webhelper->RequestFilter("page", 0, false);
           $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
           $order = $webhelper->RequestFilter("order", 0, false);
           $Parameter = "&searchKey=$searchKey&order=$order";
           $ViewPage = $dbhelper->RunSQLReturnOneRow("SELECT pkid, title, description FROM web_page WHERE slugurl='$slugurl' AND cat='$cmscat'");
           $pageId = $ViewPage['pkid'];
           $pageHero = $dbhelper->selectAll("SELECT * FROM web_page_hero WHERE page_id = $pageId ORDER BY hero_pos ASC");
           $formInc = $dbhelper->numOfRows("SELECT pkid FROM page_form_lookup WHERE page_id = ?", 'i', $pageId);
           if($formInc > 0){
             $pageForm = $dbhelper->RunSQLReturnOneRow("SELECT * FROM page_form_lookup WHERE page_id = $pageId");
             $formName = $pageForm['form_name'];
           }
           $pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = $pageId ORDER BY position ASC");
           }else{
              header('Location: /admin/cmsmodel/errorPage?reason=no-page-found');
              exit;
           }
       }else{
          header('Location: /admin/cmsmodel/errorPage?reason=no-page-found');
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
<title>Modify Home Page | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
    #admin-panel h2 a{margin-left:20px}
    #module-data .upload-field div input{margin-top:15px}
    #module-data .upload-field div input{width:92px}
    .services-icon{width:200px}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main>
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="module-section">

            <h2>Modify Home Page <?php echo "<a href='/admin/cmsmodel/page-module/preview?slugurl=$slugurl&category=$cmscat' class='global-btn blue-btn smooth-hover' target='_blank'>Preview</a>"; ?></h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/cmsmodel/page-module/modifyPageWithSlides" id="module-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid" value="<?php echo $pageId; ?>" />
                <input type="hidden" name="cmscategory" value="<?php echo $cmscat; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />

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
                        <input type="text" name="pagetitle" id="page-title" class="get-value page-short-input" value="<?php echo $ViewPage['title']; ?>" maxlength="150" tabindex="1" />
                    </fieldset>

                    <fieldset>
                     <label for="Description">Page Meta Description<span>*</span></label>
                       <textarea name="pagedesc" id="page-desc" class="meta-desc get-value" rows="1" cols="1" minlength="10" maxlength="250" tabindex="2"><?php echo $ViewPage['description']; ?></textarea>
                     </fieldset>

                     <fieldset>

                        <div class="select-type" id="select-page-form">
                            <?php 
                            $pageForms = array('contact-form', 'grant-form', 'remove');
                            $pageFormsAdd = array('contact-form', 'grant-form');
                            $currentFormValue = !empty($formName) ? $formName : 'remove';
                            echo "<input type='hidden' name='chooseform' id='choose-form' value='$currentFormValue' />"; 
                            echo "<div class='select-box' id='select-box-form'>";
                                 echo "<ul>"; 
                                      if(!empty($formName)){
                                         echo "<li><a href='#$formName' class='current choice'>$formName<i class='fa fa-caret-down'></i></a></li>";
                                         foreach($pageForms as $pfRow){
                                           if($formName != $pfRow){
                                            echo "<li><a href='#$pfRow' class='smooth-hover choice'>$pfRow<i class='fa fa-caret-down'></i></a></li>";
                                           }
                                         }
                                       }else{
                                          echo "<li><a href='#remove' class='current choice'>Add Form<i class='fa fa-caret-down'></i></a></li>";
                                          foreach($pageFormsAdd as $pfRow){
                                            echo "<li><a href='#$pfRow' class='smooth-hover choice'>$pfRow<i class='fa fa-caret-down'></i></i></a></li>";
                                        }
                                      }
                                    echo "</ul>"; 
                                echo "</div>";
                            ?>
                            </div>

                     </fieldset>

                 </div>

            </section>

            <div class="page-section" id="main-hero">

                <div class="section-heading tall-heading">
                    <h3>HERO SECTION</h3>
                    <a class="global-btn" id="new-hero-btn" href="/admin/cmsmodel/hero-module/heroForm?pkid=<?php echo $pageId; ?>&category=<?php echo $cmscat; ?>">ADD NEW SLIDE</a>
                </div>

                <?php 
                $heroNum = 1;
                $heroTotal = count($pageHero);
                $newHeroNum = $heroTotal + 1;
                foreach ($pageHero as $ViewHero){ 
                  $heroId = $ViewHero['pkid'];
                  $heroPos = $ViewHero['hero_pos'];
                  $heroDesktop = $ViewHero['desktop'];
                  $heroMobile = $ViewHero['mobile'];
                  $heroOrgFilename = $ViewHero['orgfilename'];
                  $heroExt = pathinfo($ViewHero["desktop"], PATHINFO_EXTENSION);
                  $heroHeading =  $ViewHero['heading'] == 'none' ? '' : $ViewHero['heading'];
                  $heroSubheading = $ViewHero['subheading'] == 'none' ? '' : $ViewHero['subheading'];
                  $heroPara = $ViewHero['paragraph'] == 'none' ? '' : $ViewHero['paragraph'];
                   if($ViewHero["status"] == 1){
                     $heroStatus = "Unpublish";
                     $heroStatusClass="publish";
                    }else{
                     $heroStatus = "Publish"; 
                     $heroStatusClass="unpublish";
                    } 
                echo "<section class='hero-section'>
                    <input name='hero[]' value='$heroId' type='hidden' />
                    <input name='hero-$heroNum-position' value='$heroPos' type='hidden' />
                    <div class='section-heading tall-heading slide-heading'>
                    <h3 class='slide-pos' id='slide$heroId'>SLIDE $heroPos</h3>";
                    echo "<div class='select-type'>";
                    $heroLayouts = array('left', 'center', 'right');
                    $heroAlign = $ViewHero['align'];
                    echo "<input type='hidden' name='hero-$heroNum-layout' value='$heroAlign' />"; 
                    echo "<div class='select-box' id='select-hero-$heroNum-layout'>";
                         echo "<ul>"; 
                              if($heroAlign != 'none'){
                                 echo "<li><a href='#$heroAlign' class='current choice'>$heroAlign<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($heroLayouts as $hRow){
                                   if($heroAlign != $hRow){
                                      echo "<li><a href='#$hRow' class='smooth-hover choice'>$hRow<i class='fa fa-caret-down'></i></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($heroLayouts as $hRow){
                                    echo "<li><a href='#$hRow' class='smooth-hover choice'>$hRow<i class='fa fa-caret-down'></i></i></a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    echo "</div>"; 
                    echo "<div class='select-type'>";
                    $heroColors = array('white', 'dark');
                    $heroBg = $ViewHero['bg'];
                    echo "<input type='hidden' name='hero-$heroNum-bg' value='$heroBg' />"; 
                    echo "<div class='select-box' id='select-hero-$heroNum-bg'>";
                         echo "<ul>"; 
                              if($heroBg != 'none'){
                                 echo "<li><a href='#$heroBg' class='current choice'>$heroBg<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($heroColors as $bgRow){
                                   if($heroBg != $bgRow){
                                      echo "<li><a href='#$bgRow' class='smooth-hover choice'>$bgRow<i class='fa fa-caret-down'></i></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($heroColors as $bgRow){
                                    echo "<li><a href='#$bgRow' class='smooth-hover choice'>$bgRow<i class='fa fa-caret-down'></i></i></a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    echo "</div>";
                    echo "<ul class='section-go'>
                              <li id='deletehero$heroId' class='global-btn clear-btn delete-hero smooth-hover'>Delete</li>
                            <li id='heroslide$heroId' class='global-btn blue-btn smooth-hover hero-status $heroStatusClass'>$heroStatus</li>
                            <li class='toggle-slide fa fa-minus-circle'></li>
                             </ul>";
                    echo "</div>";
                    ?>

                    <div class="section-part section-on hero-part">

                        <fieldset class="upload-field img-upload">
                            <label for="Desktop Hero">Desktop<span>*</span></label>
                            <?php
                            echo "<input type='hidden' name='hero-$heroNum-oldDesktop' value='$heroDesktop' />";
                            echo "<input type='hidden' name='hero-$heroNum-oldOrgFilename' value='$heroOrgFilename' />";
                            echo "<div>";
                              if($ViewHero["desktop"] !='none'){
                                $ext = pathinfo($heroDesktop, PATHINFO_EXTENSION);
                                   if($ext == 'mp4'){
                                      echo "<p>$heroOrgFilename</p>";
                                   }else{
                                      echo "<img src='/files/hero/$cmscat/$heroDesktop' />";
                                   }
                               }
                               echo "<input type='file' name='hero-$heroNum-desktop' tabindex='4'>
                              <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>";
                            echo "</div>";
                            ?>
                        </fieldset>

                        <fieldset class="upload-field img-upload">
                            <label for="Mobile Hero">Mobile<span>*</span></label>
                            <?php
                                echo "<input type='hidden' name='hero-$heroNum-oldMobile' value='$heroMobile' />";
                                 echo "<div>";
                                 if($heroMobile != 'none'){
                                    echo "<img src='/files/hero/$cmscat/$heroMobile' />";
                                 }
                                 echo "<input type='file' name='hero-$heroNum-mobile' tabindex='5'>
                                 <p>Accepted file types: <span>jpg, png, gif</span></p>";
                                 echo "</div>";
                            ?>
                        </fieldset>

                        <fieldset>
                            <label for="hero-subtitle">Subtitle</label>
                            <input type="text" name="hero-<?php echo $heroNum; ?>-subtitle"  class="page-short-input" value="<?php if($ViewHero['subheading'] !='none') echo $ViewHero['subheading']; ?>"  maxlength="200" tabindex="5" />
                        </fieldset>

                        <fieldset>
                            <label for="hero-title">Main Title</label>
                            <input type="text" name="hero-<?php echo $heroNum; ?>-title" class="page-short-input" value="<?php if($ViewHero['heading'] !='none') echo $ViewHero['heading']; ?>" maxlength="200" tabindex="6" />
                        </fieldset>

                        <fieldset class="body-field">
                         <label for="hero paragraph">Paragraph</label>
                         <textarea id="hero-<?php echo $heroNum; ?>-body" class='page-body' name="hero-<?php echo $heroNum; ?>-paragraph" tabindex="7"><?php if($ViewHero['paragraph'] !='none') echo stripcslashes($ViewHero['paragraph']); ?></textarea>
                        </fieldset>

                        <fieldset class="cta-fieldset">
                            <div>
                                <label for="section-cta">CTA Button</label>
                                <p>Max characters 20</p>
                                <input type="text" name="hero-<?php echo $heroNum; ?>-btn" class="section-cta" value="<?php if($ViewHero['btn_text'] != 'none') echo $ViewHero['btn_text']; ?>" maxlength="20" tabindex="8" />
                            </div>
                            <div class="request-checkboxes">
                                <?php  
                                  $heroTarget = $ViewHero["btn_target"] == 1 ? "checked='checked'" : '';?>
                                <div>
                                 <label for="Outbound Link?">Outbound Link?</label>
                                 <input type="checkbox" name="hero-<?php echo $heroNum; ?>-outbound" value="1" <?php echo $heroTarget; ?> tabindex="9" />
                                </div>
                            </div>
                            <div>
                                <p>Target URL</p>
                                <input type="text" name="hero-<?php echo $heroNum; ?>-targeturl" class="page-short-input" value="<?php if($ViewHero['btn_url'] != 'none') echo $ViewHero['btn_url']; ?>"maxlength="255" tabindex="10" />
                            </div>
                        </fieldset>

                        <fieldset class="cta-fieldset">
                            <div>
                                <label for="section-cta">CTA Button (second)</label>
                                <p>Max characters 20</p>
                                <input type="text" name="hero-<?php echo $heroNum; ?>-btn2" class="section-cta" value="<?php if($ViewHero['btn2_text']) echo $ViewHero['btn2_text']; ?>" maxlength="20" tabindex="8" />
                            </div>
                            <div class="request-checkboxes">
                                <?php  
                                  $heroTarget = $ViewHero["btn2_target"] == 1 ? "checked='checked'" : '';?>
                                <div>
                                 <label for="Outbound Link?">Outbound Link?</label>
                                 <input type="checkbox" name="hero-<?php echo $heroNum; ?>-outbound2" value="1" <?php echo $heroTarget; ?> tabindex="9" />
                                </div>
                            </div>
                            <div>
                                <p>Target URL</p>
                                <input type="text" name="hero-<?php echo $heroNum; ?>-targeturl2" class="page-short-input" value="<?php if($ViewHero['btn2_url']) echo $ViewHero['btn2_url']; ?>"maxlength="255" tabindex="10" />
                            </div>
                        </fieldset>

                    </div>

                <?php 
                    echo "</section>";
                    $heroNum++;
                } ?>

            </div>

            <?php 
             $sectionNum = 1;
             $sectionTotal = count($pageSection);
             $newSectionNum = $sectionTotal + 1;
             $formExists = $dbhelper->selectOne("SELECT pkid FROM web_page_section WHERE hasForm = 1 AND page_id=?", 'i', $pageId);
             foreach ($pageSection as $section){ 
               $sectionId = $section['pkid'];
               $sectionPos = $section['position'];
               $sectionClass = $section['class_name'];
               $sectionIdName = $section['id_name'];
               $sectionDesktop = $section['bgimg'];
               $sectionMobile = $section['bgMobileImg'];
               $sectionHeading =  $section['heading'] == 'none' ? '' : htmlentities($section['heading']);
               $sectionSubheading = $section['subheading'] == 'none' ? '' : htmlentities($section['subheading']);
               $sectionPara = $section['section_paragraph'] == 'none' ? '' : $section['section_paragraph'];
               $sectionIncForm = $section["hasForm"] == 1 ? "checked='checked'" : '';
               $sectionBody = $section['section_body'] == 'none' ? '' : $section['section_body'];
               $section['ytvideo'] == 'none' ? $ytVideo = '' : $ytVideo = $section['ytvideo'];
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
                    <h3 class='section-pos' id='sectionpos$sectionId'>SECTION $sectionNum</h3>";
                    echo "<div class='select-type'>";
                    $sectionLayouts = array('left', 'center', 'right');
                    $sectionAlign = $section['align'];
                    echo "<input type='hidden' name='section-$sectionNum-layout' value='$sectionAlign' />"; 
                    echo "<div class='select-box' id='select-section-$sectionNum-layout'>";
                         echo "<ul>"; 
                              if($sectionAlign != 'none'){
                                 echo "<li><a href='#$sectionAlign' class='current choice'>$sectionAlign<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($sectionLayouts as $slRow){
                                   if($sectionAlign != $slRow){
                                      echo "<li><a href='#$slRow' class='smooth-hover choice'>$slRow<i class='fa fa-caret-down'></i></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($sectionLayouts as $slRow){
                                    echo "<li><a href='#$slRow' class='smooth-hover choice'>$slRow<i class='fa fa-caret-down'></i></i></a></li>";
                                }
                              }
                            echo "</ul>"; 
                        echo "</div>";
                    echo "</div>";

                    echo "<div class='select-type'>";
                    $sectionColors = array('white', 'blue', 'dark-blue', 'black', 'gray');
                    $sectionBg = $section['bgColor'];
                    echo "<input type='hidden' name='section-$sectionNum-bgcolor' value='$sectionBg' />"; 
                    echo "<div class='select-box' id='select-section-$sectionNum-bg'>";
                         echo "<ul>"; 
                              if($sectionBg != 'none'){
                                 echo "<li><a href='#$sectionBg' class='current choice'>$sectionBg<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($sectionColors as $sbgRow){
                                   if($sectionBg != $sbgRow){
                                      echo "<li><a href='#$sbgRow' class='smooth-hover choice'>$sbgRow<i class='fa fa-caret-down'></i></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Select Background Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($sectionColors as $sbgRow){
                                    echo "<li><a href='#$sbgRow' class='smooth-hover choice'>$sbgRow<i class='fa fa-caret-down'></i></i></a></li>";
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

                <div class='section-part section-on main-column'>

                    <fieldset class='upload-field img-upload'>
                      <label for='Desktop Background Image'>Desktop Background Image</label>
                      <?php
                      echo "<input type='hidden' name='section-$sectionNum-oldBgImg' value='$sectionDesktop' />";
                      if($sectionDesktop != 'none'){
                         echo "<div>
                         <img src=/files/main/$sectionDesktop />
                         <input type='file' name='section-$sectionNum-bgimg' tabindex='11'>
                         <p>Accepted file types: <span>jpg, png, gif</span></p>
                         <h5 id='secbgimg-$sectionId' class='del-bg-img'>Delete</h5>
                         </div>";
                       }else{
                         echo "
                         <input type='file' name='section-$sectionNum-bgimg' tabindex='11'>
                         <p>Accepted file types: <span>jpg, png, gif</span></p>";
                       }
                      ?>
                    </fieldset>

                    <fieldset class='upload-field img-upload'>
                        <label for='Mobile Background Image'>Mobile Background Image</label>
                        <?php
                          echo "<input type='hidden' name='section-$sectionNum-oldBgMobile' value='$sectionMobile' />";
                          if($sectionMobile != 'none'){
                             echo "<div>
                             <img src=/files/main/$sectionMobile />
                             <input type='file' name='section-$sectionNum-bgmobile' tabindex='12'>
                             <p>Accepted file types: <span>jpg, png, gif</span></p>
                             <h5 id='secmobimg-$sectionId' class='del-bg-img del-mob-img'>Delete</h5>
                             </div>";
                           }else{
                             echo "
                             <input type='file' name='section-$sectionNum-bgmobile' tabindex='12'>
                             <p>Accepted file types: <span>jpg, png, gif</span></p>";
                           }
                        ?>
                    </fieldset>

                    <fieldset>
                        <label for='Main Heading'>Main Heading</label>
                        <input type="text" <?php echo "name='section-$sectionNum-heading' id='section-$sectionNum-heading'"; ?> value="<?php echo $sectionHeading; ?>" maxlength="200" tabindex="11" />
                    </fieldset>

                    <fieldset>
                        <label for='Subheading'>Subheading</label>
                        <input type="text" <?php echo "name='section-$sectionNum-subheading' id='section-$sectionNum-subheading'"; ?> value="<?php echo $sectionSubheading; ?>" maxlength="500" tabindex="12" />
                    </fieldset>

                    <fieldset class='body-field'>
                     <label for='Page Paragraph'>Page Paragraph</label>
                     <?php echo"<textarea id='section-$sectionNum-para' class='page-body' name='section-$sectionNum-paragraph' tabindex='15'>$sectionPara</textarea>"; ?>
                    </fieldset>

                    <fieldset class='field-checkbox'>
                         <div class="request-checkboxes">
                            <div>
                             <label for="Page Include Form">INCLUDE FORM</label>
                              <?php echo"<input type='checkbox' id='section-$sectionNum-incform' name='section-$sectionNum-incform' value='1' $sectionIncForm tabindex='14' />"; ?>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class='body-field'>
                     <label for='Page Body'>Page Body <span class="hint">(ADD CODE HERE) <?php echo 'main-'.$ViewPage['pkid'].'-section-'.$sectionId; ?></span></label>
                     <?php echo"<textarea id='section-$sectionNum-body' class='page-body' name='section-$sectionNum-body' tabindex='16'>$sectionBody</textarea>"; ?>
                    </fieldset>

                    <fieldset class='upload-field'>
                        <?php
                        $sectionVideoCustom = $section["videoimg"];
                        $sectionVideoCustomOrg = $section["videoimgorgname"];
                        echo "<input type='hidden' name='section-$sectionNum-oldVideoCustom' value='$sectionVideoCustom' />";
                        echo "<input type='hidden' name='section-$sectionNum-oldVideoCustomOrg' value='$sectionVideoCustomOrg' />";
                        echo "<label for='Image / Video Insert'>Image / Video Insert <span>(optional)</span></label>";
                        if($sectionVideoCustom != 'none'){
                          $vimgExt = pathinfo($sectionVideoCustom, PATHINFO_EXTENSION);
                          if($vimgExt == 'mp4'){
                             echo "<div>
                             <p>$sectionVideoCustomOrg</p>
                             <input type='file' name='section-$sectionNum-videocustom' tabindex='17'>
                             <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                             <h5 id='secvidimg-$sectionId' class='del-bg-img del-vid-img'>Delete</h5>
                             </div>";
                           }else{
                             echo "<div>
                             <img src=/files/main/$sectionVideoCustom />
                             <input type='file' name='section-$sectionNum-videocustom' tabindex='17'>
                             <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                             <h5 id='secvidimg-$sectionId' class='del-bg-img del-vid-img'>Delete</h5>
                             </div>";
                           }
                        }else{
                        echo "<input type='file' name='section-$sectionNum-videocustom' tabindex='17'>
                            <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>";
                        }
                        ?>
                    </fieldset>

                    <fieldset class='upload-field'>
                        <label for='YouTube Video Id'>Enter YouTube URL</label>
                        <?php 
                        echo "<input type='text' name='section-$sectionNum-youtubeurl' id='section-$sectionNum-youtube-url' value='$ytVideo' maxlength='50' tabindex='18' />"; ?>
                        <p class='field-eg'>Eg. https://www.youtube.com/watch?v=<span>abcd1234</span></p>
                    </fieldset>

                    <fieldset class='cta-fieldset'>
                        <?php
                        $sectionButtons = $dbhelper->selectAll("SELECT * FROM web_page_btn WHERE section_id = $sectionId");
                        if(count($sectionButtons) > 0){ 
                          foreach ($sectionButtons as $sBtn){ 
                            $btnId = $sBtn['pkid'];
                            $btnText = $sBtn['btn_text'] == 'none' ? '' : $sBtn['btn_text'];
                            $btnTarget = $sBtn["btn_target"] == 1 ? "checked='checked'" : ''; 
                            $btnUrl = $sBtn['btn_url'] == 'none' ? '' : $sBtn['btn_url']; 
                            $sBtn['btn_bg'] == 'none' ? $btnValue = 'global-btn' : $btnValue = $sBtn['btn_bg'];
                            echo "<input type='hidden' name='section-$sectionNum-btn[]' value='$btnId' />";
                            ?>
                            <div>
                                <label for='section-cta'>CTA Button</label>
                                <p>Max characters 20</p>
                                <input type="text" <?php echo "name='section-$sectionNum-btn-text-$btnId' class='section-cta' id='section-$sectionNum-btn-text-$btnId'"; ?> value="<?php echo $btnText; ?>" maxlength='20' tabindex='16' />
                            </div>
                            <div class="request-checkboxes choose-btn-color">
                            <div class="select-type">
                            <?php echo "<input type='hidden' name='section-$sectionNum-btncolor-$btnId' id='section-$sectionNum-btncolor-$btnId' value='$btnValue' />";
                              echo "<div class='select-box' id='btn-bg-$btnId'>"; ?>
                              <ul>
                                <?php 
                                $btnColors = array('blue-btn', 'global-btn');
                                if($sBtn['btn_bg'] != 'none'){ ?>
                                   <li><a href="#<?php echo $sBtn['btn_bg']; ?>" class="current choice"><?php echo $sBtn['btn_bg']; ?><i class="fa fa-caret-down"></i></a></li>
                                <?php
                                  foreach ($btnColors as $btnBg){
                                     if($sBtn['btn_bg'] != $btnBg){ ?>
                                      <li><a href="#<?php echo $btnBg; ?>" class="smooth-hover choice"><?php echo $btnBg; ?><i class="fa fa-caret-down"></i></i></a></li>
                                <?php }
                                  }
                                }else{ ?>
                                    <li><a href="#0" class="current choice">Choose Color<i class="fa fa-caret-down"></i></a></li>
                                    <?php foreach($btnColors as $btnBg){ ?>
                                      <li><a href="#<?php echo $btnBg; ?>" class="smooth-hover choice"><?php echo $btnBg; ?><i class="fa fa-caret-down"></i></i></a></li>
                              <?php  }
                                } ?>
                              </ul>
                              </div>
                            </div>
                            </div>
                            <div class='request-checkboxes'>
                                <div>
                                 <label for='Outbound Link'>Outbound Link?</label>
                                 <?php echo"<input type='checkbox' name='section-$sectionNum-outbound-$btnId' value='1' $btnTarget tabindex='20' />"; ?>
                                </div>
                            </div>
                            <div>
                                <p>Target URL</p>
                                <?php echo "<input type='text' name='section-$sectionNum-btnurl-$btnId' class='page-short-input' value='$btnUrl' maxlength='255' tabindex='21' />"; ?>
                            </div>
                        <?php } 
                         }
                        ?>
                    </fieldset>

                </div>

                <div class="section-part columns-box">

                    <div class="columns-heading">
                        <h5>Columns section</h5>
                        <a href="#" class="global-btn show-columns">Show</a>
                    </div>

                    <div class="columns-wrapper">
                        <?php
                        $colData = array();
                        $colCounter = 1;
                        $sectionColumns = $dbhelper->selectAll("SELECT pkid, bgColor, body FROM web_page_column WHERE section_id = $sectionId");
                        if(count($sectionColumns) > 0){ 
                          $colColors = array('white', 'transparent');
                          foreach($sectionColumns as $sColumn){
                            $colId = $sColumn['pkid'];
                            $colBody = empty($sColumn['body']) ? '' : stripcslashes($sColumn['body']);
                            $colBg = $sColumn['bgColor'];
                            echo 
                             "<input type='hidden' name='section-$sectionNum-column[]' value='$colId' />
                             <fieldset class='body-field column-fieldset'>
                             <legend>Column $colCounter</legend>";
                             echo "<div class='select-type'>";
                             echo "<input type='hidden' name='section-$sectionNum-column-$colCounter-color' id='section-$sectionNum-column-$colCounter-color' value='$colBg' />";
                             echo "<div class='select-box' id='select-$sectionNum-section-$colCounter-bg'>";
                                 echo "<ul>"; 
                                      if($colBg != ''){
                                         echo "<li><a href='#$colBg' class='current choice'>$colBg<i class='fa fa-caret-down'></i></a></li>";
                                         foreach($colColors as $colBgRow){
                                           if($colBg != $colBgRow){
                                              echo "<li><a href='#$colBgRow' class='smooth-hover choice'>$colBgRow<i class='fa fa-caret-down'></i></i></a></li>";
                                           }
                                         }
                                       }else{
                                          echo "<li><a href='#0' class='current choice'>Select Color<i class='fa fa-caret-down'></i></a></li>";
                                          foreach($colColors as $colBgRow){
                                            echo "<li><a href='#$colBgRow' class='smooth-hover choice'>$colBgRow<i class='fa fa-caret-down'></i></i></a></li>";
                                        }
                                      }
                                    echo "</ul>"; 
                                echo "</div>";
                             echo "</div>";
                             echo "<label for='Column $colCounter Content'>Content</label>
                             <textarea class='page-body' id='section-$sectionNum-column-$colCounter-body' name='section-$sectionNum-column-$colCounter-content'>$colBody</textarea>
                             </fieldset>";
                            $colCounter++;
                          }
                        }
                        ?>
                    </div>
                  
                </div>

            </section>
            <?php
             $sectionNum++;
            } ?>

            <section class="page-section" id="new-section">
                <input name='new-section' id="new-section-num" value='0' type='hidden' />

                <div class="section-heading tall-heading">

                    <h3>ADD SECTION</h3>
                
                    <div class="select-type">
                        <input type="hidden" name="new-layout" id="new-layout" value="0" />
                        <div class="select-box" id="new-section-layout">
                          <ul>
                            <li><a href="#0" class="current choice">Select Layout<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#left" class="smooth-hover choice">Left<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#center" class="smooth-hover choice">Center<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#right" class="smooth-hover choice">Right<i class="fa fa-caret-down"></i></a></li>
                          </ul>
                        </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="new-bgcolor" id="new-bgcolor" value="0" />
                        <div class="select-box" id="new-section-bg">
                          <ul>
                            <li><a href="#0" class="current choice">Select Background Color<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#white" class="smooth-hover choice">White<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#blue" class="smooth-hover choice">Blue<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#dark-blue" class="smooth-hover choice">Dark Blue<i class="fa fa-caret-down"></i></a></a></li>
                            <li><a href="#black" class="smooth-hover choice">Black<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#gray" class="smooth-hover choice">Gray<i class="fa fa-caret-down"></i></a></li>
                          </ul>
                        </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="new-colnum" id="new-colnum" value="0" />
                        <div class="select-box" id="new-section-cols">
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
                        <label for="Desktop Background Image">Desktop Background Image</label>
                        <input type="file" name='new-section-bgimg' tabindex="22">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Background Image">Mobile Background Image</label>
                        <input type="file" name='new-section-bgmobile' tabindex="23">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset>
                        <label for="Main Heading">Main Heading</label>
                        <input type="text" name='new-section-heading' id="new-section-heading" maxlength="200" tabindex="24" />
                    </fieldset>

                    <fieldset>
                        <label for="Subheading">Subheading</label>
                        <input type="text" name='new-section-subheading' id='new-section-subheading' maxlength="500" tabindex="25" />
                    </fieldset>

                    <fieldset class="body-field">
                     <label for="Page Paragraph">Page Paragraph</label>
                     <textarea class='page-body' id="new-section-para" name="new-section-paragraph" tabindex="26"></textarea>
                    </fieldset>

                    <?php 
                     if($formExists == 0){
                    ?>
                    <fieldset class="field-checkbox">
                        <div class="request-checkboxes">
                            <div>
                             <label for="Include Form">INCLUDE FORM</label>
                             <input type="checkbox" name='new-section-includeform' value="1" tabindex="27" />
                            </div>
                        </div>
                    </fieldset>
                    <?php } ?>

                    <fieldset class="body-field">
                     <label for="Page Body">Page Body</label>
                     <textarea class='page-body' id='new-section-body' name="new-section-body" tabindex="28"></textarea>
                    </fieldset>

                    <fieldset class="upload-field">
                        <label for="Image / Video Insert(optional)">Image / Video Insert <span>(optional)</span></label>
                        <input type="file" name='new-section-videocustom' tabindex="29">
                        <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field">
                        <label for="Enter YouTube URL">Enter YouTube URL</label>
                        <input type="text" name='new-section-youtubeurl' id='new-section-youtube-url' placeholder="abcd1234" maxlength="255" tabindex="30" />
                        <p class="field-eg">Eg. https://www.youtube.com/watch?v=<span>abcd1234</span></p>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="CTA Button">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name='new-section-btn-text' class="section-cta" id='new-section-btn' maxlength="20" tabindex="30" />
                        </div>
                        <div class="request-checkboxes choose-btn-color">
                            <div class="select-type">
                            <input type="hidden" name="new-btncolor" id="new-btncolor" value="0" />
                            <div class="select-box" id="new-btn-bg">
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
                             <input type="checkbox" name='new-section-btnoutbound' value="1" tabindex="31" />
                            </div>
                        </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name='new-section-btnurl' class="page-short-input" maxlength="255" tabindex="32" />
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
                         <textarea class='page-body' id='new-section-column-$i-body' name='new-section-column-content[]'></textarea>
                        </fieldset>";
                    } ?>

                </div>

            </section>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="blue-btn smooth-hover" id="submit-btn" tabindex="22" />
            </fieldset>

          </form>

        </div>
        <!-- Page Inner -->

    </section>

<dialog class="dialog error-dialog">
  <p>Must select Layout</p>
  <button class="global-btn blue-btn">OK</button>
</dialog>

<dialog class="dialog modify-pos-dialog" id="slide-pos-dialog">
    <div class="delete-inner">
        <form method="post" name="editSlidePos" id="slide-pos-form">
          <input type="hidden" name="slideid" id="slide-id" />
          <input type="hidden" name="slidepageid" id="slide-page-pos-id" />
          <input type="text" name="newslidepos" class="new-pos-box" />       
          <input type="submit" name="submitSlidePos" value="GO" class='modify-pos-btn global-btn blue-btn smooth-hover' />
          <input type="text" class='global-btn close-modify-pos' value="Cancel" id="close-slide-pos">
         </form>
         
     </div>
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

<dialog class="dialog delete-dialog delete-hero-dialog">
    <div class="delete-inner">
        <form method="post" name="deleteHero" id="del-hero-form">
          <input type="hidden" name="heroid" id="del-hero-id" />
          <input type="hidden" name="page-id" id="del-page-hero-id" />
          <input type="hidden" name="delherocat" value="<?php echo $cmscat; ?>" />       
          <input type="submit" name="delHero" value="YES" class='global-btn blue-btn smooth-hover' id="del-hero-yes-btn" tabindex="1" />
         </form>
         <button class='global-btn' id="close-del-hero">NO</button>
     </div>
</dialog>

<dialog class="dialog delete-dialog delete-section-dialog">
    <div class="delete-inner">
        <form method="post" name="deleteSection" id="del-section-form">
          <input type="hidden" name="secid" id="del-section-id" /> 
          <input type="hidden" name="pgid" id="del-page-id" />
          <input type="hidden" name="delseccat" value="<?php echo $cmscat; ?>" />       
          <input type="submit" name="delSection" value="YES" class='global-btn blue-btn smooth-hover' id="del-yes-btn" tabindex="1" />
         </form>
         <button class='global-btn' id="close-del-section">NO</button>
     </div>
</dialog>

<dialog class="dialog delete-dialog delete-img-dialog">
    <div class="delete-inner">
        <form method="post" name="deleteSecImg" id="del-section-img-form">
          <input type="hidden" name="secimgid" id="del-sec-img-id" /> 
          <input type="hidden" name="pgimgid" id="del-page-img-id" />
          <input type="hidden" name="imgname" id="del-img-name" />
          <input type="hidden" name="delsecimgcat" value="<?php echo $cmscat; ?>" />       
          <input type="submit" name="delSectionImg" value="YES" class='global-btn blue-btn smooth-hover' id="del-img-yes-btn" tabindex="1" />
         </form>
         <button class='global-btn' id="close-del-img">NO</button>
     </div>
</dialog>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script src="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js"></script>
<script>
var sectionEditors = [];
var editor = [];
$.each($('.body-field .page-body'),function(i){
  sectionEditors[i] = '#' + $(this).attr('id');
  editor[i] = new Jodit(sectionEditors[i],{});
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

/*-------- TOGGLE SLIDES ---------*/
$('.toggle-slide').click(function(e){
    var expandOne = $(this);
    if(expandOne.hasClass('fa-plus-circle')){
     expandOne.removeClass('fa-plus-circle').addClass('fa-minus-circle');
    }else{
     expandOne.removeClass('fa-minus-circle').addClass('fa-plus-circle');
    }

    var sectionPart = expandOne.closest('section').find('.hero-part');

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

/*-------- TOGGLE SECTION ---------*/
$('.toggle-section').click(function(e){
    var expandOne = $(this);
    if(expandOne.hasClass('fa-plus-circle')){
     expandOne.removeClass('fa-plus-circle').addClass('fa-minus-circle');
    }else{
     expandOne.removeClass('fa-minus-circle').addClass('fa-plus-circle');
    }

    var sectionPart = expandOne.closest('section').find('.section-part');

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
  if(goBtn.closest('.section-heading').find('#new-layout').val() == 0 && goBtn.closest('.section-heading').find('#new-colnum').val() == 0){
      dialog.showModal();
      const overlay = document.createElement('div');
      overlay.setAttribute('id', 'overlay');
      document.getElementsByTagName('main')[0].append(overlay);
  }else{
      if(goBtn.text() == 'DONE'){
          goBtn.text('CANCEL');
          $('#new-section-num').val(<?php echo $newSectionNum; ?>);
          goBtn.closest('section').find('.section-part').addClass('section-on').removeClass('section-off');
          goBtn.closest('.section-heading').find('.select-type input').each(function(i){
            if($(this).attr('id') == 'new-colnum'){
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
        $('#new-section-num').val(0);
        goBtn.closest('section').find('.section-part').addClass('section-off').removeClass('section-on');
        goBtn.closest('section').find('.columns-box').hide();
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


$( ".show-columns" ).on( "click", function(e){
  e.preventDefault();
  if($(this).text() == 'Show'){
    $(this).text('Hide');
  }else{
    $(this).text('Show');
  }
  $(this).closest('.columns-box').find('.columns-wrapper').toggle( "fast", function(){
    
  });
});

const dialog = document.querySelector(".error-dialog");
const closeButton = document.querySelector(".error-dialog button");

closeButton.addEventListener("click", () => {
  dialog.close();
  overlay.remove();
});

/*------------ Publish/Unpublish Heroes and Sections --------*/
 var cmsCat = '<?php echo $cmscat; ?>';

 $('.hero-status').click(function(e){
      e.preventDefault();
      var getId = $(this).attr('id'); 
      var id = getId.split("heroslide").pop();
      var getStatus = $(this).attr('class'); 
      getStatus = getStatus.split("hero-status ").pop();
      var status = getStatus == 'unpublish' ? 'publish' : 'unpublish';
      var capitalized = getStatus.charAt(0).toUpperCase() + getStatus.slice(1);
      $.ajax({
           type: 'GET',
           url: '/admin/cmsmodel/hero-module/'+status+'Hero?id='+id, 
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#heroslide'+id).removeClass(getStatus).addClass(status);
              $('#heroslide'+id).text(capitalized);
            }else if(result == "2"){
             alert('Hero section does not exist.');
            }else{
              alert('Something went wrong. Try again.');
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
       });
  });

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
           url: '/admin/cmsmodel/section-module/'+status+'Section?id='+id+'&cmscat='+cmsCat, 
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#statussec'+id).removeClass(getStatus).addClass(status);
              $('#statussec'+id).text(capitalized);
            }else if(result == "2"){
             alert('Product section does not exist.');
            }else{
              alert('Something went wrong. Try again.');
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
       });
  });

/*----------- Change Hero Posiion ---------*/
const slidePosDialog = document.getElementById("slide-pos-dialog");
const closeSlidePos = document.getElementById("close-slide-pos");

$('.slide-pos').click(function(e){
    e.preventDefault();
    $('#slide-pos-dialog p').remove();
    const overlay = document.createElement('div');
    overlay.setAttribute('id', 'overlay');
    document.getElementsByTagName('main')[0].append(overlay);
    var getId=$(this).attr('id');
    var id = getId.split("slide").pop();
    $('#slide-id').val(id);
    $('#slide-page-pos-id').val('<?php echo $pageId; ?>');
    var slideName = $(this).text();
    var warning = $(document.createElement('p'));
    warning.text("Enter new position number for "+slideName);
    warning.insertBefore($('#slide-id'));
    slidePosDialog.showModal();
});

$('form#slide-pos-form').submit(function(){
  var query = $('#slide-pos-form').serializeArray(); 
  $.ajax({
     type: 'POST',
     url: '/admin/cmsmodel/hero-module/editSlidePos',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/cmsmodel/page-module/pageWithSlides?pkid=<?php echo $pageId.'&category='.$cmscat.'&page='.$page.$Parameter; ?>";
         }else if(result == "2"){
            alert('Slide not found.');
         }else if(result == "3"){
            alert('Slide Position could not be changed.');
         }else if(result == "4"){
            alert('Other slides could not be updated. Try again.');
         }else if(result == "5"){
            alert('Slide position update failed. Try again.');
         }else if(result == "6"){
           alert('Position number you entered is either 0 or bigger than number of slides.');
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

closeSlidePos.addEventListener("click", () => {
  slidePosDialog.close();
  overlay.remove();
});

/*----------- Change Section Position ---------*/
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
    $('#section-page-pos-id').val('<?php echo $pageId; ?>');
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
     url: '/admin/cmsmodel/section-module/editSectionPos',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/cmsmodel/page-module/pageWithSlides?pkid=<?php echo $pageId.'&category='.$cmscat.'&page='.$page.$Parameter; ?>";
         }else if(result == "2"){
            alert('Section not found.');
         }else if(result == "3"){
            alert('Section Position could not be changed.');
         }else if(result == "4"){
            alert('Other sections could not be updated. Try again.');
         }else if(result == "5"){
            alert('Section position update failed. Try again.');
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


/*----------- Delete Hero, Section and Section Images ----------*/

const delHeroDialog = document.querySelector(".delete-hero-dialog");
const closeHeroDelete = document.getElementById("close-del-hero");

$('.delete-hero').click(function(e){
    e.preventDefault();
    $('.delete-hero-dialog p').remove();
    const overlay = document.createElement('div');
    overlay.setAttribute('id', 'overlay');
    document.getElementsByTagName('main')[0].append(overlay);
    var getId=$(this).attr('id');
    var id = getId.split("deletehero").pop();
    $('#del-hero-id').val(id);
    $('#del-page-hero-id').val('<?php echo $pageId; ?>');
    var heroName = $(this).closest('.section-heading').find('h3').text();
    var warning = $(document.createElement('p'));
    warning.text("Are you sure you want to delete "+heroName);
    warning.insertBefore($('.delete-hero-dialog .delete-inner'));
    delHeroDialog.showModal();
});

$('form#del-hero-form').submit(function(){
  var query = $('#del-hero-form').serializeArray(); 
  $.ajax({
     type: 'POST',
     url: '/admin/cmsmodel/hero-module/deleteHero',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/cmsmodel/page-module/pageWithSlides?pkid=<?php echo $pageId.'&category='.$cmscat.'&page='.$page.$Parameter; ?>";
         }else if(result == "2"){
            alert('Hero not found.');
         }else if(result == "3"){
            alert('Delete Hero failed.');
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

closeHeroDelete.addEventListener("click", () => {
  delHeroDialog.close();
  overlay.remove();
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
    $('#del-page-id').val(<?php echo $pageId; ?>);
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
     url: '/admin/cmsmodel/section-module/deleteSection',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/cmsmodel/page-module/pageWithSlides?pkid=<?php echo $pageId.'&category='.$cmscat.'&page='.$page.$Parameter; ?>";
         }else if(result == "2"){
            alert('Section not found.');
         }else if(result == "3"){
            alert('Delete section button failed.');
         }else if(result == "4"){
            alert('Delete section column failed.');
         }else if(result == "5"){
            alert('Delete Section failed.');
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

const delImgDialog = document.querySelector(".delete-img-dialog");
const closeImgDelete = document.getElementById("close-del-img");

$('.del-bg-img').click(function(e){
    e.preventDefault();
    var getId=$(this).attr('id');
    var id=getId.split("-").pop();
    $('.delete-img-dialog p').remove();
    const overlay = document.createElement('div');
    overlay.setAttribute('id', 'overlay');
    document.getElementsByTagName('main')[0].append(overlay);
    if($(this).hasClass('del-bg-img')){
      $('#del-img-name').val('secbgimg'); 
    }
    if($(this).hasClass('del-mob-img')){
       $('#del-img-name').val('secmobimg');
    }
    if($(this).hasClass('del-vid-img')){
       $('#del-img-name').val('secvidimg');
    }
    $('#del-sec-img-id').val(id);
    $('#del-page-img-id').val(<?php echo $pageId; ?>);
    var sectionName = $(this).closest('.page-section').find('.section-pos').text();
    var warning = $(document.createElement('p'));
    warning.text("Are you sure you want to delete "+sectionName+" Image?");
    warning.insertBefore($('.delete-img-dialog .delete-inner'));
    delImgDialog.showModal();
});

$('form#del-section-img-form').submit(function(){
  var query = $('#del-section-img-form').serializeArray();
  $.ajax({
     type: 'POST',
     url: '/admin/cmsmodel/section-module/delSectionBgImg',
     data: query,
     async : false,
       success: function(res){
        var res = res.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(res == "1"){
          location.href="/admin/cmsmodel/page-module/pageWithSlides?pkid=<?php echo $pageId.'&category='.$cmscat.'&page='.$page.$Parameter; ?>";
         }else if(res == "2"){
           alert('Section not found.');
         }else if(res == "3"){
           alert('Update section failed.');
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

closeImgDelete.addEventListener("click", () => {
  delImgDialog.close();
  overlay.remove();
});
</script>
</script>
</body>
</html>
