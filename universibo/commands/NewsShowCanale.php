<?php    

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

/**
 * NewsAdd: si occupa dell'inserimento di una news in un canale
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class NewsShowCanale extends CanaleCommand {

	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
				
		$user = & $this->getSessionUser();
		$canale = & $this->getRequestCanale();
		$user_ruoli = & $user->getRuoli();
		$id_canale = $canale->getIdCanale();

		if (!array_key_exists('inizio', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['inizio'] ) || !array_key_exists('qta', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['qta'] ))
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Parametri non validi','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		$qta = $_GET['qta'];
		$num_news_canale = getNumNewsCanale($id_canale);
		$num_pagine = ceil($num_news_canale / $qta);
		
		$lista_notizie = & getLatestNewsCanale($_GET['inizio'],$_qta);
		$param = array('id_notizie'=> $lista_notizie, 'chk_diritti' => true);
		$this->executePlugin('ShowNews', $param );
		
		$template->assign('NewsShowCanale_numPagine', $num_pagine);		

		return 'default';

	}
	
	/**
	 * Preleva da database le ultime $num notizie non scadute del canale $id_canale
	 *
	 * @static
	 * @param int $num numero notize da prelevare 
	 * @param int $id_canale identificativo su database del canale
	 * @return array elenco NewsItem , false se non ci sono notizie
	 */
	function &getLatestNewsCanale($startNum, $qta, $id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT A.id_news FROM news A, news_canale B 
					WHERE A.id_news = B.id_news AND eliminata!='.$db->quote( NEWS_ELIMINATA ).
					'AND ( data_scadenza IS NULL OR \''.time().'\' < data_scadenza ) AND B.id_canale = '.$db->quote($id_canale).' 
					ORDER BY A.data_inserimento DESC';
		$res =& $db->limitQuery($query, $startNum , $qta);
		
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