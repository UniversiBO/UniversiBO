<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowHelpTopic is an extension of UniversiboCommand class.
 *
 * It shows Contribute page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowHelpTopic extends UniversiboCommand {
	function execute(){
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$template -> assign('showHelpTopic_langAltTitle', 'Help');

		$db =& FrontController::getDbConnection('main');
		$query = 'SELECT DISTINCT riferimento FROM help_riferimento';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;
		
		$reference	= array();
				
		while($res->fetchInto($row))
		{		
			$reference[] = array('reference' => $row[0]);
			$this->executePlugin('ShowTopic', array('reference' => $row[0]));
		}
		
		$template->assign('showHelpTopic_langReferences', $reference);
				
		return 'default';
	}
}  
 
 
 
?> 