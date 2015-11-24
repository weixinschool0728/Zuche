<?php
function smarty_function_brave_html_select($params, &$smarty) {
    $result = '';
    
	$group = $params['group'];
	$data = $params['code'];

	if($params['empty'] == 'true') {
		if($group) {
			$group = array('-1' => '') + $group;
			$data[-1] = array('' => array('name' => '------'));
		} else {
			$data = array('' => array('name' => '------')) + (array)$data;
		}
	}

    if (empty($data)) {
        return $result;
    }
    
    if (strlen($params['value']) == 0) {
        $params['value'] = $params['default'];
    }

	if($group) {
		foreach($group as $gid => $label) {
			$result .= '<optgroup label="' . $label . '">';
			foreach((array)$data[$gid] as $key => $val) {
				if($val['value'] == $params['value']) {
					$result .= '<option value="' . $val['value'] . '" selected="selected">' . $val['name'] . '</option>';
				} else {
					$result .= '<option value="' . $val['value'] . '">' . $val['name'] . '</option>';
				}
			}
			$result .= '</optgroup>';
		}
	} else {
		foreach((array)$data as $key => $val) {
            if($val['hide']){
                continue;
            }
			if($val['value'] == $params['value']) {
				$result .= '<option value="' . $val['value'] . '" selected="selected">' . $val['name'] . '</option>';
			} else {
				$result .= '<option value="' . $val['value'] . '">' . $val['name'] . '</option>';
			}
		}
	}
    
    return $result;
}  

?>
