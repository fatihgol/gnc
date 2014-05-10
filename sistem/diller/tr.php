<?php
if (!defined('gnc'))
	die();

/* 
 * GNC için önemli olan ifadeler
 */ 
require_once('sistem/diller/yonetim/tr.php');

/*
 * Yapılan site için kullanılacak olan dil değişkenleri
 */
// Tuşlar ve ifadeler
$dil['facebookta_paylas'] = 'Facebookta paylaş';

// Menü
$dil['yaptiklarim'] = 'Yaptıklarım';
$dil['hakkimda'] = 'Hakkımda';
$dil['kahve'] = 'Kahve?';
$dil['forum'] = 'Forum';
$dil['blog'] = 'Blog';
$dil['iletisim'] = 'İletişim';

// Footer
$dil['gunce_kimdir_baslik'] = 'Günce kimdir?';
$dil['gunce_kimdir_icerik'] = 'Kendi halinde freelance çalışmayı seven, GNC\'yi geliştiren, PHP tutkunu web geliştiricilerden biriyim.';
$dil['beni_takip_edin'] = 'Beni takip edin';
$dil['son_yenilikler'] = 'Son yenilikler';
$dil['kisaca_gnc_nedir_baslik'] = 'Kısaca GNC nedir?';
$dil['kisaca_gnc_nedir_icerik'] = 'GNC web geliştiriciler için hazırlanmış bir Framework ve CMS karışımı basitliği amaç edinmiş bir PHP yazılımıdır';
$dil['neden_gnc_baslik'] = 'Neden GNC?';
$dil['neden_gnc_icerik'] = 'Günümüzde web sitesi yapımı için hız, kolaylık ve güvenlik sorunları geliştiricileri sürekli zorlamakta olup CodeIgniter, Cake, Zend, Symfony, Yii gibi sistemleri öğrenmek başlı başına bir uğraş haline gelmektedir. Ayrıca bu sistemler katı kurallara sahip oldukları için yavaş çalışmakta ve zaman zaman can sıkıcı olmaktadır. Bu sistemlere alternatif olarak uç kullanıcıyı değilde web geliştiricileri hedefleyen, herhangi bir ön çalışmayı gerektirmeyen PHP temelli GNC oluşturulmuştur.';

// Anasayfa
$dil['indir_v'] = 'İndir v.'.$site['surum'];
$dil['slide1_icerik'] = 'Ücretsiz, Türkçe ve Açık kaynak kodlanan içerik yönetim sistemi GNC beta sürümüyle karşınızda, web projelerini hızlı, kolay ve güvenilir şekilde geliştirmek için sizde deneyin... Denemesi bedava!';
$dil['slide2_baslik'] = 'Tamamen ücretsiz';
$dil['slide2_icerik'] = 'GNC\'yi geliştirdikten sonra ortaya çıkan ürüne basit bir fiyat biçmem imkansız oldu, bundan dolayı ücretsiz olarak dağıtmanın daha mantıklı olacağına karar verdim. GNC\'yi projelerinizde ücretsiz olarak kullanabilir, ismini değiştirebilir, parayla bir başkasına satabilir veya geliştirmeme yardımcı olabilirsiniz.';
$dil['slide3_baslik'] = 'Az kod, çok iş';
$dil['slide3_icerik'] = 'GNC sayesinde web sitenizi, blogunuzu vs... çok daha kolay, hızlı ve güvenli şekilde geliştirebileceksiniz. Çünkü geliştiricilerin en çok kullandıkları ve problem yaşadıkları kodlar GNC içerisinde hazır şekilde bulunmaktadır.';
$dil['slide4_baslik'] = 'CMS Entegrasyonu';
$dil['slide4_icerik'] = 'GNC içerisinde barındırdığı ckeditor ile ckfinder\'ın tam entegrasyonunu sağlamış ender CMS\'lerden biridir. Bunun gücünü ve tadını almak için indir tuşuna basmanız yeterli...';
$dil['slide5_baslik'] = 'Bootstrap';
$dil['slide5_icerik'] = 'GNC, bootstrap ile %100 uyumlu ve örnek tasarıma sahip olarak gelmektedir...';

