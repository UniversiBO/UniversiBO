<?php

/**
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     lower
 * Purpose:  convert string to lowercase
 * -------------------------------------------------------------
 *
 * @package Smarty
 */
function smarty_modifier_lower($string)
{
	return strtolower($string);
}

?>
