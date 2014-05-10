<?php
/**********************************************************************************
* gnc.php                                                                         *
***********************************************************************************
* gnc: GNC - PHP tabanlı Framework ve İçerik Yönetim Sistemi                      *
* Arama Motoru Dostu Framework ve İçerik Yönetim Sistemi                          *
* =============================================================================== * 
* Yazılım Sürümü:             gnc 0.1 Beta                                        *
* Yazar:					  Günce Ali Bektaş <guncebektas@gmail.com>		      *
* Telif Hakkı Sahibi:         Günce Ali Bektaş, Eren Yaşarkurt					  *
* İndirme Adresi: 			  www.guncebektas.com 								  *
***********************************************************************************
* Bu yazılım gnc adı altında ücretsiz ve açık kaynak olarak Günce Bektaş 		  *
* tarafından sunulmuştur. Bu sistem adam gibi Türkçe bir tane bile framework      *
* olmaması dolayısıyla web geliştiricilere yardım amacıyla yapılmıştır.		      *
* 																				  *
* Güvenilir ve aşırı esnektir, ancak herşey 10 numara olsundan ziyade ihtiyaç 	  *
* duyulan herşey hızlı olsun mantığıyla yapılmıştır. 							  *
* 													                              *
* Kullanım hakkı dağıtım ve satış haklarını birlikte getirmez, dağıtımı ve satışı * 
* yasaktır her dosya kullanıcıya özel olarak işaretlenmiş olup, lisansa aykırı    *
* bir durum halinde T.C. Ankara Mahkemeleri yetkilidir.                           *
**********************************************************************************/

/*	
        Adındanda anlaşılabileceği gibi bu dosya, gnc'nin ana dosyasıdır.
        Bu dosya aracılığı ile tüm diğer fonksiyonlar çağrılmakta ve
        sitenin kullanıcı tarafından görüntülenebilmesi sağlanmaktadır.
        Yönetim fonksiyonları için lütfen yonetim klasörüne göz atınız.
*/

// Hata raporlamasını kapat
error_reporting(E_ALL);
//error_reporting(0);

// Bu ve altındaki dosyaların gnc'nin bir parçası olduğunu tanımla
define('gnc', 1);

// Oluşturulma süre hesabı için başlangıç microtime'ını tanımla
$baslangic = microtime();

// Blokları (Class'ları çağır)
require_once('bloklar/guvenlik.php');			// Güvenlikle ilgili fonksiyonların bulunduğu dosya fonksiyon_calistir, guvenlik ve temizlik fonsiyonları
require_once('bloklar/upload.class.php');		// Dosya yüklemem sınıfı

// Diğer sınıflar
require_once('bloklar/sms.class.php');			// SMS hizmeti sunan Nexmo'nun sınıfı
// Diğer önemli dosyalar
require_once('veritabani.php');					// Veritabanı ayarları ve veritabanı bağlantısı
require_once('ayarlar.php');					// Statik ve Dinamik ayarlar

/* Veritabanı üzerinden çalışacak oturum fonksiyonu
 * Eren Yaşarkurt tarafından yazılmıştır.
 */