$dil['karsinizda_gnc'] = 'Bir web geliştiricinin istediği herşey, karşınızda GNC';
$dil['cms_baslik'] = 'CMS';
$dil['cms_icerik'] = 'GNC için yalnız içerik yönetim sistemi demek hatalı olacaktır ancak kategori, içerik ve şablon yapısıyla herhangi bir CMS\'den isteyeceğiniz her türlü özelliği size sunmaktadır.. ';
$dil['anlasilir_baslik'] = 'Basit ve Anlaşılır';
$dil['anlasilir_icerik'] = 'İçerik yönetim sisteminin yanı sıra framework kapsamında yazılan her satır kodun ne işe yaradığı, nasıl kullanıldığı, ne amaçla kullabileceği açıkça anlatılmıştır...';
$dil['hizli_guvenilir_baslik'] = 'Hızlı ve Güvenilir';
$dil['hizli_guvenilir_icerik'] = 'GNC yapısı gereği çok basit kurgulanmış olup temel php, jquery bilgisine sahip olan herkes bu çatı ile kolay ve hızlı şekilde web sitesi oluşturabilir...';

$dil['ucretsiz_acik_kaynak_baslik'] = 'Ücretsiz ve Açık kaynak kodlu';
$dil['ucretsiz_acik_kaynak_icerik'] = 'GNC ücretsiz ve açık kaynak kodlu olarak yürütülen bir projedir. Tek amacı web geliştiricilerin uluslararası standartlar dahilinde kod yazmalarını sağlamak olup içerisinde bulundurduğu özelliklerle bir web geliştiricinin ihtiyacı duyacağı herşeyi barındırmaktadır.';

// Kullanıcı Girişi & Kayıt
$dil['giris'] = 'Giriş';
$dil['kayit'] = 'Kayıt';
$dil['facebook_ile_baglan'] = 'Facebook ile bağlan';
$dil['kullanicinin_siteye_erisimi_yasaklanmistir'] = 'Siteye erişiminiz yasaklanmıştır.';
$dil['giris_aktivasyon_yapilmamis'] = 'Hesabınızın aktivasyonu yapılmamış.';
$dil['giris_islemi_basarisiz_oldu_lutfen_tekrar_deneyin'] = 'Giriş işlemi başarısız oldu, lütfen daha sonra tekrar deneyin.';
$dil['eposta_adresinizi_yazin'] = 'ePosta adresi';
$dil['sifre'] = 'Şifre';
$dil['sifrenizi_tekrar_girin'] = 'Şifre tekrar';
$dil['kayit_ol'] = 'Kayıt ol';
$dil['kayit_tamamlanmistir'] = 'Tebrikler, kaydınız tamalanmıştır.';
$dil['kayit_tamamlanmistir_lutfen_hesabinizi_aktiflestirin'] = 'Kayıt tamamlanmıştır, hesabınızı aktifleştirmek için ePosta hesabınıza mail gönderilmiştir. Lütfen gereksiz (spam) klasörünü de kontrol ediniz.';
$dil['aktivasyon_bekleniyor'] = 'Aktivasyon bekleniyor';
$dil['aktivasyon_islemi_basariyla_tamamlanmistir'] = 'Aktivasyon işlemi başarıyla tamamlanmıştır.';
$dil['aktivasyon_islemi_daha_once_basariyla_tamamlanmistir_lutfen_giris_yapin'] = 'Daha önce aktivasyonunuzu tamamlamışsınız, lütfen giriş yapın';
$dil['aktivasyon_islemi_basarisiz_olmustur_bu_kullanicinin_siteye_erisimi_yasaklanmistir'] = 'Aktivasyon işlemi yapılamaz, bu kullanıcının siteye erişimi yasaklanmıştır.';
$dil['aktivasyon_maili'] = 'Aktivasyon maili';
$dil['aktivasyon_kodu'] = 'Aktivasyon kodu:';
$dil['aktivasyon_icin_tiklayin'] = 'Aktivasyon için tıklayın';
$dil['sifremi_unuttum'] = 'Şifremi unuttum'; 
$dil['yeni_sifre_maili'] = 'Yeni şifre';
$dil['yeni_sifre'] = 'Yeni şifre:';
$dil['kayit_boyle_bir_kullanici_bulunamadi'] = 'Böyle bir kullanıcı bulunamadı. Daha önce kayıt yapmamışsınız. Lütfen kayıt olmayı deneyin.';
$dil['kayit_boyle_bir_kullanici_zaten_kayitlidir'] = 'Böyle bir kullanıcı zaten kayıtlıdır, eğer bu hesabın sizin olduğunu düşünüyor ve şifrenizi unuttuysanız lütfen şifremi unuttum tuşuna basınız. Eğer hesap sizin değilse lütfen faklı bilgilerle üye olunuz.';
$dil['kayit_icin_gerekli_bilgileri_hatali_girdiniz'] = 'Girdiğiniz bilgiler kayıt için gerekli standartlara uymuyor. Lütfen bilgileri istenen şekilde giriniz';
$dil['kayit_sifreler_uyusmuyor'] = 'Girdiğiniz şifreler uyuşmuyor. Lütfen tekrar deneyin.';
$dil['kayit_boyle_bir_kullanici_zaten_var'] = 'Böyle bir kullanıcı zaten bulunmaktadır. Ancak girdiğiniz şifre bu kullanıcı ile uyuşmamaktadır. Şifrenizi mi unuttunuz?';


