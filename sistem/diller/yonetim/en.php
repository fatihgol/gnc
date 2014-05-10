<?php
if (!defined('gnc'))
	die();

/* 
 * GNC için önemli olan ifadeler
 */ 
// Genel kullanım
$dil['anasayfa'] = 'Home';
$dil['gnc'] = 'GNC';
// Kullanıcı Girişi & Kayıt
$dil['giris'] = 'Giriş';
$dil['kayit'] = 'Kayıt';
$dil['giris_aktivasyon_yapilmamis'] = 'Hesabınız aktif değil.';
$dil['giris_islemi_basarisiz_oldu_lutfen_tekrar_deneyin'] = 'Giriş işlemi başarısız oldu, lütfen daha sonra tekrar deneyin.';
$dil['eposta_adresinizi_yazin'] = 'ePosta adresi';
$dil['sifre'] = 'Şifre';
$dil['sifrenizi_tekrar_girin'] = 'Şifre tekrar';
$dil['kayit_ol'] = 'Kayıt ol';
$dil['kayit_tamamlanmistir'] = 'Tebrikler, kaydınız tamalanmıştır.';
$dil['kayit_tamamlanmistir_lutfen_hesabinizi_aktiflestirin'] = 'Kayıt tamamlanmıştır, hesabınızı aktifleştirmeniz gerekmekte olup aktivasyon için ePosta hesabınıza mail gönderilmiştir.';
$dil['aktivasyon_maili'] = 'Aktivasyon maili';
$dil['aktivasyon_kodu'] = 'Aktivasyon kodu:';
$dil['sifremi_unuttum'] = 'Şifremi unuttum'; 
$dil['yeni_sifre_maili'] = 'Yeni şifre';
$dil['yeni_sifre'] = 'Yeni şifre:';
$dil['kayit_boyle_bir_kullanici_bulunamadi'] = 'Böyle bir kullanıcı bulunamadı. Daha önce kayıt yapmamışsınız. Lütfen kayıt olmayı deneyin.';
$dil['kayit_boyle_bir_kullanici_zaten_kayitlidir'] = 'Böyle bir kullanıcı zaten kayıtlıdır, eğer bu hesabın sizin olduğunu düşünüyor ve şifrenizi unuttuysanız lütfen şifremi unuttum tuşuna basınız. Eğer hesap sizin değilse lütfen faklı bilgilerle üye olunuz.';
$dil['kayit_icin_gerekli_bilgileri_hatali_girdiniz'] = 'Girdiğiniz bilgiler kayıt için gerekli standartlara uymuyor. Lütfen bilgileri istenen şekilde giriniz';
$dil['kayit_sifreler_uyusmuyor'] = 'Girdiğiniz şifreler uyuşmuyor. Lütfen tekrar deneyin.';
$dil['kayit_boyle_bir_kullanici_zaten_var'] = 'Böyle bir kullanıcı zaten bulunmaktadır. Ancak girdiğiniz şifre bu kullanıcı ile uyuşmamaktadır. Şifrenizi mi unuttunuz?';
// Tuşlar
$dil['kaydet'] = 'Kaydet';
$dil['ekle'] = 'Ekle';
$dil['gonder'] = 'Submit';
$dil['iptal'] = 'İptal';
$dil['filtreleyin'] = 'Filtreleyin';
$dil['detaylar'] = 'Detaylar';
$dil['goster'] = 'Göster';
$dil['sil'] = 'Sil';
$dil['yukle'] = 'Yükle';
$dil['indir'] = 'İndir';
$dil['sec'] = 'Seç';
$dil['secim_yapin'] = 'Seçim yapın';
$dil['devamini_oku'] = 'Devamını oku';
$dil['abone_ol'] = 'Abone ol';
// İfadeler
$dil['islemler'] = 'İşlemler';
$dil['tarih'] = 'Tarih';
$dil['siralama'] = 'Sıralama';
$dil['ornek'] = 'Örnek:';
$dil['resim'] = 'Resim';
$dil['eposta'] = 'ePosta';
$dil['islem_yapiliyor'] = 'İşleminiz yapılıyor, lütfen bekleyiniz.';
$dil['yeni_alan'] = 'Yeni alan';
$dil['kime'] = 'Kime';
$dil['kimden'] = 'Kimden';
$dil['konu'] = 'Konu';
$dil['mesaj'] = 'Mesaj';
$dil['aciklama'] = 'Açıklama';
$dil['html_kullanilamaz_bilgi'] = 'HTML ve \', ", { gibi özel karakterler kullanılamaz';
$dil['sayfa_bulunamadi'] = 'Sayfa bulunamadı';
$dil['sonuc_bulunamadi'] = 'Sonuç bulunamadı';
$dil['baska_birseyler_yazin'] = 'Başka birşeyler yazın';
$dil['siteyi_goruntule'] = 'Siteyi görüntüle';
$dil['tarayiciniz_bu_videoyu_desteklemiyot'] = 'Your browser does not support the video tag.';
$dil['cep'] = 'Mobile';
$dil['fax'] = 'Fax';
$dil['eposta'] = 'eMail';

