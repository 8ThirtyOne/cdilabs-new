<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['slugurl']) && basename($_GET['slugurl']) == $_GET['slugurl']){
  $urlName = trim($_GET['slugurl']);
  $dbhelper = new dbHelper('user');
  $webhelper = new WebHelper();
  $id = $dbhelper->selectOne("SELECT pkid FROM posts WHERE slugurl = ?", 's', $urlName);
  if($id == 0){
    header('Location: /admin/blogs/list'); 
    exit;
  }else{
    if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
      $input = $_SESSION['user'];
      if($input == 0){
        header('Location: /admin/');
        exit;
      }else{
        $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
        if(!empty($username)){
          $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM posts WHERE pkid = $id");
          $PageUrl = "/admin/blogs/preview";
          $PageCode = "030102";
          $bodyid = "news";
          $bodyClass= "full-header";
          $FirstPageCode = substr($PageCode, 0, 2);
          $SecodeCode = substr($PageCode, 2, 2);
          $ThirdCode = substr($PageCode, 4, 2);
        }else{
          header('Location: /admin/');
          exit;
        }
      }
    }else{
      header('Location: /admin/blogs/list'); 
      exit;
    }
  }
}else{
  header('Location: /admin/blogs/list'); 
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $ViewData['title']; ?> | CDI Labs Admin</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-sectionHide.php'); ?>
<style>
  .hero-section{background-repeat:no-repeat;background-position:left top}
 <?php 
 if(!empty($ViewData["desktop_hero"])){
  echo "
    #blog-hero{background-image: url('/files/blogs/{$ViewData["desktop_hero"]}');}";
 }
 if(!empty($ViewData["mobile_hero"])){
 echo "@media all and (max-width: 670px) {
  #blog-hero{background-image:none}
    #blog-hero:before{background:url('/files/blogs/{$ViewData["mobile_hero"]}') no-repeat center center;background-size:cover}";
  }
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

  <section class="hero-section short-hero" id="blog-hero">

      <div class="page-inner">

          <section class="left-hero-content">
            <?php 
              $day = ltrim($ViewData['day'],'0');
              $date = $webhelper->GetMonthName($ViewData["month"]).' '.$day.', '.$ViewData["year"];
              echo "<p id='blog-date'>$date</p>";
              echo "<h1>{$ViewData['title']}</h1>";
              if($ViewData['subtitle'] !='none') echo "<h2>{$ViewData['subtitle']}</h2>";
              echo "<p>by{$ViewData['author']}</p>";
            ?>
          </section>

      </div>
 
    </section>

    <section class="wide-section news-section section-with-sidebar" id="blog-section">
 
        <div class="page-inner">

          <div id="left-sidebar">

              <div id="page-nav">
              <?php
                if(!empty($Prev) && !empty($Prev["slugurl"])){
                  echo '<a href="/blogs/'.$Prev["slugurl"].'" class="prev btn smooth-hover">< Older</a>';
                }else{
                  echo '<a href="#" class="prev btn">< Older</a>';
                }
              ?>

              <?php
                if(!empty($Next) && !empty($Next["slugurl"])){
                  echo '<a href="/blogs/'.$Next["slugurl"].'" class="next btn smooth-hover">Newer ></a>';
                }else{
                  echo '<a href="#" class="next btn">Newer ></a>';
                }
              ?>
              </div>

                <article id="press-article">
      
                  <div class="press-body">
                    <?php echo $ViewData["body"]; ?>
                  </div>

                </article>

                <?php 

                  if($ViewData["keywords"] !='none'){
                    echo "<div id='post-keywords'><p>Keywords: {$ViewData['keywords']}</p></div>"; 
                  }

                ?>

         </div>

         <aside id="right-sidebar">
          <div class="featured-sidebar">
            <h4>Featured Blogs</h4>
            <?php  
            $featured = $dbhelper->selectAll("SELECT * FROM posts WHERE status = 0 ORDER BY title LIMIT 2");
            foreach($featured as $pRow){
              echo "<ul>";
              echo "<li><a href='/blogs/$slugurl'><img src='/files/blogs/{$pRow['thumbnail']}' alt='{$pRow['title']}' /></a></li>";
              echo "<li><a class='featured-title' href='/blogs/{$pRow['slugurl']}'>{$pRow['title']}</a></li>";
              echo "<li><a href='/blogs/{$pRow['slugurl']}'></a></li>";
              echo "<li><a class='featured-link' href='/blogs/$slugurl' target='_blank'>View Post<svg class='small-left-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a></li>";
              echo "</ul>";
            }
            ?>
          </div>
             
        </aside>

        <div id="content-footer"></div>

       </div>

    </section>

</main>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scriptsHide.php'); ?>
</body>
</html>
