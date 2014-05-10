<?php
/*	
 * Bu dosya gnc içerisinde yoğun olarak kullanılan fonksiyonları içermektedir.
 * 
 * Oturumlar, izinler ve hata iletileride sitede yoğun olarak
 * kullanıldığı için bu dosyaya dahil edilmiştir.
 * 
 * Fonksiyon isimlendirmede php'nin kurallarının yanında bir kaç hususa daha dikkat edilmelidir.
 * 1. "gnc_" öneki, gnc'nin esasında kullanılan fonksiyonların tamamının önünde gnc_ ifadesi yer almaktadır. 
 *     Bunları değiştirirken dikkatli olmanız gerekir.
 *     Sizde fonksiyonlarınızın önüne örneğin isminiz Seda Bilgin ise "sb_" şeklinde bir ön ek koyarsanız karmaşa ortadan kalkacaktır.
 *     Projede çalışan herkes bu tip bir yol ile kodunu kişiselleştirebilir.
 * 2. "model_" veya "gorunum_" bunlar fonksiyonun amacını belirtmektedir, gorunum browser'dan kullanıcıya yansıtılacak fonksiyonları, 
 *     model ise veri tabanından görünüme veri beslemeyi yada görünümden gelen istekleri veritabanına işleyen fonksiyonları ifade etmektedir.
 *     katı bir kural olmamakla beraber bu hususa dikkat edilmeli, zorunlu olunmadıkça model fonksiyonlarının içine HTML, JS, CSS kodu yazılmamalıdır.
 * 3. "dosya_" ve "fonk_" isimleri büyük projelerde (kişiye göre görecelidir) fonksiyonun yerini anlayabilmek için önem arz etmektedir. 
 *     Fonksiyon ismimlerinin gereksiz uzatılmamasına dikkat edilmeli ancak fonksiyonun nerede yazılı oluduğunun kolayca görünebilmesi projede değişiklik yaparken çok işlevsel olmaktadır.
 * 4.  Görünüm klasöründeki fonksiyon isimlerinde ise direk ifadeleri kullanın örneğin "ayarlar" zaten yonlendirici bize bu dosyanın nerede yazılı olduğunu sunmaktadır.
 * 
 * Örnekler: 
 * gnc_model_gnc_diller() : gnc'nin esas fonksiyonlarından model klasöründe yer alan gnc dosyasının içinde yazılı olan "gnc_model_gnc_diller" isimli fonksiyonu ifade eder.
 * gnc_model_oturumlar()  : gnc'nin esas fonksiyonlarından model klasöründeki oturumlar dosyasının içinde yazılı olan "gnc_model_oturumlar" isimki fonksiyonu ifade eder.
 * sb_gorunum_profil_kullanici(): projeye sb tarafından yazılmış, gorunum klasorunde yer alan profil dosyasının içinde yazılı olan "sb_gorunum_profil_kullanici" isimli fonksiyonu ifade eder.
 * 
 * GNC'deki klasör ve dosya mantığı yapısı linux'a benzer olarak düşünülmüştür. Aynı isimli bir klasörü ve dosyayı aynı dizin (klasör) içinde bulundurmayın. Kafa karıştırmasın!
*/
if (!defined('gnc'))
	die();

/* Kullanılan diller  
 * 
 * Kastedilen sadece sitenin çalıştığı dil değil yönetim sayfasından yaratılan kategorilerin içindeki içeriklerin de dilleridir. 
 * Yani diller tablosuna dil eklenmiş ancak sitenin çalışması için dil dosyası eklenmemiş olabilir.
 */
function gnc_diller()
{
	global $vt;
	$sorgu = $vt->query("SELECT * FROM gnc_diller");
	$sonuc = $vt->fetch_array($sorgu);
	return $sonuc;
}
/* Kullanıcının yetkisini kontrol et
 * 
 * Kullanıcı tiplerine göre yetkilendirme yapmak için kullanılır, menü elemanları ve yönetimle ilgili konuların güvenliğini sağlamak için önemlidir.
 * Erişim izni verilmesi için kullanıcı tipinin büyük veya eşit olması gerekir. 
 */
function gnc_yetki($yetki){
	global $site;
	
	if ($_SESSION['kullanici_tipi'] < $yetki){
		return false;	
	}
	else{
		return true;	
	}	
}
// Kullanıcı mobil bir cihazdan mı bağlanmış kontrol edelim
$_SESSION['mobile'] = is_mobile();
function is_mobile()
{
	if (empty($_SERVER['HTTP_USER_AGENT']) || !isset($_SERVER['HTTP_USER_AGENT'])) 
	{
		$is_mobile = 0;
	} 
	elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // Çoğu mobil cihaz (iPhone, iPad, vb...)
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) 
	{
		$is_mobile = 1;
	} 
	else 
	{
	    $is_mobile = 0;
	}
	return $is_mobile;
}
// Giriş yapan kullanıcı bilgilerini session değerlerine atayan fonksiyon 
function gnc_kullanici_oturumu($veri)
{
	unset($veri['kullanici_sifre']);
	$_SESSION = $veri;
}	
// Kullanıcı bilgilerini göster
function gnc_kullanici_bilgileri($kullanici_id)
{
	global $site, $vt;		

	$kullanici_id = guvenlik($kullanici_id);
	$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar WHERE kullanici_id = '$kullanici_id' LIMIT 1");
	$sonuc = $vt->fetch_array($sorgu);
	
	if (!empty($sonuc))
	{
		// Kullanıcı sifresinin hashini döndürmeyelim
		unset($sonuc['kullanici_sifre']);
		// Kullanıcının resminide belirtelim
		$sonuc['kullanici_resim'] = gnc_kullanici_resmi_goster($sonuc['kullanici_id']);
		
		return $sonuc;	
	}
	else
		return false;
}
/* Kullanıcının resmini göster
 * 
 * Kullanıcıların profil resmi gibi önem arz eden ve yokluğunda avatar gibi klasik bir resmin gösterilmesi gereken durumlar için hazırlanan bir fonksiyon
 */
