<?php
class Example1_Plug2 extends BaseCommand {
	function execute(){
		$this->initBase();
		$this->initializeFormVariables();
		$this->addEmptyVar("t_errorMessage");
	}
	function initializeFormVariables(){
		$fv=array();
		$fv[0]="f_name";
		$fv[1]="f_password";
		$this->initFormVars($fv);
	}
}
?>