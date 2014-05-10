<?php
/*
        Eğer kullanıcı yetkisi olmayan bir sayfaya erişmek isterse
*/
if (!defined('gnc'))
	die();

if ($_SESSION['kullanici_tipi'] > 99)
{
	header("Location:".$site['url'].'yonetim');
}
elseif ($_SESSION['kullanici_tipi'] > 1)
{
	header("Location:".$site['url']);
}
else 
{
	// Arama motoru optimizasyonu için 401 sayfalarının 401 header'ı göndermesini sağla
	header('HTTP/1.1 401 Unauthorized');
	header('Status: 401 Unauthorized');
}
?>
<div class="page-header">
	<div class="container">
		<h1>Haydaaa! <small>Erişim engellendi</small></h1>
	</div><!--/container-->
</div><!--/page-header-->

<div class="container inner-page" id="404-page">
	<h3 class="centered">Ulaşmak istediğiniz sayfaya erişme izniniz bulunmuyor. Buraya <a href="<?php echo $site['url'];?>">tıklayarak</a> ana sayfaya dönebilirsiniz.</h3>
	<h1 class="error404 centered">404</h1>
</div><!--/container-->

