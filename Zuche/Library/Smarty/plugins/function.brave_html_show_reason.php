<?php

//用户注销原因展示
function smarty_function_brave_html_show_reason($params, &$smarty) {
    
	$result  = '';
 
	$reasons = $params['code'];
	$rid     = $params['rid'];
	$reason  = $params['value'];
    if($rid!=10){
    	$result = $reasons[$rid]['text'];
    }else{
    	$result = $reason;

    }
    return $result;
}  

?>
