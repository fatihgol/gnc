<?php
/*
 * Sitenin kullandığı veritabanı ayarları ve bağlantıların kurulduğu dosya
 * 
 * GNC hem PDO hemde mySQL class'ını birlikte kullanmaktadır. PHP versiyonunuz 5.1'in üzerindeyse PDO kullanabilirsiniz.
 * Fonksiyon ve sayfalarınızın içerisinde GNC'nin veritabanı bağlantı mantığını kullanmak için duruma göre
 * 
 * global $pdo, $vt; şeklinde tanımlı değişkenleri kullanmanız yeterlidir.
 * 
 * Ayrıca SMF forumu kullanılacaksa, forum/Settings.php'deki veritabanı ayarları düzenlenmelidir.
 */

if (!defined('gnc'))
	die();

/*
 * Veritabanı bağlantı ayarları ve veritabanı bağlantısı
 */
$vt_ayarlari = array(
  'sunucu_adresi' => 'localhost',
  'veritabani_adi' => 'gnc',
  'veritabani_tipi' => 'mysql',
  'kullanici_adi' => 'root',
  'kullanici_sifresi' => '26081986',
  'tablo_oneki' => 'gnc_',
  'karakter_seti' => 'charset=utf8',
  'baglanilamadi' => '<h2>Veritabanına Bağlanılamadı</h2><p>Veritabanına bağlanırken bir sorun ile karşılaşıldı. Kısa bir süre içerisinde tekrar deneyiniz, eğer sorun devam ederse site yöneticisi ile iletişime geçiniz.</p>'
);

/* PDO sınıfını kullanarak veritabanına bağlanma
 * 
 * Normal mySQL bağlantısı modası geçmiş ve çağın ihtiyaçlarına cevap veremeyecek seviyede kalmıştır. Zaten PHP'nin geliştiricileri de artık kullanılmasını önermemekterdir. 
 * Bu sebeple GNC'de PDO'ya yer verilmiştir. PDO, PHP 5.1'den itibaren gelen bir özellik olup PHP 5'teki yeni nesne yönelimli özelliklere ihtiyaç duyar; 
 * Bu bakımdan PHP'nin daha önceki sürümleri ile çalışmaz. Kendinizi yenilemek ve çağın gerisinde kalmamak için PDO'yu kullanmanızı öneriyorum. 
 * 
 * Şimdi PDO'ya geçmezseniz çok geç kalabilirsiniz ancak korkmayın bunu söylememe rağmen GNC içerisinde güçlü ve basit bir mySQL sınıfıyla gelmekte olup yönetim paneli kapsamındaki tüm sorgular klasik metodla yazılmıştır. 
 * Yeni versiyonlarda sadece PDO ile çalışacağımızı şimdiden sizlere söylemek isterim.
 * 
 * PDO, mySQLi ve mySQL karşılaştırmaları için internette yüzlerce kaynak bulabilirsiniz ama http://php.net/manual/en/book.pdo.php sayfasını mutlaka incelemelisiniz.
 */
if (phpversion() > 5)
{
	require_once('bloklar/pdo.class.php');		// PDO ile veritabanına bağlantı sağlayan sınıf, içerisinde PDOStatement classıda extend edilmiştir.
	$pdo = new gnc_pdo($vt_ayarlari);
}
	
/* mySQL veritabanına bağlanma
 * 
 * Veritabanına bağlanması gereken fonksiyonlarda $vt değişkeni çağırılmalıdır. 
 * $vt gibi farklı yetkilere sahip kullanıcılarla SQL bağlantıları kurulup, gereken yerlerde gerekli özelliklere sahip kullanıcılarla oluşturulan bağlantıların çağırılması güvenliği arttıracaktır.
 * 
 * Örneğin;
 * Sitenin ziyaretçileri sadece sayfayı görüntüleyecekse vetitabanına bağlantısı için kullanılacak hesaba sadece SELECT yetkisinin verilmesi çoğu zaman yeterli olacaktır.
 * 
 * Bu güvenlik farklı veritabanlarına bağlantılar kurularak daha da güvenli hale getirilebilir. GNC için bu iş çocuk oyuncağıdır. 
 * 
 * Bu tip bir bağlantılar için aşağıdaki işlemi uygun veritabanı kullanıcılarıyla tekrarlamınız yeterlidir.
 */
if ($vt_ayarlari['veritabani_tipi'] == 'mysql')
{
	require_once('bloklar/mysql.class.php');	// mySQL için veritabanı bağlantısı sağlayan sınıf, modası geçmiş eski kullanım için
	$vt = new vt_mysql($vt_ayarlari['sunucu_adresi'], $vt_ayarlari['kullanici_adi'], $vt_ayarlari['kullanici_sifresi'], $vt_ayarlari['veritabani_adi']);
	
	// UTF-8 fonksiyonu tanımlanmadıysa fonksiyonu tanımla
	if (function_exists('mysql_set_charset') === false)
	{
		function mysql_set_charset($charset, $link_identifier = null)
		{
			if ($link_identifier == null)
				return mysql_query('SET NAMES "'.$charset.'"');
	  		else
				return mysql_query('SET NAMES "'.$charset.'"', $link_identifier);
		}
	}
	mysql_set_charset('utf8');
}
?>