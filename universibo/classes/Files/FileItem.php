<?php 


define('FILE_ELIMINATO', 'S');
define('FILE_NOT_ELIMINATO', 'N');

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
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class FileItem {

	/**
	 * @private
	 */
	var $id_file = 0;

	/**
	 * @private
	 */
	var $permessi_download = 0;

	/**
	 * @private
	 */
	var $permessi_visualizza = 0;

	/**
	 * @private
	 */
	var $id_utente = 0;

	/**
	 * @private
	 */
	var $titolo = '';

	/**
	 * @private
	 */
	var $descrizione = '';

	/**
	 * @private
	 */
	var $data_inserimento = 0;

	/**
	 * @private
	 */
	var $data_modifica = 0;

	/**
	 * @private
	 */
	var $dimensione = 0;

	/**
	 * @private
	 */
	var $download = 0;

	/**
	 * @private
	 */
	var $nome_file = '';

	/**
	 * @private
	 */
	var $id_categoria = 0;

	/**
	 * @private
	 */
	var $id_tipo_file = 0;

	/**
	 * @private
	 */
	var $hash_file = '';

	/**
	 * @private
	 */
	var $password = '';

	/**
	 * @private
	 */
	var $username = '';

	/**
	 * @private
	 */
	//	var $eliminato = false


	/**
	 * @private
	 */
	var $categoria_desc = '';

	/**
	 * @private
	 */
	var $tipo_desc = '';
	
	/**
	 * @private
	 */
	var $tipo_icona = '';
	
	/**
	 * @private
	 */
	var $tipo_info = '';
	
	
	
	///////////////////////////////////////////
	/**
	 * @private
	 */
	var $elencoIdCanali = NULL;

	/**
	 * @private
	 */
	var $elencoCanali = NULL;



	/**
	 * Crea un oggetto FileItem con i parametri passati
	 * 
	 *
	 * @param  int $id_file id del file
	 * @param  string $titolo titolo del file
	 * @param  string $descrizione descrizione completa del file
	 * @param  int $dimensione dimensione in kb del file
	 * @param  int $permessi_download categoria utenti ai quali è permesso il download
	 * @param  boolean $eliminato flag stato del file
	 * @return FileItem
	 */

	function FileItem($id_file, $permessi_download, $permessi_visualizza, $id_utente, $titolo,
					 $descrizione, $data_inserimento, $data_modifica, $dimensione, $download, 
					 $nome_file, $id_categoria, $id_tipo_file, $hash_file, $password, $username, 
					 $categoria_desc, $tipo_desc, $tipo_icona, $tipo_info  /*, $eliminato*/ ) {

		$this->id_file = $id_file;
		$this->permessi_download = $permessi_download;
		$this->permessi_visualizza = $permessi_visualizza;
		$this->id_utente = $id_utente;
		$this->titolo = $titolo;
		$this->descrizione = $descrizione;
		$this->data_inserimento = $data_inserimento;
		$this->data_modifica = $data_modifica;
		$this->dimensione = $dimensione;
		$this->download = $download;
		$this->nome_file = $nome_file;
		$this->id_categoria = $id_categoria;
		$this->id_tipo_file = $id_tipo_file;
		$this->hash_file = $hash_file;
		$this->password = $password;
		$this->username = $username;
		$this->categoria_desc = $categoria_desc;
		$this->tipo_desc = $tipo_desc;
		$this->tipo_icona = $tipo_icona;
		$this->tipo_info = $tipo_info;
		//		$this->eliminato = $eliminato;

	}

	/**
	 * @todo finire tutti i set/get
	 */

	/**
	 * Recupera il titolo del file
	 *
	 * @return string 
	 */

	function getTitolo() {
		return $this->titolo;
	}

	/**
	 * Recupera la descrizione completa del file
	 *
	 * @return string 
	 */

	function getDescrizione() {
		return $this->descrizione;
	}

	/**
	 * Recupera la dimensione del file
	 *
	 * @return int 
	 */

	function getDimensione() {
		return $this->dimensione;
	}

	/**
	 * Recupera l'id della categoria di utenti ai quali e permesso il download
	 *
	 * @return int 
	 */
	function getPermessiDownload() {
		return $this->permessi_download;
	}

	/**
	 * Recupera l'id delle categorie di utenti ai quali e permesso la visualizzazione
	 *
	 * @return int 
	 */
	function getPermessiVisualizza() {
		return $this->permessi_visualizza;
	}

	/**
	 * Recupera la data di caricamento del file (timestamp)
	 *
	 * @return int 
	 */

	function getDataInserimento() {
		return $this->data_iserimento;
	}

	/**
	 * Recupera la data di ultima modifica del file (timestamp)
	 *
	 * @return int 
	 */

	function getDataModifica() {
		return $this->data_modifica;
	}

	/**
	 * Recupera l'hash del file (almeno credo)
	 *
	 * @return string 
	 */

	function getHashFile() {
		return $this->hash_file;
	}

	/**
	 * Imposta la descrizione completa del file
	 *
	 * @param string $descrizione descrizione completa del file
	 */

	function setDescrizione($descrizione) {
		$this->descrizione = $descrizione;
	}

	/**
	 * Imposta la dimensione del file
	 *
	 * @param int $dimensione dimensione in kb del file
	 */

	function setDimensione($dimensione) {
		$this->dimensione = $dimensione;
	}

	/**
	 * Imposta l'id della categoria di utenti ai quali e permesso il download
	 *
	 * @param int $permessi categoria utenti ai quali è permesso il download
	 */

	function setPermessi($permessi) {
		$this->permessi = $permessi;
	}

	/**
	 * Imposta la data di caricamento del file (timestamp)
	 *
	 * @param int $data timestamp del giorno dell'ultima operazione sul file
	 */

	function setData($data) {
		$this->data = $data;
	}

	/**
	 * Imposta l'hash del file (almeno credo)
	 *
	 * @param string $hash hash del file
	 */

	function setHash($hash) {
		$this->hash = $hash;
	}

	//ilias: da qui in giù sto sistemando dal copia e incolla da NewsItem

	/**
	 * Recupera un file dal database
	 *
	 * @static
	 * @param int $id_file  id del file
	 * @return FileItem 
	 */
	function & selectFileItem($id_file) {
		$id_files = array ($id_file);
		$files = & FileItem :: selectFileItems($id_files);
		if ($files === false)
			return false;
		return $files[0];
	}

	/**
	 * Recupera un elenco di file dal database
	 * non ritorna i files eliminati
	 *
	 * @static
	 * @param array $id_file array elenco di id dei file
	 * @return array FileItem 
	 */
	function & selectFileItems($id_files) {

		$db = & FrontController :: getDbConnection('main');

		if (count($id_files) == 0)
			return array ();

		//esegue $db->quote() su ogni elemento dell'array
		//array_walk($id_notizie, array($db, 'quote'));
		if (count($id_files) == 1)
			$values = $id_files[0];
		else
			$values = implode(',', $id_notizie);

		$query = 'SELECT id_file, permessi_download, permessi_visualizza, A.id_utente, titolo, descrizione, data_inserimento, data_modifica, dimensione, download, nome_file, id_categoria, id_tipo_file, hash_file, password, eliminato, username FROM file A, utente B WHERE A.id_utente = B.id_utente AND id_news IN ('.$values.') AND eliminata!='.$db->quote(NEWS_ELIMINATA);
		//var_dump($query);
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throw (_ERROR_CRITICAL, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));

		$rows = $res->numRows();

		if ($rows = 0)
			return false;
		$files_list = array ();

		while ($res->fetchInto($row)) {
			$files_list[] = & new FileItem($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17]);
		}

		$res->free();

		return $files_list;
	}

	/**
	 * Seleziona gli id_canale per i quali il file è inerente 
	 * non si possono fare garanzie sull'ordine dei canali
	 *
	 * @return array	elenco degli id_canale
	 */
	function & getIdCanali() {
		if ($this->elencoIdCanali != NULL)
			return $this->elencoIdCanali;

		$id_file = $this->getIdFile();

		$db = & FrontController :: getDbConnection('main');

		$query = 'SELECT id_canale FROM file_canale WHERE id_file='.$db->quote($id_file).' ORDER BY id_canale';
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throw (_ERROR_DEFAULT, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));

		$elenco_id_canale = array ();

		while ($res->fetchInto($row)) {
			$elenco_id_canale[] = $row[0];
		}

		$res->free();

		$this->elencoIdCanali = & $elenco_id_canale;

		return $this->elencoIdCanali;

	}

	/**
	 * rimuove la notizia dal canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function removeCanale($id_canale) {

		$db = & FrontController :: getDbConnection('main');

		$query = 'DELETE FROM file_canale WHERE id_canale='.$db->quote($id_canale).' AND id_file='.$db->quote($this->getIdFile());
		//? da testare il funzionamento di =&
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throw (_ERROR_DEFAULT, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));

		// rimuove l'id del canale dall'elenco completo
		$this->elencoIdCanali = array_diff($this->elencoIdCanali, array ($id_canale));

		/**
		 * @TODO settare eliminata = 'S' quando la notizia viene tolta dall'ultimo canale
		 */
	}

	/**
	 * aggiunge la notizia al canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 * @return boolean  true se esito positivo 
	 */
	function addCanale($id_canale) {
		$return = true;

		if (!Canale :: canaleExists($id_canale)) {
			return false;
			//Error::throw(_ERROR_CRITICAL,array('msg'=>'Il canale selezionato non esiste','file'=>__FILE__,'line'=>__LINE__));
		}

		$db = & FrontController :: getDbConnection('main');

		$query = 'INSERT INTO file_canale (id_file, id_canale) VALUES ('.$db->quote($this->getIdFile()).','.$db->quote($id_canale).')';
		//? da testare il funzionamento di =&
		$res = $db->query($query);
		if (DB :: isError($res)) {
			return false;
			//	$db->rollback();
			//	Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
		}

		$this->elencoIdCanale[] = $id_canale;

		return true;

	}

	/**
	 * Inserisce una notizia sul DB
	 *
	 * @param	 array 	$array_id_canali 	elenco dei canali in cui bisogna inserire la notizia. Se non si passa un canale si recupera quello corrente.
	 * @return	 boolean true se avvenua con successo, altrimenti Error object
	 */
	function insertFileItem() {
		$db = & FrontController :: getDbConnection('main');

		ignore_user_abort(1);
		$db->autoCommit(false);
		$next_id = $db->nextID('news_id_news');
		$return = true;
		$scadenza = ($this->getDataScadenza() == NULL) ? ' NULL ' : $db->quote($this->getDataScadenza());
		$eliminata = ($this->isEliminata()) ? NEWS_ELIMINATA : NEWS_NOT_ELIMINATA;
		$flag_urgente = ($this->isUrgente()) ? NEWS_URGENTE : NEWS_NOT_URGENTE;
		$query = 'INSERT INTO news (id_news, titolo, data_inserimento, data_scadenza, notizia, id_utente, eliminata, flag_urgente, data_modifica) VALUES '.'( '.$next_id.' , '.$db->quote($this->getTitolo()).' , '.$db->quote($this->getDataIns()).' , '.$scadenza.' , '.$db->quote($this->getNotizia()).' , '.$db->quote($this->getIdUtente()).' , '.$db->quote($eliminata).' , '.$db->quote($flag_urgente).' , '.$db->quote($this->getUltimaModifica()).' )';
		$res = $db->query($query);

		if (DB :: isError($res)) {
			$db->rollback();
			Error :: throw (_ERROR_CRITICAL, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));
		}

		$this->setIdNotizia($next_id);

		$db->commit();
		$db->autoCommit(true);
		ignore_user_abort(0);
	}

	/**
	 * Aggiorna le modifiche alla notizia nel DB
	 *
	 * @return	 boolean true se avvenua con successo, altrimenti Error object
	 */
	function updateNewsItem() {
		$db = & FrontController :: getDbConnection('main');

		ignore_user_abort(1);
		$db->autoCommit(false);
		$return = true;
		$scadenza = ($this->getDataScadenza() == NULL) ? ' NULL ' : $db->quote($this->getDataScadenza());
		$flag_urgente = ($this->isUrgente()) ? NEWS_URGENTE : NEWS_NOT_URGENTE;
		$deleted = ($this->isEliminata()) ? NEWS_ELIMINATA : NEWS_NOT_ELIMINATA;
		$query = 'UPDATE news SET titolo = '.$db->quote($this->getTitolo()).' , data_inserimento = '.$db->quote($this->getDataIns()).' , data_scadenza = '.$scadenza.' , notizia = '.$db->quote($this->getNotizia()).' , id_utente = '.$db->quote($this->getIdUtente()).' , eliminata = '.$db->quote($deleted).' , flag_urgente = '.$db->quote($flag_urgente).' , data_modifica = '.$db->quote($this->getUltimaModifica()).' WHERE id_news = '.$db->quote($this->getIdNotizia());
		//echo $query;								 
		$res = $db->query($query);
		//var_dump($query);
		if (DB :: isError($res)) {
			$db->rollback();
			Error :: throw (_ERROR_CRITICAL, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));
		}

		$db->commit();
		$db->autoCommit(true);
		ignore_user_abort(0);
	}

	/**
	 * La funzione deleteNewsItem controlla se la notizia é stata eliminata da tutti i canali in cui era presente, e aggiorna il db
	 */

	function deleteNewsItem() {
		$lista_canali = & $this->getIdCanali();
		if (count($lista_canali) == 0) {
			$this->eliminata = true;
			$this->updateNewsItem();
		}
	}

}

?>