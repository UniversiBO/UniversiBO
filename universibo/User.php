<?php

define('USER_OSPITE'     ,1);
define('USER_STUDENTE'   ,2);
define('USER_MODERATORE' ,4);
define('USER_TUTOR'      ,8);
define('USER_DOCENTE'    ,16);
define('USER_PERSONALE'  ,32);
define('USER_ADMIN'      ,64);
define('USER_ALL'        ,127);


/**
 * User class
 *
 * @package universibo
 * @version 2.0.0
 * @author  Ilias Bartolini
 * @license http://www.opensource.org/licenses/gpl-license.php
 */

class User {
	
	var $id_utente = 0;
	var $groups = 0;
	var $MD5 = '';
	var $ultimoLogin = 0;
	var $username = '';
	var $email = '';
	var $bookmark;
	var $ADUsername = '';
	
	
	/**
	 *  Verifica se la sintassi dello username ט valido.
	 *  Sono permessi fino a 25 caratteri: alfanumerici, lettere accentate, spazi, punti, underscore
	 *
	 * @static
	 * @param string $username stringa dello username da verificare
	 * @return boolean
	 */
	function isUsernameValid( $username )
	{
		$username_pattern='^([[:alnum:]אטעילש ._]{1,25})$';
		return ereg($username_pattern , $username );
	}
	


	/**
	 *  Verifica se la sintassi della password ט valida.
	 *  Lunghezza min 5, max 30 caratteri
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return boolean
	 */
	function isPasswordValid( $password )
	{
		//$password_pattern='^([[:alnum:]]{5,30})$';
		//ereg($password_pattern , $password );
		$length = strlen( $password );
		return ( $length > 5 && $length < 30 );
	}
	 
	
	
	/**
	 * Genera una password casuale
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return boolean
	 */
	function generateRandomPassword()
	{
		$chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
		$max_chars = count($chars) - 1;
		
        $hash = md5(microtime());
        $loWord = substr($hash, -8);
        $seed = hexdec($loWord);
        $seed &= 0x7fffffff;
		
		mt_srand( $seed );
	
		$rand_str = '';
		for($i = 0; $i < 8; $i++)
		{
			$rand_str = $rand_str . $chars[mt_rand(0, $max_chars)];
		}

		return $rand_str;
	}
	

	
	/**
	 * Restituisce l'array associativo del codice dei gruppi e 
	 * della corrispettiva stringa descrittiva.
	 *
	 * @static
	 * @param boolean $singolare 
	 * @return array
	 */
	function groupsNames( $singolare = true )
	{
		if ( $singolare == true )
		{
			return array(
			 USER_OSPITE     => "Ospite",
			 USER_STUDENTE   => "Studente",
			 USER_MODERATORE => "Moderatore",
			 USER_TUTOR      => "Tutor",
			 USER_DOCENTE    => "Docente",
			 USER_PERSONALE  => "Personale non docente",
			 USER_ADMIN      => "Admin");
		} 
		else
		{
			return array(
			 USER_OSPITE     => "Ospiti",
			 USER_STUDENTE   => "Studenti",
			 USER_MODERATORE => "Moderatori",
			 USER_TUTOR      => "Tutor",
			 USER_DOCENTE    => "Docenti",
			 USER_PERSONALE  => "Personale non docente",
			 USER_ADMIN      => "Admin");
		}	
	}



	/**
	 * Restituisce true se lo username specificato ט giא registrato sul DB
	 *
	 * @param string $username username da ricercare
	 * @return boolean
	 */
	function usernameExists( $username )
	{
		$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT id_utente FROM utente WHERE username = '.$db->quote($username);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		
		if( $rows == 0) return false;
		elseif( $rows == 1) return true;
		else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database utenti: username non unico','file'=>__FILE__,'line'=>__LINE__));
	}



	/**
	 * Crea un oggetto utente dato il suo numero identificativo id_utente del database, 0 se utente ospite
	 *
	 * @param int $id_utente numero identificativo utente, -1 non registrato du DB, 0 utente ospite
	 * @param boolean $dbcache se true esegue il pre-caching del bookmark in modo da migliorare le prestazioni  
	 * @return boolean
	 */
	function User($id_utente, $groups, $username=NULL, $email=NULL, $ADUsername=NULL, $MD5=NULL, $ultimoLogin=NULL, $bookmark=NULL)
	{
		$this->id_utente   = $id_utente;
		$this->groups      = $groups;
		$this->username    = $username;
		$this->email       = $email;
		$this->ADUsername  = $ADUsername;
		$this->ultimoLogin = $ultimoLogin;
		$this->MD5         = $MD5;
		$this->bookmark    = $bookmark;
	}



	/**
	 * Ritorna lo username dello User
	 *
	 * @return string
	 */
	function getUsername()
	{
		return $this->username;
	}



	/**
	 * Ritorna la email dello User
	 *
	 * @return int
	 */
	function getEmail()
	{
		return $this->email;
	}



