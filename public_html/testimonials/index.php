<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$paginUrl = "/testimonials";
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "clear-header";
$PageName = "Testimonials";
$PageTitle = 'Customer Testimonials | CDI Labs';
$metaDesc = 'CDI Labs Testimonials.';
$PageUrl = 'testimonials/';
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'testimonials'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$sql = "SELECT * FROM testimonials WHERE status = 1 ORDER BY company ASC";
$page = $webhelper->RequestFilter("page", 0, false);
if($webhelper->isNull($page)) $page = 1;
$PageSize = 7;
$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
if(count($List) == 0){
    header('Location: /');
    exit;
}
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$keyword = false;
$keyword = isset($_GET['page']) || isset($input) ? true : false;
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<?php if($keyword){ 
   $PageTitle = 'Customer Testimonials - Page '.$page.' | CDI Labs';
   $metaDesc = 'CDI Labs Testimonials - Page '.$page;
   $PageUrl = 'testimonials?page='.$page.$Parameter;
   echo "<title>$PageTitle</title>";
   echo "<meta name='description' content='$metaDesc' />";
   echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}else{
  echo "<title>$PageTitle</title>";
  echo "<meta name='description' content='$metaDesc' />";
  echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); 
?>
<style>
.hero-section{background-repeat:no-repeat;background-position:left top;background-size:cover}
 <?php 
 if(!empty($hero["desktop"]) && $ext != 'mp4'){
  $desktopImg = $hero["desktop"];
  echo "
    .hero-section{background-image: url('/files/hero/$desktopImg');}";
 }
 if(!empty($hero["mobile"])){
  $mobileImg = $hero["mobile"];
 echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/hero/$mobileImg');}";
  }
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">
   <section class="hero-section short-hero" id="testimonials-hero">
        <div class="page-inner">
          <section class="left-hero-content">
              <p class="subheading">CDI Labs</p>
			  <h1>Customer Testimonials</h1>
          </section>  
        </div>
   </section>
   <section class="wide-section" id="testimonials-section">
   	 <?php
   	 if(!empty($List) && count($List) > 0){
         foreach($List as $row){
             echo "<section>
                    <div class='page-inner card-layout card2-wrapper'>
                        <div class='col'>
                            <a href='{$row['slugurl']}' class='company-thumb' target='_blank'><img src='/files/testimonials/{$row['thumbnail']}' /></a>
                        </div>
                        <div class='col'>
                             <h3>{$row['quote']}</h3>
                             <ul class='left'>
                                <li>{$row['customer']}</li>
                                <li>{$row['job_title']}</li>
                             </ul>
                        </div>
                    </div>
                  </section>";

         }
	 }
     ?>
    </section>
    <section class="wide-section" id="pagination-section">
        <div class="page-inner">
             <div class="center-paragraph">
              <?php if(!empty($List)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>
            </div>
        </div>
    </section>
</main>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>

