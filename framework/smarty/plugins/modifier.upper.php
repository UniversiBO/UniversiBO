<?php

/**
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     upper
 * Purpose:  convert string to uppercase
 * -------------------------------------------------------------
 *
 * @package Smarty
 */
function smarty_modifier_upper($string)
{
	return strtoupper($string);
}

?>