/* Aylar
 * 
 * Tarih gösterimi sırasında İngilizce dışında ay isimlerini göstermek için
 */
$dil['January'] = 'Ocak';
$dil['Jan'] = 'Oca'; 
$dil['February'] = 'Şubat';
$dil['Feb'] = 'Şub';
$dil['March'] = 'Mart';
$dil['Mar'] = 'Mar';
$dil['April'] = 'Nisan';
$dil['Apr'] = 'Nis';
$dil['May'] = 'Mayıs';
$dil['May'] = 'Mayıs';
$dil['June'] = 'Haziran';
$dil['Jun'] = 'Haz';
$dil['July'] = 'Temmuz';
$dil['Jul'] = 'Tem';
$dil['August'] = 'Ağustos';
$dil['Aug'] = 'Ağu';
$dil['September'] = 'Eylül';
$dil['Sep'] = 'Eyl';
$dil['October'] = 'Ekim';
$dil['Oct'] = 'Eki';
$dil['November'] = 'Kasım';
$dil['Nov'] = 'Kas';
$dil['December'] = 'Aralık';
$dil['Dec'] = 'Ara';
/* Günler
 * 
 * Gün gösterimi sırasında İngilizce dışında gün isimlerini göstermek için
 */
$dil['Monday'] = 'Pazartesi';
$dil['Mon'] = 'Ptesi'; 
$dil['Tuesday'] = 'Salı';
$dil['Tue'] = 'Sal';
$dil['Wednesday'] = 'Çarşamba';
$dil['Wed'] = 'Çar';
$dil['Thursday'] = 'Perşembe';
$dil['Thu'] = 'Per';
$dil['Friday'] = 'Cuma';
$dil['Fri'] = 'Cum';
$dil['Saturday'] = 'Cumartesi';
$dil['Sat'] = 'Ctesi';
$dil['Sunday'] = 'Pazar';
$dil['Sun'] = 'Paz';

/* Menu
 * 
 */
$dil['menu']['anasayfa'] 			= 'Anasayfa';
$dil['menu']['yonetim'] 			= 'Admin';
$dil['menu']['ayarlar'] 			= 'Ayarlar';
$dil['menu']['genel'] 				= 'Genel ayarlar';
$dil['menu']['kullanici'] 			= 'Kullanıcılar';
$dil['menu']['menu'] 				= 'Menü ayarları';
$dil['menu']['dil']		 			= 'Dil seçenekleri';
$dil['menu']['moduller'] 			= 'PHP Modülleri';
$dil['menu']['yonlendiriciler'] 	= 'Yönlendiriciler';
$dil['menu']['icerikler'] 			= 'İçerikler';
$dil['menu']['kategoriler'] 		= 'Kategoriler';
$dil['menu']['kategorileri_sirala'] = 'Kategorileri sırala';
$dil['menu']['yeni_kategori'] 		= 'Yeni kategori';
$dil['menu']['icerikler']	 		= 'İçerikler';
$dil['menu']['icerikleri_sirala']	= 'İçerikleri sırala';
$dil['menu']['yeni_icerik'] 		= 'Yeni içerik';
$dil['menu']['sablonlar']	 		= 'Şablonlar';
$dil['menu']['yeni_sablon'] 		= 'Yeni şablon';
$dil['menu']['veriler'] 			= 'Veriler';
$dil['menu']['albumler']	 		= 'Albümler';
$dil['menu']['resimler']	 		= 'Resimler';
$dil['menu']['videolar']	 		= 'Videolar';
$dil['menu']['diger_veriler'] 		= 'Diğer veriler';
$dil['menu']['dosya_yukle'] 		= 'Dosya yükle';

