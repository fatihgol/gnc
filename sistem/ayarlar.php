<?php
/*
 * Site ile ilgili statik ayarları içeren dosya. Bu dosyayı kullanarak
 * bazı site bilgilerini düzenleyebilirsiniz.
 * 
 * Editör olarak CKFinder ve CKEditor kullanılacaksa kendi klasörleri içerisindeki ayarlar düzenlenmelidir.
 * 
 */

if (!defined('gnc'))
	die();

/* Sitenin statik ayarları */
$site['adresi'] = 'localhost/gnc/'; 	// Sitenin adresi
$site['url'] = 'http://localhost/gnc/';	// Sitenin tam adresi
$site['yuklu_oldugu_konum'] = '//Applications/MAMP/htdocs/gnc/'; // Sitenin bulunduğu konum
// Dosyaların türlerine göre konumlanacağı klasörler
$site['dosya_yuklenecek_adres'] = 'veri/dosyalar/';
$site['resim_yuklenecek_adres'] = 'veri/_images/';
$site['video_yuklenecek_adres'] = 'veri/_files/';
// Dosyaların türlerine göre konumlanacağı tam url'ler
$site['veri_yolu']  = $site['url'].'veri/';
$site['dosya_yolu'] = $site['url'].$site['dosya_yuklenecek_adres'];
$site['resim_yolu'] = $site['url'].$site['resim_yuklenecek_adres'];
$site['video_yolu'] = $site['url'].$site['video_yuklenecek_adres'];

// Sitenin kullandığı yazılımın sürümü
$site['surum'] = '1.0';

/* SMS göndermek için kullanılan Nexmo servisinden alınan değerler
 * 1: Nexmo nun sınıfını çağır.
 * $sms = new NexmoMessage($site['nexmo_api_key'], $site['nexmo_secret']);
 * 2: Sınıfta tanımlı olan sendText($to, $from, $message) ile sms gönder
 * $bilgi = $sms->sendText($kime, $kimden, $mesaj);
 * 
 * Eğer gönderilen mesajın gösterilmesi gerekirsede displayOverview aşağıdaki gibi kullanılabilir.
 * echo $sms->displayOverview($bilgi);
 * 
 * Detaylı bilgi için www.nexmo.com
 */ 
$site['nexmo_api_key'] = "91f273f2";
$site['nexmo_secret'] = "9d9192f0";

/* 
 	Eğer sunucunuz mod_rewrite'ı destekliyorsa aşağıdaki değeri 1 yapıp adreslerdeki
	index.php/ metnini kaldırabilirsiniz 
*/
$site['url_oneki'] = 1;
switch ($site['url_oneki'])
{
	case 0:	$site['index'] = 'index.php/';
		break;
	case 1:	$site['index'] = '';
		break;
}
// Sitenin her yerinde kullanılacak site adresi
$site['url'] = $site['url'].$site['index']; // Sitenin tam adresi

// Veritabanına kaydedilen ve yönetim sayfasından değiştirilebilen dinanik ayarları çağıran fonksiyon
$ayar = gnc_ayarlar_ayarlari_cagir();			

// Bugünün tarihi
$site['bugun'] = date("Y-m-d");
$site['saat'] = date("H:s");
$site['suan'] = time();

function gnc_ayarlar_ayarlari_cagir()
{
	global $vt;		
	// Ayarları çağırarak ayar dizisi yarat
	$sorgu = $vt->query("
		SELECT * FROM gnc_ayarlar
		ORDER BY ayar_id ASC");

	$ayar = array();
	while ($sonuc = $vt->fetch_array($sorgu)){
		$ayar[$sonuc['ayar_adi']] = $sonuc['ayar_degeri'];
	}
	$varsayilan_dil_sorgusu = $vt->query("SELECT * FROM gnc_diller WHERE dil_kodu = '{$ayar['varsayilan_calisma_dili']}'");
	$varsayilan_calisma_dili = $vt->fetch_array($varsayilan_dil_sorgusu);
	$ayar['varsayilan_calisma_dili_id'] = $varsayilan_calisma_dili['dil_id'];
	
	// http://us1.php.net/manual/en/timezones.php adresindeki gibi varsayılan zaman farkını belirle 
	if (!empty($ayar['yerel_zaman_farki']))
		date_default_timezone_set($ayar['yerel_zaman_farki']);	

	return $ayar;
}

?>