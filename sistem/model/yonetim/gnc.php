<?php
if (!defined('gnc') || $_SESSION['kullanici_tipi'] < 100)
	die();

// Ayarlar
function gnc_model_ayarlar($ayar_tipi = 1){
	global $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_ayarlar 
						 WHERE ayar_tipi = '$ayar_tipi'
						 ORDER BY ayar_id ASC");
	
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;
}
function gnc_model_genel_ayarlar_ekle(){
	global $vt;
	
	if (!empty($_POST['ayar_adi']) && !empty($_POST['ayar_degeri'])){		
		$ayar_adi = guvenlik($_POST['ayar_adi']);
		$ayar_degeri = guvenlik($_POST['ayar_degeri']);
		$ayar_aciklama = guvenlik($_POST['ayar_aciklama']);
		
		$vt->query("INSERT INTO gnc_ayarlar 
						(ayar_adi, ayar_degeri, ayar_aciklama)
					VALUES
						('$ayar_adi','$ayar_degeri','$ayar_aciklama')");
	}
}
function gnc_model_genel_ayarlari_duzenle(){
	global $vt;
	
	$ayar_adi = array_keys($_POST);	
	$ayar_degeri = array_values($_POST);

	if (gnc_yetki(111))
	{
		// Tek tek tüm değerleri update et
		for ($i=0; $i<count($_POST); $i++)
		{
			$vt->query("UPDATE gnc_ayarlar SET 
							ayar_degeri = '{$ayar_degeri[$i]}'
					  	WHERE ayar_adi = '$ayar_adi[$i]' ");
		}
	}	
}
function gnc_model_profil_duzenle(){
	global $vt;
	
	if (!empty($_POST['kullanici_adi']))
	{
		$kullanici_sifre1 = gnc_encrypt(guvenlik($_POST['kullanici_sifre1']));
		$kullanici_sifre2 = gnc_encrypt(guvenlik($_POST['kullanici_sifre2']));
		$kullanici_adi = guvenlik($_POST['kullanici_adi']);
		$kullanici_soyadi = guvenlik($_POST['kullanici_soyadi']);
		
		$sorgu = "	UPDATE gnc_kullanicilar SET 
						kullanici_adi = '$kullanici_adi',
						kullanici_soyadi = '$kullanici_soyadi' ";
					
		if (!empty($_POST['kullanici_sifre1']) && $_POST['kullanici_sifre1'] == $_POST['kullanici_sifre2'])
			$sorgu .= " , kullanici_sifre = '$kullanici_sifre1' ";		
					
		$sorgu .= "	WHERE kullanici_id = '{$_SESSION['kullanici_id']}'";
		
		$vt->query($sorgu);
		
		$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar WHERE kullanici_id = '{$_SESSION['kullanici_id']}' LIMIT 1");
		$sonuc = $vt->fetch_array($sorgu);

		gnc_kullanici_oturumu($sonuc);
	}
}
function gnc_model_kullanicilar($kullanici_id = false){
	global $adres, $dil, $site, $vt;
	
	$sorgu = "SELECT * FROM gnc_kullanicilar ";
	
	// Kullanıcı id'si tanımlanmış ise sadece onun verilerini çek
	if ($kullanici_id){
		$kullanici_id = guvenlik($kullanici_id);
		$sorgu .= "WHERE kullanici_id = '$kullanici_id' 
				   LIMIT 1";
	}
	else	
		$sorgu .= "ORDER BY kullanici_id ASC";
			  
	$sorgu = $vt->query($sorgu);
	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;
   		
	return $sonuclar;
}
function gnc_model_kullanici_tipleri(){
	global $adres, $dil, $site, $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_kullanicilarin_tipleri ORDER BY kullanici_tip_yetki ASC");
	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;
   		
	return $sonuclar;
}
function gnc_model_kullanici_gruplari(){
	global $adres, $dil, $site, $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_kullanicilarin_gruplari ORDER BY kullanici_grup_adi ASC");
	while ($sonuc = $vt->fetch_array($sorgu))
		$sonuclar[] = $sonuc;
   		
	return $sonuclar;
}
function gnc_model_kullanici_ekle()
{
	global $site, $vt;

	if (isset($_POST['kullanici_kullanici_adi']) && isset($_POST['kullanici_sifre1']) && ($_POST['kullanici_sifre1'] == $_POST['kullanici_sifre2']))
	{
		$kullanici_kullanici_adi = guvenlik($_POST['kullanici_kullanici_adi']);
		$kullanici_sifre = gnc_encrypt(guvenlik($_POST['kullanici_sifre1']));
		$kullanici_tipi  = guvenlik($_POST['kullanici_tipi']);
		$kullanici_grubu  = guvenlik($_POST['kullanici_grubu']);
		$kullanici_adi  = guvenlik($_POST['kullanici_adi']);
		$kullanici_soyadi  = guvenlik($_POST['kullanici_soyadi']);
		
		$vt->query("INSERT INTO gnc_kullanicilar
						(kullanici_kullanici_adi, kullanici_sifre, kullanici_tipi, kullanici_grup, kullanici_adi, kullanici_soyadi)
					VALUES
					 	('$kullanici_kullanici_adi','$kullanici_sifre','$kullanici_tipi','$kullanici_grubu','$kullanici_adi','$kullanici_soyadi')");
	}
}
function gnc_model_kullanici_detaylarini_duzenle()
{
	global $site, $vt;
	if (gnc_yetki(100)){
		if (isset($_POST['kullanici_kullanici_adi']) && isset($_POST['kullanici_sifre1']) && ($_POST['kullanici_sifre1'] == $_POST['kullanici_sifre2']))
		{
			$kullanici_id = (int)guvenlik($_POST['kullanici_id']);	
			$kullanici_kullanici_adi = guvenlik($_POST['kullanici_kullanici_adi']);
			$kullanici_sifre = gnc_encrypt(guvenlik($_POST['kullanici_sifre1']));
			$kullanici_tipi  = guvenlik($_POST['kullanici_tipi']);
			$kullanici_aktif  = guvenlik($_POST['kullanici_aktif']);
			$kullanici_adi  = guvenlik($_POST['kullanici_adi']);
			$kullanici_soyadi  = guvenlik($_POST['kullanici_soyadi']);
			
			$vt->query("UPDATE gnc_kullanicilar SET 
							kullanici_kullanici_adi = '$kullanici_kullanici_adi', 
							kullanici_sifre = '$kullanici_sifre', 
							kullanici_tipi = '$kullanici_tipi', 
							kullanici_aktif = '$kullanici_aktif',
							kullanici_adi = '$kullanici_adi', 
							kullanici_soyadi = '$kullanici_soyadi'
						WHERE kullanici_id = '$kullanici_id'");
		}
	}
}
function gnc_model_menuler()
{
	global $vt;
	$sorgu = $vt->query("SELECT * FROM gnc_menuler");	
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;
}
function gnc_model_menu_ekle(){
	global $adres, $vt;
	
	if (isset($_POST['menu_dili']) && isset($_POST['menu_adi']) && isset($_POST['menu_aciklama'])){
		$dil_id  = guvenlik($_POST['menu_dili'] );
		$menu_adi = guvenlik($_POST['menu_adi']);
		$menu_aciklama = guvenlik($_POST['menu_aciklama']);
		
		$vt->query("INSERT INTO gnc_menuler
						(dil_id, menu_adi, menu_aciklama)
					VALUES
						('$dil_id', '$menu_adi', '$menu_aciklama')");
		
		unset($_POST);
		header("Location:".$adres['mevcut']);
	}		
}
function gnc_model_menuleri_agac_yapisinda_goster($menu = 0, $menu_eleman_id = 0, $ic_menu = 0)
{
	global $adres, $dil, $site, $vt;
		
	// Kategorinin altındaki alt kategorileri ağaç yapısı içinde gösteren fonksiyon
	$sorgu = $vt->query("SELECT * FROM gnc_menuler 
						 LEFT JOIN gnc_menulerin_elemanlari ON gnc_menulerin_elemanlari.menu_id = gnc_menuler.menu_id
						 WHERE gnc_menulerin_elemanlari.menu_eleman_id_ust = '$menu_eleman_id' AND gnc_menuler.menu_id = '$menu'
						 ORDER BY gnc_menulerin_elemanlari.menu_eleman_sira ASC ");
	
	// Drag & Drop ile sıralama için gerekli olan yapı, $ic_kategori ana kategori olmadığını bir parent kategorinin child'ı durumunu ifade etmektedir.
	if ($ic_menu == 1)
		echo '<ol>';
	while ($sonuc = $vt->fetch_array($sorgu))
	{
		echo '<li id="list_'.$sonuc['menu_eleman_id'].'">
				<div>
					<span class="disclose"><span></span></span>
					<a href="'. $sonuc['menu_eleman_href'] .'">'. $sonuc['menu_eleman_adi'] .'</a>
					<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['menu_eleman_id'].',\'gnc_yonetim_menu_elemani_sil\',\'list\');" title="'.$dil['sil'].'" class="sortable_silme_tusu hover"><img src="'.$site['url'].'sistem/tasarim/images/icons/delete.png" alt="" /></a>
				</div>';
		gnc_model_menuleri_agac_yapisinda_goster($sonuc['menu_id'], $sonuc['menu_eleman_id'], 1);
		echo '</li>';
	}
	if ($ic_menu == 1)
		echo '</ol>';

}
function gnc_model_menuler_yeni_eleman_yarat(){
	global $dil, $vt;
	
	if (isset($_POST['gnc_yonetim_menu_elemani_menu_id'])){
		if (!empty($_POST['gnc_yonetim_menu_elemani_adi']) && !empty($_POST['gnc_yonetim_menu_elemani_href'])){
			$menu_id = guvenlik($_POST['gnc_yonetim_menu_elemani_menu_id']);
			$adi = guvenlik($_POST['gnc_yonetim_menu_elemani_adi']);
			$href = guvenlik($_POST['gnc_yonetim_menu_elemani_href']);
			$target = guvenlik($_POST['gnc_yonetim_menu_elemani_target']);
			$vt->query("INSERT INTO gnc_menulerin_elemanlari
							(menu_id, menu_eleman_adi, menu_eleman_href, menu_eleman_target, menu_eleman_sira)
						VALUES
							('$menu_id', '$adi', '$href', '$target', '0')");	
		}		
	}
}
// Site için kullanılan diller
function gnc_model_diller(){
	global $adres, $site, $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_diller");
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;		
}
function gnc_model_dil_ekle()
{
	global $adres, $vt;
	
	if (gnc_yetki(111)){
		if (isset($_POST['dil_adi']) && isset($_POST['dil_kodu']) && isset($_FILES['dil_dosyasi'])){
			$dil_adi  = guvenlik($_POST['dil_adi'] );
			$dil_kodu = guvenlik($_POST['dil_kodu']);
			$_FILES['dil_dosyasi']['name'] = $dil_kodu.'.php';
			//*********** UPLOAD İŞLEMİ ***********/
			// Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
			$handle = new Upload($_FILES['dil_dosyasi']);
			  
			// Geçici yükleme işlemi tamamlandı mı kontrol edelim
			// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
			if ($handle->uploaded) { 
				// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
				// Örneğin $handle->Process('/home/www/veri/');
				$dir_dest = 'sistem/diller/';
				$handle->no_script = false; 	// Php, asp gibi script yüklenmesine izin ver, ciddi risk içerir. Sadece geliştiricinin buraya erişimi olmalı!
				$handle->mime_check = false;	// Dosya yükleme sınıfının izin verdiği bir dosyamı değil mi? Bunun kontrolünü devre dışı bırak.
				$handle->Process($dir_dest);
				$handle->mime_check = true;		// Güvenlik riskinden dolayı, mime kontrol özelliğini aktif et!
			}
			$vt->query("INSERT INTO gnc_diller
							(dil_adi, dil_kodu)
						VALUES
							('$dil_adi', '$dil_kodu')");
			header("Location:".$adres['mevcut']);
		}	
	}
}
function gnc_model_moduller($dosya_id = 0){
	global $site, $vt, $adres;
	
	$sorgu = "SELECT * FROM gnc_moduller ";
	if ($dosya_id > 0)
		$sorgu .= " WHERE dosya_id = '$dosya_id' ";
	$sorgu .= "ORDER BY dosya_izin_durumu ASC";

	$sorgu = $vt->query($sorgu);
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;			
}
/* GNC tarafından kullanılan modüllere ekleme yapma
 * 
 * GNC esnek yapısı sayesinde yönetim panelinden görünüm, model ve sql dosyalarının yüklenmesine destek vermektedir.
 * Bu sayede FTP benzeri servera bağlantısı yapmadan istediğiniz modülü sisteme entegre edebilirsiniz. Tabiki bu modüllerin 
 * GNC için hazırlanmış olması veya GNC'nin yapısına uygun olması gerekmektedir.
 * 
 * Not: 1. Modül yükleme sırasında SQL dosyaları çalıştırılacağı için, SQL dosyaları dikkatle kontrol edilmelidir. 
 * Not: 2. Ciddi güvenlik riski oluşturduğu için dikkatle kullanılmalı yada kaldırılmalıdır.
 */
function gnc_model_modul_ekle(){
	global $ayar, $adres, $vt;
	
	if (gnc_yetki(111))
	{
		if (isset($_POST['dosya_adi']) && isset($_POST['dosya_izin_durumu'])){
			$dosya_adi 			 = guvenlik($_POST['dosya_adi'] );
			$dosya_izin_durumu   = guvenlik($_POST['dosya_izin_durumu']);
			
			$dosya_gorunum_cache = guvenlik($_POST['dosya_gorunum_cache']);
			$dosya_model_cache   = guvenlik($_POST['dosya_model_cache']);
			$dosya_header_cache  = guvenlik($_POST['dosya_header_cache']);
			$dosya_footer_cache  = guvenlik($_POST['dosya_footer_cache']);
			
			if (isset($_FILES['dosya_gorunum'])){
				$_FILES['dosya_gorunum']['name'] = $dosya_adi;
				// Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
				$handle = new Upload($_FILES['dosya_gorunum']);
				// Geçici yükleme işlemi tamamlandı mı kontrol edelim
				// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
				if ($handle->uploaded) { 
					// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
					// Örneğin $handle->Process('/home/www/veri/');
					$dir_dest = 'sistem/gorunum/';
					$handle->no_script = false; 	// Php, asp gibi script yüklenmesine izin ver, ciddi risk içerir. Sadece geliştiricinin buraya erişimi olmalı!
					$handle->mime_check = false;	// Dosya yükleme sınıfının izin verdiği bir dosyamı değil mi? Bunun kontrolünü devre dışı bırak.
					$handle->Process($dir_dest);
				}
			} 
			if (isset($_FILES['dosya_model']))
			{
				$_FILES['dosya_model']['name'] = $dosya_adi;
				// Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
				$handle = new Upload($_FILES['dosya_model']);
				// Geçici yükleme işlemi tamamlandı mı kontrol edelim
				// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
				if ($handle->uploaded) { 
					// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
					// Örneğin $handle->Process('/home/www/veri/');
					$dir_dest = 'sistem/model/';
					$handle->no_script = false; 	// Php, asp gibi script yüklenmesine izin ver, ciddi risk içerir. Sadece geliştiricinin buraya erişimi olmalı!
					$handle->mime_check = false;	// Dosya yükleme sınıfının izin verdiği bir dosyamı değil mi? Bunun kontrolünü devre dışı bırak.
					$handle->Process($dir_dest);
				}
			}
			if (isset($_FILES['dosya_sql']))
			{
				// SQL dosyası varsa, çalıştıralım
				$_FILES['dosya_sql']['name'] = $dosya_adi;
				// Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
				$handle = new Upload($_FILES['dosya_sql']);
				// Geçici yükleme işlemi tamamlandı mı kontrol edelim
				// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
				if ($handle->uploaded) { 
					// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
					// Örneğin $handle->Process('/home/www/veri/');
					$dir_dest = 'veri/sql/';
					$handle->no_script = false; 	// Php, asp gibi script yüklenmesine izin ver, ciddi risk içerir. Sadece geliştiricinin buraya erişimi olmalı!
					$handle->mime_check = false;	// Dosya yükleme sınıfının izin verdiği bir dosyamı değil mi? Bunun kontrolünü devre dışı bırak.
					$handle->Process($dir_dest);
					
					$yuklenen_sql_dosyasi = $dir_dest.$handle->file_dst_name;
					require_once('sistem/bloklar/mysql.parse.php');
					sql_dosyasini_calistir($yuklenen_sql_dosyasi);
				}
			}
			// Modülü veritabanına kaydet
			$vt->query("INSERT INTO gnc_moduller
							(dosya_adi, dosya_izin_durumu, dosya_header, dosya_footer,
							 dosya_gorunum_cache, dosya_model_cache, dosya_header_cache, dosya_footer_cache)
						VALUES
							('$dosya_adi', '$dosya_izin_durumu', '', '',
							 '$dosya_gorunum_cache','$dosya_model_cache','$dosya_header_cache','$dosya_footer_cache')");
			
			// Oluşturulan modül için varsayılan dilde yönlendirici yarat				
			$modul_id = $vt->insert_id();
			$yonlendirici_sef = gnc_sef_olustur($dosya_adi);
			$dil_id = $ayar['varsayilan_calisma_dili_id'];
			$vt->query("INSERT INTO gnc_yonlendiriciler
							(dosya_id, yonlendirici_sef, dil_id)
						VALUES
							('$modul_id', '$yonlendirici_sef', '$dil_id')");	
			header("Location:".$adres['mevcut']);
		}	
	}	
}
/* Modüllerin cache sürelerinin düzenlenmesi */
function gnc_model_modul_cache_surelerini_duzenle(){
	global $site, $vt;
	if (gnc_yetki(100)){
		if (isset($_POST['dosya_gorunum_cache']) || isset($_POST['dosya_model_cache']) || isset($_POST['dosya_header_cache']) || isset($_POST['dosya_footer_cache']))
		{
			$dosya_id = (int)guvenlik($_POST['dosya_id']);	
			$dosya_gorunum_cache = guvenlik($_POST['dosya_gorunum_cache']);	
			$dosya_model_cache = guvenlik($_POST['dosya_model_cache']);	
			$dosya_header_cache = guvenlik($_POST['dosya_header_cache']);	
			$dosya_footer_cache = guvenlik($_POST['dosya_footer_cache']);	
			
			
			$vt->query("UPDATE gnc_moduller SET 
							dosya_gorunum_cache = '$dosya_gorunum_cache', 
							dosya_model_cache = '$dosya_model_cache', 
							dosya_header_cache = '$dosya_header_cache', 
							dosya_footer_cache = '$dosya_footer_cache'
						WHERE dosya_id = '$dosya_id'");
		}
	}	
}
/* Modüle uygun olarak yönlendiricilerin listelenmesi
 * 
 * Modül ilk yaratıldığında yönlendiricisi olmayacağı için önce modüller sonra left join ile diğer tablolar çekilmektedir.
 */ 
function gnc_model_yonlendiriciler(){
	global $site, $vt, $adres;
	
	$sorgu = $vt->query("SELECT *,gnc_moduller.dosya_id FROM gnc_moduller
						 LEFT JOIN gnc_yonlendiriciler ON gnc_yonlendiriciler.dosya_id = gnc_moduller.dosya_id
						 LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_yonlendiriciler.dil_id
						 ORDER BY gnc_yonlendiriciler.dosya_id ASC, gnc_yonlendiriciler.dil_id ASC");
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;		
}
function gnc_cache_klasorunu_temizle(){
	global $adres, $site;
	
	// Gizli dosyalar dahil cache klasöründeki dosyaları seçelim
	$files = glob('sistem/cache/{,.}*', GLOB_BRACE);
	
	// Seçili tüm dosyaları tek tek sil
	foreach($files as $file)
	{
		if(is_file($file))
			unlink($file); 
	}
}
// Kategoriler
function gnc_model_kategori($kategori_id)
{
	global $dil, $vt;

	$sorgu = $vt->query("SELECT * FROM gnc_kategoriler 
						 LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_kategoriler.dil_id 
						 WHERE kategori_id = '$kategori_id' LIMIT 1");	
	
	while ($sonuc = $vt->fetch_array($sorgu)){
		
		if ($sonuc['kategori_id_ust'] != 0){
			$ust_kategori_sorgusu = $vt->query("SELECT * FROM gnc_kategoriler WHERE kategori_id = '{$sonuc['kategori_id_ust']}' LIMIT 1");
			$ust_kategori_sonucu = $vt->fetch_array($ust_kategori_sorgusu);
			$sonuc['ust_kategorinin_adi'] = $ust_kategori_sonucu['kategori_adi'];	
		}
		else{
			$sonuc['ust_kategorinin_adi'] = $dil['ana_kategori'];	
		}
		
		
		$sonuclar[] = $sonuc;
	}
   		
	
	return $sonuclar;	
}
function gnc_model_kategoriler($dil_id = 1)
{
	global $dil, $vt;
	$sorgu = 	"SELECT * FROM gnc_kategoriler 
				 LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_kategoriler.dil_id 
				 WHERE gnc_diller.dil_id = '$dil_id' AND kategori_yetki < '{$_SESSION['kullanici_tipi']}'
				 ORDER BY gnc_kategoriler.kategori_id ASC";
	$sorgu = $vt->query($sorgu);	
	
	while ($sonuc = $vt->fetch_array($sorgu)){
		
		if ($sonuc['kategori_id_ust'] != 0){
			$ust_kategori_sorgusu = $vt->query("SELECT * FROM gnc_kategoriler WHERE kategori_id = '{$sonuc['kategori_id_ust']}' LIMIT 1");
			$ust_kategori_sonucu = $vt->fetch_array($ust_kategori_sorgusu);
			$sonuc['ust_kategorinin_adi'] = $ust_kategori_sonucu['kategori_adi'];	
		}
		else{
			$sonuc['ust_kategorinin_adi'] = $dil['ana_kategori'];	
		}
		
		
		$sonuclar[] = $sonuc;
	}
	if (!empty($sonuclar))
   		return $sonuclar;	
}
function gnc_model_kategori_detaylarini_duzenle()
{
	global $site, $vt;
	if (gnc_yetki(100))
	{
		if (isset($_POST['kategori_id']))
		{
			$kategori_id = (int)guvenlik($_POST['kategori_id']);	
			$kategori_adi = guvenlik($_POST['kategori_adi']);
			$kategori_sef = gnc_sef_olustur($kategori_adi);
			$dil_id = guvenlik($_POST['kategori_dil']);
			$kategori_yetki = guvenlik($_POST['kullanici_tipi']);
			
			$vt->query("UPDATE gnc_kategoriler SET 
							kategori_adi = '$kategori_adi', 
							kategori_sef = '$kategori_sef',
							dil_id = '$dil_id',
							kategori_yetki = $kategori_yetki
						WHERE kategori_id = '$kategori_id'");
		}
	}	
}
function gnc_model_kategorileri_agac_yapisinda_goster($kategori_id = 0, $dil_id = 1, $ic_kategori = 0)
{
	global $adres, $dil, $site, $vt;
		
	// Kategorinin altındaki alt kategorileri ağaç yapısı içinde gösteren fonksiyon
	$sorgu = $vt->query("SELECT * FROM gnc_kategoriler 
						 LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_kategoriler.dil_id
						 WHERE kategori_id_ust = '$kategori_id' AND gnc_diller.dil_id = '$dil_id'
						 ORDER BY gnc_kategoriler.kategori_sira ASC ");
	
	// Drag & Drop ile sıralama için gerekli olan yapı, $ic_kategori ana kategori olmadığını bir parent kategorinin child'ı durumunu ifade etmektedir.
	if ($ic_kategori == 1)
		echo '<ol>';
	while ($sonuc = $vt->fetch_array($sorgu))
	{
		echo '<li id="list_'.$sonuc['kategori_id'].'">
				<div>
					<span class="disclose"><span></span></span>'. $sonuc['kategori_adi'] .'
					<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['kategori_id'].',\'gnc_yonetim_kategori_sil\',\'list\');" title="'.$dil['sil'].'" class="sortable_silme_tusu hover"><img src="'.$site['url'].'sistem/tasarim/images/icons/delete.png" alt="" /></a>
				</div>';
		gnc_model_kategorileri_agac_yapisinda_goster($sonuc['kategori_id'], $dil_id, 1);
		echo '</li>';
	}
	if ($ic_kategori == 1)
		echo '</ol>';

}
function gnc_model_kategoriler_yeni_kategori_ekle(){
	global $vt;
	
	if (isset($_POST['kategori_adi'])){
		$kategori_adi = guvenlik($_POST['kategori_adi']);
		$kategori_resmi = guvenlik($_POST['kategori_resmi']);
		$kategori_dil_id = guvenlik($_POST['kategori_dil_id']);
		$kategori_ust_id = guvenlik($_POST['kategori_ust_kategori_id']);
		$kategori_sira = guvenlik($_POST['kategori_sira']);
		$kullanici_tipi = guvenlik($_POST['kullanici_tipi']);
		
		// Arama motoru dostu bağlantı adresi oluştur
		$kategori_sef = gnc_sef_olustur($kategori_adi);
		
		// Yeni kategoriyi oluştur
		$vt->query("INSERT INTO gnc_kategoriler
						(kategori_id_ust, dil_id, kategori_adi, kategori_sef, kategori_sira, kategori_yetki)
					VALUES
					 	('$kategori_ust_id', '$kategori_dil_id', '$kategori_adi', '$kategori_sef', '$kullanici_tipi')");
	}	
}
// İçerikler
function gnc_model_icerikler($icerik_sef = 0)
{
	global $adres, $vt;
	$sorgu = "SELECT *, gnc_icerikler.icerik_id AS icerik_id, gnc_icerikler.dil_id AS dil_id FROM gnc_icerikler
			  LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_icerikler.dil_id 
			  LEFT JOIN gnc_kullanicilar ON gnc_kullanicilar.kullanici_id = gnc_icerikler.kullanici_id 
			  LEFT JOIN gnc_iceriklerin_kategorileri ON gnc_iceriklerin_kategorileri.icerik_id = gnc_icerikler.icerik_id 
			  LEFT JOIN gnc_kategoriler ON gnc_kategoriler.kategori_id = gnc_iceriklerin_kategorileri.kategori_id 
			  LEFT JOIN gnc_iceriklerin_benzer_icerikleri ON gnc_iceriklerin_benzer_icerikleri.icerik_id = gnc_icerikler.icerik_id 
			  LEFT JOIN gnc_iceriklerin_sablonlari ON gnc_iceriklerin_sablonlari.icerik_id = gnc_icerikler.icerik_id 
			  ";
			  
	 		  
	if (!empty($adres['url2']))
		$sorgu .= " WHERE gnc_icerikler.icerik_sef = '{$adres['url2']}' LIMIT 1";
	else
		$sorgu .= " WHERE gnc_kategoriler.kategori_yetki < '{$_SESSION['kullanici_tipi']}'
					GROUP BY gnc_icerikler.icerik_id 
					ORDER BY gnc_icerikler.icerik_id ASC
					";

	$sorgu = $vt->query($sorgu);
	while ($sonuc = $vt->fetch_array($sorgu)){
		if (!empty($adres['url2'])){
			if (!empty($sonuc['icerik_buyuk_resim_id'])){
				$buyuk_resim_sorgu = $vt->query("SELECT * FROM gnc_veriler WHERE veri_id = '{$sonuc['icerik_buyuk_resim_id']}' LIMIT 1");	
				$buyuk_resim_sonuc = $vt->fetch_array($buyuk_resim_sorgu);
				$sonuc['buyuk_resim_yolu'] = $buyuk_resim_sonuc['veri_yolu'];
			}
			if (!empty($sonuc['icerik_kucuk_resim_id'])){
				$kucuk_resim_sorgu = $vt->query("SELECT * FROM gnc_veriler WHERE veri_id = '{$sonuc['icerik_kucuk_resim_id']}' LIMIT 1");
				$kucuk_resim_sonuc = $vt->fetch_array($kucuk_resim_sorgu);
				$sonuc['kucuk_resim_yolu'] = $kucuk_resim_sonuc['veri_yolu'];
			}
		}
		
		$sonuclar[] = $sonuc;
	}
   		
	
	return $sonuclar;	
}
function gnc_model_iceriklerin_kategorileri($icerik_id){
	global $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_iceriklerin_kategorileri
			  			 LEFT JOIN gnc_kategoriler ON gnc_kategoriler.kategori_id = gnc_iceriklerin_kategorileri.kategori_id
			  			 WHERE gnc_iceriklerin_kategorileri.icerik_id = '$icerik_id'");
	if ($vt->num_rows($sorgu) > 0){
		while ($sonuc = $vt->fetch_array($sorgu))
   			$sonuclar[] = $sonuc;
	
		return $sonuclar;	
	}
	
}
function gnc_model_iceriklerin_benzer_icerikler($icerik_id, $benzer_mi = 1)
{
	global $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_iceriklerin_benzer_icerikleri
					 LEFT JOIN gnc_icerikler ON gnc_icerikler.icerik_id = gnc_iceriklerin_benzer_icerikleri.benzer_icerik_id
					 WHERE gnc_iceriklerin_benzer_icerikleri.icerik_id = '$icerik_id'");
					 
	while ($sonuc = $vt->fetch_array($sorgu))
		$benzer_sonuclar[] = $sonuc;
	
	if ($benzer_mi == 1)
	{
		return $benzer_sonuclar;
	}
	else
	{
		$sorgu = $vt->query("SELECT * FROM gnc_icerikler
							 WHERE gnc_icerikler.icerik_id <> '$icerik_id'");
							 
		while ($sonuc = $vt->fetch_array($sorgu))
			$sonuclar[] = $sonuc;

		error_reporting(0);
		if (!empty($benzer_sonuclar))
		{
			foreach ($benzer_sonuclar AS $benzer)
			{
				for($i=0; $i<count($sonuclar); $i++)
				{
					if ($benzer['icerik_id'] == $sonuclar[$i]['icerik_id'])
						unset ($sonuclar[$i]);
				}	
			}	
		}
		return $sonuclar;		
	}	
}
function gnc_model_iceriklerin_sablonlari($icerik_id){
	global $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_iceriklerin_sablonlari 
			  			 LEFT JOIN gnc_sablonlarin_icerikleri ON gnc_sablonlarin_icerikleri.sablon_icerik_id = gnc_iceriklerin_sablonlari.sablon_icerik_id
			  			 WHERE gnc_iceriklerin_sablonlari.icerik_id = '$icerik_id'");
	if ($vt->num_rows($sorgu) > 0){
		while ($sonuc = $vt->fetch_array($sorgu))
   			$sonuclar[] = $sonuc;
	
		return $sonuclar;	
	}
	
}
function gnc_model_sablonlar($dil_id = 0){
	global $vt;
	
	$sorgu = "SELECT * FROM gnc_sablonlar
			  LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_sablonlar.dil_id
			  LEFT JOIN gnc_sablonlarin_icerikleri ON gnc_sablonlarin_icerikleri.sablon_id = gnc_sablonlar.sablon_id ";
	if ($dil_id > 0)
		$sorgu .= "WHERE gnc_sablonlar.dil_id = '$dil_id' ";
	
	$sorgu .= "GROUP BY gnc_sablonlar.sablon_id ";
	
	$sorgu = $vt->query($sorgu);
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	if (!empty($sonuclar))
		return $sonuclar;	
}
function gnc_model_sablonlarin_icerikleri($sablon_id){
	global $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_sablonlarin_icerikleri 
						 WHERE sablon_id = '$sablon_id' ");
	if ($vt->num_rows($sorgu) > 0){
		while ($sonuc = $vt->fetch_array($sorgu))
   			$sonuclar[] = $sonuc;
	
		return $sonuclar;		
	}
	
}
function gnc_model_sablonlar_yeni_sablon_ekle(){
	global $ayar, $vt;
	
	if (isset($_POST['gnc_yonetim_yeni_sablon_adi']) && isset($_POST['gnc_yonetim_yeni_sablon_dil']) && ($_POST['gnc_yonetim_yeni_sablon_dil'] > 0) && isset($_POST['gnc_yonetim_yeni_sablon_alani_1'])){
		$sablon_dil = guvenlik($_POST['gnc_yonetim_yeni_sablon_dil']);
		$sablon_adi = guvenlik($_POST['gnc_yonetim_yeni_sablon_adi']);
		$sablon_aciklama = guvenlik($_POST['gnc_yonetim_yeni_sablon_aciklama']);
		
		// Şablon oluştur
		$vt->query("INSERT INTO gnc_sablonlar 
						(dil_id, sablon_adi, sablon_aciklama)
					VALUES
					 	('$sablon_dil','$sablon_adi','$sablon_aciklama')");
		$sablon_id = $vt->insert_id();
		
		// Şablon içeriklerini doldur
		for ($i=1; $i < $ayar['sablon_eleman_sayisi']; $i++){
			if (isset($_POST['gnc_yonetim_yeni_sablon_alani_'.$i])){
				$sablon_alani[$i] = guvenlik($_POST['gnc_yonetim_yeni_sablon_alani_'.$i]);
			
				$sorgu = $vt->query("INSERT INTO gnc_sablonlarin_icerikleri 
							(sablon_id, sablon_icerik_adi, sablon_icerik_aciklama)
						VALUES 
							('$sablon_id', '{$_POST['gnc_yonetim_yeni_sablon_alani_'.$i]}', '{$_POST['gnc_yonetim_yeni_sablon_aciklama_'.$i]}') ");
			}
		}
	}
	unset($_POST);
}
function gnc_model_kitalar(){
	global $vt;
	$sorgu = $vt->query("SELECT * FROM gnc_veriler_kitalar");
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;	
	return $sonuclar;	
}
function gnc_model_ulkeler(){
	global $vt;
	$sorgu = $vt->query("SELECT * FROM gnc_veriler_ulkeler ORDER BY ulke_adi ASC");
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;	
	return $sonuclar;	
}
function gnc_model_yeni_ulke_ekle(){
	global $vt;
	if (isset($_POST['kita_id']) && isset($_POST['ulke_adi'])){
		$kita_id  = (int)guvenlik($_POST['kita_id']);
		$ulke_adi = guvenlik($_POST['ulke_adi']);
		$vt->query("INSERT INTO gnc_veriler_ulkeler 
						(kita_id, ulke_adi)
					VALUES
						('$kita_id', '$ulke_adi')");		
	}
	unset($_POST);
}
function gnc_model_iller(){
	global $vt;
	$sorgu = $vt->query("SELECT * FROM gnc_veriler_iller ORDER BY il_adi ASC");
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;	
	return $sonuclar;	
}
function gnc_model_yeni_il_ekle(){
	global $vt;
	if (isset($_POST['kita_id']) && isset($_POST['ulke_adi'])){
		$ulke_id = (int)guvenlik($_POST['ulke_id']);
		$il_adi  = guvenlik($_POST['il_adi']);
		$il_kodu = guvenlik($_POST['il_kodu']);
		$vt->query("INSERT INTO gnc_veriler_iller 
						(ulke_id, il_adi, il_kodu)
					VALUES
						('$ulke_id', '$il_adi', '$il_kodu')");		
	}
	unset($_POST);
}
function gnc_model_universiteler(){
	global $vt;
	$sorgu = $vt->query("SELECT * FROM gnc_veriler_universiteler");
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;	
	return $sonuclar;	
}
function gnc_model_yeni_universiteler_ekle(){
	global $vt;
	if (isset($_POST['il_id']) && isset($_POST['uni_adi']) && isset($_POST['uni_kodu'])){
		$il_id 	  = (int)guvenlik($_POST['il_id']);
		$uni_adi  = guvenlik($_POST['uni_adi']);
		$uni_kurulus_tarihi = (int)guvenlik($_POST['uni_kurulus_tarihi']);
		$uni_eposta = guvenlik($_POST['uni_eposta']);
		$vt->query("INSERT INTO gnc_veriler_universiteler 
						(il_id, uni_adi, uni_kurulus_tarihi, uni_eposta)
					VALUES
						('$ulke_id', '$uni_adi', '$uni_kurulus_tarihi', '$uni_eposta')");		
	}
	unset($_POST);
}
function gnc_model_iletisim_formu($id = 0){
	global $site, $vt;
	
	$sorgu = "SELECT * FROM gnc_iletisim_formu ";
	if ($id > 0)
		$sorgu .= "WHERE iletisim_id = '{$id}'";
	$sorgu = $vt->query($sorgu);
	
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;
}
/* ePosta gönderme sayfasından gelen veriyi listede yer alan ePosta adreslerine yolla
 * 
 * Burada dikkat edilmesi gereken, listenin yanında özel olarak yazılan ePosta adreslerine de mesajın gönderilmesidir.
 */ 
function gnc_eposta_gonder(){
	if (isset($_POST['gnc_yonetim_eposta_liste']) && isset($_POST['gnc_yonetim_eposta_konu']) && isset($_POST['gnc_yonetim_eposta_icerik'])){
		$liste  = guvenlik($_POST['gnc_yonetim_eposta_liste']);
		$ozel	= guvenlik($_POST['gnc_yonetim_eposta_ozel']);
		$konu   = guvenlik($_POST['gnc_yonetim_eposta_konu']);
		$mesaj  = guvenlik($_POST['gnc_yonetim_eposta_icerik']);
		
		for ($i==0; $i<count($liste); $i++)
			gnc_mail($liste[$i],$konu,$mesaj);
	}
}
function gnc_model_albumler($album_id = 0){
	global $vt;
	
	$sorgu = "SELECT *, gnc_albumler.album_id, gnc_veriler.veri_yolu FROM gnc_albumler 
			  LEFT JOIN gnc_albumlerin_verileri ON gnc_albumlerin_verileri.album_id = gnc_albumler.album_id 
			  LEFT JOIN gnc_veriler ON gnc_albumlerin_verileri.veri_id = gnc_veriler.veri_id ";
	
	if ($album_id > 0)	  
		$sorgu .= " WHERE gnc_albumler.album_id = '$album_id' ";
	
	$sorgu .= " GROUP BY gnc_albumler.album_id  ";
	
	$sorgu = $vt->query($sorgu);
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;
}
function gnc_model_album_verileri($album_id){
	global $vt;
	
	$sorgu = $vt->query("SELECT * FROM gnc_albumlerin_verileri 
						 LEFT JOIN gnc_veriler ON gnc_veriler.veri_id = gnc_albumlerin_verileri.veri_id
						 WHERE album_id = '$album_id'");
	$sonuclar = '';
	while ($sonuc = $vt->fetch_array($sorgu))
   		$sonuclar[] = $sonuc;
	
	return $sonuclar;	
}
function gnc_model_album_ekle(){
	global $site, $vt;
	
	if (isset($_POST['gnc_yonetim_yeni_album_adi'])){
		$album_adi = guvenlik($_POST['gnc_yonetim_yeni_album_adi']);
		$album_aciklama = guvenlik($_POST['gnc_yonetim_yeni_album_aciklama']);
		$album_thumb_en = guvenlik($_POST['gnc_yonetim_yeni_album_thumb_en']);
		$album_thumb_boy = guvenlik($_POST['gnc_yonetim_yeni_album_thumb_boy']);
		$album_crop_en = guvenlik($_POST['gnc_yonetim_yeni_album_crop_en']);
		$album_crop_boy = guvenlik($_POST['gnc_yonetim_yeni_album_crop_boy']);
	
		$vt->query("INSERT INTO gnc_albumler
						(kullanici_id, veri_id, album_adi, album_aciklama, album_thumb_en, album_thumb_boy, album_crop_en, album_crop_boy, album_tarih)
					VALUES
						('{$_SESSION['kullanici_id']}', '0', '$album_adi', '$album_aciklama', '$album_thumb_en', '$album_thumb_boy', '$album_crop_en', '$album_crop_boy' ,'{$site['bugun']}')");
	}
		
}
function gnc_model_veriler($veri_tipi, $veri_id = 0){
	global $site, $vt;
	
	$sorgu = "SELECT * FROM gnc_veriler WHERE "; 
	
	if ($veri_id > 0)
	{
		$sorgu .= "veri_id = '$veri_id'";
	}
	else
	{
		$say = count($veri_tipi);
		for ($i=0; $i<$say; $i++)
		{
			if ($i != $say-1)
				$sorgu .= "veri_tipi = '{$veri_tipi[$i]}' OR ";	
			else
				$sorgu .= "veri_tipi = '{$veri_tipi[$i]}'";	 
		}	
	}
		
	$sorgu = $vt->query($sorgu);
	
	while ($sonuc = $vt->fetch_array($sorgu)){
		// Veri tipine uygun olarak href vs.. belirle
		if ($sonuc['veri_tipi'] == 1)
			$sonuc['href'] = $site['url'].'yonetim/resim?resim='.$sonuc['veri_yolu'];
		else 
			$sonuc['href'] = 'javascript:void(0)';	

		if ($sonuc['veri_tipi'] == 2)
			$sonuc['video'] = '<video controls="controls"><source type="video/webm" src="http://stream.flowplayer.org/bauhaus/624x260.webm"></video>';
		if ($sonuc['veri_tipi'] == 21)
			$sonuc['video'] = '<iframe width="560" height="315" src="'.$sonuc['veri_yolu'].'" frameborder="0" allowfullscreen></iframe>';
			
		// Eğer veri normal yollarla yüklenen bir veri ise, tam veri yolunu tanımla
		if ($sonuc['veri_tipi'] < 10)
			$sonuc['veri_yolu'] = $site['url'].'veri/dosyalar/'.$sonuc['veri_yolu'];

		$sonuclar[] = $sonuc;
	}
	return $sonuclar;
}
function gnc_model_dosya_yukle(){
	global $ayar, $site, $vt;

	if (isset($_POST['dosya_tipi'])){			
		$veri_tipi = guvenlik($_POST['dosya_tipi']);
		$veri_aciklama = guvenlik($_POST['dosya_aciklama']);
		
		// Harici embed vs. şeklinde veri yükleme için değişkenleri tanımla
		if (!empty($_POST['dosya_url_adresi'])){
			$veri_adi  = guvenlik($_POST['dosya_url_adresi']);
			$veri_yolu = guvenlik($_POST['dosya_url_adresi']);	
		}	
		if (isset($_FILES['dosya'])){ 
			//*********** UPLOAD İŞLEMİ ***********/
			// Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
			$handle = new Upload($_FILES['dosya']);
			  
			// Geçici yükleme işlemi tamamlandı mı kontrol edelim
			// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
			if ($handle->uploaded) { 
				// Dosyamız sunucuda
				// Eğer yüklenen dosya resimse, dosyayı kalıcı konumuna almadan bir kaç değişiklik yapalım.
				// Resim değilse direk yükleme yapar
				$handle->image_resize	= true;
				$handle->image_ratio_y	= true;
				$handle->image_x		= 1200;
				
				// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
				// Veri tipi resimse değer 1 olur
				$veri_tipi = $handle->file_is_image;
				if ($handle->file_is_image)
					$dir_dest = $site['resim_yuklenecek_adres'];
				else	
					$dir_dest = $site['dosya_yuklenecek_adres'];
				
				$handle->Process($dir_dest);
				
				// Gözat tuşu ile dosya yüklenmesi
				$veri_adi  = guvenlik($handle->file_dst_name_body);
				$veri_yolu = guvenlik($handle->file_dst_name);
				if (empty($veri_aciklama))
					$veri_aciklama = $veri_adi;
			}	
		}
		$vt->query("INSERT INTO gnc_veriler
						(veri_adi, veri_yolu, veri_tipi, veri_aciklama, veri_tarih)
					VALUES
						('$veri_adi', '$veri_yolu', '$veri_tipi', '$veri_aciklama', '{$site['bugun']}')");
		
		// Yüklenen veri resim ise kırpmak için 	
		if ($veri_tipi == 1)
			header('Location: '.$site['url'].'yonetim/resim/?resim='.$veri_yolu.'');
		
		unset($_POST);
		unset($_FILES);
	}
}


