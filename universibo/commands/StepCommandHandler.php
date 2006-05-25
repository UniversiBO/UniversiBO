<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once('StepCommand/BaseStepCommand'.PHP_EXTENSION);

/**
 * StepCommandHandler is an extension of UniversiboCommand class.
 *
 * Manages Step interactions after login request by user
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto <evaimitico@gmail.com>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class StepCommandHandler extends UniversiboCommand {
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $this->frontController->getTemplateEngine();
//		$user =& $this->getSessionUser();
		
		//se esiste user in $_SESSION o siamo giunti dal login, o siamo nel bel mezzo di una interazione a step. 
		// VERIFY decidere se lanciare un errore o meno
		if(!isset($_SESSION['user'])) FrontController::redirectCommand();
		$userLogin = unserialize($_SESSION['user']);

		$referer = (array_key_exists('referer',$_SESSION)) ? $_SESSION['referer'] :	((array_key_exists('HTTP_REFERER',$_SERVER))? $_SERVER['HTTP_REFERER'] : '');
		$_SESSION['referer'] = ($referer != '') ? $referer : $fc->getReceiverUrl($fc->getReceiverId()); // VERIFY meglio in homepage o in myuniversibo se loggato?

		$activeSteps = (array_key_exists('activeSteps', $_SESSION)) ? $_SESSION['activeSteps'] : $this->getActiveStepCommand();
				
		if (count($activeSteps) == 0) 
		{	
			// completo il login dell'utente
			$_SESSION = array();
			session_destroy();
			session_start();
			$userLogin->updateUltimoLogin(time());
			$this->setSessionIdUtente($userLogin->getIdUser());
			$fc->setStyle($userLogin->getDefaultStyle());
			
			require_once ('ForumApi'.PHP_EXTENSION);
			$forum = new ForumApi();
			$forum->login($userLogin);
			
			if ( !strstr($referer, 'forum') && ( !strstr($referer, 'do') || strstr($referer, 'do=ShowHome')  || strstr($referer, 'do=ShowError') || strstr($referer, 'do=Login') || strstr($referer, 'do=RegStudente')))
				FrontController::redirectCommand('ShowMyUniversiBO');
			else if (strstr($referer, 'forum'))
				FrontController::goTo($forum->getMainUri());
			else
				FrontController::goTo($referer);
		}
		
		
		$action = null;
		$action = (array_key_exists('action',$_GET) && in_array($_GET['action'], array(CANC_ACTION, BACK_ACTION))) ? $_GET['action'] : $action;
		if (isset($_POST['action'])) $action = NEXT_ACTION; 
		
		$currentStep = current($activeSteps);		
		$esito = $this->executePlugin($currentStep, $action);
		
		//TODO verificare se esito è array?
		if (isset($esito['error'])) 
		{			
			/** 
			 * @todo mail agli sviluppatori per correggere subito l'errore, altrimenti la gente non si logga più!!
			 * per il futuro, pensare a come disabilitare in automatico gli stepcommand con errore
			 */			
			require_once('Notifica/NotificaItem'.PHP_EXTENSION);
			$notifica_titolo_long = 'WARNING: lo stepCommand '.$currentStep.' e\' errato';
			$notifica_titolo = substr($notifica_titolo_long, 0 , 199);
			$notifica_dataIns = time();
			$notifica_urgente = false; // TODO settare come urgente
			$notifica_eliminata = false;
			$notifica_messaggio = 
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
'.$notifica_titolo_long.'

Probabilmente lo stepCommand '.$currentStep.' non ha metodi implementati.
Risolvere subito il problema o disabilitarlo quanto prima,
perché impedisce il login agli utenti		
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~';
					
			$notifica_destinatario = 'mail://'.$frontcontroller->getAppSetting('develEmail');
			
			$notifica = new NotificaItem(0, $notifica_titolo, $notifica_messaggio, $notifica_dataIns, $notifica_urgente, $notifica_eliminata, $notifica_destinatario );
			$notifica->insertNotificaItem();
			
			$this->updateActiveSteps($activeSteps);
		}
