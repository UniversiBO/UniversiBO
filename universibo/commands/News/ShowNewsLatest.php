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
		
		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser(); 
		$canale    =& $bc->getRequestCanale();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$this->_db =& $fc->getDbConnection('main');
		$num_news  =  $param['num'];
		
		$id_canale = $canale->getIdCanale();
		$titolo_canale =  $canale->getTitolo();
		
		$num_news = $this->getNumNewsCanale($id_canale);
		if ($num_news == 0 )
		{
			$template->assign('showNewsLatest_langNewsAwailable', 'Non ci sono notizie in questo canale');
		}else{
			$template->assign('showNewsLatest_langNewsAwailable', 'Ci sono '.$num_news.' notizie in questo canale');
		}
		
		$elencoNews =& getLatestNewsCanale($num_news, $id_canale);
		
		$template->assign('showNewsLatest_desc', 'Mostra le ultime '.$num_news.' notizie del canale '.$id_canale.' - '.$titolo_canale);
		
		$template->assign('showNewsLatest_langNoNewsAwailable', 'Non ci sono notizie in questo canale');
		$template->assign('showNewsLatest_langShowAll', 'Mostra tutte le notizie in questo canale');
		
		
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
					ORDER BY A.data_inserimento';
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
		
		return News::selectNewsItems($id_news_list);
		
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