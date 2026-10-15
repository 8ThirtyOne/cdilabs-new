<?php if($detect->isMobile()){ ?>
 <script type='text/javascript' src="/js/mainMobile<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/mainMobile'.$minjs.'.js'); ?>"></script>
 <?php }else{ ?>
 <script type='text/javascript' src="/js/main<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/main'.$minjs.'.js'); ?>"></script>
<?php } ?>

<script async src="https://js.sitesearch360.com/plugin/bundle/49938.js"></script>
<script>document.getElementById('global-search').style.display='block';</script>
