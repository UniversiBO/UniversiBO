<?php

/**
 * Definisce gli handler da utilizzare per la classe Error, 
 * si è deciso di raggrupparli in questa classe solo per dagli un ordine migliore.
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2003
 * @todo implementare le operazioni sul LogHandler
 */

class ErrorHandlers{

	/**
	 * Handler per errori di categoria ERROR_CRITICAL
	 * Salva l'indicazione dell'errore sul LogHandler, insieme a tutti i parametri della richiesta, 
	 * Mostra sul browser un messaggio di errore e interrompe l'esecuzione 
	 *
	 * @param $param mixed,array() Tipo restituito da chi cattura l'errore, 
	 * questo handler è in grado di gestire un parametro array avente la seguente struttura
	 * $param = array(  "msg"=>"messaggio di errore da mostrare", 
	 * 					"file"=>"file in cui è avvenuto l'errore", 
	 * 					"line"=>"linea di codice in cui è avvenuto l'errore", 
	 * 					"log"=>"(opzionale)se impostato viene salvato come messaggio sul LogHandler" 
	 * 					)
	 */
	function critical_handler($param)
	{
		$param['log']= true;
		die( 'Errore Critico: '.$param['msg']. '<br />
		file: '.$param['file']. '<br />
		line: '.$param['line']. '<br />
		log: '.$param['log']. '<br />');

		//header('Redirect: http://location/error_page.php');
	}
	
	/**
	 * Handler per errori di categoria ERROR_DEFAULT
	 * Salva opzionalmente l'indicazione dell'errore sul LogHandler, insieme a tutti i parametri della richiesta, 
	 * Redirige il browser ad una pagina dell'applicazione in cui viene mostrato il messaggio di errore 
	 *
	 * @param $param mixed,array() Tipo restituito da chi cattura l'errore, 
	 * questo handler è in grado di gestire un parametro array avente la seguente struttura
	 * $param = array(  "msg"=>"messaggio di errore da mostrare", 
	 * 					"file"=>"file in cui è avvenuto l'errore", 
	 * 					"line"=>"linea di codice in cui è avvenuto l'errore", 
	 * 					"log"=>"(opzionale)se impostato viene salvato come messaggio sul LogHandler" 
	 * 					)
	 */
	function default_handler($param)
	{
		$_SESSION['error_param'] = $param;

		FrontController::redirectCommand('ShowError');
		exit(1);
	}

	/**
	 * Handler per errori di categoria ERROR_NOTICE
	 * Appende il messaggio di errore, in una variabile del TemplateEngine.
	 * NON interrompe l'esecuzione.
	 *
	 * @param $param mixed,array() Tipo restituito da chi cattura l'errore, 
	 * questo handler è in grado di gestire un parametro array avente la seguente struttura
	 * $param = array(  "msg"=>"messaggio di errore da mostrare", 
	 * 					"file"=>"file in cui è avvenuto l'errore", 
	 * 					"line"=>"linea di codice in cui è avvenuto l'errore", 
	 * 					"log"=>"(opzionale)se impostato viene salvato come messaggio sul LogHandler",
	 *					"template_engine"=>"Riferimento all'oggetto template engine" 
	 * 					)
	 */
	function notice_handler(&$param)
	{
		
		
		$template =& $param['template_engine'];
		$template->assign('error_notice_present', 'true');
		
		/** ALTERNATIVA ALL'USO DI append()
		$current_error = $template->get_template_vars('error_notice');
		if ($current_error == NULL)
		{
			$current_error = array();
		}
		$current_error[] = $param['msg'];
		$template->assign('error_notice', $current_error);
		*/
		$template->append('error_notice', $param['msg']);

		/**
		echo 'Notice: ',$param['msg'], '<br />
		file: ',$param['file'], '<br />
		line: ',$param['line'], '<br />
		log: ',$param['log'], '<br />
		template engine: ',$param['template_engine'], '<br />';
		*/
	}
	
}

	define('_ERROR_DEFAULT',0);
	define('_ERROR_CRITICAL',1);
	define('_ERROR_NOTICE',2);
		
	Error::setHandler(_ERROR_CRITICAL,array('ErrorHandlers','critical_handler'));
	Error::setHandler(_ERROR_DEFAULT,array('ErrorHandlers','default_handler'));
	Error::setHandler(_ERROR_NOTICE,array('ErrorHandlers','notice_handler'));

