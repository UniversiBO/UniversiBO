<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);


/**
 *
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptTest extends UniversiboCommand 
{
	function execute()
	{

		$string = 'we£$%\'rwe2432_we.rw35
		234_34++.ZIP';
		
		echo ereg_replace('([^a-zA-Z0-9_\.])','_',$string), "\n";
		
	}
}

?>