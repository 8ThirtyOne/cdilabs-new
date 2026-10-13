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
      $PageUrl = "/admin/services/modifyForm";
      $PageCode = "000000";
      $bodyid = "services";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter('pkid', 0, false);   
        $exists = $dbhelper->numOfRows('SELECT slugurl FROM web_page WHERE pkid = ?', 'i', $pkid);
        if($exists > 0){
          $page = $webhelper->RequestFilter("page", 0, false);
          $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
          $order = $webhelper->RequestFilter("order", 0, false);
          $Parameter = "&searchKey=$searchKey&order=$order";
          $ViewPage = $dbhelper->RunSQLReturnOneRow("SELECT * FROM web_page WHERE pkid = $pkid");
          $ViewHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM web_page_hero WHERE page_id = $pkid");
          $pageSection = $dbhelper->selectAll("SELECT * FROM web_page_section WHERE page_id = $pkid ORDER BY position ASC");
        }else{
         header('Location: /admin/services/list');
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
<title>Modify Service Page | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
<style>
    #module-data .upload-field div input{margin-top:15px}
    #module-data .upload-field div input{width:92px}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main>
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="module-section">

            <h2>Modify Service Page</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/services/modifyPage" id="module-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewPage["pkid"]; ?>" />
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
                        <label for="slugurl">Slug Url<span>*</span><span class="hint"> (Only letters, numbers and hyphens allowed)</span></label>
                        <input type="text" name="slugurl" id="slugurl" class="get-value page-short-input" pattern="[a-zA-Z0-9\-\s]+" title="Only letters, numbers and hyphens are allowed." value="<?php echo $ViewPage['slugurl']; ?>" maxlength="200" tabindex="2" />
                    </fieldset>

                    <fieldset>
                     <label for="Description">Page Meta Description<span>*</span></label>
                       <textarea name="pagedesc" id="page-desc" class="meta-desc get-value" rows="1" cols="1" minlength="10" maxlength="250" tabindex="3"><?php echo $ViewPage['description']; ?></textarea>
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
                    echo "<input type='hidden' name='herolayout' id='hero-layout' value='$heroAlign' />"; 
                    echo "<div class='select-box' id='select-hero-layout'>";
                         echo "<ul>"; 
                              if($heroAlign != 'none'){
                                 echo "<li><a href='#$heroAlign' class='current choice'>$heroAlign<i class='fa fa-caret-down'></i></a></li>";
                                 foreach($heroLayouts as $lRow){
                                   if($heroAlign != $lRow){
                                      echo "<li><a href='#$lRow' class='smooth-hover choice'>$lRow<i class='fa fa-caret-down'></i></i></a></li>";
                                   }
                                 }
                               }else{
                                  echo "<li><a href='#0' class='current choice'>Choose Color<i class='fa fa-caret-down'></i></a></li>";
                                  foreach($heroLayouts as $lRow){
                                    echo "<li><a href='#$lRow' class='smooth-hover choice'>$lRow<i class='fa fa-caret-down'></i></i></a></li>";
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
                        <label for="Desktop Hero">Desktop<span>*</span></label>
                        <?php
                          if(!empty($ViewHero["desktop"])) $ext = pathinfo($ViewHero["desktop"], PATHINFO_EXTENSION);
                          if($ext == 'mp4'){
                             echo "<div>";
                             echo "<p>".$ViewHero["orgfilename"]."</p>";
                             echo "<input type='file' name='herodesktop' tabindex='4'>
                             <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>";
                             echo "</div>";
                           }
                           if(!empty($ViewHero["desktop"]) && $ext != 'mp4'){
                            echo "<div>";
                             echo "<img src=\"/files/hero/services/" . $ViewHero["desktop"] . "\">";
                             echo "<input type='file' name='herodesktop' tabindex='4'>
                             <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>";
                             echo "</div>";
                           }
                        ?>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Hero">Mobile<span>*</span></label>
                        <?php
                          if(!empty($ViewHero["mobile"])){
                             echo "<div>";
                             echo "<img src=\"/files/hero/services/" . $ViewHero["mobile"] . "\">";
                             echo "<input type='file' name='heromobile' tabindex='5'>
                             <p>Accepted file types: <span>jpg, png, gif</span></p>";
                             echo "</div>";
                           }
                        ?>
                    </fieldset>

                    <fieldset>
                        <label for="hero-subtitle">Subtitle</label>
                        <input type="text" name="herosubtitle" id="hero-subtitle" class="page-short-input" value="<?php echo $ViewHero['subheading']; ?>"  maxlength="60" tabindex="6" />
                    </fieldset>

                    <fieldset>
                        <label for="hero-title">Main Title</label>
                        <input type="text" name="herotitle" id="hero-title" class="page-short-input" value="<?php echo $ViewHero['heading']; ?>" maxlength="200" tabindex="7" />
                    </fieldset>

                    <fieldset id="hero-para-field">
                     <label for="hero paragraph">Paragraph</label>
                     <textarea id="hero-body" name="heroparagraph" tabindex="8"><?php echo $ViewHero['paragraph']; ?></textarea>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="section-cta">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name="herosectionbtn" class="section-cta" id="hero-section-cta" value="<?php echo $ViewHero['btn_text']; ?>" maxlength="20" tabindex="16" />
                        </div>
                        <div class="request-checkboxes">
                            <?php  
                              $heroTarget = $ViewHero["btn_target"] == 1 ? "checked='checked'" : '';?>
                            <div>
                             <label for="Outbound Link?">Outbound Link?</label>
                             <input type="checkbox" name="hero-outbound" value="1" <?php echo $heroTarget; ?> tabindex="1" />
                            </div>
                        </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name="herotargeturl" class="page-short-input" value="<?php echo $ViewHero['btn_url']; ?>"maxlength="255" tabindex="17" />
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
               $sectionClass = $section['class_name'];
               $sectionIdName = $section['id_name'];
               $sectionDesktop = $section['bgimg'];
               $sectionMobile = $section['bgMobileImg'];
               $section['heading'] == 'none' ? $sectionHeading = '' : $sectionHeading = $section['heading'];
               $section['subheading'] == 'none' ? $sectionSubheading = '' : $sectionSubheading = $section['subheading'];
               $section['section_paragraph'] == 'none' ? $sectionPara = '' : $sectionPara = $section['section_paragraph'];
               $section['section_body'] == 'none' ? $sectionBody = '' : $sectionBody = $section['section_body'];
               $section['ytvideo'] == 'none' ? $ytVideo = '' : $ytVideo = $section['ytvideo'];
               if($section["status"] == 1){
                 $status = "Unpublish";
                 $statusClass="publish";
                }else{
                 $status = "Publish"; 
                 $statusClass="unpublish";
                }

               echo "<section class='page-section $sectionClass' id='$sectionIdName'>
                  <input name='section[]' value='$sectionId' type='hidden' />";
               echo "<div class='section-heading tall-heading'>
                    <h3>SECTION $sectionNum</h3>";
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
                        <li id='statussec$sectionId' class='global-btn clear-btn smooth-hover status $statusClass'>$status</li>
                        <li class='toggle-section fa fa-minus-circle'></li>
                         </ul>";
                   echo "</div>";
                ?>

                <div class='section-part section-on main-column'>

                    <fieldset class='upload-field img-upload'>
                      <label for='Desktop Hero'>Desktop Background Image</label>
                      <?php
                      echo "<input type='hidden' name='section-$sectionNum-oldBgImg' value='$sectionDesktop' />";
                      if($sectionDesktop != 'none'){
                         echo "<div>
                         <img src=/files/services/$sectionDesktop />
                         <input type='file' name='section-$sectionNum-bgimg'>
                         <p>Accepted file types: <span>jpg, png, gif</span></p>
                         <h5 id='secbgimg-$sectionId' class='del-bg-img'>Delete</h5>
                         </div>";
                       }else{
                         echo "
                         <input type='file' name='section-$sectionNum-bgimg'>
                         <p>Accepted file types: <span>jpg, png, gif</span></p>";
                       }
                      ?>
                    </fieldset>

                    <fieldset class='upload-field img-upload'>
                        <label for='Mobile Hero'>Mobile Background Image</label>
                        <?php
                          echo "<input type='hidden' name='section-$sectionNum-oldBgMobile' value='$sectionMobile' />";
                          if($sectionMobile != 'none'){
                             echo "<div>
                             <img src=/files/services/$sectionMobile />
                             <input type='file' name='section-$sectionNum-bgmobile'>
                             <p>Accepted file types: <span>jpg, png, gif</span></p>
                             <h5 id='secmobimg-$sectionId' class='del-bg-img del-mob-img'>Delete</h5>
                             </div>";
                           }else{
                             echo "
                             <input type='file' name='section-$sectionNum-bgmobile'>
                             <p>Accepted file types: <span>jpg, png, gif</span></p>";
                           }
                        ?>
                    </fieldset>

                    <fieldset>
                        <label for='Main Heading'>Main Heading</label>
                        <?php echo "<input type='text' value='$sectionHeading' name='section-$sectionNum-heading' id='section-$sectionNum-heading' maxlength='200' tabindex='11' />"; ?>
                    </fieldset>

                    <fieldset>
                        <label for='Subheading'>Subheading</label>
                        <?php echo "<input type='text' name='section-$sectionNum-subheading' id='section-$sectionNum-subheading' value='$sectionSubheading' maxlength='500' tabindex='12' />"; ?>
                    </fieldset>

                    <fieldset class='body-field'>
                     <label for='Page Paragraph'>Page Paragraph</label>
                     <?php echo"<textarea id='section-$sectionNum-para' class='page-body' name='section-$sectionNum-paragraph' tabindex='13'>$sectionPara</textarea>"; ?>
                    </fieldset>

                    <fieldset class='body-field'>
                     <label for='Page Body'>Page Body <span class="hint">(ADD CODE HERE) <?php echo 'services-'.$ViewPage['pkid'].'-section-'.$sectionId; ?></span></label>
                     <?php echo"<textarea id='section-$sectionNum-body' class='page-body' name='section-$sectionNum-body' tabindex='13'>$sectionBody</textarea>"; ?>
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
                             <input type='file' name='section-$sectionNum-videocustom' tabindex='14'>
                             <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                             <h5 id='secvidimg-$sectionId' class='del-bg-img del-vid-img'>Delete</h5>
                             </div>";
                           }else{
                             echo "<div>
                             <img src=/files/services/$sectionVideoCustom />
                             <input type='file' name='section-$sectionNum-videocustom' tabindex='14'>
                             <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                             <h5 id='secvidimg-$sectionId' class='del-bg-img del-vid-img'>Delete</h5>
                             </div>";
                           }
                        }else{
                        echo "<input type='file' name='section-$sectionNum-videocustom' tabindex='14'>
                            <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>";
                        }
                        ?>
                    </fieldset>

                    <fieldset class='upload-field'>
                        <label for='YouTube Video Id'>Enter YouTube URL</label>
                        <?php 
                        echo "<input type='text' name='section-$sectionNum-youtubeurl' id='section-$sectionNum-youtube-url' value='$ytVideo' maxlength='50' tabindex='15' />"; ?>
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
                                <?php echo "<input type='text' name='section-$sectionNum-btn-text-$btnId' class='section-cta' id='section-$sectionNum-btn-text-$btnId' value='$btnText' maxlength='20' tabindex='16' />"; ?>
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
                                 <?php echo"<input type='checkbox' name='section-$sectionNum-outbound-$btnId' value='1' $btnTarget tabindex='1' />"; ?>
                                </div>
                            </div>
                            <div>
                                <p>Target URL</p>
                                <?php echo "<input type='text' name='section-$sectionNum-btnurl-$btnId' class='page-short-input' value='$btnUrl' maxlength='255' tabindex='17' />"; ?>
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
                            $colBody = empty($sColumn['body']) ? '' : $sColumn['body'];
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
                            <li><a href="#0" class="current choice">Select Layout<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#left" class="smooth-hover choice">Left<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#center" class="smooth-hover choice">Center<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#right" class="smooth-hover choice">Right<i class="fa fa-caret-down"></i></a></li>
                          </ul>
                        </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="new-bgcolor" id="new-bgcolor" value="0" />
                        <div class="select-box" id="new-section-bg">
                          <ul>
                            <li><a href="#0" class="current choice">Select Background Color<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#white" class="smooth-hover choice">White<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#blue" class="smooth-hover choice">Blue<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#dark-blue" class="smooth-hover choice">Dark Blue<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#black" class="smooth-hover choice">Black<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#gray" class="smooth-hover choice">Gray<i class="fa fa-caret-down"></i></a></li>
                          </ul>
                        </div>
                    </div>

                    <div class="select-type">
                        <input type="hidden" name="new-colnum" id="new-colnum" value="0" />
                        <div class="select-box" id="new-section-cols">
                         <ul>
                            <li><a href="#0" class="current choice">Select # of columns<i class="fa fa-caret-down"></i></a></li>
                            <li><a href="#2" class="smooth-hover choice">2 columns<i class="fa fa-caret-down"></i></a></li>
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
                        <input type="file" name='new-section-bgimg' tabindex="19">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field img-upload">
                        <label for="Mobile Background Image">Mobile Background Image</label>
                        <input type="file" name='new-section-bgmobile' tabindex="20">
                        <p>Accepted file types: <span>jpg, png, gif</span></p>
                    </fieldset>

                    <fieldset>
                        <label for="Main Heading">Main Heading</label>
                        <input type="text" name='new-section-heading' id="new-section-heading" maxlength="200" tabindex="21" />
                    </fieldset>

                    <fieldset>
                        <label for="Subheading">Subheading</label>
                        <input type="text" name='new-section-subheading' id='new-section-subheading' maxlength="500" tabindex="22" />
                    </fieldset>

                    <fieldset class="body-field">
                     <label for="Page Paragraph">Page Paragraph</label>
                     <textarea class='page-body' id="new-section-para" name="new-section-paragraph"></textarea>
                    </fieldset>

                    <fieldset class="body-field">
                     <label for="Page Body">Page Body</label>
                     <textarea class='page-body' id='new-section-body' name="new-section-body"></textarea>
                    </fieldset>

                    <fieldset class="upload-field">
                        <label for="Image / Video Insert(optional)">Image / Video Insert <span>(optional)</span></label>
                        <input type="file" name='new-section-videocustom' tabindex="24">
                        <p>Accepted file types: <span>mp4, mov, jpg, gif</span></p>
                    </fieldset>

                    <fieldset class="upload-field">
                        <label for="Enter YouTube URL">Enter YouTube URL</label>
                        <input type="text" name='new-section-youtubeurl' id='new-section-youtube-url' placeholder="abcd1234" maxlength="255" tabindex="25" />
                        <p class="field-eg">Eg. https://www.youtube.com/watch?v=<span>abcd1234</span></p>
                    </fieldset>

                    <fieldset class="cta-fieldset">
                        <div>
                            <label for="CTA Button">CTA Button</label>
                            <p>Max characters 20</p>
                            <input type="text" name='new-section-btn-text' class="section-cta" id='new-section-btn' maxlength="20" tabindex="26" />
                        </div>
                        <div class="request-checkboxes choose-btn-color">
                            <div class="select-type">
                            <input type="hidden" name="new-btncolor" id="new-btncolor" value="0" />
                            <div class="select-box" id="new-btn-bg">
                              <ul>
                                <li><a href="#0" class="current choice">Choose Color<i class="fa fa-caret-down"></i></a></li>
                                <li><a href="#blue-btn" class="smooth-hover choice">Blue<i class="fa fa-caret-down"></i></a></li>
                                <li><a href="#global-btn" class="smooth-hover choice">Transparent<i class="fa fa-caret-down"></i></a></li>
                              </ul>
                            </div>
                        </div>
                        </div>
                        <div class="request-checkboxes">
                            <div>
                             <label for="Outbound Link?">Outbound Link?</label>
                             <input type="checkbox" name='new-section-btnoutbound' value="1" tabindex="27" />
                            </div>
                        </div>
                        <div>
                            <p>Target URL</p>
                            <input type="text" name='new-section-btnurl' class="page-short-input" maxlength="255" tabindex="28" />
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

<dialog class="dialog delete-dialog delete-section-dialog">
    <div id="delete-inner">
        <form method="post" name="deleteSection" id="del-section-form">
          <input type="hidden" name="secid" id="del-section-id" /> 
          <input type="hidden" name="pgid" id="del-page-id" />       
          <input type="submit" name="delSection" value="YES" class='global-btn blue-btn smooth-hover' id="del-yes-btn" tabindex="1" />
         </form>
         <button class='global-btn' id="close-del-section">NO</button>
     </div>
</dialog>

<dialog class="dialog delete-dialog delete-img-dialog">
    <div id="delete-inner">
        <form method="post" name="deleteSecImg" id="del-section-img-form">
          <input type="hidden" name="secimgid" id="del-sec-img-id" /> 
          <input type="hidden" name="pgimgid" id="del-page-img-id" />
          <input type="hidden" name="imgname" id="del-img-name" />      
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
var heroEditor = Jodit.make('#hero-body');
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

const dialog = document.querySelector("dialog");
const showButton = document.querySelector("dialog + button");
const closeButton = document.querySelector("dialog button");

closeButton.addEventListener("click", () => {
  dialog.close();
  overlay.remove();
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
           url: '/admin/services/'+status+'Section?id='+id, 
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#statussec'+id).removeClass(getStatus).addClass(status);
              $('#statussec'+id).text(capitalized);
            }else if(result == "2"){
             alert('Service section does not exist.');
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
    warning.insertBefore($('.delete-section-dialog #delete-inner'));
    delDialog.showModal();
});

$('form#del-section-form').submit(function(){
  var query = $('#del-section-form').serializeArray(); 
  $.ajax({
     type: 'POST',
     url: '/admin/services/deleteSection',
     data: query,
     async : false,
       success: function(result){
        result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(result == "1"){
            location.href="/admin/services/modifyForm?pkid=<?php echo $pkid.'&page='.$page.$Parameter; ?>";
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
    $('#del-page-img-id').val(<?php echo $pkid; ?>);
    var sectionName = $(this).closest('.page-section').find('h3').text();
    var warning = $(document.createElement('p'));
    warning.text("Are you sure you want to delete "+sectionName+" Image?");
    warning.insertBefore($('.delete-img-dialog #delete-inner'));
    delImgDialog.showModal();
});

$('form#del-section-img-form').submit(function(){
  var query = $('#del-section-img-form').serializeArray();
  $.ajax({
     type: 'POST',
     url: '/admin/services/delSectionBgImg',
     data: query,
     async : false,
       success: function(res){
        var res = res.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
        if(res == "1"){
          location.href="/admin/services/modifyForm?pkid=<?php echo $pkid.'&page='.$page.$Parameter; ?>";
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