function gnc_kullanici_resmi_goster($kullanici_id)
{	
	global $site, $vt;		
  
	$kullanici_id = guvenlik($kullanici_id);
	$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar 
  						 WHERE kullanici_id = '$kullanici_id' 
  						 LIMIT 1");                        			
	$sonuc = $vt->fetch_array($sorgu);
  
	if (!empty($sonuc['kullanici_resim']))
	{
		$resim = $site['resim_yolu'].$sonuc['kullanici_resim'];

		if (file_exists($resim))
			return $resim;
		else 
			return $site['url'].'sistem/img/avatar.png';  
	}
	else
	{
		return $site['url'].'sistem/img/avatar.png';
	}  
}
// Kullanıcının eposta adresini göster
function gnc_kullanici_eposta_adresi($kullanici_id){
	global $site, $vt;		
  
	$kullanici_id = guvenlik($kullanici_id);
	$sorgu = $vt->query("SELECT * FROM gnc_kullanicilar 
  						 WHERE kullanici_id = '$kullanici_id' 
  						 LIMIT 1");                        			
	$sonuc = $vt->fetch_array($sorgu);	
	return $sonuc['kullanici_kullanici_adi'];
}
// Site içerisinde kullanıcı yetkisine göre görünecek menü'yü oluşturan fonksiyon
function gnc_menu($menu = 0, $menu_eleman_id = 0, $ic_menu = 0)
{
	global $adres, $dil, $site, $vt;
		
	// Kategorinin altındaki alt kategorileri ağaç yapısı içinde gösteren fonksiyon
	$sorgu = $vt->query("SELECT * FROM gnc_menuler 
						 LEFT JOIN gnc_menulerin_elemanlari ON gnc_menulerin_elemanlari.menu_id = gnc_menuler.menu_id
						 WHERE gnc_menulerin_elemanlari.menu_eleman_id_ust = '$menu_eleman_id' AND 
						 	   gnc_menulerin_elemanlari.menu_eleman_yetki <= '{$_SESSION['kullanici_tipi']}' AND 
						 	   gnc_menuler.menu_id = '$menu' 
						 ORDER BY gnc_menulerin_elemanlari.menu_eleman_sira ASC ");
	
	// Drag & Drop ile sıralama için gerekli olan yapı, $ic_kategori ana kategori olmadığını bir parent kategorinin child'ı durumunu ifade etmektedir.
	if ($ic_menu == 1)
		echo '<ul>';
	while ($sonuc = $vt->fetch_array($sorgu))
	{
			
		if ($sonuc['menu_eleman_renk'] != '0')
			$style = 'style="color:'.$sonuc['menu_eleman_renk'].'"';
		else
			$style = '';
		
		echo '<li><a href="'.$site['url'].$sonuc['menu_eleman_href'] .'" '.$style.' target="'. $sonuc['menu_eleman_target'] .'">'. $sonuc['menu_eleman_adi'] .'</a>';
		gnc_menu($sonuc['menu_id'], $sonuc['menu_eleman_id'], 1);
		echo '</li>';
	}
	if ($ic_menu == 1)
		echo '</ul>';
}
/* Kullanıcının ip adresi
 * 
 * Kullanıcının ip adresini alan fonksiyon, giriş denemelerinde eğer kullanıcı bir kaç deneme yaptıysa vs. durumlarda sıkça kullanılır.
 */
function gnc_ip() 
{
  if (getenv("HTTP_CLIENT_IP"))
    $ip = getenv("HTTP_CLIENT_IP");
  else if(getenv("HTTP_X_FORWARDED_FOR"))
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  else if(getenv("REMOTE_ADDR"))
    $ip = getenv("REMOTE_ADDR");
  else
    $ip = "0";
  
  return $ip;
}
/* Ziyaretçinin ülkesini gösteren fonksiyon
 * 
 * Farklı yada yasak reklamların o ülke vatandaşlarına gösterilmemesi için kullanılabilir.
 * 
 * Türkiye için "Turkey" şeklinde cevap döndürmektedir.
 */
function gnc_ziyaretcinin_ulkesi()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
	
    $sonuc  = "Bilinmiyor";
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryName != null)
    {
        $sonuc = $ip_data->geoplugin_countryName;
    }
    return $sonuc;
}
/* Filtreleme ve Sterilize fonksiyonu 
 * 
 * filter_var fonksiyonunun aldığı filtre tipine uygun olarak true yada false değer döndürür
 * sıkça kullanılan filtre tipleri şunlardır;
 * 
 * FILTER_VALIDATE_EMAIL
 * FILTER_VALIDATE_IP
 * FILTER_VALIDATE_URL
 * 
 * FILTER_SANITIZE_EMAIL
 * FILTER_SANITIZE_URL
 * FILTER_SANITIZE_NUMBER_FLOAT
 * FILTER_SANITIZE_NUMBER_INT
 */
function gnc_filtre($veri, $filtre_tipi)
{
	if(filter_var($veri, $filtre_tipi))
    	return true;
	else
    	return false;
}
/* Kripto fonksiyonları 
 * 
 * Kripto anahtarı her uygulama için farklı olmalıdır ve özellikle başka bir yerden çağırılmamıştır, uygulamanızın güvenliği için anahtarı değiştirip
 * $_POST ve $_GET değişkenlerinizi şifreleyebilirsiniz. Özellikle $_GET değişkenlerini bu şekilde saklamanız tavsiye edilir. Ayrıca kripto fonksiyonlarını 
 * kullanırken farklı anahtarlarda kullanabilirsiniz.
 */
