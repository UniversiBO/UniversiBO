<?php
class Example3 extends BaseCommand{
	function execute(){
		$this->initBase();
		$ids=&$this->getIds();
		$names=&$this->getNames();
		$this->addLoop("books","id",$ids);
		$this->addLoop("books","name",$names);
		$this->addSelectLoop("bookSelection","bookName","f_bookSelection",$names);
		$dbResultArray=&$this->getDBResult();	//simulating an array created from MySQL result set.
		$this->addLoopUsingDBResults("dbResultLoop","t_theBookName","column_book_name",$dbResultArray);
		$this->processSuccess();
	}
	function &getIds(){
		$id=array();
		$id[0]="2929";
		$id[1]="1234";
		$id[2]="5949";
		$id[3]="9281";
		$id[4]="7284";
		return $id;
	}
	function &getNames(){
		$names=array();
		$names[0]="Programming PHP";
		$names[1]="OO Methodology";
		$names[2]="Dial M For Murder";
		$names[3]="Beyond Belief";
		$names[4]="Andromeda Strain";
		return $names;
	}
	/*this function shows how to create a $dbResultArray using MySql result set
	**and mysql_fetch_array. $dbResultArray can be used for adding loop
	**It uses a simulated result set array. In practice, you will use the result set
	**obtained from MySQL by a select statement.
	*/
	function &getDBResult(){
		$counter=0;
		$resultArray=array();
		while ($result=$this->_mysql_fetch_array($counter)){
			$resultArray[$counter]=$result;
			$counter++;
		}
		return $resultArray;
	}
	function _mysql_fetch_array($counter){
		if ($counter>4) return null;
		$names=&$this->getNames();
		$ids=&$this->getIds();
		$dbArray=array();
		$dbArray["column_book_id"]=$ids[$counter];
		$dbArray["column_book_name"]=$names[$counter];
		return $dbArray;		
	}
}

?>