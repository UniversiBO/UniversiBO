<?php
/**
* _UnitTest_Cdl.php
* 
* suite di test per la classe Cdl
*/ 


require_once 'PHPUnit'.PHP_EXTENSION;
require_once 'Cdl'.PHP_EXTENSION;


/**
 * Test per la classe Faoclta
 *
 * @package universibo_tests
 * @author Fabrizio Pinto
 * @license GPL, http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class CdlTest extends PHPUnit_TestCase
{

	var $cdl;	

	function UserTest($name)
	{
		$this->PHPUnit_TestCase($name);
	}
	
	// called before the test functions will be executed
	function setUp()
	{
		$db =& FrontController::getDbConnection('main');
		$db->autoCommit(false);
		$this->cdl = Cdl::selectCdlCodice('0051');
	}
	
	// called after the test functions are executed
	function tearDown() {
		$db =& FrontController::getDbConnection('main');
		$db->rollback();
		$db->autoCommit(true);
	}
	
	
	function testSetGet()
	{
		$this->cdl->getNome();
		$this->cdl->getCodiceFacoltaPadre();
		$this->cdl->getCodiceCdl();

		$cod_new = '0022';
		$this->cdl->setCodiceCdl($cod_new);
		$this->assertEquals($cod_new, $this->cdl->getCodiceCdl());

#	 * define('CDL_NUOVO_ORDINAMENTO'   ,1);
#	 * define('CDL_SPECIALISTICA'       ,2);
#	 * define('CDL_VECCHIO_ORDINAMENTO' ,3);

//	function getCategoriaCdl()
//	function getNomeMyUniversiBO()
//	{
//	function getTitolo()
//		return "CORSO DI LAUREA DI \n".$this->getNome();

	}
	
	function testRetrieveAndUpdate()
	{
		
		$cdl =& Cdl::selectCdlCanale($this->cdl->getIdCanale());
		
		$new_link = 'http://www.ing.example.com';
		$cdl->setUri($new_link);
		$nome_cdl = 'INGEGNIERIAHAH';
		$cdl->setNome($nome_cdl);
		$cod_new = '0022';
		$cdl->setCodiceCdl($cod_new);
		
		$cdl->updateCdl();
		
		$cdl2 =& Cdl::selectCdlCanale($this->cdl->getIdCanale());
		
		$this->assertEquals($new_link, $cdl2->getUri());
		$this->assertEquals($nome_cdl, $cdl2->getNome());
		$this->assertEquals($cod_new, $cdl2->getCodiceCdl());
		
	}
	
	
	function testCdlElenco()
	{
		$elenco =& Cdl::selectCdlElenco();
		
		foreach ( $elenco as $cdl)
		{
			$value = $cdl->getNome();
			if (isset($value_old))
				$this->assertTrue( strcmp($value_old, $value) < 0 );
			$value_old = $value;
		}
		
	}

}

?>
	
	
