<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('InfoDidattica'.PHP_EXTENSION);

/**
 * ShowCdl: mostra un corso di laurea
 * Mostra i collegamenti a tutti gli insegnamenti attivi nel corso di laurea
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class ShowInfoDidattica extends UniversiboCommand 
{

	function execute() 
	{
		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();

		$krono = & $frontcontroller->getKrono();
		$user = & $this->getSessionUser();
		$user_ruoli = & $user->getRuoli();
			
		if (!array_key_exists('id_canale', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_canale']))
			Error::throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		
		$session_user =& $this->getSessionUser();
		
		$info_didattica = InfoDidattica::retrieveInfoDidattica($id_canale);
		$insegnamento = Canale::retrieveCanale($insegnamento);
		//var_dump($info_didattica);
		
		$obiettivi = 'Obiettivi del corso';
		$obiettiviLink = $info_didattica->getObiettiviEsameLink();
		$obiettiviInfo = $info_didattica->getObiettiviEsame();
		
		$programma = 'Programma d\'esame';
		$programmaLink = $info_didattica->getProgrammaLink();
		$programmaInfo = $info_didattica->getProgramma();
		
		$materiale = 'Materiale didattico e testi consigliati';
		$materialeLink = $info_didattica->getTestiConsigliatiLink();
		$materialeInfo = $info_didattica->getTestiConsigliati();
		
		$modalita = 'Modalità d\'esame';
		$modalitaLink = $info_didattica->getModalitaLink();
		$modalitaInfo = '[url="index.php?do=ShowInfoDidattica&id_canale='.$id_canale.'#modalita"]Modalità d\'esame[/url]';
		
		$appelli = 'Appelli d\'esame';
		$appelliLink = $info_didattica->getAppelliLink();
		$appelliInfo = $info_didattica->getAppelli();
		
		$template->assign('infoDid_title', $insegnamento->getTitolo() );
		
		$template->assign('infoDid_obiettivi', $obiettivi );
		$template->assign('infoDid_obiettiviLink', $obiettiviLink );
		$template->assign('infoDid_obiettiviInfo', $obiettiviInfo );
		$template->assign('infoDid_programma', $programma );
		$template->assign('infoDid_programmaLink', $programmaLink );
		$template->assign('infoDid_programmaInfo', $programmaInfo );
		$template->assign('infoDid_materiale', $materiale );
		$template->assign('infoDid_materialeLink', $materialeLink );
		$template->assign('infoDid_materialeInfo', $materialeInfo );
		$template->assign('infoDid_modalita', $modalita );
		$template->assign('infoDid_modalitaLink', $modalitaLink );
		$template->assign('infoDid_modalitaInfo', $modalitaInfo );
		$template->assign('infoDid_appelli', $appelli );
		$template->assign('infoDid_appelliLink', $appelliLink );
		$template->assign('infoDid_appelliInfo', $appelliInfo );
		
		$this->executePlugin('ShowNewsLatest', array( 'num' => 5  ));
		$this->executePlugin('ShowFileTitoli', array());
		return 'default';
	}

}

?>