<?php

require_once('Ruolo'.PHP_EXTENSION);

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
	var $visite = 0;
	/**
	 * @private
	 */
	var $servizioNews = false;
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
	 * @param int $visite
	 * @param boolean $news_attivo
	 * @param boolean $files_attivo
	 * @param boolean $forum_attivo
	 * @param int $forum_forum_id
	 * @param int $forum_group_id
	 * @param boolean $links_attivo
	 * @return Canale
	 */
	function Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo)
	{
		$this->id_canale = $id_canale;
		$this->permessi = $permessi;  
		$this->ultimaModifica = $ultima_modifica;
		$this->tipoCanale = $tipo_canale;
		$this->immagine = $immagine;
		$this->nome = $nome;
		$this->visite = $visite;
		$this->servizioNotizie = $news_attivo;
		$this->servizioFiles = $files_attivo;
		$this->servizioForum = $forum_attivo;
		$this->forum['forum_id'] = $forum_forum_id;
		$this->forum['group_id'] = $forum_group_id;
		$this->servizioLinks = $links_attivo;
		$this->bookmark = NULL;
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
	 * Ritorna l' OR bit a bit dei gruppi che hanno accesso al canale
	 *
	 * @return int
	 */
	function getPermessi()
	{
		return $this->permessi;
	}



	/**
	 * Restituisce true se il gruppo o uno dei gruppi appartenenti a $groups 
	 * ha il permesso di acecsso al canale, altrimenti false
	 *
	 * @param int $groups gruppi di cui si vuole verificare l'accesso
	 * @return boolean
	 */
	function isGroupAllowed($groups)
	{
		return (boolean) ($this->permessi & $groups);
	}



	/**
	 * Ritorna il tipo di canale
	 *
	 * es: $tipo_canale:
	 *  define('CANALE_DEFAULT'   ,1);
	 *  define('CANALE_HOME'      ,2);
	 *  define('CANALE_FACOLTA'   ,3);
	 *  define('CANALE_CDL'       ,4);
	 *  define('CANALE_ESAME_ING' ,5);
	 *  define('CANALE_ESAME_ECO' ,6);
	 * 
	 * @return int
	 */
	function getTipoCanale()
	{
		return $this->tipoCanale;
	}



	/**
	 * Ritorna il timestamp dell'ultima modifica eseguita nel canale
	 *
	 * @return int
	 */
	function getUltimaModifica()
	{
		return $this->ultimaModifica;
	}



	/**
	 * Ritorna l'URL relativo alla cartella del template dell'immagine di intestazione del canale
	 *
	 * @return string
	 */
	function getImmagine()
	{
		return $this->immagine;
	}



	/**
	 * Ritorna la stringa descrittiva del titolo/nome del canale
	 *
	 * @return string
	 */
	function getNome()
	{
		return $this->nome;
	}



	/**
	 * Ritorna il numero di visite effettuate nel canale
	 *
	 * @return int
	 */
	function getVisite()
	{
		return $this->visite;
	}



	/**
	 * Aumenta il numero di visite effettuate nel canale
	 *
	 * @return boolean
	 */
	function addVisite($visite = 1)
	{
		$this->visite += $visite;

		$db =& FrontController::getDbConnection('main');
	
		$query = 'UPDATE canale SET visite = visite + '.$db->quote($visite).' WHERE id_canale = '.$db->quote($this->getIdCanale());
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $db->affectedRows();
	
		if( $rows == 1) return true;
		elseif( $rows == 0) return false;
		else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: canale non unico','file'=>__FILE__,'line'=>__LINE__));

	}



	/**
	 * Ritorna l'oggetto News, false se il servizio non è attivo
	 *
	 * @todo implementare News
	 * @return mixed
	 */
	function getServizioNews()
	{
		return $this->servizioNews;
	}



	/**
	 * Imposta il servizio news, true: attivo - false: non attivo
	 *
	 * @todo implementare propagazione DB
	 * @param boolean $attiva_files 
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean
	 */
	function setServizioNews($attiva_news, $updateDB = false)
	{
		$this->servizioNews = $attiva_news;
	}



	/**
	 * Ritorna l'oggetto Files, false se il servizio non è attivo
	 *
	 * @todo implementare Files
	 * @return mixed
	 */
	function getServizioFiles()
	{
		return $this->servizioFiles;
	}



	/**
	 * Imposta il servizio files, true: attivo - false: non attivo
	 *
	 * @todo implementare propagazione DB
	 * @param boolean $attiva_files 
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean
	 */
	function setServizioFiles($attiva_files, $updateDB = false)
	{
		$this->servizioFiles = $attiva_files;
	}



	/**
	 * Ritorna l'oggetto Links, false se il servizio non è attivo
	 *
	 * @todo implementare Links
	 * @return mixed
	 */
	function getServizioLinks()
	{
		return $this->servizioLinks;
	}



	/**
	 * Imposta il servizio links, true: attivo - false: non attivo
	 *
	 * @todo implementare propagazione DB
	 * @param boolean $attiva_links 
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean
	 */
	function setServizioLinks($attiva_links, $updateDB = false)
	{
		$this->servizioLinks = $attiva_links;
	}



	/**
	 * Ritorna l'oggetto Forum, false se il servizio non è attivo
	 *
	 * @todo implementare Forum
	 * @return mixed
	 */
	function getServizioForum()
	{
		return $this->servizioForum;
	}



	/**
	 * Imposta il servizio forum, true: attivo - false: non attivo
	 *
	 * @todo implementare propagazione DB
	 * @param boolean $attiva_links 
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean
	 */
	function setServizioForum($attiva_forum, $updateDB = false)
	{
		$this->servizioForum = $attiva_forum;
	}



	/**
	 * Ritorna il forum_id delle tabelle di phpbb, , NULL se il forum non è attivo
	 *
	 * @return mixed
	 */
	function getForumForumId()
	{
		return $this->forum['forum_id'];
	}



	/**
	 * Ritorna il group_id delle tabelle di phpbb, NULL se il forum non è attivo
	 *
	 * @return mixed
	 */
	function getForumGroupId()
	{
		return $this->forum['group_id'];
	}




	/**
	 * Crea un oggetto canale dato il suo numero identificativo id_canale del database
	 *
	 * @static
	 * @param int $id_canale numero identificativo utente
	 * @return mixed Canale se eseguita con successo, false se il canale non esiste
	 */
	function &selectCanale($id_canale)
	{
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo FROM canale WHERE id_canale= '.$db->quote($id_canale);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows > 1) Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: canale non unico','file'=>__FILE__,'line'=>__LINE__));
		if( $rows = 0) return false;

		$res->fetchInto($row);
		$canale =& new Canale($id_canale, $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
						 $row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S' );

		return $canale;
		
	}
	

	/**
	 * Inserisce su Db le informazioni riguardanti un NUOVO canale
	 *
	 * @param int $id_canale numero identificativo utente
	 * @return boolean
	 */
	function insertCanale()
	{
		$db =& FrontController::getDbConnection('main');
	
		$this->id_canale = $db->nextID('canale_id_canale');
		$files_attivo = ( $this->getFilesAttivo() ) ? 'S' : 'N';
		$news_attivo  = ( $this->getNewsAttivo()  ) ? 'S' : 'N';
		$links_attivo = ( $this->getLinksAttivo() ) ? 'S' : 'N';
		if ( $this->getForumAttivo() )
		{
			$forum_attivo = 'S';
			$forum_forum_id = $this->getForumForumId();
			$forum_group_id = $this->getForumGroupId();
		}
		else
		{
			$forum_attivo = 'N';
			/**
			 * @todo testare se gli piace il valore NULL poi quotato nella query
			 */
			$forum_forum_id = NULL ;
			$forum_group_id = NULL ;
		}	
			
		
		$query = 'INSERT INTO canale (id_canale, tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo) VALUES ('.
					$db->quote($this->getIdCanale()).' , '.
					$db->quote($this->getTipoCanale()).' , '.
					$db->quote($this->getNomeCanale()).' , '.
					$db->quote($this->getImmagine()).' , '.
					$db->quote($this->getVisite()).' , '.
					$db->quote($this->getUltimaModifica()).' , '.
					$db->quote($this->getPermessi()).' , '.
					$db->quote($files_attivo).' , '.
					$db->quote($news_attivo).' , '.
					$db->quote($forum_attivo).' , '.
					$db->quote($forum_forum_id).' , '.
					$db->quote($forum_group_id).' , '.
					$db->quote($links_attivo).' )';
		$res = $db->query($query);
		if (DB::isError($res))
		{ 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
			return false;
		}
		
		return true;
	}
	
	
	
	/**
	 * Aggiorna il contenuto su DB riguardante le informazioni del canale
	 *
	 * @return boolean true se avvenua con successo, altrimenti false e throws Error object
	 */
	function updateCanale()
	{
		$db =& FrontController::getDbConnection('main');
		
		$files_attivo = ( $this->getFilesAttivo() ) ? 'S' : 'N';
		$news_attivo  = ( $this->getNewsAttivo()  ) ? 'S' : 'N';
		$links_attivo = ( $this->getLinksAttivo() ) ? 'S' : 'N';
		if ( $this->getForumAttivo() )
		{
			$forum_attivo = 'S';
			$forum_forum_id = $this->getForumForumId();
			$forum_group_id = $this->getForumGroupId();
		}
		else
		{
			$forum_attivo = 'N';
			/**
			 * @todo testare se gli piace il valore NULL poi quotato nella query
			 */
			$forum_forum_id = NULL ;
			$forum_group_id = NULL ;
		}	
		
	
		$query = 'UPDATE canale SET ( id_canale = '.$db->quote($this->getIdCanale()).
					' , tipo_canale = '.$db->quote($this->getTipoCanale()).
					' , nome_canale = '.$db->quote($this->getNomeCanale()).
					' , immagine = '.$db->quote($this->getImmagine()).
					' , ultima_modifica = '.$db->quote($this->getUltimaModifica()).
					' , permessi_groups = '.$db->quote($this->getPermessi()).
					' , files_attivo = '.$db->quote($files_attivo).
					' , news_attivo = '.$db->quote($news_attivo).
					' , forum_attivo = '.$db->quote($forum_attivo).
					' , id_forum = '.$db->quote($forum_forum_id).
					' , group_id = '.$db->quote($forum_group_id).
					' , links_attivo = '.$db->quote($links_attivo).' )';
			
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $db->affectedRows();
	
		if( $rows == 1) return true;
		elseif( $rows == 0) return false;
		else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: canale non unico','file'=>__FILE__,'line'=>__LINE__));
	}
}


?>