<?php
if (!defined('gnc'))
	die();

/* Kullanıcılar arası mesajlarşmayı sağlayan sınıf, 
 * Güvenlik ve hukuki boyutları düşünüldüğünde geliştirme konusunda sınırı olmayan bir sınıf olduğu için dikkatli kullanılması önemlidir.
 * Burada mesajın silinmesinden kasıt tablodaki ilgili alanın 1 yapılmasıdır.
 * 
 * NOT: t transmitter, r receiver
 * 
 * Önemli parametreler
 * @param mesaj_id, veritabanında yer alan mesaj id'si
 * @param kullanici_t_id, transmitter yani mesajı gönderen kullanıcının id'si
 * @param kullanici_r_id, receiver yani mesajın gönderildiği kullanıcı id'si
 * @param kullanici_mesaj_sahibi, kullanıcının mesaj kutusu bir mesaj hem gönderene hemde gönderilenin mesaj kutusuna kaydedilir.
 * @param diger_kullanici_id, mesajı gönderen yada alan durumundaki diger kullanıcının id'sidir.
 */
class mesaj
{
	// SPAM filtresi için kullanılan yüzdesel olarak max benzerlik oranı, ne kadar düşük olursa filtre o kadar daralır ve mesaj göndermek zorlaşır
	private $istenen_max_benzerilik = 80;
	
	/* Oturumu açık olan kullanıcının tüm mesajlarını gösteren fonksiyon
	 * 
	 * @param $diger_kullanici_id (optional), oturumu açık olan kullanıcı ile parametre olarak belirtilen kullanıcı arasındaki mesajları göstermeye yarayan parametre
	 * @param $kullanici_mesaj_silinmis_mi (optional), varsayılan olarak kullanıcının silinmemiş mesajları getirilir ancak değişken 1 olarak tanımlandığında silinmiş mesajları getirilir
	 * @param $kullanici_id (optional), varsayılan değer kullanıcının kendi mesajlarını görmesidir. Ancak yöneticiler istedikleri kişinin mesajlarını okumak isterlerse, ve bu yönde bir düzenleme yapılması gerekirse bu değişken tanımlanabilir
	 * 
	 * return array, oturumu açık olan kullanıcının tüm mesajları
	 */
	function mesajlar($diger_kullanici_id = 0, $kullanici_mesaj_silinmis_mi = 0, $kullanici_id = 0)
	{
		global $site, $vt;
	
		// Hangi kullanıcının mesajları görüntülenecek
		if ($kullanici_id == 0)
			$kullanici_id = $_SESSION['kullanici_id'];
			
		$sorgu = "SELECT * , IF(kullanici_t_id <> '$kullanici_id', kullanici_t_id, kullanici_r_id) AS diger_kullanici_id
	  			  FROM gnc_kullanicilarin_mesajlari
	              WHERE kullanici_mesaj_sahibi = '$kullanici_id' AND kullanici_mesaj_silinmis_mi = '$kullanici_mesaj_silinmis_mi'";
	  
		if ($diger_kullanici_id > 0)           
			$sorgu .= " AND (kullanici_t_id = '$diger_kullanici_id' OR message_r_id = '$diger_kullanici_id') ";
	                
		$sorgu .= " ORDER BY kullanici_mesaj_timestamp DESC";
	  	$sorgu = $vt->query($sorgu);  
	
		while ($sonuc = $vt->fetch_array($sorgu)){
			$sonuc['diger_kullanici'] = gnc_kullanici_bilgileri($sonuc['diger_kullanici_id']);
			
			$sonuclar[] = $sonuc;
		}
		if (!empty($sonuclar))
			return $sonuclar;
	}
	/* Kullanıcının site içerisinde gezinirken aldığı mesajlar */
	function son_mesajlar()
	{
		global $site, $vt;
	
		$sorgu = "SELECT * , IF(kullanici_t_id <> '{$_SESSION['kullanici_id']}', kullanici_t_id, kullanici_r_id) AS diger_kullanici_id
	  			  FROM gnc_kullanicilarin_mesajlari
	              WHERE kullanici_mesaj_sahibi = '{$_SESSION['kullanici_id']}' AND kullanici_mesaj_silinmis_mi = 0 AND kullanici_mesaj_timestamp > '{$_SESSION['kullanici_timestamp']}'
	              ORDER BY kullanici_mesaj_timestamp DESC";
	  	
	  	$sorgu = $vt->query($sorgu);  
	
		while ($sonuc = $vt->fetch_array($sorgu)){
			$sonuc['diger_kullanici'] = gnc_kullanici_bilgileri($sonuc['diger_kullanici_id']);
			$sonuclar[] = $sonuc;
		}
		if (!empty($sonuclar))
			return $sonuclar;
	}
	function son_mesajlar_say()
	{
		return count($this->son_mesajlar());
	}
	/* Kullanıcının okunmamış ve silinmemiş mesajları yeni mesajlardır */
	function yeni_mesajlar()
	{
		global $site, $vt;
	
		$sorgu = "SELECT * , IF(kullanici_t_id <> '{$_SESSION['kullanici_id']}', kullanici_t_id, kullanici_r_id) AS diger_kullanici_id
	  			  FROM gnc_kullanicilarin_mesajlari
	              WHERE kullanici_mesaj_sahibi = '{$_SESSION['kullanici_id']}' AND kullanici_mesaj_silinmis_mi = 0 AND kullanici_mesaj_okunmus_mu = 0}'
	              ORDER BY kullanici_mesaj_timestamp DESC";
	  	
