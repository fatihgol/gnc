<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo gnc_baslik(); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="<?php echo $ayar['meta_description']; ?>">
		<meta name="keywords" content="<?php echo $ayar['meta_keywords']; ?>">
		
		<!-- Konumsal etiketler 
		<meta property="place:location:latitude" content="<?php echo $ayar['lat']; ?>"/>
		<meta property="place:location:longitude" content="<?php echo $ayar['lng']; ?>"/>
		<meta property="business:contact_data:street_address" content=""/>
		<meta property="business:contact_data:locality" content=""/>
		<meta property="business:contact_data:postal_code" content=""/>
		<meta property="business:contact_data:country_name" content="<?php echo $ayar['yerel_ulke']; ?>"/>
		<meta property="business:contact_data:email" content="<?php echo $ayar['iletisim_eposta']; ?>"/>
		<meta property="business:contact_data:phone_number" content="<?php echo $ayar['iletisim_bilgileri_telefon']; ?>"/>
		<meta property="business:contact_data:website" content="<?php echo $site['url']; ?>"/>
		-->
		
		<!-- FB -->
		<meta property="og:url" content="<?php echo $adres['mevcut']; ?>"/>
		<meta property="og:site_name" content="<?php echo $ayar['site_adi']; ?>"/>
		<meta property="og:title" content="<?php echo gnc_baslik(); ?>"/>
		<meta property="og:description" content="<?php echo $ayar['og_description']; ?>"/>
		<meta property="og:image" content="<?php echo $ayar['og_image']; ?>"/> 
		<!--
		<meta property="og:see_also" content="http://www.website.com"/>
		<meta property="fb:admins" content="Facebook_ID"/>
		<meta property="fb:app_id" content="App_ID"/>
		-->
		
		<!-- G+ --> 
		<meta itemprop="name" content="<?php echo $ayar['site_adi']; ?>"/>
		<meta itemprop="description" content="<?php echo $ayar['og_description']; ?>"/>
		<meta itemprop="image" content="<?php echo $ayar['og_image']; ?>"/>
		
		<!-- Twitter -->
		<!--
		<meta name="twitter:card" content="summary"/>
		 -->
		<meta name="twitter:site" content="<?php echo $ayar['site_adi']; ?>"/>
		<meta name="twitter:title" content="<?php echo gnc_baslik(); ?>">
		<meta name="twitter:description" content="<?php echo $ayar['og_description']; ?>"/>
		<meta name="twitter:creator" content="<?php echo $ayar['site_adi']; ?>"/>
		<meta name="twitter:image:src" content="<?php echo $ayar['og_image']; ?>"/>
		<meta name="twitter:domain" content="<?php echo $site['url']; ?>"/>
		
		<!-- Favicon --> 
		<link rel="shortcut icon" href="<?php echo $site['url'].$ayar['favicon']; ?>" />
		<link rel="apple-touch-icon" href="<?php echo $site['url'].$ayar['favicon']; ?>" />
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $site['url'].$ayar['apple_icon_72']; ?>" />
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $site['url'].$ayar['apple_icon_114']; ?>" />
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $site['url'].$ayar['apple_icon_144']; ?>" />
		<meta name="author" content="Günce Ali BEKTAŞ"/>
		
		<!-- Stylesheets-->
		<link href="<?php echo $site['url']; ?>bootstrap/dist/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $site['url']; ?>bootstrap/dist/css/carousel.css" rel="stylesheet">
		
		<!-- JScripts -->
		<script src="<?php echo $site['url']; ?>sistem/js/jquery.js"></script> 
		<script src="<?php echo $site['url']; ?>sistem/js/gnc.js"></script> 
		<?php
		// javascriptte kullanılacak dil degiskenlerini global js değişkenlerine dönüştürür. gnc.js'den önce çağırılmalıki fonksiyonlardan önce değişkenler tanımlanmış olsun
		echo '
		<script type="text/javascript">
		<!-- // --><![CDATA[
			var ajax_adresi = "'.$site['url'].'ajax/";
			var ajax_adresi_site = "'.$site['url'].'ajax-site/";
			var sayfa_acilis_tarihi = '.$site['suan'].';
			var oturum_omru = "'.$ayar['oturum_omru'].'";
			var oturum_sureniz_doldu = "'. $dil['oturum_sureniz_doldu'] .'";
		// ]]>
		</script>
		<script>'.$ayar['header_icine_eklenecek_js_kodlar'].'</script> 
		<style>'.$ayar['css_kodlari'].'</style>'; 
		?>	
	</head>
	<body>
		<?php
		if (!defined('gnc'))
			die();
		?>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/<?php echo $_SESSION['dil_kodu']; ?>/all.js#xfbml=1&appId=<?php echo $ayar['facebook_appid']; ?>";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<script>
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] ||
				function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o), m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
			ga('create', 'UA-44949088-1', 'guncebektas.com');
			ga('send', 'pageview');
		</script>
	    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="<?php echo $site['url']; ?>"><?php echo $ayar['site_adi']; ?></a>
	        </div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ürünler <b class="caret"></b></a>
	              <ul class="dropdown-menu">
	                <li><a href="<?php echo $site['url'].'gnc_'.$site['surum'].'.zip'; ?>">GNC <?php echo $site['surum']; ?></a></li>
	                <li><a href="<?php echo $site['url'].'gnc_'.$site['surum'].'.zip'; ?>">Alan Adı Kontrolörü</a></li>
	                <li><a href="<?php echo $site['url'].'gnc_'.$site['surum'].'.zip'; ?>">Giriş ve Kayıt Sınıfı v.0.1</a></li>
	                <li><a href="<?php echo $site['url'].'gnc_'.$site['surum'].'.zip'; ?>">Mesajlaşma Sınıfı v.0.1</a></li>
	                <li class="divider"></li>
	                <li><a href="<?php echo $site['url'].'sayfa/cok-yakinda'; ?>">Çok yakında</a></li>
	              </ul>
	            </li>
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	            <?php gnc_menu(1); ?>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>