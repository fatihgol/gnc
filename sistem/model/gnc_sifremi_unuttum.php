<?php
if (!defined('gnc'))
	die();

if (!empty($_POST['kullanici_kullanici_adi']))
{
	require_once('sistem/model/gnc_giris.php');
	$kullanici = new kullanici();
	$kullanici->kullanici_sifremi_unuttum($_POST['kullanici_kullanici_adi']);
}					
?>