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
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));

		$session_user =& $this->getSessionUser();
		$info_didattica = 
		
		$id_canale = $this->getRequestIdCanale();
		$insegnamento =& $this->getRequestCanale();
		
		$session_user_groups = $session_user->getGroups();
		$insegnamento->getTitolo();
		//var_dump($insegnamento);
		
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		
		
		$info_didattica = InfoDidattica::retrieveInfoDidattica($id_canale);
		//var_dump($info_didattica);
		
		
		$template->assign('ins_langHomepageAlternativa','Homepage alternativa');
		
		
		if ($info_didattica->getObiettiviEsameLink() == '' && $info_didattica->getObiettiviEsame() == '' )
			$obiettivi = 'Obiettivi del corso';
		elseif ($info_didattica->getObiettiviEsameLink() != '' && $info_didattica->getObiettiviEsame() == '' )
			$obiettivi = '[url="'.$info_didattica->getObiettiviEsameLink().'"]Obiettivi del corso[/url]';
		else
			$obiettivi = '[url="index.php?do=ShowInfoDidattica&id_canale='.$id_canale.'#obiettivi"]Obiettivi del corso[/url]';
		
		if ($info_didattica->getProgrammaLink() == '' && $info_didattica->getProgramma() == '' )
			$programma = 'Programma d\'esame';
		elseif ($info_didattica->getProgrammaLink() != '' && $info_didattica->getProgramma() == '' )
			$programma = '[url="'.$info_didattica->getProgrammaLink().'"]Programma d\'esame[/url]';
		else
			$programma = '[url="index.php?do=ShowInfoDidattica&id_canale='.$id_canale.'#programma"]Programma d\'esame[/url]';
		
		if ($info_didattica->getTestiConsigliatiLink() == '' && $info_didattica->getTestiConsigliati() == '' )
		{
			$materiale = 'Materiale didattico e 
testi consigliati';
		}
		elseif ($info_didattica->getTestiConsigliatiLink() != '' && $info_didattica->getTestiConsigliati() == '' )
			$materiale = '[url='.$info_didattica->getTestiConsigliatiLink().']Materiale didattico e 
testi consigliati[/url]';
		else
			$materiale = '[url=index.php?do=ShowInfoDidattica&id_canale='.$id_canale.'#modalita]Materiale didattico e 
testi consigliati[/url]';
			'';

		if ($info_didattica->getModalitaLink() == '' && $info_didattica->getModalita() == '' )
			$modalita = 'Modalità d\'esame';
		elseif ($info_didattica->getModalitaLink() != '' && $info_didattica->getModalita() == '' )
			$modalita = '[url="'.$info_didattica->getModalitaLink().'"]Modalità d\'esame[/url]';
		else
			$modalita = '[url="index.php?do=ShowInfoDidattica&id_canale='.$id_canale.'#modalita"]Modalità d\'esame[/url]';
		
		
		if ($info_didattica->getAppelliLink() == '' && $info_didattica->getAppelli() == '' )
			$appelli = 'Appelli d\'esame';
		elseif ($info_didattica->getAppelliLink() != '' && $info_didattica->getAppelli() == '' )
			$appelli = '[url="'.$info_didattica->getAppelliLink().'"]Appelli d\'esame[/url]';
		else
			$appelli = '[url="index.php?do=ShowInfoDidattica&id_canale='.$id_canale.'#appelli"]Appelli d\'esame[/url]';
		
		$orario = '[url=""]Orario delle lezioni[/url]';
		
		$forum = '[url=""]Forum[/url]';
		
		$tpl_tabella[] = $obiettivi;
		$tpl_tabella[] = $programma;
		$tpl_tabella[] = $materiale;
		$tpl_tabella[] = $modalita;
		$tpl_tabella[] = $appelli;
		$tpl_tabella[] = $orario;
		$tpl_tabella[] = $forum;
		
		$template->assign('ins_tabella', $tpl_tabella );
		
		$template->assign('ins_title', $insegnamento->getTitolo() );
		

		$this->executePlugin('ShowNewsLatest', array( 'num' => 5  ));
		$this->executePlugin('ShowFileTitoli', array());
		return 'default';
	}

}

?>