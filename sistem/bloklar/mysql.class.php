<?php
/*
 * Veritabanı iletişimi sağlayan sınıf
 * 
 * Bu sınıfla birlikte php nin sağladığı mysql fonksiyonlarıda kullanılabilir. 
 * Ancak bu class ile yaratılan public fonksiyonların kullanımını şiddetle tavsiye ediyorum. 
 */
if (!defined('gnc'))
	die();

class vt_mysql
{

	var $link;
	var $recent_link = null;
	var $sql = '';
	var $query_count = 0;
	var $error = '';
	var $errno = '';
	var $is_locked = false;
	var $show_errors = false;
	
	function vt_mysql($db_host, $db_user, $db_pass, $db_name)
	{
		$this->link = @mysql_connect($db_host, $db_user, $db_pass);
		mysql_set_charset('utf8');
		
		if ($this->link)
		{
			if (@mysql_select_db($db_name, $this->link))
			{
				$this->recent_link =& $this->link;
				return $this->link;
			}
		}
		$this->raise_error("Veritabanına bağlanılamadı: $db_name");
	}

	/* Sorguyu çalıştıran fonksiyon */
	function query($sql, $only_first = false)
	{
		// $sql = $this->prepare($sql);
		$this->recent_link =& $this->link;
		$this->sql =& $sql;
		$result = @mysql_query($sql, $this->link);

		$this->query_count++;

		if ($only_first)
		{
			$return = $this->fetch_array($result);
			$this->free_result($result);
			return $return;
		}
		return $result;
	}

	/* Array olarak veri çeken fonksiyonlarımız */
	function fetch_array($result)
	{
		return @mysql_fetch_assoc($result);
	}
	function fetch_assoc($result)
	{
		return @mysql_fetch_assoc($result);
	}
	function fetch_row($result)
	{
		return @mysql_fetch_row($result);
	}
	
	/* Satır sayma fonksiyonumuz */
	function num_rows($result)
	{
		return @mysql_num_rows($result);
	}
	function num_fields($result)
	{
		return @mysql_num_fields($result);
	}

	/* Son sorgudan etkilenen satır sayısını gösteren fonksiyonumuz */
	function affected_rows()
	{
		return @mysql_affected_rows($this->recent_link);
	}

	/* Çalıştırılan sorgu sayısını gösteren fonksiyonumuz */
	function num_queries()
	{
		return $this->query_count;
	}

	/* Veritabanı tablolarını kilitler */
	/*
	function lock($tables)
	{
		if (is_array($tables) AND count($tables))
		{
			$sql = '';
			foreach ($tables AS $name => $type)
			{
				$sql .= (!empty($sql) ? ', ' : '') . "$name $type";
			}
			$this->query("LOCK TABLES $sql");
			$this->is_locked = true;
		}
	}
	*/

	/* Kilitleri kaldırır */
	/*
	function unlock()
	{
		if ($this->is_locked)
		{
			$this->query("UNLOCK TABLES");
			$this->is_locked = false; 
		}
	}
	*/

	/* Son girişi yapılan veriye ait idyi görüntüler */
	function insert_id()
	{
		return @mysql_insert_id($this->link);
	}

	/* Sorguyu güvenli hale getirir */
	function prepare($value, $do_like = true)
	{
		$value = stripslashes($value);
		if ($do_like)
			$value = str_replace(array('%', '_'), array('\%', '\_'), $value);
		
		if (function_exists('mysql_real_escape_string'))
			return mysql_real_escape_string($value, $this->link);
		else
			return mysql_escape_string($value);
	}

	/* İlgili sorgu sonucunu hafızadan temizler */
	function free_result($result)
	{
		return @mysql_free_result($result);
	}

	/* Veritabanı hata görüntülemesini etkinleştirir */
	function show_errors()
	{
		$this->show_errors = true;
	}

	/* Veritabanı hata görüntülemesini etkisiz kılar */
	function hide_errors()
	{
		$this->show_errors = false;
	}

	/* MySQL bağlantısını kapatır */
	function close()
	{
		$this->sql = '';
		return @mysql_close($this->link);
	}

	/* MySQL hata iletisini döndürür */
	function error()
	{
		$this->error = (is_null($this->recent_link)) ? '' : mysql_error($this->recent_link);
		return $this->error;
	}

	/* MySQL hata numarasını döndürür */
	function errno()
	{
		$this->errno = (is_null($this->recent_link)) ? 0 : mysql_errno($this->recent_link);
		return $this->errno;
	}

	/* Hatanın oluştuğu URL yolunu görüntüler */
	function _get_error_path()
	{
		if ($_SERVER['REQUEST_URI'])
		{
			$errorpath = $_SERVER['REQUEST_URI'];
		}
		else
		{
			if ($_SERVER['PATH_INFO'])
			{
				$errorpath = $_SERVER['PATH_INFO'];
			}
			else
			{
				$errorpath = $_SERVER['PHP_SELF'];
			}

			if ($_SERVER['QUERY_STRING'])
			{
				$errorpath .= '?' . $_SERVER['QUERY_STRING'];
			}
		}

		if (($pos = strpos($errorpath, '?')) !== false)
		{
			$errorpath = urldecode(substr($errorpath, 0, $pos)) . substr($errorpath, $pos);
		}
		else
		{
			$errorpath = urldecode($errorpath);
		}
		return $_SERVER['HTTP_HOST'] . $errorpath;
	}

	/* Veritabanı hatası bulunursa hatayı görüntüler ve scripti durdurur */
	function raise_error($error_message = '')
	{
		if ($this->recent_link)
		{
			$this->error = $this->error($this->recent_link);
			$this->errno = $this->errno($this->recent_link);
		}

		if ($error_message == '')
		{
			$this->sql = "Hata bulunan sorgu:\n\n" . rtrim($this->sql) . ';';
			$error_message =& $this->sql;
		}
		else
		{
			$error_message = $error_message . ($this->sql != '' ? "\n\nSQL:" . rtrim($this->sql) . ';' : '');
		}

		$message = "<textarea rows=\"10\" cols=\"80\">MySQL Hatası:\n\n\n$error_message\n\nHata: {$this->error}\nHata #: {$this->errno}\nDosya Adı: " . $this->_get_error_path() . "\n</textarea>";
		
		return $message;
	}
}
?>