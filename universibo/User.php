<?php

define('USER_OSPITE',0);
define('USER_STUDENTE',1);
define('USER_MODERATORE',2);
define('USER_TUTOR',4);
define('USER_DOCENTE',8);
define('USER_PERSONALE',16);
define('USER_ADMIN',32);


/**
 * User class
 *
 * @package universibo
 * @version 2.0.0
 * @author  Ilias Bartolini
 * @license http://www.opensource.org/licenses/gpl-license.php
 */

class User {
	
	var $id_user = 0;
	var $group = 0;
	var $groupName = '';
	var $lastLogin = 0;
	var $username = '';
	var $bookmark;

	function User($id_user)
	{
		

		
		
	}
	
	
	/**
	 *  Verifica se la sintassi dello username ט valido.
	 *  Sono permessi fino a 25 caratteri: alfanumerici, lettere accentate, spazi, punti, underscore
	 *
	 * @param string $username stringa dello username da verificare
	 * @return bool
	 */
	function isUsernameValid( $username )
	{

		$username_pattern='^([[:alnum:]אטעילש ._]{1,25})$';
		return ereg($username_pattern , $username );
	
	}
	

	/**
	 *  Verifica se la sintassi della password ט valida.
	 *  Lunghezza min 5, max 30 caratteri
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return bool
	 */
	function isPasswordValid( $password )
	{
		//$password_pattern='^([[:alnum:]]{5,30})$';
		//ereg($password_pattern , $password );
		$length = strlen( $password );
		return ( $lenght > 5 && $length < 30 );
	
	}
	
	
	
	/**
	 *  Verifica se la sintassi della password ט valida.
	 *  Lunghezza min 5, max 30 caratteri
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return bool
	 */
/*	function isPasswordValid( $password )
	{
		//$password_pattern='^([[:alnum:]]{5,30})$';
		//ereg($password_pattern , $password );
		$length = strlen( $password );
		return ( $lenght > 5 && $length < 30 );
	
	}
*/	
	
	
	/**
	 *  Verifica se la sintassi della password ט valida.
	 *  Lunghezza min 5, max 30 caratteri
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return bool
	 */
/*	function isPasswordValid( $password )
	{
		//$password_pattern='^([[:alnum:]]{5,30})$';
		//ereg($password_pattern , $password );
		$length = strlen( $password );
		return ( $lenght > 5 && $length < 30 );
	
	}
*/	
	
	
}

?>