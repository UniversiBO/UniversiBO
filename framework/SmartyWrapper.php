<?
/**
 * Class SmartyWrapper
 * Version 1.0.0
 * Author: pswitek, http://www.eocene.net
 * Unrestricted license, subject to no modifcation to the line above
 * Please include any modification history
 * 16/03/2002 Initial creation
 * SmartyWrapper class is used in Eocene as a Smarty Template Engine Substitute, 
 * instead of default template engine of eocene
 *
 * PUBLIC PROPERTIES
 *	var $fileName		Name of the file including the path
 *  var $fileContents	Entire contents of the file
 * PUBLIC METHODS
 *	setVar(&$varName,&$varValue)		sets variables
 *	setLoop(&$loopName, &$loopData)		sets loops
 *	setBlock(&$aName)					sets blocks
 *	process(&$fileName,&$templateRoot)	process the template. Should be called after setting var, loops, and blocks
 * 										The processed template can be extracted from $fileContents
*/
global $fc;
if (isset($fc->paths['smarty_dir']))
	define('SMARTY_DIR',$fc->paths['smarty_dir'] . '/');
else
	define('SMARTY_DIR', '' ) ;
require_once(SMARTY_DIR.'Smarty.class.php');

class SmartyWrapper extends smarty {

	var $fileName;
	var $fileContents;
	var $loops = array();
	var $blockNames = array();	

	function SmartyWrapper() {
		global $fc ;
		if (isset($fc->paths['templates']))
			$this->template_dir = $fc->paths['templates'];
		if (isset($fc->paths['smarty_compile']))
			$this->compile_dir = $fc->paths['smarty_compile'];
		if (isset($fc->paths['smarty_config']))
			$this->config_dir = $fc->paths['smarty_config'];
		if (isset($fc->paths['smarty_cache']))
			$this->cache_dir = $fc->paths['smarty_cache'];
		Smarty::Smarty() ;
	}

	//Use it to set variables
	function setVar(&$varName, &$varValue){
		$this->assign( &$varName, &$varValue ) ;
	}
	//Loops are not available for smarty
	function setLoop(&$loopName, &$loopData){
		$this->error( 'SmartyWrapper::setLoop is not available for smarty' ) ;
	}
	//Blocks are not available for smarty
	function setBlock(&$aName){
		$this->error( 'SmartyWrapper::setBlock is not available for smarty' ) ;
	}
	//Call this method to process template after everything is set
	//$fileName has full path, $templateRoot is used to resolve includes
	function process(&$fileName,&$templateRoot){
		$this->fileName=$fileName;
		$this->fileContents=&$this->fetch('file:' . $this->fileName);
	}
	/******************************************************************************
	PRIVATE METHODS AND PROPERTIES
	*******************************************************************************/
	function error($msg){
		print $msg;
		exit();
	}
}
?>
