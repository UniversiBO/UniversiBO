<?php

class TestTemplate extends BaseCommand {
	function execute(){

		$template =& $this->frontController->getTemplateEngine();
		
		
		//$template->assign('common_pageType', 'popup');
		$template->assign('common_pageType', 'index');

		$template->assign('common_longDate', '23 Agosto 2003');
		$template->assign('common_shortDate', '23/07/2003');
		$template->assign('common_time', '15:53');
		$template->assign('common_URL', 'https://universibo.ing.unibo.it/');



		//$smarty->assign('common_pageType', 'index');



		//mettetelo nela config $smarty->assign('header_docType', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">');

		$template->assign('header_title', 'Titolo della pagina');
		$template->assign('header_logo', array('tipo'=>'estate/dafault/natale/ecc...', 'alt'=>'logo UniversiBO'));
		$template->assign('header_setHomepage', 'Imposta Homepage');
		$template->assign('header_addFavorites', 'Aggiungi ai preferiti');


		$template->display('home.tpl');

	}
}
?>