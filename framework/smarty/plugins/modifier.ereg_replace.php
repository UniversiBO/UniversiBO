<?php

/**
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     regex_replace
 * Purpose:  regular epxression search/replace
 * -------------------------------------------------------------
 *
 * @package Smarty
 */
function smarty_modifier_ereg_replace($string, $search, $replace)
{
    return ereg_replace($search, $replace, $string);
}

/* vim: set expandtab: */

?>
