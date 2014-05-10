<?php
if (!defined('gnc'))
	die();

echo '	<div class="page-header">
			<div class="container">
				<h1>'.$dil['iletisim'].' <small>'.$dil['benim_iletisime_gecin_birlikte_biz_olalim'].'</small></h1>
			</div><!--/container-->
		</div><!--/page-header-->
		
		<div class="container inner-page" id="contact">
		        
		    <form class="form-horizontal" role="form">
		    	<h2>'.$dil['formu_doldurun'].'</h2>
		        <p>'.$dil['iletisim_aciklama_1'].'<a href="mailto:'.gnc_mail_adresini_gizle($ayar['iletisim_eposta']).'"> '.$dil['buraya_tıklayarakta'].' </a>'.$dil['iletisim_aciklama_2'].'</p>
				<div class="row">
	        		<div class="col-lg-6">
						<div class="form-group">
						    <label for="inputEmail3" class="col-sm-4 control-label">'.$dil['iletisim_adınız_soyadınız'].'</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="inputEmail3" placeholder="">
						    </div>
						</div>
						<div class="form-group">
						    <label for="inputPassword3" class="col-sm-4 control-label">'.$dil['iletisim_ePosta'].'</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="inputPassword3" placeholder="">
						    </div>
						</div>
						<div class="form-group">
						    <label for="inputPassword3" class="col-sm-4 control-label">'.$dil['iletisim_mesajınız'].'</label>
						    <div class="col-sm-8">
						      <textarea class="form-control" rows="3"></textarea>
						    </div>
						</div>
						<div class="form-group">
						    <div class="col-sm-offset-4 col-sm-8">
						      <button type="submit" class="btn btn-default">'.$dil['gonder'].'</button>
						    </div>
						</div>
					</div>
					<div class="col-lg-6">
						<iframe width="550" height="300" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;sll=38.376115,27.097778&amp;sspn=3.34935,8.453979&amp;ie=UTF8&amp;hq=&amp;ll=38.376115,27.097778&amp;spn=0.202794,0.52803&amp;z=7&amp;iwloc=A&amp;output=embed"></iframe>
					</div>
				</div>
			</form>';
?>