<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
	$dbhelper = new dbHelper('user');
	$webhelper = new WebHelper();
	$slugurl = $webhelper->RequestFilter("name", 255, false);
	if($slugurl == 'huprot'){
    header('Location: /resources/faqs/');
    exit;
	}else{
    $pageId = $dbhelper->selectOne("SELECT pkid FROM faqs_page WHERE slugurl = ? AND status = 1 AND cat='faqs'", 's', $slugurl);
    if($pageId > 0){
  	  $bodyid = 'resources';
      $bodyClass= "clear-header";
  	  $PageCode = "040102";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
  	  $pageInfo = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl FROM faqs_page WHERE pkid = $pageId AND cat='faqs'");
  	  $PageName = $pageInfo['title'];
      $PageTitle = 'FAQs - '.$pageInfo['title'].' | CDI Labs';
      $metaDesc = 'Find answers to the most commonly asked questions about '.$PageName;
      $PageUrl = 'resources/faqs/'.$pageInfo['slugurl'];
      $pageHero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM faqs_page_hero WHERE page_id = $pageId");
      if($pageHero["desktop"] != 'none') $heroExt = pathinfo($pageHero["desktop"], PATHINFO_EXTENSION);
  	  $pageSection = $dbhelper->selectAll("SELECT * FROM faqs_page_section WHERE page_id = $pageId ORDER BY position ASC");
    }else{
    	header('Location: /404');
      exit;
    }
	}
}else{
header('Location: /404');
exit;
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $PageTitle; ?></title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain.'/'.$PageUrl; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
.hero-section{background-repeat:no-repeat;background-position:left top;background-size:cover}
<?php 
 if(!empty($pageHero["desktop"]) && $heroExt !='mp4'){
  $desktopHero = $pageHero["desktop"];
  echo ".hero-section{
    background-image: url('/files/hero/faqs/$desktopHero');
  }";
 }
 if(!empty($pageHero["mobile"])){
  $desktopMobile = $pageHero["mobile"];
  echo "@media all and (max-width: 845px) {
  .hero-section{background-image:url('/files/hero/faqs/$desktopMobile');
  }}";
 }
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 <main role="main">
    <?php
    $target = $pageHero['btn_target'] == 0 ? '' : "target='_blank'";
    echo "<section class='hero-section {$pageHero['height']}-hero {$pageHero['bg']}-bg faqs-hero' id='{$pageInfo['slugurl']}'>

            <div class='page-inner'>";

                echo "<section class='{$pageHero['align']}-hero-content'>";
       
                    echo "<h1>{$pageHero['heading']}</h1>";
                    if($pageHero['subheading'] != 'none') echo "<h3>{$pageHero['subheading']}</h3>";
                    if($pageHero['paragraph'] != 'none') echo "{$pageHero['paragraph']}";
                    if(!empty($pageHero['btn_text']) && $pageHero['btn_text'] != 'none') echo "<a href='{$pageHero['btn_url']}' $target class='global-btn smooth-hover'>{$pageHero['btn_text']}</a>";

              echo "</section>

        </div>
   
    </section>";
    ?>

    <section class="wide-section section-margins" id="faqs-section">

    	<div class="page-inner">

    		<div class="card-layout card2-wrapper">

		        <div id="faqs-sidebar">

		            <?php 

		            echo "<h2>{$pageInfo['title']}</h2>";
		        	
		        	echo "<ul class='ul-with-circles'>";

			        	foreach($pageSection as $row){
			        		$catName = $row['category'];
					        switch($row['id_name']){
			                  case 'gst-staining-and-gridding':
		                        $catName = 'GST Staining and Gridding';
		                        break;
		                      case 'antibody-specificity-and-cross-reactivity-testing':
		                        $catName = 'Antibody Specificity and Cross-reactivity Testing';
		                        break;
					        }
			             echo "<li><a href='#{$row['id_name']}'>$catName</a></li>";
			        	}

			        echo "</ul>";

		        	?>
		        	
		        </div>

		        <div id="faqs-content">

		        <ul id="faqs-top-nav">
		        	<li id="expand-answers" class="expand-all">Expand All Answers</li>
		        	<li><a href="/resources/faqs/huprot" class="smooth-hover">HuProt</a></li>
			        <li><a href="/resources/faqs/phip-seq" class="smooth-hover">PhIP-Seq</a></li>
			    </ul>

			    <?php
			    foreach ($pageSection as $section){
			       $lazy = '';
			       $sectionId = $section['pkid'];
			       $sectionBg = $section['bgColor'] == 'white' ? '' : $section['bgColor'].'-section';
			       $catHeading = $section['category'];
			       switch($section['id_name']){
	                  case 'what-is-phip-seq':
	                    $catHeading = 'Phage Display ImmunoPrecipitation Sequencing (PhIP-Seq)';
	                    break;
	                  case 'gst-staining-and-gridding':
                        $catHeading = 'GST Staining and Gridding';
                        break;
                      case 'antibody-specificity-and-cross-reactivity-testing':
		                $catHeading = 'Antibody Specificity and Cross-reactivity Testing';
		                break;
			       }
			       echo "<div class='faqs-category $sectionBg' id='{$section['id_name']}'>";

			             echo "<h2>$catHeading</h2>";

                              echo "<div class='faqs-body'>";

	                              if($section['cat_body'] != 'none') echo $section['cat_body'];

                              echo "</div>";

			       echo "</div>";
			     } ?>

				</div>

			</div>

		</div>

	</section>

