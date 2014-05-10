<?php
/*
 * PDO classının extend edilmesiyle oluşturulan PDO ile veritabanı iletişimi sağlayan sınıf
 *
 * Bu sınıfla birlikte php 5.1'in sağladığı PDO fonksiyonlarıda kullanılabilir.
 * Bu class ile PDO fonksiyonlarının mySQL komutlarına benzer halleri yapılmış olup geliştirmeye açıktır.
 * 
 * Benzer kullanım için http://www.phpclasses.org/browse/file/35059.html adresine bakılabilir
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * 
 * $pdo çağırıldıktan sonra örnek kullanım;
 * 
 * $sorgu = $pdo->query("SELECT * FROM gnc_kullanicilar");
 * $sonuclar = $sorgu->fetch_array();
 * foreach ($sonuclar AS $sonuc)
 * 		echo $sonuc['kullanici_kullanici_adi'];
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 */
if (!defined('gnc'))
	die();

class gnc_pdo extends PDO 
{
	function __construct($vt_ayarlari)
	{
        try 
        {
        	/* Bağlantıyı sağla */
            parent::__construct($vt_ayarlari['veritabani_tipi'].':host='.$vt_ayarlari['sunucu_adresi'].';dbname='.$vt_ayarlari['veritabani_adi'].';'.$vt_ayarlari['karakter_seti'],$vt_ayarlari['kullanici_adi'],$vt_ayarlari['kullanici_sifresi'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            /* PDO Statement'larını gnc'nin mySQL fonksiyonlarına benzer hale getirmek için PDOStatement class'ını extend et*/
            $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('gnc_pdo_statement'));
			/* UPDATE edilen sorgularıda rowcount() fonksiyonuna dahil et */
			$this->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);
			
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch(PDOException $e)
        {                
            die('HATA: '. $e->getMessage());
        }
    }
	/* Son girişi yapılan veriye ait idyi görüntüler. Dikkat: Kullanımı statement gibi değildir. $pdo->insert_id() şeklinde çalışır. */
	public function insert_id()
	{
		return $this->lastInsertId();
	}
}
/* PDO Statementları için extend edilen class'ımız. 
 * 
 * mysql.class.php deki fonksiyonlara benzer yapıda kullanım esas alınmıştır. 
 * Ancak PDO'nun yapısı gereği fonksiyon kullanımlarında farklılıklar bulunmaktadır.
 */
class gnc_pdo_statement extends PDOStatement 
{
    // Veriyi getirmek için fetchAll(PDO::FETCH_ASSOC) fonksiyonunu mysql_fetch_assoc() fonksiyonu haline getirelim.
    public function fetch_array()
    {
        return $this->fetchAll(PDO::FETCH_ASSOC);
    }
	public function fetch_assoc($result)
	{
		return $this->fetchAll(PDO::FETCH_ASSOC);
	}
	/* Satır sayma fonksiyonumuz */
	public function num_rows()
	{
		return $this->rowcount();
	}
	/* Son sorgudan etkilenen satır sayısını gösteren fonksiyonumuz */
	public function affected_rows()
	{
		return $this->rowcount();
	}
}
?>