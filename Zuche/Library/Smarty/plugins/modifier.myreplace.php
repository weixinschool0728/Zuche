<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function smarty_modifier_myreplace($string, $search) {
	if (count($search) > 0) {
		$newstring = strtr($string, $search);
		return $newstring;
	} else {
		return $string;
	}
}
?>
