<?php 
if(isset($PageName)){
  if($PageName != "CONTACT US" && $PageName != "Customer Survey"){
  echo "<div id='sticky-btn'>
    <a href='/company/contact-cdi'>Request Info</a>
  </div>";
  }
}
?>
<footer id="page-footer" class="<?php if($PageUrl !== '/company/signup-form') echo('hide-section');?>" data-info="lazy-load">
        <div class="page-inner">
          <div class="card-layout card2-wrapper">
            <div class="column-box">
              <div id="footer-logo">
                 <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/logos/cdi-footer-logo.php'); ?>
              </div>
              <div id="footer-subscribe">
                   <div id="subscribe-form">
                     <h4>Become part of the CDI Labs community</h4>
                     <p>Sign up to receive emails on our latest news and updates.</p>
                     <p><a href="/company/signup-form" class="global-btn smooth-hover">SIGN UP</a></p>
                 </div>

            </div>

          </div>
             
          <div class="column-box">
            <div class="card-layout card4-wrapper">
              <div class="footer-nav">
                <h3>PLATFORMS</h3>
                <ul>
                   <li><a href="/products/huprot-microarray" class="smooth-hover"><em>HuProt</em>&trade; Proteome Microarray</a></li>
                   <li><a href="/products/vird-membrane-protein-array" class="smooth-hover"><em>VirD</em>&trade; GPCR Protein Microarray</a></li>
                   <li><a href="/products/virscan-phip-seq" class="smooth-hover"><em>VirScan</em>&reg; Viral PhIP-Seq</a></li>
                   <li><a href="/products/huscan-phip-seq" class="smooth-hover"><em>HuScan</em>&reg; Human PhIP-Seq</a></li>
                   <li><a href="/products/mousescan-phip-seq" class="smooth-hover"><em>MouseScan</em>&trade; Murine PhIP-Seq</a></li>
                </ul>
                  
                <h3 style="padding-top:50px">BIOINFORMATICS</h3>
                <ul>
                   <li><a href="/bioinformatics/" class="smooth-hover">Overview</a></li>
                </ul>

              </div>

              <div class="footer-nav">
                <h3>SERVICES</h3>
                <ul>
                   <li><a href="/services/huprot-microarray" class="smooth-hover"><em>HuProt</em>&trade; Services</a></li>
                   <li><a href="/services/vird-membrane-protein-array" class="smooth-hover"><em>VirD</em>&trade; GPCR Services</a></li>
                   <li><a href="/services/virscan-phip-seq" class="smooth-hover"><em>VirScan</em>&reg; PhIP-Seq Services</a></li>
                   <li><a href="/services/huscan-phip-seq" class="smooth-hover"><em>HuScan</em>&reg; PhIP-Seq Services</a></li>
                   <li><a href="/services/mousescan-phip-seq" class="smooth-hover"><em>MouseScan</em>&trade; PhIP-Seq Services</a></li>
                   <li><a href="/services/peptide-hormone-phip-seq" class="smooth-hover"><em>Peptide Hormone</em> Services</a></li>
                   <li><a href="/services/pan-isotype-profiling" class="smooth-hover"><em>Pan-isotype Profiling</em> Services</a></li>
                   <li><a href="/services/antibody-development" class="smooth-hover"><em>Antibody</em> Development</a></li>
                   <li><a href="/services/autoantibody-seromics" class="smooth-hover"><em>Autoantibody Profiling</em> Overview</a></li>
                   <li><a href="/services/target-id" class="smooth-hover"><em>Target ID</em> Overview</a></li>
                   <li><a href="/services/seromics-disease-areas" class="smooth-hover"><em>Disease Areas</em> Overview</a></li>
                   <li><a href="/services/cro-services" class="smooth-hover"><em>Specialized CRO</em> Overview</a></li>
                   <!--<li><a href="/bioinformatics/" class="smooth-hover"><em>Bioinformatics</em> Overview</a></li>-->
                </ul>

              </div>

              <div class="footer-nav">
                <h3>COMPANY</h3>
                <ul>
                  <li><a href="/resources/literature" class="smooth-hover">Resources</a></li>
                  <li><a href="/resources/literature?page=1&category=content" class="smooth-hover">Library Content</a></li>
                  <li><a href="/resources/publications" class="smooth-hover">Publications</a></li>
                  <li><a href="/faqs" class="smooth-hover">FAQs</a></li>
                  <li><a href="/resources/videos" class="smooth-hover">Videos and Webinars</a></li>
                  <li><a href="/blogs" class="smooth-hover">Blogs</a></li>
                  <li><a href="/news-events/events" class="smooth-hover">Events</a></li>
                  <li><a href="/news-events/news" class="smooth-hover">News</a></li>
                  <li><a href="/company/signup-form" class="smooth-hover">Sign-up for Our eNews</a></li>    
                  <li><a href="/company/about-us" class="smooth-hover">About Us</a></li>
                  <li><a href="/company/leadership" class="smooth-hover">Leadership</a></li>
                </ul>

              </div>

              <div class="footer-nav">
                <h3>CONTACT</h3>
                <ul>
                  <li><em>Email:</em> <a href="mailto:info@cdilabs.com" class="smooth-hover">info@cdilabs.com</a></li>
                  <li><em>Tel:</em> <span>+1 844-539-6296</span></li>
                  <li class="footer-nav-btn"><a href="/company/contact-cdi" class="global-btn blue-btn smooth-hover">CONTACT US</a></li>
              </div>
            </div>
          </div>
        </div>

        <div id="footer-middle">

           <div class="card-layout card6-wrapper" id="footer-address">

             <ul>
              <li>General Inquiries</li>
              <li><a href="mailto:info@cdilabs.com" class="smooth-hover">info@cdilabs.com</a></li>
              <li class="footer-address-phone">Tel: +1 510 858-2855</li>
             </ul>
             <ul>
               <li>Technical Support</li>
               <li><a href="mailto:support@cdilabs.com" class="smooth-hover">support@cdilabs.com</a></li>
               <li class="footer-address-phone">Tel: +1 844 539-6296</li>
             </ul>
             <ul>
               <li>Mailing Address</li>
               <li>PO. Box 569</li>
               <li>Mayagüez. PR 00681-0569</li>
               <li>USA</li>
             </ul>
             <ul>
               <li>CDI Labs - Mayagüez</li>
               <li>12 W Mendez Vigo Avenue</li>
               <li>2nd Floor</li>
               <li>Mayagüez, PR 00680</li>
               <li>USA</li>
               <li class="footer-address-phone">Tel: +1 939-280-5293</li>
               <li class="footer-address-btn"><a href="https://www.google.com/maps/place/CDI+Laboratories/@18.2017126,-67.1444931,17z/data=!3m1!4b1!4m6!3m5!1s0x8c02b378731d692b:0xaec327c2867e5b2!8m2!3d18.2017075!4d-67.1419128!16s%2Fg%2F11f63yfjm1?entry=ttu" target="_blank" class="global-btn smooth-hover">DIRECTIONS</a></li>
             </ul>
             <ul>
               <li>CDI Labs - Baltimore<li>
               <li>1 N. Haven Street</li>
               <li>Suite B001</li>
               <li>Baltimore, MD 21224</li>
               <li>USA</li>
               <li class="footer-address-phone">Tel: +1 844-539-6296</li>
               <li class="footer-address-btn"><a href="https://www.google.com/maps/place/Cdi+Laboratories/@39.2935093,-76.564995,17z/data=!3m1!4b1!4m6!3m5!1s0x89c805b299be2063:0x352d795165ff9aa!8m2!3d39.2935093!4d-76.5624147!16s%2Fg%2F11t625p15v?entry=ttu" target="_blank" class="global-btn smooth-hover">DIRECTIONS</a></li>
             </ul>
             <ul>
               <li>CDI Labs Canada - Toronto<li>
               <li>MaRS Centre - West Tower</li>
               <li>661 University Ave</li>
               <li>Suite 1300</li>
               <li>Toronto, ON</li>
               <li>CANADA M5G 0B7</li>
               <li class="footer-address-phone">Tel: +1 647-243-5289</li>
               <li class="footer-address-btn"><a href="https://www.google.com/maps/place/661+University+Ave+%231385,+Toronto,+ON+M5G+1M1,+Canada/@43.6593533,-79.3920027,17z/data=!3m1!4b1!4m5!3m4!1s0x882b34b7d81e2a31:0x86d43c99ef4c142e!8m2!3d43.6593533!4d-79.3894224?entry=ttu" target="_blank" class="global-btn smooth-hover">DIRECTIONS</a></li>
             </ul>

           </div>

             <div id="footer-social">
                <ul>
                  <li>Follow Us</li>
                  <li class="sns-linkedin"><a href="https://www.linkedin.com/company/cdi-labs" id="in-footer" aria-label="CDI Labs on Linkedin" target="_blank"><svg class="smooth-hover" viewBox="0 0 24 24"><path  d="M8 19h-3v-10h3v10zm11 0h-3v-5.342c0-1.392-.496-2.085-1.479-2.085-.779 0-1.273.388-1.521 1.165v6.262h-3s.04-9 0-10h2.368l.183 2h.062c.615-1 1.598-1.678 2.946-1.678 1.025 0 1.854.285 2.487 1.001.637.717.954 1.679.954 3.03v5.647z"/><ellipse cx="6.5" cy="6.5" rx="1.55" ry="1.5"/></svg></a></li>
                  <li class="sns-twitter"><a href="https://x.com/cdi_labs" aria-label="CDI Labs on X" id="tw-footer" target="_blank"><svg class="smooth-hover" viewBox="0 0 16 16"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/></svg></a></li>
                  <li><a href="https://www.youtube.com/@CDILabs" aria-label="YouTube Icon" class="social-icon" id="yt-footer" target="_blank"><svg class="smooth-hover" viewBox="0 0 512 512"><path d="M508.64 148.79c0-45-33.1-81.2-74-81.2C379.24 65 322.74 64 265 64h-18c-57.6 0-114.2 1-169.6 3.6C36.6 67.6 3.5 104 3.5 149 1 184.59-.06 220.19 0 255.79q-.15 53.4 3.4 106.9c0 45 33.1 81.5 73.9 81.5 58.2 2.7 117.9 3.9 178.6 3.8q91.2.3 178.6-3.8c40.9 0 74-36.5 74-81.5 2.4-35.7 3.5-71.3 3.4-107q.34-53.4-3.26-106.9zM207 353.89v-196.5l145 98.2z"/></svg></a></li>
                  <li class="sns-facebook"><a href="https://www.facebook.com/cdilaboratories/" id="in-footer" aria-label="CDI Labs on Facebook" target="_blank"><svg class="smooth-hover" viewBox="0 0 32 32"><path d="M12.6,16.1v11.6c0,0.2,0.1,0.3,0.3,0.3h4.6c0.2,0,0.3-0.1,0.3-0.3V15.9h3.4c0.2,0,0.3-0.1,0.3-0.3l0.3-3.6  c0-0.2-0.1-0.3-0.3-0.3h-3.7V9.2c0-0.6,0.5-1.1,1.2-1.1h2.6C21.9,8.1,22,8,22,7.8V4.3C22,4.1,21.9,4,21.7,4h-4.4  c-2.6,0-4.7,1.9-4.7,4.3v3.4h-2.3c-0.2,0-0.3,0.1-0.3,0.3v3.6c0,0.2,0.1,0.3,0.3,0.3h2.3V16.1z"/></svg></a></li>
                </ul>

              </div>

            </div>

            <div id="footer-copyright">

                <div class="left">
                  <p><em>FOR RESEARCH USE ONLY.</em> Not for use in diagnostic procedures.</p>
                  <p><em>© <?php echo date("Y"); ?> CDI Labs.</em> All rights reserved.</p>
                </div>

                <ul id="footer-legal">
                    <li><a href="/company/privacy-policy" class="smooth-hover">Privacy Policy</a></li>
                    <li>|</li>
                    <li><a href="/company/cookie-policy" class="smooth-hover">Cookie Policy</a></li>
                    <li>|</li>
                    <li><a href="/company/web-terms" class="smooth-hover">Terms of Use - Web</a></li>
                    <li>|</li>
                    <li><a href="/company/terms-conditions-sales" class="smooth-hover">Terms &amp; Conditions - Sales</a></li>
                    <li>|</li>
                    <li><a href="/company/terms-conditions-services" class="smooth-hover">Terms &amp; Conditions - Services</a></li>
                </ul>
                
            </div>

          </div>

        </div>

      </div>

</footer>
