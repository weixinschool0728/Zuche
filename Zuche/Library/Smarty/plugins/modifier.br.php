<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function smarty_modifier_br($string, $search="（") {
    $preg="/^(.*)(".$search.")(.+)$/isU";
    return preg_replace($preg,"$1"."<br>".$search."$3" , $string);
}
?>
