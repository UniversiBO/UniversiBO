<?php

define('CANALE_DEFAULT'   ,1);
define('CANALE_HOME'      ,2);
define('CANALE_FACOLTA'   ,3);
define('CANALE_CDL'       ,4);
define('CANALE_ESAME_ING' ,5);
define('CANALE_ESAME_ECO' ,6);


/**
 * Canale class.
 *
 * Un "canale" ט una pagina dinamica con a disposizione il collegamento 
 * verso i vari servizi tramite un indentificativo, gestisce i diritti di
 * accesso per i diversi gruppi e diritti particolari 'ruoli' per alcuni utenti,
 * fornisce sistemi di notifica e per assegnare un nome ad un canale
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Canale {
	
	var $id_canale = 0;
	var $permessi = 0;  
	var $ultimoUpdate = 0;
	var $nome = '';
	var $servizioNotizie = false;
	var $servizioFiles = false;
	var $servizioForum = false;
	var $servizioLinks = false;
	
	
	
	/**
	 * Restituisce true se un argomento ט stato registrato nella sessione corrente
	 *
	 * @static
	 * @return boolean
	 */
	function sessionUserExists()
	{
		return array_key_exists('id_utente', $_SESSION);
	}



	/**
	 * Restituisce l'id_utente del dello user nella sessione corrente
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return boolean
	 */
	function sessionIdUser()
	{
		return $_SESSION['id_utente'];
	}

	
	
	/**
	 *  Verifica se la sintassi dello username ט valido.
	 *  Sono permessi fino a 25 caratteri: alfanumerici, lettere accentate, spazi, punti, underscore
	 *
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
		return ( $lenght > 5 && $length < 30 );
	}
	 
	
	
	/**
	 * Genera una password casuale
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return boolean
	 */
	function generateRandomPassword(){
		$begin  = rand(0,24);
		$length = rand(6,8);
		return substr(md5(uniqid('')), $begin , $length);
	}
	

	



	/**
	 * Restituisce true se lo username specificato ט giא registrato sul DB
	 *
	 * @param string $username username da ricercare
	 * @return boolean
	 */
	function usernameExists( $username )
	{
/*		global $pg_conn;
		
		$query='SELECT * FROM utente WHERE username = \''.$username.'\'';

		$dati = pg_exec($pg_conn,$query) or errore(pg_errormessage($pg_conn),__FILE__,__LINE__);

		$rows =  pg_numrows($dati);
		if( $rows == 0) return false;
		elseif( $rows == 1) return true;
		else errore('Errore generale database utenti: username non unico',__FILE__,__LINE__);
*/
	}



	/**
	 * Crea un oggetto utente dato il suo numero identificativo id_utente del database, 0 se utente ospite
	 *
	 * @param int $id_utente numero identificativo utente, -1 non registrato du DB, 0 utente ospite
	 * @param boolean $dbcache se true esegue il pre-caching del bookmark in modo da migliorare le prestazioni  
	 * @return boolean
	 */
	function User($id_utente, $group, $username = '', $ADUsername='', $MD5='', $ultimoLogin='', $bookmark=NULL)
	{
		

		
		
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
	 * Ritorna lo OR bit a bit dei gruppi di appartenenza dello User
	 * es:  USER_STUDENTE|USER_ADMIN  =  2|64  =  66
	 *
	 * @return int
	 */
	function getGroup()
	{
		return $this->group;
	}



	/**
	 * Imposta il gruppo di appartenenza dello User
	 * 
	 * @param int $group nuovo gruppo da impostare
	 * @param boolean $updateDB se true e l'id_utente>0 la modifica viene propagata al DB 
	 * @return int
	 */
	function updateGroup($group, $updateDB = false)
	{
		return $this->group;
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
	 * Se chiamata senza parametri ritorna true se l'utente corrente appartiene al gruppo Ospite.
	 * Se chiamata in modo statico con il parametro opzionale ritorna true se il gruppo specificato appartiene al gruppo Ospite. 
	 *
	 * @static
	 * @return boolean
	 */
	function isOspite( $group = NULL )
	{
		if ( $group == NULL ) $group = $this->group;

		if ( $group | USER_OSPITE ) return true;
		return false;
	}



	/**
	 * Crea un oggetto utente dato il suo numero identificativo id_utente del database, 0 se utente ospite
	 *
	 * @param int $id_utente numero identificativo utente
	 * @param boolean $dbcache se true esegue il pre-caching del bookmark in modo da migliorare le prestazioni  
	 * @return boolean
	 */
	function selectUser($id_utente)
	{
/*
		SELECT 
		return new User();
*/		
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