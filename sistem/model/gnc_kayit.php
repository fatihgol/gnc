<?php
if (!defined('gnc'))
	die();

if (isset($_POST['kullanici_kullanici_adi']) && isset($_POST['kullanici_sifre1']) && isset($_POST['kullanici_sifre2']))
{
	require_once('sistem/model/gnc_giris.php');
	$kullanici = new kullanici();
	$kullanici->kullanici_kayit($_POST['kullanici_kullanici_adi'],$_POST['kullanici_sifre1'],$_POST['kullanici_sifre2']);
}					
?>