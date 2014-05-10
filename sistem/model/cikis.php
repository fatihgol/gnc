<?php  
if (!defined('gnc'))
	die();

if ($_SESSION['kullanici_tipi'] > 100)
{
	require_once('sistem/model/yonetim/gnc.php');
	gnc_cache_klasorunu_temizle();	
}	
session_destroy();
header('Location: '.$site['url'].'');
?>