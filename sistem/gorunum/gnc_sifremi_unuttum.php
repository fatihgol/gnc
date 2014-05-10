<?php
if (!defined('gnc'))
	die();


if ($_SESSION['kullanici_tipi'] > 99)
{
	header("Location:".$site['url'].'yonetim');
}
elseif ($_SESSION['kullanici_tipi'] > 1)
{
	header("Location:".$site['url']);
}
else 
{ 
	echo '	<!-- Login wrapper begins -->
			<div class="loginWrapper">
			
				<!-- Current user form -->
			    <form method="POST" action="'.$site['url'].'sifremi-unuttum" id="login">
			        <div class="loginPic">
			            <a href="#" title=""><img src="'. gnc_kullanici_resmi_goster($_SESSION['kullanici_id']).'" alt="" height="80"/></a>
			            <span>'. gnc_baslik() .'</span>
			        </div>
			        
			        <input type="text" name="kullanici_kullanici_adi" placeholder="'.$dil['eposta_adresinizi_yazin'].'" class="loginEmail" />
			        
			        <div class="logControl">
			            <div class="memory">
			            	<ul style="text-align: left; margin-left:10px; margin-top:-10px;">
			            		<li><a href="'.$site['url'].'giris">&raquo; '.$dil['giris'].'</a></li>
			            		<li><a href="'.$site['url'].'kayit">&raquo; '.$dil['kayit'].'</a></li>
			            		<li><a href="'.$facebook->getLoginUrl().'" target="_blank">&raquo; '.$dil['facebook_ile_baglan'].'</a></li>
			            	</ul>
			            	<!--
			            	<input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label>
			            	-->
			            </div>
			            <input type="submit" name="yonetim_kayit_submit" value="'.$dil['sifremi_unuttum'].'" class="buttonM bBlue" />
			            <div class="clear"></div>
			        </div>
			    </form>
			    
			</div>
			<!-- Login wrapper ends -->';
}
?>