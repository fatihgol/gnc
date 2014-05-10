<?php
if (!defined('gnc'))
	die();

if (isset($_POST['kullanici_kullanici_adi']) && isset($_POST['kullanici_sifre']))
{
	$kullanici = new kullanici();
	$kullanici->kullanici_giris($_POST['kullanici_kullanici_adi'],$_POST['kullanici_sifre']);
}	
/* Genel kullanıcı işlemlerini yapan class
 *  
 * Basitlik ön planda tutulan bu class ile kullanıcılar üzerinde yapılabilecek temel işlemler tanımlanmıştır.
 * 
 */
class kullanici
{
	// Giriş formunu dolduran potansiyel bir kullanıcının giriş işlemini yapan fonksiyon
	function kullanici_giris($kullanici_kullanici_adi, $kullanici_sifre)
	{
		global $ayar, $dil, $site, $vt;
		
		// Verileri güvenlik fonksiyonundan geçir, geldiği sırayla veri tabanına kaydet
		$kullanici_kullanici_adi = guvenlik($kullanici_kullanici_adi);
		
		// Kullanıcını şifresinin hashini almayı sağlayan fonksiyon, istenirse ikinci bir parametreyi, kripto anahtarı olarak alabilir.
		$kullanici_sifre = gnc_encrypt($kullanici_sifre);
		
		$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar 
						 	WHERE kullanici_kullanici_adi = '{$kullanici_kullanici_adi}' AND kullanici_sifre = '{$kullanici_sifre}'
						 	LIMIT 1");
							
		
		$sonuc = $vt->fetch_array($sorgu);
		if ($sonuc)
		{
			// Aktif kullanıcı	
			if ($sonuc['kullanici_aktif'] == 1)
			{
				/* Kullanıcı tablosunda güncellemme yap
				 * 
				 * kullanici_timestamp ve kullanici_ip her sayfa yenilendiğinde otomatik olarak atanmaktadır. 
				 * Giriş sırasında bunu veritabanına kaydetmek yerinde olacaktır.
				 */
				$vt->query("UPDATE gnc_kullanicilar 
							SET kullanici_son_timestamp = '{$_SESSION['kullanici_timestamp']}',
								kullanici_son_ip = '{$_SESSION['kullanici_ip']}'
							WHERE kullanici_id = '{$sonuc['kullanici_id']}'");
			
				gnc_kullanici_oturumu($sonuc);
			
				if ($sonuc['kullanici_tipi'] < 100)
					header("Location:".$site['url']);
				else
					header("Location:".$site['url'].'yonetim');	
			}	
			// Yasaklanan / Engellenen kullanıcı
			elseif ($sonuc['kullanici_aktif'] == 0)
				echo $dil['kullanicinin_siteye_erisimi_yasaklanmistir'];	
			// Hiç aktivasyon yapmamış kullanıcı
			else
				echo $dil['giris_aktivasyon_yapilmamis'];	
		}
		echo $dil['giris_islemi_basarisiz_oldu_lutfen_tekrar_deneyin'];
		return false;
	}	
	/* Yeni kullanıcının kayıt olması, geliştiricinin istediği şekilde kayıt tipine göre filtreleme de yapılabilir. Nasıl filtreleme yapılacağına
	 * ayarlar sayfasından karar verilmelidir.
	 * 
	 * $kullanici->kullanici_kayit('guncebektas@gmail.com', 1, 1);
	 * şeklinde kullanılabilir. Yapılmayacaksa
	 * 
	 * gnc_kullanicilar tablosunda zorunlu olan 3 alan mevcuttur. Bunlar kullanici_kullanici_adi, kullanici_sifre, kullanici_tipi'dir.
	 * kullanici_kullanici_adi => kullanıcının giriş yaparken kullanacağı isim, ePosta adresi vs. dir.
	 * kullanici_sifre => kullanıcının şifresinin hashli halidir.
	 * kullanici_tipi  => kullanıcının yetkisini belirleyen kullanıcı tipidir.
	 */ 
	function kullanici_kayit($kullanici_kullanici_adi, $kullanici_sifre, $kullanici_sifre2)
	{
		global $ayar, $dil, $vt;
		// Şifreleri kontrol et, eğer uyuşuyorsa hash'le, uyuşmuyorsa false döndür
		if (!empty($kullanici_kullanici_adi) && !empty($kullanici_sifre) && $kullanici_sifre == $kullanici_sifre2)
		{
			$kullanici_kullanici_adi = guvenlik($kullanici_kullanici_adi);
			$sifre = gnc_encrypt($kullanici_sifre);
			$sifre2 = gnc_encrypt($kullanici_sifre2);
		}
		else 
		{
			echo $dil['kayit_sifreler_uyusmuyor'];
			return false;
		}
		// Kaydı yapılan kullanıcı zaten mevcut mu kontrol edelim, mevcut ve bilgileri doğruysa giriş yaptıralım, aksi durumda false döndür
		if (isset($kullanici_kullanici_adi))
		{
			$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar WHERE kullanici_kullanici_adi = '$kullanici_kullanici_adi' LIMIT 1");
			$sonuc = $vt->fetch_array($sorgu);
			
			if ($sonuc)
			{
				echo $dil['kayit_boyle_bir_kullanici_zaten_kayitlidir'];
				
				// Eğer böyle bir hesap varsa, şifreler uyuşuyorsa ve kullanıcı aktif bir kullanıcıysa giriş yap
				if ($sonuc['kullanici_sifre'] == $sifre && $sonuc['kullanici_aktif'] == 1)
					$this->kullanici_giris($kullanici_kullanici_adi,$kullanici_sifre);
				// Böyle bir kullanıcı var ancak kullanıcı yasaklanmış / engellenmiş
				elseif ($sonuc['kullanici_sifre'] == $sifre && $sonuc['kullanici_aktif'] == 0)
					echo $dil['kullanicinin_siteye_erisimi_yasaklanmistir'];	
				// Böyle bir kullanıcı var ancak hiç aktivasyon yapmamış, bu durum belirtilmeli hatta kullanıcının isteğine göre yeni aktivasyon gönderilmeli
				else
					echo $dil['giris_aktivasyon_yapilmamis'];		
				
				return false;
			}
		}
		
		/* KAYDI GERÇEKLEŞTİR
		 * 
		 * Kullanıcı_adı olarak kullanılacak değişkeni filtresine göre kontrol edelim, ve kayıt işlemini tamamlayalım.
		 * Not: Filtreleme olarak tek bir aktivasyon metodu tasarlanmıştır. Hem email, hem SMS gibi farklı modeller için aktivasyon kodları ayrı bir tabloda türlerine uygun olarak tutulmalıdır.
		 */
		// Fonksiyon içerisinde filtreyi tanımla
		$filtre = (int)$ayar['kullanici_kaydi'];
		
		if ($filtre == 0)		// Filtresiz kayıt sistemi için kullanılacak
		{
		    echo $dil['kayit_tamamlanmistir'];
			return true;
		}
		elseif ($filtre == 1)	// Özel bir filtreleme sistemi kullanılacaksa buna ait filtrelemeyi burada tanımlayabilirsiniz.
		{
		
		}
		else 					// Filtrelenmiş kayıt sistemi için kullanılacak
		{
			if (filter_var($kullanici_kullanici_adi, $filtre )) 
			{
				// ePosta filtrelemesi için 274 tanımlanmıştır. Bunu kontrol edip kullanıcının hesabına doğrulama kodu yollayalım.
				if ($filtre == 'FILTER_VALIDATE_EMAIL' ){
					echo $dil['kayit_tamamlanmistir_lutfen_hesabinizi_aktiflestirin'];
					// Aktivasyon kodunu kullanici_aktif bölümüne yazalım
					$aktivasyon_kodu = rand(10000,99999);
					// mesajı aktivasyon koduyla birlikte oluşturark mail'in içeriğini yaratalım
					$mesaj = '	<html>
									<body>
									  <h3>'.$dil['aktivasyon_kodu'].'</h3>
									  <p><a href="'.$site['url'].'/giris/'.$aktivasyon_kodu.'">'. $dil['aktivasyon_icin_tiklayin'] .'</a></p>
									</body>
								</html>';
					gnc_mail($kullanici_kullanici_adi,$dil['aktivasyon_maili'],$mesaj);	
				}
				
				$vt->query("INSERT INTO gnc_kullanicilar 
								(kullanici_kullanici_adi, kullanici_sifre, kullanici_tipi, kullanici_aktif) 
							VALUES 
							 	('$kullanici_kullanici_adi','$sifre','1', '$aktivasyon_kodu')");
				return true;
			}
			else
			{
			    echo $dil['kayit_icin_gerekli_bilgileri_hatali_girdiniz'];
			}
		}
		return false;
	}
	function kullanici_aktivasyonunu_yap($kullanici_kullanici_adi, $akvasyon_kodu)
	{
		global $ayar, $dil, $vt;
		
		$kullanici_kullanici_adi = guvenlik($kullanici_kullanici_adi);
		$akvasyon_kodu = guvenlik($akvasyon_kodu);
		
		// Kullanıcı bilgileri
		$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar 
							 WHERE kullanici_kullanici_adi = '$kullanici_kullanici_adi'
							 LIMIT 1");
		$sonuc = $vt->fetch_array($sorgu);
		
		// Kullanıcı zaten aktif, yapabileceği 2 işlem var; şifresini girip giriş yapabilir yada şifresini unutmuş olabilir
		if ($sonuc['kullanici_aktif'] == 1)
		{
			echo $dil['aktivasyon_islemi_daha_once_basariyla_tamamlanmistir_lutfen_giris_yapin'];
			return false;	
		}
		// Aktivasyonu gerçekleştir
		elseif ($sonuc['kullanici_aktif'] == 0)
		{
			echo $dil['aktivasyon_islemi_basarisiz_olmustur_bu_kullanicinin_siteye_erisimi_yasaklanmistir'];	
			return false;	
		}
		// Aktivasyonu gerçekleştir
		elseif ($sonuc['kullanici_aktif'] == $akvasyon_kodu)
		{
			echo $dil['aktivasyon_islemi_basariyla_tamamlanmistir'];
			$vt->query("UPDATE gnc_kullanicilar SET kullanici_aktif = 1 WHERE kullanici_kullanici_adi = '$kullanici_kullanici_adi' AND kullanici_aktif = '$akvasyon_kodu' LIMIT 1");
			// Giriş yap
			$this->kullanici_giris($kullanici_kullanici_adi,$sonuc['kullanici_sifre']);
			return false;			
		}
	}
	function kullanici_sifremi_unuttum($kullanici_kullanici_adi)
	{
		global $ayar, $dil, $vt;
		
		// Fonksiyon içerisinde filtre tanımlanmamışsa
		$filtre = (int)$ayar['kullanici_kaydi'];
		
		$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar WHERE kullanici_kullanici_adi = '$kullanici_kullanici_adi' LIMIT 1");
		$sonuc = $vt->fetch_array($sorgu);	
		
		if ($sonuc)
		{
			if ($filtre == 'FILTER_VALIDATE_EMAIL' )
			{
				// Şiresini değiştir
				$yeni_sifre = $this->kullanici_sifresini_degistir($kullanici_kullanici_adi);
				// Mesajı aktivasyon koduyla birlikte oluşturark mail'in içeriğini yaratalım
				$mesaj = $dil['yeni_sifre'].' '.$yeni_sifre;
				if (filter_var($kullanici_kullanici_adi, $filtre )) 
					gnc_mail($kullanici_kullanici_adi,$dil['yeni_sifre_maili'],$mesaj);	
			}	
			else
			{
				// Soru cevap mantığıyla çalışan yada farklı bir şekilde kullanıcının tanınmasını sağlarak yeni şifre belirlemesi yapan fonksiyon burada tanımlanmalıdır
				
			}
		}
		else 
		{
			// Böyle bir kullanıcı bulunamadı. Daha önce kayıt yapılmamış
			echo $dil['boyle_bir_kullanici_bulunamadi'];
		}
	}
	private function kullanici_sifresini_degistir($kullanici_kullanici_adi)
	{
		global $vt;
		
		$yeni_sifre = rand(10000,99999);
		$yeni_sifre_hash = gnc_encrypt($yeni_sifre);
		$vt->query("UPDATE gnc_kullanicilar SET kullanici_sifre = '$yeni_sifre_hash' WHERE kullanici_kullanici_adi = '$kullanici_kullanici_adi' LIMIT 1");
		return $yeni_sifre;			
	}
	// Yeni kullanıcı ekleme işlemi, kullanıcı kayıt işlemi değildir. Farkı kullanici_kullanici_adi için her hangi bir filtreleme kullanılmaması olup zorunlu alanların dışındaki verilerin kaydının yapılmasına olanak sağlar
	function kullanici_ekle($kullanici_kullanici_adi, $kullanici_sifre, $kullanici_tipi, $kullanici_grup = 1, $kullanici_adi = '', $kullanici_soyadi = '', $kullanici_resim_id = '')
	{
		global $vt;
		
		// Verileri güvenlik fonksiyonundan geçir, geldiği sırayla veri tabanına kaydet
		$say = func_num_args();
		$parametreler = func_get_args();
	    for ($i = 0; $i < $say; $i++) 
	    {
	        $veri[$i] = guvenlik($parametreler[$i]);
	    }
		
		// Kullanıcını şifresinin hashini almayı sağlayan fonksiyon, istenirse ikinci bir parametreyi, kripto anahtarı olarak alabilir.
		$veri[1] = gnc_encrypt($kullanici_sifre);
		
		// Kullanıcı verilerini veritabanına ekle
		$vt->query("INSERT INTO gnc_kullanicilar 
						(kullanici_kullanici_adi, kullanici_sifre, kullanici_tipi,
						 kullanici_grup, 
						 kullanici_adi, kullanici_soyadi, kullanici_resim_id) 
					VALUES 
					 	('{$veri[0]}','{$veri[1]}','{$veri[2]}',
					 	 '{$veri[3]}',
					 	 '{$veri[4]}','{$veri[5]}','{$veri[6]}')");
		 
		return true;
	}	
	
	// Kayıtlı kullanıcıyı silme işlemi
	function kullanici_sil($kullanici_id)
	{
		global $vt;
		
		$vt->query("DELETE FROM gnc_kullanicilar 
					WHERE kullanici_id = '$kullanici_id'");
					
		if ($vt->affected_rows())			
			return true;
		else
			return false;
	}
	// Kullanıcı id'si gelen kullanıcının verilerini döndüren fonksiyon, veri yoksa false döndürür
	function kullanici_bilgisi($kullanici_id)
	{
		global $vt;
		
		$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar 
							 WHERE kullanici_id = '$kullanici_id'
							 LIMIT 1");
					
		if ($vt->num_rows($sorgu))
		{			
			$sonuc = $vt->fetch_array($sorgu);
			unset($sonuc['kullanici_sifre']);
			
			return $sonuc;
		}
		else
		{
			return false;
		}
	}
	// Kullanıcı tipine göre kullanıcıları listeleyen fonksiyon
	function kullanici_listesi($kullanici_tipi = 0) 
	{
		global $vt;
		
		$sorgu  = "SELECT * FROM gnc_kullanicilar ";
		
		if ($kullanici_tipi > 0)
			$sorgu .= "WHERE kullanici_tipi = '$kullanici_tipi'";
		
		$sorgu = $vt->query($sorgu);
		while ($sonuc = $vt->fetch_array($sorgu))
			$sonuclar[] = $sonuc;
			
		return $sonuclar;
	}
	// Bilgi fonksiyonu, class içindeki bilgi fonksiyonu çağırıldığında class'ın ne yaptığı ve içeriği hakkında temel bilgiler sunulur.1
	function bilgi()
	{
		echo '	<h5>Kullanıcı class\'ı kullanıcı ile ilgili her türlü işlemi yapmayı sağlar </h5>
				<ul>
					<li>kullanici_giris(): kullanıcı girisini yapan kullanıcı yetkisine göre yönlendirme yapan fonksiyon</li>
				  	<li>kullanici_kayit(): kullanici kayıt olduğunda işlenecek fonksiyon, filtreleme özelliğinden dolayı kullanımı karmaşık gelebilir. Kodları incelemeniz önerilmektedir. </li>
				  	<li>kullanici_aktivasyonunu_yap(): Aktivasyon şekline göre kullanıcı aktivasyonunu sağlayan fonksiyon. </li>
				  	<li>kullanici_sifremi_unuttum(): kayıtlı kullanıcının şifresini unutması durumunda, yeni şifre yaratmaya yarayan fonksiyon.</li>
				  	<li>kullanici_sifresini_degistir(): kullanıcının şifresini değiştirmesini sağlayan fonksiyon </li>
				  	<li>kullanici_ekle(): yeni kullanıcı oluşturmayı sağlar </li>
				  	<li>kullanici_sil(): kullanici_id\'si gelen kullanıcıyı siler </li>
				  	<li>kullanici_bilgisi(): kullanici_id\'si gelen kullanıcının verilerini döndürür. Kullanıcının varlığını kontrol etmek için de kullanılabilir </li>
				  	<li>kullanici_listesi(): kullanici_tipine göre kullanıcı listesini döndürür </li>
				</ul>';
	}
}			
?>