// Şifreli veri göndermek için kullanılacak kriptolama fonksiyonu
function gnc_encrypt($veri, $anahtar = 0) {
	global $ayar;
	
	if ($anahtar == 0)
		$anahtar = $ayar['kripto_anahtari'];	
	
	$sounuc = '';
	for($i=0; $i<strlen($veri); $i++) {
	    $char    		= substr($veri, $i, 1);
	    $anahtar_char	= substr($anahtar, ($i % strlen($anahtar)) -1, 1);
	    $char			= chr(ord($char) + ord($anahtar_char));
	    $sounuc .= $char;
	}
	// Şifreli veriyi döndür
	return base64_encode($sounuc);
}
// Şifreli gelen verinin şifresini çözen fonksiyon, şifreleme fonksiyonunun anahtarıyla bunun anahtarı aynı olmalı
function gnc_decrypt($veri, $anahtar = 0) {
	global $ayar;
	
	if ($anahtar == 0)
		$anahtar = $ayar['kripto_anahtari'];
	
	$sounuc = '';
	$veri = base64_decode($veri);
	for($i=0; $i<strlen($veri); $i++) {
    	$char    		= substr($veri, $i, 1);
    	$anahtar_char 	= substr($anahtar, ($i % strlen($anahtar))-1, 1);
    	$char			= chr(ord($char)-ord($anahtar_char));
    	$sounuc .= $char;
	}
	// Şifresi çözülen veriyi döndür
	return $sounuc; 
}

// Başarılı ve hatalı işlem fonksiyonları
function gnc_basari($veri)
{
	global $dil;
	echo '<strong>'.$dil['basari'].' </strong>'. $veri;
}

function gnc_hata($veri)
{
	global $dil;
	echo '<strong>'.$dil['hata'].' </strong>'. $veri;
}
// 401, 404 gibi ciddi sorunları çağıran sayfa
function gnc_sorun($sorun)
{
	global $dil;
	
	include('sistem/gorunum/'.$sorun.'.php');
	die();	
}
/* ePosta gönderme 
 * 
 * php'nin mail() fonksiyonunu kullanarak ePosta gönderen mail() fonksiyonunun özelleştirilmiş hali
 * gnc'nin içerisinde daha geniş çaplı ePosta işlemleri için PHPMailer class'ı da kullanılabilmektedir. Bu class sayesinde ePosta'larınıza dosya ekleme gibi işlemleri de yapabilirisiniz. 
 * Muhtemelen gerek duymayacağınız bu class ile ilgili detaylı bilgiyi https://github.com/Synchro/PHPMailer adresinde bulabilirsiniz.
 */
