<?php
if (!defined('gnc'))
	die();

/* Form nesnesi yaratan fonksiyon 
 * 
 * @param string $tip Optional - form elemanının açma / kapama etiketimi olacağını belirten değişken, boşsa kapatma etiketi kullanılır
 * @return string - form elemanının ilgili etiketi
 */
function form($tip = 'kapat', $action = null){
	global $adres, $site;
	
	if (empty($action))
		$action = $adres['mevcut'];
	
	if ($tip == 'kapat')
		echo '</form>';
	else
		echo '<form enctype="multipart/form-data" method="post" action="'.$action.'">';
}
// Input, textarea vs. oluşturmak için kolaylaştırıcı fonksiyon
function input($metin = '', $class = '', $id = '', $name = '', $placeholder = '', $type="text"){
	echo '<input class="'.$class.'" id="'.$id.'" name="'.$name.'" placeholder="'.$placeholder.'" type="'.$type.'" value="'.$metin.'"/>';
}
function textarea($metin = '', $class = '', $id = '', $name = '', $placeholder = ''){
	echo '<textarea class="'.$class.'" id="'.$id.'" name="'.$name.'" placeholder="'.$placeholder.'">'.$metin.'</textarea>';	
}
function a($metin, $href, $class = '', $id = '', $target = 'self'){
	echo '<a class="'.$class.'" href="'.$href.'" id="'.$id.'" target="'.$target.'">'.$metin.'</a>';
}
function p($metin){
	echo '<p>'.$metin.'</p>';
}
function h($metin, $boyut = 5){
	echo '<h'.$boyut.'>'.$metin.'</h'.$boyut.'>';
}
function img($src, $alt){
	echo '<img src="boat.gif" alt="Big Boat">';
}
/* Listeleme fonksiyonu
 * 
 * Elemanları array olarak alır, tip değeride ul ve ol olabilir
 */
function liste($elemanlar, $tip = 'ul')
{	
	echo '	<'.$tip.'>';
	$say = count($elemanlar);
	for ($i=0; $i<$say; $i++)
		echo '<li>'.$elemanlar[$i].'</li>';
	echo '	</'.$tip.'>';
			
}
function video($src, $type, $width = 320, $height = 240)
{
	global $dil;
	echo '	<video width="'.$width.'" height="'.$height.'" controls>
				<source src="movie.mp4" type="video/mp4">
				<source src="movie.ogg" type="video/ogg">
				'.$dil['tarayiciniz_bu_videoyu_desteklemiyot'].'
			</video>';
}

/* Türkçe karakterleri işlemek için strtoupper,strtolower, ucfirst, ucwords fonksiyonlarını düzenleyelim
 * 
 * Bu fonksiyonlar http://eren.co/turkce-ucwords-ucfirst-strtoupper-strtolower/ adresinden alınmıştır. 
 * Katkılarından dolayı Eren Yaşarkurt'a tekrar teşekkür ederim.
 * 
 * NOT: mb_strtoupper() gibi fonksiyonlarıda kullanmak işe yarayacaktır.
 */
$kucuk = array('ç', 'ğ', 'i', 'ı', 'ö', 'ş', 'ü');
$buyuk = array('Ç', 'Ğ', 'İ', 'I', 'Ö', 'Ş', 'Ü');

function tr_strtoupper($metin)
{
	global $kucuk, $buyuk;
	return strtoupper(str_replace($kucuk, $buyuk, $metin));
}

function tr_strtolower($metin) 
{
	global $kucuk, $buyuk;
	return strtolower(str_replace($buyuk, $kucuk, $metin));
}

function tr_ucfirst($str, $e='utf-8') 
{
	$fc = tr_strtoupper(mb_substr($str, 0, 1, $e), $e);
	return $fc.mb_substr($str, 1, mb_strlen($str, $e), $e);
}

function tr_ucwords($metin)
{
	$kelime = explode(" ", $metin);

	$son = NULL;
	$ilk = true;
	$say = count($kelime);

	foreach ($kelime as $oge)
	{
		$son .= tr_ucfirst($oge);
		$son .= ' ';
		$ilk = false;
	}
	return $son;
}
/* HTML elemanlarında kullanım için kolaylaştırıcı fonksiyonlar
 * http://core.trac.wordpress.org/browser/tags/3.6.1/wp-includes/general-template.php adresinden alınmıştır
 * 
 * checked(true); gibi kullanılır, 
 * ilk parametre ile ikinci parametre uyuştuğunda checked='checked' değerini döndürür. 
 */
function checked($checked, $current = true, $echo = true){
	return __checked_selected_helper($checked, $current, $echo, 'checked');
}
function selected($selected, $current = true, $echo = true){
	return __checked_selected_helper($selected, $current, $echo, 'selected');
}
function disabled($disabled, $current = true, $echo = true){
	return __checked_selected_helper($disabled, $current, $echo, 'disabled');
}
function __checked_selected_helper($helper, $current, $echo, $type){
	if ((string)$helper === (string)$current)
		$result = " $type='$type'";
	else
		$result = '';

	if ($echo)
		echo $result;
	else
		return $result;
}
/* Değere göre tekil yada çoğul ifadeyi dil dosyasından çekmeyi sağlayan fonksiyon. */
function n($tekil, $cogul, $deger){
	global $dil;
	
	if ($deger > 1)
		return $deger.' '.$dil[$cogul];
	else
		return $deger.' '.$dil[$tekil]; 
}
function _n($tekil, $cogul, $deger){
	global $dil;
	
	if ($deger > 1)
		return $deger.' '.$cogul;
	else
		return $deger.' '.$tekil; 
}
// Dinamik form elemanları yaratmak için
function element($tip, $name, $value, $placeholder = null){
	switch($tip)
	{
		case 'text':
			echo '<input type="text" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'">';
			break;
		case 'password':
			echo '<input type="password" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'">';
			break;
		case 'file':
			echo '<input type="file" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'">';
			break;
		case 'textarea':
			echo '<textarea name="'.$name.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
			break;
	}
}
function str_replace_first($search, $replace, $subject) {
    return implode($replace, explode($search, $subject, 2));
}
?>