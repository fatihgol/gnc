<?php 
/**** AÇIKLAMALAR ***
 * 
 * 	Sabit ayarların tamamı ./sistem/ayarlar.php dosyasından 
 * 	Veritabanı ayarları ./sistem/veritabanı.php dosyasından yapılmalıdır
 * 
 * 	Dosya izinleri genel olarak 755 olarak tanımlanabilir ancak ./veri ve ./sistem/cache klasörleri ise yöneticinin veya kullanıcının dosya yükleyeceği 
 *  dizinler olduğu için 777 olarak tanımlanmalıdır. Bunun bir güvenlik riski de doğurabileceğini düşünmeli ve gerektiği yerde yetkilendirilme yapılması yerinde olacaktır.
 */



/**** .htaccess dosya içeriği aşağıdaki şekilde tanımlanabilir ****
	
	SetOutputFilter DEFLATE
	AddDefaultCharset UTF-8
	DefaultLanguage tr-TR
	RewriteEngine On
	RewriteBase /
	RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
	RewriteRule ^(.*)$ http://%1/$1 [R=301,L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php/$1 [L]

******************************************************************/

ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');

require('sistem/gnc.php');

//echo gnc_encrypt('14743');
//print_r($adres);
//print_r($site);
//print_r($ayar);
//print_r($_SESSION);
//print_r($facebook_kullanicisi);
//die();

echo gnc_sayfa(); 
?>
