<?php
/**
 * Class TemplateEngine
 * Version 1.0.0
 * Author: Deepak Dutta, http://www.eocene.net
 * Unrestricted license, subject to no modifcation to the line above
 * Please include any modification history
 * 10/01/2002 Initial creation
 * TemplateEngine class is used to parse the template
 *
 * PUBLIC PROPERTIES
 *	var $fileName		Name of the file including the path
 *  var $fileContents	Entire contents of the file
 *  var $variables		array of all the variables (anything between {} in the template)
 *  var $loops			name of all the loops
 *  var $blockNames		name of all the blocks
 *  var $unresolvedVars	variables that were found in template but not in $variables
 * PUBLIC METHODS
 *	setVar(&$varName,&$varValue)		sets variables
 *	setLoop(&$loopName, &$loopData)		sets loops 
 *	setBlock(&$aName)					sets blocks 
 *	process(&$fileName,&$templateRoot)	process the template. Should be called after setting var, loops, and blocks
 * 										The processed template can be extracted from $fileContents 
*/
class TemplateEngine{

	var $fileName;
	var $fileContents;
	var $variables = array();
	var $loops = array();
	var $blockNames = array();

	//Use it to set variables
	function setVar(&$varName, &$varValue){
		if (is_array($varValue)) {
			foreach($varValue as $key=>$value){
				$newName=$varName . '.' . $key;
				$this->setVar($newName, $value);
			}
		}
		else {
			$this->variables[$varName] = $varValue;
		}
	}

	//Use it to set loops
	function setLoop(&$loopName, &$loopData){
		if (!$loopData) $loopData = 0;
		$this->loops[$loopName] = $loopData;
	}

	//Use it to set blocks
	function setBlock(&$aName){
		$this->blockNames[$aName]="";
	}

	//Call this method to process template after everything is set
	//$fileName has full path, $templateRoot is used to resolve includes
	function process(&$fileName,&$templateRoot){
		$this->fileName=$fileName;
		$this->fileContents=&$this->getFileContents($this->fileName);
		$this->processInclude($templateRoot);	
		$this->processBlocks();
		$this->processLoops();
		$this->processVariables();
		$this->processPlugs();		
	}
	/******************************************************************************
	PRIVATE METHODS AND PROPERTIES
	*******************************************************************************/
	function &getFileContents(&$fileName){
		if (!file_exists($fileName))
		  $this->error("TemplateEngine: file $fileName does not exist.");

		$fileContents = fread($fp = fopen($fileName, 'r'), filesize($fileName));
		fclose($fp);
		return $fileContents;
	}

	function processInclude(&$templateRoot){
		$fileContents = &$this->fileContents;
		while(is_long($position = strpos($fileContents, '<include filename="'))){
			$position += 19;
			$endPosition = strpos($fileContents, '"/>', $position);
			$includeFileName = substr($fileContents, $position, $endPosition-$position);
			$replaceThis = '<include filename="'.$includeFileName.'"/>';
			$includeFileName=&$this->getIncludedFileWithPath($includeFileName,$templateRoot);
			$includeContents = &$this->getFileContents($includeFileName);
			$fileContents = str_replace($replaceThis, $includeContents, $fileContents);
		}
	}
	
	function processPlugs(){
		$fileContents = &$this->fileContents;
		while(is_long($position = strpos($fileContents, '<plug command="'))){
			$position += 15;
			$endPosition = strpos($fileContents, '"/>', $position);
			$plugAction = substr($fileContents, $position, $endPosition-$position);
			$replaceThis = '<plug command="'.$plugAction.'"/>';
			
			global $fc;
			$plugContents = &$fc->getPlugContents($plugAction);
			$fileContents = str_replace($replaceThis, $plugContents, $fileContents);
		}
	}
	
