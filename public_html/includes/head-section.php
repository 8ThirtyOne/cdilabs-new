<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta name="format-detection" content="telephone=no" />
<link rel="icon" type="image/png" href="/img/common/icon-cdilabs-64.png">
<link rel="shortcut icon" href="/img/common/icon-cdilabs-64.ico">
<link rel="apple-touch-icon" href="/img/common/cdilabs-icon.png">
<link rel="preload" href="https://use.typekit.net/mtm1gsv.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://use.typekit.net/mtm1gsv.css"></noscript>
<link rel="preload" as="image" href="https://www.cdilabs.com/files/hero/main/20250108091839677eb36f0494f.jpg" fetchPriority="high" />
<?php
 if(!isset($PageTitle)) $PageTitle = '';
 if(!isset($metaDesc)) $metaDesc = '';
 if(!isset($PageUrl)) $PageUrl = ''; 
 $ip = $webhelper->catchIP();
 $minjs = '.min'; // .min FOR JS ONLY
 $minCss = '.min'; // .min FOR CSS
?>
<link rel="preload" href="/css/global<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/global'.$minCss.'.css'); ?>" as="style">
<link rel="stylesheet" type="text/css" href="/css/global<?php echo $minCss ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/global'.$minCss.'.css'); ?>" />
<?php
if($FirstPageCode == "00"){ 
?>
   <link rel="preload" href="/css/main<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/main'.$minCss.'.css'); ?>" as="style">
   <link rel="stylesheet" type="text/css" href="/css/main<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/main'.$minCss.'.css'); ?>" />
<?php 
}else if($FirstPageCode == "01"){ 
?> 
   <link rel="preload" href="/css/applications<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/applications'.$minCss.'.css'); ?>" as="style">
   <link rel="stylesheet" type="text/css" href="/css/applications<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/applications'.$minCss.'.css'); ?>" />
<?php
}else if($FirstPageCode == "02"){ 
?>
   <link rel="preload" href="/css/products<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/products'.$minCss.'.css'); ?>" as="style">
   <link rel="stylesheet" type="text/css" href="/css/products<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/products'.$minCss.'.css'); ?>" />
<?php
}else if($FirstPageCode == "03"){
?>
   <link rel="preload" href="/css/news<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/news'.$minCss.'.css'); ?>" as="style">
   <link rel="stylesheet" type="text/css" href="/css/news<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/news'.$minCss.'.css'); ?>" />
<?php
}else if($FirstPageCode == "04"){
?>
   <link rel="preload" href="/css/resources<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/resources'.$minCss.'.css'); ?>" as="style">
   <link rel="stylesheet" type="text/css" href="/css/resources<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/resources'.$minCss.'.css'); ?>" />
<?php
}else if($FirstPageCode == "05"){ 
?> 
   <link rel="preload" href="/css/support<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/support'.$minCss.'.css'); ?>" as="style">
   <link rel="stylesheet" type="text/css" href="/css/support<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/support'.$minCss.'.css'); ?>" />
 <?php 
}else if($FirstPageCode == "06"){ 
?>
    <link rel="preload" href="/css/company<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/company'.$minCss.'.css'); ?>" as="style">
    <link rel="stylesheet" type="text/css" href="/css/company<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/company'.$minCss.'.css'); ?>" />
<?php
}else if($FirstPageCode == "07"){ 
?>
    <link rel="preload" href="/css/services<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/services'.$minCss.'.css'); ?>" as="style">
    <link rel="stylesheet" type="text/css" href="/css/services<?php echo $minCss; ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/services'.$minCss.'.css'); ?>" />
<?php
}
if($detect->isMobile()){ ?>
  <link rel="preload" href="<?php echo cdn ?>/js/mainMobile<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/mainMobile'.$minjs.'.js'); ?>" as="script">
 <?php }else{ ?>
  <link rel="preload" href="<?php echo cdn ?>/js/main<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/main'.$minjs.'.js'); ?>" as="script">
  <?php 
  } 
?>
<link rel="preconnect" href="https://cdn-cookieyes.com/">
<link rel="preload" href="https://cdn-cookieyes.com/client_data/82ec697cfddb35173fe88a41/script.js" as="script" />
<link rel="dns-prefetch" href="https://www.googletagmanager.com" />
<link href="https://www.googletagmanager.com/gtag/js?id=G-65RL72XEMK" rel="preload" as="script" />
<link href="https://www.googletagmanager.com/gtm.js?id=GTM-WN9V9F8B" rel="preload" as="script" />
<link rel="preload" href="https://js.sitesearch360.com/plugin/bundle/49938.js" as="script">
<link rel="preload" href="https://static.ads-twitter.com/uwt.js" as="script">
<link rel="preload" href="https://sc.lfeeder.com/lftracker_v1_lYNOR8xp9BN8WQJZ.js" as="script">
<link rel="preload" href="https://snap.licdn.com/li.lms-analytics/insight.min.js" as="script">
<link rel="preload" href="//js.hs-scripts.com/47509061.js" as="script">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@cdi_labs" />
<meta name="twitter:title" content="<?php echo $PageTitle; ?>" />
<meta name="twitter:description" content="<?php echo $metaDesc; ?>" />
<meta name="twitter:image" content="https://www.cdilabs.com/img/common/Logo-CDI-Labs-card.png" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="en" />
<meta property="og:url" content="https://www.cdilabs.com/<?php echo $PageUrl; ?>" />
<meta property="og:title" content="<?php echo $PageTitle; ?>" />
<meta property="og:description" content="<?php echo $metaDesc; ?>" />
<meta property="og:site_name" content="CDI Labs" />
<meta property="og:image" content="https://www.cdilabs.com/img/common/Logo-CDI-Labs-card.png" />
<meta property="og:type" content="website" />
<script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/82ec697cfddb35173fe88a41/script.js"></script>

<!-- RB2B -->
<script>
    !function () {var reb2b = window.reb2b = window.reb2b || [];
    if (reb2b.invoked) return;reb2b.invoked = true;reb2b.methods = ["identify", "collect"];
    reb2b.factory = function (method) {return function () {var args = Array.prototype.slice.call(arguments);
    args.unshift(method);reb2b.push(args);return reb2b;};};
    for (var i = 0; i < reb2b.methods.length; i++) {var key = reb2b.methods[i];reb2b[key] = reb2b.factory(key);}
    reb2b.load = function (key) {var script = document.createElement("script");script.type = "text/javascript";script.async = true;
    script.src = "https://s3-us-west-2.amazonaws.com/b2bjsstore/b/" + key + "/GOYPYHDE1GOX.js.gz";
    var first = document.getElementsByTagName("script")[0];
    first.parentNode.insertBefore(script, first);};
    reb2b.SNIPPET_VERSION = "1.0.1";reb2b.load("GOYPYHDE1GOX");}();
</script>
<!-- End RB2B -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WN9V9F8B');</script>
<!-- End Google Tag Manager -->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-65RL72XEMK"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-65RL72XEMK');
</script>
