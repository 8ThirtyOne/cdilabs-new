<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageCode = "030102";
$bodyid = "news";
$paginUrl = "/news-events/past-events";
$bodyClass= "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'events'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$page = $webhelper->RequestFilter("page", 0, false);
$searchYear = $webhelper->RequestFilter("searchYear", 0, false);
if($webhelper->isNull($page)) $page = 1;
if($webhelper->isNull($searchYear)) $searchYear = date("Y");
$Parameter = "&searchYear=$searchYear";
$PageSize = 10;
$sql = "SELECT pkid, type, year, startmonth, startday, endmonth, endday, title, eventurl, subtitle, location1, url, body, booth, thumbnail, DATEDIFF(STR_TO_DATE(concat(year, '-', startmonth, '-', startday), '%Y-%m-%d'), CURDATE()) AS diff
    FROM events WHERE CONCAT(year, '-', endmonth, '-', endday) < CURDATE() ";  
$sql .= "ORDER by year DESC, endmonth DESC, endday DESC";
$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$PageTitle = 'Past Events | CDI Labs';
$metaDesc = 'CDI Labs past events.';
$PageUrl = 'news-events/past-events';
$keyword = false;
$keyword = isset($_GET['page']) || isset($_GET['searchYear']) ? true : false;
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
       $PageTitle = 'Past Events - Page '.$page.' | CDI Labs';
       $metaDesc = 'CDI Labs Past Events - Page '.$page;
       $PageUrl = 'news-events/past-events?page='.$page.$Parameter;
       echo "<title>$PageTitle</title>";
       echo "<meta name='description' content='$metaDesc' />";
       echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>  
<style>
  .hero-section{
    background-repeat:no-repeat;
    background-position:left top;
    background-size:cover;
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
   <section class="hero-section short-hero">
    <div class="page-inner">
          <section class="left-hero-content white-text">
              <h1>Events</h1>
              <h3>Visit us at these upcoming events</h3>
          </section>
    </section>
    <section class="wide-section section-with-sidebar" id="events-section">
        <div class="page-inner">
            <div id="left-sidebar">
                   <div class="events-list">
                      <div class="events-heading">
                        <h3>Events</h3>
                        <a href="/news-events/events">Upcoming Events<svg viewBox="0 0 512 512"><path d="M64 256c0 106 86 192 192 192s192-86 192-192S362 64 256 64 64 150 64 256z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M216 352l96-96-96-96"/></svg></a>  
                      </div>
                      <?php 
                         if(!empty($List) && count($List) > 0){
                            foreach ($List as $row){ 
                              $type = $row['type'];
                              $url = $row['eventurl'] == 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/event/" .$row['eventurl'] . "'";
                              if($row['type'] == 2 || $row['type'] == 3){
                                $booth = '<span><em>Online</em></span>';
                              }else{
                                $booth = '<span>Booth <em>'.$row["booth"].'</em></span>';
                              }
                      ?>
                      <article class="news-article">
                        <div class="event-info left">
                            <div class="event-thmb left">
                                <img class="shadow-bg" src="/files/events/<?php echo $row["thumbnail"]?>" alt="<?php echo $row["title"]; ?>" />
                            </div>
                            <div class="event-title left">
                              <h4><?php echo $row["title"]; ?></h4>
                              <p class="event-sub"><?php echo $webhelper->CurRightString($row["subtitle"], "400"); ?></p>
                              <p class="event-date">
                                <?php 
                                $startMonth = $webhelper->GetMonthName($row["startmonth"]);
                                $endMonth = $webhelper->GetMonthName($row["endmonth"]);
                                $startDay = ltrim($row['startday'],'0');
                                $endDay = ltrim($row['endday'],'0');
                                $date = $row["startday"] == $row["endday"] ? $startDay : $startDay.' - '.$endDay;
                                if($row["endmonth"] > $row["startmonth"]){
                                   echo $startMonth.' '.$startDay.' - '.$endMonth.' '.$endDay;
                                }else{
                                   echo $startMonth.' '.$date; 
                                } ?>
                                </p>
                                <p class="event-location1"><?php echo $row["location1"]; ?></p>
                                <p class="event-booth"><?php echo '<span>Booth <em>'.$row["booth"].'</em></span>'; ?></p>
                              </div>
                          </div>
                          <div class="event-body left">
                              <?php echo nl2br(stripcslashes($row["body"])); ?>
                          </div>
                          <?php if(isset($url)) echo "<a class='global-btn blue-btn event-btn smooth-hover'".$url.">MORE INFO</a>"; ?>
                      </article>
                <?php 
                    } 
                }else{ 
                ?>
                    <section class="wide-section">
                        <div class="page-inner narrow-section">
                            <div class="center-paragraph">
                               <h3>Currently, there are no upcoming CDI Labs events. Please come back later or subscribe below to receive CDI Labs news.</h3>
                             </div>       
                        </div>
                    </section> 
                <?php } ?>
                </div>
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
                <h5>Schedule a Meeting with Us</h5>
                <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/schedule-meeting-form.php'); ?>
              </div>
            </aside>
            <div id="content-footer"></div>
        </div>
    </section>
</main>
 
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>
</body>
</html>
