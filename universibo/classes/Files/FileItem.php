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
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */


	/**
	 * @private
	 */
	var $id_file = 0;
	
	/**
	 * @private
	 */
	var $titolo = '';
	
	/**
	 * @private
	 */
	var $desc_breve = '';
	
	/**
	 * @private
	 */
	var $descrizione = '';
	
	/**
	 * @private
	 */
	var $autore = 0;
	
	/**
	 * @private
	 */
	var $num_download = 0;
	
	/**
	 * @private
	 */
	var $dimensione = 0;
	
	/**
	 * @private
	 */
	var $estensione = '';
	
	/**
	 * qualcosa del tipo
	 * 0 -> libero per tutti
	 * num_cat_utente -> ristretto ai superiori
	 *
	 * @private
	 */
	var $permessi = 0;
	
	/**
	 * @private
	 */
	var $data = 0;
	
	/**
	 * @private
	 */
	var $moderatore = 0;
	
	/**
	 * @private
	 */
	var $moder_data = 0;
	
	
	/**
	 * @private
	 */
	var $errata = 0;
	
	/**
	 * @private
	 */
	var $hash = '';
	
	/**
	 * @private
	 */
	var $eliminato = false;
	
	/**
	 * @private
	 */
	var $location = 'bho';
	
	/**
	 * Crea un oggetto FileItem con i parametri passati
	 * 
	 *
	 * @param  int $id_file id del file
	 * @param  string $titolo titolo del file
	 * @param  string $desc_breve categoria del file (dispense, appunti, temi d'esame, lucidi ...)
	 * @param  string $descrizione descrizione completa del file
	 * @param  int $autore id dell'utente che ha aggiunto il file
	 * @param  int $num_download numero di download del file
	 * @param  int $dimensione dimensione in kb del file
	 * @param  int $permessi categoria utenti ai quali è permesso il download
	 * @param  int $data timestamp del giorno dell'ultima operazione sul file
	 * @param  int $moderatore id del primo moderatore che ha controllato il file
	 * @param  int $moder_data timestamp del giorno in cui il mod ha controllato
	 * @param  int $errata id del file direttamente collegato a questo
	 * @param  string $hash hash del file
	 * @param  non_so $location dove si trova fisicamente il file (oppure il blob, non so)
	 * @param  boolean $eliminato flag stato del file
	 * @return FileItem
	 */
	 
	function FileItem($id_file, $titolo, $desc_breve, $descrizione, $autore, $num_download, $dimensione, $estensione, $permessi, $data, $moderatore, $moder_data, $errata, $hash, $eliminato, $location){
	 	
	 	$this->id_file = $id_file;
	 	$this->titolo = $titolo;
	 	$this->desc_breve = $desc_breve;
	 	$this->descrizione = $descrizione;
	 	$this->autore = $autore;
	 	$this->num_download = $num_download;
	 	$this->dimensione = $dimensione;
	 	$this->estensione = $estensione;
	 	$this->permessi = $permessi;
	 	$this->data = $data;
	 	$this->moderatore = $moderatore;
	 	$this->moder_data = $moder_data;
	 	$this->errata = $errata;
	 	$this->hash = $hash;
	 	$this->eliminato = $eliminato;
	 	$this->location = $location;
	 	
	 	/**
	 	 * alternativo
	 	 foreach ( $row as $name => $value) {
	 	 	$this->$name = $value;
	 	 }
	 	**/
	 	
	 
	 }
	 
	 function &selectFileItem ($id_file){
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT titolo, desc_breve, descrizione, autore, num_download, dimensione, estensione, permessi, data, moderatore, moder_data, errata, hash, eliminato, location FROM files WHERE id_file='.$db->quote($id_file);
		//$query .= 'AND eliminato <> '.$db->quote(FILE_ELIMINATO);
		
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
	
		$res->fetchInto($row);	
		
		$file =& new FileItem($id_file,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
		return $file;
	 }
	 
	 
	 function &selectFileItems ($id_files){
	 	
		array_walk($id_files, array($db, 'quote'));
		$values = implode(',',$id_files);

	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_file, titolo, desc_breve, descrizione, autore, num_download, dimensione, estensione, permessi, data, moderatore, moder_data, errata, hash, eliminato, location FROM files WHERE id_file IN ('.$values.')';
		//$query .= 'AND eliminato <> '.$db->quote(FILE_ELIMINATO);
		
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
		
		$file_list = array();
		
		while ($res->fetchInto($row)) {
			$file_list[] =& new FileItem($id_file,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]) ;	
		}
		
		return $file_list;
	 }


	 function &selectFileItemAltern ($id_file) {
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT * FROM files WHERE id_file='.$db->quote($id_file).'AND eliminato!='.$db->quote(FILE_ELIMINATO);
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
	
		$res->fetchInto($row);	
		
		$file =& new FileItem($row);
		return $file;
		
	 }
	 
	 
	 /**
	  * Recupera il titolo del file
	  *
	  * @return string 
	  */
	  
	 function getTitolo () {
	 	return $this->titolo;
	 }
	 
	 
	 /**
	  * Recupera la descrizione breve del file
	  *
	  * @return string 
	  */
	  
	 function getDesc_breve () {
	 	return $this->desc_breve;
	 }
	 
	 
	 /**
	  * Recupera la descrizione completa del file
	  *
	  * @return string 
	  */
	  
	 function getDescrizione () {
	 	return $this->descrizione;
	 }
	 
	 
	 /**
	  * Recupera l'id dell'utente che ha aggiunto il file
	  *
	  * @return int 
	  */
	  
	 function getAutore () {
	 	return $this->autore;
	 }
	 
	 
	 /**
	  * Recupera il numero di download del file
	  *
	  * @return int 
	  */
	  
	 function getNum_download () {
	 	return $this->num_download;
	 }
	 
	 
	 /**
	  * Recupera la dimensione del file
	  *
	  * @return int 
	  */
	  
	 function getDimensione () {
	 	return $this->dimensione;
	 }
	 
	 
	 /**
	  * Recupera l'estensione del file
	  *
	  * @return string 
	  */
	  
	 function getEstensione () {
	 	return $this->estensione;
	 }
	 
	 
	 /**
	  * Recupera l'id della categoria di utenti ai quali e permesso il download
	  *
	  * @return int 
	  */
	  
	 function getPermessi () {
	 	return $this->permessi;
	 }
	 
	 
	 /**
	  * Recupera la data di caricamento del file (timestamp)
	  *
	  * @return int 
	  */
	  
	 function getData () {
	 	return $this->data;
	 }
	 
	 
	 /**
	  * Recupera l'id del moderatore che ha controllato quel file
	  *
	  * @return int 
	  */
	  
	 function getModeratore () {
	 	return $this->moderatore;
	 }
	 
	 
	 /**
	  * Recupera la data in cui il moderatore ha controllato quel file
	  *
	  * @return int 
	  */
	  
	 function getModer_data () {
	 	return $this->moder_data;
	 }
	 
	 
	 /**
	  * Recupera l'id di un file collegato
	  *
	  * @return int 
	  */
	  
	 function getErrata () {
	 	return $this->errata;
	 }
	 
	 
	 /**
	  * Recupera l'hash del file (almeno credo)
	  *
	  * @return string 
	  */
	  
	 function getHash () {
	 	return$this->hash;
	 }
	 
	 
	 /**
	  * Recupera lo statp del file
	  *
	  * @return boolean 
	  */
	  
	 function getEliminato () {
	 	return $this->eliminato;
	 }
	 
	 
	 /**
	  * Recupera la posizione fisica del file
	  *
	  * @return bho 
	  */
	  
	 function getLocation () {
	 	return $this->location;
	 }
	 
	 /**
	  * Recupare lo stato del file
	  *
	  * @return boolean
	  */
	  
	 function isCancellato() {
	 	if ($this->eliminato == FILE_ELIMINATO) return true;
		
		return false;
	}
	
	
	 /**
	  * Imposta il titolo del file
	  *
	  * @param string $titolo titolo del file
	  */
	  
	 function setTitolo ($titolo) {
	 	
	 	//paranoia
	 	//controlla che ci sia il titolo
	 	$titolo = trim($titolo);
	 	if (strlen($titolo) < 3) {
			//ERRORE: titolo troppo piccolo
		}
		//rimuovi il codice html
		$titolo = preg_replace("'<([^>]*?)>(.+?)<(/[^>]*?)>'si", "", $titolo);
		
	 	$this->titolo = $titolo;
	 }
	 
	 
	 /**
	  * Imposta la descrizione breve del file
	  *
	  * @param string $desc_breve categoria del file
	  */
	  
	 function setDesc_breve ($desc_breve) {
	 	$this->desc_breve = $desc_breve;
	 }
	 
	 
	 /**
	  * Imposta la descrizione completa del file
	  *
	  * @param string $descrizione descrizione completa del file
	  */
	  
	 function setDescrizione ($descrizione) {
	 	//controlla la validità del testo
	 	$this->descrizione = _control_txt($descrizione);
	 }
	 
	 
	 /**
	  * Imposta l'id dell'utente che ha aggiunto il file
	  *
	  * @param int $autore id dell'utente che ha aggiunto il file
	  */
	  
	 function setAutore ($autore) {
	 	$this->autore = $autore;
	 }
	 
	 
	 /**
	  * Imposta il numero di download del file
	  *
	  * @param int $num_download numero di download del file
	  */
	  
	 function setNum_download ($num_download) {
	 	$this->num_download = $num_download;
	 }
	 
	 
	 /**
	  * Imposta la dimensione del file
	  *
	  * @param int $dimensione dimensione in kb del file
	  */
	  
	 function setDimensione ($dimensione) {
	 	$this->dimensione = $dimensione;
	 }
	 
	 
	 /**
	  * Imposta l'estensione del file
	  *
	  * @param string 
	  */
	  
	 function setEstensione ($estensione) {
	 	$this->estensione = $estensione;
	 }
	 
	 
	 /**
	  * Imposta l'id della categoria di utenti ai quali e permesso il download
	  *
	  * @param int $permessi categoria utenti ai quali è permesso il download
	  */
	  
	 function setPermessi ($permessi) {
	 	$this->permessi = $permessi;
	 }
	 
	 
	 /**
	  * Imposta la data di caricamento del file (timestamp)
	  *
	  * @param int $data timestamp del giorno dell'ultima operazione sul file
	  */
	  
	 function setData ($data) {
	 	$this->data = $data;
	 }
	 
	 
	 /**
	  * Imposta l'id del moderatore che ha controllato quel file
	  *
	  * @param int $moderatore id del primo moderatore che ha controllato il file
	  */
	  
	 function setModeratore ($moderatore) {
	 	$this->moderatore = $moderatore;
	 }
	 
	 
	 /**
	  * Imposta la data in cui il moderatore ha controllato quel file
	  *
	  * @param int $moder_data timestamp del giorno in cui il mod ha controllato
	  */
	  
	 function setModer_data ($moder_data) {
	 	$this->moder_data = $moder_data;
	 }
	 
	 
	 /**
	  * Imposta l'id di un file collegato
	  *
	  * @param int $errata id del file direttamente collegato a questo
	  */
	  
	 function setErrata ($errata) {
	 	$this->errata = $errata;
	 }
	 
	 
	 /**
	  * Imposta l'hash del file (almeno credo)
	  *
	  * @param string $hash hash del file
	  */
	  
	 function setHash ($hash) {
	 	$this->hash = $hash;
	 }
	 
	 
	 /**
	  * Imposta lo statp del file
	  *
	  * @param boolean $eliminato flag stato del file
	  */
	  
	 function setEliminato ($eliminato) {
	 	$this->eliminato = $eliminato;
	 }
	 
	 
	 /**
	  * Imposta la posizione fisica del file
	  *
	  * @param bho $location dove si trova fisicamente il file (oppure il blob, non so)
	  */
	  
	 function setLocation ($location) {
	 	$this->location = $location;
	 }	
	 
	 
	 /**
	  * Inserisci il File nel database
	  *
	  * @return int, id dell'Item nel DB 
	  */
	 
	 function insertDB () {
	 	//controlla che almeno i campi obbligatori siano riempiti
	 	if ( ($this->titolo != '') and ($this->autore != '') and ($this->location != '') ) {
	 		continue;
	 	} else {
	 		//ERRORE: non è stato creato il FileItem correttamente
	 	}
	 	
	 	//la location c'è, ma se uno non ha lanciato il _getFileInfo lo faccio io ora
	 	if ($this->hash == '') {
	 		$file_info = $this->_getFileInfo($this->location);
	 		
	 		//aggiorna
	 		foreach ($file_info as $name => $value) {
	 			//potrei usare i metodi set, ma non ricordo come mettere le maiuscole :P
	 			$this->$name = $value;
	 		}
	 	}
	 	
	 	//dovrei controllare se sono admin/moderatore in quel caso sono io ad aver fatto i controlli
	 	//ma qui mi servirebbe sapere come sono organizzati gli utenti
	 	
	 	//ora che tutto è corretto aggiungi l'Item al DB
	 	$db =& FrontController::getDbConnection('main');
	 	
	 	//per la data sto usando la funzione time()
	 	$this->setData(time());
	 	$query = 'INSERT INTO files (titolo, desc_breve, descrizione, autore, num_download, dimensione, estensione, permessi, data, moderatore, moder_data, errata, hash, eliminato, location) VALUES ('.$db->quote($this->titolo).','.$db->quote($this->desc_breve).','.$db->quote($this->descrizione).','.$db->quote($this->autore).','.$db->quote($this->num_download).','.$db->quote($this->dimensione).','.$db->quote($this->estensione).','.$db->quote($this->permessi).','.$db->quote($this->data).','.$db->quote($this->moderatore).','.$db->quote($this->moder_data).','.$db->quote($this->errata).','.$db->quote($this->hash).','.$db->quote($this->eliminato).','.$db->quote($this->location).')';
	 	
	 	$res =& $db->query($query);
	 	
	 	if (DB::isError($res)) {
	 		//ERRORE: qualcosa è andato storto
	 	}
	 	
	 	//ho finito, restituisci l'id del nuovo item
	 	return $db->insert_id(); //esiste sta funzione???
	 	
	 }	
	 	
	 /**
	  * Aggiorna il File nel database
	  *
	  */
	   
	 function updateDB () {
	 	//ho selezionato un FileItem con selectFileItem, l'ho creato col costruttore
	 	//l'ho modificato con le funzioni di set, l'id non dovrebbe essere cambiato
	 	//ma per paranoia lo controllo lo stesso
	 	if (!$this->id_file) {
	 		//ERRORE: è successo qualcosa che non mi apettavo
	 	}
	 	
	 	//controlla che non sono stati eliminati campi obbligatori
	 	if ( ($this->titolo != '') and ($this->autore != '') and ($this->location != '') ) {
	 		continue;
	 	} else {
	 		//ERRORE: non è stato creato il FileItem correttamente
	 	}
	 	
	 	//la location c'è, ma se uno non ha lanciato il _getFileInfo lo faccio io ora
	 	if ($this->hash == '') {
	 		$file_info = $this->_getFileInfo($this->location);
	 		
	 		//aggiorna
	 		foreach ($file_info as $name => $value) {
	 			//potrei usare i metodi set, ma non ricordo come mettere le maiuscole :P
	 			$this->$name = $value;
	 		}
	 	}
	 	
	 	//ora che tutto è corretto aggiungi l'Item al DB
	 	$db =& FrontController::getDbConnection('main');
	 	
	 	//per la data sto usando la funzione time()
	 	$this->setData(time());
	 	$query = 'UPDATE files SET titolo = '.$db->quote($this->titolo).', desc_breve = '.$db->quote($this->desc_breve).', descrizione = '.$db->quote($this->descrizione).', autore = '.$db->quote($this->autore).', num_download = '.$db->quote($this->num_download).', dimensione = '.$db->quote($this->dimensione).', estensione = '.$db->quote($this->estensione).', permessi = '.$db->quote($this->permessi).', data = '.$db->quote($this->data).', moderatore = '.$db->quote($this->moderatore).', moder_data = '.$db->quote($this->moder_data).', errata = '.$db->quote($this->errata).', hash = '.$db->quote($this->hash).', eliminato = '.$db->quote($this->eliminato).', location = '.$db->quote($this->location).' WHERE id_file = '.$db->quote($this->id_file).' LIMIT 1';
	 	
	 	$res =& $db->query($query);
	 	
	 	if (DB::isError($res)) {
			//ERRORE: qualcosa è andato storto
	 	}
	 }
	 
	 /**
	  * Funzioni più snelle per gestire alcuni tipi di modifiche meno consistenti
	  *
	  */
	 
	function validate_moder () {
		//paranoia mode on
		if (!$this->id_file) {
	 		//ERRORE: è successo qualcosa che non mi apettavo
	 	}
	 	if ($cambiami__mio_gruppo != $gruppo_mod_admin) {
	 		//ERRORE: come ci sei arrivato qui???
	 	}
	 	if ($this->moderatore) {
	 		//ERRORE: il file è già approvato
	 	}
	 	
		$this->moderatore = $cambiami__mio_id;
		//o se preferisci: $this->setModeratore($cambiami__mio_id);
		$this->moder_data = time();
		//o come al solito: $this->setModer_data(time());
		
		$db =& FrontController::getDbConnection('main');
		
		$query = 'UPDATE files SET moderatore = '.$db->quote($this->moderatore).', moder_data = '.$db->quote($this->moder_data).' WHERE id_file = '.$db->quote($this->id_file).' LIMIT 1';
		
		$res =& $db->query($query);
	 	
	 	if (DB::isError($res)) {
			//ERRORE: qualcosa è andato storto
	 	}
	 }
	 
	 
	 /**
	  * Mi fa scaricare il file (finalmente :P )
	  *
	  */
	  
	function getFile () {
		//non so come implementarla perchè non so la location
	}
	
	
	 /**
	  * Controlla che il file sia integro, senza virus, mettilo dove deve andare 
	  * e restituisci hash, dimensione, estensione e location
	  * da lanciare prima di creare l'Item per avere alcuni parametri sul file
	  * necessario che $file sia un array del tipo $HTTP_POST_FILE
	  * se $file non è un array allora fa tutte le operazioni su un file linkato
	  *
	  * @static
	  * @param array $file file ottenuto dal modulo di input
	  * @return array
	  */
	   
	 function getFileInfo ($file) {
	 	
	 	//vedi se è un array o un link
	 	if (is_array($file)) {
	 		//controlla ci sia il filename
	 		if(($file['name'] == "") or !$file['name'] or ($file['name'] == "none")) {
		 		//ERRORE: file inesistente
		 	}
	 	
		 	//directory dove mettere il file
		 	$file_dir = 'bho'; 
	 		//nome del file
			$name = $file['name'];
			//dimensione
			$size = @round($file['size'] / 1024); //in kb
			//dove si trova ora
			$tmp_name = $file['tmp_name'];
			//estensione
			$ext = strrchr($name, '.');
		
			//controllare l'upload massimo???
			if ($size > $max_size) {
				//ERRORE: file troppo grosso
			}
		
			//tanto per paranoia
			$name = preg_replace( "';'", "", $name);
			$name = preg_replace( "' '", "%20", $name);
			$name = preg_replace( "/[^\w\.]/", "_", $name );
		
			//controllare sia un'estensione possibile???
			if(!in_array($ext ,$array_estensioni_possibili)) {
				//ERRORE: Estensione non consentita
			}
			
			//dove devo mettere il file
			$location = $file_dir.$name;
			if (! @move_uploaded_file( $tmp_name, $location) ) {
				//ERRORE: upload non riuscito
			}
	 	
	 	} 
	 	else
	 	{ //è un link
	 		
	 		$protocolli_permessi = array( 'http', 'https', 'ftp');
	 		$protocollo_usato = substr($file, 0, strrpos($file, '://'));
	 		//vedi se s'è scordato di mettere l'http (funziona solo con http e https)
	 		if (!in_array( strtolower($protocollo_usato), $protocolli_permessi)) {
	 			//ce lo metto io, tanto se ha sbagliato di brutto me ne accorgo dopo
	 			$file = 'http://'.$file;
	 		}
	 		clearstatcache();
			if(!file_exists($file)) {
				//ERRORE: Il file indicato non esiste
			}
			
			
	 		//nome del file
			$name = strrchr($file, '/');
			//dimensione
			$size = @round( @filesize( $file ) / 1024 ); //in kb
			//dove si trova ora
			$tmp_name = $file;
			//estensione
			$ext = strrchr($name, '.');
			
			//devo copiarmelo nel mio hd???
			//in questo caso dovrei fare del movimento che non mi va di fare ora
			//e non sarebbe nemmeno tanto sicuro, meglio non fidarsi
			
			//dove va il file
			$location = $file;
			//ho usato le stesse variabili nel caso qualcuno voglia implementare
			//il trasferimento sul server di universibo
			//mantenedo quindi un pò di simmetria
	 	}
		
		//in effetti sti controlli si possono evitare usando solo l'upload di file
		//bho
		
		$file_info['hash'] = 'bho';
		$file_info['dimensione'] = $size;
		$file_info['estensione'] = $ext;
		$file_info['location'] = $location;
		//la location la restituisce come posizione fisica su disco
		//se poi si vuole fare col database bho
	
		return $file_info;
	
	}
	
	/**
	 * Controlla che il testo inserito sia corretto
	 * converti il BBcode
	 * cancella tutto quanto potenzialmente pericoloso
	 *
	 * @private
	 * @param string $txt testo da controllare
	 * @return string
	 */

	function _control_txt($txt) {
		//converti i <br> in \n 
 		$txt = preg_replace( "/<br>|<br \/>/", "\n", $txt );
	
		$search = array(
				//porta tutto in html
				"'&(quot|#34);'i",
				"'&(amp|#38);'i",
				"'&(lt|#60);'i",
				"'&(gt|#62);'i",
				//converti l'html in BBcode
				"'<([^>]*?)>(.+?)<(/[^>]*?)>'si",
				//altri controlli
				"'&(nbsp|#160);'i",
				"'&(iexcl|#161);'i",
				"'&(cent|#162);'i",
				"'&(pound|#163);'i",
				"'&(copy|#169);'i",
				"'&#(\d+);'e",
				"':'i",
				"'\s{1};'e",
		);

		$sostituisci = array(
				"\"",
				"&",
				"<",
				">",
				"[\\1]\\2[\\3]",
				chr(160),
				chr(161),
				chr(162),
				chr(163),
				chr(169),
				"chr(\\1)",
				"&#58;",
				"&#59;",
				);
	
		$txt = preg_replace($search, $sostituisci, $txt);
	

		//Controlli BBcode
		$txt = preg_replace( "#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $txt );
		$txt = preg_replace( "#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $txt );
		$txt = preg_replace( "#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $txt );

		// email tags
			// [email]matt@index.com[/email]   [email=matt@index.com]Email me[/email]
		$txt = preg_replace( "#\[email\](\S+?)\[/email\]#i"                                                                , "<a href='mailto:\\1'>\\1</a>", $txt );
		$txt = preg_replace( "#\[email\s*=\s*\&quot\;([\.\w\-]+\@[\.\w\-]+\.[\.\w\-]+)\s*\&quot\;\s*\](.*?)\[\/email\]#i"  , "<a href='mailto:\\1'>\\2</a>", $txt );
		$txt = preg_replace( "#\[email\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/email\]#i"                       , "<a href='mailto:\\1'>\\2</a>", $txt );
		// url tags
			// [url]https://www.universibo.it[/url]   [url=https://www.universibo.it]UniversiBo![/url]
		$txt = preg_replace( "#\[url\](\S+?)\[/url\]#ie"                                       , "<a href='\\1'>\\1</a>", $txt );
		$txt = preg_replace( "#\[url\s*=\s*\&quot\;\s*(\S+?)\s*\&quot\;\s*\](.*?)\[\/url\]#ie" , "<a href='\\1'>\\2</a>", $txt );
		$txt = preg_replace( "#\[url\s*=\s*(\S+?)\s*\](.*?)\[\/url\]#ie"                       , "<a href='\\1'>\\2</a>", $txt );


		//Elimina tutto quello che non è BBcode
		$txt = preg_replace( "'\[[^\]]*?\].*?\[/[^\]]*?\]'si" , "", $txt);
	
		//Ripreistina i <br>
		$txt = preg_replace( "/\n/", "<br>", $txt );
	
	
		return $txt;
	}	












define('NEWS_ELIMINATA','S');
define('NEWS_NOT_ELIMINATA','N');


define('NEWS_URGENTE','S');
define('NEWS_NOT_URGENTE','N');

/**
 *
 * NewsItem class
 *
 * Rappresenta una singola news.
 *
 * @package News
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */


class NewsItem {
	
//	/**
//	 * ? costante per il valore del flag per le notizie eliminate
//	 *
//	 * @private
//	 */
//	var $ELIMINATA='S';
	
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
	var $ultimaModifica = NULL; 
	
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
	 	/**
	 	 * @TODO verifica parametri ingresso	
	 	 */
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
	function isUrgente()
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
	function isEliminata() 
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
	 * @param int timestamp dell'ultima modifica della notizia
	 */
	function setUltimaModifica($ultimaModifica) 
	{
	 	$this->ultimaModifica = $ultimaModifica;
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
	 * @return array NewsItems 
	 */
	 function &selectNewsItems ($id_notizie)
	 {
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		if ( count($id_notizie) == 0 )
			return array();
		
		//esegue $db->quote() su ogni elemento dell'array
		//array_walk($id_notizie, array($db, 'quote'));
		if ( count($id_notizie) == 1 ) 
			$values = $id_notizie[0];
		else 
			$values = implode(',',$id_notizie);
		
		$query = 'SELECT titolo, notizia, data_inserimento, data_scadenza, flag_urgente, eliminata, A.id_utente, id_news, username, data_modifica FROM news A, utente B WHERE A.id_utente = B.id_utente AND id_news IN ('.$values.') AND eliminata!='.$db->quote(NEWS_ELIMINATA);
		//var_dump($query);
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
		$news_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$news_list[] =& new NewsItem($row[7],$row[0],$row[1],$row[2],$row[3],$row[9],($row[4] == NEWS_URGENTE),($row[5] == NEWS_ELIMINATA),$row[6],$row[8] );
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
	function addCanale($id_canale)
	{
		$return = true;
		
	 	if ( !Canale::canaleExists($id_canale) ){
	 		return false;
	 		//Error::throw(_ERROR_CRITICAL,array('msg'=>'Il canale selezionato non esiste','file'=>__FILE__,'line'=>__LINE__));
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
		$query = 'INSERT INTO news_canale (id_news, id_canale) VALUES ('.$db->quote($this->getIdNotizia()).','.$db->quote($id_canale).')';
		 //? da testare il funzionamento di =&
		$res = $db->query($query);
		if (DB::isError($res)) {
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
	function insertNewsItem()
	{				 
		$db =& FrontController::getDbConnection('main');
		
        ignore_user_abort(1);
        $db->autoCommit(false);
        $next_id = $db->nextID('news_id_news');
		$return = true;
		$scadenza = ($this->getDataScadenza() == NULL) ? ' NULL ' : $db->quote($this->getDataScadenza());
		$eliminata = ($this->isEliminata()) ? NEWS_ELIMINATA : NEWS_NOT_ELIMINATA;
		$flag_urgente = ($this->isUrgente()) ? NEWS_URGENTE : NEWS_NOT_URGENTE;
		$query = 'INSERT INTO news (id_news, titolo, data_inserimento, data_scadenza, notizia, id_utente, eliminata, flag_urgente, data_modifica) VALUES '.
					'( '.$next_id.' , '.
					$db->quote($this->getTitolo()).' , '.
					$db->quote($this->getDataIns()).' , '.
					$scadenza.' , '.
					$db->quote($this->getNotizia()).' , '.
					$db->quote($this->getIdUtente()).' , '.
					$db->quote($eliminata).' , '.
					$db->quote($flag_urgente).' , '.
					$db->quote($this->getUltimaModifica()).' )'; 
		$res = $db->query($query);
		
		if (DB::isError($res)){
			$db->rollback();
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
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
	function updateNewsItem()
	{				 
		$db =& FrontController::getDbConnection('main');
		
        ignore_user_abort(1);
        $db->autoCommit(false);
        $return = true;
		$scadenza = ($this->getDataScadenza() == NULL) ? ' NULL ' : $db->quote($this->getDataScadenza());
		$flag_urgente = ($this->isUrgente()) ? NEWS_URGENTE : NEWS_NOT_URGENTE;
		$deleted = ($this->isEliminata()) ? NEWS_ELIMINATA : NEWS_NOT_ELIMINATA; 		
		$query = 'UPDATE news SET titolo = '.$db->quote($this->getTitolo())
					.' , data_inserimento = '.$db->quote($this->getDataIns())
					.' , data_scadenza = '.$scadenza
					.' , notizia = '.$db->quote($this->getNotizia())
					.' , id_utente = '.$db->quote($this->getIdUtente())
					.' , eliminata = '.$db->quote($deleted)
					.' , flag_urgente = '.$db->quote($flag_urgente)
					.' , data_modifica = '.$db->quote($this->getUltimaModifica())
					.' WHERE id_news = '.$db->quote($this->getIdNotizia());
		//echo $query;								 
		$res = $db->query($query);
		//var_dump($query);
		if (DB::isError($res)){
			$db->rollback();
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
		}
		
		$db->commit();
		$db->autoCommit(true);
		ignore_user_abort(0);
	}
	
	/**
	 * La funzione deleteNewsItem controlla se la notizia é stata eliminata da tutti i canali in cui era presente, e aggiorna il db
	 */
	
	function deleteNewsItem() 
	{
		$lista_canali =& $this->getIdCanali();
		if(count($lista_canali) == 0)
		{
			$this->eliminata = true;
			$this->updateNewsItem();
		} 
	}

} 

	
?>


 
?>