<?php
class SessionExample extends BaseCommand{
	function execute(){
		global $fc;
		session_start();
		if(!isset($_SESSION['count'])){
			$_SESSION['count']=1;
		}
		else{
			$_SESSION['count']=$_SESSION['count']+1;
		}

		$r=$fc->receivers['main'];
		$a="<a href='$r/RunSessionExample'>Next Count</a><br>";
		$fc->response->write($a);
		$fc->response->write($_SESSION['count']);
	}
}
?>