<body id="<?php if(isset($bodyid)) echo $bodyid; ?>">

<header role="banner">

    <div id="main-header-wrap">

     <section id="social-header">

        <div class="page-inner">

            <div class="right">

                <div id="connect-social">
                    <ul>
                        <li>Follow Us</li>
                        <li><a href="https://www.linkedin.com/company/cdi-labs" aria-label="Linkedin Icon" class="social-icon" id="in-header" target="_blank"><svg class="smooth-hover" viewBox="0 0 24 24"><path d="M8 19h-3v-10h3v10zm11 0h-3v-5.342c0-1.392-.496-2.085-1.479-2.085-.779 0-1.273.388-1.521 1.165v6.262h-3s.04-9 0-10h2.368l.183 2h.062c.615-1 1.598-1.678 2.946-1.678 1.025 0 1.854.285 2.487 1.001.637.717.954 1.679.954 3.03v5.647z"/><ellipse cx="6.5" cy="6.5" rx="1.55" ry="1.5"/></svg></a></li>
                        <li><a href="https://x.com/cdi_labs" class="social-icon" aria-label="Twitter Icon" id="tw-header" target="_blank"><svg class="smooth-hover" viewBox="0 0 16 16"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/></svg></a></li>
                        <li><a href="https://www.youtube.com/@CDILabs" aria-label="YouTube Icon" class="social-icon" id="yt-header" target="_blank"><svg class="smooth-hover" viewBox="0 0 512 512"><path d="M508.64 148.79c0-45-33.1-81.2-74-81.2C379.24 65 322.74 64 265 64h-18c-57.6 0-114.2 1-169.6 3.6C36.6 67.6 3.5 104 3.5 149 1 184.59-.06 220.19 0 255.79q-.15 53.4 3.4 106.9c0 45 33.1 81.5 73.9 81.5 58.2 2.7 117.9 3.9 178.6 3.8q91.2.3 178.6-3.8c40.9 0 74-36.5 74-81.5 2.4-35.7 3.5-71.3 3.4-107q.34-53.4-3.26-106.9zM207 353.89v-196.5l145 98.2z"/></svg></a></li>
                        <li><a href="https://www.facebook.com/cdilaboratories/" aria-label="Facebook Icon" class="social-icon" id="fb-header" target="_blank"><svg class="smooth-hover" viewBox="0 0 32 32"><path d="M12.6,16.1v11.6c0,0.2,0.1,0.3,0.3,0.3h4.6c0.2,0,0.3-0.1,0.3-0.3V15.9h3.4c0.2,0,0.3-0.1,0.3-0.3l0.3-3.6  c0-0.2-0.1-0.3-0.3-0.3h-3.7V9.2c0-0.6,0.5-1.1,1.2-1.1h2.6C21.9,8.1,22,8,22,7.8V4.3C22,4.1,21.9,4,21.7,4h-4.4  c-2.6,0-4.7,1.9-4.7,4.3v3.4h-2.3c-0.2,0-0.3,0.1-0.3,0.3v3.6c0,0.2,0.1,0.3,0.3,0.3h2.3V16.1z"/></svg></a></li>
                    </ul>

                 </div>

                <div id="global-search" role="search" data-ss360="true">
                    <i id="searchButton" role="searchButton"><svg viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></i>
                    <input type="text" name="query" id="searchBox" placeholder="Search...">
                </div> 

            </div>

        </div>
         
     </section>

     <div id="nav-header-bg"></div>
    
      <section id="nav-header" class="<?php echo $bodyClass; ?>">

        <div id="nav-wrap">

             <div id="logo-wrap">

              <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/logos/cdi-header-logo.php'); ?>

              <button id="hamburger-btn" aria-label="Hamburger Button" class="hamburger hamburger--collapse" type="button">
                  <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                  </span>
              </button>

              </div>
              
              <nav id="main-nav">

                <div id="main-nav-wrap">
                
                    <ul id="outer-ul">
                        
                        <li class="main-link" data-hover="lab-services">

                           <a href="#" class="main-nav-link smooth-hover">LAB SERVICES <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>
                           </a>
                        
                           <ul id="gnb-lab-services" class="sub-menu card4-wrapper category-sub cat-with-heading">

                               <ul class="ul-with-circles">
                                   <li class="nav-app-heading">Service Platforms</li>
                                   <li><a href="/services/service-platforms" class="smooth-hover">OVERVIEW</a></li>
                                   <li><a href="/services/huprot-microarray" class="smooth-hover">HuProt&trade; <span class="nav-category">Services</span></a></li>
                                   <li><a href="/services/vird-membrane-protein-array" class="smooth-hover">VirD&trade; <span class="nav-category">GPCR Services</span></a></li>
                                   <li><a href="<?php echo $webhelper->DomainCA; ?>/services/virscan-phip-seq" class="cdi-canada smooth-hover">VirScan&reg; <span class="nav-category">Services*</span></a></li>
                                   <li><a href="<?php echo $webhelper->DomainCA; ?>/services/huscan-phip-seq" class="cdi-canada smooth-hover">HuScan&reg; <span class="nav-category">Services*</span></a></li>
                                   <li><a href="<?php echo $webhelper->DomainCA; ?>/services/peptide-hormone-phip-seq" class="cdi-canada smooth-hover">Peptide Hormone <span class="nav-category">Services*</span></a></li>
                                   <li><a href="<?php echo $webhelper->DomainCA; ?>/services/mousescan-phip-seq" class="cdi-canada smooth-hover">MouseScan&trade; <span class="nav-category">Services*</span></a></li>
                                   <li><a href="<?php echo $webhelper->DomainCA; ?>/services/tech-access-program-custom-phip-seq" class="cdi-canada smooth-hover">Tech Access Program<span class="nav-category line-break">Custom PhIP-Seq Libraries*</span></a></li>
                               </ul>
                               <ul class="ul-with-circles">
                                   <li class="nav-app-heading">Autoantibody Profiling Services</li>
                                   <li><a href="/services/autoantibody-seromics" class="smooth-hover">OVERVIEW</a></li>
                                   <li><a href="/services/biomarker-discovery" class="smooth-hover">Biomarker Discovery</a></li>
                                   <li><a href="/services/patient-stratification" class="smooth-hover">Patient Stratification</a></li>
                                   <li><a href="/services/patient-response" class="smooth-hover">Patient Response / Adverse Reaction Prediction</a></li>
                                   <li><a href="/services/diagnostic-development" class="smooth-hover">Diagnostic Development</a></li>
                                   <li><a href="/services/vaccine-development" class="smooth-hover">Vaccine Development and Safety</a></li>
                                   <li><a href="/services/viral-exposure-profiling" class="smooth-hover">Viral Exposure Profiling</a></li>
                               </ul>
                               <ul class="ul-with-circles">
                                <li class="nav-app-heading">Target ID Services</li>
                                   <li><a href="/services/target-id" class="smooth-hover">OVERVIEW</a></li>
                                   <li><a href="/services/protein-protein-interactions" class="smooth-hover">Protein-Protein Interactions</a></li>
                                   <li><a href="/services/protein-nucleic-acid-interactions" class="smooth-hover">Protein-Nucleic Acid Interactions</a></li>
                                   <li><a href="/services/target-discovery" class="smooth-hover">Target Deconvolution / Target Discovery</a></li>
                                   <li><a href="/services/antibody-specificity-validation" class="smooth-hover">Antibody Specificity Validation</a></li>
                                   <li><a href="/services/post-translational-modification" class="smooth-hover">Post-translational Modification Specificity Testing</a></li>
                                   <li><a href="/services/chemically-induced-proximity" class="smooth-hover">Chemically Induced Proximity (CIP)</a></li>
                               </ul>

                               <ul class="ul-with-circles">
                                <li class="nav-app-heading">Disease Areas</a></li>
                                   <li><a href="/services/seromics-disease-areas" class="smooth-hover">OVERVIEW</a></li>
                                   <li><a href="/services/autoimmune-disease" class="smooth-hover">Autoimmune Disease</a></li>
                                   <li><a href="/services/oncology" class="smooth-hover">Oncology</a></li>
                                   <li><a href="/services/neurological-disease" class="smooth-hover">Neurological Disease</a></li>
                                   <li><a href="/services/infectious-disease" class="smooth-hover">Infectious Disease</a></li>
                                   <li><a href="/services/genetic-disease" class="smooth-hover">Genetic Disease</a></li>
                               </ul>

                               <ul class="middle-note">
                                   <li class="menu-note">* Provided exclusively by CDI Labs Canada.</li>
                               </ul>

                           </ul>
                    
                        </li>

                        <li class="main-link" data-hover="cro-services">
                        
                           <a href="#" class="main-nav-link smooth-hover">SPECIALIZED CRO SERVICES <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></a>

                           <ul id="gnb-cro-services" class="sub-menu single-menu category-sub cat-with-heading">

                               <ul class="ul-with-circles">
                                <li class="nav-app-heading">Specialized CRO Services</li>
                                   <li><a href="/services/cro-services" class="smooth-hover">OVERVIEW</a></li>
                                   <li><a href="/services/antibody-development" class="smooth-hover">Antibody Development</a></li>
                                   <li><a href="/services/antibody-pairs" class="smooth-hover">Antibody Pairs</a></li>
                                   <li><a href="/services/protein-production" class="smooth-hover">Protein Production</a></li>
                                   <li><a href="/services/cell-therapy-immunogenicity" class="smooth-hover">Cell Therapy Immunogenicity Testing</a></li>
                                   <li><a href="/services/crispr-cas9-immunogenicity" class="smooth-hover">CRISPR-Cas9 Immunogenicity Testing</a></li>
                                   <li><a href="/services/post-translational-modification" class="smooth-hover">Post-translational Modification Specificity Profiling</a></li>
                                   <li><a href="/services/diagnostic-development" class="smooth-hover">Diagnostic Development</a></li>
                               </ul>

                           </ul>
                
                        </li>

                        <li class="main-link" data-hover="products">
                        
                           <a href="#" class="main-nav-link smooth-hover">PROTEOMICS TECHNOLOGIES <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></a>

                           <ul id="gnb-platforms" class="sub-menu card5-wrapper category-sub">

                               <ul class="ul-with-circles">
                                <li><a href="/products/huprot-microarray" class="smooth-hover"><svg viewBox="0 0 108 108"><defs><linearGradient id="hp-icon" x1="54" x2="54" y1="106.29" y2="1.71" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#354c5e"/><stop offset=".11" stop-color="#354e63"/><stop offset=".63" stop-color="#365875"/><stop offset="1" stop-color="#375c7c"/></linearGradient></defs><circle cx="54" cy="54" r="52.29" style="fill:url(#hp-icon)"/><path d="M59.39 88.88c-2.57 0-4.74-1.74-5.4-4.1a5.618 5.618 0 0 1-5.4 4.1c-3.09 0-5.6-2.51-5.6-5.6V57.82l-1.47 2.45c-1.59 2.65-5.04 3.5-7.69 1.91-1.28-.77-2.18-2-2.54-3.45-.36-1.45-.14-2.96.64-4.24l7.86-13.08c2.57-4.26 7.24-6.91 12.2-6.91h.45c-3.54-.72-6.21-3.86-6.21-7.6 0-4.28 3.48-7.76 7.76-7.76s7.76 3.48 7.76 7.76c0 3.75-2.67 6.89-6.21 7.6H56c4.96 0 9.64 2.65 12.2 6.91l7.87 13.09c.77 1.28 1 2.78.63 4.24a5.562 5.562 0 0 1-2.54 3.45c-2.65 1.6-6.09.74-7.69-1.91l-1.49-2.47v25.48c0 3.09-2.51 5.6-5.6 5.6Zm-7.76-24.16h4.73v18.55c0 1.67 1.36 3.03 3.03 3.03s3.03-1.36 3.03-3.03V48.55l6.26 10.38c.86 1.43 2.73 1.9 4.16 1.03.69-.42 1.18-1.08 1.38-1.87.2-.79.07-1.6-.34-2.29l-7.87-13.09c-2.1-3.49-5.94-5.66-10-5.66H52c-4.07 0-7.9 2.17-10 5.66L34.14 55.8a2.97 2.97 0 0 0-.34 2.29c.2.79.68 1.45 1.38 1.87 1.43.86 3.3.4 4.16-1.03l6.24-10.39v34.73c0 1.67 1.36 3.03 3.03 3.03s3.03-1.36 3.03-3.03V64.72Zm2.36-43.03c-2.86 0-5.19 2.33-5.19 5.19s2.33 5.19 5.19 5.19 5.19-2.33 5.19-5.19-2.33-5.19-5.19-5.19Z" style="fill:#fff"/></svg><span class="nav-app-heading"><em>HuProt</em>&trade; Microarray</span><span class="line-break">Contains <em class="p-number">21,000+</em> Full-length Human Proteins</span></a></li>
                               </ul>
                               
                               <ul class="ul-with-circles">

                                    <li><a href="/products/vird-membrane-protein-array" class=" smooth-hover"><span class="nav-app-heading"><svg viewBox="0 0 108 108"><defs><linearGradient id="vird-icon" x1="54" x2="54" y1="106.29" y2="1.71" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#3a624d"/><stop offset=".02" stop-color="#3b634e"/><stop offset=".42" stop-color="#4b7a6d"/><stop offset=".76" stop-color="#56887f"/><stop offset="1" stop-color="#5a8e86"/></linearGradient></defs><circle cx="54" cy="54" r="52.29" style="fill:url(#vird-icon)"/><path d="M54.01 82.7c-2.6 0-4.71-2.11-4.71-4.71v-1.23c0-2.32-1.5-3.77-2.91-4.35-1.41-.58-3.49-.62-5.13 1.02l-.88.88c-.89.89-2.07 1.38-3.33 1.38s-2.44-.49-3.33-1.38a4.72 4.72 0 0 1 0-6.67l.86-.87c1.65-1.65 1.61-3.73 1.03-5.14-.58-1.41-2.03-2.91-4.35-2.91h-1.23c-2.6 0-4.71-2.11-4.71-4.71s2.11-4.71 4.71-4.71h1.23c2.32 0 3.77-1.5 4.36-2.91.58-1.4.62-3.49-1.02-5.12l-.88-.88a4.72 4.72 0 0 1 0-6.67c.89-.89 2.07-1.38 3.33-1.38s2.44.49 3.33 1.38l.87.86c1.65 1.65 3.73 1.61 5.14 1.03 1.41-.58 2.91-2.03 2.91-4.35v-1.23c0-2.6 2.11-4.71 4.71-4.71s4.71 2.11 4.71 4.71v1.23c0 2.32 1.5 3.77 2.91 4.35 1.41.58 3.49.62 5.13-1.02l.88-.88c.89-.89 2.07-1.38 3.33-1.38s2.44.49 3.33 1.38a4.72 4.72 0 0 1 0 6.67l-.88.88c-1.64 1.64-1.6 3.73-1.02 5.13.58 1.41 2.03 2.91 4.35 2.91h1.23c2.6 0 4.71 2.11 4.71 4.71s-2.11 4.71-4.71 4.71h-1.22c-2.32 0-3.77 1.5-4.35 2.91-.58 1.41-.62 3.49 1.02 5.14l.88.88a4.72 4.72 0 0 1 0 6.67c-.89.89-2.07 1.38-3.33 1.38s-2.44-.49-3.33-1.38l-.88-.88c-1.64-1.64-3.73-1.6-5.13-1.02-1.41.58-2.91 2.03-2.91 4.35V78c0 2.6-2.11 4.71-4.71 4.71Zm-9.47-13.25c.94 0 1.9.19 2.83.57 2.77 1.15 4.49 3.73 4.49 6.73v1.23c0 1.18.96 2.14 2.14 2.14s2.14-.96 2.14-2.14v-1.23c0-3 1.72-5.58 4.49-6.73 2.77-1.15 5.81-.54 7.94 1.58l.88.88c.84.84 2.2.84 3.03 0 .84-.84.84-2.2 0-3.03l-.88-.88c-2.12-2.12-2.73-5.16-1.58-7.94 1.15-2.77 3.73-4.49 6.73-4.49h1.22c1.18 0 2.14-.96 2.14-2.14s-.96-2.14-2.14-2.14h-1.23c-3 0-5.58-1.72-6.73-4.49-1.15-2.77-.54-5.81 1.58-7.94l.88-.88c.84-.84.84-2.2 0-3.03-.81-.81-2.22-.81-3.03 0l-.88.88c-2.12 2.12-5.16 2.73-7.94 1.58-2.77-1.15-4.49-3.73-4.49-6.73v-1.23c0-1.18-.96-2.14-2.14-2.14s-2.14.96-2.14 2.14v1.23c0 3-1.72 5.58-4.49 6.73-2.77 1.15-5.81.54-7.94-1.58l-.87-.86c-.84-.84-2.2-.84-3.03 0-.84.84-.84 2.2 0 3.03l.88.88c2.12 2.12 2.72 5.15 1.57 7.92-1.15 2.77-3.73 4.5-6.73 4.5h-1.23c-1.18 0-2.14.96-2.14 2.14s.96 2.14 2.14 2.14h1.23c3 0 5.58 1.72 6.73 4.49 1.15 2.77.54 5.81-1.58 7.94l-.86.87c-.84.84-.84 2.2 0 3.04s2.22.81 3.03 0l.88-.88c1.41-1.41 3.23-2.15 5.1-2.15ZM59.14 63c-2.13 0-3.85-1.73-3.85-3.85s1.73-3.85 3.85-3.85 3.85 1.73 3.85 3.85S61.26 63 59.14 63Zm0-5.14c-.71 0-1.28.58-1.28 1.28s.58 1.28 1.28 1.28 1.28-.58 1.28-1.28-.58-1.28-1.28-1.28ZM50.57 57c-3.54 0-6.42-2.88-6.42-6.42s2.88-6.42 6.42-6.42 6.42 2.88 6.42 6.42S54.11 57 50.57 57Zm0-10.28c-2.13 0-3.85 1.73-3.85 3.85s1.73 3.85 3.85 3.85 3.85-1.73 3.85-3.85-1.73-3.85-3.85-3.85Z" style="fill:#fff"/></svg><em>VirD</em>&trade; GPCR Proteins</span><span class="line-break">Contains<em class="p-number">291</em> Non-odorant GPCRs</span></a></li>
                                                               
                               </ul>

                               <ul class="ul-with-circles">

                                <li><a href="<?php echo $webhelper->DomainCA; ?>/products/virscan-phip-seq" class="cdi-canada smooth-hover"><svg viewBox="0 0 108 108"><defs><linearGradient id="vs-icon" x1="54" x2="54" y1="106.29" y2="1.71" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#575356"/><stop offset=".32" stop-color="#6b405d"/><stop offset=".72" stop-color="#7d2f64"/><stop offset="1" stop-color="#842967"/></linearGradient></defs><circle cx="54" cy="54" r="52.29" style="fill:url(#vs-icon)"/><path d="M54.01 82.7c-2.6 0-4.71-2.11-4.71-4.71v-1.23c0-2.32-1.5-3.77-2.91-4.35-1.4-.58-3.49-.62-5.13 1.02l-.88.88c-.89.89-2.07 1.38-3.33 1.38s-2.44-.49-3.33-1.38a4.72 4.72 0 0 1 0-6.67l.86-.87c1.65-1.65 1.61-3.73 1.03-5.14-.58-1.41-2.03-2.91-4.35-2.91h-1.23c-2.6 0-4.71-2.11-4.71-4.71s2.11-4.71 4.71-4.71h1.23c2.32 0 3.77-1.5 4.36-2.91.58-1.4.62-3.49-1.02-5.12l-.88-.88a4.72 4.72 0 0 1 0-6.67 4.708 4.708 0 0 1 6.66 0l.87.86c1.65 1.65 3.74 1.61 5.14 1.03 1.41-.58 2.91-2.03 2.91-4.35v-1.23c0-2.6 2.11-4.71 4.71-4.71s4.71 2.11 4.71 4.71v1.23c0 2.32 1.5 3.77 2.91 4.35 1.41.58 3.49.62 5.14-1.02l.88-.88c.89-.89 2.07-1.38 3.33-1.38s2.44.49 3.33 1.38a4.72 4.72 0 0 1 0 6.67l-.88.88c-1.64 1.64-1.6 3.73-1.02 5.13s2.03 2.91 4.35 2.91h1.23c2.6 0 4.71 2.11 4.71 4.71s-2.11 4.71-4.71 4.71h-1.22c-2.32 0-3.77 1.5-4.36 2.91-.58 1.41-.62 3.49 1.02 5.13l.88.88a4.72 4.72 0 0 1 0 6.67c-.89.89-2.07 1.38-3.33 1.38s-2.44-.49-3.33-1.38l-.88-.88c-1.64-1.64-3.73-1.61-5.13-1.02-1.41.58-2.91 2.03-2.91 4.35v1.23c0 2.6-2.11 4.71-4.71 4.71Zm-9.47-13.25c.94 0 1.9.19 2.83.57 2.77 1.15 4.49 3.73 4.49 6.73v1.23c0 1.18.96 2.14 2.14 2.14s2.14-.96 2.14-2.14v-1.23c0-3 1.72-5.58 4.49-6.73 2.77-1.15 5.81-.54 7.93 1.58l.88.88c.84.84 2.2.84 3.03 0s.84-2.2 0-3.03l-.88-.88c-2.12-2.12-2.73-5.16-1.58-7.94s3.73-4.49 6.73-4.49h1.22c1.18 0 2.14-.96 2.14-2.14s-.96-2.14-2.14-2.14h-1.23c-3 0-5.58-1.72-6.73-4.49-1.15-2.77-.54-5.81 1.58-7.94l.88-.88c.84-.84.84-2.2 0-3.03-.81-.81-2.22-.81-3.03 0l-.88.88c-2.12 2.12-5.16 2.73-7.94 1.58-2.77-1.15-4.49-3.73-4.49-6.73v-1.23c0-1.18-.96-2.14-2.14-2.14s-2.14.96-2.14 2.14v1.23c0 3-1.72 5.58-4.49 6.73-2.77 1.15-5.81.54-7.94-1.58l-.87-.86c-.84-.84-2.2-.84-3.03 0-.84.84-.84 2.2 0 3.03l.88.88c2.12 2.12 2.72 5.15 1.57 7.92-1.15 2.77-3.73 4.5-6.73 4.5H30c-1.18 0-2.14.96-2.14 2.14s.96 2.14 2.14 2.14h1.23c3 0 5.58 1.72 6.73 4.49 1.15 2.77.54 5.81-1.58 7.94l-.86.87c-.84.84-.84 2.2 0 3.04s2.22.81 3.03 0l.88-.88c1.41-1.41 3.23-2.15 5.1-2.15Zm14.6-6.46c-2.13 0-3.85-1.73-3.85-3.85s1.73-3.85 3.85-3.85 3.85 1.73 3.85 3.85-1.73 3.85-3.85 3.85Zm0-5.14c-.71 0-1.28.58-1.28 1.28s.58 1.28 1.28 1.28 1.28-.58 1.28-1.28-.58-1.28-1.28-1.28ZM50.57 57c-3.54 0-6.42-2.88-6.42-6.42s2.88-6.42 6.42-6.42 6.42 2.88 6.42 6.42S54.11 57 50.57 57Zm0-10.28c-2.13 0-3.85 1.73-3.85 3.85s1.73 3.85 3.85 3.85 3.85-1.73 3.85-3.85-1.73-3.85-3.85-3.85Z" style="fill:#fff"/></svg><span class="nav-app-heading"><em>VirScan</em>&reg; PhIP-Seq*</span><span class="line-break">Detect antibodies against <em class="p-number">68,000+</em> Viral Protein Sequences</span></a></li>

                               </ul>

                               <ul class="ul-with-circles">

                                <li><a href="<?php echo $webhelper->DomainCA; ?>/products/huscan-phip-seq" class="cdi-canada smooth-hover"><svg viewBox="0 0 108 108"><defs><linearGradient id="hs-icon" x1="54" x2="54" y1="106.29" y2="1.71" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#575356"/><stop offset=".32" stop-color="#6b405d"/><stop offset=".72" stop-color="#7d2f64"/><stop offset="1" stop-color="#842967"/></linearGradient></defs><circle cx="54" cy="54" r="52.29" style="fill:url(#hs-icon)"/><path d="M59.39 88.88c-2.57 0-4.74-1.74-5.4-4.1a5.618 5.618 0 0 1-5.4 4.1c-3.09 0-5.6-2.51-5.6-5.6V57.82l-1.47 2.45a5.61 5.61 0 0 1-7.69 1.91 5.61 5.61 0 0 1-1.91-7.69l7.86-13.08c2.57-4.26 7.24-6.91 12.2-6.91h.45c-3.54-.72-6.21-3.86-6.21-7.6 0-4.28 3.48-7.76 7.76-7.76s7.76 3.48 7.76 7.76c0 3.75-2.67 6.89-6.21 7.6h.46c4.96 0 9.64 2.65 12.2 6.91l7.87 13.09c.77 1.28 1 2.78.63 4.24a5.562 5.562 0 0 1-2.54 3.45c-1.28.77-2.78 1-4.24.64a5.562 5.562 0 0 1-3.45-2.54l-1.49-2.47V83.3c0 3.09-2.51 5.6-5.6 5.6Zm-7.76-24.16h4.73v18.55c0 1.67 1.36 3.03 3.03 3.03s3.03-1.36 3.03-3.03V48.55l6.26 10.38a3.037 3.037 0 0 0 4.16 1.03c.69-.42 1.18-1.08 1.38-1.87.2-.79.07-1.6-.34-2.29l-7.87-13.09c-2.1-3.49-5.93-5.66-10-5.66H52c-4.07 0-7.9 2.17-10 5.66l-7.86 13.08c-.86 1.43-.4 3.3 1.03 4.16 1.43.86 3.3.4 4.16-1.03l6.24-10.39v34.73c0 1.67 1.36 3.03 3.03 3.03s3.03-1.36 3.03-3.03V64.71Zm2.36-43.03c-2.86 0-5.19 2.33-5.19 5.19s2.33 5.19 5.19 5.19 5.19-2.33 5.19-5.19-2.33-5.19-5.19-5.19Z" style="fill:#fff"/></svg><span class="nav-app-heading"><em>HuScan</em>&reg; PhIP-Seq*</span><span class="line-break">Detect antibodies against <em class="p-number">48,921</em> Human Proteins and Isoforms</span></a></li>

                               </ul>

                               <ul class="ul-with-circles">

                                   <li><a href="<?php echo $webhelper->DomainCA; ?>/products/mousescan-phip-seq" class="cdi-canada smooth-hover"><svg id="Layer_1" viewBox="0 0 108 108"><defs><linearGradient id="linear-gradient" x1="54" x2="54" y1="106.29" y2="1.71" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#575356"/><stop offset=".32" stop-color="#6b405d"/><stop offset=".72" stop-color="#7d2f64"/><stop offset="1" stop-color="#842967"/></linearGradient class=".ms-icon"></defs><circle cx="54" cy="54" r="52.29" style="fill:url(#linear-gradient)"/><path d="M77.85 35.56c-2.72-4.3-5.08-8.01-2.55-15.05a.961.961 0 1 0-1.81-.65c-2.85 7.92-.14 12.2 2.73 16.72 2.74 4.32 5.56 8.78 4.24 17.22-.78-2.47-2.09-4.87-3.94-7.04-4.8-5.63-14.06-10.01-24.68-4.37-.96-2.35-2.89-3.96-5.11-3.96-1.18 0-2.28.46-3.2 1.24-.94-.8-2.05-1.24-3.21-1.24-3.18 0-5.77 3.3-5.77 7.37 0 .3.01.59.04.88-.44.17-.88.34-1.32.53-8.22 3.59-13.08 10.01-11.07 14.62 1.79 4.09 8.6 5.17 16.2 2.58.23-.08.47-.04.66.09.11.08.29.25.29.57v.66a5.77 5.77 0 0 0-4.8 5.67c0 .53.43.96.96.96.03 0 .07 0 .1-.01h22.27s.03.01.05.01h13.89c2.24 0 4.31-.96 5.69-2.63 2.6-3.15 3.84-6.98 3.77-10.89 3.5-12.34-.19-18.17-3.46-23.32ZM36.49 45.81c0-3 1.72-5.45 3.84-5.45.69 0 1.36.27 1.95.77-.71 1.1-1.18 2.48-1.29 3.98-1.47.16-2.98.47-4.5.93 0-.08-.01-.16-.01-.23Zm39.56 22.73c-1.01 1.23-2.55 1.94-4.21 1.94H59.43a8.664 8.664 0 0 1 10.46-3.99c.5.18 1.05-.09 1.23-.59a.966.966 0 0 0-.59-1.23 10.586 10.586 0 0 0-13.23 5.8H36.62a3.838 3.838 0 0 1 3.71-2.88h4.8a.96.96 0 0 0 0-1.92h-3.84v-.58c0-.86-.4-1.63-1.09-2.13-.69-.49-1.59-.63-2.4-.35-6.42 2.19-12.49 1.52-13.82-1.53-1.53-3.5 3.08-9.04 10.07-12.09 2.34-1.02 4.74-1.69 7-1.95.11.83.32 1.63.64 2.36.21.49.78.71 1.26.5.49-.21.71-.78.5-1.26-.37-.85-.56-1.82-.56-2.82 0-1.65.52-3.12 1.34-4.12.03-.03.06-.07.09-.11.66-.76 1.5-1.22 2.42-1.22 2.12 0 3.84 2.44 3.84 5.45s-1.72 5.45-3.84 5.45a.96.96 0 0 0 0 1.92c3.18 0 5.77-3.3 5.77-7.37 0-.52-.04-1.02-.12-1.51 9.77-5.4 18.29-1.43 22.68 3.71 4.39 5.14 6.57 13.76.99 20.52Z" class="ms-icon"/><path d="M35.53 72.91c-.81 0-1.47-.66-1.47-1.47v-.09c.01-2.85 2.01-5.34 4.8-6.01v-.24s0-.1-.08-.15a.231.231 0 0 0-.19-.03c-7.87 2.68-14.94 1.48-16.84-2.86-2.13-4.87 2.85-11.59 11.33-15.3.33-.14.66-.28.99-.41 0-.18-.01-.36-.01-.54 0-4.35 2.82-7.88 6.28-7.88 1.14 0 2.24.38 3.21 1.1.97-.72 2.06-1.1 3.2-1.1 2.21 0 4.22 1.43 5.36 3.77 10.7-5.41 20.03-.87 24.82 4.74 1.38 1.61 2.48 3.36 3.29 5.21.56-6.94-1.97-10.93-4.42-14.79-2.94-4.64-5.71-9.01-2.78-17.17.27-.76 1.12-1.16 1.89-.89.37.13.67.4.84.76.17.36.19.76.05 1.13-2.45 6.8-.16 10.41 2.5 14.59l-.43.28.43-.28c3.31 5.22 7.06 11.15 3.54 23.66.06 4.14-1.28 7.99-3.89 11.15-1.48 1.79-3.7 2.82-6.09 2.82H35.55Zm3.14-9.03c.25 0 .5.08.72.23.32.23.5.59.5.99v1.09l-.43.07c-2.53.43-4.37 2.6-4.38 5.16 0 .26.2.46.45.46h36.31c2.08 0 4.01-.89 5.29-2.45 2.46-2.99 3.73-6.63 3.65-10.55v-.08l.02-.07c3.44-12.12-.19-17.85-3.39-22.9l.43-.28-.44.27c-2.8-4.41-5.21-8.22-2.6-15.49.04-.11.03-.23-.02-.34a.435.435 0 0 0-.25-.23.45.45 0 0 0-.57.27c-2.76 7.69-.12 11.86 2.68 16.27 2.78 4.39 5.66 8.93 4.32 17.57l-.34 2.17-.66-2.1c-.78-2.48-2.07-4.78-3.84-6.86-4.61-5.4-13.67-9.76-24.04-4.25l-.5.27-.22-.53c-.92-2.25-2.7-3.64-4.63-3.64-1.02 0-2.01.39-2.87 1.12l-.33.29-.33-.28c-.86-.73-1.85-1.12-2.87-1.12-2.9 0-5.25 3.07-5.25 6.85 0 .28.01.56.04.83l.04.39-.36.14c-.43.17-.87.34-1.3.53-7.96 3.48-12.7 9.6-10.8 13.95 1.67 3.84 8.22 4.8 15.57 2.3.13-.05.27-.07.41-.07Zm33.17 7.11H58.56l.42-.77a9.165 9.165 0 0 1 8.03-4.75c1.05 0 2.08.17 3.05.52.23.08.49-.04.57-.27.04-.11.03-.23-.02-.34a.435.435 0 0 0-.25-.23c-1.08-.38-2.2-.57-3.35-.57-4.02 0-7.65 2.39-9.24 6.09l-.13.31H35.95l.17-.64c.5-1.92 2.23-3.26 4.21-3.26h4.8c.25 0 .45-.2.45-.45s-.2-.45-.45-.45h-4.36v-1.09c0-.69-.32-1.31-.88-1.71-.56-.4-1.28-.5-1.93-.28-6.78 2.31-13 1.53-14.46-1.81-.82-1.88-.14-4.28 1.92-6.75 1.98-2.37 4.97-4.51 8.42-6.02 2.37-1.03 4.84-1.72 7.15-1.99l.5-.06.07.5c.1.79.31 1.54.6 2.22.05.11.14.19.25.24.11.04.23.04.34 0 .11-.05.19-.13.24-.25.04-.11.04-.23 0-.34-.4-.91-.61-1.96-.61-3.03 0-1.7.53-3.32 1.45-4.45l.1-.12c.78-.9 1.78-1.39 2.8-1.39 2.4 0 4.36 2.67 4.36 5.96s-1.96 5.96-4.36 5.96c-.25 0-.45.2-.45.45s.2.45.45.45c2.9 0 5.25-3.07 5.25-6.85 0-.47-.04-.95-.12-1.42l-.06-.36.32-.18c10.06-5.56 18.85-1.41 23.32 3.83 4.52 5.3 6.76 14.19.99 21.18-1.11 1.35-2.79 2.12-4.6 2.12Zm-11.48-1.03h11.48c1.51 0 2.9-.63 3.81-1.75 5.39-6.54 3.27-14.88-.98-19.86-4.17-4.89-12.34-8.76-21.73-3.76.05.41.08.82.08 1.23 0 4.35-2.82 7.88-6.28 7.88-.81 0-1.47-.66-1.47-1.48s.66-1.47 1.47-1.47c1.84 0 3.33-2.21 3.33-4.93s-1.49-4.93-3.33-4.93c-.93 0-1.62.57-2.03 1.04 0 .02-.05.07-.1.12-.75.92-1.2 2.31-1.2 3.77 0 .93.18 1.83.52 2.62.16.36.16.76.02 1.13s-.42.65-.78.81c-.36.16-.76.16-1.13.02a1.4 1.4 0 0 1-.81-.79c-.27-.62-.47-1.29-.6-1.99-2.07.29-4.26.92-6.36 1.85-3.26 1.42-6.19 3.52-8.04 5.74-1.77 2.13-2.42 4.2-1.77 5.68 1.2 2.76 7.12 3.32 13.18 1.25.97-.33 2.03-.17 2.86.42.83.59 1.31 1.52 1.31 2.55v.07h3.33c.81 0 1.47.66 1.47 1.47s-.66 1.47-1.47 1.47h-4.8c-1.28 0-2.42.73-2.98 1.85h19.61c1.82-3.9 5.72-6.4 10.04-6.4 1.27 0 2.51.21 3.7.63.37.13.67.4.84.75.17.36.19.76.06 1.13-.27.77-1.11 1.17-1.88.9-.87-.31-1.78-.46-2.71-.46a8.13 8.13 0 0 0-6.65 3.45ZM36.01 46.73l-.02-.67c0-.14-.01-.19-.01-.25 0-3.29 1.96-5.96 4.36-5.96.8 0 1.59.31 2.29.89l.34.29-.25.38c-.69 1.06-1.1 2.36-1.21 3.74l-.03.43-.43.05c-1.44.15-2.92.46-4.41.91l-.64.19Zm4.32-5.85c-1.73 0-3.16 1.97-3.32 4.48 1.18-.32 2.36-.56 3.51-.71.14-1.22.51-2.38 1.08-3.38-.41-.26-.84-.39-1.27-.39Z" class="ms-icon"/></svg><span class="nav-app-heading"><em>MouseScan</em>&trade; PhIP-Seq* </span><span class="line-break">Detect antibodies against <em class="p-number">50,135</em> Murine Proteins and Isoforms</span></a></li>
                                   
                                </ul>

                               <ul class="middle-note">
                                <li class="menu-note">* Provided exclusively by CDI Labs Canada.</li>
                               </ul>

                           </ul>
                
                        </li>

                        <li class="main-link" data-hover="bioinformatics">
                        
                           <a href="#" class="main-nav-link smooth-hover">BIOINFORMATICS <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></a>

                           <ul id="gnb-bioinformatics" class="sub-menu single-menu category-sub cat-with-heading">

                               <ul class="ul-with-circles">
                                <li class="nav-app-heading">Bioinformatics</li>
                                   <li><a href="/bioinformatics/" class="smooth-hover">OVERVIEW</a></li>
                               </ul>

                           </ul>
                
                        </li>


                        <li class="main-link" data-hover="resources">
                  
                        <a href="#" class="main-nav-link smooth-hover">RESOURCES <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></a>
                        <ul id="gnb-resources" class="sub-menu">
                            <ul class="ul-with-circles single-menu">
                                <li><a href="/resources/literature" class="smooth-hover">Resources</a></li>
                                <li><a href="/resources/literature?page=1&category=content" class="smooth-hover">Library Content</a></li>
                                <li><a href="/resources/publications" class="smooth-hover">Publications</a></li>
                                <li><a href="/resources/videos" class="smooth-hover">Videos and Webinars</a></li>
                                <li><a href="/resources/faqs" class="smooth-hover">FAQs</a></li>
                            </ul>
                        </ul>
                    
                         </li>
                      
                        <li class="main-link" data-hover="news">
                      
                            <a href="/news-events/news" class="main-nav-link smooth-hover">NEWS &nbsp;&amp;&nbsp; EVENTS <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></a>
                            <ul id="gnb-news" class="sub-menu">
                            <ul class="ul-with-circles single-menu">
                                <li><a href="/blogs" class="smooth-hover">Blogs</a></li>
                                <li><a href="/news-events/events" class="smooth-hover">Events</a></li>
                                <li><a href="/news-events/news" class="smooth-hover">News</a></li>
                            </ul>
                            </ul>
                        
                        </li>

                        <li class="main-link" data-hover="company">
                        
                        <a href="#" class="main-nav-link smooth-hover">COMPANY <svg class="arrow-down" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></a>
                        <ul id="gnb-company" class="sub-menu">
                            <ul class="ul-with-circles single-menu">
                                <li><a href="/company/about-us" class="smooth-hover">About Us</a></li>
                                <li><a href="/company/leadership" class="smooth-hover">Leadership</a></li>
                                <li><a href="/company/team" class="smooth-hover">Meet CDI Labs</a></li>
                                <li><a href="<?php echo $webhelper->DomainCA; ?>/services/tech-access-program-custom-phip-seq" class="cdi-canada smooth-hover">Tech Access <span class="mobile-break">Program</span><span class="line-break">Custom PhIP-Seq Libraries*</span></a></li>
                                <li><a href="/testimonials/" class="smooth-hover">Customer <span class="mobile-break">Testimonials</span></a></li>
                                <li><a href="/company/contact-cdi" class="smooth-hover">Contact Us</a></li>
                                <li><a href="/company/signup-form" class="smooth-hover">Sign-up for Our eNews</a></li>
                                <li><a href="/company/privacy-policy" class="smooth-hover">Privacy Policy</a></li>
                            </ul>
                       </ul>
                
                       </li>
                       
                       <li class="mobile-contact"><a href="/company/contact-cdi" class="global-btn contact-btn smooth-hover">CONTACT US</a></li>
                               
                    </ul>

                </div>

                <div id="nav-bkg"></div>
                
            </nav>  

        </div>  

      </section>
      <!-- //main-header -->
    </div>
    <!-- //main-header-wrap -->

