<?php 

require_once ('Notifica/NotificaItem'.PHP_EXTENSION);

class NotificaMail extends NotificaItem {
	
	
	
	function NotificaMail ($notifica,$fc=null) {
		//$id_notifica, $titolo, $messaggio, $dataIns, $urgente, $eliminata, $destinatario
		$this->notifica = $notifica->notifica ;
		$this->titolo = $notifica->titolo ;
		$this->messaggio = $notifica->messaggio ;
		$this->timestamp = $notifica->timestamp ;
		$this->urgente = $notifica->urgente ;
		$this->eliminata = $notifica->eliminata ;
		$this->destinatario = $notifica->destinatario ;
		$this->fc =& $fc ;
	}
	
	/**
	* Overwrite the Send (abstract) function of the base class
	* 
	* @return string "success" or "failed"
	*/
	function Send() {
		$fc =& $this->getFrontController();
		$mail =& $fc->getMail();
		
		$mail->AddAddress($this->getDestinatario());

		$mail->Subject =$this->getTitolo();
		$mail->Body = $this->getMessaggio();

		//$msg = "messaggio in caso di fallimento";
		if (!$mail->Send())
			Error :: throw (_ERROR_DEFAULT, array ('msg' => $msg, 'file' => __FILE__, 'line' => __LINE__));

		//$template->assign('regStudente_thanks', "Benvenuto \"".$new_user->getUsername()."\"!!\n \nL'iscrizione è stata registrata con successo.\nLe informazioni per permetterti l'accesso ai servizi offerti dal portale sono state inviate al tuo indirizzo e-mail di ateneo\n".'Per qualsiasi problema o spiegazioni contatta lo staff all\'indirizzo [email]'.$fc->getAppSetting('infoEmail').'[/email].');

		//elimino la password
		//$randomPassword = '';
		$mail->Body = '';
		//$msg = '';

	}

	function &factoryNotifica($id_notifica,$fc)	{
		return new NotificaMail($id_notifica,$fc);
		//$notif=NotificaMail::selectNotifica($id_notifica);
		//$notifMail=new NotificaMail($notif,$fc);
		//return $notifMail;
	}
}
?>