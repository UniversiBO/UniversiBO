<?php

include ('UniversiboCommand'.PHP_EXTENSION);

/**
 * Manages Users Logout actions
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class Logout extends UniversiboCommand {
	function execute()
	{
		$fc =& $this->getFrontController();
		
		if ( array_key_exists('f2_submit',$_POST) )
		{
			$this->setSessionIdUtente(0);
		}
		
		return ;

	}
}

?>