function gnc_mail($kime,$konu,$mesaj)
{
	global $ayar, $site;
	
	// ePosta kime gönderilecek, eğer gelen veri kullanici_id'si ise bu kişinin ePosta adresini alalım
	if (is_numeric($kime))
		$kime = gnc_kullanici_eposta_adresi($kime);
		
	// ePostanın kimden gönderildiğini göstermek ve ePosta içeriğinde HTML kullanabilmek için tanımlanmış olan header bilgisi, ne yaptığınızı bilmiyorsanız değiştirmeyin!
	$kimden  = $ayar['iletisim_eposta'];
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <'.$kimden.'>' . "\r\n";
	$headers .= "Reply-To:". $kimden ."\r\n";
  
	mail($kime, $konu, $mesaj, $headers);
}
// PHPMailer class'ı ile ePosta gönderme
function gnc_mailer($kime,$konu,$mesaj)
{
	global $ayar, $dil, $site;
	
	require_once('sistem/bloklar/PHPMailer/PHPMailerAutoload.php');
	
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	
	$mail->isSMTP();                                      		// Set mailer to use SMTP
	$mail->Host = $ayar['smtp_host_1'].';'.$ayar['smtp_host_2'];// Specify main and backup server
	$mail->SMTPAuth = true;                               		// Enable SMTP authentication
	$mail->Username = $ayar['smtp_username'];					// SMTP username
	$mail->Password = $ayar['smtp_password'];					// SMTP password
	$mail->SMTPSecure = $ayar['smtp_secure'];					// Enable encryption, 'ssl' also accepted
	
	$mail->From = $ayar['iletisim_eposta'];
	$mail->FromName = $ayar['iletisim_eposta'];
	//$mail->addAddress('josh@example.net', 'Josh Adams');  // Add a recipient
	
	// ePosta kime gönderilecek, eğer gelen veri kullanici_id'si ise bu kişinin ePosta adresini alalım
	if (is_numeric($kime))
		$kime = gnc_kullanici_eposta_adresi($kime);
	$mail->addAddress($kime);               // Name is optional
	$mail->addReplyTo($ayar['iletisim_eposta'], 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');
	
	//$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
	
	$mail->Subject = $konu;
	$mail->Body    = $mesaj;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	if(!$mail->send()) 
	{
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}	
	//echo 'Message has been sent';
}
/* NEXMO ile SMS gönderimi
 * 
 * İstenen telefon numarasına gönderen kısmında sitenin adı yazacak şekilde SMS gönderimi sağlar, hata sorgulaması için class'ı inceleyin. 
 */
function gnc_sms($telefon_numarasi, $mesaj)
{
	global $site;
  
    $kimden = $site['adi'];
    $kime 	= $telefon_numarasi;
    
    // Nexmo API'sine uygun olarak nesneyi yarat
	$nexmo_sms = new NexmoMessage($site['nexmo_api_key'], $site['nexmo_secret']);
    // Metodu kullanarak SMS gönder
  	$info = $nexmo_sms->sendText($kime, $kimden, $mesaj);
  	// İstenirse gönderilen mesajı göster
  	//echo $nexmo_sms->displayOverview($info);   
} 
/* Tarih ile ilgili fonksiyonlar (bunun yerine timestamp yada PHP 5.4 ile gelen özellikleri kullanmanızı tavsiye ediyorum)
 * 
 * gnc_tarih 		   : gnc'nin tarih fonksiyonu
 * 						 Üç farklı parametre almaktadır
 * 						 1. veri	=> 1986-08-26 gibi bir tarih verisi
 * 						 2. tip		=> Gösterilecek tarihin tipi, 3 degeri vardır. 
 * 								2.1. sayi => ay değerini sayısal olarak ifade eder. '08' gibi
 * 								2.2. kisa => ay degerini kisaltir ve dil degiskenlerindeki şekliyle gosterir. 'Aug' gibi
 * 								3.3. uzun => ay degeri dil degiskenlerindeki şekliyle gosterir. 'August' gibi
 * 						 3. ayrac	=> 26.08.1986 gibi tarih gösterimlerinde kullanılacak ayracın şeklini belirtir. Varsayılan ifade noktadır. Ayın sayısal gösterilmediği durumlarda ayraç kullanılmaz.
 * 
 * gnc_tarihi_formatla : Tarihin gösterim şeklini düzenleyen fonksiyon
 * 						 Site içerisinde gösterilecek tüm tarih değişkenleri bu fonksiyondan geçirilmeli, daha sonra yapılacak düzenlemelerde sadece bu fonksiyonu değiştirmek yeterli olacaktır.
 * 
 * gnc_gun, gnc_ay, gnc_yil fonskiyonları, gelen tarih verisinden gün, ay, yil degerlerini donduren fonksiyondur.
 * 
 */
function gnc_tarih($veri, $tip = 'sayi', $ayrac = '.'){
	$veri = date('d.m.Y', strtotime($veri));
	$gun = gnc_gun($veri);
	$ay  =  gnc_ay($veri, $tip);	
	$yil = gnc_yil($veri);	
	
	if ($tip != 'sayi')
		$ayrac = '&nbsp';
				
	return $gun.$ayrac.$ay.$ayrac.$yil;
}
/* Tarihin gösterimi düzenleyen fonksiyon 
 * 
 * Geliştiricilerin tarih gösterimini tek yerden düzenlemesi için yapılmıştır. Dikkat edilmesi gereken önemli bir husus bulunmaktadır.
 * Mevcut durumda tarih Türk gösterimine uygun şekilde 26.08.1986 şeklindedir. Amerikan tarzı gösterim olan 08.26.1986 gibi bir gösterime geçildiğinde gun, ay ve yılın yer değiştirebileceği
 * dolayısıyla gnc_gun, gnc_ay, gnc_yil fonksiyonlarının çalışma mantığını bozabileceği unutulmamalı, bu fonksiyonda yapılacak değişkene uygun olarak $tarih[$i] ifadesindeki $i'nin uygun şekle getirilmesi sağlanmalıdır. 
 *
 * @param Y-m-d formatında 
 * 
 * return string
 */ 
function gnc_tarihi_formatla($tarih){
	global $ayar;
	
	// Time stamp şeklinde integer değer geliyorsa strtotime'a gerek yok
	if (is_integer($tarih))
		return date($ayar['tarih_formati'], $tarih);
	else		
		return date($ayar['tarih_formati'], strtotime($tarih));
}
/* Parametre olarak girilen iki tarih arasındaki günleri ayarlarda istenen tarihe göre formatlar
 * 
 * @param Y-m-d formatında başlangıç tarihi
 * @param Y-m-d formatında bitiş tarihi
 * 
 * return array
 */
function gnc_tarihler_arasindaki_gunler($iDateFrom,$iDateTo, $format = 0)
{
	global $ayar;
	
    if ($format == 0)
		$format = $ayar['tarih_formati'];
	
	$result = array();
		
    while ($iDateTo >= $iDateFrom)
    {
        //$iDateFrom+=86400; // add 24 hours
        array_push($result,  date($format, strtotime($iDateFrom)));
		$iDateFrom = gnc_gun_ekle($iDateFrom, 1);
    }
    
    return $result;
}
/* Y-m-d formatlı tarih verisine +2, -5 şeklinde gün eklemeyi sağlayacan fonksiyon
 * 
 * @param Y-m-d formatında tarihi
 * @param eklenecek gün sayısı
 * 
 * return string
 */ 
function gnc_gun_ekle($tarih, $kac_gun = 1)
{
	if (is_integer($tarih))
		return $tarih + ($kac_gun * 1 * 60 * 60);
	else
		return date('Y-m-d', strtotime($kac_gun.' days', strtotime($tarih))); 
}
function gnc_gun($veri, $tip = 'sayi'){
	global $dil;
	
	if ($tip == 'uzun'){
		$tarih = explode('.',date('l.m.Y', strtotime($veri)));	
		return $dil[$tarih[0]];	
	}
	elseif ($tip == 'kisa'){
		$tarih = explode('.',date('D.m.Y', strtotime($veri)));	
		return $dil[$tarih[0]];	
	}
	else{
		$tarih = explode('.',date('d.m.Y', strtotime($veri)));	
		return $tarih[0];	
	}
}
function gnc_ay($veri, $tip = 'sayi'){
	global $dil;
	
	if ($tip == 'uzun'){
		$tarih = explode('.',date('d.F.Y', strtotime($veri)));
		return $dil[$tarih[1]];	
	}
	elseif ($tip == 'kisa'){
		$tarih = explode('.',date('d.M.Y', strtotime($veri)));
		return $dil[$tarih[1]];	
	}
	else{
		$tarih = explode('.',date('d.m.Y', strtotime($veri)));
		return $tarih[1];	
	}	
}
function gnc_yil($veri){
	$tarih = explode('.',date('d.m.Y', strtotime($veri)));	
	return $tarih[2];	
}
/* İki timestamp arasındaki farkı insanların anlayabileceği şekilde örneğin
 * "1 saat", "5 dakika", "2 gün" gibi döndürür.
 *
 * @param int $from Unix timestamp - başlangıç tarihi
 * @param int $to Optional. Unix timestamp - bitiş tarihi, girilmezse şuan olarak kabul edilir.
 * @return string insanların anlayabileceği şekildeki zaman farklılığını döndürür.
 * 
 * Dikkat edilmesi gereken en önemli konu ./sistem/bloklar/framework.php de yer alan n() fonksiyonunun incelenmesidir. 
 * İngilizcede gibi dillerde min, mins gibi farklılıklar olacağı için bu fonksiyon kullanılmakta ve rakamsal değerin niteliği bu fonksiyon ile belirlenmektedir.
 * 
 * 
 * @param Y-m-d formatında başlangıç tarihi
 * @param Y-m-d formatında bitiş tarihi
 * 
 * return string
 * */
function gnc_zaman_farki($from, $to = '')
{	
	define( 'MINUTE_IN_SECONDS', 60 );
	define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
	define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
	define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
	define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );
	
	if (empty($to))
		$to = time();

	$diff = (int)abs($to - $from);

	if ($diff < HOUR_IN_SECONDS){
		$mins = round($diff / MINUTE_IN_SECONDS);
		if ($mins <= 1)
			$mins = 1;
		$since = sprintf(n('min', 'mins', $mins), $mins);
	} 
	elseif ($diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS) 
	{
		$hours = round($diff / HOUR_IN_SECONDS);
		if ( $hours <= 1 )
			$hours = 1;
		$since = sprintf(n('hour', 'hours', $hours), $hours);
	} 
	elseif ($diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS){
		$days = round($diff / DAY_IN_SECONDS);
		if ($days <= 1)
			$days = 1;
		$since = sprintf(n('day', 'days', $days), $days);
	} 
	elseif ($diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS){
		$weeks = round( $diff / WEEK_IN_SECONDS );
		if ($weeks <= 1)
			$weeks = 1;
		$since = sprintf(n('week', 'weeks', $weeks), $weeks);
	} 
	elseif ($diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS){
		$months = round( $diff / (30 * DAY_IN_SECONDS));
		if ($months <= 1)
			$months = 1;
		$since = sprintf(n('month', 'months', $months), $months);
	} 
	elseif ($diff >= YEAR_IN_SECONDS) {
		$years = round($diff / YEAR_IN_SECONDS);
		if ($years <= 1)
			$years = 1;
		$since = sprintf(n('year', 'years', $years), $years);
	}

	return $since;
}
/* gnc'nin url yapısına uygun olarak Breadcrumb yaratan fonksiyon
 * 
 * Gösterilecek sayfa ve fonksiyon adlarının ilk harfini büyüterek, kullanıcıya anlamsız gelebilecek olan '-' değerlerini kaldırarak breadcumb'ı yaratır.
 * Sonuç olarak "Xxxx > yyyy > zzzz zzzz" yapısını yaratmak için kullanılır, hali hazırda yönetim panelinde kullanılmaktadır.
 */
