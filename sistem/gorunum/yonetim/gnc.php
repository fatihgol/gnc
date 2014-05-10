<?php
if (!defined('gnc') || $_SESSION['kullanici_tipi'] < 100)
	die();
?>
<div id="content">
	<div id="loading"><img src="<?php echo $site['url']; ?>sistem/img/ajax-load.gif"><p><?php echo $dil['islem_yapiliyor']; ?></p></div>
	<div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span><?php echo $dil['yonetim_hos_geldiniz'];?></span>
        <div class="fluid">	    
	        <!-- Sağüst köşede yer alan arama penceresi ve arama sonuçlarını içeren  pencere-->
	        <div class="grid3" style="float:right;">
	        	<div class="searchLine" style="margin-top: 15px;">
	                <div class="relative">
	                    <input type="text" class="arama" placeholder="<?php echo $dil['ne_aramak_istiyorsunuz']; ?>"/>
	                	<button type="submit" name="find" value="">
	                    	<span class="icos-search"></span>
	                	</button>
	                </div>
	                
	                <!-- Arama sonuçlarının gösterileceği pencere -->
	                <div class="sResults arama_sonuclari none"></div>
	                
	           </div>
	        </div>	     
        </div>       
        <!--
        <ul class="quickStats">
            <li>
                <a href="" class="blueImg"><img src="sistem/tasarim/images/icons/quickstats/plus.png" alt="" /></a>
                <div class="floatR"><strong class="blue">5489</strong><span>visits</span></div>
            </li>
            <li>
                <a href="" class="redImg"><img src="sistem/tasarim/images/icons/quickstats/user.png" alt="" /></a>
                <div class="floatR"><strong class="blue">4658</strong><span>users</span></div>
            </li>
            <li>
                <a href="" class="greenImg"><img src="sistem/tasarim/images/icons/quickstats/money.png" alt="" /></a>
                <div class="floatR"><strong class="blue">1289</strong><span>orders</span></div>
            </li>
        </ul>
       -->
        <div class="clear"></div>
    </div>
     
    <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <?php gnc_breadcrumb_yarat(); ?>
            </ul>
        </div>
        
        <div class="breadLinks">
            <ul>
                <li><a href="<?php echo $site['url'] ?>" title=""><i class="icos-play"></i><span><?php echo $dil['siteyi_goruntule'] ?></span></a></li>
            
            </ul>
            <div class="clear"></div>
        </div>
    </div>
 
 	<?php
 	/* Modül çağırıldığında hangi sayfa fonksiyonunun gösterileceğinin tanımı
	 * 
	 * Görünüm fonksiyonlarını kontrol ederek url yapısından istenen fonksiyonu çalıştırır. 
	 */
 	_gnc_sayfa_fonksiyonu('yonetim');	
 	?>	
</div>
<!-- İçeriğin sonu -->
<?php
/* Görünüm dosyalarının alt kısmında "$adres['fonk']" ile çağırılacak fonksiyonlar tanımlanmaktadır. 
 * 
 * Bu fonksiyonlar sayfanın her yerinde yaratılabilecekken gnc de standart olarak dosyaların en sonunda yaratılmakta ve url'den otomatik olarak çağırılmaktadır. 
 */
