<?php


define('NEWS_ELIMINATA','S');


/**
 *
 * NewsItem class
 *
 * Rappresenta una singola news.
 *
 * @package universibo
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */


class NewsItem {
	
	/**
	 * é costante per il valore del flag per le notizie eliminate
	 *
	 * @private
	 */
	var $ELIMINATA='S';
	
	/**
	 * @private
	 */
	var $titolo='';
	
	/**
	 * @private
	 */ 
	var $notizia='';
	 
	/**
	 * @private
	 */
	var $id_utente=0; 

	/**
	 * @private
	 */
	var $username=''; 

	/**
	 * data e ora di inserimento
	 * @private
	 */
	var $dataIns=0;
	
	
	/**
	 * @private
	 */
	var $dataScadenza=NULL;
	
		
	/**
	 * @private
	 */
	var $ultimaModifica = false; 
	
	/**
	 * @private
	 */
	var $urgente=false; 
	
	/**
	 * @private
	 */
	var $id_notizia=0; 
	 
	/**
	 * @private
	 */
	var $eliminata=false; 
	
	/**
	 * @private
	 */
	var $elencoCanali=NULL; 

	/**
	 * @private
	 */
	var $elencoIdCanali=NULL; 

	
	
	/**
	 * Crea un oggetto NewsItem con i parametri passati
	 * 
	 *
	 * @param  int $id_notizia id della news
	 * @param  string $titolo titolo della news max 150 caratteri
	 * @param  string $notizia corpo della news
	 * @param  int $dataIns timestamp del giorno di inserimento
	 * @param  int $dataScadenza timestamp del giorno di scadenza
	 * @param  int $ultimaModifica timestamp ultima modifica della notizia
	 * @param  boolean $urgente flag notizia urgente o meno
	 * @param  boolean $eliminata flag stato della news
	 * @param  int $id_utente id dell'autore della news
	 * @param  string $username username dell'autore della news
	 * @return NewsItem
	 */
	 
	 function NewsItem($id_notizia, $titolo, $notizia, $dataIns, $dataScadenza, $ultimaModifica, $urgente, $eliminata, $id_utente, $username)
	 {
	 	
	 	$this->id_notizia     = $id_notizia;
	 	$this->titolo         = $titolo;
	 	$this->notizia        = $notizia;
	 	$this->dataIns        = $dataIns;
	 	$this->ultimaModifica = $ultimaModifica;
	 	$this->dataScadenza   = $dataScadenza;
	 	$this->urgente        = $urgente;
	 	$this->eliminata      = $eliminata;
	 	$this->id_utente      = $id_utente;
	 	$this->username       = $username;
	 
	 }

	 
	 /**
	  * 
	  * Recupera il titolo della notizia
	  *
	  * @return String 
	  */
	 function getTitolo()
	 {
	 	return $this->titolo;
	 }

	 
	 /**
	  * Recupera il testo della notizia
	  *
	  * @return string 
	  */
	 function getNotizia()
	 {
	 	return $this->notizia;
	 }

	 
	 /**
	 * Recupera l'id_utente dell'autore della notizia
	 *
	 * @return int 
	 */
	 function getIdUtente() 
	 {
	 	return $this->id_utente;
	 }
	 

	 /**
	 * Recupera lo username dell'autore della notizia
	 *
	 * @return string 
	 */
	 function getUsername() 
	 {
	 	return $this->username;
	 }
	 

	/**
	 * Recupera la data di inserimento della notizia
	 *
	 * @return int 
	 */
	function getDataIns() 
	{
	 	return $this->dataIns;
	}
	 
	 
		 
	/**
	 * Recupera la data di scadenza della notizia
	 *
	 * @return int
	 */
	function getDataScadenza() 
	{
	 	return $this->dataScadenza;
	}
	 
	 
	/**
	 * Recupera l'urgenza della notizia
	 *
	 * @return boolean
	 */
	function getUrgente()
	{
	 	return $this->urgente;
	}
	 
	 
	/**
	 * Recupera l'id della notizia
	 *
	 * @return int
	 */
	function getIdNotizia() 
	{
	 	return $this->id_notizia;
	}
	 
	/**
	 * Recupera lo stato della notizia
	 *
	 * @return boolean
	 */
	function getEliminata() 
	{
	 	return $this->eliminata;
	}
	 

