<?php

require_once('Canale'.PHP_EXTENSION);

/**
 * Insegnamento class.
 *
 * Modella un insegnamento e le informazioni associate.
 * Ad un insegnamento possono essere associate da 1 a n attività didattiche (PrgAttivitaDidattica).
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Insegnamento extends Canale{
	
	/**
	 * @private
	 * per il caching del nome dell'insegnamento
	 */
	var $insegnamentoNome = '';
	
	/**
	 * @private
	 */
	var $insegnamentoUri = '';
	
	
	
	/**
	 * Crea un oggetto Insegnamento 
	 *
	 * @param int $id_canale 		identificativo del canale su database
	 * @param int $permessi 		privilegi di accesso gruppi {@see User}
	 * @param int $ultima_modifica 	timestamp 
	 * @param int $tipo_canale 	 	vedi definizione dei tipi sopra
	 * @param string  $immagine		uri dell'immagine relativo alla cartella del template
	 * @param string $nome			nome del canale
	 * @param int $visite			numero visite effettuate sul canale
	 * @param boolean $news_attivo	se true il servizio notizie è attivo
	 * @param boolean $files_attivo	se true il servizio false è attivo
	 * @param boolean $forum_attivo	se true il servizio forum è attivo
	 * @param int $forum_forum_id	se forum_attivo è true indica l'identificativo del forum su database
	 * @param int $forum_group_id	se forum_attivo è true indica l'identificativo del grupop moderatori del forum su database
	 * @param boolean $links_attivo se true il servizio links è attivo
	 * @param string $cod_facolta	codice identificativo d'ateneo della facoltà a 4 cifre 
	 * @param string $nome_facolta	descrizione del nome della facoltà
	 * @param string $uri_facolta	link al sito internet ufficiale della facoltà
	 * @return Insegnamento
	 */
	function Insegnamento($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo
				 /* ... */)
	{

		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
		
		/**
		
		//id_canale
		
		$this->facoltaCodice = $cod_facolta;
		$this->facoltaNome   = $nome_facolta;
		$this->facoltaUri    = $uri_facolta;
		*/
		
	}



	/**
	 * Restituisce il nome della facoltà
	 *
	 * @return string
	 */
	function getNome()
	{
		return $this->insegnamentoNome;
	}



	/**
	 * Restituisce il titolo/nome completo dell'insegnamento
	 *
	 * @return string
	 */
	function getTitolo()
	{
		return $this->getNome();
	}


	/**
	 * Restituisce il codice di ateneo a 4 cifre della facoltà
	 * es: ingegneria -> '0021'
	 *
	 * @return string
	 */
	function getCodiceFacolta()
	{
		return $this->facoltaCodice;
	}


	/**
	 * Crea un oggetto Cdl dato il suo numero identificativo id_canale
	 * Ridefinisce il factory method della classe padre per restituire un oggetto
	 * del tipo Cdl
	 *
	 * @static
	 * @param int $id_canale numero identificativo del canale
	 * @return mixed Facolta se eseguita con successo, false se il canale non esiste
	 */
	function &factoryCanale($id_canale)
	{
		return Insegnamento::selectInsegnamentoCanale($id_canale);
	}
	

	/**
	 * Seleziona da database e restituisce l'oggetto Insegnamento
	 * corrispondente al codice id_canale 
	 * 
	 * @static
	 * @param int $id_canale identificativo su DB del canale corrispondente al corso di laurea
	 * @return mixed Insegnamento se eseguita con successo, false se il canale non esiste
	 */
	function &selectInsegnamentoCanale($id_canale)
	{

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT .... WHERE a.id_canale = b.id_canale AND a.id_canale = '.$db->quote($id_canale);

		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;

		$res->fetchInto($row);
		$insegnamento =& new Insegnamento( /* ... $row[12], $row[5], */ );
		
		return $insegnamento;

	}
	
	

	/**
	 * Seleziona da database e restituisce l'oggetto Cdl 
	 * corrispondente al codice $cod_cdl 
	 * 
	 * @static
	 * @param string $cod_cdl stringa a 4 cifre del codice d'ateneo del corso di laurea
	 * @return Facolta
	 */
	function &selectInsegnamentoCodice(/* ...tutta la chiave... */)
	{

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT ... WHERE a.id_canale = b.id_canale AND b.cod_corso = '.$db->quote($cod_cdl);

		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;

		$res->fetchInto($row);
		$insegnamento =& new Insegnamento( /* ... $row[16] ... */ );
		
		return $insegnamento;

	}

	
	/**
	 * Seleziona da database e restituisce un'array contenente l'elenco 
	 * in ordine anno/ciclo/alfabetico di tutti gli insegnamenti appartenenti 
	 * al corso di laurea in un dato anno accademico
	 * 
	 * @static
	 * @param string $cod_cdl stringa a 4 cifre del codice del corso di laurea
	 * @param int $anno_accademico anno accademico
	 * @return array(Insegnamento)
	 */
	function &selectInsegnamentoElencoCdl($cod_cdl, $anno_accademico)
	{

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT ... AND b.cod_corso = '.$db->quote($cod_cdl).' ORDER BY ... ';

		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return array();
		$elenco = array();
		while (	$res->fetchInto($row) )
		{
			$insegnamento =& new Insegnamento( /* ... $row[15], $row[16] ... */ );

			$elenco[] =& $insegnamento;
		}
		
		return $elenco;
	}
	
}
?>