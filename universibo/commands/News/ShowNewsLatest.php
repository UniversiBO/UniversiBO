<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

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
		
		$num_news  =  $param['num'];

		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		$canale    =& $bc->getRequestCanale();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();


		$id_canale = $canale->getIdCanale();
		$titolo_canale =  $canale->getTitolo();
		$ultima_modifica_canale =  $canale->getUltimaModifica();

		$user_ruoli =& $user->getRuoli();

		
		$personalizza   = false;
		$referente      = false;
		$moderatore     = false;
		$ultimo_accesso = time()+100;

		if (array_key_exists($id_canale, $user_ruoli))
		{
			$personalizza = true;
			
			$ruolo =& $user_ruoli[$id_canale];
			
			$referente      = $ruolo->isReferente();
			$moderatore     = $ruolo->isModeratore();
			$ultimo_accesso = $ruolo->getUltimoAccesso();
			
			if ( $referente || $moderatore  || $user->isAdmin() )
			{
				$template->assign('showNewsLatest_addNewsFlag', 'true');
				$template->assign('showNewsLatest_addNews', 'Scrivi una nuova notizia');
				$template->assign('showNewsLatest_addNews', 'AddNews&id_canale='.$id_canale);
			}
			else
			{
				$template->assign('showNewsLatest_addNewsFlag', 'false');
			}
		}
		
		$canale_news = $this->getNumNewsCanale($id_canale);
		


		$template->assign('showNewsLatest_desc', 'Mostra le ultime '.$num_news.' notizie del canale '.$id_canale.' - '.$titolo_canale);

		if ( $canale_news == 0 )
		{
			$template->assign('showNewsLatest_langNewsAwailable', 'Non ci sono notizie in questo canale');
		}
		else
		{
			$template->assign('showNewsLatest_langNewsAwailable', 'Ci sono '.$canale_news.' notizie in questo canale');
			if ( $canale_news > $num_news )
			{
				$template->assign('showNewsLatest_langNewsShowOthers', 'Mostra le altre notizie di questa pagina');
				$template->assign('showNewsLatest_link', 'ShowNewsCanale');
			}
		}
		
		$elenco_news =& $this->getLatestNewsCanale($num_news, $id_canale);
		
		if ($elenco_news ==! false )
		{
			$elenco_news_tpl = array();
			
			$ret_news = count($elenco_news);
			
			for ($i = 0; $i < $ret_news; $i++)
			{
				$news = $elenco_news[$i];
				$this_moderatore = ($moderatore && $news->getIdUtente()==$user->getIdUser());
				
				$elenco_news_tpl[$i]['titolo']       = $news->getTitolo();
				$elenco_news_tpl[$i]['notizia']      = $news->getNotizia();
				$elenco_news_tpl[$i]['data']         = $krono->k_date('%j/%m/%Y', $news->getDataIns());
				$elenco_news_tpl[$i]['nuova']        = ($personalizza==true && $ultimo_accesso<$ultima_modifica_canale) ? 'true' : 'false'; 
				$elenco_news_tpl[$i]['autore']       = $news->getUsername();
				$elenco_news_tpl[$i]['autore_link']  = 'ShowUser&id_utente='.$news->getIdUtente();
				$elenco_news_tpl[$i]['id_autore']    = $news->getIdUtente();
				
				$elenco_news_tpl[$i]['scadenza']     = '';
				if ( ($news->getDataScadenza()!=NULL) && ( $user->isAdmin() || $referente || $this_moderatore ) )
				{
					$elenco_news_tpl[$i]['scadenza'] = 'Scade il '.$krono->k_date('%j/%m/%Y', $news->getDataScadenza() );
				}
				
				$elenco_news_tpl[$i]['modifica']     = '';
				$elenco_news_tpl[$i]['modifica_link']= '';
				$elenco_news_tpl[$i]['elimina']      = '';
				$elenco_news_tpl[$i]['elimina_link'] = '';
				if ( $user->isAdmin() || $referente || $this_moderatore )
				{
					$elenco_news_tpl[$i]['modifica']     = 'Modifica';
					$elenco_news_tpl[$i]['modifica_link']= 'EditNews&id_news='.$news->getIdNotizia();
					$elenco_news_tpl[$i]['elimina']      = 'Elimina';
					$elenco_news_tpl[$i]['elimina_link'] = 'DeleteNews&id_news='.$news->getIdNotizia().'$id_canale='.$id_canale;
				}

			}
		
		}
		
		$template->assign('showNewsLatest_newsList', $elenco_news_tpl);
		
	}
	
	
	/**
	 * Preleva da database le ultime $num notizie non scadute del canale $id_canale
	 *
	 * @static
	 * @param int $num numero notize da prelevare 
	 * @param int $id_canale identificativo su database del canale
	 * @return array elenco NewsItem , false se non ci sono notizie
	 */
	function &getLatestNewsCanale($num, $id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT A.id_news FROM news A, news_canale B 
					WHERE A.id_news = B.id_news AND eliminata!='.$db->quote( NEWS_ELIMINATA ).
					'AND ( data_scadenza IS NULL OR \''.time().'\' < data_scadenza ) AND B.id_canale = '.$db->quote($id_canale).' 
					ORDER BY A.data_inserimento DESC';
		$res =& $db->limitQuery($query, 0 , $num);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
		
		$id_news_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$id_news_list[]= $row[0];
		}
		
		$res->free();
		
		return NewsItem::selectNewsItems($id_news_list);
		
	}
	
	
	/**
	 * Preleva da database il numero di notizie non scadute del canale $id_canale
	 *
	 * @static
	 * @param int $id_canale identificativo su database del canale
	 * @return int numero notizie
	 */
	function getNumNewsCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT count(A.id_news) FROM news A, news_canale B 
					WHERE A.id_news = B.id_news AND eliminata!='.$db->quote(NEWS_ELIMINATA).
					'AND ( data_scadenza IS NULL OR \''.time().'\' < data_scadenza ) AND B.id_canale = '.$db->quote($id_canale).'';
		$res = $db->getOne($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		return $res;
		
	}
	
	
}

?>