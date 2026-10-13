<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$paginUrl = "/resources/literature";
$PageCode = "040102";
$bodyid = "resources";
$bodyClass= "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'literatures'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
if(isset($_GET['category']) && !empty($_GET['category'])){
    $input = trim($_GET['category']);
    $catId = 0;
    switch($input){
        case 'brochures':
            $catName = 'brochures';
            $catTitle = 'Brochures';
            $catId = 1;
            break;
        case 'flyers':
            $catName = 'flyers';
            $catTitle = 'Flyers';
            $catId = 2;
            break;
        case 'papers':
            $catName = 'papers';
            $catTitle = 'White Papers';
            $catId = 3;
            break;
        case 'posters':
            $catName = 'posters';
            $catTitle = 'Posters';
            $catId = 4;
            break;
        case 'technical':
            $catName = 'technical';
            $catTitle = 'Technical Docs';
            $catId = 5;
            break;
        case 'content':
            $catName = 'content';
            $catTitle = 'Content';
            $catId = 6;
            break;
    }
    if(is_int($catId) && $catId > 0){
        $sql = "SELECT * FROM literatures WHERE type = $catId AND status = 1 ";  
        $sql .= "ORDER BY year desc, month desc, day desc";
    }else{
        header('Location: /404');
        exit;
    }
}else{
    $sql = "SELECT * FROM literatures WHERE status = 1 ";  
    $sql .= "ORDER BY year desc, month desc, day desc";
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
$PageSize = 12;
$resources = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$PageTitle = 'Resources | CDI Labs';
$metaDesc = 'CDI Labs Literature';
$PageUrl = 'resources/literature';
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
       $PageTitle = 'Resources - Page '.$page.' of '.$catTitle.' | CDI Labs';
       $metaDesc = 'CDI Labs Literatures - Page '.$page.' of '.$catTitle;
       $PageUrl = 'resources/literature?page='.$page.$Parameter;
       echo "<title>$PageTitle</title>";
       echo "<meta name='description' content='$metaDesc' />";
       echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php');
?>
<style>
  .hero-section{background-repeat:no-repeat;background-position:left top}
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
 
   <section class="hero-section short-hero" id="literature-hero">

    <div class="page-inner">

        <section class="left-hero-content white-text">
              
            <h1>Resources</h1>
            <h3>View and download our content</h3>

          </section>
 
    </section>

    <section class="wide-section related-resources" id="literature-section">

        <div class="narrow-content docs-nav-wrapper">

            <div class="select-box">

             <ul id="literature-nav" class="docs-nav">
                <li><a id="all-docs" href="/resources/literature" data-news="all" class="smooth-hover">ALL</a></li>
                <li>|</li>
                <li><a href="/resources/literature?page=<?php echo $page; ?>&category=brochures" data-news="brochures" class="smooth-hover">Brochures</a></li>
                <li>|</li>
                <li><a href="/resources/literature?page=<?php echo $page; ?>&category=flyers" data-news="flyers" class="smooth-hover">Flyers</a></li>
                <li>|</li>
                <li><a href="/resources/literature?page=<?php echo $page; ?>&category=papers" data-news="papers" class="smooth-hover">White Papers</a></li>
                <li>|</li>
                <li><a href="/resources/literature?page=<?php echo $page; ?>&category=posters" data-news="posters" class="smooth-hover">Posters</a></li>
                <li>|</li>
                <li><a href="/resources/literature?page=<?php echo $page; ?>&category=technical" data-news="technical" class="smooth-hover">Technical Docs</a></li>
                <li>|</li>
                <li><a href="/resources/literature?page=<?php echo $page; ?>&category=content" data-news="content" class="smooth-hover">Library Content</a></li>
             </ul>

            </div>

        </div>

        <?php 
            if(!empty($resources) && count($resources) > 0){
               $total = count($resources);
               if($total > 3){
                $cardName = 'card4-wrapper';
               }else{
                $cardName = 'narrow-content card'.$total.'-wrapper';
               }
               $catTitle = strtoupper($catTitle);
               echo "<h3>$catTitle</h3>
               <div class='page-inner card-layout $cardName docs-wrapper'>";
              foreach ($resources as $row){
                $fullTitle = $row["title"];
                $shortTitle = $webhelper->CurRightString($fullTitle, "95");
                $titleLength = strlen($fullTitle);
                if($titleLength > 95){
                   $endOfTitle = strrpos($shortTitle,' ');
                   $docTitle = substr($shortTitle,0,$endOfTitle).'...';
                }else{
                   $docTitle = $fullTitle;
                }
                $fileType = $webhelper->GetFileType($row["orgfilename"]);
                $fileSize = $webhelper->GetFileSize("/literatures/" . $row["filename"]);
                $thmb = $row["thumbnail"];
                switch($row['type']){
                    case 1:
                        $docType = 'Brochure';
                        break;
                    case 2:
                        $docType = 'Flyer';
                        break;
                    case 3:
                        $docType = 'White Paper';
                        break;
                    case 4:
                        $docType = 'Poster';
                        break;
                    case 5:
                        $docType = 'Technical Doc';
                        break;
                    case 6:
                        $docType = 'Library Content';
                        break;
                }
                $fullDesc = $row["body"];
                $shortDesc = $webhelper->CurRightString($row["body"],160);
                $descLength = strlen($fullDesc);
                if($descLength > 160){
                   $endOfDesc = strrpos($shortDesc,' ');
                   $abstract = substr($shortDesc,0,$endOfDesc).'...';
                }else{
                   $abstract = $fullDesc;
                }
              ?>

                <div class="document-box">

                    <?php echo "<p class='doc-type'>".$docType."</p>"; ?>
                    <div class="thmb-with-shadow">
                     <a href="<?php echo '/content/literatures/'.$row['slugurl']; ?>" class="brochures-btn hover-thmb">
                       <picture>
                          <source srcset="/files/literatures/<?php echo $thmb; ?>" media="(min-width: 760px)">
                          <source srcset="/files/literatures/<?php echo $thmb; ?>">
                          <img src="/files/literatures/<?php echo $thmb; ?>" alt="<?php echo $fullTitle; ?>" />
                        </picture>
                      <span class="download-hover"><em>VIEW / DOWNLOAD</em></span></a>
                    </div>
                     <div class="brochures-text left">
                       <p class="support-file"><?php echo $fileType; ?> | <?php echo $fileSize; ?></p>
                       <h4><?php echo $docTitle; ?></h4>
                       <p><?php if(!empty($abstract) && $abstract != 'none') echo $abstract; ?></p>
                     </div>

                </div>

                <?php } ?>

             </div>

             <?php
               }else{ 

                    echo "<div class='center-paragraph'>

                         <h3>There are no $catTitle currently available.</h3>

                     </div>";

                } ?>

        </section>

        <section class="wide-section">
             
            <div class="page-inner">

                <div class="center-paragraph">

                <?php if(!empty($resources)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>

                </div>

            </div>

     </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
let cat = '<?php echo $catTitle; ?>';
cat = cat.toLowerCase();
if(cat == 'white papers') cat = 'papers';
if(cat == 'technical docs') cat = 'technical';
document.querySelectorAll('#literature-nav a').forEach((links) => { 
  if(links.getAttribute('data-news') == cat) links.classList.add('current');
});
</script>
</body>
</html>