function yonetim(){
	global $dil, $site;
	
	echo   '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
						<div class="whead">
							<h6>'.$dil['hosgeldin'].' '.$_SESSION['kullanici_adi'].'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">
							'.$dil['yonetim_hos_geldiniz'].'
							<div class="fluid">
								<div class="grid12">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="yonetim/ayarlar">'.$dil['ayarlar'].'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid12">
									<div class="wButton">
										<a class="buttonL bLightBlue" title="" href="icerikler">'.$dil['icerikler'].'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid12">
									<div class="wButton">
										<a class="buttonL bBlue" title="" href="forum">'.$dil['forum'].'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid12">
									'.gnc_decrypt($dil['yonetim_sayfasi_aciklama'],gnc).'
								</div>
							</div>
						</div>
					</div>
			        <div class="clear"></div>
			    </div>
			</div>';
}
function ayarlar(){
	global $adres, $dil, $site, $vt;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    					
			        <!-- Yönetim sayfasına ait hoşgeldin mesajı -->
			        <div class="widget grid12">';
				
					// Ayarlar sayfasının seçim yapılmamış hali							
					echo '<div class="whead">
							<h6>'. $dil['ayarlar'] .'</h6>
							<div class="clear"></div>
						  </div>
						  <div class="body">
							'.$dil['ayarlar_bilgi'].'						  
							<div class="fluid">
								<div class="grid4">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="genel-ayarlar">'.$dil['genel_ayarlar'].'</a>
									</div>
								</div>
								<div class="grid4">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="kullanici">'.$dil['menu']['kullanici'].'</a>
									</div>
								</div>
								<div class="grid4">
									<div class="wButton">
										<a class="buttonL bBlue first" title="" href="menu">'.$dil['menu_ayarlari'].'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid4">
									<div class="wButton">
										<a class="buttonL bRed first" title="" href="ayarlar/dil">'.$dil['dil_secenekleri'].'</a>
									</div>
								</div>
								<div class="grid4">
									<div class="wButton">
										<a class="buttonL bGreen first" title="" href="ayarlar/dosyalar">'.$dil['php_dosyalari'].'</a>
									</div>
								</div>
								<div class="grid4">
									<div class="wButton">
										<a class="buttonL bGreen first" title="" href="ayarlar/yonlendiriciler">'.$dil['yonlendiriciler'].'</a>
									</div>
								</div>
							</div>
						  	
						  </div>
						  <div class="fluid">
						  	<div class="nNote nFailure">
								<p>'.$dil['ne_yaptiginizi_bilmiyorsaniz_degisiklik_yapmayin'].'</p>
							</div>
						  </div>';
	
			  echo '</div>
			        <div class="clear"></div>
			    </div>				    
			</div>';
}
function genel_ayarlar()
{
	global $adres, $dil, $site, $vt;
	
	echo '	<div class="wrapper"><div class="fluid"><div class="grid12">';
	echo '	<form action="'.$site['url'].'yonetim/gnc_model_genel_ayarlari_duzenle" class="gnc_ajax_form" method="post">      
			<div class="widget acc">
				<div class="whead"><h6>'.$dil['genel_ayarlar'].'</h6><div class="clear"></div></div>
                <div class="menu_body">';
                $ayarlar = gnc_model_ayarlar(1);
                foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							if ($sonuc['ayar_degeri'] == 'on' || $sonuc['ayar_degeri'] == 'off')
								echo '<input type="hidden" name="'.$sonuc['ayar_adi'].'" value="off"/>';
								
							if ($sonuc['ayar_degeri'] == 'on')
								echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							elseif ($sonuc['ayar_degeri'] == 'off')
                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							else
								echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// Sonradan eklenen ayarların tipi 0 dır
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
				<div class="whead"><h6>'.$dil['konum_ayarlar'].'</h6><div class="clear"></div></div>
				<div class="menu_body">';
				$ayarlar = gnc_model_ayarlar(2);
				foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							if ($sonuc['ayar_degeri'] == 'on')
								echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							elseif ($sonuc['ayar_degeri'] == 'off')
                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							else
								echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
				<div class="whead"><h6>'.$dil['iletisim_ayarlar'].'</h6><div class="clear"></div></div>
				<div class="menu_body">';
				$ayarlar = gnc_model_ayarlar(3);
				foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							if ($sonuc['ayar_degeri'] == 'on')
								echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							elseif ($sonuc['ayar_degeri'] == 'off')
                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							else
								echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
				<div class="whead"><h6>'.$dil['meta_ayarlar'].'</h6><div class="clear"></div></div>
				<div class="menu_body">';
				$ayarlar = gnc_model_ayarlar(4);
				foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							if ($sonuc['ayar_degeri'] == 'on')
								echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							elseif ($sonuc['ayar_degeri'] == 'off')
                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							else
								echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
				<div class="whead"><h6>'.$dil['kod_ayarlari'].'</h6><div class="clear"></div></div>
				<div class="menu_body">';
				$ayarlar = gnc_model_ayarlar(5);
				foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							echo '<div class="grid8"><textarea name="'.$sonuc['ayar_adi'].'">'.$sonuc['ayar_degeri'].'</textarea><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
				<div class="whead"><h6>'.$dil['sosyal_ag_ayarlari'].'</h6><div class="clear"></div></div>
				<div class="menu_body">';
				$ayarlar = gnc_model_ayarlar(6);
				foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
				<div class="whead"><h6>'.$dil['diger_ayarlar'].'</h6><div class="clear"></div></div>
				<div class="menu_body">';
				$ayarlar = gnc_model_ayarlar(0);
				foreach ($ayarlar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							if ($sonuc['ayar_degeri'] == 'on')
								echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							elseif ($sonuc['ayar_degeri'] == 'off')
                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							else
								echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '
				</div>
			</div>
			<div class="formRow">
            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
            </div>
			</form>';
	echo '</div></div></div><div class="wrapper"><div class="fluid"><div class="widget grid12">';
	
	/*
	echo '<div class="whead">
			<h6>'. $dil['ayarlar'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
		
		echo '<form action="'.$site['url'].'yonetim/gnc_model_genel_ayarlari_duzenle" class="gnc_ajax_form" method="post">
				<fieldset>';
				$sonuclar = gnc_model_ayarlar(1); 
				foreach ($sonuclar AS $sonuc)
				{
					if (!isset($dil[$sonuc['ayar_adi']]))
						$dil[$sonuc['ayar_adi']] = $sonuc['ayar_adi'];
						
			    	echo '<div class="formRow" id="genel_ayar_'.$sonuc['ayar_id'].'">
	                        <div class="grid3"><label>'. ucFirst($dil[$sonuc['ayar_adi']]) .':</label></div>';
							
							if ($sonuc['ayar_degeri'] == 'on')
								echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							elseif ($sonuc['ayar_degeri'] == 'off')
                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$sonuc['ayar_adi'].'" /><span class="note">'.$sonuc['ayar_aciklama'].'</span></div></div>';
							else
								echo '<div class="grid8"><input type="text" name="'.$sonuc['ayar_adi'].'" value="'.$sonuc['ayar_degeri'].'"/><span class="note">'.$sonuc['ayar_aciklama'].'</span></div>';
							
							// 40'a kadar olan ayarlar sistem ayarları olarak tanımlanmıştır.
							if ($sonuc['ayar_tipi'] == 0) 
								echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['ayar_id'].', \'gnc_yonetim_ayar_sil\', \'genel_ayar\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>'; 
							
	                echo '  <div class="clear"></div>
			              </div>';           
				}
				echo '	<div class="formRow">
			            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
	                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
	                    </div>
				</fieldset>
			</form>';
	echo '</div>';
	echo '</div></div></div>';
	*/
	echo '<div class="whead">
			<h6>'. $dil['genel_ayar_ekle'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
				echo '<form action="'.$site['url'].'yonetim/gnc_model_genel_ayarlar_ekle" class="gnc_ajax_form" method="post">
						<fieldset>
				    		<div class="formRow">
		                        <div class="grid2"><label>'. $dil['ayar_adi']. '</label><br><span class="note">'.$dil['ayar_adi_bilgisi'].'</span></div>
		                        <div class="grid10"><input type="text" name="ayar_adi" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['ayar_degeri']. '</label></div>
		                        <div class="grid10"><input type="text" name="ayar_degeri" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['ayar_aciklama']. '</label></div>
		                        <div class="grid10"><textarea name="ayar_aciklama"></textarea></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
		                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['ekle'].'">
		                    </div>
				        </fieldset>
				      </form>';
	echo '</div>';
}
function profil()
{
	global $adres, $dil, $site;
	echo '	<div class="wrapper">    
				<div class="fluid">
			        <div class="widget grid12">
						<div class="whead">
							<div class="whead">
								<h6>'. $dil['menu']['profil'] .'</h6>
								<div class="clear"></div>
							</div>
							<div class="body">';
									// Yeni bir dil yarat
									gnc_model_profil_duzenle();
									echo '	<form class="main" enctype="multipart/form-data" method="post" action="'.$adres['mevcut'] .'">
											<fieldset>
									    		<div class="formRow">
							                        <div class="grid2"><label>'. $dil['eposta_adresinizi_yazin']. '</label></div>
							                        <div class="grid10"><input type="text" name="kullanici_kullanici_adi" value="'.$_SESSION['kullanici_kullanici_adi'].'" disabled/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['sifre']. '</label><br></div>
							                        <div class="grid10"><input type="password" name="kullanici_sifre1" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['sifrenizi_tekrar_girin']. '</label><br></div>
							                        <div class="grid10"><input type="password" name="kullanici_sifre2" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['kullanıcı_adi']. '</label><br></div>
							                        <div class="grid10"><input type="text" name="kullanici_adi" value="'.$_SESSION['kullanici_adi'].'"/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['kullanıcı_soyadi']. '</label><br></div>
							                        <div class="grid10"><input type="text" name="kullanici_soyadi" value="'.$_SESSION['kullanici_soyadi'].'"/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
									            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
							                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
							                    </div>
									        </fieldset>
									        </form>';
					echo '	</div>
							<div class="clear"></div> 
						</div>
					</div>
				</div>
			</div>';
}
function kullanicilar()
{
	global $adres, $dil, $site, $vt;
	gnc_model_kullanici_detaylarini_duzenle();
	
	echo '	<div class="wrapper">    
				<div class="fluid">
			        <div class="widget grid12">
						<div class="whead">
				            <div class="whead"><h6>'.$dil['kullanıcı_listesi'].'</h6><div class="clear"></div></div>
				            <div id="dyn">
				                <a class="tOptions act" title="Options"><img src="'.$site['url'].'sistem/gorunum/yonetim/tasarim/images/icons/options" alt="" /></a>
				                
				                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
					                <thead>
						                <tr>
							                <th>'. $dil['kullanıcı_kullanici_adi'] .'</th>
							                <th>'. $dil['kullanıcı_tipi'] .'</th>
							                <th>'. $dil['islemler'] .' </th>
						                </tr>
					                </thead>
					                <tbody>';
										
										$sonuclar = gnc_model_kullanicilar();
										foreach ($sonuclar AS $sonuc)
										{
											echo '	<tr class="gradeX" id="kullanici_'.$sonuc['kullanici_id'].'">';
														if ($sonuc['kullanici_aktif'] == 0)
															$renk = 'style="color:red;"';
														elseif ($sonuc['kullanici_aktif'] == 1)
															$renk = '';
														else
															$renk = 'style="color:darkred;"';	
														echo '
														<td '.$renk.'>'.$sonuc['kullanici_kullanici_adi'].'</td>
														<td>'.$dil['kullanici_tipi'][$sonuc['kullanici_tipi']].'</td>
														<td class="center">
															<a rel="'.$site['url'].'ajax/gnc_yonetim_kullanici_detaylari" title="'. $dil['kullanici_detaylari']  .'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['kullanici_id'].'" rev="380">'. $dil['detaylar'] .'</a>
															<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['kullanici_id'].', \'gnc_yonetim_kullanici_sil\', \'kullanici\');" title="'. $dil['sil']  .'" class="buttonM bRed ml10" style="color:#fff">'. $dil['sil'] .'</a>
									                    </td>
													</tr>';
										}
							                
							            echo '
						            </tbody>
				                </table> 
				            </div>
				            <div class="clear"></div> 
						</div>
					</div>
				</div>
			</div>';
}
function yeni_kullanici(){
	global $adres, $dil, $site;
	
	echo '	<div class="wrapper">    
				<div class="fluid">
			        <div class="widget grid12">
						<div class="whead">
							<div class="whead">
								<h6>'. $dil['yeni_kullanici'] .'</h6>
								<div class="clear"></div>
							</div>
							<div class="body">';
									// Yeni bir dil yarat
									gnc_model_kullanici_ekle();
									echo '	<form class="main gnc_ajax_form" rel="temizle" enctype="multipart/form-data" method="post" action="'.$adres['mevcut'] .'">
											<fieldset>
									    		<div class="formRow">
							                        <div class="grid2"><label>'. $dil['eposta_adresinizi_yazin']. '</label><br><span class="note">'.$dil['ornek'].' info@guncebektas.com</span></div>
							                        <div class="grid10"><input type="text" name="kullanici_kullanici_adi" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['sifre']. '</label><br></div>
							                        <div class="grid10"><input type="password" name="kullanici_sifre1" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['sifrenizi_tekrar_girin']. '</label><br></div>
							                        <div class="grid10"><input type="password" name="kullanici_sifre2" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['kullanıcı_tipi']. '</label></div>
							                        <div class="grid10 searchDrop">
									                    <select data-placeholder="'.$dil['kullanıcı_tipi'].'" name="kullanici_tipi" class="select" style="width:100%;" tabindex="2">';
									                        $tipler = gnc_model_kullanici_tipleri();
															foreach ($tipler AS $tip)
									                        	echo '<option value="'.$tip['kullanici_tip_yetki'].'">'.$dil[$tip['kullanici_tip_adi']].' ('.$dil['yetki'].':'.$tip['kullanici_tip_yetki'].')</option>';
														echo '    
									                    </select>
									                 </div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['kullanıcı_grubu']. '</label></div>
							                        <div class="grid10 searchDrop">
									                    <select data-placeholder="'.$dil['kullanıcı_grubu'].'" name="kullanici_grubu" class="select" style="width:100%;" tabindex="2">';
															$gruplar = gnc_model_kullanici_gruplari();
															foreach ($gruplar AS $grup)
									                        	echo '<option value="'.$grup['kullanici_grup_id'].'">'.$grup['kullanici_grup_adi'].'</option>';
														echo '    
									                    </select>
									                 </div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['kullanıcı_adi']. '</label><br></div>
							                        <div class="grid10"><input type="text" name="kullanici_adi" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
							                        <div class="grid2"><label>'. $dil['kullanıcı_soyadi']. '</label><br></div>
							                        <div class="grid10"><input type="text" name="kullanici_soyadi" value=""/></div>
							                        <div class="clear"></div>
									            </div>
									            <div class="formRow">
									            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
							                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
							                    </div>
									        </fieldset>
									        </form>';
					echo '	</div>
							<div class="clear"></div> 
						</div>
					</div>
				</div>
			</div>';
}
function menu()
{
	global $adres, $dil, $vt;
	
	echo '	<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
						<div class="whead">
							<h6>'. $dil['menuler'] .'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">
							<div class="formRow">
				            	<div class="grid2"><label>'.$dil['menuler'].'</label></div>
				                <div class="grid10 searchDrop">
				                    <select data-placeholder="'.$dil['menu_secin'].'" class="select" id="gnc_yonetim_menu_secin" style="width:350px;" tabindex="2">
				                        <option value=""></option>'; 
										$sonuclar = gnc_model_menuler();
										foreach ($sonuclar AS $sonuc)
				                        	echo '<option value="'.$sonuc['menu_id'].'">'.$sonuc['menu_adi'].'</option>'; 
											
										gnc_model_menuleri_agac_yapisinda_goster();
											
				                    echo '    
				                    </select>
				                 </div>
				                 <div class="clear"></div>
				            </div>
				            
				            <div id="gnc_yonetim_menu_dil_secildi"></div>
						  </div>';
					echo '</div></div></div><div class="wrapper"><div class="fluid"><div class="widget acc grid12">';
					echo '<div class="whead"><h6>'. $dil['menu_yarat'] .'</h6><div class="clear"></div></div>
				          <div class="menu_body">';
				                // Yeni bir dil yarat
								gnc_model_menu_ekle();
								echo '<form class="main" enctype="multipart/form-data" method="post" action="'.$adres['mevcut'] .'">
										<fieldset>
											<div class="formRow">
								            	<div class="grid2"><label>'.$dil['menu_dil'].'</label></div>
								                <div class="grid10 searchDrop">
								                    <select data-placeholder="'.$dil['dil_secin'].'" class="select" name="menu_dili" style="width:350px;" tabindex="2">
								                        <option value=""></option>'; 
														$sonuclar = gnc_model_diller();
														foreach ($sonuclar AS $sonuc)
								                        	echo '<option value="'.$sonuc['dil_id'].'">'.$sonuc['dil_adi'].'</option>'; 
															
								                    echo '    
								                    </select>
								                 </div>
								                 <div class="clear"></div>
								            </div>
								    		<div class="formRow">
						                        <div class="grid2"><label>'. $dil['menu_adi']. '</label></div>
						                        <div class="grid10"><input type="text" name="menu_adi" value=""/></div>
						                        <div class="clear"></div>
								            </div>
								            <div class="formRow">
						                        <div class="grid2"><label>'. $dil['menu_aciklama']. '</label></div>
						                        <div class="grid10"><textarea name="menu_aciklama" ></textarea></div>
						                        <div class="clear"></div>
								            </div>
								            
								            <div class="formRow">
								            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
						                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
						                    </div>
								        </fieldset>
								        </form>
				          </div>
				          <div class="whead"><h6>'.$dil['menu_elemani_yarat'].'</h6><div class="clear"></div></div>
				          <div class="menu_body">';
						  	gnc_model_menuler_yeni_eleman_yarat();
						  	echo '
				           	<form class="main" enctype="multipart/form-data" method="post" action="'.$adres['mevcut'] .'">
								<fieldset>
									<div class="formRow">
						            	<div class="grid2"><label>'.$dil['menuler'].'</label></div>
						                <div class="grid10 searchDrop">
						                    <select data-placeholder="'.$dil['menu_secin'].'" class="select" name="gnc_yonetim_menu_elemani_menu_id" style="width:350px;" tabindex="2">
						                        <option value=""></option>'; 
												$sonuclar = gnc_model_menuler();
												foreach ($sonuclar AS $sonuc)
						                        	echo '<option value="'.$sonuc['menu_id'].'">'.$sonuc['menu_adi'].'</option>'; 
													
												gnc_model_menuleri_agac_yapisinda_goster();
													
													
						                    echo '    
						                    </select>
						                 </div>
						                 <div class="clear"></div>
						            </div>
						    		<div class="formRow">
				                        <div class="grid2"><label>'. $dil['menu_eleman_adi'] . '</label></div>
				                        <div class="grid10"><input type="text" name="gnc_yonetim_menu_elemani_adi"/></div>
				                        <div class="clear"></div>
						            </div>
						            <div class="formRow">
				                        <div class="grid2"><label>'. $dil['menu_eleman_href'] . '</label></div>
				                        <div class="grid10"><input type="text" name="gnc_yonetim_menu_elemani_href" placeholder="http://"/></div>
				                        <div class="clear"></div>
						            </div>
						            <div class="formRow">
						            	<div class="grid2"><label>'.$dil['menu_eleman_target'].'</label></div>
						                <div class="grid10 searchDrop">
						                    <select data-placeholder="'.$dil['secim_yapin'].'" class="select" name="gnc_yonetim_menu_elemani_target" style="width:350px;" tabindex="2">
						                        <option value="_self">self</option>
						                        <option value="_blank">blank</option>
						                        <option value="_parent">parent</option>
						                        <option value="_top">top</option>
						                    </select>
						                 </div>
						                 <div class="clear"></div>
						            </div>
						            
						            <div class="formRow">
						            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
				                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
				                    </div>
						        </fieldset>
						       </form>   
				          </div>
					    </div>
						<div class="clear"></div> 
					</div>
				</div>
			</div>
		</div>';
}
function dil() 
{
	global $adres, $ayar, $dil, $site, $vt;
	
	echo '<div class="whead">
			<h6>'. $dil['dil_secenekleri'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
	
				$sonuclar = gnc_model_diller();
				foreach ($sonuclar AS $sonuc)
				{
					echo '	<div class="formRow" id="dil_'.$sonuc['dil_id'].'">
							    <div class="grid2"><label>'. ucFirst($sonuc['dil_adi']). ' ('. $sonuc['dil_kodu']. ') </label></div>
							    <div class="grid9 on_off">';												
								if (file_exists('sistem/diller/'.$sonuc['dil_kodu'].'.php'))
									echo '<div class="floatL mr10"><input type="checkbox" name="chbox1" checked="checked" disabled="disabled" />
											<span class="note">'.$dil['dil_dosyası_bulunmaktadır'].'</span>
										  </div>';
								else
									echo '<div class="floatL"><input type="checkbox" name="chbox1" disabled="disabled" />
											<span class="note">'.$dil['dil_dosyası_bulunmamaktadır'].' '.$dil['sitenin_bu_dilde_gosterilebilmesi_icin_uygun_klasore_dil_dosyasini_yukleyin'].'</span>
										  </div>';
						echo '	</div>';
						// Varsayılan çalışma dili değilse sil tuşu, aksi halde indir me tuşu, PHP dosyası direk indirilemeyeceği için indirme sınıfı kullanılmaktadır.
						if ($sonuc['dil_kodu'] != $ayar['varsayilan_calisma_dili'])
							echo '	<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['dil_id'].', \'gnc_yonetim_dil_sil\', \'dil\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>';
						/*
						else
	                    	echo '	<div class="grid1"><a class="tablectrl_small bBlue" href="'.$site['url'].'sistem/diller/'.$ayar['varsayılan_calisma_dili'].'.php" ><span class="iconb">'. $dil['indir'] .'</span></a></div>';
						*/
	                    echo ' 	<div class="clear"></div>
							</div>';
				}
	echo '</div>';
	echo '</div></div></div><div class="wrapper"><div class="fluid"><div class="widget grid12">';
	echo '<div class="whead">
			<h6>'. $dil['dil_ekle'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
				// Yeni bir dil yarat
				gnc_model_dil_ekle();
				echo '<form class="main" enctype="multipart/form-data" method="post" action="'.$adres['mevcut'] .'">
						<fieldset>
				    		<div class="formRow">
		                        <div class="grid2"><label>'. $dil['dil_adi']. '</label><br><span class="note">'.$dil['ornek'].' English</span></div>
		                        <div class="grid2"><input type="text" name="dil_adi" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['dil_kodu']. '</label><br><span class="note">'.$dil['ornek'].' en</span></div>
		                        <div class="grid2"><input type="text" name="dil_kodu" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['dil_dosyasi']. '</label></div>
		                        <div class="grid2"><input type="file" name="dil_dosyasi" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
		                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
		                    </div>
				        </fieldset>
				        </form>';
	echo '</div>';
}
function moduller()
{
	global $adres, $dil, $site, $vt;
	gnc_model_modul_cache_surelerini_duzenle();
	
	echo '<div class="whead">
			<h6>'. $dil['php_dosyalari'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
	
				$sonuclar = gnc_model_moduller();
				foreach ($sonuclar AS $sonuc)
				{
					echo '<div class="formRow" id="modul_'.$sonuc['dosya_id'].'">
	                        <div class="grid1"><label>#'. $sonuc['dosya_id']. '</label></div>
	                        <div class="grid2"><label>'. $sonuc['dosya_adi'].'</label></div>
	                        <div class="grid3 on_off">';
	                        	if ($sonuc['dosya_yayin_durumu'] == 1)
	                        		echo '<div class="floatL mr10"><input type="checkbox" id="check1" checked="checked" onChange="gnc_veri_isle('.$sonuc['dosya_id'].',\'gnc_yonetim_modul_durumunu_degistir\');"/>';
								else
									echo '<div class="floatL mr10"><input type="checkbox" id="check2" onChange="gnc_veri_isle('.$sonuc['dosya_id'].',\'gnc_yonetim_modul_durumunu_degistir\');"/>';
	                        	
	                        	echo '
                            	</div>
	                        </div>
	                        <div class="grid4">
	                        	<input type="text" name="regular" value="'.$sonuc['dosya_izin_durumu'].'"/>
	                        	<span class="note">Dosya izin durumu 0 ise ziyaretçiler dahil herkes, <br>0\'dan büyük ise kullanici_tipi\'ne uygun olarak küçük ve eşit olanlara erişim izni verilerek yetkilendirme yapılmaktadır.</span>
	                        </div>
	                        <div class="grid1"><a rel="'.$site['url'].'ajax/gnc_yonetim_modul_detaylari" title="'. $dil['dosya_adi']  .'" class="tablectrl_small bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['dosya_id'].'" rev="380">'. $dil['cache'] .'</a></div>';
	                 
					 if (!strstr($sonuc['dosya_adi'], 'gnc'))
					   echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['dosya_id'].', \'gnc_yonetim_modul_sil\', \'modul\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>';
	                 
	                 
	                 echo ' <div class="clear"></div>
			              </div>';     
				}			
	echo '</div>';
	echo '</div></div></div><div class="wrapper"><div class="fluid"><div class="widget grid12">';
	echo '<div class="whead">
			<h6>'. $dil['yeni_modul'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
				
				gnc_model_modul_ekle();
				echo '<form class="main" enctype="multipart/form-data" method="post" action="'.$adres['mevcut'] .'">
						<fieldset>
				    		<div class="formRow">
		                        <div class="grid2"><label>'. $dil['modul_adi']. '</label><br></div>
		                        <div class="grid2"><input type="text" name="dosya_adi" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['modul_izin_durumu']. '</label></div>
		                        <div class="grid10 searchDrop">
				                    <select data-placeholder="'.$dil['sec'].'" class="select" name="dosya_izin_durumu" style="width:250px;" tabindex="2">
				                        <option value=""></option>'; 
										$sonuclar = gnc_model_kullanici_tipleri();
										foreach ($sonuclar AS $sonuc)
				                        	echo '<option value="'.$sonuc['kullanici_tip_yetki'].'">'.$dil[$sonuc['kullanici_tip_adi']].' ('.$dil['yetki'].':'.$sonuc['kullanici_tip_yetki'].')</option>'; 
									echo '    
				                    </select>
				                 </div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['modul_gorunum_dosyasi']. '</label></div>
		                        <div class="grid2"><input type="file" name="dosya_gorunum" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['modul_model_dosyasi']. '</label></div>
		                        <div class="grid2"><input type="file" name="dosya_model" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['modul_sql_dosyasi']. '</label></div>
		                        <div class="grid2"><input type="file" name="dosya_sql" value=""/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['dosya_gorunum_cache']. '</label></br><span class="note">'.$dil['cache_bilgi'].'</span></div>
		                        <div class="grid2"><input type="text" name="dosya_gorunum_cache" value="0"/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['dosya_model_cache']. '</label></br><span class="note">'.$dil['cache_bilgi'].'</span></div>
		                        <div class="grid2"><input type="text" name="dosya_model_cache" value="0"/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['dosya_header_cache']. '</label></br><span class="note">'.$dil['cache_bilgi'].'</span></div>
		                        <div class="grid2"><input type="text" name="dosya_header_cache" value="0"/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
		                        <div class="grid2"><label>'. $dil['dosya_footer_cache']. '</label></br><span class="note">'.$dil['cache_bilgi'].'</span></div>
		                        <div class="grid2"><input type="text" name="dosya_footer_cache" value="0"/></div>
		                        <div class="clear"></div>
				            </div>
				            <div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
		                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
		                    </div>
				        </fieldset>
				        </form>';
	echo '</div>';
}
function yonlendiriciler()
{
	global $adres, $dil, $site, $vt;
	
	echo '<div class="whead">
			<h6>'. $dil['yonlendiriciler'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
				$sonuclar = gnc_model_yonlendiriciler();
				$dosya_adi = '';
				foreach ($sonuclar AS $sonuc)
				{
					echo '<div class="formRow" id="yonlendirici_'.$sonuc['yonlendirici_id'].'">';
						if ($sonuc['dosya_adi'] != $dosya_adi)
		                	echo '	<div class="grid2"><label><span class="icon-code"></span>'. $sonuc['dosya_adi']. '</label></div>
		                  			<div class="grid2"><a id="'. $sonuc['dosya_id'] .'" rel="'.$site['url'].'ajax/gnc_yonetim_yonlendirici_yeni_yonlendirici_ekleme_penceresi" title="'. $dil['yeni_yonlendirici']  .'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" >'. $dil['yeni_yonlendirici_ekle'] .'</a></div>';
						else
						  	echo '	<div class="grid4"><label> </label></div>';
					  
					  	if (!empty($sonuc['yonlendirici_sef']))
					  		echo '	<div class="grid1"><label>'. $sonuc['dil_adi'].' ('. $sonuc['dil_kodu'].')</label></div>
	                      	  		<div class="grid6"><label><span class="icon-arrow"></span><a href="'.$site['url'].''.$sonuc['yonlendirici_sef'].'">'. $sonuc['yonlendirici_sef'].'</a></label></div>';
					  	else
					  		echo '	<div class="grid7"><label> </label></div>';
						
	                  	if (!strstr($sonuc['dosya_adi'], 'gnc'))
					  		echo '	<div class="grid1"><a class="tablectrl_medium bRed" href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['yonlendirici_id'].', \'gnc_yonetim_yonlendirici_sil\', \'yonlendirici\');" ><span class="iconb">'. $dil['sil'] .'</span></a></div>';
	                  		echo '	<div class="clear"></div>
			              </div>';    
					
					$dosya_adi = $sonuc['dosya_adi']; 
				}	
				
	echo '</div>';	
}
function cache_klasorunu_temizle(){
	global $dil;
	
	echo '<!-- Main content -->
		  <div class="wrapper">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['menu']['cache-temizle'] .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">
	 					<div class="formRow">
	                        <div class="grid12"><label>'. $dil['cache_klasoru_temizlendi'] . '</label></div>
	                        <div class="clear"></div>     
	                    </div>
					</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
	@gnc_cache_klasorunu_temizle();	
}
function icerikler(){
	global $adres, $dil;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    					
			        <!-- Yönetim sayfasına ait hoşgeldin mesajı -->
			        <div class="widget grid12">';
				
				// İçerik & Kategori sayfasının seçim yapılmamış hali
				if (empty($adres['url1']))
				{								
					echo '<div class="whead">
							<h6>'. $dil['icerikler'] .'</h6>
							<div class="clear"></div>
						  </div>
						  <div class="body">
							'. $dil['icerikler_bilgi'] .'
						  
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="icerikler/kategoriler">'.$dil['kategoriler'] .'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="icerikler/yeni-kategori">'.$dil['yeni_kategori'] .'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bGreen first" title="" href="icerikler/icerik">'.$dil['icerikler'] .'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bGreen first" title="" href="icerikler/yeni-icerik">'.$dil['yeni_icerik'] .'</a>
									</div>
								</div>
							</div>						  	
						  </div>';
					echo '</div></div></div><div class="wrapper"><div class="fluid"><div class="widget grid12">';
					// Şablonlar
					echo '<div class="whead">
							<h6>'. $dil['sablonlar'] .'</h6>
							<div class="clear"></div>
						  </div>
						  <div class="body">
							'. $dil['sablonlar_bilgi'] .'
						  
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="icerikler/sablonlar">'.$dil['sablonlar'] .'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="icerikler/yeni-sablon">'.$dil['yeni_sablon'] .'</a>
									</div>
								</div>
							</div>
						  	
						  </div>';
					echo '</div></div></div><div class="wrapper"><div class="fluid"><div class="widget grid12">';
					// Diğer veriler
					echo '<div class="whead">
							<h6>'. $dil['veritabani_diger_veriler'] .'</h6>
							<div class="clear"></div>
						  </div>
						  <div class="body">
							'. $dil['veritabani_diger_veriler_bilgi'] .'
						  
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="icerikler/ulkeler">'.$dil['ulkeler'] .'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="icerikler/yeni-ulke">'.$dil['yeni_ulke'] .'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bGreen first" title="" href="icerikler/iller">'.$dil['iller'] .'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bGreen first" title="" href="icerikler/yeni-il">'.$dil['yeni_il'] .'</a>
									</div>
								</div>
							</div>
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bBlue first" title="" href="icerikler/universiteler">'.$dil['universiteler'] .'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bBlue first" title="" href="icerikler/yeni-universite">'.$dil['yeni_universite'] .'</a>
									</div>
								</div>
							</div>
						  	
						  </div>';
				}	
				else{
					$adres['url1'] = str_replace('-', '_', $adres['url1']);
					if (function_exists($adres['url1']))
						$adres['url1']();
				}		
			  echo '</div>
			        <div class="clear"></div>
			    </div>				    
			</div>';
}
function kategoriler()
{
	global $dil, $site, $vt;
	
	gnc_model_kategori_detaylarini_duzenle();
	
	$sonuclar = gnc_model_kategoriler();
	echo '<div class="whead">
            <div class="whead"><h6>'.$dil['kategoriler'].'</h6><div class="clear"></div></div>
            <div id="dyn" class="hiddenpars">
                <a class="tOptions" title="Options"><img src="'.$site['url'].'sistem/gorunum/yonetim/tasarim/images/icons/options" alt="" /></a>
                
                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
	                <thead>
		                <tr>
			                <th>'. $dil['kategori_adi'] .'</th>
			                <th>'. $dil['ust_kategorinin_adi'] .'</th>
			                <th>'. $dil['dil'] .'</th>
			                <th>'. $dil['islemler'] .' </th>
		                </tr>
	                </thead>
	                <tbody>';
						foreach ($sonuclar AS $sonuc){
							echo '	<tr class="gradeX" id="kategori_'.$sonuc['kategori_id'].'">
										<td>'.$sonuc['kategori_adi'].'</td>
										<td>'.$sonuc['ust_kategorinin_adi'].'</td>
										<td>'.$sonuc['dil_adi'].'</td>
										<td class="center">
											<a rel="'.$site['url'].'ajax/gnc_yonetim_kategori_detaylari" title="'. $dil['kategori_detaylari']  .'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['kategori_id'].'" rev="380">'. $dil['detaylar'] .'</a>
											<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['kategori_id'].', \'gnc_yonetim_kategori_sil\', \'kategori\');" title="'. $dil['sil']  .'" class="buttonM bRed ml10" style="color:#fff">'. $dil['sil'] .'</a>
					                    </td>
									</tr>';
						}
			            echo '
		            </tbody>
                </table> 
            </div>
            <div class="clear"></div> 
		</div>';
}
function kategorileri_sirala(){
	global $dil, $vt;
	
	echo '<div class="whead">
			<h6>'. $dil['kategoriler'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">
			<div class="formRow">
            	<div class="grid2"><label>'.$dil['dil'].'</label></div>
                <div class="grid10 searchDrop">
                    <select data-placeholder="'.$dil['dil_secin'].'" class="select" id="gnc_yonetim_kategori_dil" style="width:350px;" tabindex="2">
                        <option value=""></option>'; 
						$sonuclar = gnc_model_diller();
						foreach ($sonuclar AS $sonuc)
                        	echo '<option value="'.$sonuc['dil_id'].'">'.$sonuc['dil_adi'].'</option>'; 
							
						gnc_model_kategorileri_agac_yapisinda_goster();
							
							
                    echo '    
                    </select>
                    <span class="note">'. $dil['dil_secimi_bilgi'] .'</span>
                 </div>
                 <div class="clear"></div>
            </div>
            
            <div id="gnc_yonetim_kategori_dil_secildi"></div>
		  </div>';
}
function yeni_kategori(){
	global $adres, $dil, $site, $vt;
	
	echo '<div class="whead">
			<h6>'. $dil['yeni_kategori'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
		
		gnc_model_kategoriler_yeni_kategori_ekle();
		echo '<form class="main" method="post" action="'.$adres['mevcut'] .'">
				<fieldset>
				
			    	<div class="formRow">
                        <div class="grid2"><label>'. $dil['kategori_adi']. ':</label></div>
                        <div class="grid10"><input type="text" name="kategori_adi"/></div>
                        <div class="clear"></div>
		            </div> 
		            <div class="formRow">
                        <div class="grid2"><label>'. $dil['resim']. ':</label></div>
                        <div class="grid10"><input type="file" name="kategori_resmi"/></div>
                        <div class="clear"></div>
		            </div> 
		            <div class="formRow">
		            	<div class="grid2"><label>'.$dil['dil'].'</label></div>
                        <div class="grid4 searchDrop">
                            <select data-placeholder="'.$dil['dil_secin'].'" class="select" id="gnc_yonetim_yeni_kategori_dil" name="kategori_dil_id" style="width:350px;" tabindex="2">
                                <option value=""></option>'; 
								$sonuclar = gnc_model_diller();
								foreach ($sonuclar AS $sonuc)
                                	echo '<option value="'.$sonuc['dil_id'].'">'.$sonuc['dil_adi'].'</option>'; 
                            echo '    
                            </select>
                            <span class="note">'. $dil['dil_secimi_bilgi'] .'</span>
                         </div>
                         <div class="clear"></div>
		            </div>
		            
		            <div id="gnc_yonetim_yeni_kategori_ekle_dil_secildi"></div>
			        
					<div class="formRow">
                        <div class="grid2"><label>'. $dil['siralama']. ':</label></div>
                        <div class="grid10"><input type="text" name="kategori_sira"/></div>
                        <div class="clear"></div>
		            </div> 
		            
					<div class="formRow">
		            	<div class="grid2"><label>'.$dil['yetki'].'</label></div>
                        <div class="grid4 searchDrop">
                            <select data-placeholder="'.$dil['kullanıcı_tipi'].'" name="kullanici_tipi" class="select" style="width:100%;" tabindex="2">';
		                        $tipler = gnc_model_kullanici_tipleri();
								foreach ($tipler AS $tip)
		                        	echo '<option value="'.$tip['kullanici_tip_yetki'].'">'.$dil[$tip['kullanici_tip_adi']].' ('.$dil['yetki'].':'.$tip['kullanici_tip_yetki'].')</option>';
							echo '    
		                    </select>
                            <span class="note">'. $dil['yeni_kategori_kullanici_yetkilendirme_bilgi'] .'</span>
                         </div>
                         <div class="clear"></div>
		            </div>
		            
					<div class="formRow">
				    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
		            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
					</div>
					
				</fieldset>
			</form>';
	echo '</div>';
}
function icerik(){
	global $adres, $dil, $site, $vt;
	
		  // İçeriğin sef'i boşsa dil seçimi ve uygun içeriklerin kategorilere göre sıralanması
		  if (empty($adres['url2'])){
		  	echo '
		            <div class="whead"><h6>'.$dil['kullanıcı_listesi'].'</h6><div class="clear"></div></div>
		            <div id="dyn" class="hiddenpars">
		                <a class="tOptions" title="Options"><img src="'.$site['url'].'sistem/gorunum/yonetim/tasarim/images/icons/options" alt="" /></a>
		                
		                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
			                <thead>
				                <tr>
					                <th>'. $dil['icerik_basligi'] .'</th>
					                <th>'. $dil['kullanıcı_adi'] .'</th>
					                <th>'. $dil['kategori'] .' </th>
					                <th>'. $dil['dil'] .' </th>
					                <th>'. $dil['siralama'] .' </th>
					                <th>'. $dil['tarih'] .' </th>
					                <th>'. $dil['islemler'] .' </th>
				                </tr>
			                </thead>
			                <tbody>';
								$sonuclar = gnc_model_icerikler();
								
								foreach ($sonuclar AS $sonuc){
									echo '<tr class="gradeX" id="icerik_'.$sonuc['icerik_id'].'">
											<td style="min-width:200px;">'.$sonuc['icerik_baslik'].'</td>
					                	  	<td>'.$sonuc['kullanici_kullanici_adi'].' </td>
					                	  	<td>'.$sonuc['kategori_adi'].' </td>
					                	  	<td>'.$sonuc['dil_adi'].'  </td>
					                	  	<td>'.$sonuc['icerik_sira'].'  </td>
					                	  	<td>'.$sonuc['icerik_tarih'].' </td>
					                	  	<td class="center">
					                	  		<!--
					                	  		<a href="javascript:void(0);" rel="'.$site['url'].'ajax/gnc_model_icerik_detaylari" title="'. $dil['detaylar']  .'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['icerik_id'].'">'. $dil['detaylar'] .'</a>
					                      		-->
					                      		<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['icerik_id'].', \'gnc_yonetim_icerik_sil\', \'icerik\');" title="'. $dil['sil']  .'" class="buttonM bRed ml10">'. $dil['sil'] .'</a>
					                      		<a href="'.$adres['mevcut'].'/'.$sonuc['icerik_sef'].'" title="'. $dil['goster']  .'" class="buttonM bBlue ml10">'. $dil['goster'] .'</a>
					                      	</td>
					                      </tr>';
								}
					                
					            echo '
				            </tbody>
		                </table> 
		            </div>
		            <div class="clear"></div>';	
		  }
		  else 
		  {
				$sonuclar = gnc_model_icerikler($adres['url2']);
				echo '<div class="whead">
						<h6>'. $dil['icerik'] .'</h6>
						<div class="clear"></div>
					  </div>
					  <div class="body">';
				foreach ($sonuclar AS $sonuc)
				{
					//print_r($sonuc);
					echo '	<form action="" class="main">
								<input type="hidden" id="gnc_icerik_id" value="'.$sonuc['icerik_id'].'"/>
								<fieldset>';
													
													/*
													if (isset($sonuc['buyuk_resim_yolu']))
													echo '<div class="formRow">
															<div class="grid12" style="word-wrap: break-word;"><img src="'.$site['url'].''.$site['dosya_yuklenecek_adres'] .''.$sonuc['buyuk_resim_yolu'].'"></div>
												            <div class="clear"></div>     
												          </div>';
													if (isset($sonuc['kucuk_resim_yolu']))
													echo '<div class="formRow">
															<div class="grid12" style="word-wrap: break-word;"><img src="'.$site['url'].''.$site['dosya_yuklenecek_adres'] .''.$sonuc['kucuk_resim_yolu'].'"></div>
												            <div class="clear"></div>     
												          </div>';
													*/
													echo '	<div class="formRow">
																<div class="grid2">'.$dil['icerik_basligi'].'</div>
																<div class="grid10"><input type="text" id="gnc_icerik_baslik" value="'.$sonuc['icerik_baslik'].'"/></div>
												            	<div class="clear"></div>     
												          	</div>
												          	<div class="formRow">
																<div class="grid2">'.$dil['icerik_ozeti'].'</div>
																<div class="grid10"><textarea  id="gnc_icerik_ozet">'.$sonuc['icerik_ozet'].'</textarea></div>
												            	<div class="clear"></div>     
												          	</div>
															<div class="formRow">
																<div class="grid2">'.$dil['icerik_metni'].'</div>
																<div class="grid10"><textarea class="ckeditor" id="ckeditor" name="editor" rows="20" cols="80">'.$sonuc['icerik_icerik'].'</textarea></div>
																<div class="clear"></div>     
												          	</div>';
															$icerigin_kategorileri = gnc_model_iceriklerin_kategorileri($sonuc['icerik_id']);
															$kategoriler = gnc_model_kategoriler($sonuc['dil_id']);
															echo '
												          	<div class="formRow" style="height:300px;">
												                <div class="grid2"><label>'. $dil['kategori'] .'</label></div>
												                <div class="grid10">
												                    <select multiple="multiple" class="multiple" title="" id="gnc_yonetim_yeni_icerik_kategori" style="height:280px;">';
																		// Seçili kategorileri seçili olarak işaretle
																		foreach ($kategoriler AS $kategori)
																		{
																			if (!empty($icerigin_kategorileri))
																			{
																				foreach ($icerigin_kategorileri AS $icerigin_kategorisi)
																				{
																					if ($kategori['kategori_id'] == $icerigin_kategorisi['kategori_id'])
																						$selected = 'selected';
																					else
																						$selected = '';
																				}	
																			}
																			else
																			{
																				$selected = '';	
																			}
																			echo '<option value="'.$kategori['kategori_id'].'" '.$selected.'>'.$kategori['kategori_adi'].'</option>';
															        	}
															        echo '    
																	</select>
																</div>
															</div>';
															$benzer_icerikler = gnc_model_iceriklerin_benzer_icerikler($sonuc['icerik_id'], 0);
															echo '
															<div class="formRow" style="height:360px;">
												            	<div class="grid2"><label>'. $dil['benzer_icerikler'] .'</label></div>
												            	<div class="grid10 searchDrop">
												            		<div class="leftBox">
												                        <input type="text" id="box1Filter" class="boxFilter" placeholder="'.$dil['filtreleyin'].'..." /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />
												                        
												                        <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">';
												                        // Seçili içerikleri seçili olarak işaretle
												                        foreach ($benzer_icerikler AS $benzer_icerik){
																			echo '<option value="'.$benzer_icerik['icerik_id'].'">'.$benzer_icerik['icerik_baslik'].'</option>';
												                        }
												                        	
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
												                        <select id="box2View" multiple="multiple" class="multiple" style="height:300px;">';
												                        // Seçili içerikleri seçili olarak işaretle
												                        $benzer_icerikler = gnc_model_iceriklerin_benzer_icerikler($sonuc['icerik_id'], 1);
																		foreach ($benzer_icerikler AS $benzer_icerik)
												                        	echo '<option value="'.$benzer_icerik['icerik_id'].'">'.$benzer_icerik['icerik_baslik'].'</option>';
												                        
																		echo '
												                        </select><br/>
												                        <!-- <span id="box2Counter" class="countLabel"></span> -->
												                        
												                        <div class="displayNone"><select id="box2Storage"></select></div>
												                    </div>';
												                    echo '
												                    <div class="clear"></div>
												            	</div>
												            </div>';
													$sablonlar = gnc_model_iceriklerin_sablonlari($sonuc['icerik_id']);
													if (!empty($sablonlar))
													{
														foreach ($sablonlar AS $sablon)
														{
															//[iceriklerin_sablonlari_id] => 5 [icerik_id] => 27 [sablon_id] => 1 [sablon_icerik_id] => 1 [sablon_icerik_degeri] => 130cm [sablon_icerik_adi] => En [sablon_icerik_aciklama] => Ürünün eni
															echo '	<div class="formRow">
																		<div class="grid2">'.$sablon['sablon_icerik_adi'].'</div>
																		<div class="grid10"><input type="text" id="'.$sablon['iceriklerin_sablonlari_id'].'" class="icerik_sablonu" value="'.$sablon['sablon_icerik_degeri'].'"/></div>
														            	<div class="clear"></div>     
														          	</div>';	 
														}
													}
									?>
									<script type="text/javascript">
										function BrowseServer(startupPath, functionData)
										{
											// You can use the "CKFinder" class to render CKFinder in a page:
											var finder = new CKFinder();
											// The path for the installation of CKFinder (default = "/ckfinder/").
											finder.basePath = '../';
											//Startup path in a form: "Type:/path/to/directory/"
											finder.startupPath = startupPath;
											// Name of a function which is called when a file is selected in CKFinder.
											finder.selectActionFunction = SetFileField;
											// Additional data to be passed to the selectActionFunction in a second argument.
											// We'll use this feature to pass the Id of a field that will be updated.
											finder.selectActionData = functionData;
											// Name of a function which is called when a thumbnail is selected in CKFinder.
											finder.selectThumbnailActionFunction = ShowThumbnails;
											// Launch CKFinder
											finder.popup();
										}
										// This is a sample function which is called when a file is selected in CKFinder.
										function SetFileField(fileUrl, data)
										{
											var sFileName = this.getSelectedFile().name;
											var sFileFolder = this.getSelectedFile().folder;
											text = sFileFolder+sFileName;
											text = text.substr(1);
											
											document.getElementById(data["selectActionData"] ).value = text;
										}
										// This is a sample function which is called when a thumbnail is selected in CKFinder.
										function ShowThumbnails(fileUrl, data)
										{
											// this = CKFinderAPI
											var sFileName = this.getSelectedFile().name;
											document.getElementById( 'thumbnails' ).innerHTML +=
													'<div class="thumb">' +
														'<img src="' + fileUrl + '" />' +
														'<div class="caption">' +
															'<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
														'</div>' +
													'</div>';
											document.getElementById( 'preview' ).style.display = "";
											// It is not required to return any value.
											// When false is returned, CKFinder will not close automatically.
											return false;
										}
										</script>
									<?php
									
						            echo '	<!-- CK Finder ile içeriğe resim belirleme -->
											<div class="formRow">
								            	<div class="grid2"><label>'.$dil['buyuk_resim'].'</label></div>
					                            <div class="grid10">
					                            	<div class="grid1">
					                                	<a class="buttonS bBlack first" onclick="BrowseServer( \'Images:/\', \'gnc_ckfinder_ile_dosya_yukle\' );">'.$dil['resim'].'</a>
					                                </div> 
					                                <div class="grid11">
					                                	<input id="gnc_ckfinder_ile_dosya_yukle" name="FilePath" type="text" size="60" value="'.$sonuc['icerik_buyuk_resim_id'].'"/>
													</div>
					                             </div>
					                             <div class="clear"></div>
								            </div>
								            <div class="formRow">
								            	<div class="grid2"><label>'.$dil['kucuk_resim'].'</label></div>
					                            <div class="grid10">
					                            	<div class="grid1">
					                                	<a class="buttonS bBlack first" onclick="BrowseServer( \'Images:/\', \'gnc_ckfinder_ile_dosya_yukle_2\' );">'.$dil['resim'].'</a>
					                                </div>
					                                <div class="grid11">
					                                	<input id="gnc_ckfinder_ile_dosya_yukle_2" name="FilePath" type="text" size="60" value="'.$sonuc['icerik_kucuk_resim_id'].'"/>
												    </div>
					                             </div>
					                             <div class="clear"></div>
								            </div>';
									
									
									echo '	<!-- AJAX Dosya yükleme, dosya seçildiği anda yüklenir 
											<div class="formRow">
								            	<div class="grid2"><label>'.$dil['resim'].'</label></div>
								            	<div class="grid5"><img id="gnc_icerik_buyuk_resim" src="'.$site['url'].$site['dosya_yuklenecek_adres'].$sonuc['buyuk_resim_yolu'].'"/></div>
								            	<div class="grid5">
					                                <input type="file" name="images" id="gnc_ajax_ile_dosya_yukle" />
					                             </div>
					                             <div class="clear"></div>
								            </div>
											<div class="formRow">
								            	<div class="grid2"><label>'.$dil['resim'].'</label></div>
								            	<div class="grid5"><img id="gnc_icerik_buyuk_resim" src="'.$site['url'].$site['dosya_yuklenecek_adres'].$sonuc['kucuk_resim_yolu'].'"/></div>
								            	<div class="grid5">
					                                <input type="file" name="images_2" id="gnc_ajax_ile_dosya_yukle_2" />
					                             </div>
					                             <div class="clear"></div>
								            </div>
								            <div class="formRow dosya_yuklendi none">
								            	<div class="grid1"><div id="response"></div></div>
					                            <div class="grid1"><div id="response_2"></div></div>
					                            
					                            <div class="grid10 ">
					                            	<div id="image-list"></div>
					                            </div>
					                            <div class="clear"></div>
					                            
					                            <div class="clear"></div>
								            </div>		
								            -->
											
											
											<div class="formRow">
									            <div class="grid2">
													<div class="wButton">
														<a class="buttonL bRed first" title="" href="javascript:void(0)">'.$dil['iptal'] .'</a>
													</div>
												</div>
							                    <div class="grid10">
													<div class="wButton">
														<a class="buttonL bLightBlue first" title="" href="javascript:void(0)" id="gnc_yonetim_icerik_duzenle">'.$dil['kaydet'] .'</a>
													</div>
												</div>
											</div>
							    </fieldset>
							</form>';
				}
				echo '</div>';  
		  }
}
function yeni_icerik(){
	global $dil, $vt;
	// Editor içinden dosya yüklemek için
	require_once('ckeditor/ckupload.php');

	echo '<div class="whead">
			<h6>'. $dil['yeni_icerik'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';

		echo '<form action="" class="main">
				<fieldset>
						<div class="formRow">
	                        <div class="grid2"><label>'. $dil['icerik_basligi'] . '</label></div>
	                        <div class="grid10"><input type="text" id="gnc_yonetim_yeni_icerik_baslik" /></div>
	                        <div class="clear"></div>     
	                    </div>
	                    <div class="formRow">   
	                        <div class="grid2"><label>'. $dil['icerik_metni'] . '</label></div>
	                        <div class="grid10"><textarea class="ckeditor" id="ckeditor" name="editor" rows="10" cols="80"></textarea></div>
	                        <div class="clear"></div>
			            </div>
	                    <div class="formRow">      
	                        <div class="grid2"><label>'. $dil['icerik_ozeti'] . '</label></div>
	                        <div class="grid10"><textarea id="gnc_yonetim_yeni_icerik_ozet"></textarea>
	                        	<span class="note">'. $dil['icerik_ozet_bilgisi'] .'</span>
	                        </div>
	                        <div class="clear"></div>
			            </div>
			            <div class="formRow">
			            	<div class="grid2"><label>'.$dil['dil'].'</label></div>
                            <div class="grid10 searchDrop">
                                <select data-placeholder="'.$dil['dil_secin'].'" class="select" id="gnc_yonetim_yeni_icerik_dil" style="width:350px;" tabindex="2">
                                    <option value=""></option>'; 
									$sonuclar = gnc_model_diller();
									foreach ($sonuclar AS $sonuc)
                                    	echo '<option value="'.$sonuc['dil_id'].'">'.$sonuc['dil_adi'].'</option>'; 
                                echo '    
                                </select>
                                <span class="note">'. $dil['dil_secimi_bilgi'] .'</span>
                             </div>
                             <div class="clear"></div>
			            </div>
			            
			            <div id="gnc_yonetim_yeni_icerik_ekle_dil_secildi"></div>';
						?>
						<script type="text/javascript">
							function BrowseServer(startupPath, functionData)
							{
								// You can use the "CKFinder" class to render CKFinder in a page:
								var finder = new CKFinder();
								// The path for the installation of CKFinder (default = "/ckfinder/").
								finder.basePath = '../';
								//Startup path in a form: "Type:/path/to/directory/"
								finder.startupPath = startupPath;
								// Name of a function which is called when a file is selected in CKFinder.
								finder.selectActionFunction = SetFileField;
								// Additional data to be passed to the selectActionFunction in a second argument.
								// We'll use this feature to pass the Id of a field that will be updated.
								finder.selectActionData = functionData;
								// Name of a function which is called when a thumbnail is selected in CKFinder.
								finder.selectThumbnailActionFunction = ShowThumbnails;
								// Launch CKFinder
								finder.popup();
							}
							// This is a sample function which is called when a file is selected in CKFinder.
							function SetFileField(fileUrl, data)
							{
								var sFileName = this.getSelectedFile().name;
								var sFileFolder = this.getSelectedFile().folder;
								text = sFileFolder+sFileName;
								text = text.substr(1);
								
								document.getElementById(data["selectActionData"] ).value = text;
							}
							// This is a sample function which is called when a thumbnail is selected in CKFinder.
							function ShowThumbnails(fileUrl, data)
							{
								// this = CKFinderAPI
								var sFileName = this.getSelectedFile().name;
								document.getElementById( 'thumbnails' ).innerHTML +=
										'<div class="thumb">' +
											'<img src="' + fileUrl + '" />' +
											'<div class="caption">' +
												'<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
											'</div>' +
										'</div>';
								document.getElementById( 'preview' ).style.display = "";
								// It is not required to return any value.
								// When false is returned, CKFinder will not close automatically.
								return false;
							}
							</script>
						<?php
						
			            echo '
						<!-- CK Finder ile içeriğe resim belirleme -->
						<div class="formRow">
			            	<div class="grid2"><label>'.$dil['buyuk_resim'].'</label></div>
                            <div class="grid10">
                            	<div class="grid1">
                                	<a class="buttonS bBlack first" onclick="BrowseServer( \'Images:/\', \'gnc_ckfinder_ile_dosya_yukle\' );">'.$dil['resim'].'</a>
                                </div> 
                                <div class="grid11">
                                	<input id="gnc_ckfinder_ile_dosya_yukle" name="FilePath" type="text" size="60" />
								</div>
                             </div>
                             <div class="clear"></div>
			            </div>
			            <div class="formRow">
			            	<div class="grid2"><label>'.$dil['kucuk_resim'].'</label></div>
                            <div class="grid10">
                            	<div class="grid1">
                                	<a class="buttonS bBlack first" onclick="BrowseServer( \'Images:/\', \'gnc_ckfinder_ile_dosya_yukle_2\' );">'.$dil['resim'].'</a>
                                </div>
                                <div class="grid11">
                                	<input id="gnc_ckfinder_ile_dosya_yukle_2" name="FilePath" type="text" size="60" />
							    </div>
                             </div>
                             <div class="clear"></div>
			            </div>
			            <div id="preview" style="display:none">
							<strong>Selected Thumbnails</strong><br/>
							<div id="thumbnails"></div>
						</div>
						
						
						
						
						
						
						<!-- AJAX Dosya yükleme, dosya seçildiği anda yüklenir 
						<div class="formRow">
			            	<div class="grid2"><label>'.$dil['resim'].'</label></div>
                            <div class="grid10">
                                <input type="file" name="images" id="gnc_ajax_ile_dosya_yukle" />
                                <span class="note">'. $dil['icerik_resim_bilgi'] .'</span>
                             </div>
                             <div class="clear"></div>
			            </div>
						-->
						<!-- AJAX Dosya yükleme, dosya seçildiği anda yüklenir 
						<div class="formRow">
			            	<div class="grid2"><label>'.$dil['resim'].'</label></div>
                            <div class="grid10">
                                <input type="file" name="images_2" id="gnc_ajax_ile_dosya_yukle_2" />
                                <span class="note">'. $dil['icerik_resim_bilgi'] .'</span>
                             </div>
                             <div class="clear"></div>
			            </div>
			            -->
						<!--
						<div class="formRow dosya_yuklendi none">
			            	<div class="grid1"><div id="response"></div></div>
                            <div class="grid1"><div id="response_2"></div></div>
                            
                            <div class="grid10 ">
                            	<div id="image-list"></div>
                            </div>
                            <div class="clear"></div>
                            
                            <div class="clear"></div>
			            </div>				
						-->
						
						<div class="formRow">
	                        <div class="grid2"><label>'. $dil['siralama'] . '</label></div>
	                        <div class="grid10"><input type="text" id="gnc_yonetim_yeni_icerik_sira" /></div>
	                        <div class="clear"></div>     
	                    </div>
			            <div class="formRow">
				            <div class="grid2">
								<div class="wButton">
									<a class="buttonL bRed first" title="" href="javascript:void(0)">'.$dil['iptal'] .'</a>
								</div>
							</div>
		                    <div class="grid10">
								<div class="wButton">
									<a class="buttonL bLightBlue first" title="" href="javascript:void(0)" id="gnc_yonetim_yeni_icerik_ekle">'.$dil['kaydet'] .'</a>
								</div>
							</div>
						</div>
			    </fieldset>
			</form>';

	echo '</div>';
}
function sablonlar(){
	global $adres, $dil, $site, $vt;
	
	// Şablonlar
	echo '
	        <div class="whead"><h6>'.$dil['sablonlar'].'</h6><div class="clear"></div></div>
	        <div id="dyn" class="hiddenpars">
	            <a class="tOptions" title="Options"><img src="'.$site['url'].'sistem/gorunum/yonetim/tasarim/images/icons/options" alt="" /></a>
	            
	            <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
	                <thead>
		                <tr>
			                <th>'. $dil['sablon_adi'] .'</th>
			                <th>'. $dil['sablon_aciklama'] .' </th>
			                <th>'. $dil['dil'] .' </th>
			                <th>'. $dil['islemler'] .' </th>
		                </tr>
	                </thead>
	                <tbody>';
						
						$sonuclar = gnc_model_sablonlar();
						if (!empty($sonuclar))
						{
							foreach ($sonuclar AS $sonuc)
							{
								echo '<tr class="gradeX" id="sablon_'.$sonuc['sablon_id'].'">
										<td>'.$sonuc['sablon_adi'].' </td>
				                	  	<td>'.$sonuc['sablon_aciklama'].' </td>
				                	  	<td>'.$sonuc['dil_adi'].'  </td>
				                	  	<td class="center">
				                	  		<a href="javascript:void(0);" rel="'.$site['url'].'ajax/gnc_yonetim_sablon_detaylari" title="'. $dil['detaylar']  .'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['sablon_id'].'">'. $dil['detaylar'] .'</a>
				                      		<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['sablon_id'].', \'gnc_yonetim_sablon_sil\', \'sablon\');" title="'. $dil['sil']  .'" class="buttonM bRed ml10">'. $dil['sil'] .'</a>
				                      	</td>
				                      </tr>';
							}	
						}
						echo '
		            </tbody>
	            </table> 
	        </div>
	        <div class="clear"></div>';	
}
function yeni_sablon(){
	global $adres, $dil, $vt;
	
	
	echo '<div class="whead">
			<h6>'. $dil['yeni_sablon'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
		
		gnc_model_sablonlar_yeni_sablon_ekle();
		echo '<form class="main" method="post" action="'.$adres['mevcut'] .'">
				<fieldset>
						<div class="formRow">
	                        <div class="grid2"><label>'. $dil['sablon_adi'] . '</label></div>
	                        <div class="grid10"><input type="text" id="gnc_yonetim_yeni_sablon_adi" name="gnc_yonetim_yeni_sablon_adi"/></div>
	                        <div class="clear"></div>     
	                    </div>
	                    <div class="formRow">
			            	<div class="grid2"><label>'.$dil['dil'].'</label></div>
                            <div class="grid10 searchDrop">
                                <select data-placeholder="'.$dil['dil_secin'].'" class="select" name="gnc_yonetim_yeni_sablon_dil" style="width:350px;" tabindex="2">
                                    <option value=""></option>'; 
									$sonuclar = gnc_model_diller();
									foreach ($sonuclar AS $sonuc)
                                    	echo '<option value="'.$sonuc['dil_id'].'">'.$sonuc['dil_adi'].'</option>'; 
                                echo '    
                                </select>
                             </div>
                             <div class="clear"></div>
			            </div>
			            <div class="formRow">
	                        <div class="grid2"><label>'. $dil['sablon_aciklama'] . '</label></div>
	                        <div class="grid10"><textarea id="gnc_yonetim_yeni_sablon_aciklama" name="gnc_yonetim_yeni_sablon_aciklama"></textarea></div>
	                        <div class="clear"></div>     
	                    </div>
	                    
	                    <div class="nNote nInformation">
							<p>'.$dil['sablona_alan_adi_elemani_ekleme_bilgisi'].'</p>
						</div>
						
	                    <div class="formRow">
	                    
	                        <div class="grid2"><label class="alan_adi">'. $dil['alan_adi'] . '</label></div>
	                        <div class="grid2"><input type="text" class="sablon_alan_adi" name="gnc_yonetim_yeni_sablon_alani_1" placeholder="'. $dil['alan_adi'] . '"/></div>
	                        <div class="grid6"><input type="text" class="sablon_alan_aciklama" name="gnc_yonetim_yeni_sablon_aciklama_1" placeholder="'. $dil['alan_aciklamasi'] . '"/></div>
	                        <div class="grid2">
								<div class="">
									<a class="sablona_yeni_alan_ekle buttonS bGreen first" title="" href="javascript:void(0)">'.$dil['yeni_alan'] .'</a>
									<a style="display:none;" class="sablona_yeni_alan_sil buttonS bRed first" title="" href="javascript:void(0)">'.$dil['sil'] .'</a>
								</div>
							</div>	
							
	                        <div class="clear"></div>     
	                    </div>
						<div id="sablon_alanlari"></div>
						
						<div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
		                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
						</div>
						
			    </fieldset>
			</form>';

	echo '</div>';
}
function yeni_ulke(){
	global $adres, $dil, $vt;
	
	
	echo '<div class="whead">
			<h6>'. $dil['yeni_ulke'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
		
		gnc_model_yeni_ulke_ekle();
		echo '<form class="main" method="post" action="'.$adres['mevcut'] .'">
				<fieldset>
					<div class="formRow">
		            	<div class="grid2"><label>'.$dil['kitalar'].'</label></div>
                        <div class="grid10 searchDrop">
                            <select data-placeholder="'.$dil['kita_secin'].'" name="kita_id" class="select" style="width:350px;" tabindex="2">
                                <option value=""></option>'; 
								$sonuclar = gnc_model_kitalar();
								foreach ($sonuclar AS $sonuc)
                                	echo '<option value="'.$sonuc['kita_id'].'">'.$sonuc['kita_adi'].'</option>'; 
                            echo '    
                            </select>
                         </div>
                         <div class="clear"></div>
		            </div>
					<div class="formRow">
                        <div class="grid2"><label>'. $dil['ulke_adi'] . '</label></div>
                        <div class="grid10"><input type="text" name="ulke_adi"/></div>
                        <div class="clear"></div>     
                    </div>
                    <div class="formRow">
			            <input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
	                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
					</div>
				</fieldset>
			</form>';

	echo '</div>';
}
function yeni_il(){
	global $adres, $dil, $vt;
	
	
	echo '<div class="whead">
			<h6>'. $dil['yeni_il'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
		
		//gnc_model_yeni_il_ekle();
		echo '<form class="main" method="post" action="'.$adres['mevcut'] .'">
				<fieldset>
					<div class="formRow">
		            	<div class="grid2"><label>'.$dil['ulkeler'].'</label></div>
                        <div class="grid10 searchDrop">
                            <select data-placeholder="'.$dil['ulke_secin'].'" name="ulke_id" class="select" style="width:350px;" tabindex="2">
                                <option value=""></option>'; 
								$sonuclar = gnc_model_ulkeler();
								foreach ($sonuclar AS $sonuc)
                                	echo '<option value="'.$sonuc['ulke_id'].'">'.$sonuc['ulke_adi'].'</option>'; 
                            echo '    
                            </select>
                         </div>
                         <div class="clear"></div>
		            </div>
					<div class="formRow">
                        <div class="grid2"><label>'. $dil['il_adi'] . '</label></div>
                        <div class="grid10"><input type="text" name="il_adi"/></div>
                        <div class="clear"></div>     
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>'. $dil['il_kodu'] . '</label></div>
                        <div class="grid10"><input type="text" name="il_kodu"/></div>
                        <div class="clear"></div>     
                    </div>
                    <div class="formRow">
			            <input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
	                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
					</div>
				</fieldset>
			</form>';
	echo '</div>';
}
function yeni_universite(){
	global $adres, $dil, $vt;
	
	echo '<div class="whead">
			<h6>'. $dil['yeni_universite'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
		
		//gnc_model_yeni_il_ekle();
		echo '<form class="main" method="post" action="'.$adres['mevcut'] .'">
				<fieldset>
					<div class="formRow">
		            	<div class="grid2"><label>'.$dil['iller'].'</label></div>
                        <div class="grid10 searchDrop">
                            <select data-placeholder="'.$dil['il_secin'].'" name="il_id" class="select" style="width:350px;" tabindex="2">
                                <option value=""></option>'; 
								$sonuclar = gnc_model_iller();
								foreach ($sonuclar AS $sonuc)
                                	echo '<option value="'.$sonuc['il_id'].'">'.$sonuc['il_adi'].'</option>'; 
                            echo '    
                            </select>
                         </div>
                         <div class="clear"></div>
		            </div>
					<div class="formRow">
                        <div class="grid2"><label>'. $dil['universite_adi'] . '</label></div>
                        <div class="grid10"><input type="text" name="uni_adi"/></div>
                        <div class="clear"></div>     
                    </div>
                    <div class="formRow">
		            	<div class="grid2"><label>'.$dil['iller'].'</label></div>
                        <div class="grid10 searchDrop">
                            <select data-placeholder="'.$dil['il_secin'].'" name="il_id" class="select" style="width:350px;" tabindex="2">';
                                for ($i=date('Y'); $i>1700; $i--)
                                	echo '<option value="'.$i.'">'.$i.'</option>'; 
                            echo '    
                            </select>
                         </div>
                         <div class="clear"></div>
		            </div>
                    <div class="formRow">
                        <div class="grid2"><label>'. $dil['universite_eposta_adresi'] . '</label><br><span class="note">'.$dil['ornek'].' odtu.edu.tr</span></div>
                        <div class="grid10"><input type="text" name="uni_eposta"/></div>
                        <div class="clear"></div>     
                    </div>
                    <div class="formRow">
			            <input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
	                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
					</div>
				</fieldset>
			</form>';
	echo '</div>';
}
function albumler(){
	global $adres, $dil, $site, $vt;
	
	echo '<!-- Main content -->
		  <div class="wrapper">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['albumler'] .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">
					
						<ul class="middleNavS" style="margin-top:10px; margin-bottom:20px;">
							<li><a class="tipN" href="javascript:void(0);" original-title="'.$dil['yeni_album'].'" onClick="gnc_yonetim_yeni_album();""><img alt="" src="'.$site['url'].'sistem/gorunum/yonetim/tasarim/images/icons/middlenav/add.png"><br>'.$dil['yeni_album'].'</a></li>';
							
							$sonuclar = gnc_model_albumler();
							foreach($sonuclar AS $sonuc)
								echo '<li><a class="tipN" href="javascript:void(0);" original-title="'.$sonuc['album_adi'].'" onClick="gnc_yonetim_secili_albumu_goster('.$sonuc['album_id'].');"><img alt="" src="'.$site['url'].'veri/dosyalar/'.$sonuc['veri_yolu'].'" style="padding:0px;" width="67" height="67"></a></li>';
					
					echo '
						</ul>	
					</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
	
	
	gnc_model_album_ekle();
	echo '<!-- Main content -->
		  <div id="gnc_yonetim_yeni_album" class="wrapper none">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['yeni_album'] .'</h6>
						<div class="titleOpt">
							<a data-toggle="dropdown" onClick="gnc_yonetim_yeni_album_gizle();" href="javascript:void(0);" style="border: none; padding-top:12px;">
								Kapat
								<span class="icon-close"></span>
								<span class="clear"></span>
							</a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="body">
						<form class="main" method="post" action="'.$adres['mevcut'] .'">
							<fieldset>
								<div class="formRow">
			                        <div class="grid2"><label>'. $dil['album_adi'] . '</label></div>
			                        <div class="grid10"><input type="text" id="gnc_yonetim_yeni_album_adi" name="gnc_yonetim_yeni_album_adi" style="height:29px;"/></div>
			                        <div class="clear"></div>     
			                    </div>
			                    <div class="formRow">
			                        <div class="grid2"><label>'. $dil['album_aciklama'] . '</label></div>
			                        <div class="grid10"><textarea id="gnc_yonetim_yeni_album_aciklama" name="gnc_yonetim_yeni_album_aciklama"></textarea></div>
			                        <div class="clear"></div>     
			                    </div>
			                    <div class="formRow">
			                        <div class="grid2"><label>'. $dil['album_thumb_en'] . '</label></div>
			                        <div class="grid10"><input type="text"  id="gnc_yonetim_yeni_album_thumb_en" name="gnc_yonetim_yeni_album_thumb_en" /></div>
			                        <div class="clear"></div>     
			                    </div>
			                    <div class="formRow">
			                        <div class="grid2"><label>'. $dil['album_thumb_boy'] . '</label></div>
			                        <div class="grid10"><input type="text"  id="gnc_yonetim_yeni_album_thumb_boy" name="gnc_yonetim_yeni_album_thumb_boy" /></div>
			                        <div class="clear"></div>     
			                    </div>
								<div class="formRow">
			                        <div class="grid2"><label>'. $dil['album_crop_en'] . '</label></div>
			                        <div class="grid10"><input type="text"  id="gnc_yonetim_yeni_album_crop_en" name="gnc_yonetim_yeni_album_crop_en" /></div>
			                        <div class="clear"></div>     
			                    </div>
			                    <div class="formRow">
			                        <div class="grid2"><label>'. $dil['album_crop_boy'] . '</label></div>
			                        <div class="grid10"><input type="text"  id="gnc_yonetim_yeni_album_crop_boy" name="gnc_yonetim_yeni_album_crop_boy" /></div>
			                        <div class="clear"></div>     
			                    </div>
								<div class="formRow">
					            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
			                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
	
	echo '<!-- Seçili albümü görüntüle -->
		  <div id="gnc_yonetim_secili_album" class="wrapper "></div>';
}
function dosyalar(){
	?>
	<script type="text/javascript">
		// This is a sample function which is called when a file is selected in CKFinder.
		function showFileInfo(fileUrl, data, allFiles)
		{
			var msg = '<b>'+file_Url+':</b> <a href="' + fileUrl + '">' + fileUrl + '</a><br /><br />';
			// Display additional information available in the "data" object.
			// For example, the size of a file (in KB) is available in the data["fileSize"] variable.
			if ( fileUrl != data['fileUrl'] )
				msg += '<b>'+file_Url+':</b> ' + data['fileUrl'] + '<br />';
			
			msg += '<b>'+file_Size+':</b> ' + data['fileSize'] + ' KB<br />';
			
			if ( allFiles.length > 1 )
			{
				msg += '<br /><br /><b>Selected files:</b><br /><br />';
				msg += '<ul style="padding-left:20px">';
				for ( var i = 0 ; i < allFiles.length ; i++ )
				{
					// See also allFiles[i].url
					msg += '<li>' + allFiles[i].data['fileUrl'] + ' (' + allFiles[i].data['fileSize'] + 'KB)</li>';
				}
				msg += '</ul>';
			}
			// this = CKFinderAPI object
			this.openMsgDialog(selectedFile, msg );
		}

		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();
		// The path for the installation of CKFinder (default = "/ckfinder/").
		finder.basePath = '../';
		// The default height is 400.
		finder.height = 600;
		// This is a sample function which is called when a file is selected in CKFinder.
		finder.selectActionFunction = showFileInfo;
		finder.create();

		// It can also be done in a single line, calling the "static"
		// create( basePath, width, height, selectActionFunction ) function:
		// CKFinder.create( '../', null, null, showFileInfo );

		// The "create" function can also accept an object as the only argument.
		// CKFinder.create( { basePath : '../', selectActionFunction : showFileInfo } );
	</script>
	<?php
}
function dosya_yukle(){
	global $adres, $dil, $vt;
	
	gnc_model_dosya_yukle();
	echo '<!-- Main content -->
		  <div class="wrapper">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['yeni_dosya'] .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">
						<form class="main" enctype="multipart/form-data" method="post" action="'. $adres['mevcut'] .'">
							<fieldset>
								<div class="nNote nInformation">
									<p>'. $dil['dosya_yukleme_bilgi'] .'</p>
								</div>
								<div class="formRow">
					            	<div class="grid2"><label>'.$dil['dosya_tipi'].'</label></div>
		                            <div class="grid10 searchDrop">
		                                <select data-placeholder="'.$dil['secim_yapin'].'" class="select" id="dosya_tipi" name="dosya_tipi" style="width:250px;" tabindex="2">
		                                    <option value="1">'.$dil['resim'].'</option> 
		                                    <option value="11">'.$dil['resim_harici'].'</option> 
		                                    <option value="2">'.$dil['video'].'</option> 
		                                    <option value="21">'.$dil['video_harici'].'</option> 
		                                    <option value="0">'.$dil['dosya'].'</option>  
		                                </select>
		                                <span class="note">'. $dil['dosya_tipi_bilgi'] .'</span>
		                             </div>
		                             <div class="clear"></div>
					            </div>
					            
						        <div class="dosya_tipi_normal">
						            <div class="formRow">
				                        <div class="grid2"><label>'. $dil['dosya_sec'] . '</label></div>
				                        <div class="grid10"><input type="file" id="dosya" name="dosya" /></div>
				                        <div class="clear"></div>     
				                    </div>
				                </div>
			                    <div class="dosya_tipi_harici none">
				                    <div class="nNote nWarning dosya_tipi">
										<p>'. $dil['harici_dosya_yukleme_aciklamasi'] .'</p>
									</div>
						            <div class="formRow dosya_tipi">
				                        <div class="grid2"><label>'. $dil['url_adresi'] . '</label></div>
				                        <div class="grid10"><input type="text" id="dosya_url_adresi" name="dosya_url_adresi" /></div>
				                        <div class="clear"></div>  
				                    </div>
			 					</div>
			 					<div class="formRow">
			                        <div class="grid2"><label>'. $dil['aciklama'] . '</label></div>
			                        <div class="grid10"><textarea id="dosya_aciklama" name="dosya_aciklama"></textarea><span class="note">'. $dil['html_kullanilamaz_bilgi'] .'</span></div>
			                        <div class="clear"></div>     
			                    </div>
			                    
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['kaydet'].'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
}
function resimler(){
	global $dil, $site, $vt;
	
	echo '<!-- Main content -->
		  <div class="wrapper">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['resimler'] .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">
					
						<ul class="middleNavS" style="margin-top:10px; margin-bottom:20px;">';
							// Resim veri_tiplerini belirtelim...
							$veri_tipi = array(1, 11); 
							$sonuclar = gnc_model_veriler($veri_tipi);
							foreach($sonuclar AS $sonuc)
								echo '<li><a class="tipN" href="'.$sonuc['href'].'" original-title="'.$sonuc['veri_yolu'].'"><img alt="'.$sonuc['veri_aciklama'].'" src="'.$sonuc['veri_yolu'].'" style="padding:0px;" width="67" height="67"></a></li>';
					
					echo '
						</ul>	
					</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
	
}
function videolar(){
	global $dil, $site, $vt;
	
	echo '<!-- Main content -->
		  <div class="wrapper">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['videolar'] .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">';
						// Video tiplerini belirtelim...
						$veri_tipi = array(2, 21); 
						$sonuclar = gnc_model_veriler($veri_tipi);
						foreach($sonuclar AS $sonuc){
							echo $sonuc['video'];	
						}
					
			echo '	</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
	
}
function resim(){
	global $dil, $site, $vt;
	
	$resim = $site['url'].$site['resim_yuklenecek_adres'].$_REQUEST['resim'];
	echo '<!-- Main content -->
	<div class="wrapper">    
	    <div class="fluid">
	    					
	        <!-- Yönetim sayfasına ait hoşgeldin mesajı -->
	        <div class="widget grid12">';
	
		echo '<div class="body">';
			  
				echo '	<!-- Seçili resmi göster -->
						<div class="formRow">
			            	<div class="grid2"><label>'.$dil['album_sec'].'</label></div>
                            <div class="grid10 searchDrop">
                                <select data-placeholder="'.$dil['secim_yapin'].'" class="select" id="album_secimi" name="album_secimi" style="width:250px;" tabindex="2">
                                    <option value=""></option>';
                                    $sonuclar = gnc_model_albumler();
									foreach ($sonuclar AS $sonuc){
										echo '<option value="'.$sonuc['album_id'].'-'.$sonuc['album_crop_en'].'-'.$sonuc['album_crop_boy'].'">'.$sonuc['album_adi'].'</option>'; 
									} 
                                echo ';
                                </select>
                                <span class="note">'. $dil['dosya_yukleme_sirasinda_album_secimi_bilgi'] .'</span>
                             </div>
                             <div class="clear"></div>
			            </div>
			            
						
					    <div class="formRow">
					    	<div class="grid12">
					    		<img src="'.$resim.'" id="cropbox">
					    	</div>
					        <div class="clear"></div>
					        <form class="none">
								<label>X1 <input type="text" size="4" id="x"  name="x"  /></label>
								<label>Y1 <input type="text" size="4" id="y"  name="y"  /></label>
								<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
								<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
								<label>W  <input type="text" size="4" id="w"  name="w"  /></label>
								<label>H  <input type="text" size="4" id="h"  name="h"  /></label>
							</form>
							<div id="sonuc"></div>
						</div>
						
						<div class="formRow resim_kirpma_islemi none">
	                        <div class="grid2"><label>'. $dil['aciklama'] . '</label></div>
	                        <div class="grid10">
	                        	<input type="text" id="gnc_yonetim_resim_aciklama" name="gnc_yonetim_resim_aciklama" style="height:29px;"/>
	                        	<span class="note">'. $dil['resim_aciklama_bilgi'] .'</span>
	                        </div>
	                        <div class="clear"></div>     
	                    </div>
					    <div class="formRow resim_kirpma_islemi none">
							<a class="buttonM bBlue grid12" id="resim_kirpma_tusu" onClick="resim_kirp();" href="javascript:void(0);">
								<span class="icon-thumbs-up-2"></span>
								<span>'.$dil['resmi_kirp'].'</span>
							</a><br>
						</div>';
		echo '</div>';	
	
	
	  echo '</div>
	        <div class="clear"></div>
	    </div>				    
	</div>';
}
function mesajlar(){
	global $adres, $dil, $site, $vt;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			        <div class="widget grid12">';
					// Ayarlar sayfasının seçim yapılmamış hali							
					echo '<div class="whead">
							<h6>'. $dil['ayarlar'] .'</h6>
							<div class="clear"></div>
						  </div>
						  <div class="body">
							<div class="fluid">
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="ayarlar/genel">'.$dil['genel_ayarlar'].'</a>
									</div>
								</div>
								<div class="grid6">
									<div class="wButton">
										<a class="buttonL bLightBlue first" title="" href="ayarlar/kullanici">'.$dil['kullanici_ayarlari'].'</a>
									</div>
								</div>
							</div>
						  </div>';
			  echo '</div>
			        <div class="clear"></div>
			    </div>				    
			</div>';
}
function iletisim_formu(){
	global $adres, $dil, $site, $vt;
	
	echo '	<div class="whead">
	            <div class="whead"><h6>'.$dil['iletisim_formundan_gelen_mesajlar'].'</h6><div class="clear"></div></div>
	            <div id="dyn" class="hiddenpars">
	                <a class="tOptions" title="Options"><img src="'.$site['url'].'sistem/gorunum/yonetim/tasarim/images/icons/options" alt="" /></a>
	                
	                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
		                <thead>
			                <tr>
				                <th>'. $dil['iletisim_adi'] .'</th>
				                <th>'. $dil['eposta'] .'</th>
				                <th>'. $dil['tarih'] .' </th>
				                <th>'. $dil['islemler'] .' </th>
			                </tr>
		                </thead>
		                <tbody>
			                <tr class="gradeX">';
							
							$sonuclar = gnc_model_iletisim_formu();
							foreach ($sonuclar AS $sonuc){
								echo '<td>'.$sonuc['iletisim_adi'].'</td>
				                	  <td>'.$sonuc['iletisim_eposta'].'</td>
				                	  <td>'.$sonuc['iletisim_tarih'].'</td>
				                	  <td class="center">
				                	  		<a rel="http://localhost/gnc/ajax/gnc_yonetim_iletisim_formu_detaylari" title="'. $dil['menu']['iletisim_formu']  .'" class="buttonM bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['iletisim_id'].'">'. $dil['detaylar'] .'</a>
				                      </td>';
							}
				                
				            echo '
			                </tr>
			            </tbody>
	                </table> 
	            </div>
	            <div class="clear"></div> 
	        </div>';
}
function eposta(){
	global $adres, $dil, $vt;
	/* PHPMailer class'ı ile ePosta gönderimi için gnc_smtp_ile_eposta_gonder() fonksiyonunu kullanabilirsiniz, burada PHP'nin mail() fonksiyonu kullanılmaktadır.
	 * 
	 * Yüklenen blok ile ePosta göndermeyi sağlar, 
	 * 
	 * Class https://github.com/Synchro/PHPMailer adresinden alınmıştır.
	 * Türkçe anlatım için http://blog.rasitkan.com/phpmailer-ile-smtp-kullanarak-form-mail-gonderme.html adresine bakabilirsiniz
	 */
	echo '<div class="whead">
			<h6>'. $dil['ePosta_gonder'] .'</h6>
			<div class="clear"></div>
		  </div>
		  <div class="body">';
	
			gnc_eposta_gonder();
			echo '<form class="main" method="post" action="'.$adres['mevcut'] .'">
					<fieldset>
						<div class="formRow">
	                        <div class="grid2"><label>'. $dil['kime'] . '</label></div>
	                        <div class="grid3 searchDrop">
                                <select data-placeholder="'.$dil['gonderilecek_listeyi_secin'].'" class="select" name="gnc_yonetim_eposta_liste" style="width:350px;" tabindex="2">
                                    <option value=""></option>
                                    <option value="0">'.$dil['Özel'].'</option>  
									<option value="1">'.$dil['Herkese'].'</option>   
									<option value="2">'.$dil['Kullanıcılara'].'</option>   
									<option value="3">'.$dil['Abonelere'].'</option>   
								</select>
                            </div>
                            <div class="grid7"><input type="text" id="gnc_yonetim_eposta_ozel" name="gnc_yonetim_eposta_ozel" placeholder="'. $dil['ozel_olarak_eposta_gondermek_istediginiz_kisilerin_eposta_adreslerini_yazin'] . '" style="height:29px;"/></div>
	                        <div class="clear"></div>     
	                    </div>
	                    <div class="formRow">
	                        <div class="grid2"><label>'. $dil['konu'] . '</label></div>
	                        <div class="grid10"><input type="text" id="gnc_yonetim_eposta_konu" name="gnc_yonetim_eposta_konu"/></div>
	                        <div class="clear"></div>     
	                    </div>
	                    <div class="formRow">
	                        <div class="grid2"><label>'. $dil['mesaj'] . '</label></div>
	                        <div class="grid10"><textarea id="gnc_yonetim_eposta_icerik" name="gnc_yonetim_eposta_icerik"></textarea></div>
	                        <div class="clear"></div>     
	                    </div>
						
						<div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'.$dil['iptal'].'">
		                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'.$dil['gonder'].'">
						</div>
					</fieldset>
				</form>';
	
		echo '</div>';	
}
/* Excel dosyalarıno PHP'den okumayı sağlayan fonksiyon
 * 
 * Excel sınıfını kullanarak, excel verilerini okumayı sağlayan fonksiyon basit olduğu için 
 * Vadim Tkachenko tarafından yazılan Spreadsheet Excel Reader kullanılmıştır, büyük dosyalar okunurken sorun yaşanabilmektedir.
 * 
 * Web projelerinde pek sık gerek duyulmamasına rağmen projenizde excel'den sürekli veri okuyacak ve yazacaksanız
 * http://code.google.com/p/php-excel-reader/
 * adresinde bulunan eklentiyi kullanmanızı tavsiye ederim!
 */
function excel(){
	global $adres, $dil, $site, $vt;	
	
	// Sınıfı çağır
	error_reporting(0);
	require_once('sistem/bloklar/excel.class.php');		// Excel sayfalarını okumak için kullanılan sınıf

	// Excel sınıfını çağır
	$excel = new Spreadsheet_Excel_Reader();
	
	// Excel dosyasını belirt
	$excel->read('veri/excel/ornek.xls');
	/* Excel verisini okumak için şu komutu kullan
	 * 
	 * $excel->sheets['sayfa']['cells']['satir]['sutun'];
	 * Gerisi hayal gücünüze kalmış...
	 */
	echo $excel->sheets[0]['cells'][1][1];
}
/* Veri çek
 * 
 * Çeşitli veritabanlarından veri çekmek için kullanılır
 */
function veri_cek(){
	global $site, $vt;
	
	// Beşka bir veritabanına bağlantı yapılacaksa, bunun nesne adını db yapalım
	$db['sunucu_adresi'] = 'localhost'; // Sunucu adresi (genelde localhost)
	$db['veritabani_adi'] = 'bahispesinde'; // Veritabanı adı
	$db['kullanici_adi'] = 'root'; // Kullanıcı adı
	$db['kullanici_sifresi'] = '26081986'; // Parola
	// $vt['oneki'] = 'gnc_'; // Tablo öneki
	$db['baglanilamadi'] = '<h2>Veritabanına Bağlanılamadı</h2><p>Veritabanına bağlanırken bir sorun ile karşılaşıldı. Kısa bir süre içerisinde tekrar deneyiniz, eğer sorun devam ederse site yöneticisi ile iletişime geçiniz.</p>';
	
	// Veritabanına bağlan, bağlanılamazsa hata iletisini görüntüle
	$db = new db_mysql($db['sunucu_adresi'], $db['kullanici_adi'], $db['kullanici_sifresi'], $db['veritabani_adi']);
	mysql_set_charset('utf8');
	
	$db_sorgu = $db->query("SELECT takimATeknikAdam FROM maclar GROUP BY takimATeknikAdam ORDER BY takimATeknikAdam ASC");
	while($db_sonuc = $db->fetch_array($db_sorgu)){
			
		print_r($db_sonuc);
		
		if (!empty($db_sonuc['asdadsadsad']))
		{
		$db->query("INSERT INTO bp_teknikadamlar
						(ta_adi)
					VALUES
						( '{$db_sonuc['takimATeknikAdam']}')");	
		}
	}
}
function veritabani_yedekle(){
	global $dil;
	
	echo '<!-- Main content -->
		  <div class="wrapper">    
			  <div class="fluid">
			  	<div class="widget grid12">
					<div class="whead">
						<h6>'. $dil['menu']['veritabani_yedekle'] .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">
	 					<div class="formRow">
	                        <div class="grid12"><label>'. $dil['veritabani_yedeklendi'] . '</label></div>
	                        <div class="clear"></div>     
	                    </div>
					</div>
				</div>
				<div class="clear"></div>
		    </div>				    
		</div>';
	@gnc_veritabanini_yedekle();
}