$dil['menu']['mesajlar'] 			= 'Mesajlar';
$dil['menu']['iletisim_formu'] 		= 'İletişim formu';
$dil['menu']['ePosta_gonder'] 		= 'ePosta gönder';
$dil['menu']['istatistikler'] 		= 'İstatistikler';
$dil['menu']['topluluk'] 			= 'Topluluk';
$dil['menu']['forum'] 				= 'Forum';
$dil['menu']['forum_yonetimi'] 		= 'Forum yönetimi';
$dil['menu']['cikis'] 				= 'Exit';

// Menu ayarlarıyla ilgili dil değişkenleri
$dil['menuler'] = 'Menüler';
$dil['menu_secin'] = 'Menü seçin';
$dil['menu_yarat'] = 'Yeni bir menü yarat';
$dil['menu_dil'] = 'Menü dili';
$dil['menu_adi'] = 'Menü adı';
$dil['menu_aciklama'] = 'Menü açıklama';
$dil['menu_elemani_yarat'] = 'Menü elemanı yarat';
// Menü elemanlari
$dil['menu_eleman_adi'] = 'Elemanın adı';
$dil['menu_eleman_href'] = 'Elemanın href degeri';
$dil['menu_eleman_target'] = 'Elemanın target degeri';

/* Arama
 * 
 * Arama sırasında ve sonrasında gösterilecek metinler
 */
$dil['ne_aramak_istiyorsunuz'] = 'Ne aramak istiyorsunuz...';
// Başarı mesajları
$dil['basari'] = 'Başarılı:';
// Hata mesajları
$dil['hata'] = 'Hata:';
$dil['sonuc_bulunamadı'] = 'Her hangi bir sonuç bulunamadı';
$dil['bu_sayfayı_goruntuleme_yetkiniz_yok'] = 'Bu sayfayı görüntüleme yetkiniz yok';

/* Dinamik tablolarda gösterilen metinler
 * 
 * jquery.datatables da kullanılan metin değişkenleri
 * Ayrıntılı bilgi için http://www.datatables.net/ adresine bakabilirsiniz.
 *
 * $dil['sSearch'] = 'Search:';
 * $dil['sLengthMenu'] = 'Display _MENU_ records per page';
 * $dil['sZeroRecords'] = 'Nothing found - sorry';
 * $dil['sInfo'] = 'Showing _START_ to _END_ of _TOTAL_ records';
 * $dil['sInfoEmpty'] = 'Showing 0 to 0 of 0 records';
 * $dil['sInfoFiltered'] = '(filtered from _MAX_ total records)';
 * $dil['sFirst'] = 'First';
 * $dil['sLast'] = 'Last';
 * $dil['sNext'] = 'Next';
 * $dil['sPrevious'] = 'Previous';
 * // Uniform file select
 * $dil['fileDefaultText'] = 'No file selected'; 
 */
$dil['sSearch'] = 'Ara:';
$dil['sLengthMenu'] = 'Her sayfada _MENU_ kayıt göster';
$dil['sZeroRecords'] = 'Üzgünüz, hiç kayıt bulunmuyor';
$dil['sInfo'] = '_TOTAL_ kayıttan _START_ ile _END_ arasındakiler gösteriliyor.';
$dil['sInfoEmpty'] = 'Showing 0 to 0 of 0 records';
$dil['sInfoFiltered'] = '(filtered from _MAX_ total records)';
$dil['sFirst'] = 'İlk';
$dil['sLast'] = 'Son';
$dil['sNext'] = 'Sonraki';
$dil['sPrevious'] = 'Önceki';
// Uniform file select
$dil['fileDefaultText'] = 'Dosya seçin'; 

/* Yönetim
 * 
 * Yönetim sayfasına ait dil değişkenleri
 */
