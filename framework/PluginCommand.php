<?php
/**
 * PluginCommand is the abstract super class of all plugin command classes.
 *
 * Plugin Commands are sub commands called from a BaseCommand implementation.
 * Usually they are associated to a (sub)template that must be included in 
 * the main template
 *
 * @package framework
 * @version 1.1.0
 * @author  Ilias Bartolini <brain79@virgilio.it>
 * @license {@link http://www.opensource.org/licenses/gpl-license.php}
 */
class PluginCommand {
	
	/**
	 * @private
	 */
	var $baseCommand;

	/**
	 * Sets the link to the caller BaseCommand
	 */ 
	function BaseCommand( &$baseCommand )
	{
		$this->baseCommand =& $baseCommand;
	}
	
	
	/**
	 * Abstract method must be overridden from sons-classes
	 */ 
	function execute()
	{
		Error::throw(_ERROR_CRITICAL,array('msg'=>'Il metodo execute del command deve essere ridefinito','file'=>__FILE__,'line'=>__LINE__) );
	}
	
	
	/**
	 * Return the caller BaseCommand
	 *
	 * @return BaseCommand
	 */ 
	function &getBaseCommand()
	{
		return $this->baseCommand;
	}

}

?>