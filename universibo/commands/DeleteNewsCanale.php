<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * DeleteNewsCanale: elimina una notizia, mostra il form e gestisce la cancellazione 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class DeleteNewsCanale extends CanaleCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$user =& $this->getSessionUser();
		$canale =& $this->getCanale();

		if (array_key_exists('f8_submit', $_POST)  )
		{
			
		}



		return 'default';
	}

}

?>