function gnc_breadcrumb_yarat(){
	global $adres, $ayar, $site;;

	if (!empty($adres['fonk']))
		echo '<li><a href="'.$site['url'].'">'.ucfirst($ayar['site_adi']).'</a></li>
			  <li><a href="'.$site['url'].''.$adres['dosya'].'">'.ucfirst(str_replace('-', ' ', $adres['dosya'])).'</a></li>
			  <li class="current"><a href="'.$site['url'].''.$adres['dosya'].'/'.$adres['fonk'].'">'.ucfirst(str_replace('-', ' ', $adres['fonk'])).'</a></li>';
	else 
		echo '<li><a href="'.$site['url'].'">'.ucfirst($ayar['site_adi']).'</a></li>
			  <li class="current"><a href="'.$site['url'].''.$adres['dosya'].'">'.ucfirst(str_replace('-', ' ', $adres['dosya'])).'</a></li>';
} 
/* Herhangi bir metni belirli bir uzunluğa kadar kısaltmak
 * 
 * Sitenin bazı bölümlerinde metnin kısa halini göstermek durumunda kalabileceğimiz için, parametre olarak gelen veriyi uygun şekilde kısaltan 
 * fonksiyon, varsayılan çalışma şekli; 30 karakterden büyük metinlerin ilk 25 karakterini gösterdikten sonra, metnin sonuna ... koyar!
 */ 
function gnc_yaziyi_kisalt($metin, $limit = 30)
{
  if (strlen($metin) > $limit)
    return mb_substr($metin,0,$limit-5,'UTF-8').'...';
  else
    return $metin;  
}
/* İki metin iceriğindeki yazıların benzerlik oranını hesaplayan fonksiyon
 * 50,72 gibi değer döndürür.
 */
function gnc_yazidaki_benzerlik_orani($metin1, $metin2)
{
	similar_text($metin1, $metin2, $sonuc);  	
	return $sonuc;
}
/* Bir metin kullanılarak, bir dizi içerisindeki benzer elemanları seçmeyi sağlayan ve belirlenen oran dahilindekileri döndüren fonksiyon
 * Arama algoritmalarından kullanılabilir. Yeni bir diziyi cevap olarak döndürmektedir.
 * 
 * 3 parametre alır;
 * $metin -> aranacak metnin kendisi
 * $dizi  -> $metin değişkenine benzer olan elemanların aranacağı dizi
 * $istenen_oran -> benzerliği istenen ve cevap olarak döndürülecek dizi'nin elemanların oluşturulma şartını belirleyecek fonksiyon
 * 
 */
