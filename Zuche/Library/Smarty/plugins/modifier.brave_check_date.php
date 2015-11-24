<?php
function smarty_modifier_brave_check_date($date)
{
	if("0000-00-00"==$date) {
		return '';
	}
    
	return $date;
}
?>