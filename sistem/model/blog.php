<?php
if (!defined('gnc'))
	die();

// Tüm içerikleri, limit koyarak göster
$tum_icerikler = gnc_icerikler(0,20);
// Son içerikleri, limite kadar göster
$son_icerikler = gnc_son_icerikler(10);
// Tarihe göre içerikleri, limite kadar göster
$tarihe_gore_icerikler = gnc_tarihe_gore_icerikler(30);
							

//Belirtilen içeriği veritabanından çeken fonksiyon
function gnc_icerik($icerik_sef){
	global $adres, $vt;
	
	if (!empty($icerik_sef))
	{
		$sorgu = $vt->query("SELECT * FROM gnc_icerikler
							 LEFT JOIN gnc_iceriklerin_kategorileri ON gnc_icerikler.icerik_id = gnc_iceriklerin_kategorileri.icerik_id
							 WHERE gnc_icerikler.icerik_sef = '$icerik_sef'
							 LIMIT 1");
	}
	else 
	{
		$sorgu = $vt->query("SELECT * FROM gnc_icerikler
						 	 LEFT JOIN gnc_iceriklerin_kategorileri ON gnc_icerikler.icerik_id = gnc_iceriklerin_kategorileri.icerik_id
						 	 ORDER BY gnc_icerikler.icerik_tarih DESC
						 	 LIMIT 1");	
	}
	while ($sonuc = $vt->fetch_array($sorgu)){
		// Tarihi belirtilen formata uygun olarak düzenle	
		$sonuc['icerik_tarih'] = gnc_tarihi_formatla($sonuc['icerik_tarih']);	
		// Gün	
		$sonuc['icerik_gun'][0] = gnc_gun($sonuc['icerik_tarih'],'sayi');
		$sonuc['icerik_gun'][1] = gnc_gun($sonuc['icerik_tarih'],'uzun');
		// Ay
		$sonuc['icerik_ay'][0] = gnc_ay($sonuc['icerik_tarih'],'sayi');
		$sonuc['icerik_ay'][1] = gnc_ay($sonuc['icerik_tarih'],'kisa');
		// Yıl
		$sonuc['icerik_yil'][0] = gnc_yil($sonuc['icerik_tarih']);
		
		// Resimleri çağır
		$sonuc = gnc_iceriklerin_resimleri($sonuc);
			
		$sonuclar[] = $sonuc;
   	}
		
	return $sonuclar[0];
}
// Belirtilen kategorideki içerikleri veritabanından çeken fonksiyon
function gnc_icerikler($kategori_id = 0, $limit = 0)
{
	global $adres, $vt;
	$sorgu  = "SELECT * FROM gnc_iceriklerin_kategorileri
			   LEFT JOIN gnc_kategoriler ON gnc_kategoriler.kategori_id = gnc_kategoriler.kategori_id  
			   LEFT JOIN gnc_icerikler ON gnc_icerikler.icerik_id = gnc_iceriklerin_kategorileri.icerik_id ";
	
	if ($kategori_id != 0)
		$sorgu .= "WHERE gnc_iceriklerin_kategorileri.kategori_id = '$kategori_id' ";
	
	$sorgu .= "GROUP BY gnc_icerikler.icerik_id 
			   ORDER BY gnc_iceriklerin_kategorileri.icerik_id DESC ";
	
	if ($limit > 0)
		$sorgu .= " LIMIT $limit ";
	
	$sorgu = $vt->query($sorgu);
	
	while ($sonuc = $vt->fetch_array($sorgu)){
		// Tarihi belirtilen formata uygun olarak düzenle
		$sonuc['icerik_tarih'] = gnc_tarihi_formatla($sonuc['icerik_tarih']);	
		// Gün	
		$sonuc['icerik_gun'][0] = gnc_gun($sonuc['icerik_tarih'],'sayi');
		$sonuc['icerik_gun'][1] = gnc_gun($sonuc['icerik_tarih'],'uzun');
		// Ay
		$sonuc['icerik_ay'][0] = gnc_ay($sonuc['icerik_tarih'],'sayi');
		$sonuc['icerik_ay'][1] = gnc_ay($sonuc['icerik_tarih'],'kisa');
		// Yıl
		$sonuc['icerik_yil'][0] = gnc_yil($sonuc['icerik_tarih']);
		
		// Resimleri çağır
		$sonuc = gnc_iceriklerin_resimleri($sonuc);
		
		// Sonuçları sırala	
		$sonuclar[] = $sonuc;
	}
	return $sonuclar;	
}
/* Belirtilen içeriğin resmini bulan fonksiyon 
 * 
 * Resim herhangi bir yerde kullanılmak amacıyla yüklendikten sonra gnc_veriler tablosuna numarik olarak eklendiyse
 * fonksiyon bu resmide seçebileceği gibi aksi bir durumda direk resim yolunu düzenleyebilmekte veya sistem/img/resim_yok.png
 * olarak tanımlı olan varsayılan resmi döndürmektedir
 * 
 * param int, string
 * 
 * @return string (path)
 */

function gnc_iceriklerin_resimleri($sonuc)
{
	global $site, $vt;
	
	// Büyük resmin yolunu belirle
	if (!empty($sonuc['icerik_buyuk_resim_id']) && is_numeric($sonuc['icerik_buyuk_resim_id'])){
		$buyuk_resim_sorgu = $vt->query("SELECT * FROM gnc_veriler WHERE veri_id = '{$sonuc['icerik_buyuk_resim_id']}' LIMIT 1");	
		$buyuk_resim_sonuc = $vt->fetch_array($buyuk_resim_sorgu);
		$sonuc['icerik_buyuk_resim'] = $site['resim_yolu'].$buyuk_resim_sonuc['veri_yolu'];
	}
	elseif (!empty($sonuc['icerik_buyuk_resim_id'])){
		$sonuc['icerik_buyuk_resim'] = $site['resim_yolu'].$sonuc['icerik_buyuk_resim_id'];
	}
	else{
		$sonuc['icerik_buyuk_resim'] = 'sistem/img/resim_yok.png';
	}
	
	if (!empty($sonuc['icerik_kucuk_resim_id']) && is_numeric($sonuc['icerik_kucuk_resim_id'])){
		$kucuk_resim_sorgu = $vt->query("SELECT * FROM gnc_veriler WHERE veri_id = '{$sonuc['icerik_kucuk_resim_id']}' LIMIT 1");
		$kucuk_resim_sonuc = $vt->fetch_array($kucuk_resim_sorgu);
		$sonuc['icerik_kucuk_resim'] = $site['resim_yolu'].$kucuk_resim_sonuc['veri_yolu'];
	}
	elseif (!empty($sonuc['icerik_kucuk_resim_id'])){
		$sonuc['icerik_kucuk_resim'] = $site['resim_yolu'].$sonuc['icerik_kucuk_resim_id'];
	}
	else{
		$sonuc['icerik_kucuk_resim'] = 'sistem/img/resim_yok.png';
	}
	return $sonuc;
}
// Belirtilen içeriğin şablonlarının veritabanından çeken fonksiyon
function gnc_iceriklerin_sablonlari($icerik_id)
{
	global $vt;

	$sorgu = $vt->query("SELECT * FROM gnc_iceriklerin_sablonlari
						 LEFT JOIN gnc_sablon_icerikleri ON gnc_sablon_icerikleri.sablon_icerik_id = gnc_iceriklerin_sablonlari.sablon_icerik_id
						 WHERE gnc_iceriklerin_sablonlari.icerik_id = '$icerik_id'");
	
	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;

	if (isset($sonuclar))
		return $sonuclar;		
}
// Belirtilen içeriğe benzer olarak belirtilen içerikleri veritabanından çeken fonksiyon
function gnc_benzer_icerikler($icerik_id)
{
	global $vt;

	$sorgu = $vt->query("SELECT * FROM gnc_iceriklerin_benzer_icerikleri
						 LEFT JOIN gnc_icerikler ON gnc_icerikler.icerik_id = gnc_iceriklerin_benzer_icerikleri.benzer_icerik_id
						 WHERE gnc_iceriklerin_benzer_icerikleri.icerik_id = '$icerik_id'");

	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;

	return $sonuclar;	
}
// Tarihe göre en son yazılmış olan içerikleri sıralı şekilde veritabanından çeken fonksiyon
function gnc_son_icerikler($limit)
{
	global $vt;

	$sorgu = $vt->query("SELECT * FROM gnc_icerikler           
			             LEFT JOIN gnc_iceriklerin_kategorileri ON gnc_icerikler.icerik_id = gnc_iceriklerin_kategorileri.icerik_id
						 ORDER BY icerik_tarih DESC 
						 LIMIT $limit");

	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;

	return $sonuclar;	
}
function gnc_tarihe_gore_icerikler($limit)
{
	global $vt;

	$sorgu = $vt->query("SELECT *, YEAR(icerik_tarih) AS icerik_yil, MONTH(icerik_tarih) AS icerik_ay FROM gnc_icerikler
						 LEFT JOIN gnc_iceriklerin_kategorileri ON gnc_icerikler.icerik_id = gnc_iceriklerin_kategorileri.icerik_id
            			 ORDER BY icerik_tarih DESC
            			 LIMIT $limit");

	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;

	return $sonuclar;	
}