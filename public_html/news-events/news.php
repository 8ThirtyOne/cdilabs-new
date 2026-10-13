<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageCode = "030102";
$paginUrl = "/news-events/news";
$bodyid = "news";
$bodyClass= "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'news'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
if(isset($_GET['category']) && !empty($_GET['category'])){
    $input = trim($_GET['category']);
    $typeId = $input == 'news' ? 1 : 2; //Change this if more than 2 categories
    $catExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE type = ?', 'i', $typeId);
    if($catExists > 0){
        $sql = "SELECT * FROM articles WHERE type = '$typeId' AND status = 1 ";  
        $sql .= "ORDER BY year desc, month desc, day desc";
        $catTitle = $typeId == 1 ? 'News' : 'Press Releases';
    }else{
        header('Location: /news-events/news');
        exit;
    }
}else{
    $sql = "SELECT * FROM articles WHERE status = 1 ";  
    $sql .= "ORDER BY year desc, month desc, day desc";
    $catTitle = 'All';
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
$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$PageTitle = 'News and Press Releases | CDI Labs';
$metaDesc = 'CDI Labs news, articles, and press releases. Discover the latest articles about our company, our products, our policies, and our people.';
$PageUrl = 'news-events/news';
$keyword = false;
$keyword = isset($_GET['page']) || isset($input) ? true : false;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<?php 
if(!$keyword){
    echo "<title>$PageTitle</title>
    <meta name='description' content='$metaDesc' />
    <link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
} 
if($keyword){
       $PageTitle = 'News and Press Releases - Page '.$page.' of '.$catTitle.' | CDI Labs';
       $metaDesc = 'CDI Labs News and Press Releases - Page '.$page.' of '.$catTitle;
       $PageUrl = 'news-events/news?page='.$page.$Parameter;
       echo "<title>$PageTitle</title>";
       echo "<meta name='description' content='$metaDesc' />";
       echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}
      include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php');
?>  
<style>
  .hero-section{
    background-repeat:no-repeat;
    background-position:left top;
  }
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
 
   <section class="hero-section short-hero" id="news-hero">

    <div class="page-inner">

      <section class="left-hero-content white-text">
          <h1>In the News</h1>
          <h3>Read the latest news and articles featuring CDI Labs</h3>
      </section>
 
    </section>
 
    <section class="wide-section section-with-sidebar news-section">

        <div class="page-inner">

            <div id="left-sidebar">

                <ul id="news-nav" class="docs-nav">
                    <li><a href="/news-events/news" data-news="all" class="smooth-hover">ALL</a></li>
                    <li>|</li>
                    <li><a href="/news-events/news?page=<?php echo $page; ?>&category=news" data-news="news" class="smooth-hover">News</a></li>
                    <li>|</li>
                    <li><a href="/news-events/news?page=<?php echo $page; ?>&category=press" data-news="press" class="smooth-hover">Press Releases</a></li>
                </ul>

                <?php echo "<h4>".strtoupper($catTitle)."</h4>"; ?>

                <?php 
                 if($List != null && count($List) > 0){
                    foreach ($List as $row){ 
                      $type = $row['type'];
                      if($type == 1){
                        $category = 'News';
                        $url = $row['filename'] == 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/news-events/" . $row['slugurl'] . "'";
                        $titleUrl = $url;
                      }
                      if($type == 2){
                        $category = 'Press Release';
                          $url = "href='/news-events/" . $row['slugurl'] . "'";
                          $titleUrl = $url;
                      }
                      $day = ltrim($row['day'],'0');
                      $subtitle = $webhelper->CurRightString($row["subtitle"], "400");
                      $getDate = $row['day'].' '.$webhelper->GetMonthName($row["month"]).' '.$row['year'];
                 ?>
                 <div class="news-box no-margin">

                    <div class="page-inner narrow-section">

                       <div class="news-list">
                             
                          <article class="news-article">

                             <ul>
                                 <li><?php echo $category; ?></li>
                                 <li>|</li>
                                 <li><?php echo $webhelper->GetFullWeekName($getDate).', '.$webhelper->GetMonthShortName($row["month"]).' '.$day.' '.$row["year"]; ?></li>
                             </ul>  
                             <p class="news-source">SOURCE: <?php echo $row["source"]; ?></p>
                             <a class="news-title smooth-hover" <?php echo $titleUrl; ?>><?php echo $row["title"]; ?></a>
                             <?php if($subtitle != 'none') echo "<p class='news-text'>".$subtitle."</p>"; ?>
                             <?php echo "<a class='news-btn global-btn smooth-hover'".$url.">READ MORE</a>"; ?>

                          </article>

                          </div>

                        </div>

                  </div>

                  <?php 
                        } 
                  } ?>

                  <section class="wide-section">
             
                    <div class="page-inner">

                        <div class="center-paragraph">

                        <?php if(!empty($List)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>

                        </div>

                    </div>

                   </section>

             </div>

             <aside id="right-sidebar">
        <div class="featured-sidebar">
          <ul id="linkedin-heading">
            <li><img src="/img/common/cdilabs-icon.png" /></li>
            <li><span>CDI LABS</span>Linkedin Feed</li>
          </ul>
          <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
          <div class="elfsight-app-32288ada-f358-4e48-835f-95241787278e" data-elfsight-app-lazy></div>
        </div>

      </aside>

            <div id="content-footer"></div>

        </div>

    </section>
      
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
    let cat = '<?php echo $catTitle; ?>';
    cat = cat.toLowerCase();
    if(cat == 'press releases') cat = 'press';
    document.querySelectorAll('#news-nav a').forEach((links) => { 
      if(links.getAttribute('data-news') == cat) links.classList.add('current');
    });
</script>
</body>
</html>
