<?php
/**
 * Class MultiLanguage
 * Version 1.1.0
 * Author: pswitek, http://www.eocene.net
 * Unrestricted license, subject to no modifcations to the line above.
 * Please include any modifcation history.
 * This class adds multilanguage capability to Eocene
 * PUBLIC METHODS
 *  getLanguage()		//returns a language code
 *  getMessage($msgId)	//It accepts variable length arguments besides $msgId and returns a message string 
 *
 * @package framework
 * @version 1.1.0
 * @author  Deepak Dutta, Ilias Bartolini
 * @license http://www.opensource.org/licenses/gpl-license.php
 */

class MultiLanguage { 
	var $language = 'en' ; 
	var $messages;
	var $eoceneLanguageFile='eoceneStrings.txt';
	
	function MultiLanguage($eoceneLanguage){
		if(isset($eoceneLanguage)) $this->setLanguage($eoceneLanguage);
		$this->loadEoceneMsg();
	}

	function setLanguage( $language) { 
		$this->language = $language ; 
	} 

	function getLanguage() { 
		return $this->language ; 
	} 

	function getMessage( $msgId ) { 
		$args = func_get_args() ; 
		unset( $args[0]); 
		return vsprintf( $this->messages[$this->language][$msgId], $args) ; 
	} 

	function loadUserMsg() { 
		global $fc ;
		if(isset($fc->appSettings['langFile'])){
			$fullPath=realpath($fc->rootFolder . $fc->appSettings['langFile']);
			if (!$fp=fopen( $fullPath, 'r' )) $fc->writeError( 120,$fullPath ); 
			while ($line = fgetcsv($fp, 1000, ','))
				$this->messages[$line[0]][$line[1]] = $line[2];
		}
	}
	
	function loadEoceneMsg(){
		global $fc ;
		global $eocene;
		$theFile = $this->eoceneLanguageFile;
		if (!$fp=fopen( $theFile, 'r' ))
			$fc->writeError("Error: Cannot open Eocene language file: $theFile"); 
		while ($line = fgetcsv($fp, 1000, ',')) 
			$this->messages[$line[0]][$line[1]] = $line[2]; 
	}
}
?>