// GNC
$dil['php_temelli_icerik_yonetim_sistemi_ve_framework'] = 'PHP temelli İçerik Yönetim Sistemi ve Framework';

// Yaptıklarım
$dil['sizin_icin_sectiklerim'] = 'Sizin için seçtiğim, bazı çalışmalarım';

// Hakkımda
$dil['karsinizda_ben_baslik'] = 'Karşınızda BEN';
$dil['karsinizda_ben_icerik'] = '	Merhaba öncelikle web siteme hoş geldiniz.</br></br>
									Zaten bu sayfaya kadar geldiyseniz adımı biliyor olmalısınız, evet adım Günce Bektaş :) </br></br>
									Kendini Antalya\'lı hissedenlerdenim. Şuan İzmir\'de oturmakta olup basketbol, koşu, tenis ve çeşitli su sporlarıyla ve bilgisayarla uğraşmayı severim. </br></br>
									Okul hayatıyla ve işle güçle sizleri sıkmak istemem ancak kısaca şunları söylemem yerinde olacaktır. Sistem mühendisiyim ve geçenlerde Gazi Üniversitesinde yüksek lisansımı tamamladım... </br></br>
									Eğer bir web projeniz varsa ve bunu hayata geçirmek isterseniz, öncelikle neler yapabildiğime göz atmanız için yaptıklarım sayfasına göz atın ve ardından benimle iletişime geçin.';
$dil['hedefim_baslik'] = 'Hedefim';
$dil['hedefim_icerik'] = '	"Bilgi"nin 5 harfli bir kelime olduğunu ve bunun beşte dördünün "ilgi" olduğunu düşünen birisiyim dolayısıyla ilgi duyduğum konuların başında gelen web geliştiriciliği konusunda sahip olduğum bilgiyi arttırabilecek para kazanmayı amaçlamayan dünyayı değiştirebilecek ilginç projelerde yer almak en büyük hedeflerimden birisidir. </br></br>
							Bu doğrultuda GNC\'nin hedefi de ilginç projelerin temelini oluşturabilmektir. </br></br>
							Tabi... bu denli bir hedefi tek başına gerçekleştirecek kadar bencil değilim :) Eğlenceli, yetenekli ve zeki ekip arkadaşlarıyla çalışmaktan onur duyarım. Sizinle hedeflerimiz örtüşüyor ve hayattan beklentilerimiz aynı ise "merhaba" demekten çekinmeyin.';
$dil['en_iyiler_baslik'] = 'En iyiler klübü';
$dil['en_iyiler_icerik'] = 'Freelancer.com tarafından 09 Mayıs 2013 tarihinde dünya genelindeki en iyi 10.000 programcı arasında gösterildim.Bu gururu bana yaşatan başta arkadaşlarım olmak üzere, çalıştığım herkese teşekkür ederim...';

$dil['yeteneklerim'] = 'Yeteneklerim';				
$dil['web_gelistiriciligi'] = 'Web geliştiriciliği';

// Blog
$dil['gelistirici_ve_yatirimcilar_icin'] = 'Geliştirici ve yatırımcılar için';
$dil['abone_olun_baslik'] = 'Abone olun';
$dil['abone_olun_icerik'] = 'Önemli olayları kaçırmayın, size ePosta ile ulaşalım';
$dil['ePosta_adresinizi_girin'] = 'ePosta adresinizi girin';

// İletişim
$dil['benim_iletisime_gecin_birlikte_biz_olalim'] = 'Benimle iletişime geçin, birlikte biz olalım';
$dil['formu_doldurun'] = 'Formu doldurun';
$dil['iletisim_aciklama_1'] = 'Aşağıdaki formu doldurarak bana ePosta atabileceğiniz gibi';
$dil['iletisim_aciklama_2'] = 'adresine de ePosta atabilirsiniz veya telefonla iletişime geçebilirsiniz.';
$dil['buraya_tıklayarakta'] = 'buraya tıklayarakta';
$dil['iletisim_adınız_soyadınız'] = 'Adınız ve Soyadınız';
$dil['iletisim_ePosta'] = 'ePosta adresiniz';
$dil['iletisim_mesajınız'] = 'Mesajınız';