function gnc_dizideki_benzerlik_orani($metin, $dizi, $istenen_oran)
{
    $i = 0;            
	foreach($dizi AS $dizi_elemani)  
	{  
	    similar_text($metin,$dizi_elemani,$benzerlik);  	      
	    if($benzerlik >= $istenen_oran)  
	    {  
	        $benzer_dizi[$i] = $dizi_elemani;
			$i++;
	    }  
	}  
	return $benzer_dizi;
}
/* Arama motoru dostu (Search Engine Friendly) url yapıları oluşturan fonksiyon
 * 
 * Pretty url'den alınmıştır, detaylı bilgi için http://code.google.com/p/prettyurls/ adresine bakabilirsiniz.
 * 
 * $_GET değişkenleri yerine "site_adresi/icerik/lepistesler-hakkinda-makale-1" gibi bir yapı kullanmanız bizim için olduğu gibi arama motorları için de
 * daha anlamlı olacaktır. Verilerinizi mutlaka başlıklardan üretilmiş sef'leriyle çağırın.
 */
function gnc_sef_olustur($veri, $tarih_eklensin_mi = 0)
{
	global $vt;
	$characterHash = array (
		'a'		=>	array ('a', 'A', 'à', 'À', 'á', 'Á', 'â', 'Â', 'ã', 'Ã', 'ä', 'Ä', 'å', 'Å', 'ª', 'ą', 'Ą', 'а', 'А', 'ạ', 'Ạ', 'ả', 'Ả', 'Ầ', 'ầ', 'Ấ', 'ấ', 'Ậ', 'ậ', 'Ẩ', 'ẩ', 'Ẫ', 'ẫ', 'Ă', 'ă', 'Ắ', 'ắ', 'Ẵ', 'ẵ', 'Ặ', 'ặ', 'Ằ', 'ằ', 'Ẳ', 'ẳ', 'あ', 'ア', 'α', 'Α'),
		'aa'	=>	array ('ا'),
		'ae'	=>	array ('æ', 'Æ', 'ﻯ'),
		'and'	=>	array ('&'),
		'at'	=>	array ('@'),
		'b'		=>	array ('b', 'B', 'б', 'Б', 'ب'),
		'ba'	=>	array ('ば', 'バ'),
		'be'	=>	array ('べ', 'ベ'),
		'bi'	=>	array ('び', 'ビ'),
		'bo'	=>	array ('ぼ', 'ボ'),
		'bu'	=>	array ('ぶ', 'ブ'),
		'c'		=>	array ('c', 'C', 'ç', 'Ç', 'ć', 'Ć', 'č', 'Č'),
		'cent'	=>	array ('¢'),
		'ch'	=>	array ('ч', 'Ч', 'χ', 'Χ'),
		'chi'	=>	array ('ち', 'チ'),
		'copyright'	=>	array ('©'),
		'd'		=>	array ('d', 'D', 'Ð', 'д', 'Д', 'د', 'ض', 'đ', 'Đ', 'δ', 'Δ'),
		'da'	=>	array ('だ', 'ダ'),
		'de'	=>	array ('で', 'デ'),
		'degrees'	=>	array ('°'),
		'dh'	=>	array ('ذ'),
		'do'	=>	array ('ど', 'ド'),
		'e'		=>	array ('e', 'E', 'è', 'È', 'é', 'É', 'ê', 'Ê', 'ë', 'Ë', 'ę', 'Ę', 'е', 'Е', 'ё', 'Ё', 'э', 'Э', 'Ẹ', 'ẹ', 'Ẻ', 'ẻ', 'Ẽ', 'ẽ', 'Ề', 'ề', 'Ế', 'ế', 'Ệ', 'ệ', 'Ể', 'ể', 'Ễ', 'ễ', 'え', 'エ', 'ε', 'Ε'),
		'f'		=>	array ('f', 'F', 'ф', 'Ф', 'ﻑ', 'φ', 'Φ'),	
		'fu'	=>	array ('ふ', 'フ'),
		'g'		=>	array ('g', 'G', 'ğ', 'Ğ', 'г', 'Г', 'γ', 'Γ'),
		'ga'	=>	array ('が', 'ガ'),
		'ge'	=>	array ('げ', 'ゲ'),
		'gh'	=>	array ('غ'),
		'gi'	=>	array ('ぎ', 'ギ'),
		'go'	=>	array ('ご', 'ゴ'),
		'gu'	=>	array ('ぐ', 'グ'),
		'h'		=>	array ('h', 'H', 'ح', 'ه'),
		'ha'	=>	array ('は', 'ハ'),
		'half'	=>	array ('½'),
		'he'	=>	array ('へ', 'ヘ'),
		'hi'	=>	array ('ひ', 'ヒ'),
		'ho'	=>	array ('ほ', 'ホ'),
		'i'		=>	array ('i', 'I', 'ì', 'Ì', 'í', 'Í', 'î', 'Î', 'ï', 'Ï', 'ı', 'İ', 'и', 'И', 'Ị', 'ị', 'Ỉ', 'ỉ', 'Ĩ', 'ĩ', 'い', 'イ', 'η', 'Η', 'Ι', 'ι'),
		'j'		=>	array ('j', 'J', 'ج'),
		'ji'	=>	array ('じ', 'ぢ', 'ジ', 'ヂ'),
		'k'		=>	array ('k', 'K', 'к', 'К', 'ك', 'κ', 'Κ'),
		'ka'	=>	array ('か', 'カ'),
		'ke'	=>	array ('け', 'ケ'),
		'kh'	=>	array ('х', 'Х', 'خ'),
		'ki'	=>	array ('き', 'キ'),
		'ko'	=>	array ('こ', 'コ'),
		'ku'	=>	array ('く', 'ク'),
		'l'		=>	array ('l', 'L', 'ł', 'Ł', 'л', 'Л', 'ل', 'λ', 'Λ'),
		'la'	=>	array ('ﻻ'),
		'm'		=>	array ('m', 'M', 'м', 'М', 'م', 'μ', 'Μ'),
		'ma'	=>	array ('ま', 'マ'),
		'me'	=>	array ('め', 'メ'),
		'mi'	=>	array ('み', 'ミ'),
		'mo'	=>	array ('も', 'モ'),
		'mu'	=>	array ('む', 'ム'),
		'n'		=>	array ('n', 'N', 'ñ', 'Ñ', 'ń', 'Ń', 'н', 'Н', 'ن', 'ん', 'ン', 'ν', 'Ν'),
		'na'	=>	array ('な', 'ナ'),
		'ne'	=>	array ('ね', 'ネ'),
		'ni'	=>	array ('に', 'ニ'),
		'no'	=>	array ('の', 'ノ'),
		'nu'	=>	array ('ぬ', 'ヌ'),
		'o'		=>	array ('o', 'O', 'ò', 'Ò', 'ó', 'Ó', 'ô', 'Ô', 'õ', 'Õ', 'ö', 'Ö', 'ø', 'Ø', 'º', 'о', 'О', 'Ọ', 'ọ', 'Ỏ', 'ỏ', 'Ộ', 'ộ', 'Ố', 'ố', 'Ỗ', 'ỗ', 'Ồ', 'ồ', 'Ổ', 'ổ', 'Ơ', 'ơ', 'Ờ', 'ờ', 'Ớ', 'ớ', 'Ợ', 'ợ', 'Ở', 'ở', 'Ỡ', 'ỡ', 'お', 'オ', 'ο', 'Ο', 'ω', 'Ω'),
		'p'		=>	array ('p', 'P', 'п', 'П', 'π', 'Π'),
		'pa'	=>	array ('ぱ', 'パ'),
		'pe'	=>	array ('ぺ', 'ペ'),
		'percent'	=>	array ('%'),
		'pi'	=>	array ('ぴ', 'ピ'),
		'plus'	=>	array ('+'),
		'plusminus'	=>	array ('±'),
		'po'	=>	array ('ぽ', 'ポ'),
		'pound'	=>	array ('£'),
		'ps'	=>	array ('ψ', 'Ψ'),
		'pu'	=>	array ('ぷ', 'プ'),
		'q'		=>	array ('q', 'Q', 'ق'),
		'quarter'	=>	array ('¼'),
		'r'		=>	array ('r', 'R', '®', 'р', 'Р', 'ر'),
		'ra'	=>	array ('ら', 'ラ'),
		're'	=>	array ('れ', 'レ'),
		'ri'	=>	array ('り', 'リ'),
		'ro'	=>	array ('ろ', 'ロ'),
		'ru'	=>	array ('る', 'ル'),
		's'		=>	array ('s', 'S', 'ş', 'Ş', 'ś', 'Ś', 'с', 'С', 'س', 'ص', 'š', 'Š', 'σ', 'ς', 'Σ'),
		'sa'	=>	array ('さ', 'サ'),
		'se'	=>	array ('せ', 'セ'),
		'section'	=>	array ('§'),
		'sh'	=>	array ('ш', 'Ш', 'ش'),
		'shi'	=>	array ('し', 'シ'),
		'shch'	=>	array ('щ', 'Щ'),
		'so'	=>	array ('そ', 'ソ'),
		'ss'	=>	array ('ß'),
		'su'	=>	array ('す', 'ス'),
		't'		=>	array ('t', 'T', 'т', 'Т', 'ت', 'ط', 'τ', 'Τ', 'ţ', 'Ţ'),
		'ta'	=>	array ('た', 'タ'),
		'te'	=>	array ('て', 'テ'),
		'th'	=>	array ('ث', 'θ', 'Θ'),
		'three-quarters'	=>	array ('¾'),
		'to'	=>	array ('と', 'ト'),
		'ts'	=>	array ('ц', 'Ц'),
		'tsu'	=>	array ('つ', 'ツ'),
		'u'		=>	array ('u', 'U', 'ù', 'Ù', 'ú', 'Ú', 'û', 'Û', 'ü', 'Ü', 'у', 'У', 'Ụ', 'ụ', 'Ủ', 'ủ', 'Ũ', 'ũ', 'Ư', 'ư', 'Ừ', 'ừ', 'Ứ', 'ứ', 'Ự', 'ự', 'Ử', 'ử', 'Ữ', 'ữ', 'う', 'ウ', 'υ', 'Υ'),
		'v'		=>	array ('v', 'V', 'в', 'В', 'β', 'Β'),	
		'w'		=>	array ('w', 'W', 'و'),
		'wa'	=>	array ('わ', 'ワ'),
		'wo'	=>	array ('を', 'ヲ'),
		'x'		=>	array ('x', 'X', '×', 'ξ', 'Ξ'),	
		'y'		=>	array ('y', 'Y', 'ý', 'Ý', 'ÿ', 'й', 'Й', 'ы', 'Ы', 'ي', 'Ỳ', 'ỳ', 'Ỵ', 'ỵ', 'Ỷ', 'ỷ', 'Ỹ', 'ỹ'),
		'ya'	=>	array ('я', 'Я', 'や'),
		'yen'	=>	array ('¥'),
		'yo'	=>	array ('よ'),
		'yu'	=>	array ('ю', 'Ю', 'ゆ'),
		'z'		=>	array ('z', 'Z', 'ż', 'Ż', 'ź', 'Ź', 'з', 'З', 'ز', 'ظ', 'ž', 'Ž', 'ζ', 'Ζ'),
		'za'	=>	array ('ざ', 'ザ'),
		'ze'	=>	array ('ぜ', 'ゼ'),
		'zh'	=>	array ('ж', 'Ж'),
		'zo'	=>	array ('ぞ', 'ゾ'),
		'zu'	=>	array ('ず', 'づ', 'ズ', 'ヅ'),
		'-'		=>	array ('-', ' ', '.', ','),
		'_'		=>	array ('_'),
		'!'		=>	array ('!'),
		'~'		=>	array ('~'),
		'*'		=>	array ('*'),
		''		=>	array ("'", '"', 'ﺀ', 'ع'),
		'('		=>	array ('(', '{', '['),
		')'		=>	array (')', '}', ']'),
		'$'		=>	array ('$'),	
		'0'		=>	array ('0'),
		'1'		=>	array ('1', '¹'),
		'2'		=>	array ('2', '²'),
		'3'		=>	array ('3', '³'),
		'4'		=>	array ('4'),
		'5'		=>	array ('5'),
		'6'		=>	array ('6'),
		'7'		=>	array ('7'),
		'8'		=>	array ('8'),	
		'9'		=>	array ('9'),
	);	
	$prettytext = '';	
	preg_match_all("~.~su", $veri, $characters);
	
	foreach ($characters[0] as $aLetter)
	{
		foreach ($characterHash as $replace => $search)
		{
			//	Karekter bulununca, o karakteri değiştir!
			if (in_array($aLetter, $search))
			{
				$prettytext .= $replace;
				break;
			}
		}
	}
	//	İstenmeyen '-' değerlerini kaldır
	$prettytext = str_replace('', '-', $prettytext);
	// Veritabanında aynı sef'e sahip veri olabileceği için url'nin sonunda tarih, saat eklenerek bu sorun giderilmektedir.
	if ($tarih_eklensin_mi == 1)
		$prettytext .= '-'.date('Y.m.d-H:i:s');
	
	return $prettytext;
}
/* Yüzde alan fonksiyon
 * 
 * Gelen değerin, toplam değere göre yüzdesini alan fonksiyon
 */
