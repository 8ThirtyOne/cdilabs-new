<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
  $urlName = trim($_GET['name']);
  $dbhelper = new dbHelper('user');
  $webhelper = new WebHelper();
  $id = $dbhelper->selectOne("SELECT pkid FROM employee_page WHERE slugurl = ? AND status = 1", 's', $urlName);
  if($id == 0){
    header('Location: /admin/company/team'); 
    exit;
  }else{
    $dbhelper = new dbHelper('user');
    $webhelper = new WebHelper();
    $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM employee_page WHERE pkid = $id AND status = 1");
    $PageTitle = 'Meet '.$ViewData['first_name'].' '.$ViewData['last_name'].' | CDI Labs';
    $metaDesc = 'CDI Labs Team Profile - '.$ViewData['first_name'].' '.$ViewData['last_name'];
    $PageUrl = "company/team/".$ViewData['slugurl'];
    $PageCode = "060101";
    $bodyid = "company";
    $bodyClass= "clear-header";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
  }
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $PageTitle; ?></title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<link rel="canonical" href="/<?php echo $PageUrl; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
  .hero-section{background-repeat:no-repeat;background-position:left top}
 <?php 
 if(!empty($ViewData["hero_img"])){
  echo "
    #profile-hero{background-image: url('/files/team/{$ViewData["hero_img"]}');}";
 }
 if(!empty($ViewData["mobile_img"])){
 echo "@media all and (max-width: 670px) {
 	#profile-hero{background-image:none}
    #profile-hero:before{background:url('/files/team/{$ViewData["mobile_img"]}') no-repeat center center;background-size:cover}";
  }
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

    <section class="hero-section short-hero" id="profile-hero">

      <div class="page-inner narrow-section">

          <div class="right-hero-content">
           <p>Meet</p>
              <h1><?php echo stripcslashes($ViewData['first_name'].' '.$ViewData['last_name']); ?></h1>

              <h2><?php echo $ViewData['job_pos']; ?></h2>

              <h3><?php echo $ViewData['job_loc']; ?></h3>

          </div>

      </div>
 
    </section>

    <section class="wide-section no-margin" id="profile-quote">

      <div class="page-inner">
        
        <div class="center-paragraph">
          <p><svg viewBox="0 0 16 16"><path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z"/></svg><?php echo $ViewData['profile_quote']; ?><svg class="right-quote" viewBox="0 0 16 16"><path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z"/></svg></p>
        </div>

      </div>
      
    </section>

    <section class="wide-section" id="profile-section">

      <div class="page-inner narrow-section">

           <?php echo nl2br(stripcslashes($ViewData['page_body'])); ?>
        
      </div>

    </section>

</main>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>

