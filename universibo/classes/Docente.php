<?php

require_once('User'.PHP_EXTENSION);

/**
 * Docente class, modella le informazioni relative ai docenti
 * A dir la verità non so perchè estende User @see Collaboratore
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2004
 */

class Docente extends User {
	
	/**
	 * @access private
	 */
	var $id_utente;
	
	/**
	 * @access private
	 */
	var $codDoc;	
	
	/**
	 * @access private
	 */
	var $nomeDoc;
	
	/**
	 * @access private
	 */
	var $userCache = null;

	function Docente($id_utente, $cod_doc, $nome_doc )
	{
		$this->id_utente	= $id_utente;
		$this->codDoc		= $cod_doc;
		$this->nomeDoc		= $nome_doc;
	}
	
	function getIdUtente()
	{
		return $this->id_utente;
	}

	function setIdUtente($id_utente)
	{
		$this->id_utente = $id_utente;
	}

	function getCodDoc()
	{
		return $this->codDoc;
	}

	function getNomeDoc()
	{
		return $this->nomeDoc;
	}
 
	function getHomepageDocente()
	{
		return 'http://www.unibo.it/Portale/Strumenti+del+Portale/Rubrica/paginaWebDocente.htm?mat='.$this->getCodDoc();
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
	function &selectDocente($id_utente)
	{
		
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_utente,	cod_doc, nome_doc FROM docente WHERE id_utente = '.$db->quote($id_utente);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows == 0) return false;

		$row = $res->fetchRow();
		$docente = new Docente($row[0], $row[1], $row[2]);
		
		return $docente;
	
	}
	
	
}


?>