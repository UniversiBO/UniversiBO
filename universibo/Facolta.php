<?php

require_once('Canale'.PHP_EXTENSION);

define('CANALE_DEFAULT'   ,1);
define('CANALE_HOME'      ,2);
define('CANALE_FACOLTA'   ,3);
define('CANALE_CDL'       ,4);
define('CANALE_ESAME_ING' ,5);
define('CANALE_ESAME_ECO' ,6);


/**
 * Canale class.
 *
 * Un "canale" è una pagina dinamica con a disposizione il collegamento 
 * verso i vari servizi tramite un indentificativo, gestisce i diritti di
 * accesso per i diversi gruppi e diritti particolari 'ruoli' per alcuni utenti,
 * fornisce sistemi di notifica e per assegnare un nome ad un canale
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Facolta extends Canale{
	
	/**
	 * @private
	 */
	var $facoltaCodice = '';
	/**
	 * @private
	 */
	var $facoltaNome = '';
	/**
	 * @private
	 */
	var $facoltaUri = '';
	/**
	 * @private
	 */
	var $facoltaElencoCodice = NULL;
	/**
	 * @private
	 */
	var $facoltaElencoAlfabetico = NULL;
	/**
	 * @private
	 */
	var $facoltaElencoCanale = NULL;
	
	
	
	
	
	function Facolta($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo, $cod_facolta, $nome_facolta, $uri_facolta)
	{

		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
		
		$this->$facoltaCodice = $cod_facolta;
		$this->$facoltaNome = $nome_facolta;
		$this->$facoltaUri = $uri_facolta;
		
	}



	function &selectFacoltaCanale($id_canale)
	{

	}
	
	
	function &selectFacoltaCodice($cod_facolta)
	{

	}
	
	
	function &selectElencoFacolta()
	{
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, a.id_canale, cod_fac, desc_fac, url_facolta FROM canale a , facolta b WHERE a.id_canale = b.id_canale ORDER BY 14';
		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows = 0) return false;

		$this->facoltaElencoAlfabetico = array();
		$this->facoltaElencoCanale     = array();
		$this->facoltaElencoCodice     = array();

		while (	$res->fetchInto($row) )
		{
			$facolta =& new Facolta($row[12], $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
				$row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S', $row[13], $row[14], $row[15]);

			$this->facoltaElencoAlfabetico[] =& $facolta;
			$this->facoltaElencoCodice[$facolta->getFacoltaCodice()] =& $facolta;
			$this->facoltaElencoAlfabetico[$facolta->getIdCanale()] =& $facolta;


		}
		
		
		return $elenco_facolta;
		
		
	}
	
	
	
	
}