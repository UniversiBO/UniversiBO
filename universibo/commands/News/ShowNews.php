<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

/**
 * ShowNews è un'implementazione di PluginCommand.
 *
 * Mostra la notizia $id_notizia.
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel paramentro di ingresso del deve essere specificato il numero di notizie da visualizzare.
 *
 * @package universibo
 * @subpackage News
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowNews extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'id_notizia' l'id della notizia da visualizzare
	 *	  es: array('id_notizia'=>5) 
	 */
	function execute($param)
	{
		
		$id_news  =  $param['id_notizia'];

		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();

		$news =& NewsItem::selectNewsItem($id_news);
		$id_canale = $canale->getIdCanale();
		$user_ruoli =& $user->getRuoli();

		
		if (array_key_exists($id_canale, $user_ruoli))
		{
			$personalizza = true;
			
			$ruolo =& $user_ruoli[$id_canale];
			
			$referente      = $ruolo->isReferente();
			$moderatore     = $ruolo->isModeratore();
			$ultimo_accesso = $ruolo->getUltimoAccesso();
			
			if ( $referente || $moderatore  || $user->isAdmin() )
			{
				$template->assign('showNews_addNews', 'Scrivi nuova notizia');
				$template->assign('showNews_addNewsUri', 'index.php?do=AddNews&amp;id_canale='.$id_canale);
			}
		}
		else
		{
			$personalizza   = false;
			$referente      = false;
			$moderatore     = false;
			$ultimo_accesso = time();
		}
		
		//che cosa fa?
		$template->assign('showNews_desc', 'Mostra la notizia '.$id_news);

			
		$elenco_news_tpl['titolo']       = $news->getTitolo();
		$elenco_news_tpl['notizia']      = $news->getNotizia();
		$elenco_news_tpl['data']         = $krono->k_date('%j/%m/%Y', $news->getDataIns());
		//echo $personalizza,"-" ,$ultimo_accesso,"-", $news->getUltimaModifica()," -- ";
		$elenco_news_tpl['nuova']        = ($personalizza==true && $ultimo_accesso < $news->getUltimaModifica()) ? 'true' : 'false'; 
		$elenco_news_tpl['autore']       = $news->getUsername();
		$elenco_news_tpl['autore_link']  = 'ShowUser&amp;id_utente='.$news->getIdUtente();
		$elenco_news_tpl['id_autore']    = $news->getIdUtente();
				
		$elenco_news_tpl['scadenza']     = '';
		if ( ($news->getDataScadenza()!=NULL) && ( $user->isAdmin() || $referente || $this_moderatore ) )
		{
			$elenco_news_tpl[$i]['scadenza'] = 'Scade il '.$krono->k_date('%j/%m/%Y', $news->getDataScadenza() );
		}
			
		$elenco_news_tpl['modifica']     = '';
		$elenco_news_tpl['modifica_link']= '';
		$elenco_news_tpl['elimina']      = '';
		$elenco_news_tpl['elimina_link'] = '';
		if ( $user->isAdmin() || $referente || $this_moderatore )
		{
			$elenco_news_tpl[$i]['modifica']     = 'Modifica';
			$elenco_news_tpl[$i]['modifica_link']= 'EditNews&amp;id_news='.$news->getIdNotizia();
			$elenco_news_tpl[$i]['elimina']      = 'Elimina';
			$elenco_news_tpl[$i]['elimina_link'] = 'DeleteNews&amp;id_news='.$news->getIdNotizia().'&amp;$id_canale='.$id_canale;
		}
		
		$template->assign('showNews_notizia', $elenco_news_tpl);
		
	}
	
	

	
}

?>