<?php

/**
 * It is a front controller.
 * Instantiate it using a config file and run executeCommand method
 * to handle any action command.
 * It calls the execute method of an appropriate command controller 
 * defined in the config file.
 *
 * @package framework
 * @version 1.0.0
 * @author  Deepak Dutta, Ilias Bartolini
 * @license http://www.opensource.org/licenses/gpl-license.php
 */

class FrontController {	
	var $configFile;
	var $config;
	var $rootFolder;		
	var $rootURL;
	var $defaultCommand;
	var $commandClass;
	var $defaultLanguage;
	var $paths;	
	var $receivers;
	var $commandTemplate;
	var $dbLinks;
	var $appSettings;
	var $mailerInfo;
	var $plugs;
	var $templateEngine;

	/**
	* Constuctor of front controller object based upon $configFile 
	*
	* @param string $configFile filename of FrontController configuration file
	*/
	function FrontController( $configFile ){

		include_once("XmlDoc.php");
		include_once("LogHandler.php");

		//include bootstrap classes from core library
		$this->setConfig( $configFile );
		
		$log_error_definition = array(0 => 'time',
									  1 => 'remote_ip',
									  2 => 'request',
									  3 => 'referer_page',
									  4 => 'file',
									  5 => 'line',
									  6 => 'description' );
		
		$errorLog = new LogHandler('error',$this->paths['logs'],$log_error_definition); 

		$a = time();
		$b = $_SERVER['REMOTE_ADDR'];
		$c = (array_key_exists('HTTP_REFERER',$_SERVER)) ? $_SERVER['HTTP_REFERER'] : '';
		$protocol = (array_key_exists('HTTPS',$_SERVER) && $_SERVER['HTTPS']=='on')? 'https':'http';
		$d = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$e = __FILE__;
		$f = __LINE__;
		$g = 'description';
		$log_array = array('time'         => $a,
						   'remote_ip'    => $b,
						   'request'      => $c,
						   'referer_page' => $d,
						   'file'         => $e,
						   'line'         => $f,
						   'description'  => $g);

		$errorLog->addLogEntry($log_array);

		var_dump($errorLog);
		
		var_dump($this);
		//temp


		return;
		

		
		include_once("Error.php");
		include_once("MultiLanguage.php");

		$this->language=new MultiLanguage('it');
	

		//Initialize Request and Response objects and set $this->request, $this->response
//		$this->import("Request");
//		$this->import("Response");
//		$this->request=new Request();
//		$this->response=new Response();		
	}
	

	/**
	* Executes an action.
	*
	* Action is in receiver.php?do=someAction
	* A class SomeAction should exists and someAction should be
    * associated with this class in the config file.  Class SomeAction 
    * is the command controller that can serve one or more commands.
	*	
	* @access public
	*/
	function executeCommand(){
		//Need to set the language first because it handles errors.
		include_once ('BaseCommand.php');	
		//$cc=&$this->commandClass;
		$cc=$this->getCommandClass();
		$cr=$this->getCommandRequest();
		
		include_once($this->paths['commands'].'/'.$cc.'.php');
		//Now load the user language file
		//$this->language->loadUserMsg();
		
		$command=new $cc;
		$command->setFrontController($this);
		$command->execute();
	}
	

	/**
	* Returns the command class name only (without .) 
	*
	* @access public
	*/
	function getCommandClass(){
		$cc=&$this->commandClass;
		$explodedCC=explode(".",$cc);
		$theSize=count($explodedCC);
		if($theSize==1) return $explodedCC[0];
		else return $explodedCC[$theSize-1];
	}


	//insert an error and abort
	//writeError will take variable-length argument list
	//The first argument can be a string or an integer.
	//If the first argument is an integer, a language string is extracted from a language file
	//if the first argument is a string, it will sent to Error class as it is
	//If the first argument is an integer, more parameters can be passed to writeError for 
	//       for variable substitution in the string. Please refer manual or readme.txt
	function writeError($messageOrID){
		var_dump($messageOrID); 
		$numArgs=func_get_args();
		$theMessage="";
		if(count($numArgs)==1 && is_string($numArgs[0]))
			$theMessage=$messageOrID;
		else{
			$args = func_get_args() ; 
			unset( $args[0]);
			$languageObject=&$this->language;
			$currentLanguage=$languageObject->language;
			$messageString=$languageObject->messages[$currentLanguage][$messageOrID];
			$theMessage= vsprintf($messageString, $args);
		}
		$error = new Error($theMessage);
	}


