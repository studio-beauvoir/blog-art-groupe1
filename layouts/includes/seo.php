<?php
require_once __DIR__ . '/../../util/index.php';
$siteTitle="Bordeaux Street Art";
$siteDesc="Connaissez-vous le street art à Bordeaux? Très peu? Vous avez surement vu une ou plusieur oeuvres mais ne les avez pas regardées? Alors venez donc!";
$siteHeroImg=webAssetPath('img/hero.png');
?>


<meta name="robots" content="all">
<meta name="target" content="all">
<meta name="author" content="Studio Beauvoir">
<meta name="owner" content="Studio Beauvoir">
<meta name="language" content="fr">

<meta http-equiv="content-language" content="fr" />
<meta name="url" content="<?= webSitePath() ?>">
<meta name="identifier-URL" content="<?= webSitePath() ?>">
<link rel="canonical" href="<?= webSitePath() ?>" />

<meta name="subject" content="street-art">
<meta name="description" content="<?=isset($pageDesc)?$pageDesc:$siteDesc?>" />
<meta name="theme-color" content="#111">

<meta property="og:title" content="<?=isset($pageTitle)?$pageTitle:$siteTitle?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?=isset($pageDesc)?$pageDesc:$siteDesc?>" />
<meta property="og:site_name" content="Bordeaux Street Art" />
<meta property="og:url" content="<?= webSitePath() ?>" />
<meta property="og:locale" content="fr" />
<meta property="og:image" content="<?=isset($pageHeroImg)?$pageHeroImg:$siteHeroImg ?>" />

<meta name="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="<?= webSitePath() ?>">
<meta name="twitter:title" content="<?=isset($pageTitle)?$pageTitle:$siteTitle?>" />
<meta name="twitter:description" content="<?=isset($pageDesc)?$pageDesc:$siteDesc?>" />
<meta name="twitter:site" content="<?= webSitePath() ?>" />
<meta name="twitter:image" content="<?=isset($pageHeroImg)?$pageHeroImg:$siteHeroImg ?>" />

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-title" content="{{ site.title }}" />
<meta name="apple-mobile-web-app-status-bar-style" content="#000">

<link rel="shortcut icon" href="<?= webAssetPath() ?>img/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="<?= webAssetPath() ?>img/apple-touch-icon.png" />
<link rel="apple-touch-icon" sizes="57x57" href="<?= webAssetPath() ?>img/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?= webAssetPath() ?>img/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="76x76" href="<?= webAssetPath() ?>img/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?= webAssetPath() ?>img/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="120x120" href="<?= webAssetPath() ?>img/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon" sizes="144x144" href="<?= webAssetPath() ?>img/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="152x152" href="<?= webAssetPath() ?>img/apple-touch-icon-152x152.png" />
<link rel="apple-touch-icon" sizes="180x180" href="<?= webAssetPath() ?>img/apple-touch-icon-180x180.png" />