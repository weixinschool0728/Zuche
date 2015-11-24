<?php

//用户注销原因选择
function smarty_function_brave_html_check_reason($params, &$smarty) {
    
	$result  = '';

	$reasons = $params['code'];
	$ckvalue = $params['value']; 


	foreach ($reasons as $key => $value) {

        $ck = ($ckvalue==$value['value'])?"checked=''":"";

		if($value['value']%3==1){
			$result.= "<tr> <td class='form-group' ><label><input {$ck} class='res' value='{$value['value']}' type='radio' name='radio1' />{$value['text']}</label></td>";
		}
		if($value['value']==(count($reasons))){
			$result.= "</tr>";
			break;
			//return $result;
		}
		if($value['value']%3==2){
			$result.= " <td class=form-group ><label><input {$ck} class='res' value='{$value['value']}' type=radio  name=radio1 />{$value['text']}</label></td>";

		}
		if($value['value']%3==0){
			$result.= "<td class=form-group ><label><input {$ck} class='res' value='{$value['value']}' type=radio  name=radio1 />{$value['text']}</label></td></tr>";
		}
	}

    return $result;
}  

?>