	function processLoops(){
		$fileContents = &$this->fileContents;
		while (list($loopName, $loopArgs) = each($this->loops) ){

			$startTag = strpos($fileContents, '<loop start="'.$loopName.'"/>');
			$startPosition = $startTag + strlen('<loop start="'.$loopName.'"/>');
			if (!$startPosition) continue;

			$endPosition = strpos($fileContents, '<loop end="'.$loopName.'"/>');

			$loopContents = substr($fileContents, $startPosition, $endPosition-$startPosition);
			$originalLoopContents = $loopContents;
			
			$startTag = substr($fileContents, $startTag, strlen('<loop start="'.$loopName.'"/>'));
			$endTag = substr($fileContents, $endPosition, strlen('<loop end="'.$loopName.'"/>'));

			if($loopContents == '') continue;
		
			$parsedContents = '';
			if (is_array($loopArgs)){
				$theKeys = array_keys($loopArgs);
				$numKeys = count($theKeys);
				for($i = 0; ($i< $numKeys); $i++){	
					$holdIt = $loopContents;
					foreach( $loopArgs[$theKeys[$i]] as $k=>$v){
						$holdIt = str_replace('{'. $loopName. '.' .$k. '}',$v,$holdIt);
					}
					$parsedContents .= $holdIt;
				}	
			} 	
			$fileContents =str_replace($startTag.$originalLoopContents.$endTag,$parsedContents,$fileContents);
		}
	}

	function processVariables(){
		if(empty($this->variables)) return;
		
		$fileContents=&$this->fileContents;
		$allStringsBeforeParen=explode('{',$fileContents);

		$numSizeBeforeParen=count($allStringsBeforeParen);
		for($i=1;$i<$numSizeBeforeParen;$i++){
			$templateVariable=explode('}',$allStringsBeforeParen[$i]);
			if(count($templateVariable)==0){
				$this->error("No closing } for ".$allStringsBeforeParen[$i-1]);
			}

			if(isset($this->variables[$templateVariable[0]])){
				$templateVariable[0] = $this->variables[$templateVariable[0]];
				$allStringsBeforeParen[$i]=implode("",$templateVariable);
			}
			else{
				$allStringsBeforeParen[$i]=implode("}",$templateVariable);
				$allStringsBeforeParen[$i] ="{".$allStringsBeforeParen[$i];
			}

		}
		$fileContents=implode("",$allStringsBeforeParen);
	}

	function processBlocks(){
		$templateString=&$this->fileContents;
		$blockStartAt=strpos($templateString, '<block start="',0);
		if(!is_long($blockStartAt)) return;		
	
		while(is_long($blockStartAt)){
			$this->processTemplateStringForBlock($templateString,$blockStartAt);
			$templateString=&$this->fileContents;
			$blockStartAt=strpos($templateString, '<block start="',0);	
		}
	}
	
	function processTemplateStringForBlock(&$templateString,$blockStartAt){
		if(!is_long($blockStartAt)) return;
		
		$blockNameStartAt=$blockStartAt+14;
		$blockNameEndAt=strpos($templateString,'"/>',$blockNameStartAt);
		$blockNameLength=$blockNameEndAt-$blockNameStartAt;
		$blockName=substr($templateString,$blockNameStartAt,$blockNameLength);
		if($blockNameLength>50 || $blockNameLength<=0)
			$this->error("Block name $blockName should be between 1 and 50 characters");
		
		$startTag='<block start="'.$blockName.'"/>';
		$endTag='<block end="'.$blockName.'"/>';
		$blockEndTagStartsAt=strpos($templateString,$endTag,$blockNameStartAt);
		if(!is_long($blockEndTagStartsAt))
			$this->error("Cannot find end tag for block name $blockName");

		$blockEndAt=$blockEndTagStartsAt+strlen($endTag);
		$blockLength=$blockEndAt-$blockStartAt;
		if(isset($this->blockNames[$blockName])){
			$searchString=array();
			$searchString[0]=$startTag;
			$searchString[1]=$endTag;

			$templateString=str_replace($searchString,'',$templateString);	
		}
		else{
			$templateString=substr_replace($templateString,'',$blockStartAt,$blockLength);
		}
	}
	
	//included files in a template should be either in the same template directory
	//or in the root templates directory.
	//$fileName does not have path
	//$this->fileName has path
	function &getIncludedFileWithPath(&$fileName,&$templateRoot){
		$trueFileName=dirname($this->fileName).'/'.$fileName;
		if(file_exists($trueFileName)) return $trueFileName;
		return $templateRoot.'/'.$fileName;
	}	

	function error($msg){
		print $msg;
		exit();
	}
}
?>