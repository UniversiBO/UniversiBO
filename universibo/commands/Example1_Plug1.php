<?php
class Example1_Plug1{
	function execute(){
	}
	function &getContents(){
		$m="This text is coming from plug command that does not use any template<br>";
		return $m;
	}
}
?>