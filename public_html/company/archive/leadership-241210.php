<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/leadership";
$PageCode = "060101";
$bodyid = "company";
$bodyClass= "clear-header";
$banner = $dbhelper->selectAll("SELECT type, title, eventurl as slugurl, NULL AS url,                              startmonth AS month, startday AS day, endday, year,                              filename FROM events WHERE status = 1 AND isSlide = 1
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
<title>Leadership | CDI Labs</title>
<meta name="description" content="Leadership, executives, board of directors, and scientific advisors for CDI Labs" />
<link rel="canonical" href="<?php echo $webhelper->Domain; ?>/company/leadership" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>body{background:#F0F0F0}</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

    <section class="hero-section short-hero" id="leadership-hero">

    <div class="page-inner">

          <section class="left-hero-content white-text">
 
              <p class="subtitle">CDI Labs</p>
              <h1>Leadership</h1>

          </section>
 
    </section>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/press-sticker.php'); ?>

    <section id="leadership-section" class="wide-section">

        <div class="page-inner narrow-section">

          <div class="center-paragraph">
              <h2>Executive Team</h2>
              <p>Our executive team has a combined history of successfully developing and commercializing novel technologies and services in biotech. At CDI Labs, we're dedicated to delivering antibody seromics solutions that deepen our understanding of human disease and aim to shift the future of healthcare and beyond.</p>
          </div>

          <div class="card-layout card4-wrapper">

            <div class="column-box">

                <div class="thmb-with-shadow">
                   <div class="center-icon">
                      <a class="leader-name hover-thmb" href="#saunders"><img src="/img/company/PIC-Saunders-01a.jpg" alt="Barnev E. Saunders, CDI Labs CEO" /><span class="download-hover"><em>VIEW BIO</em></span></a>
                    </div>
                </div>

                <h4>Barney E. Saunders, PhD</h4>
                <h5>CEO, Board Member</h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                  <div class="center-icon">
                    <a class="leader-name hover-thmb" href="#pino"><img src="/img/company/PIC-Pino-01a.jpg" alt="Ignacio Pino, COO, CDI Labs Co-founder, Board Member" /><span class="download-hover"><em>VIEW BIO</em></a>
                  </div>
                </div>

                <h4>Ignacio Pino, DVM</h4>
                <h5>COO, Co-founder, <span class="line-break">Board Member</span></h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                  <div class="center-icon">
                    <a class="leader-name hover-thmb" href="#hulett"><img src="/img/company/PIC-Hulett-01a.jpg" alt="Tyler Hulett, CDI Labs CSO" /><span class="download-hover"><em>VIEW BIO</em></a>
                  </div>
                </div>

                <h4>Tyler Hulett, PhD</h4>
                <h5>CSO</h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                  <div class="center-icon">
                    <a class="leader-name hover-thmb" href="#corliss"><img src="/img/company/PIC-Corliss-02d.jpg" alt="John Corliss, CDI Labs CFO" /><span class="download-hover"><em>VIEW BIO</em></a>
                  </div>
                </div>

                <h4>John Corliss</h4>
                <h5>CFO</h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                   <div class="center-icon">
                      <a class="leader-name hover-thmb" href="#grimley"><img src="/img/company/PIC-Grimley-01a.jpg" alt="Chris Grimley, CDI Labs Senior Vice President of Marketing"><span class="download-hover"><em>VIEW BIO</em></span></a>
                    </div>
                </div>

                <h4>Chris Grimley</h4>
                <h5>Senior Vice President <span class="line-break">of Marketing</span></h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                  <div class="center-icon">
                    <a class="leader-name hover-thmb" href="#paschke"><img src="/img/company/PIC-Paschke-01a.jpg" alt="Scott Paschke, CDI Labs Vice President of Business Development" /><span class="download-hover"><em>VIEW BIO</em></a>
                  </div>
                </div>

                <h4>Scott Paschke</h4>
                <h5>Vice President <span class="line-break">of Business Development</span></h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                  <div class="center-icon">
                    <a class="leader-name hover-thmb" href="#buell"><img src="/img/company/PIC-Buell-01a.jpg" alt="Ian Buell, CDI Labs Vice President of Sales Development" /><span class="download-hover"><em>VIEW BIO</em></a>
                  </div>
                </div>

                <h4>Ian Buell</h4>
                <h5>Vice President of Sales</h5>

             </div>

             <div class="column-box">

                <div class="thmb-with-shadow">
                  <div class="center-icon">
                    <a class="leader-name hover-thmb" href="#hu"><img src="/img/company/PIC-Hu-01a.jpg" alt="Shaohui Hu, CDI Labs Director of Proteomic Sciences" /><span class="download-hover"><em>VIEW BIO</em></a>
                  </div>
                </div>

                <h4>Shaohui Hu, PhD</h4>
                <h5>Director of <span class="line-break">Proteomic Sciences</span></h5>

             </div>
                 
             <div class="column-box">

                <div class="thmb-with-shadow">
                   <div class="center-icon">
                      <a class="leader-name hover-thmb" href="#boykin"><img src="/img/company/PIC-Boykin-01a.jpg" alt="Rich Boykin, CDI Labs VP of Informatics" /><span class="download-hover"><em>VIEW BIO</em></span></a>
                    </div>
                </div>

                <h4>Rich Boykin</h4>
                <h5>Vice President of Informatics</h5>

             </div>
                 
             <div class="column-box">

                <div class="thmb-with-shadow">
                   <div class="center-icon">
                      <a class="leader-name hover-thmb" href="#moon"><img src="/img/company/PIC-Moon-01j.jpg" alt="Paul Moon, CDI Labs VP of Brand Marketing" /><span class="download-hover"><em>VIEW BIO</em></span></a>
                    </div>
                </div>

                <h4>Paul Moon</h4>
                <h5>Vice President of Brand Marketing</h5>

             </div>

          </div>
                 
        </div>

     </section>

     <section class="wide-section board-section no-margin">
       
       <div class="page-inner narrow-section">

         <div class="center-paragraph">

           <h2>Board of Directors</h2>

         </div>

         <div class="card-layout card5-wrapper">

           <div class="col">

              <h4>Jef Boeke, PhD</h4>
              <h5>Co-founder, Board Member <span class="line-break">SAB Member</span></h5>
              <a class="leader-name" href="#boeke">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Jon Brennan-Badal</h4>
              <h5>Board Member</h5>
              <a class="leader-name" href="#badal">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Ignacio Pino DVM</h4>
              <h5>Co-founder, Board Member</h5>
              <a class="leader-name" href="#pino">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Antoine de Marsily</h4>
              <h5>Board Member</h5>
              <a class="leader-name" href="#marsily">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Aaron Fisher</h4>
              <h5>Board Member</h5>
              <a class="leader-name" href="#fisher">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Barney E. Saunders, PhD</h4>
              <h5>Board Member</h5>
              <a class="leader-name" href="#saunders">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>
             
             <div class="col">

              <h4>Jeffrey Rossio, PhD</h4>
              <h5>SAB Member, Board Observer</h5>
              <a class="leader-name" href="#rossio">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Sean Reusch</h4>
              <h5>Board Observer</h5>
              <a class="leader-name" href="#reusch">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

          </div>

       </div>

     </section>

     <section class="wide-section board-section">
       
       <div class="page-inner narrow-section">

         <div class="center-paragraph">

           <h2>Scientific Advisory Board</h2>

         </div>

         <div class="card-layout card5-wrapper">

           <div class="col">

              <h4>Heng Zhu, PhD</h4>
              <h5>Co-founder, SAB Member</h5>
              <a class="leader-name" href="#zhu">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Jef Boeke, PhD</h4>
              <h5>Co-founder, Board Member <span class="line-break">SAB Member</span></h5>
              <a class="leader-name" href="#boeke">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Daniel Eichinger, PhD</h4>
              <h5>Co-founder, SAB Member</h5>
              <a class="leader-name" href="#eichinger">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Seth Blackshaw, PhD</h4>
              <h5>Co-founder, SAB Member</h5>
              <a class="leader-name" href="#blackshaw">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Prashant Desai, PhD</h4>
              <h5>SAB Member</h5>
              <a class="leader-name" href="#desai">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

            <div class="col">

              <h4>Jeffrey Rossio, PhD</h4>
              <h5>SAB Member, Board Observer</h5>
              <a class="leader-name" href="#rossio">View Bio<svg class='small-right-arrow' viewBox='0 0 24 24'><path d='M0 0h24v24H0V0z' fill='none'/><path d='M10.02 6L8.61 7.41 13.19 12l-4.58 4.59L10.02 18l6-6-6-6z'/></svg></a>

            </div>

         </div>

       </div>

     </section>

     <section id="saunders" class="leadership-box">

           <div class="leadership-text">

             <h4>Barney E. Saunders, PhD<em>CEO</em></h4>

             <p class="bold">Barney is CEO of CDI Labs, serving since July 2023.</p>

             <p>Barney brings three decades of leadership experience and is passionate about scaling and commercializing life science tools, and diagnostics businesses. Prior to CDI Labs, Barney was CEO of Purigen Biosystems where the team, launched the Ionic® System for preparing nucleic acid from valuable clinical specimens and ultra-long DNA templates. At NanoString Technologies, he headed Sales and Marketing, driving strong revenue growth that supported the company’s IPO. As VP and GM at Agilent Technologies, Barney led the team that launched the first full genome arrays for human, rat, and mouse and Agilent’s array CGH solutions. Barney began his career with Amersham International, which was acquired by General Electric. He holds a PhD in Molecular Biology from Birmingham University, England.</p>

             <a class="close-box" href="#">X</a>

           </div>

         </section>

         <section id="pino" class="leadership-box">

          <div class="leadership-text">

             <h4>Ignacio Pino, DVM<em>COO, Co-founder, Board Member</em></h4>

             <p class="bold">Ignacio is a co-founder, and Chief Operating Officer of CDI Labs and has been developing and commercializing monoclonal antibodies and proteomic tools since co-founding the company. Ignacio led CDI Labs as President and CEO for many years, establishing sites in Mayaguez, Puerto Rico, and Baltimore, MD. He built successful academic and industrial partnerships across the US, Europe, China, South Korea, and the Caribbean. Ignacio, and the team, established the mMabs monoclonal antibody development pipeline at CDI Labs and HuProt, the world’s most comprehensive protein microarray.</p>
             
             <p>Ignacio successfully raised angel and private investments, and secured over $11.5 million in local and NIH grants for CDI Labs. This included funding to develop highly-specific monoclonal antibodies in collaboration with Johns Hopkins University, and funding to produce commercial HIV vaccines in collaboration with the University of Puerto Rico, Mayaguez.  He and the team have developed HuProt, VirD, and PhIP-Seq services that transform how ligands, antibodies, and drugs that bind human membrane proteins, are screened to develop novel biomarkers and drug targets.
             </p>
             <p>A graduate of the University of Puerto Rico, Mayaguez, Ignacio earned a DVM from the Ross University School of Veterinary Medicine in St. Kitts, followed by clinical training at Kansas State University.  Prior to founding CDI Labs, he ran a veterinary consultation business, and conducted tick-borne disease and vaccine research at University Products, LLC.  Ignacio was a Guayacán Tech Fellow at the MIT Entrepreneurship Development Program, and represented CDI Labs at the first White House Demo Day, hosted by President Barack Obama.</p>

             <a class="close-box" href="#">X</a>

           </div>

         </section>

         <section id="hulett" class="leadership-box">

          <div class="leadership-text">

           <h4>Tyler Hulett, PhD<em>CSO</em></h4>
              
           <p class="bold">Tyler has been the Chief Scientific Officer for CDI Labs since January 2023. In this role, Tyler focuses on advancing the field of autoantibody seromics by developing a portfolio of platforms and services that enable CDI clients to access previously inaccessible seromic data. He hopes that by raising awareness about the importance of autoantibody signatures, other scientists will be able to use CDI technologies to unlock novel diagnoses and treatments for human disease. Tyler helps clients accelerate their research in diverse areas, including autoimmunity, cancer, neurological and neurodegenerative disease, genetic conditions, and ageing.</p>
              
           <p>Before becomming CSO, Tyler was the Director of Immuno-Oncology and Biomarker Development at CDI Labs. He holds an undergraduate degree in biochemistry from the University of Notre Dame and a PhD in Molecular Microbiology and Immunology from Oregon Health &amp; Science University. He trained in cancer immunotherapy at the Earle A. Chiles Research Institute (EACRI) of the Providence Portland Cancer Center studying antigen-specific autoantibody and T-cell responses to cancer vaccines.</p>

           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="corliss" class="leadership-box">

          <div class="leadership-text">

           <h4>John Corliss<em>CFO</em></h4>
             
           <p class="bold">John Corliss has more than 20 years of experience across strategic finance and operations, including 15 years in the life science research tools industry.</p>
           <p>Most recently, John spent seven years with Standard BioTools where he supported a dynamic commercial organization as VP of Commercial Financial Planning &amp; Analysis and then running its field service business as VP of Global Service &amp; Sales Operations. He has served as head of finance in several startups and in divisions of Agilent Technologies. He began his career in the field of corporate finance at the investment bank, William Blair &amp; Co. John holds a BA in Economics from the University of Chicago and an MBA from the Wharton School.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="grimley" class="leadership-box">

          <div class="leadership-text">

           <h4>Chris Grimley<em>Senior Vice President of Marketing</em></h4>
              
           <p class="bold">Chris brings over 25 years of experience in the life science industry to his role at CDI Labs.</p>
           <p>Prior to joining CDI Labs Chris was Chief Commercial Officer at Purigen Biosystems (acquired by Bionano) where he built the commercial team that launched the company’s Ionic® System and consumables portfolio. At Labcyte Inc. (acquired by Beckman Life Sciences) Chris was Vice President of Marketing, and he held the same position at NanoString Technologies during which time the company completed its IPO. Chris also held commercial leadership roles at Agilent Technologies, managing the company’s genomics portfolio, and Applied Biosystems (now part of Thermo Fisher Scientific) where he held positions of increasing responsibility in the company’s real-time PCR business. He holds a Bachelor of Science degree in Biochemistry from San Francisco State University.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="paschke" class="leadership-box">

          <div class="leadership-text">

           <h4>Scott Paschke<em>Vice President of Business Development</em></h4>
             
           <p class="bold">Scott Paschke is CDI Labs’ Vice President of Sales and Business Development. With over 20 years of experience in the biotechnology sector working with renowned R&amp;D reagent companies, Scott leads our business and commercial strategy to help clients accelerate their research and discoveries with CDI Labs’ innovative tools.</p>
           <p>Scott received a BA in biology and a MA in biochemistry from State University College at Buffalo. Prior to joining CDI Labs, Scott was Director of Business Development at Active Motif, and was President and Chief Technology Officer at Lake Placid Biologics. He also held leadership positions at Serologicals Corporation, Lake Placid Biologicals and Upstate Inc.  Scott’s background in fundraising, biotechnology licensing and tech transfer was instrumental in shaping CDI Labs’ business plan for an initial round of fund-raising. In addition to directing sales and marketing and business development, he also works closely with staff scientists on operational issues.  Scott has played a key role in creating partnerships between academic researchers and CDI Labs, helping them commercialize innovative products.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="buell" class="leadership-box">

          <div class="leadership-text">

           <h4>Ian Buell<em>Vice President of Sales</em></h4>
             
           <p class="bold">Ian brings over 25 years of experience in life science sales and management to his role at CDI Labs.</p>
           <p>Prior to joining CDI Labs Ian was Sr. Director of Sales at NanoString where over his 12 year career helped build the commercial sales team. During his tenure NanoString went IPO, the commercial team launched: Prosigna, a DX test for the risk of recurrence of Breast cancer, the GeoMx system for spatial biology as well as the CosMx system, a spatial sub-cellular system. Prior to NanoString Ian had varying positions in molecular sales at Eppendorf, Roche and Genome Therapeutics.  He holds a Bachelor of Science degree in Microbiology from the University of New Hampshire.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="hu" class="leadership-box">

          <div class="leadership-text">

           <h4>Shaohui Hu, PhD<em>Director of Proteomic Sciences</em></h4>
             
           <p class="bold">Shaohui Hu is one of the original co-developers of the HuProt human proteome microarray.</p>
           <p>With over 15 years of experience in high-throughput studies of networks and pathways using protein microarray technology, Dr. Hu supervises the proteomic research activities and client projects at CDI, including high-throughput subcloning and protein purification, protein microarray production and applications in biomarker discovery, protein-protein, -RNA, -DNA interactions, antibody specificity characterization and substrate identification, etc. Dr. Hu is also in charge of the optimization and troubleshooting of array products and services, as well as development of new technologies and products.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>
                 
         <section id="boykin" class="leadership-box">

          <div class="leadership-text">

           <h4>Rich Boykin<em>Vice President of Informatics</em></h4>
             
           <p class="bold">Rich brings over 25 years of Informatics experience and 20+ years of leadership and management to his role at CDI Labs.</p>
           <p>Prior to joining CDI Labs, Rich was Chief of Bioinformatics at NanoString. Over his 15-year career at NanoString, he helped build the Bioinformatics systems - from software development to infrastructure. He was also responsible for building a team from a department of 1 to a team of 25 across multiple different functions (commercial focus, assay / content development, biostatistics, software development, and computational biology). In addition to building out the analytics teams and processes, Rich was also involved in developing assays for all 3 platforms (nCounter, GeoMx, and CosMx) and holds patents on novel applications for the nCounter platform (miRNA assay, infectious disease detection, fusion detection). Prior to NanoString, Rich held varying positions in Informatics/Bioinformatics, including Pathogenesis, Chiron, and Novartis.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>
                 
         <section id="moon" class="leadership-box">

          <div class="leadership-text">

           <h4>Paul Moon<em>Vice President of Brand Marketing</em></h4>
             
           <p class="bold">Paul has over 19 years experience in brand marketing, marketing operations, and marketing communications for biotech and tech industries throughout Seattle and the Bay Area, including 7 years in tech documentation for Fred Hutchinson Cancer Research Center.</p>
           <p>Prior to CDI Labs, Paul was the Head of Brand Marketing at Berkeley Lights (acquired by Bruker), Head of Brand Marketing at Purigen Biosystems (acquired by Bionano), and Director of Marketing Communications at Labcyte (acquired by Danaher). As a proven leader in commercial / marketing operations, he has been instrumental in building and elevating numerous brands to prominent recognition, resulting in positive growth and results across key marketing ROIs. He is a hands-on leader in building and scaling robust marketing infrastructures, and also creates and oversees all aspects of downstream marketing campaigns and programs. He has also held leadership roles at Personalis, NanoString, Advanced Microscopy Group (acquired by Thermo Fisher) and JDSU (now VIAVI). He holds a BA degree in Biology from Baylor University.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="boeke" class="leadership-box">

          <div class="leadership-text">

           <h4>Jef Boeke, PhD<em>Co-founder, Board Member, SAB Member</em></h4>
             
           <p class="bold">Jef is a co-founder of CDI Labs, and the Founding Director of the Institute for Systems Genetics at NYU Langone Medical Center. His foundational work on retrotransposition led to technological innovations in genetics, genomics and synthetic biology, used to study how retrotransposition affects human reproductive cells, non-reproductive cells, and cancer.  Jef also leads the Synthetic Yeast Genome Project, an international and collaborative effort aiming to design and build the 16 synthetic chromosomes of the world’s first designer eukaryotic cell.</p>
           <p>A graduate of Bowdoin College, Jef received a PhD in Molecular Biology from the Rockefeller University, followed by postdoctoral work at MIT/Whitehead Institute. He was on the faculty of the Department of Molecular Biology &amp; Genetics at the Johns Hopkins University School of Medicine from 1986-2014, where he also founded the High Throughput Biology Center.  He is a co-founder of the biotechnology companies Avigen and CDI Labs, and was elected to the National Academy of Sciences in 2013.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="badal" class="leadership-box">

          <div class="leadership-text">

           <h4>Jon Brennan-Badal<em>Board Member</em></h4>
             
           <p class="bold">Jon Brennan-Badal is the CEO of Opentrons, leading business operations, strategy and growth.</p>
           <p>Previously, Badal worked at Amazon as the Director of Strategy at comiXology (exited to Amazon in 2014). As an early employee at comiXology, he helped the company become the leading platform for discovering, buying, and reading digital comic books and the #1 Top Grossing non-game iPad app. Prior to comiXology, Badal was an analyst at early-stage VC Rose Tech Ventures. He graduated from Columbia University as a history major</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="marsily" class="leadership-box">

          <div class="leadership-text">

           <h4>Antoine de Marsily<em>Board Member</em></h4>
             
           <p class="bold">Antoine de Marsily is the Managing Director at Independent Capital LL, in San Juan, Puerto Rico.  He represented Apollo Ventures, the lead investor of CDI’s Series A round. He has also served as the Executive Vice President at Grupo VL, LLC since 2011. Formerly, he was Executive Vice President at Alara Pharmaceutical Corp, and VP of Operations at Mova Pharmaceutical Corp.  Antonine received a degree in aerospace, aeronautical and astronautical engineering from WSU.  He also received an MBA and a Masters in International Economics and Management from SDA Bocconi in Italy. A native of France, Antoine is the Honorary Consul for France in Puerto Rico.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="fisher" class="leadership-box">

          <div class="leadership-text">

           <h4>Aaron Fisher<em>Board Member</em></h4>
             
           <p class="bold">Aaron Fisher is a Vice President at BroadOak Capital Partners, where he originates, executes, and manages growth capital investments.  Aaron has a finance background and extensive experience working with companies in the healthcare ecosystem, from early-stage to middle-market.</p>
           <p>He previously worked as a private equity investment professional with Northwood Healthcare Partners and H.I.G. Growth Partners, and played a key role in incubating Envision Genomics, a clinical genomics business focused on rare diseases, which was a HudsonAlpha Institute of Biotechnology associate company. Aaron began his career as an investment banking analyst with Stephens, Inc. He holds a B.S. from the McIntire School of Commerce at the University of Virginia, as well as an M.B.A. from the Wharton School at the University of Pennsylvania.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="rossio" class="leadership-box">

          <div class="leadership-text">

           <h4>Jeffrey Rossio, PhD<em>SAB Member, Board Observer</em></h4>
             
           <p class="bold">Jeff has extensive experience in biotechnology, immunology, and molecular biology. He held many roles over 20 years at the NIH/National Cancer Institute where he lead core facilities and immune monitoring laboratories related to pivotal AIDS and cancer research. He is an Emeritus Professor at Hood College, Frederick, Maryland.</p>
           <p>His industry career led him to Invitrogen Corporation, now Thermo-Fisher Scientific, where Dr. Rossio additionally served in leadership roles including as a Sr. Manager for Research and Development, managing the day-to-day operations of R&amp;D groups, supervising and coordinating software development groups and technical support functions, and advising on immunological aspects of product development.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="reusch" class="leadership-box">

          <div class="leadership-text">

           <h4>Sean Reusch<em>Board Member</em></h4>
             
           <p class="bold">Sean Reusch represents BroadOak where he is a Vice President and focused on growth capital investing activities.</p>
           <p>Sean was previously a Principal at Sombra Capital Management, a private investment firm focused on investment opportunities in the healthcare services and life science tools and diagnostics industries. Prior to Sombra, Sean spent seven years as a healthcare investor at PAR Capital Management, where he was part of a two-person team managing more than $1 billion of public and private healthcare investments.</p>
           <p>Sean holds a BBA from the University of Michigan – Ross School of Business and an MBA from the Massachusetts Institute of Technology – Sloan School of Management.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="zhu" class="leadership-box">

          <div class="leadership-text">

           <h4>Heng Zhu, PhD<em>Co-founder, SAB Member</em></h4>
             
           <p class="bold">Heng is a co-founding member of the CDI Labs. He is a professor in the Department of Pharmacology at Johns Hopkins Medical School. A graduate of Beijing University, he earned his PhD at Clemson University with Ralph Dean, followed by postdoctoral work at Yale with Mike Snyder, where he created the first proteome microarray for a eukaryote. This work was eventually licensed by Invitrogen to create their ProtoArray.  Heng’s large-scale studies of protein networks using protein arrays have led to many unique technological innovations, including both the high-density Human Proteome Microarray (HuProtTM) and VirDTM array technologies now produced at CDI Labs.</p>
           <p>In addition to his studies on the functions of large networks of proteins, Heng has used proteomics to understand how microbes and viruses sustain themselves within human hosts. In the area of human disease biomarker discovery, Heng works closely with international collaborators and has published studies on human autoimmune diseases (Inflammatory Bowel Disease), infectious disease (including SARS, herpes, Zika, and dengue), chronic conditions (Parkinson’s and Alzheimer’s diseases) and human cancers (including lung, ovarian, stomach and glioma).</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="eichinger" class="leadership-box">

          <div class="leadership-text">

           <h4>Daniel Eichinger<em>Co-founder, SAB Member</em></h4>
             
           <p class="bold">Dan is CDI Labs’ CSO-emeritus and a co-founder. He received his PhD from the NYU School of Medicine, and did post-doctoral research at the Johns Hopkins University School of Medicine.  Prior to joining CDI Labs, he was chair of the Department of Parasitology at NYU Medical School.  With almost 30 years of experience at the NYU School of Medicine and Johns Hopkins University School of Medicine, Dan’s academic interests spanned molecular biology, genetics, and immunology of bacteria, yeast and medically-relevant parasitic diseases such as malaria, amebiasis and trypanosomiasis.</p>
           <p><em>"Most satisfying to me about CDI Labs is being able to help combine long-established and cutting-edge proteomics technologies to generate protein products of a quality that was not previously possible, and making those products available to the basic and applied research community I was once part of. In a few short years, those products have led to a large, and growing, number of scientific and medical discoveries."</em></p>
           <p>At CDI Labs, Dan develops microarray and ELISA-based platforms that take advantage of both the highly-specific monoclonal antibodies and a high-content human protein arrays that are manufactured at CDI Labs.  An expert in monoclonal antibody development and in recombinant protein development and production, Dan played a critical role in building CDI Labs’ FAST-MabTM platform. His work at CDI has contributed to disease biomarker discoveries in lung cancer, creation of multiplex biomarker panels for distinguishing Dengue and Zika viral infections, as well as creation of the VirDTM array and characterization of monoclonal antibody binding kinetics.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="blackshaw" class="leadership-box">

          <div class="leadership-text">

           <h4>Seth Blackshaw<em>Co-founder, SAB Member</em></h4>
             
           <p class="bold">Seth Blackshaw is a professor of neuroscience, neurology and ophthalmology at the Johns Hopkins School of Medicine, and a member of the Institute for Cell Engineering. A co-founding member of CDI Labs, he collaborated with Professor Heng Zhu to create HuProt&trade;, the human proteome microarray. </p>
           <p><em>"I helped co-create HuProtTM because I was interested in getting the best quality tools, including monoclonal antibodies, into the hands of the biomedical research community."</em></p>
           <p>Prof. Blackshaw received degrees in biochemistry from the University of Chicago and a PhD in Neuroscience from Johns Hopkins School of Medicine, and performed postdoctoral research at Harvard Medical School. His research has focused on the regulation of cell fate specification and neuronal regeneration in retina and hypothalamus, hypothalamic regulation of innate behaviors such as sleep and feeding, and the development of new tools for functional proteomics.  He also led a collaborative CDI Labs – Johns Hopkins effort under a five-year NIH-funded effort to generate ultraspecific, protein microarray-validated, monoclonal antibodies.</p>
           <p>He has received numerous awards, including the Sloan Foundation Research Fellowship, the Esther A. and Joseph Klingenstein Fellowship in the Neurosciences, and the W. M. Keck Foundation Distinguished Young Scholar in Medical Research Award.</p>
           <a class="close-box" href="#">X</a>

          </div>

         </section>

         <section id="desai" class="leadership-box">

          <div class="leadership-text">

           <h4>Prashant Desai, PhD<em> SAB Member</em></h4>
             
           <p class="bold">Prashant is an associate professor at the Department of Oncology at the Johns Hopkins School of Medicine, and is based at the Johns Hopkins Sidney Kimmel Comprehensive Cancer Center.  He studies Herpes Simplex 1 virus (HSV-1), with an eye towards elucidating virus-encoded functions in the infectious pathway that are suitable for anti-viral drug treatment.</p>
           <p>In collaboration with CDI Labs and Professor Heng Zhu at Johns Hopkins, Prashant has also developed an innovative, high-content Virion Display (VirDTM) array to display G-protein-coupled receptors (GPCRs) on the lipid envelope of the herpesvirus virion. This diverse group of cell surface receptor proteins act as an inbox for messages in the form of light, energy, peptides, lipids, sugars, and proteins. While they have long been viewed with great interest as potential targets for drug treatment, they have been difficult to study as they require membranes to fold and function properly. The VirD-GPCR array is the first-complete tool for screening small molecule drugs and protein affinity reagents in high-throughput. Prashant hopes this will lead to the discovery of useful new ligands, and eventually therapeutics that can bind to these elusive receptor proteins.</p>
           <a class="close-box" href="#">X</a>

          </div>

    </section>

</main>

<?php 
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>
<script>
const slides=Array.from(document.querySelectorAll("#press-release .slide"));let slider=new Slider("#press-release",slides,"#press-release .slide.playing",document.querySelector("#press-release .slide-nav"),"#press-release .slide-btn","fade",5e3);function showWindow(e){const t=document.createElement("div");t.setAttribute("id","overlay"),document.getElementsByTagName("main")[0].append(t);document.getElementById(e).childNodes[1].classList.add("leadership-anim"),document.getElementById(e).style.display="block",document.getElementById(e).style.zIndex="1100",document.getElementById(e).style.overflow="scroll"}function removeWindow(e){const t=document.getElementById(e).childNodes[1];document.getElementById(e).style.overflow="hidden";const l=t.classList;l.contains("leadership-anim")&&l.remove("leadership-anim"),document.getElementById(e).style.display="none";const s=document.getElementById("overlay");s&&s.remove()}slider.getPos(),slider.playLoop(),slider.setNav(),slider.currNavBtn(),slider.processNav(),slider.setArrows(),slider.getArrows(),window.onload=()=>{document.querySelectorAll(".leader-name").forEach((e=>{let t=e.getAttribute("href").slice(1);const l=document.getElementById(t).querySelector(".close-box");e.addEventListener("click",(e=>{e.preventDefault(),showWindow(t)})),l.addEventListener("click",(e=>{e.preventDefault(),removeWindow(t)}))}))};
</script>
</body>
</html>
