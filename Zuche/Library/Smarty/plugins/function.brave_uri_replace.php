<?php

function smarty_function_brave_uri_replace($params, &$smarty) {

	$uri = $_SERVER['QUERY_STRING'];
	
	if (empty($params)) {
		return '?'.$uri;
	}
	if (isset($params['array']) && strlen($params['array']) > 0) {
		$array = $params['array'];
		unset($params['array']);
	}
	
	$parts = array();
	
	parse_str($_SERVER['QUERY_STRING'], $parts);
	if(!is_array($params['exclude'])){
		$params['exclude'] = array();
	}
	foreach ($params['exclude'] as $val) {
		unset($parts[$array][$val]);
	}
	unset($params['exclude']);
	
	foreach ($params as $k => $v) {
        if($array){
            $parts[$array][$k] = $v;
        }else{
            $parts[$k] = $v;
        }
	}

	return '?'.http_build_query($parts);
}
?>
