<?php
require_once('User'.PHP_EXTENSION);

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
	 * Identificativo di connessione al database da utilizzare
	 * @access private
	 */
	var $database = 'main';
	
	/**
	 * Prefisso del nome delle tabelle del database
	 * @access private
	 */
	var $table_prefix = 'phpbb_';
	
	/**
	 * Cartella percorso dell'url del forum
	 * @access private
	 */
	var $forumPath = 'forum/';

	/**
	 * Stile del forum di default - implica la modifica anche nella tabella di config di phpbb
	 * @access private
	 */
	var $defaultUserStyle = array('unibo' => 1, 'black' => 7);

	/**
	 * Ranks e livelli da assegnare agli utenti inizialmente
	 * @access private
	 */
	var $defaultRanks = array(USER_STUDENTE => 0, USER_COLLABORATORE => 9, USER_TUTOR => 10, USER_DOCENTE => 11, USER_PERSONALE => 12, USER_ADMIN =>  1);


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
	 * Esegue il login sul forum, si suppone che la password sia gi? stata controllata.
	 * Inserisce le informazioni di sessione e cookie per mantenere traccia dell'utente
	 * Se l'opreazione avviene con successo viene impostata nella sessione la variabile 'phpbb_sid'
	 * 
	 * @static 
	 * @param User Oggetto User che deve effettuare l'accesso al forum
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
					$db->quote('cookie_domain').','.
					$db->quote('cookie_name').')';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		if( $rows != 4) 
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
		
		setcookie ($cookie_name.'_data', $cookie_value, time()+3600, $cookie_path, $cookie_domain , $cookie_secure);
		
		$sid = md5(uniqid(rand(),1));
		
		setcookie ($cookie_name.'_sid', $sid, time()+3600, $cookie_path, $cookie_domain , $cookie_secure);
		
		$query = 'INSERT INTO '.$this->table_prefix.'sessions (session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in) VALUES ('.
			$db->quote($sid).', '.$user->getIdUser().', '.time().', '.time().', '.$db->quote($this->_encodeIp($_SERVER['REMOTE_ADDR'])).', 0, 1)';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
