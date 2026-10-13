<meta charset="utf-8">
<meta name="robots" CONTENT="noindex,nofollow">
<meta name="AdsBot-Google" content="noindex,nofollow">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
<meta name="format-detection" content="telephone=no" />
<link rel="icon" type="image/png" href="/img/common/icon-cdilabs-64.png">
<link rel="shortcut icon" href="/img/common/icon-cdilabs-64.ico">
<link rel="apple-touch-icon" href="/img/common/cdilabs-icon.png">
<link rel="preload" href="https://use.typekit.net/mtm1gsv.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
 <noscript><link rel="stylesheet" href="https://use.typekit.net/mtm1gsv.css"></noscript>
 <?php 
 $ip = $webhelper->catchIP();
 $minjs = ''; // .min FOR JS ONLY
 if($detect->isMobile()){ ?>
  <link rel="dns-prefetch" href="<?php echo cdn ?>/js/mainMobile<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/mainMobile'.$minjs.'.js'); ?>" as="script">
 <?php }else{ ?>
  <link rel="dns-prefetch" href="<?php echo cdn ?>/js/main<?php echo $minjs; ?>.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/js/main'.$minjs.'.js'); ?>" as="script">
  <?php 
  }
  $minCss = ''; // .min FOR CSS
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
  ?>