$dil['yonetim'] = 'Yönetim';
$dil['yonetim_sayfasi'] = 'Yönetim sayfası';
$dil['yonetim_hos_geldiniz'] = 'Yönetim sayfasına hoş geldiniz.';
$dil['ne_yaptiginizi_bilmiyorsaniz_degisiklik_yapmayin'] = 'Eğer yaptığınız şeyin ne olduğunu bilmiyorsanız, değişiklik yapmayın.';
// Ayarlar
$dil['ayarlar'] = 'Ayarlar';
$dil['genel_ayarlar'] = 'Genel ayarlar';
$dil['konum_ayarlar'] = 'Konum ayarları';
$dil['iletisim_ayarlar'] = 'İletişim bilgileri';
$dil['meta_ayarlar'] = 'Meta bilgileri';
$dil['kod_ayarlari'] = 'Kod ekleme';
$dil['diger_ayarlar'] = 'Diğer ayarlar';
$dil['menu_ayarlari'] = 'Menü ayarları';
$dil['dil_secenekleri'] = 'Dil seçenekleri';
$dil['php_dosyalari'] = 'Php modülleri';
$dil['yonlendiriciler'] = 'Yönlendiriciler';
// Genel ayarlar
$dil['ayarlar_bilgi'] = 'Bu sayfadan sitenin dinamik ayarlarını düzenleyebilirsiniz, bazı ayarlar sadece kod düzenlemesiyle değiştirilebilmekte olup bu tip ayarlara statik ayarlar denmektedir. Örneğin veritabanı bağlantı ayarları statik bir ayardır.';
$dil['index'] = 'Açılış sayfasının yönlendirme adresi';
$dil['gzip_sikistirma'] = 'Gzip sıkıştırma';
$dil['varsayilan_calisma_dili'] = 'Varsayılan çalışma dili';
$dil['sablon_eleman_sayisi'] = 'Şablonda bulunacak eleman sayısı';
$dil['cache_suresi'] = 'Cache Süresi';
$dil['oturum_omru'] = 'Oturum ömrü';
$dil['oturum_sureniz_doldu'] = 'Oturum süreniz doldu lütfen tekrar giriş yapın';
$dil['cerez_adi'] = 'Çerez ismi';
$dil['kullanici_kaydi'] = 'Kullanıcı kaydı';
// Bölgesel ayarlar
$dil['yerel_zaman_farki'] = 'Yerel zaman farkı';
$dil['yerel_ulke'] = 'Yerel ülke';
$dil['yerel_ulke_kodu'] = 'Yerel ülke kodu';
$dil['tarih_formati'] = 'Tarih formatı';
$dil['saat_formati'] = 'Saat formatı';
// İletişim bilgileri
$dil['iletisim_bilgileri_acik'] = 'İletişim bilgileri gösterilsin';
$dil['iletisim_eposta'] = 'İletişim için kullanılacak ePosta adresi';
$dil['iletisim_bilgileri_telefon'] = 'Telefon';
$dil['iletisim_bilgileri_cep_telefonu'] = 'Cep telefonu';
$dil['iletisim_bilgileri_fax'] = 'Fax';
$dil['iletisim_bilgileri_adres'] = 'Adresi';
// Meta bilgileri
$dil['meta_description'] = 'Sitenin tanıtımı';
$dil['meta_keywords'] = 'Anahtar kelimeler';
$dil['og_url'] = 'OpenGraph url';
$dil['og_title'] = 'OpenGraph title';
$dil['og_description'] = 'OpenGraph site tanıtımı';
$dil['og_image'] = 'OpenGraph resmi';
$dil['favicon'] = 'Favicon';
$dil['apple_icon_72'] = 'Apple ikon 72px';
$dil['apple_icon_114'] = 'Apple ikon 114px';
$dil['apple_icon_144'] = 'Apple ikon 144px';
// Kod ekleme
$dil['header_icine_eklenecek_js_kodlar'] = 'Header içine JS';
$dil['footer_icine_eklenecek_js_kodlar'] = 'Footer içine JS';
$dil['css_kodlari'] = 'CSS kodları';
// Yeni genel ayar ekle
$dil['genel_ayar_ekle'] = 'Genel ayarlara yeni bir ayar daha ekle';
$dil['ayar_adi'] = 'Ayar adı';
$dil['ayar_adi_bilgisi'] = '$ayar global değişkeninin tanımlı olduğu sitenin her yerinden erişilebilecek olan değişkendir.';
$dil['ayar_degeri'] = 'Ayar değeri';
$dil['ayar_aciklama'] = 'Ayar açıkalaması';
// Kullanıcı ayarları
$dil['kullanıcı_listesi'] = 'Kullanıcı listesi';
$dil['kullanıcı_kullanici_adi'] = 'Kullanıcıadı';
$dil['kullanıcı_sifresi'] = 'Kullanıcı şifresi';
$dil['kullanıcı_tipi'] = 'Kullanıcı tipi';
$dil['yetki'] = 'Yetki';
$dil['kullanıcı_grubu'] = 'Kullanıcı grubu';
$dil['kullanici_tipi'][111] = 'Geliştirici';
$dil['kullanici_tipi'][100] = 'Editör';
$dil['kullanici_tipi'][1]   = 'Üye';
$dil['kullanici_tipi'][0]   = 'Herkes';
$dil['gelistirici']   		= 'Geliştici';
$dil['editor']  	  		= 'Editör';
$dil['uye']     	  		= 'Üye';
$dil['herkes']     	  		= 'Herkes';
$dil['kullanıcı_adi'] = 'Kullanıcı adı';
$dil['kullanıcı_soyadi'] = 'Kullanıcı soyadı';
$dil['kullanici_detaylari'] = 'Kullanıcı detayları';
$dil['yeni_kullanici'] = 'Yeni kullanıcı';
// Dil ve diller
$dil['dil'] = 'Dil';
$dil['dil_dosyası_bulunmaktadır'] = 'Dil dosyası bulunmaktadır.';
$dil['dil_dosyası_bulunmamaktadır'] = 'Dil dosyası bulunmamaktadır.';
$dil['sitenin_bu_dilde_gosterilebilmesi_icin_uygun_klasore_dil_dosyasini_yukleyin'] = 'Sitenin bu dilde gosterilebilmesi icin <strong style="color:#000;">/sistem/diller</strong> klasörünün içerisine dil dosyasını yükleyiniz.';
$dil['dil_ekle'] = 'Dil ekle';
$dil['dil_adi'] = 'Dil adı';
$dil['dil_kodu'] = 'Dil kodu';
$dil['dil_dosyasi'] = 'Dil dosyası';
$dil['sitenin_bu_dilde_gosterimi_icin_dil_dosyası_yuklemelisiniz_yinede_bu_dilde_dinamik_olarak_icerik_uretmeniz_mumkun_olacaktir'] = 'Sitenin bu dilde gösterilebilmesi için <strong style="color:#000;">/sistem/diller</strong> klasörüne dil dosyası yüklemelisiniz. Dil dosyası olmadığı durumlarda bu dilde dinamik olarak içerik üretmeniz mümkün olacaktır';
$dil['dil_dosyası_bulunmuyor_sitenin_bu_dilde_calismasi_icin_diller_bolumunden_dil_dosyasi_ekleyebilirsiniz'] = 'Yaratılan içerik isteğe göre bu dilde de gösterilecektir ancak dil dosyası bulunmuyor. Sitenin bu dilde çalışması için diller bölümünden dil dosyası ekleyebilirsiniz.';
// Modüller
$dil['modul_adi'] = 'Modül adı';
$dil['yeni_modul'] = 'Yeni modül';
$dil['modul_izin_durumu'] = 'İzin durumu';
$dil['modul_gorunum_dosyasi'] = 'Görünüm dosyası';
$dil['modul_model_dosyasi'] = 'Model dosyası';
$dil['modul_sql_dosyasi'] = 'SQL dosyası';
// Dosyalar
$dil['dosya_adi'] = 'Dosya adı';
$dil['yeni_dosya'] = 'Yeni dosya';
$dil['dosya_izin_durumu'] = 'İzin durumu';
$dil['dosya_gorunum_dosyasi'] = 'Görünüm dosyası';
$dil['dosya_model_dosyasi'] = 'Model dosyası';
$dil['dosya_sql_dosyasi'] = 'SQL dosyası';
$dil['burada_kastedilen_gorunum_model_klasörlerindeki_php_dosyalarıdır_bu_dosyalar_ilgili_klasorlere_eklendikten_sonra_veritabanınada_kaydedilmelidir'] = 'Burada kastedilen <strong style="color:#000;">/sistem/gorunum</strong> ve <strong style="color:#000;">/sistem/model</strong> klasörlerinde yer alan *.php dosyalarıdır, sitenizin düzgün çalışması için bu dosyaların veritabanına da kaydedilmesi gerekmektedir.';
// Cache
$dil['cache'] = 'Cache';
$dil['dosya_gorunum_cache'] = 'Görünüm\'ün cache değeri';
$dil['dosya_model_cache'] = 'Model\'in cache değeri';
$dil['dosya_header_cache'] = 'Header\'ın cache değeri';
$dil['dosya_footer_cache'] = 'Footer\'ın cache değeri';
$dil['cache_bilgi'] = 'Ayarlarda belirtilen süre ile cacheleme yapmak için 1, cacheleme yapmamak için 0 yazın yada süre belirtmek isterseniz saniye cinsinden belirtebilirsiniz.';
// Yönlendiriciler
$dil['yeni_yonlendirici'] = 'Yeni yönlendirici';
$dil['yeni_yonlendirici_ekle'] = 'Yeni yönlendirici ekle';
$dil['yeni_yonlendirici_ekleme_bilgisi'] = 'Aynı içeriğe birden çok yönlendirici vermeniz mümkündür ancak bir sayfa için aynı dilde, birden çok yönlendirici yaratmanız arama motorları tarafından spam içerik olarak algılanabilir, bu özelliği sık kullanmak sitenizin arama motorlarındaki sıralaması için zarar verebilir.';
$dil['yonlendirici_adi'] = 'Yönlendirici adı';
// İçerik & Kategoriler
$dil['icerik'] = 'İçerik';
$dil['icerikler'] = 'İçerikler';
$dil['yeni_icerik'] = 'Yeni içerik';
$dil['benzer_icerikler'] = 'Benzer içerikler';
$dil['kategoriler'] = 'Kategoriler';
$dil['yeni_kategori'] = 'Yeni kategori';
$dil['kategori_detaylari'] = 'Kategori detaylari';
$dil['icerikler_bilgi'] = 'Bu bölüm sayesinde siteye dinamik olarak haber, blog vb... içerik ekleyebilir, eklediğiniz bu içerikleri düzenleyebilir veya silebilirsiniz. Öncelikle çeşitli kategoriler yaratmalı ve içerikleri bu kategorilere göre yaratmalısınız.';
// Yeni kategori
$dil['kategori_adi'] = 'Kategori adı';
$dil['ust_kategorinin_adi'] = 'Üst kategorinin adı';
$dil['kategori_secin'] = 'Kategori seçin';
$dil['ana_kategori'] = 'Ana kategori (Üst kategorisi bulunmuyor)';
// Yeni içerik
$dil['icerik_basligi'] = 'Başlık';
$dil['icerik_metni'] = 'Metin';
$dil['icerik_ozeti'] = 'Özeti';
$dil['icerik_ozet_bilgisi'] = 'Site içeriğinin 100-200 karakterle gösterilecek olan özeti';
$dil['kategori'] = 'Kategori';
$dil['kategori_secin'] = 'Kategori seçin';
$dil['dil_secin'] = 'Dil seçin';
$dil['dil_secimi_bilgi'] = 'İçeriğin dilini seçtikten sonra bu dile ait kategoriler aşağıda listelenecektir.';
$dil['sablon_secin'] = 'Şablon seçin';
$dil['sablon_secimi_bilgi'] = 'İsteğe bağlı olarak içeriğinizi daha önceden belirttiğiniz şablona uygun olarak özelleştirmek için kullanabilirsiniz.';
$dil['icerik_resim_bilgi'] = 'İçeriği belirtecek bir resim yükleyiniz, içeriğin özeti ile beraber gösterilecek olduğundan dolayı güzel bir resim seçmeniz önerilir.';
$dil['icerik_anahtar_kelimeler'] = 'Anahtar kelimeler';
// Blog
$dil['en_son_yazilanlar'] = 'En son yazılanlar';
$dil['tarihe_gore_yazilar'] = 'Tarihe göre yazılar';
// Şablonlar
$dil['sablonlar'] = 'Şablonlar';
$dil['yeni_sablon'] = 'Yeni şablon';
$dil['sablon_adi'] = 'Şablon adı';
$dil['sablon_degeri'] = 'Şablon değeri';
$dil['sablon_aciklama'] = 'Şablon açıklaması';
$dil['alan_adi'] = 'Alan adı';
$dil['alan_aciklamasi'] = 'Alan açıklaması';
$dil['alan_tipi'] = 'Alan tipi'; 
$dil['sablona_alan_adi_elemani_ekleme_bilgisi'] = 'Şablon oluştururken aşağıdaki form ile dinamik şekilde bu şablona elemanlar ekleyebilirsiniz. Bu sayede yaratacağınız içeriklerde seçeceğiniz şablonların elemanlarını istediğiniz gibi belirtebilirsiniz.';
$dil['sablonlar_bilgi'] = 'Şablonlar içerikleri kişiselleştirmeniz içim önemli bir adımdır, şablonları içeriklerinizle ilişkilendirebilirsiniz. Örnek vermek gerekirse; bu sayede girilen içeriği bir ürüne dönüştürebilir. Ürünün en, boy, fiyat vb. bilgilerini şablon değeri olarak atayabilirsiniz.';
// Veritabanında yer alan diğer bilgiler, sık kullanılan uygulamalar için kıta,ülke,şehir,üniversite verileri vs.
$dil['veritabani_diger_veriler'] = 'Veritabanında yer alan diğer veriler';
$dil['veritabani_diger_veriler_bilgi'] = 'Veritabanında yer alan ve çeşitli uygulamarda sıklıkla kullanılan kıta,ülke,şehir,üniversite gibi veriler.';
// Kıtalar
$dil['kitalar'] = 'Kıtalar';
$dil['kita_secin'] = 'Kıta seçin';
$dil['Avrupa'] = 'Avrupa';
$dil['Asya'] = 'Asya';
$dil['Afrika'] = 'Afrika';
$dil['Avustralya '] = 'Avustralya ';
$dil['KuzeyAmerika'] = 'Kuzey Amerika';
$dil['GüneyAmerika'] = 'Güney Amerika';
$dil['Antartika'] = 'Antartika';
// Ülkeler
$dil['ulkeler'] = 'Ülkeler';
$dil['yeni_ulke'] = 'Yeni ülke';
$dil['ulke_secin'] = 'Ülke seçin';
$dil['ulke_adi'] = 'Ülke adı';
// İller
$dil['iller'] = 'İller';
$dil['yeni_il'] = 'Yeni il';
$dil['il_secin'] = 'İl seçin';
$dil['il_kodu'] = 'İl kodu';
$dil['il_adi'] = 'İl adı';
// Üniversiteler
$dil['universiteler'] = 'Üniversiteler';
$dil['yeni_universite'] = 'Yeni üniversite';
$dil['universite_secin'] = 'Üniversite seçin';
$dil['universite_adi'] = 'Üniversite adı';
$dil['universite_kuruluş_tarihi'] = 'Kuruluş tarihi';
$dil['universite_eposta_adresi'] = 'Üniversitenin eposta uzantısı';
// Resim & Video & Dosyalar
$dil['veriler'] = 'Veriler';
$dil['dosyalar'] = 'Dosyalar';
$dil['resimler'] = 'Resimler';
$dil['videolar'] = 'Videolar';
$dil['dosya'] = 'Dosya';
$dil['resim'] = 'Resim';
$dil['resim_harici'] = 'Harici resim';
$dil['video'] = 'Video';
$dil['video_harici'] = 'Harici video';
$dil['yeni_dosya'] = 'Yeni dosya';
$dil['yeni_resim'] = 'Yeni resim';
$dil['yeni_video'] = 'Yeni video';
$dil['dosya_sec'] = 'Dosya sec';
$dil['dosya_tipi'] = 'Dosya tipi';
$dil['dosya_yukleme_bilgi'] = 'Web sitenizde kullanacağınız tüm resim, video, dosya vb. verileri bu form ile yükleyebilir daha sonra bunları veriler tablosundan veri_id değeriyle istediğiniz yerde çağırabilirsiniz. Ayırıca bu verileri albümler içerisine gruplandırarak daha sonra albüm, slide, carousel olarak istediğiniz yerde kullanabilirsiniz.';
$dil['dosya_tipi_bilgi'] = 'Dosya tipinin seçimi ile birlikte alt tarafa gelecek olan form ile bazı ayarları kişiselleştirmeniz mümkündür. Değişiklik yapmadığınız durumlarda ayarlar da kayıtlı olan değerler kullanılacaktır.';
$dil['dosya_orjinal_boyut_bilgi'] = 'Yüklenecek resmin orjinal en boy değerini değiştirmek istiyorsanız, bu alanları doldurun.';
$dil['dosya_thumb_boyut_bilgi'] = 'Yüklenecek resimden oluşturulacak küçük resim (thumbnail)\'ın ebatlarını ayarlar bölümünden farklı olarak belirtmek istiyorsanız aşağıdaki bölüme istediğiniz değerleri girin. <br> Mevcut durumda '.$ayar['thumb_eni'].'x'.$ayar['thumb_boyu'].' şeklinde oluşturulacaktır.';
$dil['harici_dosya_yukleme_aciklamasi'] = 'Harici dosyaları yüklemek için tam url adresini aşağıdaki alana yazın';
$dil['url_adresi'] = 'URL adresi';
$dil['eklenecek_dosyayi_secin'] = 'Eklenecek dosya veya dosyalari secin';
$dil['dosya_basariyla_yuklenmistir'] = 'Dosya başarıyla yüklenmiştir.';
// Albümler
$dil['albumler'] = 'Albümler';
$dil['album'] = 'Albüm';
$dil['yeni_album'] = 'Yeni Albüm';
$dil['album_sec'] = 'Albüm seçin';
$dil['dosya_yukleme_sirasinda_album_secimi_bilgi'] = 'Yüklemek istediğiniz resim albüme uygun olarak boyutlandırılacağı için, lütfen yükleme işlemini yapmadan önce bir albüm seçin';
$dil['albume_ekle'] = 'Albüme ekle';
$dil['eklemek_istediginiz_resmi_secin'] = 'Albüme eklemek istediğiniz resmi seçin, açılan resimden albüme uygun olarak resmi kırpın ve kaydet tuşuna basın';
$dil['albumden_cikart'] = 'Albümden çıkart';
$dil['albume_secin'] = 'Albüm seçin';
$dil['album_adi'] = 'Albüm adı';
$dil['album_aciklama'] = 'Albüm açıklama';
$dil['album_thumb_en'] = 'Resimlerin thumb eni';
$dil['album_thumb_boy'] = 'Resimlerin thumb boyu';
$dil['album_crop_en'] = 'Kırpılacak resmin eni';
$dil['album_crop_boy'] = 'Kırpılacak resmin boyu';
// Resimler
$dil['eni'] = 'Eni';
$dil['boyu'] = 'Boyu';
$dil['thumbin_boyutlari'] = 'Küçük resim boyutları';
$dil['cropun_boyutlari'] = 'Kesilecek resmin boyutları';
$dil['thumb_eni'] = 'Thumb\'ın eni';
$dil['thumb_boyu'] = 'Thumb\'ın boyu';
$dil['resmi_kirp'] = 'Resmi kırp';
$dil['resim_aciklama_bilgi'] = 'Resmin title vs. değerinde kullanılmak üzere resmi açıklayan bir ifade yazın, arama motorları için önemlidir.';
$dil['resim_basariyla_kesilmistir'] = 'Resim başarıyla kesilmiştir. Yeni halinin yüklendiği konum: ';
// Slide'lar
$dil['slidelar'] = 'Slide\'lar';
$dil['slide'] = 'Slide';
$dil['yeni_slide'] = 'Yeni slide';
$dil['slide_secin'] = 'Slide seçin';
// İletişim formu
$dil['iletisim_formundan_gelen_mesajlar'] = 'İletişim formundan gelen mesajlar';
$dil['iletisim_adi'] = 'Kişinin ismi';
// ePosta 
$dil['ePosta_gonder'] = 'Yeni ePosta gönder';
$dil['gonderilecek_listeyi_secin'] = 'Gönderilecek listeyi seçin';
$dil['Özel'] = 'Özel';
$dil['Herkese'] = 'Herkese';
$dil['Kullanıcılara'] = 'Kullanıcılara';
$dil['Abonelere'] = 'Abonelere';
$dil['ozel_olarak_eposta_gondermek_istediginiz_kisilerin_eposta_adreslerini_yazin'] = 'Özel olarak ePosta göndermek istediğinizi kişilerin ePosta adreslerini aralarında , olacak şekilde buraya yazın.';

// Sistemin ana geliştiricisinin ismi
$dil['ana_gelistirici'] = '<strong>Günce Ali Bektaş</strong>, <small>Ana geliştirici</small>';