	  	$sorgu = $vt->query($sorgu);  
	
		while ($sonuc = $vt->fetch_array($sorgu)){
			$sonuc['diger_kullanici'] = gnc_kullanici_bilgileri($sonuc['diger_kullanici_id']);
			$sonuclar[] = $sonuc;
		}
		if (!empty($sonuclar))
			return $sonuclar;
	}
	function yeni_mesajlar_say()
	{
		return count($this->yeni_mesajlar_say());
	}
	/* Mesajı gönder, Eğer HTML formumuzda mesajı eposta gönderme isteğini belirten 
	 * $_POST['mesaj_eposta_olarakta_gonder'] gibi bir POST değişkeni varsa, mesajı ePosta olarakta atmayı sağlayan mesaj gönderme fonksiyonu
	 * 
	 * @param $eposta_olarakta_gonder (optional)
	 */
	function mesaj_gonder($eposta_olarakta_gonder = 0)
	{
		global $dil,$site, $vt;
	 
		if (!empty($_POST['mesaj_icerigi']))
		{
			$t_ip = gnc_ip();
	    	$r_id = (int)guvenlik($_POST['kullanici_r_id']);
	    	$konu = guvenlik($_POST['mesaj_konusu']);
	    	$icerik = guvenlik($_POST['mesaj_icerigi']);
	    	$eposta_olarakta_gonder = guvenlik($_POST['mesaj_eposta_olarakta_gonder']);
	  		
			/* SPAM için tedbir alalım, 
			 * 
			 * Aynı kullanıcı son 5 dakika içerisinde benzer bir mesaj atıyorsa kullanıcının mesajını kaydetmemek gerekir. 
			 * Hatta bu durum tekrarlanırsa kullanıcının siteye erişimi engellenmelidir.
			 */
			$onceki_mesajlar = $this-> kullanicinin_gonderdigi_mesajlar(10);
			$benzerlik = 0;
			foreach ($onceki_mesajlar AS $mesaj)
			{
				$benzerlik_orani = gnc_yazidaki_benzerlik_orani($icerik, $mesaj['kullanici_mesaj_icerigi']);
				if ($benzerlik_orani > $benzerlik)
					$benzerlik = $benzerlik_orani;
			}
			
			/* Kullanıcının gönderdiği son 10 mesajı kontrol ettik, eğer bunlardan her hangi biri %50den fazla benzer değilse bu mesajımızı yolluyoruz.
			 * 
			 * Kullanıcının engellenmesi vs. durumlar burada tanımlanabilir ancak GNC içerisinde bu kadar özele girmeye gerek olmadığını değerlendiriyorum.
			 */  
			if ($benzerlik < $this->istenen_max_benzerilik())
			{
				/* Hem kendi mesaj kutusuna, hemde gönderilen kişinin mesaj kutusuna mesajı kaydedelim */
			    $vt->query("INSERT INTO gnc_kullanicilarin_mesajlari 
		                    	(kullanici_t_id, kullanici_r_id, kullanici_mesaj_sahibi, kullanici_mesaj_timestamp, kullanici_mesaj_t_ip, kullanici_mesaj_konusu, kullanici_mesaj_icerigi)
		                    VALUES                        
		                    	('{$_SESSION['kullanici_id']}','$r_id','{$_SESSION['kullanici_id']}', UNIX_TIMESTAMP(), '$t_ip', '$konu','$icerik'),
		                    	('{$_SESSION['kullanici_id']}','$r_id','$r_id',            			  UNIX_TIMESTAMP(), '$t_ip', '$konu','$icerik')");
				
			
				if ($eposta_olarakta_gonder == 1)
					send_mail_to($message_to, $message_text, $message_subject);
			}
			else 
			{
				echo '<p>Mesajınız SPAM gerekçesiyle gönderilmemiştir.</p>';	
			}
		}
	}
	function mesaj_oku()
	{
		global $site, $vt;
		
		$vt->query("UPDATE gnc_kullanicilarin_mesajlari
	    			SET kullanici_mesaj_okunmus_mu = 1 
	                WHERE kullanici_mesaj_sahibi = '{$_SESSION['kullanici_id']}'");
	}
	/* Mesaj Silme 
	 * 
	 * Hukuki boyutları gereği mesajı komple silmek doğru olmayabilir, 
	 * 
	 * Dolayısıyla kullanici_mesaj_silinmis_mi değerini 1 yapmak daha doğru olacaktır. 
	 * Zaten mesajlar fonksiyonunda bu değer 0 ise kullanıcılara gösterilmektedir.
	 * 
	 * mesaj_sil(0,diger_kullanici_id) şeklinde kullanıldığında id'si gelen kişi ile olan tüm mesajlaşmaları siler
	 * 
	 * @param mesaj_id istenen mesajın silinmesini sağlar
	 * @param diger_kullanici_id seçili kişi olan mesajların tamamını siler
	 */
	function mesaj_sil($mesaj_id = 0, $diger_kullanici_id = 0)
	{
		global $site, $vt;
	 
		$diger_kullanici_id = (int)guvenlik($_POST['diger_kullanici_id']);
		$mesaj_id = (int)guvenlik($_POST['mesaj_id']);
		
		// Eğer diğer kullanıcıdan gelen tüm mesajlar silinecekse
	 	if ($diger_kullanici_id > 0)
		{
	    	$vt->query("UPDATE gnc_kullanicilarin_mesajlari
	    				SET kullanici_mesaj_silinmis_mi = 1 
	                	WHERE kullanici_mesaj_sahibi = '{$_SESSION['kullanici_id']}' AND 
	                     	(kullanici_t_id = '$diger_kullanici_id' OR 
	                      	 kullanici_r_id = '$diger_kullanici_id')");
		}
		// Belirtilen bir mesaj silinecekse
		if ($mesaj_id > 0) 
		{
			$vt->query("UPDATE FROM gnc_kullanicilarin_mesajlari 
						SET kullanici_mesaj_silinmis_mi = 1 
	                	WHERE kullanici_mesaj_sahibi = '{$_SESSION['kullanici_id']}' AND mesaj_id = '$mesaj_id'");
		}
	}
	
	function kullanicinin_gonderdigi_mesajlar($limit = 50)
	{
		global $site, $vt;
	
		$sorgu = "SELECT * FROM gnc_kullanicilarin_mesajlari
	              WHERE kullanici_t_id = '{$_SESSION['kullanici_id']}'
	              ORDER BY kullanici_mesaj_timestamp DESC
	              LIMIT $limit";
	  	$sorgu = $vt->query($sorgu);  
	
		while ($sonuc = $vt->fetch_array($sorgu))
			$sonuclar[] = $sonuc;
		
		if (!empty($sonuclar))
			return $sonuclar;		
	}
	// Bilgi fonksiyonu, class içindeki bilgi fonksiyonu çağırıldığında class'ın ne yaptığı ve içeriği hakkında temel bilgiler sunulur.1
	function bilgi()
	{
		echo '	<h5>Mesaj class\'ı kullanıcı ile ilgili her türlü işlemi yapmayı sağlar </h5>
				<ul>
					<li>mesajlar(): kullanıcının mesajlarını gösterir</li>
					<li>son_mesajlar(): kullanıcının site içerisinde gezinirken aldığı mesajlar</li>
					<li>son_mesajlar_say(): kullanıcının site içerisinde gezinirken aldığı mesajların sayısı</li>
					<li>yeni_mesajlar(): okunmamış ve silinmemiş durumdaki tüm mesajlar</li>
					<li>yeni_mesajlar_say(): okunmamış ve silinmemiş durumdaki tüm mesajların sayısı</li>
					<li>mesaj_gonder(): kullanici kayıt olduğunda işlenecek fonksiyon, filtreleme özelliğinden dolayı kullanımı karmaşık gelebilir. Kodları incelemeniz önerilmektedir. </li>
				  	<li>mesaj_sil(): seçili mesajı veya kişi ile ilgili tüm mesajları silen fonksiyon.</li>
				  	<li>kullanicinin_gonderdigi_mesajlar(): kullanıcının gönderdiği mesajlar.</li>
				</ul>';
	}
}			
?>