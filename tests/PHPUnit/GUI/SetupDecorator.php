<?php
//
//  $Id: SetupDecorator.php,v 1.2 2003-09-09 13:04:37 brain_79 Exp $
//

/**
*   this decorator actually just adds the functionality to read the 
*   test-suite classes from a given directory and instanciate them 
*   automatically, use it as given in the example below.
*
*   usage example
*   <code>
*   $gui = new PHPUnit_GUI_SetupDecorator(new PHPUnit_GUI_HTML());
*   $gui->getSuitesFromDir();
*   $gui->show();
*   </code>
*
*/
class PHPUnit_GUI_SetupDecorator
{
    /**
    *
    *
    */
    function PHPUnit_GUI_SetupDecorator(&$gui)
    {
        $this->_gui = $gui;
    }
    
    /**
    *   just forwarding the action to the decorated class.
    *
    */
    function show($showPassed=true)
    {
        $this->_gui->show($showPassed);
    }
    
    /**
    *   Setup test suites that can be found in the given directory
    *   Using the second parameter you can also choose a subsets of the files found
    *   in the given directory. I.e. only all the files that contain '_UnitTest_',
    *   in order to do this simply call it like this:
    *   <code>getSuitesFromDir($dir,'.*_UnitTest_.*')</code>.
    *   There you can already see that the pattern is built for the use within a regular expression.
    *   
    *
    */
    function getSuitesFromDir($dir,$filenamePattern='',$exclude=array())
    {
        // remove trailing DIRECTORY_SEPERATOR if missing
        if ($dir{strlen($dir)-1} == DIRECTORY_SEPARATOR) {
            $dir = substr($dir,0,-1);
        }

        $files = $this->_getFiles($dir,$filenamePattern,$exclude,realpath($dir.'/..'));
        asort($files);
        foreach ($files as $className=>$aFile) {
            include_once($aFile);
            if (class_exists($className)) {
                $suites[] =& new PHPUnit_TestSuite($className);
            } else {
                trigger_error("$className could not be found in $dir$aFile!");
            }
        }
        
        $this->_gui->addSuites($suites);
    }
    
    function _getFiles($dir,$filenamePattern,$exclude,$rootDir)
    {
        $files = array();
        if ($dp=opendir($dir)) {
            while (false!==($file=readdir($dp))) {
                $filename = $dir.DIRECTORY_SEPARATOR.$file;
                $match = true;
                if ($filenamePattern && !preg_match("~$filenamePattern~",$file)) {
                    $match = false;
                }
                if (sizeof($exclude)) {
                    foreach ($exclude as $aExclude) {
                        if (strpos($file,$aExclude)!==false) {
                            $match = false;
                            break;
                        }
                    }
                }
                if (is_file($filename) && $match) {
                    $className = str_replace('/','_',substr(str_replace($rootDir,'',$filename),1));
                    $className = basename($className,'.php');   // remove php-extension
                    $files[$className] = $filename;
                }
                if ($file!='.' && $file!='..' && is_dir($filename)) {
                    $files = array_merge($files,$this->_getFiles($filename,$filenamePattern,$exclude,$rootDir));
                }
            }
            closedir($dp);
        }
        return $files;        
    }    
}

?>
