<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$paginUrl = "/resources/videos";
$PageCode = "040102";
$bodyid = "resources";
$bodyClass= "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'videos'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
if(isset($_GET['category']) && !empty($_GET['category'])){
    $input = trim($_GET['category']);
    $catId = 0;
    switch($input){
        case 'technology':
            $catTitle = 'Technology';
            $catId = 1;
            break;
        case 'webinars':
            $catTitle = 'Webinars';
            $catId = 2;
            break;
        case 'events':
            $catTitle = 'Events';
            $catId = 3;
            break;
        case 'others':
            $catTitle = 'Others';
            $catId = 4;
            break;
    }
    if(is_int($catId) && $catId > 0){
        $sql = "SELECT * FROM videos WHERE type = $catId AND status = 1 ";  
        $sql .= "ORDER BY updated DESC";
    }else{
        header('Location: /404');
        exit;
    }
}else{
    $sql = "SELECT * FROM videos WHERE status = 1 ";  
    $sql .= "ORDER BY updated DESC";
    $catTitle = "ALL";
}
$page = $webhelper->RequestFilter("page", 0, false);
$category = $webhelper->RequestFilter("category", 20, false);
if($webhelper->isNull($page)) $page = 1;
if(!isset($input)){
    $Parameter = "";
}else{
    $Parameter = "&category=$category";
}
$PageSize = 10;
$videos = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$PageTitle = 'Videos and Webinars | CDI Labs';
$metaDesc = 'CDI Labs Videos';
$PageUrl = 'resources/videos/';
$keyword = false;
$keyword = isset($_GET['page']) || isset($input) ? true : false;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<?php
if(!$keyword){
    echo "<title>$PageTitle</title>
    <meta name='description' content='$metaDesc' />
    <link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
} 
if($keyword){
       $PageTitle = 'Videos and Webinars - Page '.$page.' of '.$catTitle.' | CDI Labs';
       $metaDesc = 'CDI Videos and Webinars - Page '.$page.' of '.$catTitle;
       $PageUrl = 'resources/videos/?page='.$page.$Parameter;
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
 
   <section class="hero-section short-hero" id="videos-hero">

    <div class="page-inner">

        <section class="left-hero-content white-text">
              <h1>Videos and Webinars</h1>
              <h3>View our latest videos and webinars</h3>
          </section>
 
    </section>

    <section class="wide-section no-margin related-resources" id="videos-section">

        <div class="narrow-content docs-nav-wrapper">

            <ul id="videos-nav" class="docs-nav">
                <li><a href="/resources/videos" data-news="all" class="smooth-hover">ALL</a></li>
                <li>|</li>
                <li><a href="/resources/videos?page=<?php echo $page; ?>&category=technology" data-news="technology" class="smooth-hover">Technology</a></li>
                <li>|</li>
                <li><a href="/resources/videos?page=<?php echo $page; ?>&category=webinars" data-news="webinars" class="smooth-hover">Webinars</a></li>
                <li>|</li>
                <li><a href="/resources/videos?page=<?php echo $page; ?>&category=events" data-news="events" class="smooth-hover">Events</a></li>
                <li>|</li>
                <li><a href="/resources/videos?page=<?php echo $page; ?>&category=others" data-news="others" class="smooth-hover">Tutorials</a></li>
            </ul>

        </div>

            <?php 
                if(!empty($videos) && count($videos) > 0){
                   $total = count($videos);
                   $catTitle = strtoupper($catTitle);
                   echo "<h3>$catTitle</h3>
                   <div class='page-inner card-layout narrow-content card3-wrapper docs-wrapper'>";
                   foreach($videos as $row){
                    $slugurl = $row['type'] == 2 ? '/resources/webinar/'.$row["slugurl"] : '/resources/videos/'.$row["slugurl"];
                    $fullAbstract = $row["body"];
                    $shortAbstract = $webhelper->CurRightString($fullAbstract, "150");
                    $abstractLength = strlen($fullAbstract);
                    if($abstractLength > 150){
                       $endOfAbstract = strrpos($shortAbstract,' ');
                       $abstract = substr($shortAbstract,0,$endOfAbstract).'...';
                    }else{
                       $abstract = $fullAbstract;
                    }
            ?>

            <div class="video-box">

                <div class="video-thmb">
                    <a href="<?php echo $slugurl; ?>">
                      <img src="/files/videos/<?php echo $row["thumbnail"]?>" alt="<?php echo $row["title"]; ?>" />
                    </a>
                </div>
                     
                <div class="video-info">

                    <p class="video-title smooth-hover"><?php echo $row["title"]; ?></p>
                    <p class="video-body"><?php echo $abstract; ?></p>
                    <a href="<?php echo $slugurl; ?>" class="global-btn blue-btn smooth-hover">WATCH VIDEO</a>

                </div>

            </div>

            <?php }
               }else{ 
                 echo "<div class='page-inner narrow-section'>

                     <div class='center-paragraph'>

                         <h3>There are no $catTitle currently available.</h3>

                     </div>

                    </div>";

                }

            ?>

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
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
    let cat = '<?php echo $catTitle; ?>';
    cat = cat.toLowerCase();

    document.querySelectorAll('#videos-nav a').forEach((links) => { 
      if(links.getAttribute('data-news') == cat) links.classList.add('current');
    });
</script>
</body>
</html>
