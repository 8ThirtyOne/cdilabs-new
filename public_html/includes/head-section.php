<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta name="format-detection" content="telephone=no" />
<link rel="icon" type="image/png" href="/img/common/icon-cdilabs-64.png">
<link rel="shortcut icon" href="/img/common/icon-cdilabs-64.ico">
<link rel="apple-touch-icon" href="/img/common/cdilabs-icon.png">
<link rel="preload" href="https://use.typekit.net/mtm1gsv.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://use.typekit.net/mtm1gsv.css"></noscript>
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
<link rel="preload" href="https://js.sitesearch360.com/plugin/bundle/49938.js" as="script">
<link rel="preload" href="//js.hs-scripts.com/47509061.js" as="script">
<meta property="og:type" content="website" />
<meta property="og:locale" content="en" />
<meta property="og:title" content="<?php echo $PageTitle; ?>" />
<meta property="og:description" content="<?php echo $metaDesc; ?>" />
<meta property="og:site_name" content="CDI Labs" />
<meta property="og:image" content="https://cdilabs-new.8romans.com/img/common/Logo-CDI-Labs-card.png" />
<meta property="og:type" content="website" />
