<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageCode = "040102";
$bodyid = "resources";
$paginUrl = '/resources/publications';
$bodyClass= "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'publications'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$page = $webhelper->RequestFilter("page", 0, false);
$searchKeyword = $webhelper->RequestFilter("searchKeyword", 300, false);
$searchPublication = $webhelper->RequestFilter("searchPublication", 300, false);
$searchYear = $webhelper->RequestFilter("searchYear", 4, false);
$searchInst = $webhelper->RequestFilter("searchInst", 300, false);
$searchAuth = $webhelper->RequestFilter("searchAuth", 300, false);
if($webhelper->isNull($page)) $page = 1;
if($webhelper->isNull($searchKeyword)) $searchKeyword = "";
if($webhelper->isNull($searchPublication)) $searchPublication = "";
if($webhelper->isNull($searchYear)) $searchYear = "";
if($webhelper->isNull($searchInst)) $searchInst = "";
if($webhelper->isNull($searchAuth)) $searchAuth = "";
$Parameter = "&searchKeyword=$searchKeyword&searchPublication=$searchPublication&searchYear=$searchYear&searchInst=$searchInst&searchAuth=$searchAuth";
$PageSize = 10;
$sql = "SELECT * FROM publications WHERE status = 1 ";
if($searchYear != ""){
   $sql .= " and year = '$searchYear' ";
}
if($searchKeyword != ""){
   $searchKeyword = str_replace('%20', ' ', $searchKeyword);
   $sql .= " and ( ( keywords != '' and keywords like '%$searchKeyword%') or title like '%$searchKeyword%' or authors like '%$searchKeyword%' or publisher like '%$searchKeyword%' or body like '%$searchKeyword%' ) ";
}
if($searchInst != ""){
   $sql .= " and institution like '%$searchInst%' ";
}
if($searchAuth!= ""){
   $sql .= " and authors like '%$searchAuth%' ";
}
if($searchPublication != ""){
   $sql .= " and publisher = '$searchPublication' ";
}
$sql .= " order by year desc, month desc, day desc";
$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$PageTitle = 'Publications | CDI Labs';
$metaDesc = 'Browse through CDI Labs Publications.';
$PageUrl = 'resources/publications';
$sql = "";
$keyword = false;
$searchResult = '';
if(!empty($_GET['searchKeyword'])){
   $searchResult = $searchKeyword;
   $keyword = true;
}
if(!empty($_GET['searchPublication'])){
   $searchResult = $searchPublication;
   $keyword = true;
}
if(!empty($_GET['searchInst'])){
   $searchResult = $searchInst;
   $keyword = true;
}
if(!empty($_GET['searchAuth'])){
   $searchResult = $searchAuth;
   $keyword = true; 
}
if(!empty($_GET['searchYear'])){
   $searchResult = $searchYear;
   $keyword = true;
}
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<?php 
if(!$keyword && $page == 1){
    echo "<title>$PageTitle</title>";
    echo "<meta name='description' content='$metaDesc' />";
    echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
} 
if($page > 1 && empty($searchResult)){
   $PageTitle = 'Publications - Page '.$page.' | CDI Labs';
   $metaDesc = 'Browse through CDI Labs Publications Page '.$page;
   $PageUrl = 'resources/publications?page='.$page.$Parameter;
   echo "<title>$PageTitle</title>";
   echo "<meta name='description' content='$metaDesc' />";
   echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}
