<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * NewsAdd: si occupa dell'inserimento di una news in un canale
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class NewsAdd extends CanaleCommand {

	function execute() 
	{
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
				
		$this->executePlugin( 'PlAddNews', NULL );
		
		return 'default';
	}

}

?>