<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['slugurl']) && basename($_GET['slugurl']) == $_GET['slugurl']){
  $urlName = trim($_GET['slugurl']);
  $dbhelper = new dbHelper('user');
  $webhelper = new WebHelper();
  $id = $dbhelper->selectOne("SELECT pkid FROM articles WHERE slugurl = ?", 's', $urlName);
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
          $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM articles WHERE pkid = $id");
          $PageUrl = "/admin/new-events/news/preview";
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

      <section class="wide-section section-with-sidebar news-section" id="single-press-page">
 
        <div class="page-inner">

           <div id="left-sidebar">

              <div id="page-nav">
              <?php
                if(!empty($Prev) && !empty($Prev["slugurl"])){
                  echo '<a href="/news-events/'.$Prev["slugurl"].'" class="prev btn smooth-hover">< Older</a>';
                }else{
                  echo '<a href="#" class="prev btn">< Older</a>';
                }
              ?>

              <?php
                if(!empty($Next) && !empty($Next["slugurl"])){
                  echo '<a href="/news-events/'.$Next["slugurl"].'" class="next btn smooth-hover">Newer ></a>';
                }else{
                  echo '<a href="#" class="next btn">Newer ></a>';
                }
              ?>
              </div>

                <div id="single-press-pdf">

                  <?php if($ViewData['filename'] != 'none'){ ?>
                    <a href="/content/articles/<?php echo $ViewData['slugurl']; ?>"><svg viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/><path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/></svg> Download PDF</a>
                    <?php } ?>

                </div>

                <div id="press-share">
                <ul>
                    <li>Share</li>
                    <li>
                    <a href="http://linkedin.com/shareArticle?mini=true&url=<?php echo $webhelper->Domain; ?>/news-events/press-post?pkid=<?php echo $pkid; ?>&title=<?php echo $ViewData["title"]; ?>" class="smooth-hover" target="_blank"><svg class="linkedin-news smooth-hover" viewBox="0 0 24 24"><path d="M8 19h-3v-10h3v10zm11 0h-3v-5.342c0-1.392-.496-2.085-1.479-2.085-.779 0-1.273.388-1.521 1.165v6.262h-3s.04-9 0-10h2.368l.183 2h.062c.615-1 1.598-1.678 2.946-1.678 1.025 0 1.854.285 2.487 1.001.637.717.954 1.679.954 3.03v5.647z"/><ellipse cx="6.5" cy="6.5" rx="1.55" ry="1.5"/></svg></a></li>
                    <li>
                    <a href="http://twitter.com/home?status=<?php echo $ViewData["title"]; ?> https://<?php echo $webhelper->Domain; ?>/news-events/press-post?pkid=<?php echo $pkid; ?>" class="smooth-hover" target="_blank"><svg class="twitter-news smooth-hover" viewBox="0 0 16 16"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/></svg></a></li>
                </ul>
                </div>

                <article id="press-article">

                  <p id="single-press-date"><?php echo $webhelper->GetFullWeekName($ViewData["day"]).', '.$webhelper->GetMonthShortName($ViewData["month"]).' '.$ViewData["day"].' '.$ViewData["year"]; ?></p>
        
                  <h4><?php echo $ViewData["title"]; ?></h4>
                  <?php if($ViewData['subtitle'] != 'none') echo "<h5>".$ViewData['subtitle']."</h5>"; ?>
      
                  <div class="press-body">
                    <?php echo nl2br(stripcslashes($ViewData["body"])); ?>
                  </div>

                </article>

         </div>

         <aside id="right-sidebar">
              <div class="featured-sidebar">
                <ul id="linkedin-heading">
                    <li><img src="/img/common/cdilabs-icon.png" /></li>
                    <li><span>CDI LABS</span>Linkedin Feed</li>
                </ul>
                <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script><div class="elfsight-app-32288ada-f358-4e48-835f-95241787278e" data-elfsight-app-lazy></div>
              </div>
                 
            </aside>

            <div id="content-footer"></div>

       </div>

     </section>

</main>

<?php 
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scriptsHide.php'); ?>
</body>
</html>