function gnc_oturum_yukle()
{
	global $ayar;

	// Çerezlerin açık olduğundan emin ol ve get metodunu kapat
	@ini_set('session.use_cookies', true);
	@ini_set('session.use_only_cookies', true);
	@ini_set('session.cookie_lifetime', $ayar['oturum_omru'] * 60);

	/* Oturum açma ve kapatma fonksiyonları, bu değerleri boş bırakamadığımız
	   ve veritabanı bağlantısı önceden tanımlandığı için bir şey yapmıyorlar */
	function oturum_ac()
	{
		return 1;
	}
	function oturum_kapat()
	{
		return 1;
	}

	// Veritabanına bağlanıp oturum varmı kontrol et varsa oturumu oku
	function oturum_oku($oturum_no)
	{
		// Tarihi tanımla
		$tarih = time();

		$sorgu = mysql_query("
			SELECT oturum_id, oturum_veri
			FROM gnc_oturumlar
			WHERE oturum_id = '{$oturum_no}'");
		
        $oturum_verisi ='';

		while ($satir = mysql_fetch_assoc($sorgu))
		{
			$oturum_verisi = $satir['oturum_veri'];
		}
		mysql_free_result($sorgu);

		return $oturum_verisi;
	}

	// Oturum var mı kontrol et yoksa oluştur
	function oturum_yaz($oturum_no, $oturum_veri)
	{
		// Tarihi tanımla
		$tarih = time();

		// Oturum girdisini yap
		$sorgu = mysql_query("
			INSERT INTO gnc_oturumlar
			VALUES ('{$oturum_no}', '{$oturum_veri}', '{$tarih}')");

		// Oturum girdisi varsa süreyi ve veriyi güncelle
		if (empty($sorgu))
		{
			$sorgu = mysql_query("
				UPDATE gnc_oturumlar
				SET oturum_sure = '{$tarih}', oturum_veri = '{$oturum_veri}'
                WHERE oturum_id = '{$oturum_no}' AND oturum_sure < {$tarih}");
		}
		return $sorgu;
	}

	// Oturumu kaldır
	function oturum_kaldir($oturum_no)
        {
 		$sorgu = mysql_query("
			DELETE FROM gnc_oturumlar
			WHERE oturum_id = '{$oturum_no}'");

		return $sorgu;
	}

	// Süresi dolmuş oturumları temizle
	function oturum_temizle($oturum_omru)
        {
		global $ayar;

		// Tarihi tanımla
		$tarih = time();
		
		$oturum_omru = $tarih - ($ayar['oturum_omru'] * 60);

 		$sorgu = mysql_query("
			DELETE FROM gnc_oturumlar
			WHERE oturum_sure < {$oturum_omru}");

		return $sorgu;
	}

	// Ön tanımlı php fonksiyonunu kullanarak oturumu tanımla
	session_set_save_handler('oturum_ac', 'oturum_kapat', 'oturum_oku',
		'oturum_yaz', 'oturum_kaldir', 'oturum_temizle');
		
	// Oturum çerezinin adını belirt
	session_name($ayar['cerez_adi']);

	// En sonunda oturumu başlat
	session_start();
	
	// Üye grubu tanımlanmamışsa ziyaretçi olduğunu belirt
	if (empty($_SESSION['kullanici_tipi'])){
		$_SESSION['kullanici_tipi'] = 0;
		$_SESSION['kullanici_id'] = 0;
	}
}
// Veritabanından oturumu yükle
gnc_oturum_yukle();
				
require_once('bloklar/pagination.class.php');	// Sayfalama için kullanılan sınıf
require_once('bloklar/framework.php');			// Çeşitli HTML elemanlar için hazır kodların bulunduğu php dosyası

// Kullanım dilinin seçimini yap, eğer dil dosyası yoksa gnc_ayarlar tablosunda geçerli olan varsayılan çalışma diline ait dosyayı çağırır.
if (!empty($_GET['dil']))
{
	$tarayici_dili = $_GET['dil'];
	$sorgu = $vt->query("SELECT * FROM gnc_diller WHERE dil_kodu = '$tarayici_dili' LIMIT 1");
	$sonuc = $vt->fetch_array($sorgu);
	if($sorgu)    
	{
		$_SESSION['dil'] = $sonuc['dil_kodu'];
		$_SESSION['dil_kodu'] = $sonuc['dil_kodu_uzun']; 
	}
	else
		$_SESSION['dil'] = $ayar['varsayılan_calisma_dili'];
}
if (empty($_SESSION['dil']))
{
	$tarayici_dili = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$sorgu = $vt->query("SELECT * FROM gnc_diller WHERE dil_kodu = '$tarayici_dili' LIMIT 1");
	$sonuc = $vt->fetch_array($sorgu);
	if($sorgu)    
	{
		$_SESSION['dil'] = $sonuc['dil_kodu'];
		$_SESSION['dil_kodu'] = $sonuc['dil_kodu_uzun']; 
	}
	else
		$_SESSION['dil'] = $ayar['varsayılan_calisma_dili'];
	
	$_SESSION['dil_kodu'] = $sonuc['dil_kodu_uzun']; 
}
if (strpos($_SERVER['HTTP_USER_AGENT'],"Googlebot"))
	$_SESSION['dil'] = $ayar['varsayılan_calisma_dili'];

/* Dil seçimine uygun olarak dil dosyasını çağır
 * 
 * Diller klasörünün içinde tr.php / en.php vs.. isimli boş bir dosya olursa, dil değişkenleri tanımlı olmadığı için notice hatası ile karşılaşırsınız.
 * Bu konuyu burada sizin için hatırlatma ihtiyacı duyuyorum. Boş dil dosyası asla bulundurmayın!
 */
if (file_exists('sistem/diller/'. $_SESSION['dil'] .'.php'))
	require_once('diller/'. $_SESSION['dil'] .'.php');	
else
	require_once('diller/'. $ayar['varsayilan_calisma_dili'] .'.php');

/* Sosyal Ağlar 
 *
 * Facebook, Twitter gibi sosyal ağların api ve classları 
 * 
 * Facebook PHP SDK için https://github.com/facebook/facebook-php-sdk
 */
// Facebook classını çağır ve https://developers.facebook.com/apps adresinden yaratılan uygun id ve secret ile objeyi yarat
require_once('bloklar/facebook/facebook.php');
$facebook = new Facebook(array(
  'appId'  => $ayar['facebook_appid'],
  'secret' => $ayar['facebook_secret'],
));
// FB kullanıcısını yaratalım, eğer giriş yapmış kullanıcı varsa unique id yoksa 0 değeri döndürür!
$facebook_kullanicisi = $facebook->getUser();
	
// GNC içinde yoğunca kullanılan ortak fonksiyonları çağır (üyelik, tarih, dizi, hata, başarı, vs)
require_once('fonksiyonlar.php');
// Sitede yoğunca kullanılan ortak fonksiyonları çağır
require_once('fonksiyonlar_site.php');

/* Arama motoru optimizasyonu ve çağırılacak sayfanın tespit edilmesini sağlayan fonksiyon, icerik fonksiyonuyla koordine içinde çalışır
 * 
 * GET metodu kadar güvenilir olduğu için buradan alınan veriler sadece gorunum dosyalarında kullanılmalıdır
 */
function gnc_urlyi_al($degisken)
{
	if (isset($_SERVER['ORIG_PATH_INFO']))
    	$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];   
	// Adresler için bir array tanımla
	if (isset($_SERVER['PATH_INFO']))
	{
        // Adresteki index.php den sonraki kısmı alıp düzenle
 		$PATH_INFO = substr($_SERVER['PATH_INFO'], 1-strlen($_SERVER['PATH_INFO']), 255);
		$url = array();
		$url = explode('/', guvenlik($PATH_INFO));
	}
	if (isset($url[$degisken]))
		return guvenlik($url[$degisken]);
}
// Arama motoru dostu şekilde mevcut sayfanın url'sini alan fonksiyon 
function gnc_mevcut_url(){
	global $site;	
	if (isset($_SERVER['PATH_INFO']))
		return $site['url'].substr($_SERVER['PATH_INFO'], 1-strlen($_SERVER['PATH_INFO']), 255);
	else 
		return $site['url'];
}
$adres['dosya'] = @gnc_urlyi_al(0);
$adres['fonk']  = @gnc_urlyi_al(1);
for ($i=1; $i<10; $i++)
	$adres['url'.$i]  = @gnc_urlyi_al($i+1);

// Mevcut url'yi tanımla
$adres['mevcut'] = @gnc_mevcut_url();

// Eğer site bakımda ise siteyi durdur ve bakim görünümünü yükle
if ($ayar['bakimda'] == 'on')
{
	if ($_SESSION['kullanici_tipi'] > 99)
		echo '<p>Siteyi bakım modunda görüntülemektesiniz, yöneticiler dışında sitenizi ziyaret eden kullanıcılar sitenizin bazı özelliklerini kullanamıyor olabilir. Siteyi normal haline döndürmek için sistem yöneticisi ile irtibata geçiniz.</p>';
	
	if ($adres['dosya'] != 'yonetim' && $adres['dosya'] != 'giris' && $_SESSION['kullanici_tipi'] < 100)
	{
		require_once('gorunum/bakim.php');
		die;	
	}	
}


// PDF, JS ve XML Site Haritası fonksiyonunu sayfayı sıkıştırmadan önce çağır
if ($adres['dosya'] == 'pdf')
{
	require_once('gorunum/pdf.php');
	pdf();
	die;
}
if ($adres['dosya'] == 'sitemap.php' || $adres['dosya'] == 'site-haritasi.xml' || ($adres['url1'] == 'xml' && $adres['url2'] == 'xsl'))
{
	require_once('gorunum/siteharitasi.php');
	site_haritasi();
	die;
}

// Gzip sıkıştırmasını kontrol et
if (!empty($ayar['gzip_sikistirma']) && ini_get('zlib.output_compression') == FALSE)
	ob_start('ob_gzhandler');
else
	ob_start();

// RSS
if ($adres['dosya'] == 'rss')
{
 	require_once('model/rss.php');
	require_once('gorunum/rss.php');
	rss();
	die;
}
// Ajax kodları
if ($adres['dosya'] == 'ajax')
{
	// Yönetimsel ajax fonksiyonlarının bulunduğu dosya
	require_once('ajax.php');
	die;
}
if ($adres['dosya'] == 'ajax-site')
{
	// Site bazında projeye ait olan ajax fonksiyonlarının bulunduğu dosya
	require_once('ajax_site.php');
	die;
}
/* Siteyi ziyaret eden tüm üyeler için tanımlı olması gereken oturum verileri */
$_SESSION['kullanici_timestamp'] = $site['suan'];
$_SESSION['kullanici_ip'] = gnc_ip();

/* Adres çubuğuna yazılanlara göre uygun olan görünüm ve model dosyalarını çağıran fonksiyon
 * Dosyalara erişim yetkilerinide kontrol ederek 503 ve 404 hataları gösterir.
 * 
 * Adres çubuğunda alan adından sonra yazılan ve gnc_yonlendiriciler tablosunda yer alan dosya_id'lerini çeker,
 * burası boş olduğunda 404 hatası oluşur. Sisteme yeni sayfa eklemek için;
 * gnc_moduller ve gnc_yonlendiriciler tabloları doldurulmalıdır.
 */
function gnc_sayfa()
{
	global $adres, $ayar, $cache, $dil, $facebook, $pdo, $site, $vt;
	
	if (empty($adres['dosya']))
		$adres['dosya'] = $ayar['index'];
	
	$sorgu = $vt->query("
		SELECT yonlendirici_sef, dosya_adi, dosya_izin_durumu, dosya_header, dosya_footer, dosya_gorunum_cache, dosya_model_cache, dosya_header_cache, dosya_footer_cache
		FROM gnc_moduller
		LEFT JOIN gnc_yonlendiriciler ON gnc_yonlendiriciler.dosya_id = gnc_moduller.dosya_id
		LEFT JOIN gnc_menulerin_elemanlari ON gnc_menulerin_elemanlari.dosya_id = gnc_moduller.dosya_id
		WHERE gnc_moduller.dosya_yayin_durumu = 1 AND 
			  (
			  gnc_yonlendiriciler.yonlendirici_sef = '{$adres['dosya']}'
			  OR
			  gnc_menulerin_elemanlari.menu_eleman_href = '{$adres['dosya']}'
			  )
		ORDER BY gnc_moduller.dosya_id ASC 
		LIMIT 1");
	
	$sql_say = $vt->num_rows($sorgu);
	$sonuc  = $vt->fetch_array($sorgu);
	
	// Kullanıcının görmek isteği sayfaya erişim izni varmı, yoksa 401 hatası göster
	if ($sonuc['dosya_izin_durumu'] > $_SESSION['kullanici_tipi']){
		// Dosyaya erişim izni yoksa giris sayfasını göster...
		$sonuc['dosya_header'] = 'yonetim/header_gnc';
		$sonuc['dosya_adi'] = '401';
		$sonuc['dosya_footer'] = 'yonetim/footer_gnc';
	}
	
	// İstenilen sayfa varsa sayfayı görüntüle aksi takdirde 404 hatası ver
	if (file_exists('sistem/gorunum/'.$sonuc['dosya_adi'].'.php') && $sql_say > 0)
	{
		// Model dosyasını çağır
     	if ($sonuc['dosya_model_cache'] == 1 && $_SESSION['kullanici_tipi'] < 111){
			gnc_ile_cache('basla','model-'.$sonuc['dosya_adi']);
			if($cache)
				@include('model/'.$sonuc['dosya_adi'].'.php');
			gnc_ile_cache('bitir','model-'.$sonuc['dosya_adi']);	
		}
		else {
			@include('model/'.$sonuc['dosya_adi'].'.php');	
		}
		
		// Header dosyasını çağır
		if (empty($sonuc['dosya_header']))
			$sonuc['dosya_header'] = 'header';
		
		if ($sonuc['dosya_header_cache'] == 1 && $_SESSION['kullanici_tipi'] < 111){
			gnc_ile_cache('basla','header-'.$sonuc['dosya_header']);
			if($cache)
				include('gorunum/'.$sonuc['dosya_header'].'.php');
			gnc_ile_cache('bitir','header-'.$sonuc['dosya_header']);	
		}
		else {
			include('gorunum/'.$sonuc['dosya_header'].'.php');	
		}
		
    	// Görünüm dosyasını çağır
		if ($sonuc['dosya_gorunum_cache'] == 1 && $_SESSION['kullanici_tipi'] < 111){
			gnc_ile_cache('basla','gorunum-'.$sonuc['dosya_adi']);
			if($cache)
				include('gorunum/'.$sonuc['dosya_adi'].'.php');
			gnc_ile_cache('bitir','gorunum-'.$sonuc['dosya_adi']);	
		}
		else {
			include('gorunum/'.$sonuc['dosya_adi'].'.php');	
		}
    	
		// Footer dosyasını çağır
		if (empty($sonuc['dosya_footer']))
			$sonuc['dosya_footer'] = 'footer';
		$sonuc['dosya_footer_cache'] = 0;
		if ($sonuc['dosya_footer_cache'] == 1 && $_SESSION['kullanici_tipi'] < 111){
			gnc_ile_cache('basla','footer-'.$sonuc['dosya_footer']);
			if($cache)
				include('gorunum/'.$sonuc['dosya_footer'].'.php');
			gnc_ile_cache('bitir','footer-'.$sonuc['dosya_footer']);
		}
		else{
			include('gorunum/'.$sonuc['dosya_footer'].'.php');	
		}
	}
	else
	{
    	include('gorunum/header.php');
		gnc_sorun(404);
		include('gorunum/footer.php');
	}
}
/* URL yapısına uygun olarak yönetim sayfası gibi özel sayfaların 
 * yetki parametrelerine dikkat ederek görünümün dosyalarını çağıran fonskiyon
 * 
 * Açılacak sayfada çalıştırılacak olan fonksiyonu belirler, varsayılan fonksiyon ismini parametre olarak almaktadır.
 */
function _gnc_sayfa_fonksiyonu($varsayilan){
	global $adres, $site;

	if (!empty($adres['fonk']));
		$adres['fonk'] = str_replace('-', '_', $adres['fonk']);
	if (!empty($adres['url1']));
		$adres['url1'] = str_replace('-', '_', $adres['url1']);
	
	/* Bu tanımlamadan sonra eğer çağırılan fonksiyon varsa onlar çalıştırılacak
	 * 
	 * Burada yer alacak fonksiyonlar url'den otomatik olarak çağırıldığı için bu dosyanın içerisinde (gnc de her zaman dosyanın sonunda) "function fonksiyon_adi()" şeklinde fonksiyonun yaratılması yeterlidir.
	 * Aşağıda eğer url1 tanımlanmamışsa hangi sayfa açılacak, tanımlanmışsa fonksiyon hangi html kodun içine çağırılacak gösterilmektedir.
	 */
	if (empty($adres['fonk']) && function_exists($adres['dosya']))
		fonksiyon_calistir($adres['dosya']);
	elseif (empty($adres['fonk']) && !function_exists($adres['dosya']))
		$varsayilan();	
	else
	{
		if (empty($adres['url1']) && function_exists($adres['fonk']))
			fonksiyon_calistir($adres['fonk']);
		elseif (!empty($adres['url1']) && function_exists($adres['url1']) && function_exists($adres['fonk']))
		{
				echo '<!-- Main content -->
				<div class="wrapper">    
				    <div class="fluid">
				    					
				        <!-- Yönetim sayfasına ait hoşgeldin mesajı -->
				        <div class="widget grid12">';
	
						fonksiyon_calistir($adres['url1']);	
	
				  echo '</div>
				        <div class="clear"></div>
				    </div>				    
				</div>';	
		}
		else 
		{
			gnc_sorun('yonetim/404');
		}	
	}
}
/* Cache'leme fonksiyonu 
 * 
 * Genel olarak belirlenen parametrelere göre php sayfalarının txt formatında dökümlerini ./sistem/cache/ klasörüne alarak. 
 * İstek yapıldığında tekrar php dosyası gösterilmesi yerine .txt dosyasının çağırılması mantığına göre çalışmaktadır.
 * 
 * 3 parametre alır. 
 * 
 * $islem, basla yada bitir
 * $cache_ismi, yaratılacak cache dosyasının ismidir.
 * $cache_suresi, saniye cinsinden cache süresidir. Eğer sayfa isteği bu süreden sonra yapılırsa cache yenilenir.
 * 
 * Bu fonksiyon http://caqlayan.com/file-cache-nedir-nasil-yapilir adresinden alınmıştır.
 * */
function gnc_ile_cache($islem, $cache_ismi = null, $cache_suresi = 0){
	global $adres, $ayar, $cache;
	
	if ($ayar['cache_suresi'] != 0)
	{
		if($cache_suresi == 1)
			$cache_suresi = $ayar['cache_suresi'];	
		if($cache_ismi == null)
			$cache_ismi = md5($_SERVER['REQUEST_URI']);
		
		// Cache dosyalarının isimleri karmaşaya sebep olmamak için modüller tablosunda belirtildiği şekliyle alınacaktır, dolayısıyla / gibi ifadeler - şekline getirilmelidir.
		$cache_ismi = str_replace('/', '-', $cache_ismi); 
		// Klasör ve dosya adı ayarları
		$cache_klasor = "sistem/cache";
		$cache_dosya_adi = $cache_klasor."/$cache_ismi.txt";
		 
		// Klasör yoksa oluştur, izinleri ver
		if(!is_dir($cache_klasor)) 
			mkdir($cache_klasor, 0755);
		 
		if($islem == 'basla')
		{
			if(file_exists($cache_dosya_adi) && (time() - filemtime($cache_dosya_adi)) < $cache_suresi){
				$cache = false;
				include($cache_dosya_adi);
			} 
			else 
			{
				$cache = true;
				ob_start();
			}
		}
		elseif($islem == 'bitir' && $cache)
		{
			file_put_contents($cache_dosya_adi,ob_get_contents());
			ob_end_flush();
		}	
	}
}
/* Sayfanın title bölümünde istenen ifadeyi gösterecek fonksiyon
 * 
 * Arama motoru dostu siteler için her sayfanın kendine has title (başlık) değerinin olması önemlidir. gnc; başlık değerini 
 * url adresinde yer alan fonksiyon ve dosya(sayfa) isimlerinden otomatik olarak yaratmak için bu fonksiyonu kullanmaktadır.
 */

function gnc_baslik()
{
	global $adres, $ayar;
	if (!empty($adres['fonk']))
		return ucfirst(str_replace('-', ' ', $adres['fonk'])). ' | ' .$ayar['site_adi'];
	elseif (!empty($adres['dosya']))
		return ucfirst(str_replace('-', ' ', $adres['dosya'])). ' | ' .$ayar['site_adi'];
	else
		return $ayar['site_adi'];
}




