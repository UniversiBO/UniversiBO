<?php

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowHome: mostra la homepage
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */


class ShowHome extends CanaleCommand 
{
	
	/** 
	 * Inizializza il comando ShowHome ridefinisce l'initCommand() di CanaleCommand
	 */
	function initCommand( &$frontController )
	{
		
		parent::initCommand( $frontController );
		
		$canale =& $this->getRequestCanale();
		//var_dump($canale);
		
		if ( $canale->getTipoCanale() != CANALE_HOME )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il tipo canale richiesto non corrisponde al comando selezionato','file'=>__FILE__,'line'=>__LINE__));
		
	}


	function execute()
	{
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$template->assign('home_langWelcome', 'Benvenuto è in UniversiBO!');
		$template->assign('home_langWhatIs', 'Questo è il nuovo portale per la didattica, dedicato agli studenti dell\'università di Bologna.');
		$template->assign('home_langMission', 'L\'obiettivo verso cui è tracciata la rotta delle iniziative e dei servizi che trovate su questo portale è di "aiutare gli studenti ad aiutarsi tra loro", fornire un punto di riferimento centralizzato in cui prelevare tutte le informazioni didattiche riguardanti i propri corsi di studio e offrire un mezzo di interazione semplice e veloce con i docenti che partecipano all\'iniziativa.');

		$this->executePlugin('ShowNewsLatest', array( 'num' => 4 ) );
		
		return 'default';
	}

	function shutdownCommand()
	{
		$this->updateUltimoAccesso();
		parent::shutdownCommand();
	}

}

?>