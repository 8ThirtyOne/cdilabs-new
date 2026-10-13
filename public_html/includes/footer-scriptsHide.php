<?php if($detect->isMobile()){ ?>
 <script type='text/javascript' src="/js/mainMobile.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/mainMobile.js'); ?>"></script>
 <?php }else{ ?>
 <script type='text/javascript' src="/js/main.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/main.js'); ?>"></script>
<?php } ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script async src="https://js.sitesearch360.com/plugin/bundle/49938.js"></script>
<script>document.getElementById('global-search').style.display='block';</script>
