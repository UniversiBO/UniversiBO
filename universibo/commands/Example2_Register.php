<?php
$this->import("commands.Example2");
class Example2_Register extends Example2{
	function execute(){
		$this->initBase();
		$this->initializeFormVariables();
		if($this->isInputOK($message)){
			global $fc;
			$m="Thank you, ".$fc->request->f_name.", for registering";
			$this->addVar("t_successMessage",$m);
			$this->processSuccess();
		}
		else {
			$this->addVar("t_errorMessage",$message);
			$this->processFailure();
		}
	}
	function isInputOK(&$message){
		global $fc;
		if(strlen($fc->request->f_name) < 4){
			$message="Name should not be less than four characters long";
			return false;
		}
		if(strlen($fc->request->f_password) < 4){
			$message="Password should not be less than four characters long";
			return false;
		}
		return true;
	}
}
?>