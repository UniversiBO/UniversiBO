<?php

require_once('User'.PHP_EXTENSION);
require_once('UniversiboCommand'.PHP_EXTENSION);

/**
 *Questa classe consente la visualizzazione e la possibile modifica
 *dei dati di un utente.
 *@author Daniele Tiles
 */

class ShowUser extends UniversiboCommand{

	function execute()
	{
		$frontcontroller 	=& $this->getFrontController();
		$template			=& $frontcontroller->getTemplateEngine();
		$id_user			=  $_GET['id_utente'];
		$current_user		=& $this->getSessionUser();
		$user				=& User::selectUser($id_user);
		if($current_user->isOspite())
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Le schede degli utenti sono visualizzabili solo se si é loggati','file'=>__FILE__,'line'=>__LINE__));
		}
		if(!$user)
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'utente cercato non è valido','file'=>__FILE__,'line'=>__LINE__));
		}
		$arrayRuoli				=& $user->getRuoli();
		$canali = array();
		$keys = array_keys($arrayRuoli);
		foreach ($keys as $key)
			{
				$ruolo =& $arrayRuoli[$key];
				$canale =& Canale::retrieveCanale($ruolo->getIdCanale());
				$Canali = array();
				$Canali['uri']   = $canale->showMe();
				$Canali['tipo']  = $canale->getTipoCanale();
				$Canali['label'] = ($ruolo->getNome() != '') ? $ruolo->getNome() : $canale->getNome();
				$Canali['ruolo'] = ($ruolo->isReferente()) ? 'R' :  (($ruolo->isModeratore()) ? 'M' : 'none');
				$Canali['categoria'] = ($user->getUserGroupsNames());
				$Canali['rimuovi']	= 'index.php?do=MyUniversiBORemove&id_canale='.$ruolo->getIdCanale();
				$Canali['categoria'] = implode($Canali['categoria']);
				$arrayCanali[] = $Canali;
			}
//		usort($arrayCanali, array('UniversiboCommand','_compareMyUniversiBO'));
		$email = $user->getEmail();
		$template->assign('showUserNickname',$user->getUsername());
		$template->assign('showUserEmail',$email);
		$pos = strpos($email,'@');
		$firstPart = substr($email,0,$pos);
		$secondPart = substr($email,$pos+1,strlen($email)-$pos);
		$template->assign('showEmailFirstPart',$firstPart);
		$template->assign('showEmailSecondPart',$secondPart);
		$template->assign('showCanali',$arrayCanali);
		$stessi = false;
		if($current_user->getIdUser() == $id_user)
		{
			$stessi = true;
		}
		$template->assign('showDiritti',$stessi);
		$template->assign('showSettings','index.php?do=ShowSettings');
		return 'default';
	}

}


?>