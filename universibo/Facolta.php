<?php

require_once('Canale'.PHP_EXTENSION);

global $__facoltaElencoCodice;
global $__facoltaElencoAlfabetico;
global $__facoltaElencoCanale;

$facoltaElencoCodice     = NULL;
$facoltaElencoAlfabetico = NULL;
$facoltaElencoCanale     = NULL;


/**
 * Facolta class.
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

	
	
	
	function Facolta($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo, $cod_facolta, $nome_facolta, $uri_facolta)
	{

		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
		
		$this->facoltaCodice = $cod_facolta;
		$this->facoltaNome   = $nome_facolta;
		$this->facoltaUri    = $uri_facolta;
	}



	function getNome()
	{
		return $this->facoltaNome;
	}


	function getTitolo()
	{
		return 'FACOLTA\' DI '.$this->getNomeFacolta();
	}


	function getCodiceFacolta()
	{
		return $this->facoltaCodice;
	}


	function &selectFacoltaCanale($id_canale)
	{
		global $__facoltaElencoCanale;
		
		if ( $__facoltaElencoCanale == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		return $__facoltaElencoCanale[$id_canale];
	}
	
	
	function &selectFacoltaCodice($cod_facolta)
	{
		global $__facoltaElencoCodice;
		
		if ( $__facoltaElencoCodice == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		return $__facoltaElencoCodice[$cod_facolta];
	}
	
	
	function &selectFacoltaElenco()
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
	 */
	function _selectFacolta()
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
		if( $rows = 0) return false;

		$__facoltaElencoAlfabetico = array();
		$__facoltaElencoCanale     = array();
		$__facoltaElencoCodice     = array();

		while (	$res->fetchInto($row) )
		{
			$facolta =& new Facolta($row[12], $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
				$row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S', $row[13], $row[14], $row[15]);

			$__facoltaElencoAlfabetico[] =& $facolta;
			$__facoltaElencoCodice[$facolta->getCodiceFacolta()] =& $facolta;
			$__facoltaElencoCanale[$facolta->getIdCanale()] =& $facolta;
		}

	}
	
}