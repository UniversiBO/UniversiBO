<?php 
require_once('UniversiboCommand'.PHP_EXTENSION);
class ShowStatistiche extends UniversiboCommand {
		function execute() {
		
			$db =& FrontController::getDbConnection('main');
			$query = 'SELECT * FROM statistiche_esami';
//			var_dump($query); die;
			$res = $db->query($query);
			if (DB::isError($res)) 
			Error::throwError(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->numRows();
			if( $rows == 0) return false;
			elseif( $rows == 1) return true;
			else Error::throwError(_ERROR_CRITICAL,array('msg'=>'Errore generale database','file'=>__FILE__,'line'=>__LINE__));
			var_dump($res); die;
			return false;
		}
}
?>