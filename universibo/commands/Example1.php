<?php
class Example1 extends BaseCommand {
	function execute(){
		global $fc;
		$this->initBase();
		if(!isset($fc->request->f_onBlock)){
			$this->addBlock("onBlock");
		}
		else{
			$this->addBlock("offBlock");
		}
		
		$this->processSuccess();
	}
}
?>