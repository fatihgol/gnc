<?php
/*
	gnc'nin tüm güvenliği bu dosyadaki fonksiyonlar aracılığı ile
	gerçekleştirilmektedir. Bu dosyada değişiklik yaparken çok
	dikkatli olmanız gerekmektedir. Aksi takdirde sitenizde güvenlik
	açıkları oluşmasına sebep olabilirsiniz. 
 	
 	XSS kaynağı quickwireddan alınmıştır.
 
 	eysis tarafından temin edilmiştir.
*/

if (!defined('gnc'))
	die();

/* Fonksiyonları yetki seviyelerine göre çalıştıralım 
 * 
 * Neden? Bu sayede güvenlik işlemlerini tek bir yerden yapabilir, dosyalar dışında fonksiyonlara da tek tek yetkilendirebiliriz.
 * NOT: Eğer fonksiyon bulunuyor ancak yetki listesi dediğimiz $fonksiyon_yetki[] dizisinde bulunmuyorsa fonksiyon çalıştırılacaktır.
 */
function fonksiyon_calistir($fonksiyon_adi)
{
	/* Yetki seviyesi 110 ve üstü olan kullanıcıların çalıştırabileceği fonksiyonlar */
	$fonksiyon_yetki = array("ayarlar"=>"110",
							 "genel_ayarlar"=>"110",
							 "kullanicilar"=>"110",
							 "menu"=>"110",
							 "dil"=>"110",
							 "moduller"=>"110",
							 "yonlendiriciler"=>"110",
							 "cache_klasorunu_temizle"=>"110");
	
	if (!empty($fonksiyon_yetki[$fonksiyon_adi]))
	{
		if ($_SESSION['kullanici_tipi'] > $fonksiyon_yetki[$fonksiyon_adi])
		{
			$fonksiyon_adi();
		}
		else 
		{
			gnc_sorun('401');
		}	
	}
	else
	{
		$fonksiyon_adi();	
	}

}
// Adındanda anlaşılabileceği gibi ana güvenlik fonksiyonudur
function guvenlik($girdi)
{
	global $metin;

	// İzin verilmeyecek karakterleri, slashleri kaç
	$girdi = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $girdi);
	
	// Girdide aşağıdaki sembolleri tara
	$ara = 'abcdefghijklmnopqrstuvwxyz';
	$ara .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$ara .= '1234567890!@#$%^&*()';
	$ara .= '~`";:?+/={}[]-_|\'\\';
	
	// Girdide güvenlik açığı oluşturabilecek sembolleri tekrar kaç
	for ($i = 0; $i < strlen($ara); $i++) {
		$girdi = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($ara[$i])).';?)/i', $ara[$i], $girdi);
		$girdi = preg_replace('/(&#0{0,8}'.ord($ara[$i]).';?)/', $ara[$i], $girdi);
	}
	
	// Girdide güvenlik açığı oluşturabilecek java, vb flash ve benzeri scriptleri kaç
	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	// Arrayleri birleştir
	$ra = array_merge($ra1, $ra2);
	
	// Üst tarafta tanımladığımız olası tehditleri yok et
	$bulundu = true;
	while ($bulundu == true) {
		$ilk_girdi = $girdi;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$davranis = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$davranis .= '(';
					$davranis .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
					$davranis .= '|(&#0{0,8}([9][10][13]);?)?';
					$davranis .= ')?';
				}
				$davranis .= $ra[$i][$j];
			}
			$davranis .= '/i';
			$degisiklik = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
			$girdi = preg_replace($davranis, $degisiklik, $girdi);
			if ($ilk_girdi == $girdi) {$bulundu = false;}
		}
	}
	
	// İzin verilecek etiketler
	$izin_ver = "<p><strong><em><b><i><ul><li><pre><hr><blockquote><span>";
	$cikti = strip_tags($girdi, $izin_ver);
	
	// Özel karakterleri html sürümlerine dönüştür
	$cikti = htmlspecialchars($cikti);

	// Yeni satırları xhtml olan brye dönüştür
	$cikti = str_replace("\n", "<br />", $cikti);

	// Slash ekle
	$cikti = addslashes($cikti);

	// Fonksiyondan çıktı al
	return $cikti;
}

// Slash ve diğer gereksiz karakterleri temizleyecek fonksiyon
function temizle($sorgu)
{
    // Kullanıcı tarafından düzenlemesi yapılacak değişkenleri temizle
	$sorgu = str_replace("\'", "'", $sorgu);
	$sorgu = str_replace("\\\\", "\\", $sorgu);
	$sorgu = str_replace("<br />", "\n", $sorgu);
	$sorgu = str_replace("&amp;", "&", $sorgu);
	$sorgu = str_replace("&quot;", "\"", $sorgu);
	$sorgu = str_replace("<", "&lt;", $sorgu);
	$sorgu = str_replace(">", "&gt;", $sorgu);

	return $sorgu;
}

?>