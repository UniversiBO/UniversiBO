<?php

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowHome: mostra la homepage
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */


class ShowHome extends CanaleCommand 
{
	
	function execute()
	{
		$template =& $this->frontController->getTemplateEngine();
		
		$template->assign('home_langWelcome', 'Benvenuto in UniversiBO!');
		$template->assign('home_langWhatIs', 'Questo è il nuovo portale per la didattica, dedicato agli studenti dell\'università di Bologna.');
		$template->assign('home_langMission', 'L\'obiettivo verso cui è tracciata la rotta delle iniziative e dei servizi che trovate su questo portale è di "aiutare gli studenti ad aiutarsi tra loro", fornirgli un punto di riferimento centralizzato in cui prelevare tutte le informazioni didattiche riguardanti i propri corsi di studio e offrire un mezzo di interazione semplice e veloce con i docenti che partecipano all\'iniziativa.');
	}

}

?>