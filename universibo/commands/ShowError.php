<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowError: mostra una pagina con la descrizione dell'errore per gli ErrorDefault
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @todo implementare il log degli errori tramite il LogHandler.
 */


class ShowError extends UniversiboCommand 
{
	
	function execute()
	{
		$template =& $this->frontController->getTemplateEngine();
		
		//if (!array_key_exists('error_param', $_SESSION))
		//	Error::throw(_ERROR_CRITICAL,array('msg'=>'Chiamata illegale del comando di errore','log'=>true,'file'=>__FILE__,'line'=>__LINE__));
		
		$param = $_SESSION['error_param'];
		
		//inserire il log dell'errore tramite il LogHandler		
		
		$template->assign('error_default', $param['msg']);
		
		return 'default';
	}

}

?>
