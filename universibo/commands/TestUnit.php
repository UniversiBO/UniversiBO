<?php

include ('UniversiboCommand'.PHP_EXTENSION);

class TestUnit extends UniversiboCommand {
	function execute()
	{
		$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', '../tests'.$pathDelimiter.ini_get('include_path'));

		include ('_UnitTest_StringEsempioUsoPhpUnit'.PHP_EXTENSION);
		echo '<br /><br />';


	}
}

?>