if($page > 1 && !empty($searchResult)){
   $PageTitle = 'Publications Results on '.$searchResult.' - Page '.$page.' | CDI Labs';
   $metaDesc = 'Browse through CDI Labs Publications Results on '.$searchResult.' - Page '.$page;
   $PageUrl = 'resources/publications?page='.$page.$Parameter;
   echo "<title>$PageTitle</title>";
   echo "<meta name='description' content='$metaDesc' />";
   echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
}
if($page == 1 && $keyword){ 
   $PageTitle = 'Publications Results on '.$searchResult.' | CDI Labs';
   $metaDesc = 'Browse through CDI Labs Publications Results on '.$searchResult;
   $PageUrl = 'resources/publications?page='.$page.$Parameter;
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

    <section class="hero-section short-hero" id="publications-hero">

	    <div class="page-inner">

	        <section class="left-hero-content white-text">
              <h1>Scientific Publications</h1>
              <h3>High-profile publications featuring CDI Labs <span class="line-break" >next-gen proteomics technologies and services</span></h3>
	        </section>

	        <p id="pub-count"><small><em><?php echo $pageList->RecordCount; ?></em> Total Publications</small></p>

        </div>
 
    </section>

    <section class="wide-section section-with-sidebar">

      <div class="page-inner">

        <div id="left-sidebar">

        	<section id="pub-search-box">

	             <h3>Refine Your Search</h3>

	             <form method="get" name="searchFrm" id="pub-form" action="/resources/publications">
	    
	                <fieldset>
	                    <label for="keyword">Keyword</label>
	                    <input type="text" name="searchKeyword" value="<?php echo $searchKeyword; ?>" placeholder="Keyword" tabindex = "1" maxlength="250" />
		            </fieldset>

	                <fieldset>
	                    <label for="publication">Publication/Type</label>
	                    <input type="text" name="searchPublication" value="<?php echo $searchPublication; ?>" placeholder="Publication/Type" tabindex = "2" maxlength="200" />
		            </fieldset>

	                <fieldset>
	                    <label for="institution">Institution(s)</label>
	                    <input type="text" name="searchInst" value="<?php echo $searchInst; ?>" placeholder="Institution(s)" tabindex = "3" maxlength="200" />
		            </fieldset>

                    <fieldset>
	                    <label for="author">Author(s)</label>
	                    <input type="text" name="searchAuth" value="<?php echo $searchAuth; ?>" placeholder="Author(s)" id="authors-field" tabindex = "4" maxlength="200" />

	                    <label for="year">Year</label>
	                    <input type="text" name="searchYear" value="<?php echo $searchYear; ?>" placeholder="Year" tabindex = "5" maxlength="4" />
	                </fieldset>

                    <div id="pub-search-submit">
                        <a href="#" id="search-submit" class="global-btn blue-btn smooth-hover">SEARCH</a>
                        <a href="#" id="reset-submit" class="global-btn gray-btn smooth-hover">RESET</a>
                    </div>

	              </form>

	          </section>

              <section id="publications-list">

	              <div id="expand-abstracts">
                     <a href="#" class="global-btn blue-btn expand-all smooth-hover">Expand Abstracts</a>
	              </div>

	              <div id="pub-heading">
	                  <p>Publication Details</p>
	                  <ul>
	                     <li>Date</li>
	                     <li>Link</li>
	                     <li>PDF</li>
	                     <li>+ Abstract</li>
	                  </ul>
	              </div>

                  <?php 
                    if(!empty($List) && count($List) > 0){
                        foreach($List as $row){ 
                           $fullAuthor = $row["authors"];
                           $shortAuthor = $webhelper->CurRightString($fullAuthor, "125");
                           $authorLength = strlen($fullAuthor);
                            if($authorLength > 125){
                               $endOfAuthors = strrpos($shortAuthor,' ');
                               $authors = substr($shortAuthor,0,$endOfAuthors).'...';
                            }else{
                               $authors = $fullAuthor;
                            }
                      ?>
			              <div class="pub-section">

			              	  <div class="pub-left-col">

			              	  	  <div class="pub-thumb">

			              	  	  	<img src="/files/publications/<?php echo $row["thumbnail"]; ?>" alt="<?php echo $row['publisher']; ?>" />

			              	  	  	<?php if($row["publisher"] != "") echo'<p>'.$row['publisher'].'</p>'; ?>

			              	  	  </div>

				                  <ul>
                                      <li><span>Main Product: </span><?php echo $row["main_product"];?></li>
				                      <li class="pub-title"><?php echo $row["title"]; ?></li>
				                      <li class="pub-author"><?php echo $authors; ?></li>
				                      <li class="pub-institution"><?php echo $row["institution"]; ?></li>
				                  </ul>

			                  </div>

			                  <ul class="pub-right-col">
			                      <li class="pub-year"><?php echo $webhelper->GetMonthShortName($row["month"]).' '.$row['day'].'<span>'.$row["year"].'</span>'; ?></li>
			                      <li><?php if($row["link"] != ""){?><a href="<?php echo $row["link"]; ?>" target="_blank" class="publications-btn smooth-hover"><svg class="link-icon" viewBox="0 0 16 16"><path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/><path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/></svg></a>
			                      <?php }else{?>&nbsp;<?php } ?>
			                      </li>
			                      <li><?php if($row["orgfilename"] != "none"){?><a href="/content/publications/<?php echo $row["slugurl"]; ?>" class="publications-btn smooth-hover"><svg viewBox="0 0 16 16" class="pdf-icon"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/><path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/></svg></a>
                                  <?php }else{ ?>&nbsp;<?php } ?>
			                      </li>
			                      <li class="expand-one smooth-hover"><svg class="plus-icon" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/></svg></li>
			                  </ul>

			                  <div class="pub-desc desc-closed">
                          <p><?php echo $row["body"]; ?></p>
                          <ul>
                            <?php if($row["link"] != "" ){ echo "<li><span>Link: </span><a href='".$row['link']."' target='_blank'>".$row["link"]."</a></li>"; } ?>
                          </ul>
			                  </div>

			              </div>
                    <?php 
                        } 
                    } ?>

             </section>

             <section class="wide-section" id="pagination-section">
 
            <div class="page-inner">

                 <div class="center-paragraph">

                  <?php if(!empty($List)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>

                </div>

            </div>

        </section>

        </div>

        <aside id="right-sidebar">
          <div class="featured-sidebar">
            <h4>Featured Publications</h4>
            <?php  
            $cnt = 1;
            $featured = $dbhelper->selectAll("SELECT * FROM publications WHERE featured = 1 AND status = 1 ORDER BY title");
            foreach($featured as $fRow){
              $pubId = $fRow['pkid'];
              $publisher = $fRow['publisher'];
              $title = $fRow['title'];
              $url = $fRow['link'];
              $authors = $fRow['authors'];
              $slugurl = $fRow['slugurl'];
              echo "<ul>";
              echo "<li><a class='featured-publisher'>$publisher</a></li>";
              echo "<li><a class='featured-title' href='$url'>$title</a></li>";
              echo "<li>$authors</li>";
              if($fRow["orgfilename"] != "none"){ echo "<li><a href='/content/publications/$slugurl'><svg viewBox='0 0 16 16' class='pdf-icon'><path d='M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z'/><path d='M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z'/></svg></a></li>";}
              echo "<li><a class='featured-link' href='$url' target='_blank'>View Publication<svg class='small-left-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a></li>";
              echo "</ul>";
              $cnt++;
            }
            ?>
          </div>
             
        </aside>

        <div id="content-footer"></div>
        
      </div>

    </section>

</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
if (typeof jQuery == 'undefined'){
	document.write(unescape("%3Cscript src='/scripts/jquery-3.6.3.min.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>
<script>
document.getElementById('search-submit').addEventListener('click', function(){
	var f = document.searchFrm;
    f.submit();
},false);

document.getElementById('reset-submit').addEventListener('click', function(){
    var f = document.searchFrm;
    f.searchKeyword.value = "";
    f.searchPublication.value = "";
    f.searchInst.value = "";
    f.searchAuth.value = "";
    f.searchYear.value = "";
    f.submit();
},false);


$('#expand-abstracts a').click(function(e){
	if($(this).hasClass('expand-all')){ 
		$(this).text('Collapse Abstracts').removeClass('expand-all').addClass('collapse-all');
		$.each($('.pub-desc'),function(){
          $(this).addClass('desc-opened').removeClass('desc-closed').slideDown();
	    });
	    $.each($('.expand-one'),function(){
	       $(this).removeClass('fa-plus-circle').addClass('fa-minus-circle');
	    });
    }else{
    	$(this).text('Expand Abstracts').removeClass('collapse-all').addClass('expand-all');
        $.each($('.pub-desc'),function(){
          $(this).addClass('desc-closed').removeClass('desc-opened').slideUp();
	    });
    	$.each($('.expand-one'),function(){
	       $(this).removeClass('fa-minus-circle').addClass('fa-plus-circle');
	    });
    }
	e.preventDefault();
}); 

$('.expand-one').click(function(e){
	var expandOne = $(this);
	if(expandOne.hasClass('fa-plus-circle')){
     expandOne.removeClass('fa-plus-circle').addClass('fa-minus-circle');
  }else{
     expandOne.removeClass('fa-minus-circle').addClass('fa-plus-circle');
  }

	var pubDesc = expandOne.closest('div').find('.pub-desc');
	var divsOpened = $('.desc-opened').length;
  if(divsOpened < 2) $('#expand-abstracts a').text('Expand Abstracts').removeClass('collapse-all').addClass('expand-all');

	if(pubDesc.hasClass('desc-closed')){
    if(divsOpened == 1){
      $('.desc-opened').parent().find('.expand-one').removeClass('fa-minus-circle').addClass('fa-plus-circle');
      $('.desc-opened').addClass('desc-closed').removeClass('desc-opened').slideToggle();
    }
		pubDesc.slideToggle(400, function(){
			pubDesc.addClass('desc-opened').removeClass('desc-closed');
		});
	}else{
		pubDesc.slideToggle(400, function(){
			pubDesc.addClass('desc-closed').removeClass('desc-opened');
		});
	}
	e.preventDefault();
});
</script>
</body>
</html>

