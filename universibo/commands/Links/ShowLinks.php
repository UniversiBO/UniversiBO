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


		$id_canale = $canale->getIdCanale();
//		$titolo_canale =  $canale->getTitolo();
//		$ultima_modifica_canale =  $canale->getUltimaModifica();
//		$user_ruoli =& $user->getRuoli();

//		$personalizza_not_admin = false;

//		$template->assign('showNewsLatest_addNewsFlag', 'false');
//		if (array_key_exists($id_canale, $user_ruoli) || $user->isAdmin())
//		{
//			$personalizza = true;
//			
//			if (array_key_exists($id_canale, $user_ruoli))
//			{
//				$ruolo =& $user_ruoli[$id_canale];
//				
//				$personalizza_not_admin = true;
//				$referente      = $ruolo->isReferente();
//				$moderatore     = $ruolo->isModeratore();
//				$ultimo_accesso = $ruolo->getUltimoAccesso();
//			}
//			
//			if ( $user->isAdmin() || $referente || $moderatore )
//			{
//				$template->assign('showNewsLatest_addNewsFlag', 'true');
//				$template->assign('showNewsLatest_addNews', 'Scrivi nuova notizia');
//				$template->assign('showNewsLatest_addNewsUri', 'index.php?do=NewsAdd&id_canale='.$id_canale);
//			}
//		}
//		else
//		{
//			$personalizza   = false;
//			$referente      = false;
//			$moderatore     = false;
//			$ultimo_accesso = $user->getUltimoLogin();
//		}
//		//var_dump($moderatore);
//		$canale_news = $this->getNumNewsCanale($id_canale);
//
//		$template->assign('showNewsLatest_desc', 'Mostra le ultime '.$num_news.' notizie del canale '.$id_canale.' - '.$titolo_canale);
//
//		if ( $canale_news == 0 )
//		{
//			$template->assign('showNewsLatest_langNewsAvailable', 'Non ci sono notizie in questo canale');
//			$template->assign('showNewsLatest_langNewsAvailableFlag', 'false');
//			$template->assign('showNewsLatest_langNewsShowOthers', '');
//		}
//		else
//		{
//			$template->assign('showNewsLatest_langNewsAvailable', 'Ci sono '.$canale_news.' notizie in questo canale');
//			$template->assign('showNewsLatest_langNewsAvailableFlag', 'true');
//			if ( $canale_news > $num_news )
//			{
//				$template->assign('showNewsLatest_langNewsShowOthers', 'Mostra tutte le news');
//				$template->assign('showNewsLatest_langNewsShowOthersUri', 'index.php?do=NewsShowCanale&id_canale='.$id_canale.'&inizio=0&qta=10');
//			}
//			else
//			{
//				$template->assign('showNewsLatest_langNewsShowOthers', '');
//			}
//		}
//		
//		$elenco_news =& $this->getLatestNewsCanale($num_news, $id_canale);
//		
//		$elenco_news_tpl = array();
//
//		if ($elenco_news ==! false )
//		{
//			
//			$ret_news = count($elenco_news);
//			
//			for ($i = 0; $i < $ret_news; $i++)
//			{
//				$news =& $elenco_news[$i];
//				$this_moderatore = ($user->isAdmin() || ($moderatore && $news->getIdUtente()==$user->getIdUser()));
//				
//				$elenco_news_tpl[$i]['titolo']       = $news->getTitolo();
//				$elenco_news_tpl[$i]['notizia']      = $news->getNotizia();
//				$elenco_news_tpl[$i]['data']         = $krono->k_date('%j/%m/%Y - %H:%i', $news->getDataIns());
//				//echo $personalizza,"-" ,$ultimo_accesso,"-", $news->getUltimaModifica()," -- ";
//				$elenco_news_tpl[$i]['nuova']        = ($personalizza_not_admin==true && $ultimo_accesso < $news->getUltimaModifica()) ? 'true' : 'false'; 
//				$elenco_news_tpl[$i]['autore']       = $news->getUsername();
//				$elenco_news_tpl[$i]['autore_link']  = 'ShowUser&id_utente='.$news->getIdUtente();
//				$elenco_news_tpl[$i]['id_autore']    = $news->getIdUtente();
//				
//				$elenco_news_tpl[$i]['scadenza']     = '';
//				if ( ($news->getDataScadenza()!=NULL) && ( $user->isAdmin() || $referente || $this_moderatore ) )
//				{
//					$elenco_news_tpl[$i]['scadenza'] = 'Scade il '.$krono->k_date('%j/%m/%Y', $news->getDataScadenza() );
//				}
//				
//				$elenco_news_tpl[$i]['modifica']     = '';
//				$elenco_news_tpl[$i]['modifica_link']= '';
//				$elenco_news_tpl[$i]['elimina']      = '';
//				$elenco_news_tpl[$i]['elimina_link'] = '';
//				if ( $user->isAdmin() || $referente || $this_moderatore )
//				{
//					$elenco_news_tpl[$i]['modifica']     = 'Modifica';
//					$elenco_news_tpl[$i]['modifica_link']= 'NewsEdit&id_news='.$news->getIdNotizia().'&id_canale='.$id_canale;
//					$elenco_news_tpl[$i]['elimina']      = 'Elimina';
//					$elenco_news_tpl[$i]['elimina_link'] = 'NewsDelete&id_news='.$news->getIdNotizia().'&id_canale='.$id_canale;
//				}
//
//			}
//		
//		}
		
		$lista_links =& Link::selectCanaleLinks($id_canale);
		 
		$ret_links = count($lista_links);
	
		for ($i = 0; $i < $ret_links; $i++)
		{
			$links =& $lista_links[$i];
			
			$elenco_links_tpl[$i]['uri']       		= $links->getUri();
			$elenco_links_tpl[$i]['label']      	= $links->getLabel();
			$elenco_links_tpl[$i]['description']    = $links->getDescription();

		}

		$template->assign('showLinks_linksList', $elenco_links_tpl);	
		$template->assign('showLinks_linksListAvailable', (count($elenco_links_tpl) > 0));
		
	}
		
}

?>