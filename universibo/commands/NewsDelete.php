<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

/**
 * NewsDelete: elimina una notizia, mostra il form e gestisce la cancellazione 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class NewsDelete extends CanaleCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$user =& $this->getSessionUser();
		$canale =& $this->getRequestCanale();
		
		if (!array_key_exists('id_news', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_news'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id della notizia richiesta non è valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		/* diritti
		 -admin
		 -autore notizia
		 -referenti canale
		*/
		
		$news =& NewsItem::selectNewsItem($_GET['id_news']);
		$id_user = $user->getIdUser();
		$id_user_writer = $news->getIdUtente();
		
		$user_ruoli = $user->getRuoli();
		$id_canale = $canale->getIdCanale();
		if(array_key_exists($id_canale,$user_ruoli))
		{
			$user_ruolo_canale = $user_ruoli[$id_canale];
		}
		 else {Error::throw(_ERROR_DEFAULT,array('msg'=>'Non possiedi i diritti per eliminare la notizia o la sessione potrebbe essere scaduta','file'=>__FILE__,'line'=>__LINE__ ));}
		
		if(!($id_user==$id_user_writer)&&!($user->isAdmin())&&!($user_ruolo_canale->isReferente()))
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Non hai i diritti per eliminare la notizia o la sessione potrebbe essere scaduta','file'=>__FILE__,'line'=>__LINE__ ));
		}
		var_dump($id_user);
		die();
		
		if (array_key_exists('f8_submit', $_POST)  )
		{
			//cancellazione: da tutti i canali?
			return 'success';
		}
		
		//visualizza notizia
		$param = array('id_notizie'=>array($_GET['id_news']) );
		$this->executePlugin('ShowNews', $param );
		
		
		return 'default';
	}

}

?>