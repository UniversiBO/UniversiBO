<?php
class Example4 extends BaseCommand{
	function execute(){
		$this->initBase();
		$books=&$this->getBooks();
		$oddBooks=array();
		$evenBooks=array();
		$this->splitArray($books,$oddBooks,$evenBooks);
		$this->addLoop("books","name_even",$evenBooks);
		$this->addLoop("books","name_odd",$oddBooks);
		$this->processSuccess();
	}
	function &getBooks(){
		$names=array();
		$names[0]="Programming PHP";
		$names[1]="OO Methodology";
		$names[2]="Dial M For Murder";
		$names[3]="Beyond Belief";
		$names[4]="Andromeda Strain";
		$names[5]="The Eocene Framework";
		$names[6]="The Last Book";
		return $names;
	}
	function splitArray(&$inArray,&$oddArray,&$evenArray){
		$n=count($inArray);
		$isOdd=true;
		for($i=0;$i<$n;$i++){
			if($isOdd){
				array_push($oddArray,$inArray[$i]);
				$isOdd=false;
			}
			else{
				array_push($evenArray,$inArray[$i]);
				$isOdd=true;
			}
		}
		$n1=count($oddArray);
		$n2=count($evenArray);
		if($n1!=$n2){
			if($n1<$n2){array_push($oddArray,"");}
			else{array_push($evenArray,"");}
		}
	}
}
?>