</main>
 
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>
<script type='text/javascript' src="/js/custom.js"></script>
<script>
window.onload = function(){
	let id = location.hash.split('#');
	currPath = window.location.pathname;
	window.scrollTo(0, 0);
  if(id != ''){
     let container = document.getElementById(id[1]).getBoundingClientRect();
     smoothScroll({yPos: container.y - 200, duration: 500});
     document.querySelectorAll('#'+id[1]+' .faqs-paragraph').forEach(fpLoad => {
      slideDown(fpLoad);
      fpLoad.previousElementSibling.classList.add('question-before');
	    fpLoad.classList.replace('answer-closed', 'answer-opened');
     });
  }
}
document.querySelectorAll('#faqs-sidebar li a').forEach(sbLink => {
   sbLink.addEventListener('click', function(event){
    event.preventDefault();
    let newId = sbLink.getAttribute('href').split('#');
    document.querySelectorAll('.faqs-paragraph').forEach(answers => {
      if(answers.parentElement.parentElement.getAttribute('id') !== newId[1]){
        answers.style.display='none';
        answers.classList.replace('answer-opened', 'answer-closed');
        answers.previousElementSibling.classList.remove('question-before');
      }
    });
    window.scrollTo(0, 0);
    let newContainer = document.getElementById(newId[1]).getBoundingClientRect();
    smoothScroll({yPos: newContainer.y - 180, duration: 500});
    history.pushState(null, null, window.location.pathname+"#"+newId[1]);
    document.querySelectorAll('#'+newId[1]+' .faqs-paragraph').forEach(faqsPara => {
      slideDown(faqsPara);
      faqsPara.previousElementSibling.classList.add('question-before');
	    faqsPara.classList.replace('answer-closed', 'answer-opened');
    });
    let expandAll = document.getElementById('expand-answers');
    if(expandAll.classList.contains('expand-none')){
      expandAll.classList.replace('expand-none', 'expand-all');
      expandAll.classList.remove('question-before');
    }
   });
});

document.getElementById('expand-answers').addEventListener('click', function(event){
	if(this.classList.contains('expand-all')){
    document.querySelectorAll('.faqs-paragraph').forEach(fp => {
		  slideDown(fp);
			fp.classList.replace('answer-closed', 'answer-opened');
			fp.previousElementSibling.classList.add('question-before');
		});
		this.classList.replace('expand-all', 'expand-none');
		this.classList.toggle('question-before');
	}else{
		document.querySelectorAll('.faqs-paragraph').forEach(fp => {
		  slideUp(fp);
	    fp.classList.replace('answer-opened', 'answer-closed');
	    fp.previousElementSibling.classList.remove('question-before');
		});
		this.classList.replace('expand-none', 'expand-all');
		this.classList.toggle('question-before');
  }
});

document.querySelectorAll('.faqs-category h3').forEach(question => { 
  question.addEventListener('click', function(event){
  	this.classList.toggle('question-before');
    let faqsAnswer = question.nextElementSibling;
    let faqsState = faqsAnswer.classList;
    let currSecId = question.parentElement.parentElement.getAttribute('id');
    document.querySelectorAll('#'+currSecId+' .faqs-paragraph').forEach(secA => {
      if(secA.classList.contains('answer-opened') && faqsState.contains('answer-closed')){
      	slideUp(secA);
        secA.classList.replace('answer-opened', 'answer-closed');
        secA.previousElementSibling.classList.remove('question-before');
      }
    });
    if(faqsState.contains('answer-closed')){
      slideDown(faqsAnswer, 500);
      faqsState.replace('answer-closed', 'answer-opened');
    }else{
      slideUp(faqsAnswer, 500);
      faqsState.replace('answer-opened', 'answer-closed');
    }
  });
});

let slideUp = (target, duration=500) => {
    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    target.style.height = target.offsetHeight + 'px';
    target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout( () => {
          target.style.display = 'none';
          target.style.removeProperty('height');
          target.style.removeProperty('padding-top');
          target.style.removeProperty('padding-bottom');
          target.style.removeProperty('margin-top');
          target.style.removeProperty('margin-bottom');
          target.style.removeProperty('overflow');
          target.style.removeProperty('transition-duration');
          target.style.removeProperty('transition-property');
    }, duration);
}
let slideDown = (target, duration=500) => {
    console.log(target.style.height);
    target.style.removeProperty('display');
    let display = window.getComputedStyle(target).display;
    if (display === 'none') display = 'block';
    target.style.display = display;
    let height = target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + 'ms';
    target.style.height = height + 'px';
    target.style.removeProperty('padding-top');
    target.style.removeProperty('padding-bottom');
    target.style.removeProperty('margin-top');
    target.style.removeProperty('margin-bottom');
    window.setTimeout( () => {
      target.style.removeProperty('height');
      target.style.removeProperty('overflow');
      target.style.removeProperty('transition-duration');
      target.style.removeProperty('transition-property');
    }, duration);
}
var slideToggle = (target, duration = 500) => {
    if (window.getComputedStyle(target).display === 'none') {
      return slideDown(target, duration);
    } else {
      return slideUp(target, duration);
    }
}

/*---------------------------------------*/

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
