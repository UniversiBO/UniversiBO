<?php

/**
 * The receiver. Code to activate the framework system
 * 
 * @package framework
 * @version 1.0.0
 * @author  Deepak Dutta, http://www.eocene.net, Ilias Bartolini
 * @copyright UniversiBO 2001-2003
 * @license http://www.opensource.org/licenses/gpl-license.php
*/


/**
* Receiver class for framework activation.
*/
class Receiver{

	var $eocenePath = '../framework';

	var $configFile = '../config.xml';
	
	/**
 	* Set PHP language settings (path, gpc, etc...)
	*/
	
	function _setPhpEnvirorment()
	{
		
		$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', $this->eocenePath.$pathDelimiter.ini_get('include_path'));
		
		error_reporting(E_ALL);
		
		if ( get_magic_quotes_runtime() == 1 )
		{
			 set_magic_quotes_runtime(0);
		} 
		
		define ('PHP_EXTENSION', '.php');
		
	}
	
	/**
 	* Main code for framework activation, instantiates FrontController
	*/
	function main()
	{
		$this->_setPhpEnvirorment();
				
		include_once('FrontController'.PHP_EXTENSION);
		$fc= new FrontController($this->configFile);
		
		//$smarty =& $fc->getTemplateEngine();
		
		//var_dump($smarty);
		
		$fc->executeCommand();

		//modifica brain
		echo $fc->response->content;
		
	}	
	
}

$receiver = new Receiver;
$receiver->main();


?>