	/**
	 * Recupera il timestamp dell'ultima modifica della notizia
	 *
	 * @return int timestamp dell'ultima modifica della notizia
	 */
	function getUltimaModifica() 
	{
	 	return $this->ultimaModifica;
	}
	 

	/**
	 * Imposta il titolo della notizia
	 *
	 * @param  string $titolo titolo della news max 150 caratteri
	 */
	function setTitolo($titolo)
	{
	 	$this->titolo=$titolo;
	}
	 

	/**
	 * Imposta il testo della notizia
	 *
	 * @param  string $notizia corpo della news 
	 */
	function setNotizia($notizia)
	{
	 	$this->notizia=$notizia;
	}
	 
	 
	/**
	 * Imposta l'id_utente dell'autore della notizia
	 *
	 * @param  int $id_utente id dell'autore della news 
	 */
	function setIdUtente($id_utente) 
	{
	 	$this->id_utente = $id_utente;
	}
	 
	 
	 /**
	 * Imposta lo username dell'autore della notizia
	 *
	 * @param  string $username username dell'autore della news 
	 */
	 function setUsername($username) 
	 {
	 	$this->username = $username;
	 }
	 

	/**
	 * Imposta la data di inserimento della notizia
	 *
	 * @param  int $dataIns timestamp del giorno di inserimento 
	 */
	function setDataIns($dataIns) 
	{
	 	$this->dataIns=$dataIns;
	}
	
	
	/**
	 * 
	 * Imposta la data di scadenza della notizia
	 *
	 * @param  int $dataScadenza timestamp del giorno di scadenza 
	 */
	function setDataScadenza($dataScadenza) {
	 	$this->dataScadenza=$dataScadenza;
	}
	 

	/**
	 * Imposta l'urgenza della notizia
	 *
	 * @param  boolean $urgente flag notizia urgente o meno
	 */
	function setUrgente($urgente)
	{
		$this->urgente=$urgente;
	}
	 
	 
	
	 
	/**
	 * Imposta il timestamp dell'ultima modifica della notizia
	 *
	 * @return int timestamp dell'ultima modifica della notizia
	 */
	function setUltimaModifica() 
	{
	 	return $this->ultimaModifica;
	}
	 

	/**
	 * 
	 * Imposta l'id della notizia
	 *
	 * @param  int $id_notizia id della news
	 */
	function setIdNotizia($id_notizia) 
	{
	 	$this->id_notizia=$id_notizia;
	}
	 
	
	/**
	 * 
	 * Imposta lo stato della notizia
	 *
	 * @param  boolean $eliminata flag stato della news
	 */
	function setEliminata($eliminata) 
	{
	 	$this->eliminata=$eliminata;
	}
	
	 
	/**
	 * Recupera una notizia dal database
	 *
	 * @static
	 * @param int $id_notizia  id della news
	 * @return NewsItem 
	 */
	 function &selectNewsItem ($id_notizia)
	 {
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT titolo, notizia, data_inserimento, data_scadenza, flag_urgente, eliminata, id_utente, username, data_modifica FROM news A, utente B WHERE A.id_autore = B.id_utente AND id_news='.$db->quote($id_notizia).'AND eliminata!='.$db->quote($this->ELIMINATA);
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
	
		$res->fetchInto($row);	
		$res->free();
		
		$news=& new NewsItem($id_notizia,$row[0],$row[1],$row[2],$row[3],$row[9],$row[4],$row[5],$row[6],$row[8], $row[9]);
		return $news;
	 }
	
	

	/**
	 * Recupera un elenco di notizie dal database
	 *
	 * @static
	 * @param array $id_notizie array elenco di id della news
	 * @return NewsItems 
	 */
	 function &selectNewsItems ($id_notizie)
	 {
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		if ( count($id_notizie) == 0 )
			return array();
		
		//esegue $db->quote() su ogni elemento dell'array
		//array_walk($id_notizie, array($db, 'quote'));
		$values = implode(',',$id_notizie);
		
		$query = 'SELECT titolo, notizia, data_inserimento, data_scadenza, flag_urgente, eliminata, A.id_utente, id_news, username, data_modifica FROM news A, utente B WHERE A.id_utente = B.id_utente AND id_news IN ('.$values.') AND eliminata!='.$db->quote(NEWS_ELIMINATA);
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
		$news_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$news_list[]=& new NewsItem($row[7],$row[0],$row[1],$row[2],$row[3],$row[9],$row[4],$row[5],$row[6],$row[8] );
		}
		