	/**
	* Gets the current command string request
	* Returns default command string if not set
	* and  sets $_GET['do'] with default value
	*
	* @access public
	*/
	function getCommandRequest()
	{
		if(!array_key_exists('do',$_GET))
		{
			$_GET['do'] = $this->defaultCommand;
		}

		if($_GET['do'] == "")
			$this->writeError(119);

		return $_GET['do'];
	}


	/**
	* Set up the FrontController with the given $configFile 
	*
	* @param string $configFile filename of FrontController configuration file
	* @access public
	*/
	function setConfig( $configFile )
	{
		$config = new XmlDoc();
		$config->parse($configFile);

		if($config->isError()) die ($config->error);
	
		$this->config=&$config;

		//Set $this->rootFolder
		$this->_setRootFolder();

		//Set $this->rootURL
		$this->_setRootURL();

		//set $this->receivers
		$this->_setReceivers();

		//$set this->defaultCommand
		$this->_setDefaultCommand();

		//set $this->dbinfo
		$this->_setDbInfo();

		//set $this->templateEngine
		$this->_setTemplateEngineInfo();

		//set $this->dbinfo
		$this->_setMailerInfo();

		//set $this->appSettings
		$this->_appSettings();
		
		//Set $this->paths[]
		$this->_setPaths();

		//temp
		//var_dump($this->config);
		
		//return;
		
		//$elementTemplate = $this->config->root->getChild('templateEngine');
		//$this->templateEngine = $elementTemplate->charData;

		//set $this->commandClass must be placed after $this->_setDefaultCommand();
		$this->_setCommandClass();


		
		unset($this->config);
		
	}
	
	
	/**
	* Sets the RootFolder
	*
	* @access private
	*/
	function _setRootFolder()
	{
		$elementFolder = &$this->config->root->getChild('rootFolder');
		$this->rootFolder = $elementFolder->charData;
		if(is_dir($this->rootFolder)) return;
		die ('Config error: rootFolder mismatch');
	}

	
	/**
	* Sets the RootURL
	*
	* @access private
	*/
	function _setRootURL()
	{
		$elementURL = &$this->config->root->getChild('rootURL');
		$this->rootURL = $elementURL->charData;
	}


	/**
	* Sets the Receivers Array
	*
	* @access private
	*/
	function _setReceivers()
	{
		$this->receivers=array();
		$node=&$this->config->root->getChild('receivers');		
		$n=$node->numChildren();		
		for($i=0; $i<$n; $i++)
		{
			$child=&$node->children[$i];
			$charData=$child->charData;
			$this->receivers[$child->name]=$this->rootURL.'/'.$child->charData;
		}
	}


	/**
	* Sets the framework defaultCommand
	*
	* @access private
	*/
	function _setDefaultCommand()
	{
		$elementDefaultCommand = &$this->config->root->getChild('defaultCommand');
		$this->defaultCommand = $elementDefaultCommand->charData;
	}


