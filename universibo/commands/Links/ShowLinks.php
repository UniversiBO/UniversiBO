<?php


require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('Links/Link'.PHP_EXTENSION);

/**
 * ShowLinks è un'implementazione di PluginCommand.
 *
 * Mostra i link 
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel parametro di ingresso del deve essere specificato il numero di notizie da visualizzare.
 *
 * @package universibo
 * @subpackage Links
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowLinks extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'num' il numero di link da visualizzare
	 *	  es: array('num'=>5) 
	 */
	function execute($param)
	{
		
		$num_news  =  $param['num'];

		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		$canale    =& $bc->getRequestCanale();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$user_ruoli =& $user->getRuoli();
		

		$id_canale = $canale->getIdCanale();
		$ultima_modifica_canale =  $canale->getUltimaModifica();

		$template->assign('showLinks_adminLinksFlag', 'false');
		if (array_key_exists($id_canale, $user_ruoli) || $user->isAdmin())
		{
			$personalizza = true;
			
			if (array_key_exists($id_canale, $user_ruoli))
			{
				$ruolo =& $user_ruoli[$id_canale];
				
				$referente      = $ruolo->isReferente();
				$moderatore     = $ruolo->isModeratore();
				$ultimo_accesso = $ruolo->getUltimoAccesso();
			}
		
		}
		else
		{
			$personalizza   = false;
			$referente      = false;
			$moderatore     = false;
			$ultimo_accesso = $user->getUltimoLogin();
		}
	
		$lista_links =& Link::selectCanaleLinks($id_canale);
		 
		$ret_links = count($lista_links);
		$elenco_links_tpl = array();
	
		for ($i = 0; $i < $ret_links; $i++)
		{
			$links =& $lista_links[$i];
			
			$elenco_links_tpl[$i]['uri']       		= $links->getUri();
			$elenco_links_tpl[$i]['label']      	= $links->getLabel();
			$elenco_links_tpl[$i]['description']    = $links->getDescription();

		}

		$template->assign('showLinks_linksList', $elenco_links_tpl);	
		$template->assign('showLinks_linksListAvailable', ((count($elenco_links_tpl) > 0) || $personalizza));
		$template->assign('showLinks_linksAdminUri', 'LinksAdminSearch&id_canale='.$id_canale);
		$template->assign('showLinks_linksAdminLabel', 'Gestione links');
		$template->assign('showLinks_linksPersonalizza', ($personalizza) ? 'true' : 'false');
	}
		
}

?>