//		$query = 'UPDATE '.$this->table_prefix.'_users SET user_lastvisit = '.time();
//		$res = $db->query($query);
//		if (DB::isError($res)) 
//			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		
		
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
					$db->quote('cookie_domain').','.
					$db->quote('cookie_name').')';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		if( $rows != 4) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Impossibile trovare le informazioni di configurazione del forum','file'=>__FILE__,'line'=>__LINE__)); 
		while (	$res->fetchInto($row) )
		{
			${$row[0]} = $row[1];
		}

		$cookie_value = '';
		
		//bug qui: errore nome cookie
		setcookie ($cookie_name.'_data', $cookie_value, time()+3600, $cookie_path, $cookie_domain , $cookie_secure);
		
		setcookie ($cookie_name.'_sid', '', time()-3600, $cookie_path, $cookie_domain , $cookie_secure);
		
		$query = 'DELETE FROM '.$this->table_prefix.'sessions WHERE session_id = '.$db->quote(ForumApi::getSid()).';';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));

		$_SESSION['phpbb_sid'] = '';
		
	}
	
	
	/**
	 * Crea un nuovo utente sul database del forum dato uno User
	 * 
	 * @todo renderla funzionante anche per utenti che appartengono a pi? gruppi
	 * @static 
	 */
	function insertUser($user)
	{
		
		$db =& FrontController::getDbConnection($this->database);
		if ($user->isOspite()) return;

		$groups = $user->getGroups();
		if ( $groups != USER_OSPITE && $groups != USER_STUDENTE && $groups != USER_COLLABORATORE && $groups != USER_TUTOR && $groups != USER_DOCENTE && $groups != USER_PERSONALE && $groups != USER_ADMIN ) return;
		// @todo renderla funzionante anche per utenti che appartengono a pi? gruppi
		
		$user_style = $this->defaultUserStyle[$user->getDefaultStyle()];
		$user_rank  = $this->defaultRanks[$groups];
		$user_level = ( $user->isAdmin() == true ) ? 1 : ( $user->isCollaboratore() == true ) ? 2 : 0 ;
		
		require_once('Krono'.PHP_EXTENSION);
		$user_timezone =  (Krono::_is_daylight(time()) == true) ? 2 : 1;
		
		if ($user->isDocente() || $user->isTutor()){
			$user_notify_pm = 0;
			$user_popup_pm = 0;
		}
		else{
			$user_notify_pm = 1;
			$user_popup_pm = 1;
		}
		
		$query = 'INSERT INTO '.$this->table_prefix.'users (user_id, user_active, username, user_regdate, user_password, user_session_time, user_session_page, user_lastvisit, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_sig_bbcode_uid, user_style, user_aim, user_yim, user_msnm, user_posts, user_new_privmsg, user_unread_privmsg, user_last_privmsg, user_emailtime, user_viewemail, user_attachsig, user_allowhtml, user_allowbbcode, user_allowsmile, user_allow_pm, user_allowavatar, user_allow_viewonline, user_rank, user_avatar, user_avatar_type, user_level, user_lang, user_timezone, user_dateformat, user_notify_pm, user_popup_pm, user_notify, user_actkey, user_newpasswd)
					VALUES('.$db->quote($user->getIdUser()).', 1, '.$db->quote($user->getUsername()).', '.$db->quote(time()).','.$db->quote($user->getPasswordHash()).', 0, 0, 0,'.$db->quote($user->getEmail()).', \'\', \'\', \'\', \'\', \'\', \'\', \'          \', '.$user_style.', \'\', \'\', \'\', 0, 0, 0, 0, NULL, 0, 1, 0, 1, 1, 1, 1, 1, '.$user_rank.', \'\', 0, '.$user_level.', '.$db->quote('italian').', '.$user_timezone.', '.$db->quote('D d M Y G:i').', '.$user_notify_pm.', '.$user_popup_pm.', 0, \'\', \'\')';
		
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
	}



	/**
	 * Modifca lo stile di un utente sul database del forum dato uno User
	 */
	function updateUserStyle($user)
	{
		
		$db =& FrontController::getDbConnection($this->database);
		if ($user->isOspite()) return;

		$user_style = $this->defaultUserStyle[$user->getDefaultStyle()];
		
		$query = 'UPDATE '.$this->table_prefix.'users SET user_style = '.$db->quote($user_style).' WHERE user_id = '.$db->quote($user->getIdUser());
		
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
	}



	/**
	 * Modifca la password di un utente sul database del forum dato uno User
	 * 
	 * @static 
	 */
	function updatePasswordHash($user)
	{
		
		$db =& FrontController::getDbConnection($this->database);
		if ($user->isOspite()) return;

		$query = 'UPDATE '.$this->table_prefix.'users SET user_password = '.$db->quote($user->getPasswordHash()).' WHERE user_id = '.$db->quote($user->getIdUser());
		
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
	}


	/**
	 * Aggiunge un utente ad un gruppo di moderazione sul database del forum
	 * 
	 * @static 
	 */
	function addUserGroup($user, $group)
	{
		
		$db =& FrontController::getDbConnection($this->database);

		$query = 'SELECT * FROM '.$this->table_prefix.'user_group WHERE group_id = '.$db->quote($group).' AND user_id = '.$db->quote($user);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		if ($res->numRows() > 0 ) return;
		
		$query = 'INSERT INTO '.$this->table_prefix.'user_group (group_id, user_id, user_pending) VALUES ('.$db->quote($group).', '.$db->quote($user).', 0)';
		
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
	}


	/**
	 * Remove un utente ad un gruppo di moderazione sul database del forum
	 * 
	 * @static 
	 */
	function removeUserGroup($user, $group)
	{
		
		$db =& FrontController::getDbConnection($this->database);

		$query = 'DELETE FROM '.$this->table_prefix.'user_group WHERE group_id = '.$db->quote($group).' AND user_id = '.$db->quote($user);
		
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
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