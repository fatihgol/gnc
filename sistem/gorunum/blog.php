<?php
if (!defined('gnc'))
	die();

echo '	<div class="container marketing">
			<div class="page-header">
				<div class="container">
					<h1>Blog <small>'.$dil['gelistirici_ve_yatirimcilar_icin'].'</small></h1>
				</div><!--/container-->
			</div><!--/page-header-->
			<div class="container">
			  <div class="row featurette col-md-9">
			  	';
		        
				if (!empty($tum_icerikler))
				{
					foreach ($tum_icerikler AS $sonuc)
					{
						echo '	<div class="col-sm-6 col-md-4">
									<div class="thumbnail">
										<img src="'.$sonuc['icerik_kucuk_resim'].'" alt="" class="img-rounded" style="height:115px;"/>
										<div class="caption">
											<h5>'.gnc_yaziyi_kisalt($sonuc['icerik_baslik'],20).'</h5>
				          					<p class="lead" style="height:70px;">'. gnc_yaziyi_kisalt($sonuc['icerik_ozet'],70).'</p>
				          					<p class="text-center"><a href="sayfa/'.$sonuc['icerik_sef'].'" class="btn btn-primary" role="button">Devamını oku</a>
			          					</div>
		          					</div>
		          				</div>';
					}
				}
		      
		      echo '  
		      </div>
		      <div class="col-md-3">
		      	
				<div class="panel-group" id="accordion">
				  <div class="panel panel-default">
				    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
				        <div class="panel-heading">
					      <h4 class="panel-title">
					          '.$dil['en_son_yazilanlar'].'
					      </h4>
					    </div>
					</a>
				    <div id="collapseOne" class="panel-collapse collapse in">
				      <div class="panel-body">
				        <ul>';
							if (!empty($son_icerikler))
							{
								foreach($son_icerikler AS $yazi)
									echo '<li><a href="'.$site['url'].'sayfa/'.$yazi['icerik_sef'].'"><i class="icon-angle-right"></i> '.$yazi['icerik_baslik'].'</a></li>';
							}
						echo ' 
						</ul>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					          '.$dil['tarihe_gore_yazilar'].'
					        
					      </h4>
					    </div>
				    </a>
				    <div id="collapseTwo" class="panel-collapse collapse">
				      <div class="panel-body">
				        <ul>';
							if (!empty($tarihe_gore_icerikler))
							{
								foreach($tarihe_gore_icerikler AS $yazi)
									echo '<li><a href="'.$site['url'].'sayfa/'.$yazi['icerik_sef'].'"><i class="icon-angle-right"></i> '.$yazi['icerik_baslik'].'</a></li>';
							}
						echo ' 
						</ul>
				      </div>
				    </div>
				  </div>
				</div>
		      
		      </div>
			</div>';
