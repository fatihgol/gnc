<?php
if (!defined('gnc'))
	die();

/* ePosta adresini çalmayı amaçlayan bot'lara engel olmak için ePosta adresini koda dönüştüren fonksiyon. Özellikle 
 * <a href="mailto:eposta_adresi">mail gönder</a> tipi kullanımlarda eposta_adresini bu fonksiyondan geçirmek gerekmektedir.
 * 
 * @param string $ePosta, ePosta adresi
 * @param int 	 $mailto isteğe bağlı. Encoding işlemi için kullanılır
 * @return string Converted email address.
 * 
 * http://core.trac.wordpress.org/browser/tags/3.6.1/wp-includes/formatting.php adresinden alınmıştır.
*/
function gnc_mail_adresini_gizle($ePosta, $mailto=1) 
{
	$email_NO_SPAM_addy = '';
	srand ((float) microtime() * 1000000);
	for ($i = 0; $i < strlen($ePosta); $i = $i + 1) 
	{
		$j = floor(rand(0, 1+$mailto));
		if ($j==0) 
			$email_NO_SPAM_addy .= '&#'.ord(substr($ePosta,$i,1)).';';
		elseif ($j==1)
				$email_NO_SPAM_addy .= substr($ePosta,$i,1);
		elseif ($j==2)
			$email_NO_SPAM_addy .= '%'.gnc_sifirla(dechex(ord(substr($ePosta, $i, 1))), 2);
	}
	$email_NO_SPAM_addy = str_replace('@','&#64;',$email_NO_SPAM_addy);
	return $email_NO_SPAM_addy;
}
/* Gerekli olduğunda sıfır ekleyen fonksiyon
 * 
 * Örnekle açıklamak gerekirse; 
 * Eğer $basamak '4' olarak belirlenmiş ancak sayi '10' ise fonksiyon 0010 döndürecektir.
 * 
 * http://core.trac.wordpress.org/browser/tags/3.6.1/wp-includes/formatting.php adresinden alınmıştır.
 */
function gnc_sifirla($sayi, $basamak) {
	return sprintf('%0'.$basamak.'s', $sayi);
}
?>