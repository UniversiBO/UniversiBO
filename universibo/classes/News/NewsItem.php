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
	 * ? costante per il valore del flag per le notizie eliminate
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
	 	$id_notizie = array($id_notizia);
		$news =& NewsItem::selectNewsItems($id_notizie);
		if ($news === false) return false;
		return $news[0];
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
	 * Verifica se la notizia ? scaduta
	 *
	 * @return boolean
	 */
	function isScaduta() 
	{
	 	return $this->getDataScadenza() < time();
	}
	 
	 
	/**
	 * Seleziona gli id_canale per i quali la notizia ? inerente 
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
	 * rimuove la notizia dal canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function removeCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'DELETE FROM news_canale WHERE id_canale='.$db->quote($id_canale).' AND id_news='.$db->quote($this->id_notizia);
		 //? da testare il funzionamento di =&
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		// rimuove l'id del canale dall'elenco completo
		$this->elencoIdCanali = array_diff ($this->elencoIdCanali, array($id_canale));
	}

		 
	/**
	 * aggiunge la notizia al canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 * @return boolean  true se esito positivo 
	 */
	function addCanale($id_canale)
	{
		$return = true;
		
	 	if ( ! Canale::canaleExists($id_canale) ){
	 		$return = false;
	 		Error::throw(_ERROR_DEFAULT,array('msg'=>'Il canale selezionato non esiste','file'=>__FILE__,'line'=>__LINE__));
	 	}
	 	
	 	$db =& FrontController::getDbConnection('main');
	 	
/*	 	$query = 'SELECT id_notizia FROM news_canale WHERE id_canale = '.$db->quote($id_canale).' AND id_notizia = '.$db->quote($this->getIdNotizia());
		$res =& $db->query($query);
		
		if (DB::isError($res)){
		 	$return = false;
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
		} 
		
		if ($res->numRows());
*/		
		$query = 'INSERT INTO news_canale (id_notizia, id_canale) VALUES ('.$db->quote($this->id_notizia).','.$db->quote($id_canale).')';
		 //? da testare il funzionamento di =&
		//$res =& $db->query($query);
		
		if (DB::isError($res)) {
			$return = false;
		//	$db->rollback();
		//	Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
		} 
		
		$res->free();
		
		$this->elencoIdCanale[] = $id_canale;
		
		return $return;
		
	}	 
	
	/**
	 * Inserisce su DB le informazioni riguardanti un nuovo utente
	 *
	 * @param	 array 	$array_id_canali 	elenco dei canali in cui bisogna inserire la notizia. Se non si passa un canale si recupera quello corrente.
	 * @return	 boolean true se avvenua con successo, altrimenti Error object
	 */
	function insertNewsItem($id_canali)
	{				 
		$db =& FrontController::getDbConnection('main');
		
        ignore_user_abort(1);
        $db->autoCommit(false);
        		
		$return = true;
				
		$query = 'INSERT INTO news (id_news, titolo, data_inserimento, data_scadenza, notizia, id_utente, eliminata, flag_urgente, data_modifica) VALUES '.
					'( '.$db->nextID('id_news').' , '.
					$db->quote($this->getTitolo()).' , '.
					$db->quote($this->getDataIns()).' , '.
					$db->quote($this->getDataScadenza()).' , '.
					$db->quote($this->getNotizia()).' , '.
					$db->quote($this->getIdUtente()).' , '.
					$db->quote($this->getEliminata()).' , '.
					$db->quote($this->getUrgente()).' , '.
					$db->quote($this->getUltimaModifica()).' )'; 
		
		$res = $db->query($query);
		
		if (DB::isError($res)){
			$db->rollback();
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
		}
		
		$num_canali = count($id_canali);
		for ($i = 0; $i<$num_canali; $i++)
		{
			$canale =& $id_canali[$i];
			if ($this -> addCanale($canale) === false)
			{
				$db->rollback();
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
			}
		}	
		
		$db->commit();
		        
		$res->free();
		$db->autoCommit(true);
		ignore_user_abort(0);
				
		return $return;
	}

} 
 
?>