<?php
/**
* _UnitTest_PrgAttivitaDidattica.php
* 
* suite di test per la classe PrgAttivitaDidattica
*/ 


require_once 'PHPUnit'.PHP_EXTENSION;
require_once 'PrgAttivitaDidattica'.PHP_EXTENSION;


/**
 * Test per la classe PrgAttivitaDidattica
 *
 * @package universibo_tests
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class _UnitTest_PrgAttivitaDidattica extends PHPUnit_TestCase
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
		$this->cdl = PrgAttivitaDidattica::selectPrgAttivitaDidattica(435);
	}
	
//	// called after the test functions are executed
//	function tearDown() {
//		$db =& FrontController::getDbConnection('main');
//		$db->rollback();
//		$db->autoCommit(true);
//	}
//	
//	
//	function testSetGet()
//	{
//		$cod_new = '0022';
//		$this->cdl->setCodicePrgAttivitaDidattica($cod_new);
//		$this->assertEquals($cod_new, $this->cdl->getCodicePrgAttivitaDidattica());
//
//		$codFac_new = '0028';
//		$this->cdl->setCodiceFacoltaPadre($codFac_new);
//		$this->assertEquals($codFac_new, $this->cdl->getCodiceFacoltaPadre());
//		
//		$nome_new = 'INOSUX';
//		$this->cdl->setNome($nome_new);
//		$this->assertEquals($nome_new, $this->cdl->getNome());
//
//		$codDoc_new = '666666';
//		$this->cdl->setCodDocente($codDoc_new);
//		$this->assertEquals($codDoc_new, $this->cdl->getCodDocente());
//
//		$catId_new = '666';
//		$this->cdl->setForumCatId($catId_new);
//		$this->assertEquals($catId_new, $this->cdl->getForumCatId());
//
//		$cat_new = '3';
//		$this->cdl->setCategoriaPrgAttivitaDidattica($cat_new);
//		$this->assertEquals($cat_new, $this->cdl->getCategoriaPrgAttivitaDidattica());
//
//	}
//	
//	function testRetrieveAndUpdate()
//	{
//		
//		$cdl =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaCanale($this->cdl->getIdCanale());
//		
//		$cod_new = '6666';
//		$cdl->setCodicePrgAttivitaDidattica($cod_new);
//
//		$codFac_new = '0028';
//		$cdl->setCodiceFacoltaPadre($codFac_new);
//		
//		$nome_new = 'INOSUX';
//		$cdl->setNome($nome_new);
//
//		$codDoc_new = '666666';
//		$cdl->setCodDocente($codDoc_new);
//		
//		$catId_new = '666';
//		$cdl->setForumCatId($catId_new);
//		
//		$cat_new = '3';
//		$cdl->setCategoriaPrgAttivitaDidattica($cat_new);
//
//		$cdl->updatePrgAttivitaDidattica();
////		var_dump($cdl);
//		
//		$cdl2 =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaCanale($this->cdl->getIdCanale());
//		
//		$this->assertEquals($cod_new, $cdl2->getCodicePrgAttivitaDidattica());
//		$this->assertEquals($codFac_new, $cdl2->getCodiceFacoltaPadre());
//		$this->assertEquals($nome_new, $cdl2->getNome());
//		$this->assertEquals($codDoc_new, $cdl2->getCodDocente());
//		$this->assertEquals($catId_new, $cdl2->getForumCatId());
//		$this->assertEquals($cat_new, $cdl2->getCategoriaPrgAttivitaDidattica());
//		
//	}
//	
//	
//	function testPrgAttivitaDidatticaElenco()
//	{
//		$cod_facolta = '0021';
//		$elenco =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaElencoFacolta($cod_facolta);
//		
//		foreach ( $elenco as $cdl)
//		{
//			$value = $cdl->getCategoriaPrgAttivitaDidattica();
//			if (isset($value_old))
//				$this->assertTrue( $value >= $value_old );
//			$value_old = $value;
//		}
//		
//	}

}

?>