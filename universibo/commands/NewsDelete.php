<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * NewsDelete: elimina una notizia, mostra il form e gestisce la cancellazione 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class NewsDelete extends CanaleCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$user =& $this->getSessionUser();
		$canale =& $this->getRequestCanale();
		
		if (!array_key_exists('id_news', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_news'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id della notizia richiesta non è valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		//diritti
		
		
		if (array_key_exists('f8_submit', $_POST)  )
		{
			//cancellazione
			return 'success';
		}
		
		//visualizza notizia
		$param = array('id_notizie'=>array($_GET['id_news']) );
		$this->executePlugin('ShowNews', $param );
		
		
		return 'default';
	}

}

?>