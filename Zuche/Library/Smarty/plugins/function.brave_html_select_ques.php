<?php
function smarty_function_brave_html_select_ques($params, &$smarty) {
    $result = '';


    $quesarr = $params['code'];

    $index    = isset($params['index'])?$params['index']:0;

    foreach ($quesarr as $arr) {
        $selected = ($arr['id'] == $index)?'selected':'';
        
        $result.= '<option value="' . $arr['id'] . '" ' . $selected . '>';
        $result.= $arr['text'];
        $result.= '</option>';
    }
    return $result;
}  

?>
