<?php
/**
 * BaseCommand is the abstract super class of all command classes.
 *
 * @package framework
 * @version 1.1.0
 * @author  Ilias Bartolini
 * @license {@link http://www.opensource.org/licenses/gpl-license.php}
 */
class BaseCommand {
	
	var $frontController;

	function initCommand( &$frontController )
	{
		$this->frontController =& $frontController;
	}
	
	
	function execute(){
		Error::throw(_ERROR_CRITICAL,array('msg'=>'Il metodo execute del command deve essere ridefinito','file'=>__FILE__,'line'=>__LINE__) );
	}
	

}
?>