<?php

require_once('User'.PHP_EXTENSION);

/**
 * Collaboratore class, modella le informazioni relative ai collaboratori
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2004
 */

class Collaboratore extends User {
	
	/**
	 * @access private
	 */
	var $id_utente;
	
	/**
	 * @access private
	 */
	var $intro;
	
	/**
	 * @access private
	 */
	var $ruolo;	
	
	/**
	 * @access private
	 */
	var $recapito;
	
	/**
	 * @access private
	 */
	var $obiettivi;
		
	/**
	 * @access private
	 */
	var $foto; 
	
	/**
	 * @access private
	 */
	var $userCache = NULL; 
	
	/**
	 * @final
	 * @access private
	 */
	var $fotoDefault = 'no_foto.png'; 


	function Collaboratore($id_utente, $intro, $recapito, $obiettivi, $foto, $ruolo )
	{
		$this->id_utente	= $id_utente;
		$this->intro		= $intro;
		$this->ruolo		= $ruolo;
		$this->recapito 	= $recapito;
		$this->foto			= $foto;
		$this->obiettivi	= $obiettivi;
	}
	
	function getIdUtente()
	{
		return $this->id_utente;
	}

	function setIdUtente($id_utente)
	{
		$this->id_utente = $id_utente;
	}

	function getIntro()
	{
		return $this->intro;
	}

	function setIntro($intro)
	{
		$this->intro = $intro;
	}
 
	function getRuolo()
	{
		return $this->ruolo;
	}

	function setRuolo($ruolo)
	{
		$this->ruolo = $ruolo;
	}
 
	function getRecapito()
	{
		return $this->recapito;
	}

	function setRecapito($recapito)
	{
		$this->recapito = $recapito;
	}
 
	function getObiettivi()
	{
		return $this->obiettivi;
	}

	function setObiettivi($obiettivi)
	{
		$this->obiettivi = $obiettivi;
	}
 
	function getFotoFilename()
	{
		return ($this->foto != NULL) ? $this->getIdUtente().'_'.$this->foto : $this->fotoDefault;
	}

	function setFotoFilename($foto)
	{
		$this->foto = $foto;
	}
 
	
	/**
	 * Ritorna Preleva tutti i collaboratori dal database
	 *
	 * @static
	 * @param int $id_utente numero identificativo utente
	 * @return array Collaboratori
	 */
	function &getUser()
	{
		if ($this->userCache == NULL)
		{
			$this->userCache = User::selectUser($this->getIdUtente()); 
		}
		return $this->userCache;
	}
 
	
	/**
	 * Ritorna un collaboratori dato l'id_utente del database
	 *
	 * @static
	 * @param int $id_utente numero identificativo utente
	 * @return array Collaboratori
	 */
	function &selectCollaboratore($id_utente)
	{
		
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_utente,	intro, recapito, obiettivi, foto, ruolo FROM collaboratore WHERE id_utente = '.$db->quote($id_utente);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows == 0) return false;

		$row = $res->fetchRow();
		$collaboratore = new Collaboratore($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		
		return $collaboratore;
	
	}
	
	/**
	 * Preleva tutti i collaboratori dal database
	 *
	 * @static
	 * @param int $id_utente numero identificativo utente
	 * @return array Collaboratori
	 */
	function &selectCollaboratoriAll()
	{
		
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_utente,	intro, recapito, obiettivi, foto, ruolo FROM collaboratore';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		
		$collaboratori = array();

		while($row = $res->fetchRow())
		{
			$collaboratori[] = new Collaboratore($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		}
		
		return $collaboratori;
	
	}
	
}


?>