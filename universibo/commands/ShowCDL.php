<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowCDL: mostra un corso di laurea
 * Mostra i collegamenti a tutti i gli esami attivi nel corso di laurea
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Nicola Timoncini <tntimo@despammed.com>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class ShowCDL extends CanaleCommand {

	/** 
	 * Inizializza il comando ShowHome ridefinisce l'initCommand() di CanaleCommand
	 */
	function initCommand(& $frontController) {

		parent :: initCommand($frontController);

		$canale = & $this -> getRequestCanale();
		//var_dump($canale);

		if ($canale -> getTipoCanale() != CANALE_CDL)
			Error :: throw(_ERROR_DEFAULT, array('msg' => 'Il tipo canale richiesto non corrisponde al comando selezionato', 'file' => __FILE__, 'line' => __LINE__));

	}

	function execute() {
		$template = & $this -> frontController -> getTemplateEngine();

		$cdl = & $this -> getRequestCanale();

		require_once('Cdl'.PHP_EXTENSION);

		$template -> assign('cdl_langCDL', 'CORSO DI LAUREA IN ');
		$template -> assign('cdl_cdlTitle', $cdl->getTitoloCDL());
		$template -> assign('cdl_cdlName',  $cdl->getNome());
		$template -> assign('cdl_cdlCategoria', $cdl->getCategoriaCdl());
		$template -> assign('cdl_cdlCodiceFacPadre', $cdl->getCodiceFacoltaPadre());
		$template -> assign('cdl_cdlCodiceCDL', $cdl->getCodiceCDL());
		$template -> assign('cdl_langList', 'Elenco corsi di laurea attivati su UniversiBO');

		$default_anno_accademico = $this->frontController->appSettings['defaultAnnoAccademico'];
		$session_user =& $this->getSessionUser();
		$session_user_groups = $session_user->getGroups();

		$param = array( 'num' => 4 );
		$this->executePlugin('ShowNewsLatest', $param );
		
		return 'default';
	}

}

?>