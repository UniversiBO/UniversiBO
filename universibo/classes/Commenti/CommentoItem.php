<?php

/**
 * CommentoItem class
 *
 * Rappresenta un singolo commento su un FileStudente.
 *
 * @package universibo
 * @subpackage Commenti
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Fabio Crisci <fabioc83@yahoo.it>
 * @author Daniele Tiles
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class CommentoItem
{
	/**
	 * @private
	 */
	var $id_file_studente = 0;
	/**
	 * @private
	 */
	var $id_utente = 0;
	/**
	 * @private
	 */
	var $commento = '';
	/**
	 * @private
	 */
	var $voto = -1;
	
	/**
	 * Crea un oggetto CommentoItem
	 * @param $id_file_studente id di un File Studente
	 * @param $id_utente id di un utente, quello che ha fatto il commento
	 * @param $commento commento a un File Studente
	 * @param $voto proposto per un file studente
	 */
	
	function CommentoItem($id_file_studente,$id_utente,$commento,$voto)
	{
		$this->id_file_studente = $id_file_studente;
		$this->id_utente = $id_utente;
		$this->commento = $commento;
		$this->voto = $voto;
	}
	
	/**
	 * Restituisce l'id_file_studente del commento
	 */
	 
	 function getIdFileStudente()
	 {
	 	return $this->id_file_studente;
	 }
	 
	 /**
	 * Setta l'id_file_studente del commento
	 */
	 
	 function setIdFileStudente($id_file_studente)
	 {
	 	$this->id_file_studente = $id_file_studente;
	 }
	 
	 /**
	 * Restituisce l'id_utente che ha scritto il commento
	 */
	 
	 function getIdUtente()
	 {
	 	return $this->id_utente;
	 }
	 
	 /**
	 * Setta l'id_utente che ha scritto il commento
	 */
	 
	 function setIdUtente($id_utente)
	 {
	 	$this->id_utente = $id_utente;
	 }
	 
	 /**
	 * Restituisce il commento al File Studente
	 */
	 
	 function getCommento()
	 {
	 	return $this->commento;
	 }
	 
	 /**
	 * Setta il commento al File Studente
	 */
	 
	 function setCommento($commento)
	 {
	 	$this->commento = $commento;
	 }
	 
	 /**
	 * Restituisce il voto associato al file studente
	 */
	 
	 function getVoto()
	 {
	 	return $this->voto;
	 }
	 
	 /**
	 * Setta il voto associato al File Studente 
	 */
	 
	 function setVoto($voto)
	 {
	 	$this->voto = $voto;
	 }
	 
	 /**
	  *
	  */
	  
	 function & selectCommentiItem($id_file)
	 {
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT id_utente,commento,voto FROM file_studente_commenti WHERE id_file_studente='.$db->quote($id_file).' ORDER BY voto DESC';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$commenti_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$commenti_list[]= &new CommentoItem($id_file,$row[0],$row[1],$row[2]);
		}
		
		$res->free();
		
		return $commenti_list;
	 }
	 
	 /**
	  *
	  */
	  
	 function & selectCommentoItem($id_file,$id_utente)
	 {
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT commento,voto FROM file_studente_commenti WHERE id_file_studente='.$db->quote($id_file).' AND id_utente = '.$db->quote($id_utente);
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$commenti_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$commenti_list= &new CommentoItem($id_file,$id_utente,$row[0],$row[1]);
		}
		
		$res->free();
		
		return $commenti_list;
	 }
	 
	 /**
	 * Conta il numero dei commenti presenti per il file
	 *
	 * @static 
	 * @param int $id_file identificativo su database del file studente
	 * @return numero dei commenti
	 */
	function & quantiCommenti($id_file)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT count(*) FROM file_studente_commenti WHERE id_file_studente = '.$db->quote($id_file).' GROUP BY id_file_studente';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$res->fetchInto($row);
		$res->free();
		
		return $row[0];
		
	}
	
	/**
	 * Restituisce il nick dello user
	 *
	 * @return il nickname
	 */
	 
	 function getUsername()
	 {
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT username FROM utente WHERE id_utente= '.$db->quote($this->id_utente);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		if( $rows == 0) 
			 Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste un utente con questo id_user','file'=>__FILE__,'line'=>__LINE__));
		$res->fetchInto($row);
		$res->free();
		return $row[0];
		
	 }
	 
	/**
	 * Aggiunge un Commento sul DB
	 */
	 
	 function & insertCommentoItem($id_file_studente,$id_utente,$commento,$voto)
	 {
	 	$db = FrontController::getDbConnection('main');
		ignore_user_abort(1);
		$return = true;
        $query = 'INSERT INTO file_studente_commenti VALUES ('.$db->quote($id_file_studente).','.$db->quote($id_utente).','.$db->quote($commento).','.$db->quote($voto).')';
		$res = $db->query($query);
		if (DB :: isError($res))
			{				
				$db->rollback();
				Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
				$return = false;
			}
			ignore_user_abort(0);
		return $return;
	 }
	 
	 /**
	 * Modifica un Commento sul DB
	 */
	 
	 function & updateCommentoItem($id_file_studente,$id_utente,$commento,$voto)
	 {
	 	$db = FrontController::getDbConnection('main');
		ignore_user_abort(1);
		$return = true;
        $query = 'UPDATE file_studente_commenti SET commento='.$db->quote($commento).', voto= '.$db->quote($voto).' WHERE id_file_studente='.$db->quote($id_file_studente).' AND id_utente ='.$db->quote($id_utente);
		$res = $db->query($query);
		if (DB :: isError($res))
			{				
				$db->rollback();
				Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
				$return = false;
			}
			ignore_user_abort(0);
		return $return;
	 }
	 
	 /**
	  * Cancella un commento sul DB
	  */
	  
	  function & deleteCommentoItem($id_file_studente,$id_utente)
	  {
	  		$db = FrontController::getDbConnection('main');
		ignore_user_abort(1);
		$return = true;
        $query = 'DELETE FROM file_studente_commenti WHERE id_file_studente='.$db->quote($id_file_studente).' AND id_utente ='.$db->quote($id_utente);
		$res = $db->query($query);
		if (DB :: isError($res))
			{				
				$db->rollback();
				Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
				$return = false;
			}
			ignore_user_abort(0);
		return $return;
	  }
}

?>