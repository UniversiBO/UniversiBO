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
			$arrayNewsItems[] = array();
			$arrayFilesItems[] = array();
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
				else{echo('stupido!');}
				
				if ($canale->getServizioFiles())
				{
					$id_canale = $canale->getIdCanale();
					$canale_files = $this->getNumFilesCanale($id_canale);
					$arrayFileItems = $this->getLatestFileCanale($canale_files,$id_canale);
					var_dump($num_files);
					$num_files = $num_files + $canale_files;
				}
				else{echo('stupidi files');}
			
			}
			
//			var_dump($num_files);
//			var_dump($canale_files);
						
			//Allora...stranamente mi segna tutti i canali di cui dispongo
			//Senza servizio news...mentre esiste un unico canale
			//con servizio files,ed é Scrittura Contenuti...
			//A quanto sembra, $num_files é visto come un intero, mentre
			//$canale_files come una stringa...anche se non penso sia
			//questo l'errore...
			
			
			$keys = array_keys($arrayNewsItems);
			foreach ($keys as $key)
			{
				//todo: mettere in ordine le notizie
			}
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
	
	function &getLatestFileCanale($num, $id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT A.id_file FROM file A, file_canale B 
					WHERE A.id_file = B.id_file AND eliminato!='.$db->quote( FILE_ELIMINATO ).
					'AND B.id_canale = '.$db->quote($id_canale).' 
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
		
		return FileItem::selectFileItems($id_news_list);
		
	}
	
	
}

?>