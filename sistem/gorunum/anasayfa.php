<?php
if (!defined('gnc'))
	die();

echo '	<!-- Carousel 
		================================================== -->
	    <div id="myCarousel" class="carousel slide" data-ride="carousel">
	      <!-- Indicators -->
	      <ol class="carousel-indicators">
	        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	        <li data-target="#myCarousel" data-slide-to="1"></li>
	        <li data-target="#myCarousel" data-slide-to="2"></li>
	        <li data-target="#myCarousel" data-slide-to="3"></li>
	        <li data-target="#myCarousel" data-slide-to="4"></li>
	      </ol>
	      <div class="carousel-inner">
	        <div class="item active">
	          <img src="'.$site['resim_yolu'].'slide-01.jpg" alt="First slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>'.$dil['gnc'].'</h1>
	              <p>'.$dil['slide1_icerik'].'</p>
	              <p><a href="'.$site['url'].'gnc_'.$site['surum'].'.zip" class="btn  btn-lg btn-primary" role="button">'.$dil['indir_v'].'</a></p>
	            </div>
	          </div>
	        </div>
	        <div class="item">
	          <img src="'.$site['resim_yolu'].'slide-02.jpg" alt="Second slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>'.$dil['slide2_baslik'].'</h1>
	              <p>'.$dil['slide2_icerik'].'</p>
	              <p><a href="'.$site['url'].'gnc_'.$site['surum'].'.zip" class="btn  btn-lg btn-primary" role="button">'.$dil['indir_v'].'</a></p>
	            </div>
	          </div>
	        </div>
	        <div class="item">
	          <img src="'.$site['resim_yolu'].'slide-03.jpg" alt="Third slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>'.$dil['slide3_baslik'].'</h1>
	              <p>'.$dil['slide3_icerik'].'</p>
	              <p><a href="'.$site['url'].'gnc_'.$site['surum'].'.zip" class="btn  btn-lg btn-primary" role="button">'.$dil['indir_v'].'</a></p>
	            </div>
	          </div>
	        </div>
	        <div class="item">
	          <img src="'.$site['resim_yolu'].'slide-04.jpg" alt="Forth slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>'.$dil['slide4_baslik'].'</h1>
	              <p>'.$dil['slide4_icerik'].'</p>
	              <p><a href="'.$site['url'].'gnc_'.$site['surum'].'.zip" class="btn  btn-lg btn-primary" role="button">'.$dil['indir_v'].'</a></p>
	            </div>
	          </div>
	        </div>
	        <div class="item">
	          <img src="'.$site['resim_yolu'].'slide-05.jpg" alt="Forth slide">
	          <div class="container">
	            <div class="carousel-caption" style="margin:0 600px 60px 0;">
	              <h1>'.$dil['slide5_baslik'].'</h1>
	              <p>'.$dil['slide5_icerik'].'</p>
	              <p><a href="'.$site['url'].'gnc_'.$site['surum'].'.zip" class="btn  btn-lg btn-primary" role="button">'.$dil['indir_v'].'</a></p>
	            </div>
	          </div>
	        </div>
	      </div>
	      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	    </div><!-- /.carousel -->
	
	
		<div class="container marketing">
			<div class="row">
				<h3 class="text-center">'.$dil['karsinizda_gnc'].'</h3>
			</div>
		</div><!--white-bg-full-->
		
		<hr class="featurette-divider">
		
	    <!-- Marketing messaging and featurettes
	    ================================================== -->
	    <!-- Wrap the rest of the page in another container to center all the content. -->
	
	    <div class="container marketing">
	
	      <!-- Three columns of text below the carousel -->
	      <div class="row">
	        <div class="col-lg-4">
	          <img class="img-circle" src="'.$site['resim_yolu'].'sub-home-01.jpg" alt="Generic placeholder image">
	          <h2>'.$dil['cms_baslik'].'</h2>
	          <p>'.$dil['cms_icerik'].'</p>
	        </div><!-- /.col-lg-4 -->
	        <div class="col-lg-4">
	          <img class="img-circle" src="'.$site['resim_yolu'].'sub-home-02.jpg" alt="Generic placeholder image">
	          <h2>'.$dil['anlasilir_baslik'].'</h2>
	          <p>'.$dil['anlasilir_icerik'].'</p>
	        </div><!-- /.col-lg-4 -->
	        <div class="col-lg-4">
	          <img class="img-circle" src="'.$site['resim_yolu'].'sub-home-03.jpg" alt="Generic placeholder image">
	          <h2>'.$dil['hizli_guvenilir_baslik'].'</h2>
	          <p>'.$dil['hizli_guvenilir_icerik'].'</p>
	        </div><!-- /.col-lg-4 -->
	      </div><!-- /.row -->
		  
		  <hr>
		  
		  <div class="well well-large centered">
			<h3>'.$dil['ucretsiz_acik_kaynak_baslik'].'</h3>
			<p>'.$dil['ucretsiz_acik_kaynak_icerik'].'</p>
		  </div><!--/well-->
			
	      <!-- START THE FEATURETTES -->
	
	      <hr>
		  <div class="row featurette">
	        <div class="col-md-7">
	          <h2 class="featurette-heading">Hadi <span class="text-muted"> başlayalım...</span></h2>
	          <p class="lead">CI, Wordpress, Joomla gibi sistemlerin aksine GNC\'de PHP\'nin temel klavuzu dışında her hangi bir klavuza gerek yoktur. Anlaşılır ve sade olan bu sistemi tanımak için video anlatımı izleyiniz.</p>
	        </div>
	        <div class="col-md-5">
	          <img class="featurette-image img-responsive" src="'.$site['resim_yolu'].'mid-home-01.png" alt="Generic placeholder image">
	        </div>
	      </div>
	
	      <hr>
	
	      <div class="row featurette">
	        <div class="col-md-5">
	          <img class="featurette-image img-responsive" src="'.$site['resim_yolu'].'mid-home-02.png" alt="Generic placeholder image">
	        </div>
	        <div class="col-md-7">
	          <h2 class="featurette-heading">Neden <span class="text-muted">GNC?</span></h2>
	          <p class="lead">Hızlı, güvenli ve uluslararası yazım kurallarına uygun kod geliştirmek tüm geliştiricilerin hedefidir. Bunu hızla yapmak için ihtiyaca göre Joomla, CI, drupal, wordpress gibi CMS veya Framework\'leri en ince ayrıntısına kadar öğrenmek sıkıcı bir süreç olup geliştirciler için anlamsız bir zaman kaybına sebep olmaktadır. </br></br> İşte bu noktada GNC, size öğrenmek zorunda olmadığınız ve ihtiyacınız olan her şeyi içeren bir sistem sunmaktadır.</p>
	        </div>
	      </div>
	
	      <!-- /END THE FEATURETTES -->';

/*
require_once('forum/SSI.php');
ssi_login();
ssi_recentPosts();
*/
?>