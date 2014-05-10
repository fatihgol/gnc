<?php
if (!defined('gnc'))
	die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<!-- Her sayfanın başlığını oluşturalım, Arama motoru dostu siteler için önemlidir. -->
		<title><?php echo gnc_baslik(); ?></title>
		
		<meta name="description" content="<?php echo $ayar['meta_description']; ?>">
		<meta name="keywords" content="<?php echo $ayar['meta_keywords']; ?>">
		<!-- FB meta tags -->
		<meta property="og:url" content="<?php echo $adres['mevcut']; ?>"/>
		<meta property="og:title" content="<?php echo gnc_baslik(); ?>"/>
		<meta property="og:description" content="<?php echo $ayar['og_description']; ?>"/>
		<meta property="og:image" content="<?php echo $ayar['og_image']; ?>"/> 
		  
		<link rel="shortcut icon" href="<?php echo $ayar['favicon']; ?>" />
		<link rel="apple-touch-icon" href="<?php echo $ayar['favicon']; ?>" />
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $ayar['apple_icon_72']; ?>" />
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $ayar['apple_icon_114']; ?>" />
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $ayar['apple_icon_144']; ?>" />
		
		
		<!-- jquery ve jquery-ui -->
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/js/jquery.js"></script> 
		
		<!-- GNC de kullanılan jquery kodlarının - BAŞLANGICI -->
		<?php
		// javascriptte kullanılacak dil degiskenlerini global js değişkenlerine dönüştürür. gnc.js'den önce çağırılmalıki fonksiyonlardan önce değişkenler tanımlanmış olsun
		echo '
		<script type="text/javascript">
		<!-- // --><![CDATA[
			var site_adresi = "'.$site['url'].'";
			var ajax_adresi = "'.$site['url'].'ajax/";
			var ajax_adresi_site = "'.$site['url'].'ajax-site/";
			
			var sayfa_acilis_tarihi = '.$site['suan'].';
			var oturum_omru = "'.$ayar['oturum_omru'].'";
			var oturum_sureniz_doldu = "'. $dil['oturum_sureniz_doldu'] .'";
			
			var sSearch = "'. $dil['sSearch'] .'";
			var sLengthMenu = "'. $dil['sLengthMenu']  .'";
			var sZeroRecords = "'. $dil['sZeroRecords']  .'";
			var sInfo = "'. $dil['sInfo']  .'";
			var sInfoEmpty = "'. $dil['sInfoEmpty']  .'";
			var sInfoFiltered = "'. $dil['sInfoFiltered']  .'";
			var sFirst = "'. $dil['sFirst']  .'";
			var sLast = "'. $dil['sLast']  .'";
			var sNext = "'. $dil['sNext']  .'";
			var sPrevious = "'. $dil['sPrevious']  .'";
			var fileDefaultText = "'. $dil['fileDefaultText'] .'";
			
			var selectedFile = "'. $dil['selectedFile']  .'";
			var file_Url = "'. $dil['file_Url']  .'";
			var file_Size = "'. $dil['file_Size']  .'";
			var file_Date = "'. $dil['file_Date']  .'";
			
			var modal_box_width = '.$ayar['modal_box_width'].';
			 			
			var crop_x = '.$ayar['crop_eni'].';
			var crop_y = '.$ayar['crop_boyu'].';
		// ]]>
		</script>';
		?>
		<!-- GNC tarafından sıkça kullanılan js fonksiyonları -->
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/js/gnc.js?<?php echo rand(1,10000); ?>"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/js/gnc-timeout.js?<?php echo rand(1,10000); ?>"></script>		
		<!-- GNC de kullanılan jquery kodlarının - BİTİŞİ -->
		
		<link href="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $site['url']; ?>sistem/css/gnc.css" rel="stylesheet" type="text/css" />
		
		<!--[if IE]> <link href="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/ui.spinner.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.mousewheel.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/js/jquery-ui.js"></script> 
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/charts/excanvas.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/charts/jquery.flot.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/charts/jquery.flot.orderBars.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/charts/jquery.flot.pie.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/charts/jquery.flot.resize.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/charts/jquery.sparkline.min.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/tables/jquery.dataTables.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/tables/jquery.sortable.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/tables/jquery.resizable.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/autogrowtextarea.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.uniform.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.inputlimiter.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.tagsinput.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.maskedinput.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.autotab.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.chosen.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.dualListBox.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.cleditor.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.ibutton.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.validationEngine-en.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/forms/jquery.validationEngine.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/uploader/plupload.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/uploader/plupload.html4.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/uploader/plupload.html5.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/uploader/jquery.plupload.queue.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/wizards/jquery.form.wizard.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/wizards/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/wizards/jquery.form.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.collapsible.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.breadcrumbs.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.tipsy.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.progress.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.timeentry.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.jgrowl.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.fancybox.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.fileTree.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.sourcerer.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/others/jquery.fullcalendar.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/others/jquery.elfinder.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/plugins/ui/jquery.easytabs.min.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/files/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/files/functions.js"></script>
		
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/charts/chart.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/js/charts/hBar_side.js"></script>
		
		<!--
			Wysiwyg editor olarak ckeditor kullanılmış olup editör içinden resim yükleme eklentisi dahil pek çok özelleştirme yapılmıştır.
			Editör ile hazırlanan içeriklere yüklenen resimler veri/_images klasörüne yüklenmektedir.
			Detaylı bilgi için http://ckeditor.com/ adresine bakabilirsiniz.
		-->
		<script type="text/javascript" src="<?php echo $site['url']; ?>ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo $site['url']; ?>ckfinder/ckfinder.js"></script>
		
		<!-- Resim kırpma eklentisi -->
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/js/jquery.Jcrop.js"></script>
		<link href="<?php echo $site['url']; ?>sistem/css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
		
		<!-- Menü sıra ve yapısının ayarı için gereken eklenti -->
		<script type="text/javascript" src="<?php echo $site['url']; ?>sistem/js/jquery.mjs.nestedSortable.js"></script>

		<?php 
		echo '<script>'.$ayar['header_icine_eklenecek_js_kodlar'].'</script>'; 
		echo '<style>'.$ayar['css_kodlari'].'</style>'; 
		?>
	</head>
	<body>
		<?php
		/* Gnc'ye giriş yapıldığında kullanıcının oturum süresi dolduğunda açılacak olan modal penceresi */
		echo '<div id="gnc-modal-oturum-suresi-doldu" class="none">
				<!-- Login wrapper begins -->
				<div class="loginWrapper">
				
					<!-- Current user form -->
				    <form method="POST" action="'.$site['url'].'giris" id="login">
				        <div class="loginPic">
				            <a href="#" title=""><img src="'. gnc_kullanici_resmi_goster($_SESSION['kullanici_id']).'" alt="" height="80"/></a>
				        </div>
				        
				        <input type="text" name="kullanici_kullanici_adi" placeholder="'.$dil['eposta_adresinizi_yazin'].'" class="loginEmail" />
				        <input type="password" name="kullanici_sifre" placeholder="'.$dil['sifre'].'" class="loginPassword" />
				        
				        <div class="logControl">
				            <!--
				            <div class="memory"><input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label></div>
				            -->
				            <input type="submit" name="yonetim_giris_submit" value="'.$dil['giris'].'" class="buttonM bBlue" />
				            <div class="clear"></div>
				        </div>
				    </form>
				
				</div>
				<!-- Login wrapper ends -->
			  </div>';
		/* Gnc de kullanılan ve ajax'la beslenen modal penceresi
		 * 
		 * Aşağıdaki örnek gibi bir tuşla tetiklenebilir.
		 * <a rel="http://localhost/gnc/ajax/gnc_yonetim_kullanici_detaylari" title="Kullanıcı Detayları" class="buttonM bDefault ml10 gnc-modal-acma-tusu" id="'.$sonuc['kullanici_id'].'">Detaylar</a></a>
		 * a'nın rel değerinde çalıştırılan ajax isteği açılan pencerenin içerisine veri beslemektedir ayrıca a'nın title değeride açılan modal penceresinin title değerini almaktadır.                      
		 */
		echo '<div class="gnc-modal-penceresi">
      			<div class="load none"></div>
            	<div id="modal-penceresinin-icerigi"></div>
        	  </div>';
		?>
		<!-- Sidebar begins -->
		<div id="sidebar">
		    <div class="mainNav">
		    	<?php
		    	if (gnc_yetki(100)){
		        	  echo '<div class="user">
					            <a href="'. $site['url'] .'yonetim/profil" title="Kendi bilgilerinizi düzenlemek için tıklayın" class="leftUserDrop"><img src="'. gnc_kullanici_resmi_goster($_SESSION['kullanici_id']) .'" alt="" width="80" height="80" /><span><!--<strong>3</strong>--></span></a>
					            <!--<span>'. $_SESSION['kullanici_adi'] .'</span>-->
					        </div>';
				}
				?>
		        <!-- Main nav -->
		        <ul class="nav">
		            <li><a href="<?php echo $site['url']; ?>yonetim" title=""> <!-- class="active" --> <img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/dashboard.png" alt="" /><span><?php echo $dil['menu']['yonetim']; ?></span></a></li>
		            <?php if (gnc_yetki(110)){ ?>
		            <li><a href="<?php echo $site['url']; ?>yonetim/ayarlar" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/settings.png" alt="" /><span><?php echo $dil['menu']['ayarlar']; ?></span></a>
		                <ul>
		                	<?php if (gnc_yetki(111)){ ?>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/genel-ayarlar" title=""><span class="icol-cog2"></span><?php echo $dil['menu']['genel']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/menu" title=""><span class="icon-list"></span><?php echo $dil['menu']['menu']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/ayarlar/dil" title=""><span class="icon-comment"></span><?php echo $dil['menu']['dil']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/ayarlar/moduller" title=""><span class="icon-code"></span><?php echo $dil['menu']['moduller']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/ayarlar/yonlendiriciler" title=""><span class="icon-arrow"></span><?php echo $dil['menu']['yonlendiriciler']; ?></a></li>
		                	<?php } ?>
		                	<li><a href="<?php echo $site['url']; ?>yonetim/kullanicilar" title=""><span class="icol-user"></span><?php echo $dil['menu']['kullanici']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/yeni-kullanici" title=""><span class="icol-add"></span><?php echo $dil['yeni_kullanici']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/cache-klasorunu-temizle" title=""><span class="icon-briefcase-2"></span><?php echo $dil['menu']['cache-temizle']; ?></a></li>
		                </ul>
		            </li>
		            <?php } ?>
		            <li><a href="<?php echo $site['url']; ?>yonetim/icerikler" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/forms.png" alt="" /><span><?php echo $dil['menu']['icerikler']; ?></span></a>
		                <ul>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/icerikler/kategoriler" title=""><span class="icol-list"></span><?php echo $dil['menu']['kategoriler']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/icerikler/kategorileri-sirala" title=""><span class="icon-grid"></span><?php echo $dil['menu']['kategorileri_sirala']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/icerikler/yeni-kategori" title=""><span class="icon-add"></span><?php echo $dil['menu']['yeni_kategori']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/icerikler/icerik" title=""><span class="icon-document"></span><?php echo $dil['menu']['icerikler']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/icerikler/yeni-icerik" title=""><span class="icon-add"></span><?php echo $dil['menu']['yeni_icerik']; ?></a></li>
		                	<?php if (gnc_yetki(111)){ ?>
		                	<li><a href="<?php echo $site['url']; ?>yonetim/icerikler/sablonlar" title=""><span class="icon-drawer"></span><?php echo $dil['menu']['sablonlar']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/icerikler/yeni-sablon" title=""><span class="icon-add"></span><?php echo $dil['menu']['yeni_sablon']; ?></a></li>
		                	<?php } ?>
		                </ul>
		            </li>
		            <li><a href="<?php echo $site['url']; ?>yonetim/dosyalar" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/images.png" alt="" /><span><?php echo $dil['menu']['veriler']; ?></span></a>
		            	<ul>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/albumler" title=""><span class="icon-landscape"></span>Albümler</a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/resimler" title=""><span class="icon-images"></span>Resimler</a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/videolar" title=""><span class="icon-movie-2"></span>Videolar</a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/diger-veriler" title=""><span class="icon-documents"></span>Diğer veriler</a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/dosya-yukle" title=""><span class="icol-upload"></span>Dosya yükle</a></li>
		                    <?php if (gnc_yetki(111)){ ?>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/veritabani-yedekle" title=""><span class="icol-archive"></span>Veritabanını yedekle</a></li>
		                	<?php } ?>
		                </ul>
		            </li>
		            <!--
		            <li><a href="<?php echo $site['url']; ?>yonetim/mesajlar" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/messages.png" alt="" /><span><?php echo $dil['menu']['mesajlar']; ?></span></a>
		            	<ul>
		            		<!--
		                    <li><a href="ui.html" title=""><span class="icol-add"></span>Mesaj yaz</a></li>
		                    <li><a href="ui_icons.html" title=""><span class="icol-inbox"></span>Gelen kutusu</a></li>
		                   	
		                    <li><a href="<?php echo $site['url']; ?>yonetim/mesajlar/iletisim-formu" title=""><span class="icon-list"></span><?php echo $dil['menu']['iletisim_formu']; ?></a></li>
		                    <li><a href="<?php echo $site['url']; ?>yonetim/mesajlar/eposta" title=""><span class="icon-mail"></span><?php echo $dil['menu']['ePosta_gonder']; ?></a></li>
		                </ul>
		            </li>
		            <li><a href="<?php echo $site['url']; ?>yonetim/istatistikler" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/statistics.png" alt="" /><span><?php echo $dil['menu']['istatistikler']; ?></span></a></li>
		            -->
		            <li><a href="<?php echo $site['url']; ?>forum" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/ui.png" alt="" /><span><?php echo $dil['menu']['topluluk']; ?></span></a>
		        		<ul>
		                	<li><a href="<?php echo $site['url']; ?>forum" title=""><span class="icon-comment"></span><?php echo $dil['menu']['forum']; ?></a></li>
		                	<li><a href="<?php echo $site['url']; ?>forum/index.php?action=admin" title=""><span class="icon-suitcase"></span><?php echo $dil['menu']['forum_yonetimi']; ?></a></li>
		                    <li><a href="http://www.guncebektas.com" title=""><span class="icon-sleep"></span>www.guncebektas.com</a></li>
		                </ul>
		            </li>
		            <li><a href="<?php echo $site['url']; ?>cikis" title=""><img src="<?php echo $site['url']; ?>sistem/gorunum/yonetim/tasarim/images/icons/mainnav/other.png" alt="" /><span><?php echo $dil['menu']['cikis']; ?></span></a></li>
		        </ul>
		    </div>
		</div>
		