function gnc_yuzde($sayi, $toplam_sayi){
	return number_format($sayi/$toplam_sayi*100,0);
}
/* Bir arrayi istenen sayıda eşit parçaya bölmeye sağlar 
 * 
 * İki parametre alır; ilki dizinin kendisi, ikincisi kaç parçaya ayrılacağı
 */
function gnc_diziyi_bol($array, $parca_sayisi) {
    $array_len = count( $array );
    $part_len = floor( $array_len / $parca_sayisi );
    $partrem = $array_len % $parca_sayisi;
    
    $partition = array();
    $mark = 0;
	
    for ($i = 0; $i < $parca_sayisi; $i++) 
    {
        $incr = ($i < $partrem) ? $part_len + 1 : $part_len;
        $partition[$i] = array_slice( $array, $mark, $incr );
        $mark += $incr;
    }
    return $partition;
}
/* DOM parser, HTML etiketlerinin arasındaki veriyi çekmeyi sağlar 
 * 
 * 2 parametre alır, 
 * 
 * $html = HTML kodu
 * $etiket = HTML etiketi
 */
function gnc_html_etiketinin_arasindaki_deger($html, $etiket) {
    // HTML kodundan DOM yarat
    $html = str_get_html($html);

    $degerler = array();
    // Tüm etiketleri bul ve metin olarak değerleri array'e ata
    foreach($html->find($etiket) as $eleman)
        $degerler[] = $eleman->plaintext;
    
	return $degerler;
}
/* Proje ile ilgili olarak yazılan güzel sözlerin bir köşede dönmesi sıklıkla karşılaşılan bir durumdur. 
 * Bu işlemi yapan ve bu şekilde veri döndüren fonksiyon
 */ 
