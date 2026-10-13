<?php
include_once('../../lcmodel/loadPage.inc.php');

use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;

$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageCode = "030102";
$bodyid = "news";
$bodyClass = "clear-header";
$PageName = "Blog";
$paginUrl = "/blogs/";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'blogs'");
if (!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$sql = "SELECT * FROM posts WHERE status = 1 ORDER BY created DESC";
$page = $webhelper->RequestFilter("page", 0, false);
if ($webhelper->isNull($page)) $page = 1;
if (!isset($input)) {
    $Parameter = "";
} else {
}
$PageSize = 7;
$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$PageTitle = 'Blogs | CDI Labs';
$metaDesc = 'CDI Labs Blogs';
$PageUrl = 'blogs/';
if (count($List) == 0) {
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
    <?php if ($keyword) {
        $PageTitle = 'BLOGS - Page ' . $page . ' | CDI Labs';
        $metaDesc = 'CDI Labs BLOGS - Page ' . $page;
        $PageUrl = 'blogs?page=' . $page . $Parameter;
        echo "<title>$PageTitle</title>";
        echo "<meta name='description' content='$metaDesc' />";
        echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
    } else {
        echo "<title>$PageTitle</title>";
        echo "<meta name='description' content='$metaDesc' />";
        echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
    }
    include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
    <style>
        .hero-section {
            background-repeat: no-repeat;
            background-position: left top;
            background-size: cover
        }

        <?php
        if (!empty($hero["desktop"]) && $ext != 'mp4') {
            $desktopImg = $hero["desktop"];
            echo "
    .hero-section{background-image: url('/files/hero/$desktopImg');}";
        }
        if (!empty($hero["mobile"])) {
            $mobileImg = $hero["mobile"];
            echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/hero/$mobileImg');}";
        }
        ?>
    </style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">
    <section class="hero-section short-hero" id="blog-hero">
        <div class="page-inner">
            <section class="left-hero-content">
                <p class="subheading">CDI Labs</p>
                <h1>Blogs</h1>
            </section>
        </div>
    </section>
    <section class="wide-section section-with-sidebar news-section <?php if($pageList->PageCount > 1){echo 'with-pagination';}?>" id="blog-list">
        <div class="page-inner">

            <div id="left-sidebar">
                <?php
                if (!empty($List) && count($List) > 0) {
                    foreach ($List as $row) {
                        $day = ltrim($row['day'], '0');
                        $date = $webhelper->GetMonthName($row["month"]) . ' ' . $day . ', ' . $row["year"];
                        echo "<section>

                    <div class='page-inner card-layout card2-wrapper'>

                        <div class='col'>

                            <p>$date</p>

                            <a href='/blogs/{$row['slugurl']}' class='post-thumb'><img src='/files/blogs/{$row['thumbnail']}' /></a>
                    
                        </div>

                        <div class='col'>

                             <h3>{$row['title']}</h3>

                             <div class='left author-box'>

                                 <div class='left author-avatar'>
                                     <div class='author-pic'></div>
                                     <img src='/files/blogs/{$row['avatar']}' alt='{$row['author']}' />
                                 </div>

                                 <ul class='left'>
                                    <li>by</li>
                                    <li>{$row['author']}</li>
                                    <li>{$row['job_title']}</li>
                                 </ul>

                             </div>

                             <a href='/blogs/{$row['slugurl']}' class='global-btn smooth-hover'>READ MORE</a>

                        </div>

                    </div>

                  </section>";
                    }
                }

                ?>
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
    <?php if($pageList->PageCount > 1 ){?> 
    <section class="wide-section" id="pagination-section">
        <div class="page-inner">
            <div class="center-paragraph">
                <?php if (!empty($List)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>
            </div>
        </div>
    </section>
    <?php } ?>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php');
?>
</body>

</html>