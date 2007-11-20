<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('mobytSms'.PHP_EXTENSION);


/**
 *
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptTestSms extends UniversiboCommand 
{
	
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $fc->getTemplateEngine();
		$m =& $fc->getSmsMoby();
		$m->setAuthMd5();
		var_dump($m); 	
		echo '**** START REQUEST ****'. "\n";	
		echo 'credito ';  
		var_dump($m->getCredit());
                echo "\n".'sms residuii ';
		var_dump($m->getAvailableSms());
		echo '**** STOP REQUEST ****'. "\n";	
	}	
}

?>
