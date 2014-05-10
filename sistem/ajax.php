<?php
if (!defined('gnc'))
	die();

if (function_exists($adres['fonk']))
	$adres['fonk']();

/* AJAX ile dosya yükleme
 *
 * Dosya seç tuşuna basıldığında seçili dosyayı otomatik olarak upload sınıfındaki kurallara uygun olarak sunucuya yükleyen fonksiyon,
 * Özellikle içerik ekleme sırasında kullanılması için düşünülmüştür. 
 * 
 * Crop ile kullanıma uygundur, dolayısıyla hem resmi anında yükleyip hepte istenen ebatlara uygun olarak kırpmak mümkündür.
 */
function gnc_dosya_yukle(){
	global $dil, $site, $vt;
	
	// Tek dosya yüklemek için sadece son yüklenen resmi seçmek gerekir, bundan dolayı i değişkeni ile kontrol yapalım
	$i = 1;
	foreach ($_FILES["images"]["error"] as $key => $error) {
		if (count($_FILES["images"]["error"]) == $i)
		{
			$handle = new Upload($_FILES["images"]["tmp_name"][$key]);
			// Geçici yükleme işlemi tamamlandı mı kontrol edelim, dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
			if ($handle->uploaded) { 
				// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
				if ($handle->file_is_image)
					$dir_dest = $site['resim_yuklenecek_adres'];
				else
					$dir_dest = $site['dosya_yuklenecek_adres'];	
				$handle->Process($dir_dest);
			
				$vt->query("INSERT INTO gnc_veriler
							(veri_adi, veri_yolu, veri_tipi, veri_aciklama, veri_tarih)
						VALUES
							('{$handle->file_dst_name}', '{$handle->file_dst_name}', '1', '{$handle->file_dst_name}', '{$site['bugun']}')");
				$veri_id = $vt->insert_id();
				
			}	    
		}
		$i++;
	}
	echo '<input type="hidden" value="'.$veri_id.'" name="yuklenen_resim_id" id="yuklenen_resim_id">';
	echo '<p>'.$dil['dosya_basariyla_yuklenmistir'].'</p>';
}
function gnc_dosya_yukle_2(){
	global $dil, $site, $vt;
	
	// Tek dosya yüklemek için sadece son yüklenen resmi seçmek gerekir, bundan dolayı i değişkeni ile kontrol yapalım
	$i = 1;
	foreach ($_FILES["images_2"]["error"] as $key => $error) {
		if (count($_FILES["images_2"]["error"]) == $i)
		{
			$handle = new Upload($_FILES["images_2"]["tmp_name"][$key]);
			// Geçici yükleme işlemi tamamlandı mı kontrol edelim, dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
			if ($handle->uploaded) { 
				// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
				if ($handle->file_is_image)
					$dir_dest = $site['resim_yuklenecek_adres'];
				else
					$dir_dest = $site['dosya_yuklenecek_adres'];	
				
				$handle->Process($dir_dest);
				
				$vt->query("INSERT INTO gnc_veriler
							(veri_adi, veri_yolu, veri_tipi, veri_aciklama, veri_tarih)
						VALUES
							('{$handle->file_dst_name}', '{$handle->file_dst_name}', '1', '{$handle->file_dst_name}', '{$site['bugun']}')");
				$veri_id = $vt->insert_id();
			}	    
		}
		$i++;
	}
	echo '<input type="hidden" value="'.$veri_id.'" name="yuklenen_resim_id_2" id="yuklenen_resim_id_2">';
	echo '<p>'.$dil['dosya_basariyla_yuklenmistir'].'</p>';
}
/* Arama motoruna girilen değere göre arama yaparak sonuçları döndüren fonksiyon 
 * 
 * Yönetim panelinde sadece kullanıcı isimlerini, ve içerikleri cevap olarak döndürmektedir. Farklı sorgular ile arama metodu genişletilebilir.
 */
function gnc_yonetim_arama_sonuclarini_goster(){
	global $dil, $site, $vt;
	
	$aranan = guvenlik($_POST['aranan']);
	echo '  <span class="arrow"></span>
            <ul class="updates">';
    
	// İçerikler
	$sorgu_icerikler = $vt->query("SELECT * FROM gnc_icerikler
                      	 		   WHERE icerik_baslik LIKE '%$aranan%'"); 
  	$say_icerikler = $vt->num_rows($sorgu_icerikler);
	// Kullanıcılar
	$sorgu_kullanicilar = $vt->query("SELECT * FROM gnc_kullanicilar
								   	  WHERE kullanici_kullanici_adi LIKE '%$aranan%'");
	$say_kullanicilar = $vt->num_rows($sorgu_kullanicilar);
	
	
	if ($say_icerikler != 0 || $say_kullanicilar != 0){
		// İçerik sonuçları
		while ($sonuc = $vt->fetch_array($sorgu_icerikler)){
			echo '<li>
	              	<span class="uDone">
	                	<a href="'.$site['url'].'yonetim/icerikler/icerik/'.$sonuc['icerik_sef'].'" title="">'.$sonuc['icerik_baslik'].'</a>
	                    <span>'.$sonuc['icerik_ozet'].'</span>
	                </span>
	                <span class="uDate"><span>'.gnc_gun($sonuc['icerik_tarih']).'</span>'.gnc_ay($sonuc['icerik_tarih'], 'kisa').'</span>
	                <span class="clear"></span>
	              </li>';
		}	
		// Kullanıcı sonuçları
		while ($sonuc = $vt->fetch_array($sorgu_kullanicilar)){
			echo '<li>
	              	<span class="uDone sonuc_bulunamadi">
	                	<a href="'.$site['url'].'yonetim/icerikler/icerik/'.$sonuc['kullanici_id'].'" title="">'.$sonuc['kullanici_kullanici_adi'].'</a>
	                    <span>'.$sonuc['kullanici_adi'].' '.$sonuc['kullanici_soyadi'].'</span>
	                </span>
	                
	              </li>';
		}	
	}
	else {
		echo '<li>
              	<span class="uAlert sonuc_bulunamadi">
                	<a href="javascript:void(0)" title="">'.$dil['sonuc_bulunamadi'].'</a>
                    <span>'.$dil['baska_birseyler_yazin'].'</span>
                </span>
              </li>';
	}
		/*
	echo '      <li>
                    <span class="uDone">
                        <a href="#" title="">A new server is on the board!</a>
                        <span>We\'ve just set up a new server. Our gurus ...</span>
                    </span>
                    <span class="uDate"><span>24</span>may</span>
                    <span class="clear"></span>
                </li>          
                <li>
                    <span class="uAlert">
                        <a href="#" title="">[ URGENT ] ex.ua was closed by government</a>
                        <span>But already everything was solved. It will ...</span>
                    </span>
                    <span class="uDate"><span>25</span>may</span>
                    <span class="clear"></span>
                </li>
                <li>
                    <span class="uNotice">
                        <a href="#" title="">Meat a new team member - Don Corleone</a>
                        <span>Very dyplomatic and flexible sales manager</span>
                    </span>
                    <span class="uDate"><span>02</span>jun</span>
                    <span class="clear"></span>
                </li>';
	*/
	echo '  </ul>';
}
function gnc_yonetim_ayar_sil()
{
	global $vt, $adres;
	
	if (gnc_yetki(111))
	{
		$ayar_id = guvenlik($_POST['veri_id']);
		
		// id'si gelen dilin dil_kodu'nu al ve dil dosyasını sil
		$vt->query("DELETE FROM gnc_ayarlar
					WHERE ayar_id = '$ayar_id'");
	}
	die();
}
function gnc_yonetim_kullanici_detaylari(){
	global $adres, $dil, $site, $vt;

	include('model/yonetim/gnc.php');
	$sonuclar = gnc_model_kullanicilar(guvenlik($_POST['id']));
	
	foreach($sonuclar AS $sonuc){
		echo '	<form method="POST" action="'.$site['url'].'yonetim/ayarlar/kullanici" class="gnc_ajax_form">	
					<fieldset>
					    <!-- Detayları gösterilen kullanıcının id değeri -->
	                    <input type="hidden" name="kullanici_id" value="'.$sonuc['kullanici_id'].'" /></div>
	                    <table>
							<tr>
								<td style="width:200px;">'. $dil['eposta_adresinizi_yazin']. '/'. $dil['kullanıcı_adi']. '</td>
								<td><input type="text" name="kullanici_kullanici_adi" value="'. $sonuc['kullanici_kullanici_adi'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['sifre']. '</td>
								<td><input type="password" name="kullanici_sifre1" value="'. $sonuc['kullanici_sifre'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['sifre']. '</td>
								<td><input type="password" name="kullanici_sifre2" value="'. $sonuc['kullanici_sifre'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['kullanıcı_tipi']. '</td>
								<td>
									<select data-placeholder="'.$dil['kullanıcı_tipi'].'" name="kullanici_tipi" class="select" style="width:100%;" tabindex="2">
										<option value="'.$sonuc['kullanici_tipi'].'">'.$dil['kullanici_tipi'][$sonuc['kullanici_tipi']].' ('.$dil['yetki'].':'.$sonuc['kullanici_tipi'].')</option>';
				                        $tipler = gnc_model_kullanici_tipleri();
										foreach ($tipler AS $tip)
				                        	echo '<option value="'.$tip['kullanici_tip_yetki'].'">'.$dil[$tip['kullanici_tip_adi']].' ('.$dil['yetki'].':'.$tip['kullanici_tip_yetki'].')</option>';
									echo '    
				                    </select>
				                </td>
			                </tr>
			                <tr>
								<td style="width:200px;">'. $dil['kullanıcı_aktif']. '</td>
								<td>
									<select data-placeholder="'.$dil['kullanıcı_aktif'].'" name="kullanici_aktif" class="select" style="width:100%;" tabindex="2">';
				                        if ($sonuc['kullanici_aktif'] == 1)
											echo '<option value="1">'.$dil['aktif'].'</option>
												  <option value="0">'.$dil['pasif'].'</option>';
										elseif ($sonuc['kullanici_aktif'] == 0)
											echo '<option value="0">'.$dil['pasif'].'</option>
												  <option value="1">'.$dil['aktif'].'</option>';
										else
											echo '<option value="'.$sonuc['kullanici_aktif'].'">'.$dil['aktivasyon_bekleniyor'].'</option>
												  <option value="0">'.$dil['pasif'].'</option>
												  <option value="1">'.$dil['aktif'].'</option>';
									echo '    
				                    </select>
				                </td>
			                </tr>
			                <tr>
								<td style="width:200px;">'. $dil['kullanıcı_grubu']. '</td>
								<td>
									<select data-placeholder="'.$dil['kullanıcı_grubu'].'" name="kullanici_grubu" class="select" style="width:100%;" tabindex="2">';
										$gruplar = gnc_model_kullanici_gruplari();
										foreach ($gruplar AS $grup)
				                        	echo '<option value="'.$grup['kullanici_grup_id'].'">'.$grup['kullanici_grup_adi'].'</option>';
									echo '    
				                    </select>
				                </td>
			                </tr>
			                <tr>
								<td style="width:200px;">'. $dil['kullanıcı_adi']. '</td>
								<td><input type="text" name="kullanici_adi" value="'. $sonuc['kullanici_adi'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['kullanıcı_soyadi']. '</td>
								<td><input type="text" name="kullanici_soyadi" value="'. $sonuc['kullanici_soyadi'] .'"/></td>
							</tr>
						</table>
		            </fieldset>
		        	<div>
		            	<!--<input class="buttonS bRed grid2" type="reset" value="'.$dil['iptal'].'">-->
                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
                    	<div class="clear"></div>
                    </div>
		        </form>';
	}
}
function gnc_yonetim_kullanici_sil(){
	global $vt;
	
	if (gnc_yetki(111))
	{
		$kullanici_id = guvenlik($_POST['veri_id']);
		
		$sorgu = $vt->query("DELETE FROM gnc_kullanicilar
							 WHERE kullanici_id = '$kullanici_id'");
	}
}

function gnc_yonetim_yonlendirici_yeni_yonlendirici_ekleme_penceresi(){
	global $adres,$dil, $site, $vt;
	
	include('model/yonetim/gnc.php');
	$dosya_id = guvenlik($_POST['id']);
	
	echo '  <form>
				<table>
					<tr>
						<td style="width:200px;">'. $dil['dosya_adi']. '</td>';
						
						$sonuclar = gnc_model_moduller($dosya_id);
						foreach ($sonuclar AS $sonuc)
						echo '<td><input type="text" id="yonlendirici_dosya_id" value="'. $sonuc['dosya_id'] .'" style="display:none;" />'. $sonuc['dosya_adi'] .'</td>';
						
						echo '
					</tr>
					<tr>
						<td>'. $dil['yonlendirici_adi']. '</td>
						<td><input type="text" id="yonlendirici_yonlendirici_sef" style="width: 97%;"/></td>
					</tr>
					<tr>
						<td>'.$dil['dil'].'</td>
						<td><select data-placeholder="'.$dil['dil_secin'].'" class="select" id="yonlendirici_dil_id" style="width:350px;" tabindex="2">
			                    <option value=""></option>'; 
								$sonuclar = gnc_model_diller();
								foreach ($sonuclar AS $sonuc)
			                    	echo '<option value="'.$sonuc['dil_id'].'">'.$sonuc['dil_adi'].'</option>'; 
			                echo '    
			                </select>
			            </td>
					</tr>					
					
				</table>
				<br>
				<a class="buttonM bBlue formSubmit" onClick="gnc_yonetim_yeni_yonlendirici_ekle()" style="margin-right:25px;">'. $dil['kaydet'] .'</a>
				<br>
			</form>
			<div class="divider"><span></span></div>';
	echo '<p><small>'. $dil['yeni_yonlendirici_ekleme_bilgisi'] .'</small></p>';	
}
function gnc_yonetim_yonlendirici_yeni_yonlendirici_ekle(){
	global $vt, $adres;
	
	$dosya_id = guvenlik($_POST['dosya']);
	$yonlendirici_sef = guvenlik($_POST['yonlendirici']);
	$dil_id = guvenlik($_POST['dil']);
	

	$sorgu = $vt->query("INSERT INTO gnc_yonlendiriciler
							(dosya_id, yonlendirici_sef, dil_id)
						VALUES
							('$dosya_id','$yonlendirici_sef','$dil_id')");
}
function gnc_yonetim_yonlendirici_sil(){
	global $vt, $adres;
	
	if (gnc_yetki(111))
	{
		$yonlendirici_id = guvenlik($_POST['veri_id']);
		
		$sorgu = $vt->query("DELETE FROM gnc_yonlendiriciler
							 WHERE yonlendirici_id = '$yonlendirici_id'");
	}
	die();
}
function gnc_yonetim_dil_sil()
{
	global $vt, $adres;
	
	if (gnc_yetki(111))
	{
		$dil_id = guvenlik($_POST['veri_id']);
		
		// id'si gelen dilin dil_kodu'nu al ve dil dosyasını sil
		$sorgu = $vt->query("SELECT * FROM gnc_diller
							WHERE dil_id = '$dil_id'");
		$sonuc = $vt->fetch_array($sorgu);					
		unlink('sistem/diller/'.$sonuc['dil_kodu'].'.php');
		
		// veriyi veri tabanından sil						
		$vt->query("DELETE FROM gnc_diller
					WHERE dil_id = '$dil_id'");	
	}
}
function gnc_yonetim_modul_detaylari(){
	global $adres, $dil, $site, $vt;

	include('model/yonetim/gnc.php');
	$sonuclar = gnc_model_moduller(guvenlik($_POST['id']));
	
	foreach($sonuclar AS $sonuc){
		echo '	<form method="POST" action="'.$site['url'].'yonetim/ayarlar/moduller" class="gnc_ajax_form">	
					<fieldset>
						<p class="note" style="white-space: pre-wrap;">'.$dil['cache_bilgi'].'</p>
					    <!-- Detayları gösterilen kullanıcının id değeri -->
	                    <input type="hidden" name="dosya_id" value="'.$sonuc['dosya_id'].'" /></div>
	                    <table>
							<tr>
								<td style="width:200px;">'. $dil['dosya_gorunum_cache']. '</td>
								<td><input type="text" name="dosya_gorunum_cache" value="'. $sonuc['dosya_gorunum_cache'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['dosya_model_cache']. '</td>
								<td><input type="text" name="dosya_model_cache" value="'. $sonuc['dosya_model_cache'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['dosya_header_cache']. '</td>
								<td><input type="text" name="dosya_header_cache" value="'. $sonuc['dosya_header_cache'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['dosya_footer_cache']. '</td>
								<td><input type="text" name="dosya_footer_cache" value="'. $sonuc['dosya_footer_cache'] .'"/></td>
							</tr>
						</table>
		            </fieldset>
		        	<div>
		            	<!--<input class="buttonS bRed grid2" type="reset" value="'.$dil['iptal'].'">-->
                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
                    	<div class="clear"></div>
                    </div>
		        </form>';
	}
}
function gnc_yonetim_modul_durumunu_degistir()
{
	global $vt;
	
	if (gnc_yetki(111))
	{
		$modul_id = guvenlik($_POST['veri_id']);
		
		// Id'si gelen modülün durumunu al			
		$sorgu = $vt->query("SELECT dosya_yayin_durumu FROM gnc_moduller
							 WHERE dosya_id = '$modul_id'");	
		$sonuc = $vt->fetch_array($sorgu);
		
		if ($sonuc['dosya_yayin_durumu'] == 0)
			$dosya_yayin_durumu = 1;
		else
			$dosya_yayin_durumu = 0;
		
		// Id'si gelen modülün yayın durumunu değiştir
		$vt->query("UPDATE gnc_moduller SET
						dosya_yayin_durumu = '$dosya_yayin_durumu'
					WHERE dosya_id = '$modul_id'");
	}		
}
function gnc_yonetim_modul_sil()
{
	global $vt;
	
	if (gnc_yetki(111))
	{
		$modul_id = guvenlik($_POST['veri_id']);
		
		// veriyi veritabanından sil						
		$vt->query("DELETE FROM gnc_moduller
					WHERE dosya_id = '$modul_id'");	
					
		// modül silindiğine göre bu modülün yönlendiricilerinin silinmesi yerinde olacaktır, kalıcı hasarlar verilmesini önlemek için dosyaları otomatik olarak silmiyoruz.
		$vt->query("DELETE FROM gnc_yonlendiriciler
					WHERE dosya_id = '$modul_id'");	
	}	
}
function gnc_yonetim_icerik_sil(){
	global $vt, $adres;
	
	if (gnc_yetki(111))
	{
		$icerik_id = guvenlik($_POST['veri_id']);
		
		$sorgu = $vt->query("DELETE FROM gnc_icerikler
							 WHERE icerik_id = '$icerik_id'");
		$sorgu = $vt->query("DELETE FROM gnc_iceriklerin_benzer_icerikleri
							 WHERE icerik_id = '$icerik_id' OR benzer_icerik_id = '$icerik_id'");
		$sorgu = $vt->query("DELETE FROM gnc_iceriklerin_kategorileri
							 WHERE icerik_id = '$icerik_id'");
	}
	die();
}
function gnc_yonetim_serialize_menu(){
	global $vt;
	
	//print_r($_POST['list']);
	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$indis = array_keys($_POST['list']);
		$deger = array_values($_POST['list']);
		if ($deger[$i] == 'null')
			$deger[$i] = 0;	
			
		$vt->query("UPDATE gnc_menulerin_elemanlari SET 
						menu_eleman_id_ust = '{$deger[$i]}',
						menu_eleman_sira = '{$i}'
					WHERE menu_eleman_id = '{$indis[$i]}' LIMIT 1");
		//echo 'kategori_id:'. $indis[$i] .'- ust_kategori:'. $deger[$i] .' - sira:' .$i.'<br>';
	}
	
}
function gnc_yonetim_serialize_kategori(){
	global $vt;
	
	//print_r($_POST['list']);
	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$indis = array_keys($_POST['list']);
		$deger = array_values($_POST['list']);
		if ($deger[$i] == 'null')
			$deger[$i] = 0;	
			
		$vt->query("UPDATE gnc_kategoriler SET 
						kategori_id_ust = '{$deger[$i]}',
						kategori_sira = '{$i}'
					WHERE kategori_id = '{$indis[$i]}' LIMIT 1");
		//echo 'kategori_id:'. $indis[$i] .'- ust_kategori:'. $deger[$i] .' - sira:' .$i.'<br>';
	}
	
}
function gnc_yonetim_menu_elemani_sil(){
	global $vt;
	
	if (gnc_yetki(111))
	{
		$silinecek_eleman_id = guvenlik($_POST['veri_id']);
		
		$sorgu = $vt->query("SELECT * FROM gnc_menulerin_elemanlari WHERE menu_eleman_id = '$silinecek_eleman_id' LIMIT 1");
		$sonuc = $vt->fetch_array($sonuc);
		$silinecek_elemanin_ust_idsi = $sonuc['menu_eleman_id_ust'];
		/*  Silinecek elemanın üst id'sini elemanın içindeki elemanların üst id'si yapalım
		 * 
		 *	$sonuc['menu_eleman_id_ust'] // Silinecek elemanın üst id'si, bu elemanın altındaki elemanların konacağı yeri belirttiği için ciddi önem arz etmektedir.
		 */
		$sorgu = $vt->query("SELECT * FROM gnc_menulerin_elemanlari WHERE menu_eleman_id_ust = '$silinecek_elemanin_ust_idsi'");
		if ($sorgu){
			while ($sonuc = $vt->fetch_array($sorgu)){
				$vt->query("UPDATE gnc_menulerin_elemanlari 
							SET menu_eleman_id_ust = '$silinecek_elemanin_ust_idsi' 
							WHERE menu_eleman_id_ust = '$silinecek_eleman_id'");
			}
		}
		
		// Son olarak silmek istediğimiz elemanı silelim
		$vt->query("DELETE FROM gnc_menulerin_elemanlari
				    WHERE menu_eleman_id = '$silinecek_eleman_id'");
	}	
}
function gnc_yonetim_kategori_detaylari(){
	global $adres, $dil, $site, $vt;

	include('model/yonetim/gnc.php');
	$sonuclar = gnc_model_kategori(guvenlik($_POST['id']));
	
	foreach($sonuclar AS $sonuc){
		echo '	<form method="POST" action="'.$site['url'].'yonetim/ayarlar/kategoriler" class="gnc_ajax_form">	
					<fieldset>
					    <!-- Detayları gösterilen kategorinin id değeri -->
	                    <input type="hidden" name="kategori_id" value="'.$sonuc['kategori_id'].'" /></div>
	                    <table>
							<tr>
								<td style="width:200px;">'. $dil['kategori_adi']. '</td>
								<td><input type="text" name="kategori_adi" value="'. $sonuc['kategori_adi'] .'"/></td>
							</tr>
							<tr>
								<td style="width:200px;">'. $dil['dil']. '</td>
								<td>
									<select data-placeholder="'.$dil['dil'].'" name="kategori_dil" class="select" style="width:100%;" tabindex="2">';
				                        $diller = gnc_model_diller();
										foreach ($diller AS $kategori_dil)
				                        	echo '<option value="'.$kategori_dil['dil_id'].'">'.$kategori_dil['dil_adi'].'</option>';
									echo '    
				                    </select>
				                </td>
			                </tr>
			                <tr>
								<td style="width:200px;">'. $dil['kullanıcı_tipi']. '</td>
								<td>
									<select data-placeholder="'.$dil['kullanıcı_tipi'].'" name="kullanici_tipi" class="select" style="width:100%;" tabindex="2">';
		                        	echo '<option value="'.$sonuc['kategori_yetki'].'">'.$dil['kullanici_tipi'][$sonuc['kategori_yetki']].' ('.$dil['yetki'].':'.$sonuc['kategori_yetki'].')</option>';
									
									    $tipler = gnc_model_kullanici_tipleri();
										foreach ($tipler AS $tip)
				                        	echo '<option value="'.$tip['kullanici_tip_yetki'].'">'.$dil[$tip['kullanici_tip_adi']].' ('.$dil['yetki'].':'.$tip['kullanici_tip_yetki'].')</option>';
									echo '    
				                    </select>
				                </td>
			                </tr>
			            </table>
		            </fieldset>
		        	<div>
		            	<!--<input class="buttonS bRed grid2" type="reset" value="'.$dil['iptal'].'">-->
                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
                    	<div class="clear"></div>
                    </div>
		        </form>';
	}
}
function gnc_yonetim_kategori_sil(){
	global $vt;
	
	if (gnc_yetki(111))
	{
		$silinecek_kategori_id = guvenlik($_POST['veri_id']);
		
		$sorgu = $vt->query("SELECT * FROM gnc_kategoriler WHERE kategori_id = '$silinecek_kategori_id' LIMIT 1");
		$sonuc = $vt->fetch_array($sonuc);
		$silinecek_kategorinin_ust_idsi = $sonuc['kategori_id_ust'];
		/*  Silinecek elemanın üst id'sini elemanın içindeki elemanların üst id'si yapalım
		 * 
		 *	$sonuc['menu_eleman_id_ust'] // Silinecek elemanın üst id'si, bu elemanın altındaki elemanların konacağı yeri belirttiği için ciddi önem arz etmektedir.
		 */
		$sorgu = $vt->query("SELECT * FROM gnc_kategoriler WHERE kategori_id_ust = '$silinecek_kategorinin_ust_idsi'");
		if ($sorgu){
			while ($sonuc = $vt->fetch_array($sorgu)){
				$vt->query("UPDATE gnc_kategoriler 
							SET kategori_id_ust = '$silinecek_kategorinin_ust_idsi' 
							WHERE kategori_id_ust = '$silinecek_kategori_id'");
			}
		}
		/* Silinen içeriğe bağlı içeriklerin erişilebilir kalması için bir üst kategorinin içine yerleştir! 
		 * 
		 * Bunun için gnc_iceriklerin_kategorileri tablosunu yeniden düzenle
		 */
		$vt->query("UPDATE gnc_iceriklerin_kategorileri
					SET kategori_id = '$silinecek_kategorinin_ust_idsi' 
					WHERE kategori_id = '$silinecek_kategori_id'");
		
		 
		// Son olarak silmek istediğimiz elemanı silelim
		$vt->query("DELETE FROM gnc_kategoriler
				    WHERE kategori_id = '$silinecek_kategori_id'");
	}	
}
function gnc_yonetim_ayarlar_menu_secimi(){
	global $dil;
	
	include('model/yonetim/gnc.php');	
	$id = guvenlik($_POST['menu_id']);
	
	// Ağaç yapısındaki gösterimi drag & drop ile sıralanabilir hale getirmek için .sortable eklenmiştir. Benzer yapı menü sayfasında da bulunmaktadır.
	echo '<ol class="sortable">';
	gnc_model_menuleri_agac_yapisinda_goster($id);
	echo '</ol>';
	
	echo '	<div class="formRow border-0 padding-0 padding-bottom-35">
				<a id="serialize" class="buttonM bBlue grid12" href="javascript:void(0);">
					<span class="icon-export"></span>
					<span>'.$dil['kaydet'].'</span>
				</a>
				<!--<pre id="serializeOutput"></pre>-->
			</div>';
}
function gnc_yonetim_ayarlar_kategori_dil_secimi(){
	global $dil;
	
	include('model/yonetim/gnc.php');	
	$dil_id = guvenlik($_POST['dil_id']);
	
	// Ağaç yapısındaki gösterimi drag & drop ile sıralanabilir hale getirmek için .sortable eklenmiştir. Benzer yapı menü sayfasında da bulunmaktadır.
	echo '<ol class="sortable">';
	gnc_model_kategorileri_agac_yapisinda_goster(0, $dil_id);
	echo '</ol>';
	
	echo '	<div class="formRow border-0 padding-0 padding-bottom-35">
				<a id="serialize" class="buttonM bBlue grid12" href="javascript:void(0);">
					<span class="icon-export"></span>
					<span>'.$dil['kaydet'].'</span>
				</a>
				<!--<pre id="serializeOutput"></pre>-->
			</div>';
}
function gnc_yonetim_ayarlar_yeni_kategori_ekle_dil_secimi(){
	global $adres, $vt, $dil;
	
	if (gnc_yetki(111))
	{
		include('model/yonetim/gnc.php');
		$dil_id = guvenlik($_POST['dil_id']);
		
		echo '<div class="formRow">
	            	<div class="grid2"><label>'.$dil['ust_kategorinin_adi'].'</label></div>
	                <div class="grid10 searchDrop">
	                    <select data-placeholder="'.$dil['kategori_secin'].'" class="select" name="kategori_ust_kategori_id" style="width:350px;" tabindex="2">
	                        <option value="0">'. $dil['ana_kategori'] .'</option>'; 
							$sonuclar = gnc_model_kategoriler($dil_id);
							foreach ($sonuclar AS $sonuc)
	                        	echo '<option value="'.$sonuc['kategori_id'].'">'.$sonuc['kategori_adi'].'</option>'; 
	                    echo '    
	                    </select>
	                 </div>
	                 <div class="clear"></div>
	            </div>';
	}
}
function gnc_yonetim_ayarlar_yeni_icerik_ekle_dil_secimi(){
	global $vt, $dil;
	
	if (gnc_yetki(100))
	{
		include('model/yonetim/gnc.php');
			
		$dil_id = guvenlik($_POST['dil_id']);
		
		echo '  <div class="formRow" style="height:300px;">
	                <div class="grid2"><label>'. $dil['kategori'] .'</label></div>
	                <div class="grid10">
	                    <select multiple="multiple" class="multiple" title="" id="gnc_yonetim_yeni_icerik_kategori" style="height:280px;">';
		                 	$sonuclar = gnc_model_kategoriler($dil_id);
							foreach ($sonuclar AS $sonuc)
				        		echo '<option value="'.$sonuc['kategori_id'].'">'.$sonuc['kategori_adi'].'</option>';
				        
						echo '    
						</select>
					</div>
				</div>
				<div class="formRow" style="height:360px;">
	            	<div class="grid2"><label>'. $dil['benzer_icerikler'] .'</label></div>
	            	<div class="grid10 searchDrop">
	            		<div class="leftBox">
	                        <input type="text" id="box1Filter" class="boxFilter" placeholder="'.$dil['filtreleyin'].'..." /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />
	                        
	                        <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">';
	                        
	                        $sonuclar = gnc_model_icerikler(0, $dil_id);
							foreach ($sonuclar AS $sonuc)
	                        	echo '<option value="'.$sonuc['icerik_id'].'">'.$sonuc['icerik_baslik'].'</option>';
	                        
							echo '
	                        </select>
	                        <br/>
	                        <!-- <span id="box1Counter" class="countLabel"></span> -->
	                        
	                        <div class="displayNone"><select id="box1Storage"></select></div>
	                    </div>
	                            
	                    <div class="dualControl">
	                        <button id="to2" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
	                        <button id="allTo2" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
	                        <button id="to1" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
	                        <button id="allTo1" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
	                    </div>
	                            
	                    <div class="rightBox">
	                        <input type="text" id="box2Filter" class="boxFilter" placeholder="'.$dil['filtreleyin'].'..." /><button type="button" id="box2Clear" class="dualBtn fltr">x</button><br />
	                        <select id="box2View" multiple="multiple" class="multiple" style="height:300px;">
	                        
	                        </select><br/>
	                        <!-- <span id="box2Counter" class="countLabel"></span> -->
	                        
	                        <div class="displayNone"><select id="box2Storage"></select></div>
	                    </div>
	                    <div class="clear"></div>
	            	</div>
	            </div>
	            
				<div class="formRow">
	            	<div class="grid2"><label>'.$dil['sablonlar'].'</label></div>
                    <div class="grid10 searchDrop">
                        <select data-placeholder="'.$dil['sablon_secin'].'" class="select" id="gnc_yonetim_yeni_icerik_sablon" style="width:350px;" tabindex="2">
                            <option value="0">'.$dil['sablon_secin'].'</option>'; 
							$sonuclar = gnc_model_sablonlar();
							foreach ($sonuclar AS $sonuc)
				        		echo '<option value="'.$sonuc['sablon_id'].'">'.$sonuc['sablon_adi'].' ('.$sonuc['sablon_aciklama'].')</option>';
                        echo '    
                        </select>
                        <span class="note">'. $dil['sablon_secimi_bilgi'] .'</span>
                     </div>
                     <div class="clear"></div>
	           	</div>
	           	<div id="gnc_yonetim_yeni_icerik_ekle_sablon_secildi"></div>';
	}			
}
function gnc_yonetim_ayarlar_yeni_icerik_ekle_sablon_secimi(){
	global $vt, $dil;
	
	if (gnc_yetki(100))
	{
		include('model/yonetim/gnc.php');
			
		$sablon_id = guvenlik($_POST['sablon_id']);	
		$sonuclar = gnc_model_sablonlarin_icerikleri($sablon_id);
		if (!empty($sonuclar))
		{
			foreach ($sonuclar AS $sonuc){
				echo '  <div class="formRow" style="height:25px;">
			                <div class="grid2"><label>'. $sonuc['sablon_icerik_adi'] .'</label></div>
			                <div class="grid10">
			                	<input type="text" class="icerik_sablonu" id="'.$sonuc['sablon_icerik_id'].'">   
							</div>
						</div>';
			}	
		}	
	}	
}
function gnc_yonetim_yeni_icerik_ekle(){
	global $vt, $dil, $site;
	
	if (gnc_yetki(100))
	{
		$baslik   = guvenlik($_POST['baslik']);
		$sef   	  = gnc_sef_olustur($baslik);
		$icerik   = $_POST['icerik'];
		$ozet     = guvenlik($_POST['ozet']);
		$dil      = guvenlik($_POST['dil']);
		$kategori = $_POST['kategori'];
		$benzer_icerik 	= $_POST['benzer_icerik'];
		$sablon_id 		= $_POST['sablon_id'];
		$sablon_icerik_id = $_POST['sablon_icerik_id'];
		$sablon_icerik 	= $_POST['sablon_icerik'];
		
		$yuklenen_resim_buyuk = guvenlik($_POST['yuklenen_resim_buyuk']);
		$yuklenen_resim_kucuk = guvenlik($_POST['yuklenen_resim_kucuk']);
		$yuklenen_resim_id = (int)guvenlik($_POST['yuklenen_resim_id']);
		$yuklenen_resim_id_2 = (int)guvenlik($_POST['yuklenen_resim_id_2']);
		
		$sira = guvenlik($_POST['sira']);
	
		/* İçeriği yarat */
		
		// Ckfinder ile içeriğin resim yolunu kaydet
		$sorgu = $vt->query("INSERT INTO gnc_icerikler
								(dil_id, kullanici_id, 					icerik_baslik, icerik_sef, icerik_icerik, icerik_ozet, 	icerik_sira, icerik_tarih, 		 icerik_buyuk_resim_id, icerik_kucuk_resim_id)
							VALUES
								('$dil', '{$_SESSION['kullanici_id']}', '$baslik',     '$sef',     '$icerik',     '$ozet',		'$sira',     '{$site['bugun']}', '$yuklenen_resim_buyuk' , '$yuklenen_resim_kucuk')");
		
		/*
		// Ajax file upload ile içeriğin resim id'sini kaydet
		$sorgu = $vt->query("INSERT INTO gnc_icerikler
								(dil_id, kullanici_id, 					icerik_baslik, icerik_sef, icerik_icerik, icerik_ozet, 	icerik_sira, icerik_tarih, 		icerik_buyuk_resim_id, icerik_kucuk_resim_id)
							VALUES
								('$dil', '{$_SESSION['kullanici_id']}', '$baslik',     '$sef',     '$icerik',     '$ozet',		'$sira',     '{$site['bugun']}', 	'$yuklenen_resim_id' , '$yuklenen_resim_id_2')");
		*/
		// Son girilen içeriğin id'sini al
		$son_yaratilan_icerik_id = $vt->insert_id();
		
		// İçerik için seçili olan kategorileri belirt	
		$sorgu = "INSERT INTO gnc_iceriklerin_kategorileri
					(icerik_id, kategori_id)
				  VALUES ";
		for ($i = 0; $i <= count($kategori) -1; $i++){		  
			$sorgu .= "('$son_yaratilan_icerik_id','{$kategori[$i]}')";
			if ($i != count($kategori) -1)
				$sorgu .=", ";
		}
		echo $sorgu;
		$sorgu = $vt->query($sorgu);
		
		// İçerik için seçili olan benzer içerikleri belirt
		$sorgu = "INSERT INTO gnc_iceriklerin_benzer_icerikleri
					(icerik_id, benzer_icerik_id)
				  VALUES ";
		for ($i = 0; $i <= count($benzer_icerik) -1; $i++){		  
			$sorgu .= "('$son_yaratilan_icerik_id','{$benzer_icerik[$i]}')";
			if ($i != count($benzer_icerik) -1)
				$sorgu .=", ";
		}
		echo $sorgu;
		$sorgu = $vt->query($sorgu);
		
		// İçerik için seçili olan şablon içeriklerini kaydet
		$sorgu = "INSERT INTO gnc_iceriklerin_sablonlari
					(icerik_id, sablon_id, sablon_icerik_id, sablon_icerik_degeri)
				  VALUES ";
		for ($i = 0; $i <= count($benzer_icerik) -1; $i++){		  
			$sorgu .= "('$son_yaratilan_icerik_id', '$sablon_id', '{$sablon_icerik_id[$i]}', '{$sablon_icerik[$i]}')";
			if ($i != count($sablon_icerik) -1)
				$sorgu .=", ";
		}
		echo $sorgu;
		$sorgu = $vt->query($sorgu);
	}
}
function gnc_yonetim_icerik_duzenle(){
	global $dil, $vt;
	
    $id = (int)guvenlik($_POST['id']);
	
	// Kullanıcı bu içeriği düzenlemeye yetkili mi kontrol edelim
	$sorgu = $vt->query("SELECT * FROM gnc_iceriklerin_kategorileri
						 LEFT JOIN gnc_kategoriler ON gnc_kategoriler.kategori_id = gnc_iceriklerin_kategorileri.kategori_id
						 WHERE gnc_iceriklerin_kategorileri.icerik_id = '$id'
						 LIMIT 1");
	
	$sonuc = $vt->fetch_array($sorgu);
	
	echo "SELECT * FROM gnc_iceriklerin_kategorileri
						 LEFT JOIN gnc_kategoriler ON gnc_kategoriler.kategori_id = gnc_iceriklerin_kategorileri.kategori_id
						 WHERE gnc_iceriklerin_kategorileri.icerik_id = '$id'
						 LIMIT 1";
	print_r($sonuc);
	if (gnc_yetki($sonuc['kategori_yetki']))
	{		
		$baslik = guvenlik($_POST['baslik']);
		//$sef   	= gnc_sef_olustur($baslik); // Sef'i değiştirmek yeni bir içerik oluşturma anlamına gelir, kullanımına dikkat edilmeli
		$icerik = $_POST['icerik'];
		$ozet   = guvenlik($_POST['ozet']);	
		$yuklenen_resim_id = (int)guvenlik($_POST['yuklenen_resim_id']);
		$yuklenen_resim_id_2 = (int)guvenlik($_POST['yuklenen_resim_id_2']);
		$kategori = $_POST['kategori'];
		$benzer_icerik 	= $_POST['benzer_icerik'];
		$sablon_icerik_id = $_POST['sablon_icerik_id'];
		$sablon_icerik 	= $_POST['sablon_icerik'];
		
		// İçeriği düzenle
		$sorgu = "	UPDATE gnc_icerikler
				  	SET icerik_baslik = '$baslik',
				  	    icerik_ozet = '$ozet',
						icerik_icerik = '$icerik' ";
		
		if (!empty($yuklenen_resim_id))
			$sorgu .= ", icerik_buyuk_resim_id = '$yuklenen_resim_id' ";
		if (!empty($yuklenen_resim_id_2))
			$sorgu .= ", icerik_kucuk_resim_id = '$yuklenen_resim_id_2' ";	
						
		$sorgu .= "	WHERE icerik_id = '$id'";
		$vt->query($sorgu);
		
		// İçerik için seçili olan kategorileri belirt	
		$vt->query("DELETE FROM gnc_iceriklerin_kategorileri WHERE icerik_id = '$id'");
		$sorgu = "INSERT INTO gnc_iceriklerin_kategorileri
					(icerik_id, kategori_id)
				  VALUES ";
		for ($i = 0; $i <= count($kategori) -1; $i++){		  
			$sorgu .= "('$id','{$kategori[$i]}')";
			if ($i != count($kategori) -1)
				$sorgu .=", ";
		}
		$sorgu = $vt->query($sorgu);
		
		// İçerik için seçili olan benzer içerikleri belirt
		$vt->query("DELETE FROM gnc_iceriklerin_benzer_icerikleri WHERE icerik_id = '$id'");
		$sorgu = "INSERT INTO gnc_iceriklerin_benzer_icerikleri
					(icerik_id, benzer_icerik_id)
				  VALUES ";
		for ($i = 0; $i <= count($benzer_icerik) -1; $i++){		  
			$sorgu .= "('$id','{$benzer_icerik[$i]}')";
			if ($i != count($benzer_icerik) -1)
				$sorgu .=", ";
		}
		$sorgu = $vt->query($sorgu);			
		
		// İçeriğe ait tanımlanan bir şablon varsa, şablonu düzenle
		for ($i = 0; $i <= count($sablon_icerik_id)-1; $i++){		  
			$sorgu = "UPDATE gnc_iceriklerin_sablonlari
					  SET sablon_icerik_degeri = '{$sablon_icerik[$i]}'
					  WHERE iceriklerin_sablonlari_id = '{$sablon_icerik_id[$i]}'";
			$sorgu = $vt->query($sorgu);
		}
	}
}
/* Blog sayfası içeriğini yönetim paneline gerek kalmadan güncelleyen fonksiyon */
function gnc_yonetim_sayfa_icinden_icerik_duzenle(){
	global $site, $vt;
	
	$sef = guvenlik($_POST['sef']);
	$metin = addslashes($_POST['metin']);
	if (!empty($sef) && gnc_yetki(99)){
		$vt->query("UPDATE gnc_icerikler
					SET icerik_icerik = '$metin',
						icerik_tarih = '{$site['bugun']}'
					WHERE icerik_sef = '$sef'");			
	}
}
function gnc_yonetim_sablon_detaylari(){
	global $dil, $vt;
	
	include('model/yonetim/gnc.php');
	$sonuclar = gnc_model_sablonlarin_icerikleri(guvenlik($_POST['id']));
	
	echo '<table cellpadding="0" cellspacing="0" width="100%" class="tDefault checkAll tMedia" id="checkAll">
	            <thead>
	                <tr>
	                    <td width="150">'.$dil['alan_adi'] .'</td>
	                    <td>'.$dil['alan_aciklamasi'] .'</td>
	                </tr>
	            </thead>
	            <tbody>';
				foreach ($sonuclar AS $sonuc){
					echo '  <tr>
			                    <td class="textL">'. $sonuc['sablon_icerik_adi']. '</td>
			                    <td class="textL">'.$sonuc['sablon_icerik_aciklama'].'</td>
			                </tr>';
	            }
	echo '		</tbody>
	       </table>';
}
function gnc_yonetim_sablon_sil()
{
	global $vt;
	
	if (gnc_yetki(111))
	{
		$sablon_id = guvenlik($_POST['veri_id']);
		
		// Şablonu veritabanından sil						
		$vt->query("DELETE FROM gnc_sablonlar
					WHERE sablon_id = '$sablon_id'");
		// Şablonun içeriğinide veritabanından sil						
		$vt->query("DELETE FROM gnc_sablonlarin_icerikleri
					WHERE sablon_id = '$sablon_id'");
		// Şablon artık olmadığına göre şablonu içeriklerin şablonlarından da sil
		$vt->query("DELETE FROM gnc_iceriklerin_sablonlari
					WHERE sablon_id = '$sablon_id'");		
	}	
}
function gnc_yonetim_album_detaylari(){
	global $adres, $dil, $site, $vt;
	
	if (isset($_POST['album_id']))
		$album_id = guvenlik($_POST['album_id']);
	else
		$album_id = 0;
	
	include('model/yonetim/gnc.php');
	$album = gnc_model_albumler($album_id); 
	
		echo '<div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $album[0]['album_adi'] .'</h6>
						<div class="titleOpt">
							<a data-toggle="dropdown" onClick="gnc_veri_sil('.$album_id.',\'gnc_yonetim_albumu_sil\', \'yenile\');" href="javascript:void(0);" style="border: none; padding-top:12px;">
								'.$dil['albumu_sil'].'
								<span class="icon-close"></span>
								<span class="clear"></span>
							</a>
						</div>
						<div class="clear"></div>
					</div>
					<center><p>'.$album[0]['album_aciklama'].'</p></center>
					<div class="divider"></div>';
		
		$veriler  = gnc_model_album_verileri($album_id);
		if (!empty($veriler)){
			echo '	<div class="pagination">
		                <ul class="pages">';
							$i = 0;
							foreach ($veriler AS $veri)
							{
								$i++;
								echo '<li><a id="'.$veri['veri_id'].'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" title="'.$veri['veri_adi'].'" rel="'.$site['url'].'ajax/gnc_yonetim_albumdeki_resmi_goster">'.$i.'</a></li>';
			                }
		          echo '</ul>
		            </div>';
					}
			echo '	<div class="gallery">
						<ul>';
						$veriler  = gnc_model_album_verileri($album_id);
						if (!empty($veriler))
						{
							foreach ($veriler AS $veri)
							{
			                    	
								echo '	
			                    <li id="veri_'.$veri['veri_id'].'">
			                    	<a href="'.$site['url'].$site['resim_yuklenecek_adres'].$veri['veri_yolu'].'" title="'.$veri['veri_adi'].'" class="lightbox"><img src="'.$site['url'].$site['resim_yuklenecek_adres'].$veri['veri_yolu'].'" alt="'.$veri['veri_aciklama'].'" /></a>
			                        <a href="javascript:void(0);" onClick="gnc_veri_sil('.$veri['veri_id'].', \'gnc_yonetim_albumden_veri_sil\', \'yenile\');" title="'.$dil['albumden_cikart'].'" class="galeri hover"><img src="'.$site['url'].'sistem/tasarim/images/icons/delete.png" alt="" /></a>
								</li>
			                    ';
       
								//echo '<div style="display: block; float:left;"><img src="'.$site['url'].$site['resim_yuklenecek_adres'].'/thumb/'.$veri['veri_yolu'].'" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DFDFDF; padding: 4px;"><span class="icon-close"></span></div>';
							}
						
						}
				echo '  </ul>
						<div class="divider"></div>
						<div class="grid5 left">
							<p><strong>'.$dil['thumbin_boyutlari'].'</strong></p>
							<img src="'.$site['url'].'sistem/img/ruler.png">
							<span class="ruler">'.$album[0]['album_thumb_en'].' x '.$album[0]['album_thumb_boy'].'</span>
						</div>
						<div class="grid6 right">
							<p><strong>'.$dil['cropun_boyutlari'].'</strong></p>
							<img src="'.$site['url'].'sistem/img/ruler.png">
							<span class="ruler">'.$album[0]['album_crop_en'].' x '.$album[0]['album_crop_boy'].'</span>
						</div>
						<div class="clear"></div>
						<div class="divider"></div>
					</div>
				</div>
			</div>';	
}
function gnc_yonetim_albumdeki_resmi_goster(){
	global $dil,$site,$vt;
	
	include('model/yonetim/gnc.php');
	$veri_tipi = array(1, 11); 
	$sonuclar = gnc_model_veriler($veri_tipi, guvenlik($_POST['id']));
	foreach($sonuclar AS $sonuc)
		echo '<img alt="'.$sonuc['veri_aciklama'].'" src="'.$sonuc['veri_yolu'].'" style="padding:0px;">';
}
function gnc_yonetim_resim_kirp(){
	global $dil,$site,$vt;
	
	$path = pathinfo($_POST['crop']); // http://www.php.net/manual/en/function.pathinfo.php 'dan fonksiyonun kullanımıyla ilgili detaylı bilgi alabilirisniz.
	$img = $site['yuklu_oldugu_konum'].$site['dosya_yuklenecek_adres'].$path['basename'];
	
	$x1 = $_POST['x1'];
	$y1 = $_POST['y1'];
	$x2 = $_POST['x2'];
	$y2 = $_POST['y2'];
	$w  = $_POST['w'];
	$h  = $_POST['h'];
	
	$album_id = guvenlik($_POST['album_id']);
	$resim_aciklama = guvenlik($_POST['resim_aciklama']);
	
	$handle = new Upload($img);
	
	// Geçici yükleme işlemi tamamlandı mı kontrol edelim
	// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
	if ($handle->uploaded) { 
		// Dosyamız sunucuda
		// Eğer yüklenen dosya resimse, dosyayı kalıcı konumuna almadan bir kaç değişiklik yapalım.
		// Resim kırpma için ilgili değerleri al
		$img_x = $handle->image_src_x; // Resmin genişliği
		$img_y = $handle->image_src_y; // Resmin boyu		
		//$x1 = $img_x - $x1;
		//$y1 = $img_y - $y1;
		$handle->image_ratio_crop = 'L';
		$handle->image_x = $x1;
		$handle->image_y = $y1;		
		
		$x2 = $img_x - $x2;
		$y2 = $img_y - $y2;
		$handle->image_crop = array($y1, $x2, $y2, $x1); // T R B L
		
		// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
		// Örneğin $handle->Process('/home/www/veri/');
		$dir_dest = $site['resim_yuklenecek_adres'].'crop/';		
		$handle->Process($dir_dest);
	
		// Kırpılmış resim verisini tabloya ekle
		$vt->query("INSERT INTO gnc_veriler
					(veri_adi, veri_yolu, veri_tipi, veri_aciklama, veri_tarih)
				VALUES
					('{$handle->file_dst_name}', 'crop/$handle->file_dst_name', '1', '$resim_aciklama', '{$site['bugun']}')");
		$veri_id = $vt->insert_id();
		// Veriyi seçilen albümün verisi olarak atayalım
		$vt->query("INSERT INTO gnc_albumlerin_verileri
						(album_id, veri_id, albumlerin_verileri_aciklama)
					VALUES
						('$album_id','$veri_id','$resim_aciklama')");
		
							 
		$basari_mesaji = $dil['resim_basariyla_kesilmistir'].$dir_dest.$handle->file_dst_name;
		gnc_basari($basari_mesaji);
	}
}
function gnc_yonetim_albumu_sil(){
	global $vt;
	
	$veri_id = guvenlik($_POST['veri_id']);
	$vt->query("DELETE FROM gnc_albumler WHERE album_id = '$veri_id'");
	$vt->query("DELETE FROM gnc_albumlerin_verileri WHERE album_id = '$veri_id'");
}
function gnc_yonetim_albumden_veri_sil(){
	global $vt;
	
	$veri_id = guvenlik($_POST['veri_id']);
	$vt->query("DELETE FROM gnc_albumlerin_verileri WHERE veri_id = '$veri_id'");
}
function gnc_yonetim_iletisim_formu_detaylari(){
	global $vt;
	
	include('model/yonetim/gnc.php');
	$sonuclar = gnc_model_iletisim_formu(guvenlik($_POST['id']));
	foreach($sonuclar AS $sonuc)
		echo $sonuc['iletisim_aciklama'];
}
?>