<?php

function smarty_function_brave_jp_year($params, &$smarty) {
	$year = $params['year'];
	if($year > 1989){
		$jpYear = '平成' . ($year - 1988).'年';
	}elseif($year == 1989){
		$jpYear = '平成元年';
	}elseif($year > 1926){
		$jpYear = '昭和' . ($year - 1925).'年';
	}elseif($year == 1926){
		$jpYear = '昭和元年';
	}elseif($year > 1912){
		$jpYear = '大正' . ($year - 1912).'年';
	}elseif($year == 1912){
		$jpYear = '大正元年';
	}elseif($year > 1868){
		$jpYear = '明治' . ($year - 1867).'年';
	}elseif($year == 1868){
		$jpYear = '明治元年';
	}

	return $jpYear.$md;
}
?>
