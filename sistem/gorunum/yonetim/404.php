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
<!-- Main content wrapper begins -->
<div class="errorWrapper" style="margin:0px;">
    <span class="errorNum">404</span>
	<div class="errorContent">
        <span class="errorDesc"><span class="icon-warning"></span><?php echo $dil['sayfa_bulunamadi']; ?>!</span>
        <div class="fluid">
            <a href="./" title="" class="buttonM bLightBlue grid6"><?php echo $dil['yonetim_sayfasi']; ?></a>
            <a href="<?php echo $site['url'];?>" title="" class="buttonM bRed grid6"><?php echo $dil['siteyi_goruntule']; ?></a>
        </div>
    </div>
</div>    
<!-- Main content wrapper ends -->

