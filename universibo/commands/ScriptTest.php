<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Facolta'.PHP_EXTENSION);
require_once ('Cdl'.PHP_EXTENSION);
require_once ('Insegnamento'.PHP_EXTENSION);


/**
 *
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptTest extends UniversiboCommand 
{
	function execute()
	{
		
		
		
		
		
		
		
		
		
		
		
		die();
/*		
		$canale = Canale::retrieveCanale(1573);
		echo $titolo = $canale->getNome(),"\n";
		$tutti = array();
		$db = FrontController::getDbConnection('main');
		
		$query = 'SELECT id_canale FROM canale WHERE id_canale != 432';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		while ($res->fetchInto($row))
		{
			$canale2 = Canale::retrieveCanale($row[0]);
			if ($canale2->getTipoCanale() == CANALE_INSEGNAMENTO && $canale2->isGroupAllowed(USER_OSPITE))
			{
				$titolo2 = $canale2->getNome();
				$tutti[] = array ('dist' => similar_text($titolo, $titolo2), 'titolo' => $titolo2, 'id_canale' => $row[0]);
			}
		}

		usort($tutti, array('ScriptTest','_order'));
		
		$i = 0;
		foreach ($tutti as $value) {
   			echo $i.' - '.$value['dist'],' - '.$value['id_canale'].' : ',$value['titolo'],"<br />";
		}
		//var_dump($tutti);
		
		die();
		
//		echo php_uname();
//		
//		if (substr(php_uname(), 0, 7) == "Windows") {
//			die ("Sorry, this script doesn't run on Windows.\n");
//		}
		
//		$string = 'we?$%\'rwe2432_we.rw35
//		234_34++.ZIP';
//		
//		echo ereg_replace('([^a-zA-Z0-9_\.])','_',$string), "\n";
*/
		
	}
	
	function _order($a, $b)
	{

	   if ($a['dist'] == $b['dist'])
	       return 0;
	   return ($a['dist'] > $b['dist']) ? -1 : 1;

	}
	
}

?>