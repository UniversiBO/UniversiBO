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
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowHelpTopic extends UniversiboCommand {
	function execute(){
		
		
		
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$template -> assign('showHelpTopic_langAltTitle', 'Help');

		$ref_pattern='^([:alnum:]{1,32})$'; //queste info andrebbero in una classe statica help
 		
		$references = array();

		if (!array_key_exists('ref',$_GET) || ereg( $ref_pattern , $_GET['ref'] ) ) 
		{
			$db =& FrontController::getDbConnection('main');
			$query = 'SELECT riferimento FROM help_topic';
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			
			while($res->fetchInto($row))
			{
				$references[] = $row[0];
				$topics[] = $this->executePlugin('ShowTopic', array('reference' => $row[0]));
			}
			$res->free();

			$template->assign('showHelpTopic_index', 'true');
		}
		else
		{
			$topics[] = $this->executePlugin('ShowTopic', array('reference' => $_GET['ref']));

			$template->assign('showHelpTopic_index', 'false');
		}

		
		//$template->assign('showHelpTopic_langReferences', $references);
		$template->assign('showHelpTopic_topics', $topics);
		
		return 'default';
	}
}  
 
 
 
?>