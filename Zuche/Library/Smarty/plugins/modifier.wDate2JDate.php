<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function smarty_modifier_wDate2JDate($string, $format='Y年m月d日') {
	if($format == '' || $string == ''){
        return $string;
    }
    $newstring = $string;
    if(is_numeric($string)){
        $string .= "-" . "01-01";
    }
    $time = strtotime($string);
    if(!preg_match("/Y/is", $format)){
        return date($format, $time);
    }else{
        $format = preg_replace(array("/YY/s","/Y/s", "/y/s"), array('{>>>}', '{>>}', '{<<}'), $format);
    }
    $replace = array(
        '{>>>}' => '',
        '{>>}' => '',
        '{<<}' => '',
    );
    
    $y = date('Y', $time);
    if ($y - 1988 > 0) {
        $yearNum = 4;
        $replace['{>>>}'] = '平' . ($y - 1988);
        $replace['{>>}'] = '平成' . ($y - 1988);
        $replace['{<<}'] = 'H' . ($y - 1988);
    } else if ($y - 1925 > 0) {
        $yearNum = 3;
        $replace['{>>>}'] = '昭' . ($y - 1925);
        $replace['{>>}'] = '昭和' . ($y - 1925);
        $replace['{<<}'] = '昭和' . ($y - 1925);
    } else if ($y - 1911 > 0) {
        $yearNum = 2;
        $replace['{>>>}'] = '大' . ($y - 1911);
        $replace['{>>}'] = '大正' . ($y - 1911);
        $replace['{<<}'] = '大正' . ($y - 1911);
    } else if ($y - 1867 > 0) {
        $yearNum = 1;
        $replace['{>>>}'] = '明' . ($y - 1867);
        $replace['{>>}'] = '明治' . ($y - 1867);
        $replace['{<<}'] = '明治' . ($y - 1867);
    } else {
        return $newstring;
    }
    $str = date($format, $time);
    return str_replace(array_keys($replace), $replace, $str);
}
?>
