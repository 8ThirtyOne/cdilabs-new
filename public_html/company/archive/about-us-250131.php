<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/about-us";
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "clear-header";
$PageName = "ABOUT US";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
$banner = $dbhelper->selectAll("SELECT type, title, eventurl as slugurl, NULL AS url,                              startmonth AS month, startday AS day, endday, year,                              filename FROM events WHERE status = 1 AND isSlide=1
                                AND CONCAT(year, '-', endmonth, '-', endday) >= CURDATE()
                                UNION
                                SELECT type, title, slugurl, url, month, day, 
                                NULL AS endday, year, filename
                                FROM articles WHERE status = 1 AND isSlide = 1
                                ORDER BY year DESC, month DESC, day DESC");
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>About Us | CDI Labs</title>
<meta name="description" content="About the people and history of CDI Labs" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/company/about-us" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <section class="hero-section tall-hero" id="about-us-hero">

        <div class="page-inner">

          <section class="left-hero-content">

              <p class="subtitle">Who we are</p>
			  <h1>CDI Labs Culture</h1>

              <p>Our bright and vibrant company DNA shapes the identity of our amazing culture. As the first biotech company to be founded on the island, Co-founder and then CEO, Ignacio Pino has recruited the best and brightest team from Mayagüez, Puerto Rico. We continue to cultivate an environment where our employees thrive, feel valued, and contribute their best. CDI Labs now operates from labs and offices in Baltimore, Toronto, and Mayagüez.</p>

              <!--<a href="/company/careers" class="global-btn smooth-hover">CAREERS</a>-->

          </section>
              
        </div>

   </section>
    
<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/press-sticker.php'); ?>

   <section class="wide-section">
 
         <div class="page-inner">

             <div class="center-paragraph">
             
                <h2>About CDI Labs</h2>

                <p>CDI Labs is the result of intensive efforts and advances made by synthetic biologists at the Johns Hopkins University School of Medicine. With labs and offices in Mayaguez, Puerto Rico, Baltimore, and Toronto, CDI Labs was created <i>by</i> scientists <i>for</i> scientists to address critical needs required to accelerate research, advance discoveries, and translate discoveries into novel products and services that improve human health.</p>

                <p>CDI Labs has deep roots in Baltimore. Co-founders Jef Boeke, Heng Zhu, and Seth Blackshaw started the company while they worked as professors at Johns Hopkins University. The company had a facility located on campus in the Rangos Life Sciences Building, providing us close access to our expanding Scientific Advisory Board. All HuProt arrays are currently printed by scientists at our Baltimore facility.</p>


              </div>

          </div>

    </section>
    
    <section class="wide-section" id="history-section">

         <div class="page-inner narrow-section">

             <div class="center-paragraph">
             
                <h3>Our History</h3>

             </div>

             <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2001</li>
                        <li class="history-info">Co-founder Heng Zhu publishes his breakthrough paper featuring the first full eukaryotic proteome array with Michael Snyder</li>
                    </ul>
                  </div>
              </div>

              <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2008</li>
                        <li class="history-info">CDI Labs is founded to commercialize technologies 2008 created by the Johns Hopkins University School of Medicine</li>
                    </ul>
                  </div>
               </div>

               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2009</li>
                        <li class="history-info">Future Director of Proteomic Sciences Shaohui Hu publishes on initial HuProt&trade; technology with Heng Zhu</li>
                    </ul>
                  </div>
               </div>

               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2010</li>
                        <li class="history-info">First SBIR Grant<small>SBIR Phase 1 Grant: Development of an Attenuated Babesia Vaccine for Cattle.</small></li>
                    </ul>
                  </div>
               </div>

               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2010</li>
                        <li class="history-info">First STTR Grant<small>STTR Phase I grant awarded to produce and commercialize monoclonal antibodies used to study brain-expressed proteins that are implicated in human mental disorders. The antibodies were validated using CDI Labs' proprietary antigen microarrays.</small></li>
                    </ul>
                  </div>
               </div>

               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2011</li>
                        <li class="history-info">Additional funding<small>$800K note from the Puerto Rico Science Trust.</small></li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2012</li>
                        <li class="history-info">Major $13.5M NIH Roadmap grant to develop new reagents validated by HuProt&trade; microarrays</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2012</li>
                        <li class="history-info">First publication of finalized HuProt&trade; technology</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2013</li>
                        <li class="history-info">The first VirD&trade; prototype was developed in 2013 by CDI Labs' Director of Proteomic Sciences Shaohui Hu, working with Prashant Desai, Heng Zhu, and others at the Johns Hopkins University School of Medicine</li>
                    </ul>
                  </div>
               </div>
    
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2015</li>
                        <li class="history-info">CDI invited to attend White House Demo Day</li>
                    </ul>
                  </div>
               </div>
    
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2016</li>
                        <li class="history-info">Results of CDI’s work for the NIH Protein Capture Reagents Program are published in Nature Methods</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2016</li>
                        <li class="history-info">Additional STTR Grant<small>STTR Phase 1 Grant: Validation of immune-based biomarkers for endometriosis.</small></li>
                    </ul>
                  </div>
               </div>
               
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2016</li>
                        <li class="history-info">Additional STTR Grant<small>STTR Phase 1 Grant: Monospecific monoclonal antibodies against human protein complexes on an interactome- wide scale.</small></li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2018</li>
                        <li class="history-info">Collaborators use HuProt&trade; to show that patients' pre-treatment autoantibody fingerprints can predict adverse events to cancer immunotherapy</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2019</li>
                        <li class="history-info">Co-founder Heng Zhu publishes additional work on VirD™ membrane-embedded arrays</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2019</li>
                        <li class="history-info">Antygen&trade; brand launched</li>
                    </ul>
                  </div>
               </div>
               
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2019</li>
                        <li class="history-info">mMabs&trade; brand launched</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2020</li>
                        <li class="history-info">VirScan&trade; &amp; HuScan&trade; technologies launched<small>First commercial application of phage display immunoprecipitation sequencing technologies.</small></li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2020</li>
                        <li class="history-info">Products for SARS-CoV-2 research developed<small>Release of SARS-COV-2 HuProt&trade; and funding from Puerto Rico Science Trust to develop tests for the virus that causes COVID-19.</small></li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2023</li>
                        <li class="history-info">BroadOak Capital Partners Invests in CDI Laboratories to Expand and Scale Antibody Biomarker Discovery Platforms</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left">
                    <ul>
                        <li class="history-year">2024</li>
                        <li class="history-info">In March 2024, HuScan® PhIP-Seq register trademarked in the U.S.</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="right">
                    <ul>
                        <li class="history-year">2024</li>
                        <li class="history-info">In July 2024, VirScan® PhIP-Seq register trademarked in the U.S.</li>
                    </ul>
                  </div>
               </div>
             
               <div class="history-box">
                  <div class="left last-history-date">
                    <ul>
                        <li class="history-year">2024</li>
                        <li class="history-info">New VirScan®, HuScan® and MouseScan™ PhIP-Seq services by CDI Labs Canada launched on July 9</li>
                    </ul>
                  </div>
               </div>

          </div>

    </section>

    <section class="wide-section" id="map-puerto-rico-section">
    
        <div class="center-paragraph">
         
            <h2>Biotech Companies in Puerto Rico</h2>
            <p>Puerto Rico has been home to a diverse range of biotech companies, leveraging the island's strategic location, skilled workforce, and favorable incentives. The biotech sector in Puerto Rico encompasses various areas, including pharmaceuticals, medical devices, research and development, and contract manufacturing. Many global pharmaceutical giants have established a presence on the island, attracted by its unique blend of regulatory advantages and proximity to key markets. CDI Labs, based in Mayagüez (with labs and offices in Baltimore and Toronto), is proud to be among the many notable biotech companies operating in Puerto Rico.</p>
        </div>

        <div class="diagrams-wrapper">
            <ul class="diagram-mobile-nav">
                <li class="slide-left"><img src="/img/common/fig-slide-left.svg"></li>
                <li class="slide-right"><img src="/img/common/fig-slide-right.svg"></li>
            </ul>
            <div class="mobile-fig-wrapper">
               <div class="mobile-wrap">
                  <img src="/img/company/map-biotech-puerto-rico-01a.svg" />
               </div>
            </div>
                   
        </div>

    </section>
    
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
const slides=Array.from(document.querySelectorAll("#press-release .slide"));let slider=new Slider("#press-release",slides,"#press-release .slide.playing",document.querySelector("#press-release .slide-nav"),"#press-release .slide-btn","fade",5e3);function showWindow(e){const t=document.createElement("div");t.setAttribute("id","overlay"),document.getElementsByTagName("main")[0].append(t);document.getElementById(e).childNodes[1].classList.add("leadership-anim"),document.getElementById(e).style.display="block",document.getElementById(e).style.zIndex="1100"}function removeWindow(e){const t=document.getElementById(e).childNodes[1].classList;t.contains("leadership-anim")&&t.remove("leadership-anim"),document.getElementById(e).style.display="none";const s=document.getElementById("overlay");s&&s.remove()}slider.getPos(),slider.playLoop(),slider.setNav(),slider.currNavBtn(),slider.processNav(),slider.setArrows(),slider.getArrows(),window.onload=()=>{document.querySelectorAll(".leader-name").forEach((e=>{let t=e.getAttribute("href").slice(1);const s=document.getElementById(t).querySelector(".close-box");e.addEventListener("click",(e=>{e.preventDefault(),showWindow(t)})),s.addEventListener("click",(e=>{e.preventDefault(),removeWindow(t)}))}))};let timer,pos=0;var winW=window.innerWidth;pos=winW<515?820-winW:880-winW;<?php if(!$detect->isMobile() && !$detect->isTablet()){ ?>function toggleDiagram(){pos=0,winW=window.innerWidth,winW<515?pos=820-winW:pos=880-winW,clearInterval(timer),document.querySelectorAll(".mobile-wrap").forEach((e=>{e.style.transform="translateX(0)"}))}window.addEventListener("resize",(function(){toggleDiagram()}));<?php } ?>function animate(e,t,a){var n=0;timer=setInterval((function(){n++,"+"==t&&(e.style.transform="translateX(0)"),"-"==t&&(e.style.transform="translateX("+t+n+"px)"),n==a&&clearInterval(timer)}),10)}document.querySelectorAll(".diagram-mobile-nav li").forEach((e=>{e.addEventListener("click",(function(e){e.preventDefault(),clearInterval(timer),document.querySelectorAll(".mobile-wrap").forEach((e=>{e.style.transform="translateX(0)"}));var t=this.parentElement.parentElement.querySelector(".mobile-wrap");let a=t.getBoundingClientRect();this.classList.contains("slide-left")&&a.x<0&&animate(t,"+",pos),this.classList.contains("slide-right")&&a.x>0&&animate(t,"-",pos)}))}));
</script>
</body>
</html>
