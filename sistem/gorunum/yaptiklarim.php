<?php
if (!defined('gnc'))
	die();

echo '	<div class="container marketing">
			<div class="page-header">
				<div class="container">
					<h1>'.$dil['yaptiklarim'].' <small>'.$dil['sizin_icin_sectiklerim'].'</small></h1>
				</div><!--/container-->
			</div><!--/page-header-->
			<div class="container">
			  <div class="row featurette col-md-12">';
		        
				if (!empty($yaptiklarim))
				{
					$i=0;
					foreach ($yaptiklarim AS $sonuc)
					{
						echo '	<div class="col-sm-6 col-md-3">
									<div class="thumbnail">
										<img src="'.$sonuc['icerik_kucuk_resim'].'" alt="" class="img-rounded"/>
										<div class="caption">
											<h5>'. gnc_yaziyi_kisalt($sonuc['icerik_baslik'],20).'</h5>
				          					<p class="lead" style="height:70px;">'. gnc_yaziyi_kisalt($sonuc['icerik_ozet'],70).'</p>
				          					<p class="text-center"><a href="sayfa/'.$sonuc['icerik_sef'].'" class="btn btn-primary" role="button">Devamını oku</a>
			          					</div>
		          					</div>
		          				</div>';
					}
				}
		      
		      echo '  
		      </div>
			</div>';