		$res->free();
		
		return $news_list;
	 }
	
	

	/**
	 * Verifica se la notizia è scaduta
	 *
	 * @return boolean
	 */
	function isScaduta() 
	{
	 	return $this->getDataScadenza() < time();
	}
	 
	 
	/**
	 * Seleziona gli id_canale per i quali la notizia è inerente 
	 *
	 * @static
	 * @return array	elenco degli id_canale
	 */
	function &getIdCanali() 
	{
	 	if ($this->elencoIdCanali != NULL) 
	 		return $this->elencoIdCanali;
 		
 		$id_notizia = $this->getIdNotizia();
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_canale FROM news_canale WHERE id_news='.$db->quote($id_notizia).' ORDER BY id_canale';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows = 0) return false;
		
		$elenco_id_canale = array();
		
		while($res->fetchInto($row))
		{
			$elenco_id_canale[] = $row[0];
		}
		
		$res->free();		
		
		$this->elencoIdCanali =& $elenco_id_canale;
		
 		return $this->elencoIdCanali;
		
	}
	 

	/**
	 * Seleziona i canali per i quali la notizia è inerente 
	 *
	 * @static
	 * @return array	elenco dei canali
	 */
	function &getCanali() 
	{
	 	if ($this->elencoCanali != NULL) 
	 		return $this->elencoCanali;
 		/*
 		$id_notizia = $this->getIdNotizia();
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_canale FROM news_canale WHERE id_news='.$db->quote($id_notizia).' ORDER BY id_canale';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows = 0) return false;
		
		$elenco_id_canale = array();
		
		while($res->fetchInto($row))
		{
			$elenco_id_canale[] = $row[0];
		}
		
		$this->elencoIdCanale = $elenco_id_canale;
		*/
		$elenco_id =& $this->getIdCanali();
		
		if ($elenco_id === false)
		{
			$this->elencoCanali = array();
		}
		else
		{
			$this->elencoCanali =& Canale::selectCanali( $elenco_id  );
		}
		
 		return $this->elencoCanali;
		
	}
	 

	/**
	 * rimuove la notizia dal canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function removeCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'DELETE FROM news_canale WHERE id_canale='.$db->quote($id_canale).' AND id_news='.$db->quote($this->id_notizia);
		 //è da testare il funzionamento di =&
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 

		$this->elencoIdCanali  = NULL;
		$this->elencoCanali    = NULL;
	 
	}

	 
	/**
	 * aggiunge la notizia al canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function addCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'INSERT INTO news_canale VALUES ('.$db->quote($this->id_notizia).','.$db->quote($id_canale).')';
		 //è da testare il funzionamento di =&
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$this->elencoIdCanali  = NULL;
		$this->elencoCanali    = NULL;
		
	}	 
	
	/**
	 * Inserisce su DB le informazioni riguardanti un nuovo utente
	 *
	 * @return boolean true se avvenua con successo, altrimenti Error object
	 */
	function insertNewsItem()
	{
		$db =& FrontController::getDbConnection('main');
		
        ignore_user_abort(1);
        $db->autoCommit(false);
        
		$query = 'SELECT id_news FROM news WHERE id_news = '.$db->quote($this->getIdNotizia()); 
		$res = $db->query($query);
		$rows = $res->numRows();
		
		if( $rows > 0) 
		{
			$return = false;
		}
		else
		{
			$query = 'INSERT INTO news (id_news, titolo, data_inserimento, data_scadenza, notizia, id_utente, eliminata, flag_urgente, data_modifica) VALUES '.
						'( '.$db->quote($this->getIdNotizia()).' , '.
						$db->quote($this->getTitolo()).' , '.
						$db->quote($this->getDataIns()).' , '.
						$db->quote($this->getDataScadenza()).' , '.
						$db->quote($this->getNotizia()).' , '.
						$db->quote($this->getIdUtente()).' , '.
						$db->quote($this->getEliminata()).' , '.
						$db->quote($this->getUrgente()).' , '.
						$db->quote($this->getUltimaModifica()).' )'; 
			$res = $db->query($query);
			
			if (DB::isError($res))
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
			
			$db->commit();
			
			$return = true;
		}
        
        $db->autoCommit(true);
        ignore_user_abort(0);
		
		return $return;
	}

} 
 
?>