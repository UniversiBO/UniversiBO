<?php
/**
* _UnitTest_Database.php
* 
* suite di test esegue query di controllo per il Database
*/ 


require_once 'PHPUnit'.PHP_EXTENSION;


/**
 * Test per la coerenza dei dati sul database
 *
 * @package universibo_tests
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Elisa Silenzi <>
 * @license GPL, http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2004
 */

class _UnitTest_Database extends PHPUnit_TestCase
{

	function UserTest($name)
	{
		$this->PHPUnit_TestCase($name);
	}
	
	// called before the test functions will be executed
	function setUp()
	{
		$db =& FrontController::getDbConnection('main');
		$db->autoCommit(false);
	}
	
	// called after the test functions are executed
	function tearDown() {
		$db =& FrontController::getDbConnection('main');
		$db->rollback();
		$db->autoCommit(true);
	}
	
	
		/**
--Controlla che tutti i canali siano puntati da un forum
		*/
	function testCanalePuntaForum()
	{
		$db =& FrontController::getDbConnection('main');
		//--Controlla che tutti i canali puntino un forum esistente
		$query = 'SELECT * FROM canale WHERE id_forum NOT IN (SELECT forum_id from phpbb_forums);';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controlla che tutti i canali puntino ad un gruppo esistente
		*/
	function testCanalePuntaGruppoForum()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM canale 
WHERE group_id NOT IN (SELECT group_id from phpbb_groups)
ORDER BY id_canale;
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controlla che files_attivo sia S o N
		*/
	function testCanaleFileAttivoSN()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM canale
WHERE files_attivo NOT IN (\'S\', \'N\');
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

	/**
--Controlla che news_attivo sia S o N
	*/
	function testCanaleNewsAttivoSN()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM canale
WHERE news_attivo NOT IN (\'S\', \'N\');
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che forum_attivo sia S o N
		*/
	function testCanaleForumAttivoSN()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM canale
WHERE forum_attivo NOT IN (\'S\', \'N\');
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che links_attivo sia S o N
		*/
	function testCanaleLinksAttivoSN()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM canale
WHERE links_attivo NOT IN (\'S\', \'N\');
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che i permessi siano minori di 127
		*/
	function testCanalePermessiMinore127()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM canale
WHERE permessi_groups>127;
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutti i cdl puntino ad un canale esistente
		*/
	function testCdlPuntaCanale()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM classi_corso 
WHERE id_canale NOT IN (SELECT id_canale from canale);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo se tutti i canali puntati dai cdl hanno tipo_canale=4 (cdl)
		*/
	function testCdlPuntatoDaCanaleDiTipo4()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT *
FROM classi_corso cc, canale cn 
WHERE cc.id_canale=cn.id_canale
AND cn.tipo_canale!=4;
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutti i cdl puntino ad una categoria del forum esistente (cat_id)
		*/
	function testCdlPuntaCategoriaForum()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM classi_corso 
WHERE cat_id NOT IN (SELECT cat_id from phpbb_categories);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo le corrispondenze tra titolo categoria e codice cdl --> NON FUNGE
		*/
	function testCdlPuntaCategoriaForumConCodiceNelTitolo()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '---
SELECT * 
FROM classi_corso cc, phpbb_categories pc
WHERE cc.cat_id=pc.cat_id
AND cc.cod_corso=substring(pc.cat_title from 0 for 4);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
//		else 
//		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutti i cdl abbiano un codice docente esistente
		*/
	function testCdlPuntaPresidente()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM classi_corso 
WHERE cod_doc NOT IN (SELECT cod_doc FROM docente);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutti i cdl abbiano un codice facolt? esistente
		*/
	function testCdlPuntaFacolta()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM classi_corso 
WHERE cod_fac NOT IN (SELECT cod_fac FROM facolta);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che l\'id del collaboratore esista tra gli id_utente
		*/
	function testCollaboratorePuntaIdUtente()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM collaboratore 
WHERE id_utente NOT IN (SELECT id_utente FROM utente);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che groups sia o 4 (moderatore) o 64(admin) (se qualcuno ha smesso di collaborare va ttenuto comunque nel chi siamo)
		*/
	function testCollaboratoriAppartengonoAiGruppiUtentiCollaboratoreOAdmin()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM collaboratore c, utente u 
WHERE c.id_utente=u.id_utente
AND u.groups NOT IN (4,64);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutti i docenti siano esistenti
		*/
	function testDocenteContattiPuntaDocente()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM docente_contatti 
WHERE cod_doc NOT IN (SELECT cod_doc FROM docente);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutte le facolt? puntino un canale esistente
		*/
	function testFacoltaPuntaCanale()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM facolta 
WHERE id_canale NOT IN (SELECT id_canale FROM canale);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che tutte le facolt? abbiano un codice docente esistente
		*/
	function testFacoltaPuntaDocente()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM facolta 
WHERE cod_doc NOT IN (SELECT cod_doc FROM docente);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che i permessi siano maggiori di 127
		*/
	function testFilePermessiMinori127()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM file 
WHERE permessi_visualizza>127 OR permessi_download>127;
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che l\'id_utente esista
		*/
	function testFileAutorePuntaUtente()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM file
WHERE id_utente NOT IN (SELECT id_utente FROM utente);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	

		/**
--Controllo che l\'id categoria sia esistente 
		*/
	function testFilePuntaCategoria()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT * 
FROM file
WHERE id_categoria NOT IN (SELECT id_categoria FROM file_categoria);
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	


	
	
		/**
		*/
	function test()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	
	







		/**
-- Controlla che le password di sito e forum siano uguali (restituisce tuple solo se trova pwd diverse)
		*/
	function testPasswordUtentiForumUguali()
	{
		$db =& FrontController::getDbConnection('main');

		$query = '
SELECT user_id, u.username, p.user_password, u.password
FROM phpbb_users p, utente u
WHERE user_id=id_utente
AND p.user_password NOT LIKE u.password
';

		$result =& $db->query($query);
		if (DB::isError($result)) $this->fail();
		else 
		$this->assertEquals(0, $result->numRows());
	}
	
	
	
	

}

?>