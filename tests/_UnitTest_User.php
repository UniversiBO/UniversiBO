<?php
/*
* StringTest.php
* 
* suite di test per la classe String
*/ 


/*
* classe PHPUnit 
*/
require_once 'PHPUnit'.PHP_EXTENSION;


/*
* classe da testare 
*/
require_once '../universibo/User'.PHP_EXTENSION;


/**
 * Esempio d'uso di PHPUnit
 * Test per la classe String
 *
 * @package universibo_tests
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class UserTest extends PHPUnit_TestCase
{
// contains the object handle of the string class
var $utente;

// valori del test..
var $username = '<pippo>';
var $id_utente = 0;
var $MD5 = '';
var $email = '';
var $ultimoLogin = 0;
var $bookmark = array();
var $ADUsername = '';
var $groups = 0;

// constructor of the test suite
function UserTest($name) {
$this->PHPUnit_TestCase($name);
}

// called before the test functions will be executed
// this function is defined in PHPUnit_TestCase and overwritten
// here
function setUp() {
// create a new instance of User.
$this->utente = new User(USER_ALL, 0, $this->username);
}

// called after the test functions are executed
// this function is defined in PHPUnit_TestCase and overwritten
// here
function tearDown() {
// delete your instance
unset($this->utente);
}


// test of the getUsername function
function testGetUsername() {
$result = $this->utente->getUsername();
$expected = $this->username;
$this->assertTrue($result == $expected);
}

// test of the getPasswordHash function
function testGetPasswordHash() {
$result = $this->utente->getPasswordHash();
$expected = $this->MD5;
$this->assertTrue($result == $expected);
}

// test of the getMail function
function testGetEmail() {
$result = $this->utente->getEmail();
$expected = $this->email;
$this->assertTrue($result == $expected);
}

// test of the getUltimoLogin function
function testGetUltimoLogin() {
$result = $this->utente->getUltimoLogin();
$expected = $this->ultimoLogin;
$this->assertTrue($result == $expected);
}

// test of the isUsernameValid function
function testIsUsernameValid() {
$result = $this->utente->isUsernameValid($this->utente->getUsername());
$expected = true;
$this->assertTrue($result == $expected);
}


/*// test of the isPasswordValid function
function testIsPasswordValid() {
$result = $this->utente->isPasswordValid($this->utente->????);
$expected = true;
$this->assertTrue($result == $expected);
}*/

}


$suite  = new PHPUnit_TestSuite('UserTest');
$result = PHPUnit::run($suite);
//echo $result -> toHTML();
echo $result -> toHtmlTable();

?>