	/**
	 * Imposta la email dello User
	 * 
	 * @param string $email nuova email da impostare
	 * @param boolean $updateDB se true e l'id_utente>0 la modifica viene propagata al DB 
	 * @return int
	 */
	function updateEmail($email, $updateDB = false)
	{
		return $this->email;
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$query = 'UPDATE utente SET email = '.$db->quote($email).' WHERE id_utente = '.$db->quote($this->id_utente);
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database utenti: username non unico','file'=>__FILE__,'line'=>__LINE__));
			
		}
		return true;
	}



	/**
	 * Ritorna lo OR bit a bit dei gruppi di appartenenza dello User
	 * es:  USER_STUDENTE|USER_ADMIN  =  2|64  =  66
	 *
	 * @return int
	 */
	function getGroups()
	{
		return $this->groups;
	}



	/**
	 * Imposta il gruppo di appartenenza dello User
	 * 
	 * @param int $groups nuovo gruppo da impostare
	 * @param boolean $updateDB se true e l'id_utente>0 la modifica viene propagata al DB 
	 * @return int
	 */
	function updateGroups($groups, $updateDB = false)
	{
		return $this->groups;
		if ( $updateDB == true )
		{
			
		}
		return true;
	}



	/**
	 * Ritorna il timestamp dell'ultimo login dello User
	 *
	 * @return int
	 */
	function getUltimoLogin()
	{
		return $this->ultimoLogin;
	}



	/**
	 * Imposta il timestamp dell'ultimo login dello User
	 * 
	 * @param int $ultimoLogin timestamp dell'ultimo login da impostare
	 * @param boolean $updateDB se true e l'id_utente>0 la modifica viene propagata al DB 
	 * @return int
	 */
	function updateUltimoLogin($ultimoLogin, $updateDB = false)
	{
		$this->ultimoLogin = $ultimoLogin;
		if ( $updateDB == true )
		{
			
		}
		return true;
	}



	/**
	 * Ritorna l'oggetto bookmark associato all'utente corrente
	 *
	 * @return Bookmark
	 */
	function getBookmark()
	{
		return $this->bookmark;
	}



	/**
	 * Ritorna lo username dell'ActiveDirectory di ateneo associato all'utente corrente
	 *
	 * @return string
	 */
	function getADUsername()
	{
		return $this->ADUsername;
	}



	/**
	 * Imposta lo username dell'ActiveDirectory di ateneo associato all'utente corrente
	 * 
	 * @param string $ADUsername username dell'ActiveDirectory di ateneo da impostare
	 * @param boolean $updateDB se true e l'id_utente>0 la modifica viene propagata al DB 
	 * @return int
	 */
	function updateADUsername($ADUsername, $updateDB = false)
	{
		$this->ADUsername = $ADUsername;
		if ( $updateDB == true )
		{
			
		}
		return true;
	}



	/**
	 * Ritorna l'hash MD5 della password dell'utente
	 *
	 * @return string
	 */
	function getPasswordHash()
	{
		return $this->MD5;
	}



	/**
	 * Imposta l'hash della password dell'utente corrente
	 * 
	 * @param string $hash stringa della codifica esadecimale dell'hash
	 * @param boolean $updateDB se true e l'id_utente>0 la modifica viene propagata al DB 
	 * @return int
	 */
	function updatePasswordHash($hash, $updateDB = false)
	{
		$this->MD5 = $hash;
		if ( $updateDB == true )
		{
			
		}
		return true;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Admin.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Admin. 
	 *
	 * @static
	 * @return boolean
	 */
	function isAdmin( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_ADMIN ) return true;
		return false;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Personale.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Personale. 
	 *
	 * @static
	 * @return boolean
	 */
	function isPersonale( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_PERSONALE ) return true;
		return false;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Docente.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Docente. 
	 *
	 * @static
	 * @return boolean
	 */
	function isDocente( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_DOCENTE ) return true;
		return false;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Tutor.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Tutor. 
	 *
	 * @static
	 * @return boolean
	 */
	function isTutor( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_TUTOR ) return true;
		return false;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Moderatori.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Moderatori. 
	 *
	 * @static
	 * @return boolean
	 */
	function isModeratore( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_MODERATORE ) return true;
		return false;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Studenter.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Studente. 
	 *
	 * @static
	 * @return boolean
	 */
	function isStudente( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_STUDENTE ) return true;
		return false;
	}



	/**
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Ospite.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Ospite. 
	 *
	 * @static
	 * @return boolean
	 */
	function isOspite( $groups = NULL )
	{
		if ( $groups == NULL ) $groups = $this->groups;

		if ( $groups | USER_OSPITE ) return true;
		return false;
	}



	/**
	 * Crea un oggetto utente dato il suo numero identificativo id_utente del database, 0 se utente ospite
	 *
	 * @static
	 * @param int $id_utente numero identificativo utente
	 * @param boolean $dbcache se true esegue il pre-caching del bookmark in modo da migliorare le prestazioni  
	 * @return boolean
	 */
	function &selectUser($id_utente)
	{
/*
		SELECT 
*/		
		$user = new User(0,USER_OSPITE);
		return $user;
	}



	/**
	 * Inserisce su DB le informazioni riguardanti un nuovo utente
	 *
	 * @return boolean true se avvenua con successo, altrimenti false e throws Error object
	 */
	function insertUser()
	{
/*
		INSERT INTO  
		return true;
*/		
	}

	

	/**
	 * Aggiorna il contenuto su DB riguardante le informazioni utente
	 *
	 * @return boolean true se avvenua con successo, altrimenti false e throws Error object
	 */
	function updateUser()
	{
/*
		UPDATE SET 
		return true;
*/		
	}

	
}



?>