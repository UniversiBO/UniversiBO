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
	var $paths;	
	var $receivers;
	var $commandTemplate;
	var $appSettings;
	var $mailerInfo = array();
	var $languageInfo = array();
	var $plugs;
	var $templateEngine;

	/**
	* Constuctor of front controller object based upon $configFile 
	*
	* @param string $configFile filename of FrontController configuration file
	*/
	function FrontController( $configFile ){


		include_once('Error'.PHP_EXTENSION); 
		include_once('LogHandler'.PHP_EXTENSION);
		include_once('XmlDoc'.PHP_EXTENSION);


		//include bootstrap classes from core library
		$this->setConfig( $configFile );
		
/*		$log_error_definition = array(	0 => 'timestamp',
										1 => 'date',
										2 => 'remote_ip',
										3 => 'request',
										4 => 'referer_page',
										5 => 'file',
										6 => 'line',
										7 => 'description' );
		
		$errorLog = new LogHandler('error',$this->paths['logs'],$log_error_definition); 
*/

//		include_once("MultiLanguage.php");

//		$language = new MultiLanguage('it',$this->defaultLanguage);
		
//		var_dump($language);
		//temp

		

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
		$command_class=$this->getCommandClass();
		//$command_request=$this->getCommandRequest();
		
		include_once($this->paths['commands'].'/'.$command_class.'.php');
		//Now load the user language file
		//$this->language->loadUserMsg();
		
		$command = new $command_class;
		
		$command->initCommand($this);
		
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

		$this->_setErrorHandler();


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

		//set $this->languageInfo
		$this->_setLanguageInfo();

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
 	* Defines error categories, sets the error handlers
	*/
	function _setErrorHandler(){
		
		require_once('ErrorHandlers'.PHP_EXTENSION);
		
		define('_ERROR_DEFAULT',0);
		define('_ERROR_CRITICAL',1);
		define('_ERROR_NOTICE',2);
		
		Error::setHandler(_ERROR_CRITICAL,array('ErrorHandlers','critical_handler'));
		Error::setHandler(_ERROR_DEFAULT,array('ErrorHandlers','default_handler'));
		Error::setHandler(_ERROR_NOTICE,array('ErrorHandlers','notice_handler'));
		
	}


	/**
	* Sets the RootFolder
	*
	* @access private
	*/
	function _setRootFolder()
	{
		$elementFolder = &$this->config->root->getChild('rootFolder');
		if ($elementFolder == NULL)
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è specificato l\'elemento rootFolder nel file di config','file'=>__FILE__,'line'=>__LINE__));
		$this->rootFolder = $elementFolder->charData;
		if(is_dir($this->rootFolder)) return;
		else
			Error::throw(_ERROR_CRITICAL,array('msg'=>'rootFolder errata nel file di config','file'=>__FILE__,'line'=>__LINE__));
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
		//cancellare?   $this->receivers=array();
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
		if ( $templateInfoNode == NULL )
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è specificato l\'elemento templateInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));
		
		if ( $templateInfoNode->attributes['type'] != 'Smarty' ) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Al momento non sono supportati template engines diversi da Smarty','file'=>__FILE__,'line'=>__LINE__));

		if ( $templateInfoNode->attributes['debugging'] == 'on' )
		{ 
			$this->templateEngine['debugging'] = true;
		}
		else
		{ 
			$this->templateEngine['debugging'] = false;
		}
		
		

		$templateDirsNode = &$templateInfoNode->getChild('template_dirs');
		if ( $templateDirsNode == NULL )
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è specificato l\'elemento template_dirs nel file di config','file'=>__FILE__,'line'=>__LINE__));
				
		$n = $templateDirsNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$templateSetting = &$templateDirsNode->children[$i];
			$this->templateEngine[$templateSetting->name] = $templateSetting->charData;
		}


		$templateStylesNode = &$templateInfoNode->getChild('template_styles');		
		if($templateStylesNode == NULL)
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è specificato l\'elemento template_styles nel file di config','file'=>__FILE__,'line'=>__LINE__));

		$n = $templateStylesNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$templateSetting = &$templateStylesNode->children[$i];
			$this->templateEngine['styles'][$templateSetting->attributes['name']] = $templateSetting->attributes['dir'];
		}

		$this->templateEngine['default_template'] = $templateStylesNode->attributes['default'];  
		
		if (!array_key_exists($this->templateEngine['default_template'],$this->templateEngine['styles']))
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non esiste il template di default nel file di config','file'=>__FILE__,'line'=>__LINE__));
		
		//assegno il template in uso	
		if (array_key_exists('setTemplate', $_GET) && $_GET['setTemplate']!=''
			&& array_key_exists($_GET['setTemplate'],$this->templateEngine['styles'])) 
		{
			$_SESSION['template_name'] = $_GET['setTemplate'];
		}
		
		if (array_key_exists('template_name', $_SESSION) && $_SESSION['template_name']!='') 
		{
			$this->templateEngine['template_name'] = $_SESSION['template_name'];
		}
		else
		{
			$this->templateEngine['template_name'] = $this->templateEngine['default_template'];
		}
		
	}


	/**
	* Sets the framework mailer settings
	*
	* @access private
	*/
	function _setMailerInfo()
	{
		$mailerInfoNode =& $this->config->root->getChild('mailerInfo');
		if ($mailerInfoNode == NULL)
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento mailerInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));
		
		$n = $mailerInfoNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$aSetting=&$mailerInfoNode->children[$i];
			$this->mailerInfo[$aSetting->name] = $aSetting->charData;
		}
	}	


	/**
	* Sets the framework and application multilanguage info
	*
	* @access private
	*/
	function _setLanguageInfo()
	{
		$languageInfoNode =& $this->config->root->getChild('langInfo');
		if ($languageInfoNode == NULL)
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento langInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));
		
		$n = $languageInfoNode->numChildren();
		for( $i=0; $i<$n; $i++ )
		{
			$aSetting=&$languageInfoNode->children[$i];
			$this->languageInfo[$aSetting->name] = $aSetting->charData;
		}
		
		//linguaggio corrente inpostato uguale a quello di default
		//inserire la possibilità di cambiarlo a run time. 
		$this->languageInfo['lang'] = $this->languageInfo['lang_default'];  
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
		if($node == NULL)
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è specificato l\'elemento path nel file di config','file'=>__FILE__,'line'=>__LINE__));
			
		$n=$node->numChildren();
		for($i=0; $i<$n; $i++)
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
		if($cinfonode == NULL)
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Elemento commands non trovato nel file di config','file'=>__FILE__,'line'=>__LINE__));
		
		$commandNode=&$cinfonode->getChild($commandString);
		if($commandNode == NULL)
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Non esiste il comando '.$commandString.' nel file di config','file'=>__FILE__,'line'=>__LINE__));
		
		$this->commandClass=$commandNode->attributes['class'];
		
		$this->commandTemplate=array();
		//$templatePath=$this->paths['templates'];		
		$n=$commandNode->numChildren();
		for($i=0;$i<$n;$i++)
		{
			$child=&$commandNode->children[$i];
			$this->templates[$child->attributes['type']]=$child->charData;			
		}
		if(!isset($this->commandClass))
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è definita l\'attributo class relativo al comando spacificato nel file di config','file'=>__FILE__,'line'=>__LINE__));
			
		if(empty($this->commandClass))
			Error::throw(_ERROR_CRITICAL,array('msg'=>'Non è specificata la classe relativa al comando spacificato nel file di config','file'=>__FILE__,'line'=>__LINE__));
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
				if (DB::isError($connectionList[$identifier]))
 					Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($connectionList[$identifier]),'file'=>__FILE__,'line'=>__LINE__)); 
 
			}
			return $connectionList[$identifier]; 	
			
		}
    	else return false;  //wrong use of interface... put error here?

	}


	
	/**
	* Factory method that creates a Smarty object
	* Implements singleton pattern, returns always the same object istance
	*
	* @return Smarty
	* @access public 
	*/
	function &getTemplateEngine()
	{
		static $templateEngine;
		//var_dump($templateEngine);
		 
		if ( defined('SMARTY_DIR') ){
			 return $templateEngine ; 
		}
		else
		{	
			define('SMARTY_DIR',$this->templateEngine['smarty_dir']);
			require_once(SMARTY_DIR.'Smarty.class.php');
			
			$templateEngine = new Smarty();
			
			$templateEngine->template_dir = $this->templateEngine['smarty_template'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
			$templateEngine->compile_dir  = $this->templateEngine['smarty_compile'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
			$templateEngine->config_dir   = $this->templateEngine['smarty_config'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
			$templateEngine->cache_dir    = $this->templateEngine['smarty_cache'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
			$templateEngine->debugging    = $this->templateEngine['debugging'];
			
			//var_dump($templateEngine->debugging);
			
			return $templateEngine; 	
			
		}

	}


	
	/**
	* Factory method that creates a PhpMailer Mail object
	*
	* @return PHPMailer object
	* @access public 
	*/
	function &getMail()
	{
		require_once('PHPMailer.php');

    	$mail = new PHPMailer();
    	$mail -> IsSMTP(); 							// send via SMTP
    	$mail -> Host = $this->mailerInfo['smtp'];	// SMTP server
    	$mail -> SMTPAuth = false; 					// off SMTP authentication
    	$mail -> From = $this->mailerInfo['fromAddress']; 
		$mail -> FromName = $this->mailerInfo['fromName'];
    	
    	return $mail;
	}


	/**
	* Factory method that creates a Kronos object based on the config language info
	*
	* @return Krono object
	* @access public 
	*/
	function &getKrono()
	{

		require_once('Krono.php');

		$krono = new Krono($this->languageInfo['lang'],$this->languageInfo['lang'],$this->languageInfo['date_separator']);
    	
    	return $krono;
    	
	}


}
?>