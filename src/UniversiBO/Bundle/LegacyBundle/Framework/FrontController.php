<?php
namespace UniversiBO\Bundle\LegacyBundle\Framework;

use UniversiBO\Bundle\LegacyBundle\App\ErrorHandlers;

define('MAIL_KEEPALIVE_NO', 0);
define('MAIL_KEEPALIVE_ALIVE', 1);
define('MAIL_KEEPALIVE_CLOSE', 2);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use \DB;
use \Error;
use \Krono;

/**
 * It is a front controller.
 * Instantiate it using a config file and run executeCommand method
 * to handle any action command.
 * It calls the execute method of an appropriate command controller
 * defined in the config file.
 *
 * @package framework
 * @version 1.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Fabrizio Pinto
 * @author Roberto Floris
 * @author Davide Bellettini
 * @author GNU/Mel <gnu.mel@gmail.com>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
class FrontController
{

    /**
     * @access private
     */
    private $configFile;

    /**
     * @access private
     */
    private $config;

    /**
     * @access private
     */
    private $rootFolder;

    /**
     * @access private
     */
    private $rootUrl = '';

    /**
     * @access private
     */
    private $receiverId;

    /**
     * @access private
     */
    private $defaultCommand;

    /**
     * @access private
     */
    private $commandClass;

    /**
     * @access private
     */
    private $paths;

    /**
     * @access private
     */
    private $receivers;

    /**
     * @access private
     */
    private $commandTemplate;

    /**
     * @access private
     */
    private $appSettings;

    /**
     * @access private
     */
    private $mailerInfo = array();

    /**
     * @access private
     */
    private $smsMobyInfo = array();

    /**
     * @access private
     */
    private $languageInfo = array();

    /**
     * @access private
     */
    private $plugins;

    /**
     * @access private
     */
    private $templateEngine;


    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var DBConnectionFactory
     */
    private static $connectionFactory;

    /**
     * Constuctor of front controller object based upon $configFile
     *
     * @param string $configFile filename of FrontController configuration file
     */
    public function __construct( $receiver ){
        $this->container = new ContainerBuilder();

        //		include_once('XmlDoc'.PHP_EXTENSION);

        $this->receiverIdentifier = $receiver->getIdentifier();

        /*		$log_error_definition = array(0=>'timestamp', 1=>'date', 2=>'remote_ip', 3=>'request', 4=>'referer_page', 5=>'file', 6=>'line', 7=>'description' );
         $errorLog = new LogHandler('error',$this->paths['logs'],$log_error_definition);
        */

        //		include_once("MultiLanguage.php");
        //		$language = new MultiLanguage('it',$this->defaultLanguage);
        //		var_dump($language);

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
        //$command_request=$this->getCommandRequest();
        $command_class=$this->getCommandClass();
        $bundleClass = 'UniversiBO\\Bundle\\LegacyBundle\\Command\\'.$command_class;
        
        if(class_exists($bundleClass)) {
            $command_class = $bundleClass;            
        } else {
            require_once($this->paths['commands'].'/'.$command_class.PHP_EXTENSION);
        }
        
        /**
         * @todo mettere controllo sull'avvenuta inclusione, altrimenti errore critico
         */
        $command = new $command_class;

        $command->initCommand($this);
        $response = $command->execute();
        $command->shutdownCommand();


        if ($response == NULL) $response='default';
        if (array_key_exists($response, $this->commandTemplate))
        {
            $template = $this->commandTemplate[$response];
             
            $templateEngine =& $this->getTemplateEngine();
            if (!$templateEngine->template_exists($template))
            {
                echo $template;
                \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non e` presente il file relativo al template specificato: "'.$template.'"','file'=>__FILE__,'line'=>__LINE__));
            }
             
            $templateEngine->display($template);
        }

    }



    /**
     * Executes a plugin action.
     *
     * A class SomePlugin should exists and someAction should be
     * associated with this class in the config file.
     *
     * @param string $name identifier name for this plugin
     * @param BaseCommand $base_command the caller BaseCommand
     * @param mixed $param a parameter handled by PluginCommand
     * @access public
     */
    function executePlugin($name, &$base_command, $param=NULL){
        $classValues = $this->getPluginClass($name);

        if ($classValues == null )
        {
            \Error::throwError(_ERROR_DEFAULT,array('msg'=>'Non e` stato definito il plugin richiesto: '.$name ,'file'=>__FILE__,'line'=>__LINE__));
            return;
        }

        //		$pc = $this->plugins[$name];
        //		$explodedPc = explode(".",$pc);
        //		$file_namepath = implode("/",$explodedPc);
        //		$class_name = $explodedPc[count($explodedPc)-1];
        //
        //		require_once($this->paths['commands'].$file_namepath.PHP_EXTENSION);
        
        if(class_exists($classValues['bundleClass'])) {
            $plugin = new $classValues['bundleClass']($base_command);
        } else {
            require_once($this->paths['commands'].$classValues['nameWithPath'].PHP_EXTENSION);
            $plugin = new $classValues['className']($base_command);
        }

        return $plugin->execute($param);
    }

    /**
     * @author Pinto
     * @access public
     * @return array list of available plugin for current requested command
     */
    function getAvailablePlugins ()
    {
        $list = array();
        foreach ($this->plugins as $pc)
        {
            //			$explodedPc = explode(".",$pc);
            //			$class_name = $explodedPc[count($explodedPc)-1];
            //			$list[]		= $class_name;
            $list[] = $this->_parsePluginInfo($pc);
        }
        return $list;
    }


    /**
     * Permette di redirigere la richiesa su un nuovo Command del receiver corrente
     *
     * @param string $command command identifier to redirect to with parameters in uri sintax es: 'do=ShowFacolta&cod_fac=2148'
     * @param string $receiver receiver identifier
     * @todo add ability to redirect on another receiver
     */
    function redirectCommand($command='', $receiver=NULL)
    {
        $request_protocol = (array_key_exists('HTTPS',$_SERVER) && $_SERVER['HTTPS']=='on') ? 'https' : 'http';

        if ( $command != '' )
        {
            $command = 'do='.$command;
        }

        $url = $request_protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$command;

        self::redirectUri($url);
    }


    /**
     * Permette di redirigere la richiesa su un'altra pagina
     *
     * @param string $destination
     */
    function redirectUri($destination)
    {
        header('Location: '.$destination);
        exit();
    }


    /**
     * Returns the command class name and path (without .)
     *
     * @return string
     * @access public
     */
    public function getCommandClass()
    {
        return str_replace('.', '\\', $this->commandClass);
    }

    /**
     * Returns the plugin command class associated in config file
     *
     * @param string $name PluginCommand name associated in config file
     * @return mixed  array with PluginCommand class path/file if $name exists for the current command, null otherwise
     * @access public
     */
    function getPluginClass($name)
    {
       	if (!array_key_exists($name, $this->plugins) )
       	{
       	    return null;
       	}
       	return $this->_parsePluginInfo($this->plugins[$name]);
    }

    /**
     * @author Pinto
     * @access private
     * @return array plugin values
     */
    function _parsePluginInfo ($plugin)
    {
       	$pc = $plugin['class'];
       	$explodedPc = explode(".",$pc);
       	$file_namepath = implode("/",$explodedPc);
       	$class_name = $explodedPc[count($explodedPc)-1];

       	$ret = array('nameWithPath' => $file_namepath,'className' => $class_name);
       	$ret['restrictedTo'] = (isset($plugin['restrictedTo']))? $plugin['restrictedTo'] : '';
       	$ret['condition'] = (isset($plugin['condition']))? $plugin['condition'] : '';
       	$ret['restrictedTo'] = str_replace(' ', '', $ret['restrictedTo']);
       	$ret['bundleClass'] = 'UniversiBO\\Bundle\\LegacyBundle\\Command\\' . str_replace('.', '\\', $pc);

       	$ret['restrictedTo'] = ($ret['restrictedTo'] != '') ? explode(',', $ret['restrictedTo']) : array();

       	return $ret;
    }
    /**
     * Returns the current receiver identifier
     *
     * @return string
     * @access public
     */
    function getReceiverId()
    {
       	return $this->receiverIdentifier;
    }



    /**
     * Returns the receiver URL of the given receiver identifier
     * All allowed identifiers must be listed in config file
     *
     * @param string $receiverId receiver identifier
     * @param boolean $relative if true path is relative to rootUrl
     * @return string ...mi ero scordato il commento non ricordo cosa ritorna!!!! argh!!!
     * @todo ...mi ero scordato il commento non ricordo cosa ritorna!!!! argh!!!
     * @access public
     */
    function getReceiverUrl($receiverId, $relative=true)
    {
       	if ( !array_key_exists($receiverId, $this->receivers) )
       	    \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Identificativo del receiver inesistente o non permesso','file'=>__FILE__,'line'=>__LINE__));

       	if ($relative == true )
       	{
       	    return $this->receivers[$receiverId];
       	}
       	else
       	{
       	    return $this->rootUrl.$this->receivers[$receiverId];
       	}
    }



    /**
     * Returns the config path url
     *
     * @return string
     * @access public
     */
    function getRootPath()
    {
       	return $this->rootUrl;
    }




    /**
     * Gets the current command string request
     * Returns default command string if not set
     * and  sets $_GET['do'] with default value
     *
     * @return string
     * @access public
     */
    function getCommandRequest()
    {
       	if(!array_key_exists('do',$_GET))
       	{
       	    $_GET['do'] = $this->defaultCommand;
       	}

       	if($_GET['do'] == '')
       	    \Error::throwError(_ERROR_DEFAULT,array('msg'=>'Il comando indicato � vuoto','file'=>__FILE__,'line'=>__LINE__));

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

       	//
       	//		$config = new XmlDoc();
       	//		$config->parse($configFile);

       	$config = new \DOMDocument();
       	//var_dump($config);
       	$config->load($configFile);

       	//		if($config->isError()) die ($config->error);

       	$this->config = & $config;

       	//Set $this->rootFolder
       	$this->_setRootFolder();

       	//Set $this->rootURL
       	$this->_setRootUrl();

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

       	$this->_setSmsMobyInfo();

       	//set $this->languageInfo
       	$this->_setLanguageInfo();

       	//set $this->appSettings
       	$this->_appSettings();

       	//Set $this->paths[]
       	$this->_setPaths();

       	//Set $this->rootURL
       	//$this->_setWebUrl();

       	//temp
       	//var_dump($this->config);

       	//return;

       	//$elementTemplate = $this->config->root->getChild('templateEngine');
       	//$this->templateEngine = $elementTemplate->charData;

       	//set $this->commandClass must be placed after $this->_setDefaultCommand();
       	$this->_setCommandClass();

       	//		var_dump($this); die();

       	unset($this->config);
    }


    /**
     * Imposta lo style del template da visualizzare...
     */
    function setStyle($style)
    {
       	$_SESSION['template_name'] = $style;
    }


    /**
     * Restituisce lo style del template da visualizzare...
     */
    function getStyle()
    {
       	if (!array_key_exists('template_name', $_SESSION) )
       	    return $this->getAppSetting('defaultStyle');

       	return $_SESSION['template_name'];
    }


    /**
     * Defines error categories, sets the error handlers
     */
    private function _setErrorHandler()
    {
        $handlers = new ErrorHandlers();
        $handlers->register();
    }

    /**
     * Sets the RootFolder
     *
     * @access private
     */
    function _setRootFolder()
    {
       	$elementsFolder = $this->config->getElementsByTagName('rootFolder');
       	if ($elementsFolder == NULL)
       	    \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non e` specificato l\'elemento rootFolder nel file di config','file'=>__FILE__,'line'=>__LINE__));
       	$elementFolderItem = $elementsFolder->item(0);
       	$elementFolderChild =& $elementFolderItem->firstChild;
       	$this->rootFolder = $elementFolderChild->nodeValue;
       	if(is_dir($this->rootFolder)) return;
       	else
       	    \Error::throwError(_ERROR_CRITICAL,array('msg'=>'rootFolder errata nel file di config','file'=>__FILE__,'line'=>__LINE__));
    }


    /**
     * Sets the RootURL
     *
     * @access private
     */
    function _setRootUrl()
    {
       	$rootNode	=& $this->config->documentElement;
       	//var_dump($rootNode);
       	// @TODO o completare il MyDOMNodeList o trasformare il foreach in for
       	$figli =& $rootNode->childNodes;
       	//var_dump($figli);
       	for ( $i = 0; $i < $figli->length; $i++ )
       	    if (($figlio = $figli->item($i)) != null)
       	    {
       	        if ( $figlio->nodeType == XML_ELEMENT_NODE && $figlio->tagName == 'rootURL')
       	        {
       	            $testo		=& $figlio->firstChild;
       	            $elementURL =& $testo->nodeValue;
       	            //					var_dump($figlio);
       	            break;
       	        }
       	    }
       	    $this->rootUrl = $elementURL;
       	    //var_dump($elementURL);
    }


    /**
     * Sets the Receivers Array
     *
     * @access private
     */
    function _setReceivers()
    {
       	$this->receivers=array();
       	$nodeList = $this->config->getElementsByTagName('receivers');
       	$node = $nodeList->item(0);
       	$figli =& $node->childNodes;
       	$n =& $figli->length;

       	for($i=0; $i<$n; $i++)
       	{
       	    $child	  = $figli->item($i);
       	    if ($child->nodeType == XML_ELEMENT_NODE)
       	    {
       	        $charData =&  $child->firstChild->nodeValue;
       	        $this->receivers[$child->tagName] = $charData;
       	    }
       	}
       	//var_dump($this->receivers);
    }


    /**
     * Sets the framework defaultCommand
     *
     * @access private
     */
    function _setDefaultCommand()
    {
        $figli =& $this->config->documentElement->childNodes;
        //		var_dump($figli);
        for ($i = 0; $i < $figli->length; $i++)
        {
            $iesimoFiglio = $figli->item($i);
            if ($iesimoFiglio->nodeType == XML_ELEMENT_NODE && $iesimoFiglio->tagName == 'defaultCommand')
                $this->defaultCommand =& $iesimoFiglio->firstChild->nodeValue;
        }
        //var_dump($this->defaultCommand );
    }


    /**
     * Sets the framework databaseConnections
     *
     * @access private
     */
    function _setDbInfo()
    {
        $dbinfoNodes = $this->config->getElementsByTagName('dbInfo');

        $dbInfo = $dbinfoNodes->item(0);
        $connections = $dbInfo->getElementsByTagName('connection');
        //		$connections =& $dbInfo->childNodes;
        $num =& $connections->length;
        //		var_dump($connections);

        self::$connectionFactory = new DBConnectionFactory();

        for( $i=0; $i<$num; $i++ )
        {
            $singleConnection = $connections->item($i);
            if ($singleConnection->nodeType == XML_ELEMENT_NODE)
            {
                $identifier = $singleConnection->getAttribute('identifier');
                //$identifier =& $attributo->nodeValue;
                //			var_dump($singleConnection->attributes);
                $charData = $singleConnection->firstChild->nodeValue;
                
                self::$connectionFactory->registerDSN($identifier, $charData);
            }
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

        $templateInfoNodes = $this->config->getElementsByTagName('templateInfo');
        if ( $templateInfoNodes == NULL )
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificato l\'elemento templateInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));
        $templateInfoNode = $templateInfoNodes->item(0);
        //		var_dump($templateInfoNode->attributes);
        if ( $templateInfoNode == NULL )
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificato l\'elemento templateInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));

        if ( $templateInfoNode->getAttribute('type') != 'Smarty' )
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Al momento non sono supportati template engines diversi da Smarty','file'=>__FILE__,'line'=>__LINE__));

        $this->templateEngine['debugging'] = ( $templateInfoNode->getAttribute('debugging') == 'on' );


        $templateDirsNodes 	= $templateInfoNode->getElementsByTagName('template_dirs');
        if ( $templateDirsNodes == NULL )
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificato l\'elemento template_dirs nel file di config','file'=>__FILE__,'line'=>__LINE__));
        $templateDirsNode	= $templateDirsNodes->item(0);
        if ( $templateDirsNode == NULL )
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificato l\'elemento template_dirs nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $figli = $templateDirsNode->childNodes;
        for( $i=0; $i<$figli->length; $i++ )
        {
            $templateSetting = $figli->item($i);
            if ($templateSetting->nodeType == XML_ELEMENT_NODE)
                $this->templateEngine[$templateSetting->tagName] = $templateSetting->firstChild->nodeValue;
        }


        $templateStylesNodes = $templateInfoNode->getElementsByTagName('template_styles');
        if($templateStylesNodes == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificato l\'elemento template_styles nel file di config','file'=>__FILE__,'line'=>__LINE__));
        $templateStylesNode	= $templateStylesNodes->item(0);
        if($templateStylesNode == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificato l\'elemento template_styles nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $figli = $templateStylesNode->childNodes;
        for( $i=0; $i<$figli->length; $i++ )
        {
            $templateSetting = $figli->item($i);
            if ($templateSetting->nodeType == XML_ELEMENT_NODE)
                $this->templateEngine['styles'][$templateSetting->getAttribute('name')] = $templateSetting->getAttribute('dir');
        }

        $this->templateEngine['default_template'] = $templateStylesNode->getAttribute('default');

        if (!array_key_exists($this->templateEngine['default_template'],$this->templateEngine['styles']))
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste il template di default nel file di config','file'=>__FILE__,'line'=>__LINE__));

        //assegno il template in uso
        if (array_key_exists('setStyle', $_GET) && $_GET['setStyle']!=''
                && array_key_exists($_GET['setStyle'],$this->templateEngine['styles']))
        {
            $this->setStyle($_GET['setStyle']);
        }

        if ( $this->getStyle()!='' )
        {
            $this->templateEngine['template_name'] = $this->getStyle();
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
        $mailerInfoNodes = $this->config->getElementsByTagName('mailerInfo');
        if ($mailerInfoNodes == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento mailerInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $mailerInfoNode = $mailerInfoNodes->item(0);
        if ($mailerInfoNode == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento mailerInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $figli = $mailerInfoNode->childNodes;
        for( $i=0; $i<$figli->length; $i++ )
        {
            $aSetting = $figli->item($i);
            if ($aSetting->nodeType == XML_ELEMENT_NODE)
                $this->mailerInfo[$aSetting->tagName] = $aSetting->firstChild->nodeValue;
        }
    }


    /**
     * Sets the framework mailer settings
     *
     * @access private
     */
    function _setSmsMobyInfo()
    {
        $smsMobyInfoNodes = $this->config->getElementsByTagName('smsMobyInfo');
        if ($smsMobyInfoNodes == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento smsMobyInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $smsMobyInfoNode = $smsMobyInfoNodes->item(0);
        if ($smsMobyInfoNode == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento smsMobyInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $figli = $smsMobyInfoNode->childNodes;
        for( $i=0; $i<$figli->length; $i++ )
        {
            $aSetting = $figli->item($i);
            if ($aSetting->nodeType == XML_ELEMENT_NODE)
                $this->smsMobyInfo[$aSetting->tagName] = $aSetting->firstChild->nodeValue;
        }

        $this->container -> register('mobytsms', 'mobytSms')
        -> addArgument($this->smsMobyInfo['username'])
        -> addArgument($this->smsMobyInfo['password'])
        -> addArgument($this->smsMobyInfo['fromName']);
    }



    /**
     * Sets the framework and application multilanguage info
     *
     * @access private
     */
    function _setLanguageInfo()
    {
        $languageInfoNodes = $this->config->getElementsbyTagname('langInfo');
        if ($languageInfoNodes == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento langInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));
        $languageInfoNode = $languageInfoNodes->item(0);
        if ($languageInfoNode == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste l\'elemento langInfo nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $figli = $languageInfoNode->childNodes;
        for( $i=0; $i < $figli->length; $i++ )
        {
            $aSetting = $figli->item($i);
            if ($aSetting->nodeType == XML_ELEMENT_NODE)
                $this->languageInfo[$aSetting->tagName] = $aSetting->firstChild->nodeValue;
        }

        //linguaggio corrente inpostato uguale a quello di default
        //inserire la possibilit? di cambiarlo a run time.
        $this->languageInfo['lang'] = $this->languageInfo['lang_default'];

        $this->container->register('krono', 'Krono')
        ->addArgument($this->languageInfo['lang'])
        ->addArgument($this->languageInfo['lang'])
        ->addArgument($this->languageInfo['date_separator']);
    }


    /**
     * Sets the framework application own settings
     *
     * @access private
     */
    function _appSettings()
    {
        $this->appSettings = array();
        //		$appSettingNodes = &$this->config->getElementsByTagName("appSettings");
        //		var_dump($appSettingNodes);

        $figli =& $this->config->documentElement->childNodes;
        //var_dump($figli);
        for ( $i = 0; $i < $figli->length; $i++ )
            if (($figlio = $figli->item($i)) != null)
            {
                if ( $figlio->nodeType == XML_ELEMENT_NODE && $figlio->tagName == 'appSettings')
                {
                    $appSettingNode =& $figlio;
                    break;
                }
            }

            if($appSettingNode == NULL) return;

            $figliAppSettingNode = $appSettingNode->childNodes;
            for( $i=0; $i < $figliAppSettingNode->length; $i++ )
            {
                $aSetting = $figliAppSettingNode->item($i);
                //			echo $i.' '.$aSetting->nodeName.'<br>';
                //				var_dump($aSetting);
                if ($aSetting->nodeType == XML_ELEMENT_NODE)
                {
                    $this->appSettings[$aSetting->tagName] = ($aSetting->hasChildNodes() == true) ? $aSetting->firstChild->nodeValue : '';
                }
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
        $nodes = $this->config->getElementsByTagName('paths');

        if($nodes == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non e` specificato l\'elemento path nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $node = $nodes->item(0);
        //var_dump($node);
        if($nodes == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non e` specificato l\'elemento path nel file di config','file'=>__FILE__,'line'=>__LINE__));

        $figli = &$node->childNodes;
        for($i=0; $i < $figli->length; $i++)
        {
            $child = $figli->item($i);
            //			$this->paths[$child->name]=realpath($this->rootFolder.$child->charData);
            if ($child->nodeType == XML_ELEMENT_NODE)
            {
                $this->paths[$child->tagName] = $this->rootFolder.$child->firstChild->nodeValue;
                //var_dump($child);
            }
        }

    }

    /**
    	* Sets the framework current request command class
    	*
    	* @access private
    	*/
    function _setCommandClass()
    {
        $commandString=$this->getCommandRequest();
        // @bug: qui il ->childNodes mi restituisce i figli di appsettings invce che dei figli di root
        $figliRoot =& $this->config->documentElement->childNodes;
        //		var_dump($this);
        //		$listaNodiCommands =& $this->config->getElementsByTagName("commands");
        $cinfonode = null;
        for ( $i = 0; $i < $figliRoot->length; $i++ )
        {
            $iesimoFiglio = $figliRoot->item($i);
            //			var_dump($iesimoFiglio);
            if ($iesimoFiglio != null)
                if ($iesimoFiglio->nodeType == XML_ELEMENT_NODE && $iesimoFiglio->tagName == 'commands' )
                {
                    $cinfonode =& $iesimoFiglio;
                    break;
                }

        }

        //	for ( $i = 0; $i < $listaNodiCommands->length; $i++ )
        //		{
        //			$iesimoFiglio =& $listaNodiCommands->item($i);
        //			var_dump($iesimoFiglio);
        //			if ($iesimoFiglio != null)
        //				if ($iesimoFiglio->nodeType == XML_ELEMENT_NODE && $iesimoFiglio->parentNode->nodeName == 'config' )
        //				{
        //					$cinfonode =& $iesimoFiglio;
        //					break;
        //				}
        //
        //		}

        //		var_dump($cinfonode);
        if($cinfonode == NULL)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Elemento commands non trovato nel file di config','file'=>__FILE__,'line'=>__LINE__));
        // @TODO qui migliorerebbe molto o xpath o cache
        $figli = &$cinfonode->childNodes;
        //print_r($figli);
        for($i=0; $i < $figli->length; $i++)
        {
            $child = $figli->item($i);
            if ( $child->nodeType == XML_ELEMENT_NODE && $child->tagName == $commandString )
            {
                $commandNode = &$child;
                break;
            }
        }
        if(!isset($commandNode) ||is_null($commandNode))
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non esiste il comando '.$commandString.' nel file di config','file'=>__FILE__,'line'=>__LINE__));

    				$this->commandClass = $commandNode->getAttribute('class');
    				//		var_dump($commandNode->attributes[0]->value);
    				//reads allowed response for this BaseCommand
    				$this->commandTemplate=array();
    				$responses = $commandNode->getElementsByTagName('response');

    				for($i=0; $i < $responses->length; $i++)
    				{
    				    $response = $responses->item($i);
    				    if ($response->getAttribute('type') == 'template')
    				    {
    				        $this->commandTemplate[$response->getAttribute('name')] = $response->firstChild->nodeValue;
    				    }
    				}

    				$plugins = $commandNode->getElementsByTagName('pluginCommand');

    				for($i=0; $i < $plugins->length; $i++)
    				{
    				    $plugin = $plugins->item($i);
    				    //			$this->plugins[$plugin->getAttribute('name')] = $plugin->getAttribute('class');
    				    $this->plugins[$plugin->getAttribute('name')] = array ('class' => $plugin->getAttribute('class'), 'restrictedTo' => $plugin->getAttribute('restrictedTo'), 'condition' => $plugin->getAttribute('condition'));
    				}

    				if(!isset($this->commandClass))
    				    \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � definito l\'attributo class relativo al comando specificato nel file di config','file'=>__FILE__,'line'=>__LINE__));

    				if(empty($this->commandClass))
    				    \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Non � specificata la classe relativa al comando spacificato nel file di config','file'=>__FILE__,'line'=>__LINE__));
    }


    /**
     * Returns values of elements added into the <appSettings> XML tag in config file
    	*
    	* @param string $identifier Setting name identifier of XML element tag
    	* @return string text content of XML tag
    	* @access public
    	*/
    function getAppSetting( $identifier )
    {
        return $this->appSettings[$identifier];
    }


    /**
     * Factory method that creates a Pear::DB Connection object
     * If called with optional $dsn parameter sets the connection information
     * Implements singleton pattern for each connection
     *
     * @param string $identifier Connection "name" identifier in config file
     * @param string $dsn optional sets the $identifier dsn connection
     * @return mixed true, PearDB
     * @access public
     */
    public static function getDbConnection($identifier)
    {
        $conn = self::$connectionFactory->getConnection($identifier);

        if(!$conn instanceof \DB_common)
            \Error::throwError(_ERROR_CRITICAL,array('msg'=>'Uso errato dell\'interfaccia di accesso al Database','file'=>__FILE__,'line'=>__LINE__));

        return $conn;
    }

    /**
     * Factory method that creates a Smarty object
     * Implements singleton pattern, returns always the same object istance
     *
     * @return Smarty
     * @access public
     */
    function getTemplateEngine()
    {
        static $templateEngine = NULL;
        //var_dump($templateEngine);
         
        //if ( defined('TEMPLATE_SINGLETON') ){
        if ( $templateEngine != NULL ){
            return $templateEngine ;
        }
        else
        {
            //define('TEMPLATE_SINGLETON','on');
            require_once($this->templateEngine['smarty_dir'].'Smarty.class.php');
            require_once($this->templateEngine['smarty_dir'].'MySmarty.class.php');
             
            //			$templateEngine = new Smarty();

            //mia aggiunta per tentativo di template "differenziali"
            $templateEngine = new \MySmarty();

            $templateEngine->default_template_dir  = $this->templateEngine['smarty_template'].$this->templateEngine['styles'][$this->templateEngine['default_template']];
            //fine mia aggiunta

            $templateEngine->template_dir  = $this->templateEngine['smarty_template'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
            $templateEngine->compile_dir   = $this->templateEngine['smarty_compile'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
            $templateEngine->config_dir    = $this->templateEngine['smarty_config'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
            $templateEngine->cache_dir     = $this->templateEngine['smarty_cache'].$this->templateEngine['styles'][$this->templateEngine['template_name']];
            $templateEngine->compile_check = true;
            $templateEngine->debugging     = $this->templateEngine['debugging'];

            return $templateEngine;

        }
    }


    public function getTemplateEngineSettings()
    {
        return $this->templateEngine;
    }

    /**
     * Factory method that creates a PhpMailer Mail object
     *
     * param $keepAlive MAIL_KEEPALIVE_NO||MAIL_KEEPALIVE_ALIVE||MAIL_KEEPALIVE_CLOSE
     * @return PHPMailer object
     * @access public
     */

    public function getMail($keepAlive = MAIL_KEEPALIVE_NO)
    {
        static $singleton = null;
        $mail = null;
         
        if ($keepAlive == MAIL_KEEPALIVE_ALIVE)
        {
            if ($singleton == null)
            {
                $singleton = new \PHPMailer();
                $singleton->IsSMTP(); 							// send via SMTP
                $singleton->Host = $this->mailerInfo['smtp'];	// SMTP server
                $singleton->SMTPAuth = false; 					// off SMTP authentication
                $singleton->From = $this->mailerInfo['fromAddress'];
                $singleton->FromName = $this->mailerInfo['fromName'];
                $singleton->WordWrap = 80;
                $singleton->IsHTML(false);
                $singleton->AddReplyTo($this->mailerInfo['replyToAddress'], $this->mailerInfo['fromName']);
                $singleton->SMTPKeepAlive = true;
            }

            return $singleton;

        }
        elseif ($keepAlive == MAIL_KEEPALIVE_CLOSE)
        {
            if ($singleton != null)
            {
                $singleton->SMTPKeepAlive = true;
            }
        }
        elseif($keepAlive == MAIL_KEEPALIVE_NO)
        {
            $mail = new \PHPMailer();
            $mail -> IsSMTP(); 							// send via SMTP
            $mail -> Host = $this->mailerInfo['smtp'];	// SMTP server
            $mail -> SMTPAuth = false; 					// off SMTP authentication
            $mail -> From = $this->mailerInfo['fromAddress'];
            $mail -> FromName = $this->mailerInfo['fromName'];
            $mail -> WordWrap = 80;
            $mail -> IsHTML(false);
            $mail -> AddReplyTo($this->mailerInfo['replyToAddress'], $this->mailerInfo['fromName']);
        }

        return $mail;
    }


    /**
    	* Factory method that creates a PhpMailer Mail object
    	*
    	* param $keepAlive MAIL_KEEPALIVE_NO||MAIL_KEEPALIVE_ALIVE||MAIL_KEEPALIVE_CLOSE
    	* @return PHPMailer object
    	* @access public
    	*/

    function getSmsMoby()
    {
        return $this->container->get('mobytsms');
    }

    /**
     * Factory method that creates a Kronos object based on the config language info
     *
     * @return Krono object
     * @access public
     */
    public function getKrono()
    {
        return $this->container->get('krono');
    }
}