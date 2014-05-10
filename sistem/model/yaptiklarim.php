<?php
if (!defined('gnc'))
	die();

require_once('sistem/model/blog.php');

// Kategori_id'si 1 olan içeriklerin tamamını göster
$yaptiklarim = gnc_icerikler(1);
shuffle($yaptiklarim);
?>