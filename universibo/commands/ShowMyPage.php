<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('News/ShowNewsLatest'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);
require_once  ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowMyPage is an extension of UniversiboCommand class.
 *
 * Mostra la MyPage dell'utente loggato, con le ultime 5 notizie e 
 * gli ultimi 5 files presenti nei canali da lui aggiunti...
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles 
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowMyPage extends UniversiboCommand 
{
	function execute()
	{
		
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$utente =& $this->getSessionUser();
		
		//procedure per ricavare e mostrare le ultime 5 notizie dei canali a cui si é iscritto...
		
		if(!$utente->isOspite())
		{
			$arrayNewsItems = array();
			$arrayCanaliFiles = array();
			$arrayCanali = array();
			$arrayRuoli =& $utente->getRuoli();
			$keys = array_keys($arrayRuoli);
			foreach ($keys as $key)
			{
				$ruolo =& $arrayRuoli[$key];
				if ($ruolo->isMyUniversibo())
				{
								
					$canale =& Canale::retrieveCanale($ruolo->getIdCanale());
					$arrayCanali[] = $canale;
				}
			}
			///ho ottenuto tutti i canali a cui é iscritto l'utente
			$keys = array_keys($arrayCanali);
			$num_news = 0;
			$num_files = 0;
			
			//variabili di prova
			
			$canali_senza_servizio_news = 0;
			$canali_senza_servizio_files = 0;
			
			foreach ($keys as $key)
			{
				$canale =& $arrayCanali[$key];					
				if ($canale->getServizioNews())
				{
					$id_canale = $canale->getIdCanale();
					$canale_news = ShowNewsLatest::getNumNewsCanale($id_canale);
					$arrayNewsItems[] = ShowNewsLatest::getNumNewsCanale($canale_news,$id_canale);
					$num_news = $num_news + $canale_news;
				}
				else{$canali_senza_servizio_news++;  }
				
				if ($canale->getServizioFiles())
				{
					$id_canale = $canale->getIdCanale();
					$canale_files = $this->getNumFilesCanale($id_canale);
					$arrayCanaliFiles[$key] = $id_canale;
					$num_files = $num_files + $canale_files;
				}
				else{$canali_senza_servizio_files++;}
			
			}
			
			$arrayFilesItems = $this->getLatestFileCanale(2,$arrayCanaliFiles[]);
			$keys = array_keys($arrayFilesItems);
			foreach ($keys as $key)
			{
				var_dump($key);
				echo('---');
				var_dump($arrayFilesItems[$key]);
				//todo: mettere in ordine le notizie
			}
		}
		else
		{
			Error :: throw(_ERROR_DEFAULT, array('msg' => 'Non esiste una MyPage per utenti ospite. Puo\' essere che sia scaduta la tua sessione.', 'file' => __FILE__, 'line' => __LINE__));
		}
		
		
	}
	
	/**
	 * Preleva da database il numero di files del canale $id_canale
	 *
	 * @static
	 * @param int $id_canale identificativo su database del canale
	 * @return int $res numero files
	 */
	 
	function getNumFilesCanale($id_canale)
	{
		$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT count(A.id_file) FROM file A, file_canale B 
					WHERE A.id_file = B.id_file AND eliminato!='.$db->quote(FILE_ELIMINATO).
					'AND B.id_canale = '.$db->quote($id_canale).'';
		$res = $db->getOne($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		return $res;
	}
	
	/**
	 * Preleva da database gli ultimi $num files del canale $id_canale
	 *
	 * @static
	 * @param int $num numero files da prelevare 
	 * @param int $id_canale identificativo su database del canale
	 * @return array elenco FileItem , false se non ci sono notizie
	 */
	
	function &getLatestFileCanale($num, $id_canali = array())
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		$query = 'SELECT A.id_file FROM file A, file_canale B 
					WHERE A.id_file = B.id_file AND eliminato!='.$db->quote( FILE_ELIMINATO ).
					'AND B.id_canale IN ('.$db->quote($id_canali[0]).','.$db->quote($id_canali[1]).')
					ORDER BY A.data_inserimento DESC';
		$res =& $db->limitQuery($query, 0 , $num);
		var_dump($res);
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
		
		return FileItem::selectFileItems($id_news_list);
		
	}
	
	
}

?>