function gnc_guzel_sozler()
{
	$dizi[0] = 'Dâhi odur ki, ileride herkesin takdir ve kabul edeceği şeyleri ilk ortaya koyduğu zaman herkes onlara delilik der.';
	$dizi[1] = 'Ondan sonra sana büyüksün derlerse, bunu diyenlere de güleceksin.';
	$dizi[2] = 'Ne mutlu Türk\'üm diyene';
	$dizi[3] = 'Şef, görüşünü ve düşüncesini en üstün kabul ettiren, işi yönetendir. Şef, niteliği ve değeri en yüksek olan adamdır.';
	$dizi[4] = 'Muhtaç olduğun kudret damarlarındaki asil kanda mevcuttur.';

	shuffle($dizi);
	return $dizi[0];	
}
/* Veri tabanını yada sadece bir yabloyu yedeklemeyi sağlayan fonksiyon 
 * 
 * http://davidwalsh.name/backup-mysql-database-php
 * adresinden alınmıştır
 */
function gnc_veritabanini_yedekle($tablolar = '*')
{
	global $vt;
	
	// Tüm tabloları yada belitilen tabloyu seç 
	if($tablolar == '*')
	{
		$tablolar = array();
		$sonuc = $vt->query('SHOW TABLES');
		while($row = $vt->fetch_row($sonuc))
		{
			$tablolar[] = $row[0];
		}
	}
	else
	{
		$tablolar = is_array($tablolar) ? $tablolar : explode(',',$tablolar);
	}
	
	// Tablolar için sırayla yedeği oluştur
	foreach($tablolar as $tablo)
	{
		$sonuc = $vt->query('SELECT * FROM '.$tablo);
		$num_fields = $vt->num_fields($sonuc);
		
		$return.= 'DROP TABLE IF EXISTS '.$tablo.';';
		$row2 = $vt->fetch_row($vt->query('SHOW CREATE TABLE '.$tablo));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = $vt->fetch_row($sonuc))
			{
				$return.= 'INSERT INTO '.$tablo.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	// Dosyayı ana dizine yedekle
	$dosya = fopen('db-backup-'.time().'-'.(md5(implode(',',$tablolar))).'.sql','w+');
	fwrite($dosya,$return);
	fclose($dosya);
}
/* Parametreler arasındaki içeriği çekmek için kullanılır */
function gnc_icerik_icinde_ara($bas, $son, $icerik)
{
    @preg_match_all('/' . preg_quote($bas, '/') .
    '(.*?)'. preg_quote($son, '/').'/i', $icerik, $m);
    return @$m[1];
}
?>