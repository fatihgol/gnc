<?php
if (!defined('gnc'))
	die();


echo '	<div class="container marketing">
			<div class="page-header">
				<div class="container">
					<h1>'.$dil['hakkimda'].' <small>'.$dil['gunce_kimdir_baslik'].'</small></h1>
				</div><!--/container-->
			</div><!--/page-header-->
			<div class="container">
			  <div class="row featurette">
		        <div class="col-md-6">
		          <h2>'.$dil['karsinizda_ben_baslik'].'</h2>
		          <p class="lead">'.$dil['karsinizda_ben_icerik'].'</p>
		        </div>
		        <div class="col-md-6">
		          <img src="sistem/tasarim/img/ben_yon_gosteriyorum.jpg" alt=""/>
		        </div>
		      </div>
		      
		      <hr class="featurette-divider">
		      	
		      <div class="row featurette">
		      	<div class="col-md-6">
		          <img src="sistem/tasarim/img/top10k.png" alt=""/>
		        </div>
		        <div class="col-md-6">
		          <h2>'.$dil['hedefim_baslik'].'</h2>
		          <p class="lead">'.$dil['hedefim_icerik'].'</p>
		        </div>
		      </div>
		      <div class="row featurette">
		      	<div class="col-md-12">
		      	  <h2>'.$dil['en_iyiler_baslik'].'</h2>
		          <p class="lead">'.$dil['en_iyiler_icerik'].'</p>
		      	</div>  
		      </div>
			</div>';
?>