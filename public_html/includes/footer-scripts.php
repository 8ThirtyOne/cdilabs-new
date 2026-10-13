<?php if($detect->isMobile()){ ?>
 <script type='text/javascript' src="/js/mainMobile<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/mainMobile'.$minjs.'.js'); ?>"></script>
 <?php }else{ ?>
 <script type='text/javascript' src="/js/main<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/main'.$minjs.'.js'); ?>"></script>
<?php } ?>
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/47509061.js"></script>
<!-- End of HubSpot Embed Code -->
<script async src="https://js.sitesearch360.com/plugin/bundle/49938.js"></script>
<script>document.getElementById('global-search').style.display='block';</script>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WN9V9F8B"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>