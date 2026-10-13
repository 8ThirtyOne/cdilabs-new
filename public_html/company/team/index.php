<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageName = $pageInfo['title'];
$PageTitle = 'Meet CDI Labs | CDI Labs';
$metaDesc = 'Learn more about our amazing CDI Labs team members.';
$PageUrl = "company/team/";
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'team'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$sql = "SELECT * FROM employee_page WHERE status = 1 ORDER BY last_name";
$page = $webhelper->RequestFilter("page", 0, false);
if($webhelper->isNull($page)) $page = 1;
$PageSize = 10;
$team = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$paginUrl = '/company/team/';
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Meet CDI Labs | CDI Labs</title>
<meta name="description" content="Learn more about our amazing CDI Labs team members." />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/company/team/" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
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
 
   <section class="hero-section short-hero" id="team-hero">

    <div class="page-inner">

        <section class="left-hero-content white-text">
              <h1>Meet CDI Labs</h1>
              <p>Learn about our remarkable team and see why CDI Labs is an exceptional environment where employees thrive and flourish.</p>
          </section>
 
    </section>

    <section class="wide-section no-margin" id="team-section">

        <div class="page-inner narrow-section">

            <div class="center-paragraph">

               <h2>Meet the People at CDI Labs</h2>
               <p>We are incredibly fortunate to boast a team of brilliant and dedicated individuals whose contributions truly make our company an exceptional workplace. Through our "Meet CDI Labs" series, you'll have the opportunity to personally connect with some of these remarkable individuals, gaining deeper insights into our collective identity and ethos.</p>

            </div>

            <div id="team-list">

                <?php if(!empty($team) && count($team) > 0){

                echo "<div class='card-layout card4-wrapper'>";

                foreach($team as $row){

                  echo "<div class='column-box'>

                            <div class='team-thmb'>

                                <a href='{$row['slugurl']}'><img src='/files/team/{$row['mobile_img']}' alt='{$row['first_name']} {$row['last_name']}' />
                                </a>
                            </div>
                     
                            <div class='team-info'>

                                <p class='team-name smooth-hover'>{$row['first_name']} {$row['last_name']}</p>
                                <p class='team-position'>{$row['job_pos']}</p>
                                <p class='team-location'>{$row['job_loc']}</p>

                            </div>

                        </div>";
 
                  }

              } ?>

            </div>

         </div>

    </section>

    <section class="wide-section">
 
            <div class="page-inner">

                 <div class="center-paragraph">

                  <?php if(!empty($videos)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>

                </div>

            </div>

    </section>
           
</main>
 
<?php 
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); 
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>
</body>
</html>