	/**
	* Sets the framework databaseConnections
	*
	* @access private
	*/
	function _setDbInfo()
	{
		$this->receivers=array();
		$dbinfoNode=&$this->config->root->getChild('dbInfo');		
		$n = $dbinfoNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$dbConnection=&$dbinfoNode->children[$i];
			$this->getDbConnection( $dbConnection->attributes['identifier'], $dbConnection->charData );
		}
	}


	/**
	* Sets the framework templateEngine to be used from getTemplateEngine factory method
	*
	* @access private
	*/
	function _setTemplateEngineInfo()
	{
		$this->templateEngine=array();
		$templateInfoNode = &$this->config->root->getChild('templateInfo');		
		$n = $templateInfoNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$templateSetting = &$templateInfoNode->children[$i];
			$this->templateEngine[$templateSetting->name] = $templateSetting->charData;
		}
	}


	/**
	* Sets the framework mailer settings
	*
	* @access private
	*/
	function _setMailerInfo()
	{
		$this->mailerInfo = array();
		$mailerInfoNode = &$this->config->root->getChild("mailerInfo");
		if ($mailerInfoNode == NULL) return;
		$n = $mailerInfoNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$aSetting=&$mailerInfoNode->children[$i];
			$this->mailerInfo[$aSetting->name] = $aSetting->charData;
		}
	}	


	/**
	* Sets the framework application own settings
	*
	* @access private
	*/
	function _appSettings()
	{
		$this->appSettings = array();
		$appSeetingNode = &$this->config->root->getChild("appSettings");
		if($appSeetingNode == NULL) return;
		$n = $appSeetingNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$aSetting=&$appSeetingNode->children[$i];
			$this->appSettings[$aSetting->name] = $aSetting->charData;
		}
	}	


	/**
	* Sets the framework paths settings
	*
	* @access private
	*/
	function _setPaths()
	{
		$this->paths=array();
		$node=&$this->config->root->getChild('paths');
		if($node == NULL) $this->writeError('Paths non trovati');
		$n=$node->numChildren();
		for($i=0;$i<$n;$i++)
		{
			$child=&$node->children[$i];
//			$this->paths[$child->name]=realpath($this->rootFolder.$child->charData);
			$this->paths[$child->name]=$this->rootFolder.$child->charData;
		}
	}
	
	/**
	* Sets the framework current request command class
	*
	* @access private
	*/
	function _setCommandClass(){		
		$commandString=$this->getCommandRequest();
		
		$cinfonode=&$this->config->root->getChild('commands');
//err		if($cinfonode==NULL) $this->writeError(115);
		
		$commandNode=&$cinfonode->getChild($commandString);
//err		if($commandNode == NULL) $this->writeError(116,$commandString);

		$this->commandClass=$commandNode->attributes['class'];		

		$this->commandTemplate=array();
		//$templatePath=$this->paths['templates'];		
		$n=$commandNode->numChildren();
		for($i=0;$i<$n;$i++)
		{
			$child=&$commandNode->children[$i];
			$this->templates[$child->attributes['type']]=$child->charData;			
		}
//		if(!isset($this->commandClass))
//err			$this->writeError(117,$commandString);
			
//		if(empty($this->commandClass))
//err			$this->writeError(118,$commandString );			
	}	


	/**
	* Factory method that creates a Pear::DB Connection object
	* If called with optional $dsn parameter sets the connection information
	* Implements singleton pattern for each connection
	*
	* @param string $identifier Connection "name" identifier in config file
	* @param string $dsn optional sets the $identifier dsn connection
	* @return mixed true, false, PearError or PearDB
	* @access public 
	*/
	function &getDbConnection( $identifier, $dsn=NULL )
	{
		static $dsnList = array();
		static $connectionList = array();
		
		 
		if ( $dsn!==NULL )
		{
			 $dsnList[$identifier]=$dsn;
			 return true; //dsn "added" correcly
			 //if an open connection dsn is modified
			 //modification doesn't thake effect 
		}
		elseif( array_key_exists($identifier, $dsnList) )
		{	
			include_once('DB.php');
			
			if( !array_key_exists($identifier, $connectionList) )
			{
				$connectionList[$identifier] = &DB::connect( $dsnList[$identifier] );
			}
			return $connectionList[$identifier]; 	
			
		}
    	else return false;  //what are you tring do do... put error here?

	}


	
	/**
	* Factory method that creates a Smarty object
	* Implements singleton pattern, returns always the same object istance
	*
	* @return Smarty
	* @access public 
	*/
	function &getTemplateEngine( )
	{
		static $myTemplateObject = NULL;
		 
		if ( $myTemplateObject !== NULL ){
			 return $myTemplateObject; 
		}
		else
		{	
			define('SMARTY_DIR',$this->templateEngine['smarty_dir']);
			require_once(SMARTY_DIR.'/Smarty.class.php');
			
			$smarty = new Smarty();
			
			$smarty->template_dir = $this->templateEngine['smarty_template'];
			$smarty->compile_dir  = $this->templateEngine['smarty_compile'];
			$smarty->config_dir   = $this->templateEngine['smarty_config'];
			$smarty->cache_dir    = $this->templateEngine['smarty_cache'];

			$myTemplateObject =& $smarty; 
			
			return $smarty; 	
			
		}

	}


	
	/**
	* Factory method that creates a PhpMailer Mail object
	* If called with optional $dsn parameter sets the connection information
	*
	* @return phpmailer object
	* @access public 
	*/
	function getMail()
	{
		require_once("PHPMailer.php");

    	$mail = new PHPMailer();
    	$mail -> IsSMTP(); 							// send via SMTP
    	$mail -> Host = $this->mailerInfo['smtp'];	// SMTP server
    	$mail -> SMTPAuth = false; 					// off SMTP authentication
    	$mail -> From = $this->mailerInfo['fromAddress']; 
		$mail -> FromName = $this->mailerInfo['fromName'];
    	
    	return $mail;
	}


}
?>