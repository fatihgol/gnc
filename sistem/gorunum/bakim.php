<?php
/*
        Eğer kullanıcı silinmiş bir içeriğe ulaşmak ister veya yanlış bir
        adres kullanılırsa görüntülenecek sayfa.
*/
if (!defined('gnc'))
	die();
error_reporting(0);
require_once('sistem/gorunum/header.php');
?>
<div class="page-header">
	<div class="container">
		<h1>Üzgünüz! <small>Sitemiz bakımdadır</small></h1>
	</div><!--/container-->
</div><!--/page-header-->

<div class="container inner-page" id="404-page">
	<h3 class="centered">Size daha iyi hizmet verebilmek için sitemizi bakıma aldık, </br>lütfen daha sonra tekrar ziyaret edin.</h3>
	<h1 class="error404 centered">:/</h1>
</div><!--/container-->
