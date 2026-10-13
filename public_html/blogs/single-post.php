<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
	$title = trim($_GET['name']);
	$dbhelper = new dbHelper('user');
	$webhelper = new WebHelper();
	$pkid = $dbhelper->selectOne('SELECT pkid FROM posts WHERE slugurl = ? AND status = 1', 's', $title);
	if($pkid > 0){
	  $PageCode = "030102";
	  $bodyid = "news";
	  $bodyClass= "full-header";
	  $sql = "SELECT * FROM posts WHERE pkid = $pkid AND status = 1";
	  $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
    $getDate = $ViewData['day'].' '.$webhelper->GetMonthName($ViewData["month"]).' '.$ViewData['year'];
	  $sql = "SELECT slugurl FROM posts WHERE status = 1 AND pkid != $pkid 
	          AND concat(year, month, day)  < '" . $ViewData["year"] . $ViewData["month"] . $ViewData["day"] . "' ";
	  $sql .= " ORDER BY year desc, month desc, day desc, pkid desc";
	  $Prev = $dbhelper->RunSQLReturnOneRow($sql);
	  $sql = "SELECT slugurl FROM posts WHERE status = 1 AND pkid != $pkid 
	          and concat(year, month, day)  > '" . $ViewData["year"] . $ViewData["month"] . $ViewData["day"] . "' ";
	  $sql .= " ORDER BY year, month, day, pkid";
	  $Next = $dbhelper->RunSQLReturnOneRow($sql);
	  $keyword = false;
	  $keyword = !empty($_GET['searchYear']) || !empty($_GET['page']) ? true : false;
	  if(isset($ViewData["title"])){
	    $PageTitle = $webhelper->CurRightString($ViewData["title"], 100).' | CDI Labs Blog';
	    $metaDesc = $webhelper->CurRightString($ViewData["title"], 200);
	    $metaDesc = strip_tags($metaDesc);
      $PageUrl = 'blogs/'.$ViewData['slugurl'];
	  }        
	  $FirstPageCode = substr($PageCode, 0, 2);
	  $SecodeCode = substr($PageCode, 2, 2);
	  $ThirdCode = substr($PageCode, 4, 2);
	}else{
	   header('Location: /blogs/');
	   exit;
	}
}else{
 header('Location: /blogs');
 exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $PageTitle; ?></title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<?php 
echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); 
?>  
<style>
  .hero-section{background-repeat:no-repeat;background-position:left top}
 <?php 
 if(!empty($ViewData["desktop_hero"])){
  echo "
    #post-hero{background-image: url('/files/blogs/{$ViewData["desktop_hero"]}');}";
 }
 if(!empty($ViewData["mobile_hero"])){
 echo "@media all and (max-width: 670px) {
  #post-hero{background-image:none}
    #post-hero:before{background:url('/files/blogs/{$ViewData["mobile_hero"]}') no-repeat center center;background-size:cover}";
  }
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">
	<section class="hero-section short-hero" id="post-hero">
      <div class="page-inner">
          <section class="left-hero-content">
            <?php 
              $day = ltrim($ViewData['day'],'0');
              $date = $webhelper->GetMonthName($ViewData["month"]).' '.$day.', '.$ViewData["year"];
              echo "<p id='blog-date'>$date</p>";
              echo "<h1>{$ViewData['title']}</h1>";
              if($ViewData['subtitle'] !='none') echo "<h2>{$ViewData['subtitle']}</h2>";
              echo "<p>by {$ViewData['author']}</p>";
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
            $featured = $dbhelper->selectAll("SELECT * FROM posts WHERE status = 1 ORDER BY title LIMIT 3");
            foreach($featured as $pRow){
              echo "<ul>";
              echo "<li><a href='/blogs/{$pRow['slugurl']}' class='featured-thumb'><img src='/files/blogs/{$pRow['thumbnail']}' alt='{$pRow['title']}' /></a></li>";
              echo "<li><a class='featured-title' href='/blogs/{$pRow['slugurl']}'>{$pRow['title']}</a></li>";
              echo "<li><a class='featured-link' href='/blogs/{$pRow['slugurl']}' target='_blank'>View Post<svg class='small-left-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a></li>";
              echo "</ul>";
            }
            ?>
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
<script>
let pos = 0;
let timer;
var winW = window.innerWidth;
if(winW < 515){
  pos = 850 - winW;
}else{
  pos = 910 - winW;
}
window.addEventListener("resize", function() {
toggleDiagram();
});
function toggleDiagram(){
pos = 0;
winW = window.innerWidth;
if(winW < 515){
  pos = 850 - winW;
}else{
  pos = 910 - winW;
}
clearInterval(timer);
document.querySelectorAll('.mobile-wrap').forEach((dm) => { 
  dm.style.transform = 'translateX(0)';
});
}

//----------- PROCESS MOBILE DIRECTIONAL DIAGRAM ARROWS ---------//

  document.querySelectorAll('.diagram-mobile-nav li').forEach(dnav => {
    dnav.addEventListener('click', function(e){
      e.preventDefault();
      clearInterval(timer);
      document.querySelectorAll('.mobile-wrap').forEach((dm) => { 
        dm.style.transform = 'translateX(0)';
      });
      var diagram = this.parentElement.parentElement.querySelector('.mobile-wrap');
      let coord = diagram.getBoundingClientRect();
      if(this.classList.contains('slide-left') && coord.x < 0){
        animate(diagram, '+', pos);
      }
      if(this.classList.contains('slide-right') && coord.x > 0){
        animate(diagram, '-', pos);
      }
    });
  });

function animate(elem, dir, limit){
    var cnt = 0;
    function frame(){
      cnt++;
      if(dir=='+') elem.style.transform = 'translateX(0)';
      if(dir=='-') elem.style.transform = 'translateX('+dir+cnt + 'px)';
      if(cnt == limit) clearInterval(timer);
    }
    timer = setInterval(frame, 10);
 }
</script>
</body>
</html>