<?php

/**
 * UnitTest command class
 *
 * E' integrata ed utilizza il framework per avere accesso alle funzionalit?
 * del framework stesso necessarie al corretto funzionamento della maggiorparte delle
 * entit? da testare che sono ad esso accoppiate.
 *
 * @package universibo_tests
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Fabrizio Pinto 
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2003
 */



require_once ('UniversiboCommand'.PHP_EXTENSION);

class TestUnit extends UniversiboCommand {
	function execute()
	{
		$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', '../tests'.$pathDelimiter.ini_get('include_path'));

		if (!($dir_handle = opendir('../tests')))
			Error::throwError(_ERROR_CRITICAL,array('msg'=>'Path directory test non valido','file'=>__FILE__,'line'=>__LINE__)); 
			
	    while ( false !== ($file = readdir($dir_handle)) ) 
	    { 
	        if ( ('_UnitTest_' == substr($file, 0, 10)) && (substr($file, -4)==PHP_EXTENSION) )
	        {
	        	echo $file;
				include ($file);
				echo '<br /><br />';
	        }
	    }

	    closedir($dir_handle); 		
	}
}

?>