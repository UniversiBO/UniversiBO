<?php


/**
 * La classe Forum fornisce un'API esterna per le operazioni sul forum PHPBB 2.0.x
 * 
 * Rispettando le interfacce messe a disposizione si possono creare
 * API per altri tipi di forum.
 * La classe deve essere instanziata per ovviare al problema delle varibili statiche.
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class ForumApi
{
	
	/**
	 * @access private
	 */
	var $database = 'main';
	
	/**
	 * @access private
	 */
	var $table_prefix = 'phpbb_';
	
	/**
	 * @access private
	 */
	var $forumPath = 'forum/';

	/**
	 * esegue la codifica esadecimale di un ipv4 nel formato separato da punti
	 * es: '127.0.0.1' -> '7f000001'
	 *
	 * @access private
	 * @static
	 * @param string codifica separata da punti di un numero ip
	 * @return string codifica esadecimale del numero ip
	 */
	function _encodeIp($dotquad_ip)
	{
		$ip_sep = explode('.', $dotquad_ip);
		return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
	}


	/**
	 * @return string: id di sessione del forum 'sid=f454e54ea75ae45aef75920b02751ac' altrimenti false
	 */
	function getSid()
	{
		//echo $_SESSION['phpbb_sid'];
		if (array_key_exists('phpbb_sid', $_SESSION) && $_SESSION['phpbb_sid']!='') return 'sid='.$_SESSION['phpbb_sid'];
		return '';
	}


	/**
	 * @return string path della cartella in cui si trova il forum
	 */
	function getPath()
	{
		return $this->forumPath;
	}


	/**
	 * Esegue il login sul forum, si suppone che la password sia già stata controllata.
	 * Inserisce le informazioni di sessione e cookie per mantenere traccia dell'utente
	 * Se l'opreazione avviene con successo viene impostata nella sessione la variabile 'phpbb_sid'
	 * 
	 * @static 
	 * @param User Oggetto User che deve effettuare l'accesso al fourm
	 */
	function login($user)
	{
		
		//mappa informazioni salvate nei cookie da phpbb2
		
		//var_dump(unserialize(stripslashes($_COOKIE['phpbb2_data'])));
		// array(2) { ["autologinid"]=> string(0) "" ["userid"]=> string(2) "81" } 
		
		$db =& FrontController::getDbConnection($this->database);
		
		$query = 'SELECT config_name, config_value FROM '.$this->table_prefix.'config WHERE config_name IN ('.
					$db->quote('cookie_path').','.
					$db->quote('cookie_secure').','.
					$db->quote('cookie_domain').')';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		if( $rows != 3) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Impossibile trovare le informazioni di configurazione del forum','file'=>__FILE__,'line'=>__LINE__)); 
		while (	$res->fetchInto($row) )
		{
			${$row[0]} = $row[1];
		}
		//echo $cookie_domain;
		//echo $cookie_path;
		//echo $cookie_secure;

		$phpbb2_cookie = array();
		$phpbb2_cookie['autologinid'] = ''; 
		$phpbb2_cookie['userid'] = (string)$user->getIdUser() ; 
		$cookie_value = serialize($phpbb2_cookie);
		setcookie ('phpbb2_data', $cookie_value, time()+3600, $cookie_path, $cookie_domain , $cookie_secure);
		
		$sid = md5(uniqid(rand(),1));
		
		$query = 'INSERT INTO '.$this->table_prefix.'sessions (session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in) VALUES ('.
			$db->quote($sid).', '.$user->getIdUser().', '.time().', '.time().', '.$db->quote($this->_encodeIp($_SERVER['REMOTE_ADDR'])).', 0, 1)';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 

		$_SESSION['phpbb_sid'] = $sid;
		
	}
	
	/**
	 * Esegue il logout dal forum.
	 * Distrugge la sessione e il cookie
	 * 
	 * @static 
	 */
	function logout()
	{
		
		$db =& FrontController::getDbConnection($this->database);
		
		$query = 'SELECT config_name, config_value FROM '.$this->table_prefix.'config WHERE config_name IN ('.
					$db->quote('cookie_path').','.
					$db->quote('cookie_secure').','.
					$db->quote('cookie_domain').')';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		if( $rows != 3) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Impossibile trovare le informazioni di configurazione del forum','file'=>__FILE__,'line'=>__LINE__)); 
		while (	$res->fetchInto($row) )
		{
			${$row[0]} = $row[1];
		}

		$cookie_value = '';
		setcookie ('phpbb2_data', $cookie_value, time()+3600, $cookie_path, $cookie_domain , $cookie_secure);
		
		$query = 'DELETE FROM '.$this->table_prefix.'sessions WHERE session_id = '.$db->quote(ForumApi::getSid()).';';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));

		$_SESSION['phpbb_sid'] = '';
		
	}

	/**
	 * @return mixed string: id di sessione del forum 'sid=f454e54ea75ae45aef75920b02751ac' altrimenti false
	 */
	function getMainUri()
	{
		return $this->getPath().'index.php?'.ForumApi::getSid();
	}


	/**
	 * @param  int   $id_forum  
	 * @return mixed string: id di sessione del forum 'sid=f454e54ea75ae45aef75920b02751ac' altrimenti false
	 */
	function getForumUri($id_forum)
	{
		return $this->getPath().'viewforum.php?f='.$id_forum.'&'.ForumApi::getSid();
	}


}



?>