<?php

require_once ('PluginCommand'.PHP_EXTENSION);

/**
 * ShowTopic è un'implementazione di PluginCommand.
 *
 * Dato un riferimento mostra gli argomenti di help inerenti
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel parametro di ingresso del plugin deve essere specificato l'id_help da visualizzare.
 *
 * @package universibo
 * @subpackage Help
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowTopic extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'reference' il riferimento degli argomenti da visualizzare
	 *	  es: array('reference'=>'pippo') 
	 */
	function execute($param)
	{
		
		$reference  =  $param['reference'];

		$bc        =& $this->getBaseCommand();
		$frontcontroller =& $bc->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$db =& FrontController::getDbConnection('main');
		$query = 'SELECT id_help FROM help_riferimento he, help h WHERE he.riferimento=\''.$reference.'\' ORDER BY indice';  //un join solo per ordinare secondo l'indice..
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;
		
		$argomenti	= array();
				
		while($res->fetchInto($row))
		{		
			$argomenti[] = $row[0]
			
		}
		
		$this->executePlugin('ShowHelpId', $argomenti);
		$template->assign('showTopic_langArgomento', $argomenti);
		$template->assign('showTopic_langReference', $reference);
	}
	
	
}

?>

