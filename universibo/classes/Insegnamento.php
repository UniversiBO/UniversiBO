<?php

require_once('Canale'.PHP_EXTENSION);

/**
 * Insegnamento class.
 *
 * Modella un insegnamento e le informazioni associate.
 * Ad un insegnamento possono essere associate da 1 a n attività didattiche (PRG_ATTIVITA_DOCENTE).
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
	 * @private
	 */
	var $uri = '';

	/**
	 * @private
	 */
	var $obiettivi = '';

	/**
	 * @private
	 */
	var $obiettiviUri = '';

	/**
	 * @private
	 */
	var $programma = '';

	/**
	 * @private
	 */
	var $programmaUri = '';

	/**
	 * @private
	 */
	var $materiale = '';

	/**
	 * @private
	 */
	var $materialeUri = '';

	/**
	 * @private
	 */
	var $modalita = '';

	/**
	 * @private
	 */
	var $modalitaUri = '';

	/**
	 * @private
	 */
	var $orario = '';

	/**
	 * @private
	 */
	var $orarioUri = '';

	/**
	 * @private
	 */
	var $appelli = '';

	/**
	 * @private
	 */
	var $appelliUri = '';
	
	
	/**
	 * Crea un oggetto Insegnamento 
	 *
	var $insegnamentoNome = '';
	var $insegnamentoUri = '';
	var $ = '';
	var $uri = '';
	var $obiettivi = '';
	var $obiettiviUri = '';
	var $programma = '';
	var $programmaUri = '';
	var $materiale = '';
	var $materialeUri = '';
	var $modalita = '';
	var $modalitaUri = '';
	var $orario = '';
	var $orarioUri = '';
	var $appelli = '';
	var $appelliUri = '';
	 * @param int $id_canale 		identificativo del canae su database
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
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo,
				 $cod_facolta, $nome_facolta, $uri_facolta)
	{

		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
		
		$this->facoltaCodice = $cod_facolta;
		$this->facoltaNome   = $nome_facolta;
		$this->facoltaUri    = $uri_facolta;
	}



	/**
	 * Restituisce il nome della facoltà
	 *
	 * @return string
	 */
	function getNome()
	{
		return $this->facoltaNome;
	}



	/**
	 * Restituisce il titolo/nome completo della facoltà
	 *
	 * @return string
	 */
	function getTitoloFacolta()
	{
		return 'FACOLTA\' DI '.$this->getNome();
	}



	/**
	 * Restituisce il link alla homepage ufficiale della facoltà
	 *
	 * @return string
	 */
	function getUri()
	{
		return $this->facoltaUri;
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
	 * Crea un oggetto facolta dato il suo numero identificativo id_canale
	 * Ridefinisce il factory method della classe padre per restituire un oggetto
	 * del tipo Facolta
	 *
	 * @static
	 * @param int $id_canale numero identificativo del canale
	 * @return mixed Facolta se eseguita con successo, false se il canale non esiste
	 */
	function &factoryCanale($id_canale)
	{
		return Facolta::selectFacoltaCanale($id_canale);
	}
	

	/**
	 * Seleziona da database e restituisce l'oggetto facoltà 
	 * corrispondente al codice id_canale 
	 * 
	 * @static
	 * @param int $id_canale id_del canale corrispondente alla facoltà
	 * @return mixed Facolta se eseguita con successo, false se il canale non esiste
	 */
	function &selectFacoltaCanale($id_canale)
	{
		global $__facoltaElencoCanale;
		
		if ( $__facoltaElencoCanale == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		if ( !array_key_exists($id_canale,$__facoltaElencoCanale) ) return false;
		
		return $__facoltaElencoCanale[$id_canale];
	}
	
	

	/**
	 * Seleziona da database e restituisce l'oggetto facoltà 
	 * corrispondente al codice $cod_facolta 
	 * 
	 * @static
	 * @param string $cod_facolta stringa a 4 cifre del codice d'ateneo della facoltà
	 * @return Facolta
	 */
	function &selectFacoltaCodice($cod_facolta)
	{
		global $__facoltaElencoCodice;
		
		if ( $__facoltaElencoCodice == NULL )
		{
			Facolta::_selectFacolta();
		}

		if ( !array_key_exists($cod_facolta,$__facoltaElencoCodice) ) return false;
		
		return $__facoltaElencoCodice[$cod_facolta];
	}
	

	
	/**
	 * Seleziona da database e restituisce un'array contenente l'elenco 
	 * in ordine alfabetico di tutte le facoltà 
	 * 
	 * @static
	 * @param string $cod_facolta stringa a 4 cifre del codice d'ateneo della facoltà
	 * @return array(Facolta)
	 */
	function &selectElencoInsegnamentiCdl()
	{
		global $__facoltaElencoAlfabetico;
		
		if ( $__facoltaElencoAlfabetico == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		return $__facoltaElencoAlfabetico;
	}
	
	
	/**
	 *
	 * 
	 * @static
	 * @private
	 * @return none 
	 */
	function _selectInsegnamento()
	{
		
		global $__facoltaElencoCodice;
		global $__facoltaElencoAlfabetico;
		global $__facoltaElencoCanale;

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, a.id_canale, cod_fac, desc_fac, url_facolta FROM canale a , facolta b WHERE a.id_canale = b.id_canale ORDER BY 15';
		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		$__facoltaElencoAlfabetico = array();
		$__facoltaElencoCanale     = array();
		$__facoltaElencoCodice     = array();

		if( $rows = 0) return array();
		while (	$res->fetchInto($row) )
		{
			$facolta =& new Facolta($row[12], $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
				$row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S', $row[13], $row[14], $row[15]);

			$__facoltaElencoAlfabetico[] =& $facolta;
			$__facoltaElencoCodice[$facolta->getCodiceFacolta()] =& $facolta;
			$__facoltaElencoCanale[$facolta->getIdCanale()] =& $facolta;
		}
		$res->free();
		
	}
	
}
?>