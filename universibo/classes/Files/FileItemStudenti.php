<?php  

require_once('Files/FileKeyWords'.PHP_EXTENSION);
require_once('Files/FileItem'.PHP_EXTENSION);

/**
 * FileItemStudenti class
 *
 * Rappresenta un singolo file degli studenti.
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Fabio Crisci <fabioc83@yahoo.it>
 * @author Daniele Tiles
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class FileItemStudenti extends FileItem {
	
	/**
	 * aggiunge il file al canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 * @return boolean  true se esito positivo 
	 */
	function addCanale($id_canale) {
		$return = true;

		if (!Canale :: canaleExists($id_canale)) {
			return false;
			//Error::throwError(_ERROR_CRITICAL,array('msg'=>'Il canale selezionato non esiste','file'=>__FILE__,'line'=>__LINE__));
		}

		$db = & FrontController :: getDbConnection('main');

		$query = 'INSERT INTO file_studente_canale (id_file, id_canale) VALUES ('.$db->quote($this->getIdFile()).','.$db->quote($id_canale).')';
		//? da testare il funzionamento di =&
		$res = $db->query($query);
		if (DB :: isError($res)) {
			return false;
			//	$db->rollback();
			//	Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
		}

		$this->elencoIdCanale[] = $id_canale;

		return true;

	}
	
	
	/**
	 * rimuove il file dal canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function removeCanale($id_canale) {

		$db = & FrontController :: getDbConnection('main');

		$query = 'DELETE FROM file_studente_canale WHERE id_canale='.$db->quote($id_canale).' AND id_file='.$db->quote($this->getIdFile());
		//? da testare il funzionamento di =&
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throwError(_ERROR_DEFAULT, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));

		// rimuove l'id del canale dall'elenco completo
		$this->elencoIdCanali = array_diff($this->elencoIdCanali, array ($id_canale));

		/**
		 * @TODO settare eliminata = 'S' quando il file viene tolto dall'ultimo canale
		 */
	}
	
	/**
	 * Seleziona gli id_canale per i quali il file ? inerente 
	 * non si possono fare garanzie sull'ordine dei canali
	 *
	 * @return array	elenco degli id_canale
	 */
	
	function & getIdCanali() {
		if ($this->elencoIdCanali != NULL)
			return $this->elencoIdCanali;

		$id_file = $this->getIdFile();

		$db = & FrontController :: getDbConnection('main');

		$query = 'SELECT id_canale FROM file_studente_canale WHERE id_file='.$db->quote($id_file).' ORDER BY id_canale';
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throwError(_ERROR_DEFAULT, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));

		$elenco_id_canale = array ();

		while ($res->fetchInto($row)) {
			$elenco_id_canale[] = $row[0];
		}

		$res->free();

		$this->elencoIdCanali = & $elenco_id_canale;

		return $this->elencoIdCanali;

	}
	
}

?>