<?php

require_once ('PluginCommand'.PHP_EXTENSION);

/**
 * ShowNewsLatest è un'implementazione di PluginCommand.
 *
 * Mostra le ultime $num notizie del canale.
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel paramentro di ingresso del deve essere specificato il numero di notizie da visualizzare.
 *
 * @package universibo
 * @subpackage News
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowNewsLatest extends PluginCommand {
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'num' il numero di notizie da visualizzare
	 *	  es: array('num'=>5) 
	 */
	function execute($param)
	{

		$bc       =& $this->getBaseCommand();
		$fc       =& $bc->getFrontController();
		$template =& $fc->getTemplateEngine();
		$db       =& $fc->getDbConnection('main');
		$num_news = $param['num'];
		
		$id_canale = $bc->getRequestIdCanale();
		$canale =& $bc->getRequestCanale();
		$titolo = $canale->getTitolo();
		$template->assign('shownewslatest_msg', 'Mostra le ultime '.$num_notizie.' notizie del canale '.$id_canale.' - '.$titolo);

	}
}

?>