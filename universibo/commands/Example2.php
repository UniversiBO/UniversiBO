<?php
class Example2 extends BaseCommand {
	function execute(){
		$this->initBase();
		$this->initializeFormVariables();
		$this->addEmptyVar("t_errorMessage");
		$this->processSuccess();
	}
	function initializeFormVariables(){
		$fv=array();
		$fv[0]="f_name";
		$fv[1]="f_password";
		$this->initFormVars($fv);
	}
}
?>