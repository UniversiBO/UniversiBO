<?php

class TestTemplate extends BaseCommand {
	function execute(){

		$template =& $this->frontController->getTemplateEngine();
		
		
		//$template->assign('common_pageType', 'popup');
		$template->assign('common_pageType', 'index');

		$template->assign('common_templateBaseDir', 'tpl/black/');
		$template->assign('common_rootUrl', 'https://universibo.ing.unibo.it/');
		$template->assign('common_universibo', 'UniversiBO');
		
		$template->assign('common_veryLongDate', 'Sabato 23 Agosto 2003');
		$template->assign('common_longDate', '23 Agosto 2003');
		$template->assign('common_shortDate', '23/07/2003');
		$template->assign('common_time', '15:53');
		$template->assign('common_metaKeywords', 'universibo, università, facoltà, studenti, bologna, professori, lezioni, materiale didattico, didattica, corsi, studio, studi, novità, appunti, dispense, lucidi, esercizi, esami, temi d\'esame, orari lezione, ingegneria, economia, ateneo');
		$template->assign('common_metaDescription', 'Il portale dedicato agli studenti universitari di Bologna');
		$template->assign('common_alert', 'Il sito è momentaneamente accessibile in sola lettura per attività di manutenzione');


		//mettetelo nel config del template 
		$template->assign('config_docType', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">');
		$template->assign('config_styleSheet', '<link rel="stylesheet" href="tpl/black/style.css" type="text/css">');
		
		
		
		
		$template->assign('common_title', 'Titolo della pagina');
		$template->assign('common_logo', 'Logo UniversiBO');
		$template->assign('common_logoType', 'default'); //estate/natale/8marzo/pasqua/carnevale/svalentino/halloween/ecc...
		$template->assign('common_setHomepage', 'Imposta Homepage');
		$template->assign('common_addBookmarks', 'Aggiungi ai preferiti');


		$template->assign('common_fac', 'Facoltà');
		
		$common_facLinks = array();
		$common_facLinks[] = array ('label'=>'Ingegneria', 'uri'=>'http://www.example.com'); 
		$common_facLinks[] = array ('label'=>'Economia', 'uri'=>'http://www.example.com'); 
		$common_facLinks[] = array ('label'=>'Nome facoltà', 'uri'=>'http://www.example.com'); 
		$common_facLinks[] = array ('label'=>'Altro nome', 'uri'=>'http://www.example.com'); 
		$template->assign('common_facLinks', $common_facLinks);


		$template->assign('common_services', 'Servizi');
	
		$common_servicesLinks = array();
		$common_servicesLinks[] = array ('label'=>'Appunti - Latex', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Biblioteca', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Eventi', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Moderatori', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Grafica', 'uri'=>'http://www.example.com'); 
		$template->assign('common_servicesLinks', $common_servicesLinks);

		$template->assign('common_info', 'Informazioni');

		$template->assign('common_help', 'Help');
		$template->assign('common_helpUri', 'index.php?do=ShowHelp');
		$template->assign('common_rules', 'Regolamento');
		$template->assign('common_rulesUri', 'index.php?do=ShowRules');
		$template->assign('common_contacts', 'Contatti - (chi siamo)');
		$template->assign('common_contactsUri', 'index.php?do=ShowContacts');
		$template->assign('common_contribute', 'Collabora');
		$template->assign('common_contributeUri', 'index.php?do=ShowContribute');


		$template->assign('home_welcome', 'Benvenuto in UniversiBO!');
		$template->assign('home_whatIs', 'Questo è il nuovo portale per la didattica, dedicato agli studenti dell\'università di Bologna.');
		$template->assign('home_mission', 'L\'obiettivo verso cui è tracciata la rotta delle iniziative e dei servizi che trovate su questo portale è di "aiutare gli studenti ad aiutarsi tra loro", fornirgli un punto di riferimento centralizzato in cui prelevare tutte le informazioni didattiche riguardanti i propri corsi di studio e offrire un mezzo di interazione semplice e veloce con i docenti che partecipano all\'iniziativa.');


		$template->display('home.tpl');

	}
}
?>