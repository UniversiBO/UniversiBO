<?php
/**
* _UnitTest_Facolta.php
* 
* suite di test per la classe Facolta
*/ 


require_once 'PHPUnit'.PHP_EXTENSION;
require_once 'Facolta'.PHP_EXTENSION;


/**
 * Test per la classe Faoclta
 *
 * @package universibo_tests
 * @author Fabrizio Pinto
 * @license GPL, http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class FacoltaTest extends PHPUnit_TestCase
{

	var $facolta;	

	function UserTest($name)
	{
		$this->PHPUnit_TestCase($name);
	}
	
	// called before the test functions will be executed
	function setUp()
	{
		$this->facolta = Facolta::selectFacoltaCodice('0021');
	}
	
	// called after the test functions are executed
	function tearDown() {}
	
	
	function testSetGetCodice()
	{
		$cod_new = '0022';
		$this->facolta->setCodiceFacolta($cod_new);
		$this->assertEquals($cod_new, $this->facolta->getCodiceFacolta());
	}
	
	function testSetGetNome()
	{
		$nome_facolta = 'INGEGNIERIAHAH';
		$this->facolta->setNome($nome_facolta);
		$this->assertEquals($nome_facolta, $this->facolta->getNome());
		$this->assertEquals("FACOLTA' DI \n".$nome_facolta, $this->facolta->getTitolo());
	}


	function testSetGetUri()
	{
		$new_value = 'http://www.ing.example.com';
		$this->facolta->setUri($new_value);
		$this->assertEquals($new_value, $this->facolta->getUri());
	}

	function testRetrieveAndUpdate()
	{
		$db =& FrontController::getDbConnection('main');
		$db->autoCommit(false);
		
		$facolta =& Facolta::selectFacoltaCanale($this->facolta->getIdCanale());
		
		$new_link = 'http://www.ing.example.com';
		$facolta->setUri($new_link);
		$nome_facolta = 'INGEGNIERIAHAH';
		$facolta->setNome($nome_facolta);
		$cod_new = '0022';
		$facolta->setCodiceFacolta($cod_new);
		
		$facolta->updateFacolta();
		
		$facolta2 =& Facolta::selectFacoltaCanale($this->facolta->getIdCanale());
		
		$this->assertEquals($new_link, $facolta2->getUri());
		$this->assertEquals($nome_facolta, $facolta2->getNome());
		$this->assertEquals($cod_new, $facolta2->getCodiceFacolta());
		
		$db->rollback();
		$db->autoCommit(true);
	}

}

?>

	/**
	 * Seleziona da database e restituisce un'array contenente l'elenco 
	 * in ordine alfabetico di tutte le facolt? 
	 * 
	 * @static
	 * @param string $cod_facolta stringa a 4 cifre del codice d'ateneo della facolt?
	 * @return array(Facolta)
	 */
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
	 * Siccome nella maggiorparte delle chiamate viene eseguito l'accesso a tutte le
	 * facolt? questa procedura si occupa di eseguire il caching degli oggetti facolt?
	 * in variabili static (globali per comodit? implementativa) e permette di 
	 * alleggerire i futuri accessi a DB implementando di fatto insieme ai metodi
	 * select*() i meccanismi di un metodo singleton factory
	 * 
	 * @static
	 * @private
	 * @return none 
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
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
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
	
	/** 
	 * Restituisce l'uri del command che visulizza il canale
	 *	
	 * @return string URI del command 
	 */
	 function getShowUri()
	 {
	 	return 'index.php?do=ShowFacolta&id_canale='.$this->getIdCanale();
	 }
