<?php

/**
 * UnitTest command class
 *
 * E' integrata ed utilizza il framework per avere accesso alle funzionalità
 * del framework stesso necessarie al corretto funzionamento della maggiorparte delle
 * entità da testare che sono ad esso accoppiate.
 *
 * @package universibo_tests
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @author Fabrizio Pinto 
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2003
 */



include ('UniversiboCommand'.PHP_EXTENSION);

class TestUnit extends UniversiboCommand {
	function execute()
	{
		$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', '../tests'.$pathDelimiter.ini_get('include_path'));

		include ('_UnitTest_StringEsempioUsoPhpUnit'.PHP_EXTENSION);
		echo '<br /><br />';
		
		include ('_UnitTest_User'.PHP_EXTENSION);
		echo '<br /><br />';

		include ('_UnitTest_User'.PHP_EXTENSION);
		echo '<br /><br />';

	}
}

?>