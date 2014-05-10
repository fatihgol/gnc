<?php
/*
        Eğer kullanıcı silinmiş bir içeriğe ulaşmak ister veya yanlış bir
        adres kullanılırsa görüntülenecek sayfa.
*/
if (!defined('gnc'))
	die();

// Arama motoru optimizasyonu için 404 sayfalarının 404 header'ı göndermesini sağla
header('Status: 404 Not Found');
header('HTTP/1.1 404 Not Found');
?>
<div class="page-header">
	<div class="container">
		<h1>Haydaaa! <small>Sayfa bulunamadı</small></h1>
	</div><!--/container-->
</div><!--/page-header-->

<div class="container inner-page" id="404-page">
	<h3 class="centered">Ulaşmak istediğiniz sayfa bulunamadı. Buraya <a href="<?php echo $site['url'];?>">tıklayarak</a> ana sayfaya dönebilirsiniz.</h3>
	<h1 class="error404 centered">404</h1>
</div><!--/container-->
