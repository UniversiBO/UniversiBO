<?php

class ErrorHandlers{

	function critical_handler($param)
	{
		die( 'Errore Critico: '.$param['msg']. '<br />
		file: '.$param['file']. '<br />
		line: '.$param['line']. '<br /><br />');
		//header('Redirect: http://location/error_page.php');
	}
	
	function default_handler($param)
	{
		echo 'Errore: ',$param['msg'], '<br />
		file: ',$param['file'], '<br />
		line: ',$param['line'], '<br /><br />';
		//die();
		//header('Redirect: http://location/error_page.php');
	}

	function notice_handler($param)
	{
		echo 'Notice: ',$param['msg'], '<br />
		file: ',$param['file'], '<br />
		line: ',$param['line'], '<br /><br />';
		//die();
		//header('Redirect: http://location/error_page.php');
	}
	
}
