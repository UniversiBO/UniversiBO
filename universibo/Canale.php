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
 * Un "canale" è una pagina dinamica con a disposizione il collegamento 
 * verso i vari servizi tramite un indentificativo, gestisce i diritti di
 * accesso per i diversi gruppi e diritti particolari 'ruoli' per alcuni utenti,
 * fornisce sistemi di notifica e per assegnare un nome ad un canale
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Canale {
	
	/**
	 * @private
	 */
	var $id_canale = 0;
	/**
	 * @private
	 */
	var $permessi = 0;  
	/**
	 * @private
	 */
	var $ultimaModifica = 0;
	/**
	 * @private
	 */
	var $tipoCanale = 0;
	/**
	 * @private
	 */
	var $immagine = '';
	/**
	 * @private
	 */
	var $nome = '';
	/**
	 * @private
	 */
	var $servizioNotizie = false;
	/**
	 * @private
	 */
	var $servizioFiles = false;
	/**
	 * @private
	 */
	var $servizioForum = false;
	/**
	 * @private
	 */
	var $forum = array();
	/**
	 * @private
	 */
	var $servizioLinks = false;
	
	
	
	/**
	 * Crea un oggetto canale 
	 *
	 * $tipo_canale:
	 *  define('CANALE_DEFAULT'   ,1);
	 *  define('CANALE_HOME'      ,2);
	 *  define('CANALE_FACOLTA'   ,3);
	 *  define('CANALE_CDL'       ,4);
	 *  define('CANALE_ESAME_ING' ,5);
	 *  define('CANALE_ESAME_ECO' ,6);
	 *
	 * @see selectCanale
	 * @param int $id_canale
	 * @param int $permessi {@see User}
	 * @param int $ultima_modifica timestamp 
	 * @param int $tipo_canale 	 
	 * @param string  $immagine
	 * @param string $nome
	 * @param boolean $news_attivo
	 * @param boolean $files_attivo
	 * @param boolean $forum_attivo
	 * @param int $forum_forum_id
	 * @param int $forum_group_id
	 * @param boolean $links_attivo
	 * @return Canale
	 */
	function &Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo)
	{
		$this->id_canale = $id_canale;
		$this->permessi = $permessi;  
		$this->ultimaModifica = $ultima_modifica;
		$this->tipoCanale = $tipo_canale;
		$this->immagine = $immagine;
		$this->nome = $nome;
		$this->servizioNotizie = $news_attivo;
		$this->servizioFiles = $files_attivo;
		$this->servizioForum = $forum_attivo;
		$this->forum['forum_id'] = $forum_forum_id;
		$this->forum['group_id'] = $forum_group_id;
		$this->servizioLinks = $links_attivo;
		$this->bookmark = $bookmark;
	}



	/**
	 * Ritorna l'id_canale che identifica il canale
	 *
	 * @return string
	 */
	function getIdCanale()
	{
		return $this->id_canale;
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