<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Cdl'.PHP_EXTENSION);


/**
 * ChangePassword is an extension of UniversiboCommand class.
 *
 * Si occupa della modifica della password di un utente
 * NON ASTRAE DAL LIVELLO DATABASE!!!
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptCreaForum extends UniversiboCommand 
{
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $fc->getTemplateEngine();
		$db =& $fc->getDbConnection('main');
		
		$query = 'begin';
		$res =& $db->query($query);
		if (DB::isError($res)) die($query); 

		$cdlAll =& Cdl::selectCdlAll();
		//var_dump($cdlAll);
		
		$query = 'commit';
		$res =& $db->query($query);
		if (DB::isError($res)) die($query); 
	}
	
	
	
}

?>
