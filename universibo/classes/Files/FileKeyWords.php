<?php  

/**
 *
 * FileItem class
 *
 * Rappresenta un singolo file.
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Fabio Crisci <fabioc83@yahoo.it>
 * @author Daniele Tiles
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class FileKeyWords{

//Todo: mancano le get&set dell'id_file e id_utente

	/**
	 * @private
	 */
	var $id_file = 0;

	/**
	 * Recupera le parole chiave
	 *
	 * @return array di string 
	 */
	function selectFileKeyWords($id_file) {
		return array();
	}


	/**
	 * Imposta le parole chiave
	 *
	 * @param array di string 
	 */
	function updateFileKeyWords() {
		return array();
	}

}

?>