<?php
/**
 * Class DBConnect
 * Version 1.0.0
 * Author: Deepak Dutta, http://www.eocene.net
 * Unrestricted license, subject to no modifcations to the line above.
 * Please include any modification history.
 * 10/01/2002 Initial creation.
 * DBConnect class is to connect to a MYSQL database and return a database link.
 * It has methods to process success and failure templates.
 *
 * PUBLIC METHODS
 *	&getLink()			returns a mysql databse link
*/
class DBConnect{
	var $_link;		//private
	
	function &getLink(){
		global $fc;
		if(isset($this->_link))
			return $this->_link;
			
		$this->_link=mysql_connect($fc->dbInfo['host'],$fc->dbInfo['userid'],$fc->dbInfo['password']);
		if(!$this->_link)
			$fc->writeError(104 ,mysql_error());
		
		$status=mysql_select_db($fc->dbInfo['database'],$this->_link);
		if(!$status)
			$fc->writeError(105,mysql_error());
		
		return $this->_link;
	}
}
?>