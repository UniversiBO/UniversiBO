<?php

list($usec, $sec) = explode(" ", microtime());
$page_time_start = ((float)$usec + (float)$sec);


/**
 * The receiver. Code to activate the framework system
 * 
 * @package framework
 * @version 1.0.0
 * @author Deepak Dutta, http://www.eocene.net, 
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Receiver{

	var $frameworkPath = '../framework';
	var $applicationPath = '../universibo';

	var $configFile = '../config.xml';
	
	/**
 	* Set PHP language settings (path, gpc, etc...)
	*/
	function _setPhpEnvirorment()
	{
		
		// attivo la visualizzazione di tutti i warning
		error_reporting(E_ALL); 

		// buffering dell'output.
		//ob_start('ob_gzhandler');

		//inizializzazione della sessione
		session_start();
		if (!array_key_exists('SID',$_SESSION) )
		{
			$_SESSION['SID'] = SID;
		}
		// echo SID,' - ' ,$_SESSION['SID'];
				
		$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', $this->frameworkPath.$pathDelimiter.$this->applicationPath.$pathDelimiter.ini_get('include_path'));
		
		error_reporting(E_ALL);
		
		if ( get_magic_quotes_runtime() == 1 )
		{
			 set_magic_quotes_runtime(0);
		} 
		
		define ('PHP_EXTENSION', '.php');
		
		
	}
	
	
	/**
 	* Main code for framework activation, includes Error definitions
 	* and instantiates FrontController
	*/
	function main()
	{
		$this->_setPhpEnvirorment();
				
		include_once('FrontController'.PHP_EXTENSION);
		$fc= new FrontController($this->configFile);
		
		//$smarty =& $fc->getTemplateEngine();
		
		//var_dump($smarty);
		
		//$response = $fc->executeCommand( $request );
		$fc->executeCommand();
		
		//modifica brain
		//echo $fc->response->content;
		
	}

}

$receiver = new Receiver;
$receiver->main();


list($usec, $sec) = explode(" ", microtime());
$page_time_end = ((float)$usec + (float)$sec);

printf("%01.5f", $page_time_end - $page_time_start);

?>


