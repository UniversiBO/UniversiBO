<?php

require_once ('PluginCommand'.PHP_EXTENSION);

/**
 * ShowHelpId è un'implementazione di PluginCommand.
 *
 * Mostra la spiegazione dell'argomento n° $id_help
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel parametro di ingresso del plugin deve essere specificato l'id_help da visualizzare.
 *
 * @package universibo
 * @subpackage Help
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowHelpId extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'id_help' l'id dell'argomento da visualizzare
	 *	  es: array('id_help'=>5) 
	 *	se id_help=0 mostra tutti gli argomenti	
	 */
	function execute($param)
	{
		
		$id_help  =  $param['id_help'];

		$bc        =& $this->getBaseCommand();
		$frontcontroller =& $bc->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$db =& FrontController::getDbConnection('main');
		if ($id_help === 0)
			$query = 'SELECT id_help, titolo, contenuto FROM help ORDER BY indice';
		else 
			$query = 'SELECT id_help, titolo, contenuto FROM help WHERE id_help=\''.$id_help.'\'';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;
		
		$argomenti	= array();
				
		while($res->fetchInto($row))
		{		
			$argomenti[] = array('id' => $row[0], 'titolo' => $row[1], 'contenuto' => $row[2]);
		}
		
		$template->assign('showHelpId_langArgomento', $argomenti);
		
	}
	
	

	
}

?>