</header>

<dialog id="cdi-canada-popup">

   <div id="cdi-canada-logo">
    <svg viewBox="0 0 177.9 42.5"><path d="M32.81 7.73c1.06-1.92 2.5-3.41 4.34-4.48 1.83-1.07 3.88-1.61 6.14-1.61 2.75 0 5.11.65 7.07 1.96s3.39 3.15 4.29 5.52h-2.89c-.71-1.67-1.78-2.97-3.23-3.92-1.45-.94-3.19-1.41-5.24-1.41-1.81 0-3.44.42-4.89 1.27-1.45.85-2.58 2.06-3.4 3.65-.82 1.59-1.23 3.43-1.23 5.52 0 2.09.41 3.93 1.23 5.5.82 1.58 1.96 2.79 3.4 3.63 1.45.85 3.07 1.27 4.89 1.27 2.05 0 3.79-.46 5.24-1.39 1.45-.93 2.52-2.22 3.23-3.86h2.89c-.89 2.35-2.33 4.17-4.3 5.47-1.98 1.29-4.33 1.94-7.06 1.94-2.26 0-4.3-.53-6.14-1.61-1.83-1.07-3.28-2.56-4.34-4.46-1.06-1.91-1.59-4.07-1.59-6.49s.53-4.59 1.59-6.5zM73.91 3.4c1.95.99 3.45 2.41 4.48 4.27 1.03 1.86 1.55 4.07 1.55 6.63 0 2.54-.52 4.73-1.55 6.58-1.04 1.85-2.53 3.26-4.48 4.23-1.95.98-4.29 1.46-7.02 1.46h-7.3V1.92h7.3c2.73 0 5.07.5 7.02 1.48zm.83 18.44c1.8-1.8 2.7-4.31 2.7-7.53 0-3.25-.9-5.78-2.7-7.6-1.8-1.82-4.42-2.73-7.85-2.73h-4.83v20.57h4.83c3.43-.01 6.05-.91 7.85-2.71zM87 1.92v24.66h-2.47V1.92H87zM104.81 24.57h8.85v2.01h-11.32V1.92h2.47v22.65zM131.52 20.73H120.3l-2.15 5.86h-2.61l9-24.34h2.79l8.96 24.34h-2.61l-2.16-5.86zm-.75-2.05L125.9 5.34l-4.87 13.34h9.74zM155.33 15.96c.96 1.15 1.45 2.49 1.45 4.02 0 1.25-.31 2.37-.93 3.37-.62 1-1.53 1.79-2.73 2.36-1.2.58-2.63.86-4.3.86h-8.54V1.92h8.29c2.49 0 4.39.58 5.7 1.73 1.31 1.15 1.96 2.65 1.96 4.48 0 1.53-.41 2.77-1.23 3.72-.82.95-1.88 1.62-3.18 1.99 1.37.27 2.54.97 3.51 2.12zm-12.6-3.14h5.75c1.67 0 2.96-.39 3.86-1.18.91-.79 1.36-1.88 1.36-3.26 0-1.36-.45-2.43-1.36-3.21-.9-.78-2.22-1.17-3.96-1.17h-5.64v8.82zm10.07 10.41c1-.85 1.5-2.01 1.5-3.49 0-1.48-.52-2.66-1.57-3.55-1.05-.88-2.45-1.32-4.22-1.32h-5.79v9.63h5.89c1.8 0 3.2-.42 4.19-1.27zM164.55 25.98c-1.23-.56-2.2-1.35-2.91-2.36-.71-1.01-1.08-2.14-1.13-3.39h2.61c.12 1.2.65 2.25 1.59 3.16.94.91 2.32 1.36 4.13 1.36 1.67 0 2.99-.43 3.97-1.29.98-.86 1.46-1.95 1.46-3.26 0-1.06-.27-1.91-.81-2.56a4.957 4.957 0 0 0-2.01-1.45c-.8-.32-1.91-.66-3.32-1.04-1.65-.45-2.95-.88-3.92-1.31-.96-.42-1.79-1.08-2.47-1.98-.68-.89-1.02-2.1-1.02-3.63 0-1.27.33-2.4.99-3.4.66-1 1.59-1.78 2.79-2.35 1.2-.56 2.58-.85 4.13-.85 2.28 0 4.12.56 5.52 1.68 1.4 1.12 2.2 2.56 2.42 4.32h-2.68c-.16-1.01-.72-1.91-1.66-2.7-.94-.79-2.21-1.18-3.81-1.18-1.48 0-2.72.39-3.7 1.18-.99.79-1.48 1.86-1.48 3.23 0 1.04.27 1.87.81 2.5.54.63 1.22 1.12 2.03 1.45.81.33 1.91.68 3.3 1.06 1.6.45 2.89.89 3.88 1.32.99.44 1.82 1.1 2.5 1.99.68.89 1.02 2.09 1.02 3.6 0 1.15-.31 2.25-.92 3.28-.61 1.04-1.52 1.87-2.72 2.5-1.2.64-2.63.95-4.3.95-1.62.02-3.05-.26-4.29-.83z" class="logoca0"/><circle cx="9.26" cy="5.61" r=".97" class="logoca1"/><path d="M18.11 19.76v6.37c0 .41-.05.46-.47.46h-1.7c-.44 0-.53-.09-.53-.52 0-2.62.07-10.3.05-11.51v-.24c0-.35-.09-.63-.36-.9-1.7-1.67-3.38-3.36-5.06-5.05l-.13-.13c-.15-.17-.16-.29 0-.45.49-.5.94-1.03 1.48-1.49.11-.09.19-.11.31-.03.1.07.19.17.28.25.62.62 4.61 4.54 5.09 5.09.32.37.72.68.9 1.16.08.22.15.42.15.66-.01 2.11-.01 4.22-.01 6.33zM18.73 13.55c0-.56.22-1.02.59-1.44.44-.51 5.33-5.4 5.77-5.76.2-.17.25-.19.43-.02.29.27 1.15 1.21 1.34 1.36.3.23.25.38.02.59-.28.26-4.1 4.16-5.25 5.26a.87.87 0 0 0-.28.67c0 1.09.09 10.33.09 11.74v.24c-.02.24-.17.39-.41.39h-1.89c-.29 0-.38-.1-.38-.38v-2.53c-.03-1.3-.03-8.05-.03-10.12z" class="logoca0"/><path d="M9.03 7.85c.08 0 .19.06.27.15.34.42 2.38 2.38 2.98 3.01.3.32.62.62.93.93.1.09.11.17.03.28-.22.32-.51.58-.79.84-.13.12-.35.09-.49-.06-.23-.22-3.73-3.79-3.91-3.92-.13-.07-.15-.21-.04-.35.23-.3.52-.54.78-.81.06-.06.13-.08.24-.07zM24.57 13.13c-.1.01-.16-.03-.22-.09l-.7-.7c-.13-.13-.14-.27-.03-.42.06-.08 3.38-3.45 3.88-3.92.23-.21.33-.22.56 0 .21.21.43.41.64.62.18.18.2.29.02.49-.17.2-.36.39-.56.57-.24.22-3.2 3.16-3.34 3.35-.06.07-.16.12-.25.1z" class="logoca0"/><circle cx="1.97" cy="1.97" r=".97" class="logoca0"/><circle cx="1.97" cy="5.61" r=".97" class="logoca0"/><circle cx="1.97" cy="9.26" r=".97" class="logoca0"/><circle cx="1.97" cy="12.9" r=".97" class="logoca0"/><circle cx="1.97" cy="16.55" r=".97" class="logoca0"/><circle cx="1.97" cy="20.19" r=".97" class="logoca0"/><circle cx="5.61" cy="1.97" r=".97" class="logoca0"/><circle cx="9.26" cy="1.97" r=".97" class="logoca0"/><circle cx="12.9" cy="1.97" r=".97" class="logoca0"/><circle cx="16.55" cy="1.97" r=".97" class="logoca0"/><circle cx="20.19" cy="1.97" r=".97" class="logoca0"/><circle cx="5.61" cy="5.61" r=".97" class="logoca0"/><circle cx="12.9" cy="5.61" r=".97" class="logoca0"/><circle cx="16.55" cy="5.61" r=".97" class="logoca0"/><circle cx="20.19" cy="5.61" r=".97" class="logoca0"/><circle cx="5.61" cy="20.19" r=".97" class="logoca0"/><circle cx="9.26" cy="20.19" r=".97" class="logoca0"/><circle cx="12.9" cy="20.19" r=".97" class="logoca0"/><circle cx="5.61" cy="16.55" r=".97" class="logoca0"/><circle cx="9.26" cy="16.55" r=".97" class="logoca0"/><circle cx="12.9" cy="16.55" r=".97" class="logoca0"/><circle cx="5.61" cy="12.9" r=".97" class="logoca0"/><circle cx="9.26" cy="12.9" r=".97" class="logoca0"/><circle cx="5.61" cy="9.26" r=".97" class="logoca0"/><circle cx="16.55" cy="9.26" r=".97" class="logoca0"/><circle cx="20.19" cy="9.26" r=".97" class="logoca0"/><path d="M32.22 32.14h144.55v10.08H32.22z" class="logoca1"/><path d="M71.63 35.52c.13-.18.3-.31.5-.41s.44-.15.7-.15.5.05.7.14c.2.09.36.23.49.41s.22.39.28.64h1.11c-.08-.45-.23-.84-.46-1.15-.23-.31-.53-.55-.88-.71-.36-.16-.76-.24-1.21-.24-.43 0-.81.07-1.16.21-.34.14-.64.34-.88.6-.24.26-.42.56-.55.92-.13.35-.19.74-.19 1.18 0 .58.11 1.08.33 1.52.22.44.53.77.95 1.02.41.24.91.36 1.48.36.44 0 .84-.08 1.21-.24.36-.16.66-.39.9-.7.24-.31.38-.68.44-1.13h-1.06c-.08.37-.25.66-.5.86-.25.2-.57.3-.96.3-.35 0-.65-.08-.9-.26s-.43-.41-.56-.7c-.12-.3-.19-.64-.19-1.03 0-.29.04-.56.11-.8.07-.26.17-.47.3-.64zM90.65 34.15l-2.14 5.6h1.08l.43-1.15h2.45l.43 1.15h1.16l-2.11-5.6h-1.3zm.61 1.06.91 2.52h-1.82l.91-2.52zM111.35 37.89l-2.43-3.74h-1.27v5.6h1.05v-4.08l2.67 4.08h1.03v-5.6h-1.05zM128.13 34.15l-2.14 5.6h1.08l.43-1.15h2.45l.43 1.15h1.16l-2.11-5.6h-1.3zm.61 1.06.91 2.52h-1.82l.91-2.52zM148.9 34.49c-.43-.23-.93-.34-1.52-.34h-2.25v5.6h2.25c.44 0 .84-.07 1.19-.21s.65-.33.89-.58c.25-.25.43-.55.56-.9.13-.35.2-.73.2-1.14 0-.56-.11-1.05-.34-1.46-.23-.42-.56-.74-.98-.97zm.06 3.21c-.08.24-.2.44-.35.61-.15.17-.34.3-.55.4-.22.1-.46.14-.72.14h-1.1v-3.82h1.1c.36 0 .67.08.93.24s.46.38.6.66c.14.29.21.61.21.99 0 .29-.04.55-.12.78zM167.68 39.75h1.16l-2.11-5.6h-1.3l-2.14 5.6h1.08l.43-1.15h2.45l.43 1.15zm-1.63-4.54.91 2.52h-1.82l.91-2.52zM46.31 37.21l-.39-.19c-.17-.06-.12-.17-.06-.41l.29-1.1-1.1.24c-.11.02-.18-.05-.19-.12l-.14-.52-.87 1.02c-.12.16-.38.16-.3-.21l.37-2.06-.5.27c-.14.08-.28.1-.36-.05l-.69-1.34-.69 1.34c-.08.15-.22.13-.36.05l-.5-.27.37 2.06c.08.38-.17.38-.3.21l-.87-1.02-.14.52c-.02.07-.09.14-.2.12l-1.1-.24.29 1.1c.06.24.11.34-.06.41l-.39.19 1.9 1.6c.08.06.11.17.09.27l-.17.57 1.89-.23c.06 0 .15.05.15.12l-.09 2.08h.32l-.05-2.07c0-.07.09-.12.14-.12l1.89.23-.17-.57c-.03-.1.01-.21.09-.27l1.9-1.61z" class="logoca0"/></svg>
   </div>

   <div id="cdi-canada-note">
       <p>You are now leaving the CDI Labs U.S. website and will be directed to the CDI Labs Canada website.</p>
       <button class="global-btn blue-btn" id="cdi-canada-go">GO</button>
       <button class="global-btn" id="cdi-canada-close">Cancel</button>
   </div>

</dialog>