//		var_dump($esito);
		if ($action == CANC_ACTION && $esito['priority'] == HIGH_INTERACTION && $esito['cancelled'])
		{			
			$_SESSION = array();
			session_destroy();
			session_start();
			// TODO messaggio di errore per spiegare che è obbligatorio accettare?
			FrontController::goTo($referer);
		}	
		
		//  Elimino dalla lista gli step cancellati dall'utente e quelli completati con successo
		if ($esito['complete'] || ($action == CANC_ACTION && $esito['priority'] != HIGH_INTERACTION))
			$this->updateActiveSteps($activeSteps);	
			
		$callbackName = $esito['stepName'];
		
		$template->assign('StepCommandHandler_stepPath', 'StepCommand/' . $activeSteps[0] .'/'. $callbackName .'.tpl' );  //stepPath. estensione  e path hardcoded
		$template->assign('StepCommandHandler_title_lang', $esito['title'] );  // TODO dare un title ad ogni StepCommand?
		$template->assign('StepCommandHandler_back_uri', 'index.php?do='.$fc->getCommandRequest().'&action='.BACK_ACTION );
		$template->assign('StepCommandHandler_back_lang', $esito['navigation']['back']);
		$template->assign('StepCommandHandler_canc_uri', 'index.php?do='.$fc->getCommandRequest().'&action='.CANC_ACTION);
		$template->assign('StepCommandHandler_canc_lang', $esito['navigation']['canc']);
		$template->assign('StepCommandHandler_next_lang', $esito['navigation']['next'] );
	}
	
	/**
	 * @author Pinto
	 * @access private
	 */
	function updateActiveSteps(&$activeSteps)
	{
		unset($activeSteps[key($activeSteps)]);
		$_SESSION['activeSteps'] = $activeSteps;
		FrontController::redirectCommand('StepCommandHandler');
	}
	
	/**
	 * @author Pinto
	 * @access private
	 * @return array list of available stepCommand
	 */
	function getAllStepCommand () 
	{
		$list = $this->frontController->getAvailablePlugins();
//		var_dump($list);
		$steps = array();
		foreach ($list as $item)
		{
			include_once('StepCommand/' . $item . PHP_EXTENSION);
			if (in_array('BaseStepCommand', $this->get_all_ancerstors_of_class($item))) $steps[] = $item;
//			var_dump($item);
//			var_dump(get_parent_class($item)); die;
		}
//		var_dump($steps); die;
		return $steps;
	}
	
	/**
	 * @author Pinto
	 * @access private
	 * @return array list of ancestor (almeno quelli che riesce a trovare)
	 */
	function get_all_ancerstors_of_class ($class) {
		$list = array();
//		$ancestor = get_parent_class($class);
//		while ($ancestor != null && $ancestor != 'stdClass' )
//		{
//			$list[] 	= $ancestor;
//			$ancestor 	= get_parent_class($ancestor);
//		}
		// versione alternativa migliore. PS servira' il controllo != da stdClass?
		$parentClass = $class;
		while(is_string($parentClass = get_parent_class($parentClass)) && $parentClass != 'stdClass') {
            $list[] = $parentClass;
        }
		// TODO se il while si interrompe per il null, vuol dire che la lista è parziale. Gestirlo in modo diverso?
		return $list;
		
				
		
	}
	
	
	/**
	 * @author Pinto
	 * @access private
	 * @return array list of active stepCommand
	 */
	function getActiveStepCommand () 
	{
		// TODO: migliorare il confronto
		$allSteps 	= $this->getAllStepCommand();
		$stepsDone 	= $this->getCompletedStepCommandByUser();
//		var_dump($allSteps);
//		var_dump($stepsDone);
		return array_diff($allSteps, $stepsDone);
	}
	
	/**
	 * @author Pinto
	 * @access private
	 * @return mixed array with the list of stepCommand already completed by current user, false if empty
	 */
	function getCompletedStepCommandByUser() 
	{
		$db =& FrontController::getDbConnection('main');
		$user =&  unserialize($_SESSION['user']);
		
		$query = 'SELECT id_step, nome_classe FROM  	step_log 
					WHERE id_utente = '.$db->quote( $user->getIdUser() ).
					' AND  esito_positivo IS NOT NULL '.		// NB suppongo che quelli con esito 'n' siano quelli una-tantum (bassa priorità) rifiutati 
					'';					
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		
		if( $rows = 0) return array();
				
		$list = array();	
		while ( $res->fetchInto($row) )
		{
			$list[$row[0]]= $row[1];
		}		
		$res->free();
				
		return $list;
	}	
}

?>
