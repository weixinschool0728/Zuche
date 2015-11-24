<?php

function smarty_function_brave_jp_date($params, &$smarty) {
	$jpYear = '';
	$date = $params['date'];
	$year = date('Y', strtotime($date));
	$getYear = $params['getYear'];
	switch ($params['format']) {
		case 'm月d日':
			$md = date('m月d日', strtotime($date));
			break;
		case 'n月j日':
			$md = date('n月j日', strtotime($date));
			break;
		case 'n月':
			$md = date('n月', strtotime($date));
			break;
		default :
			$md = date('m月d日', strtotime($date));
	}

	if ($year > 1988) {
		$jpYear = '平成' . ($year - 1988) . '年';
	} elseif ($year == 1989) {
		$jpYear = '平成元年';
	} elseif ($year > 1925) {
		$jpYear = '昭和' . ($year - 1925) . '年';
	} elseif ($year == 1925) {
		$jpYear = '昭和元年';
	} elseif ($year > 1912) {
		$jpYear = '大正' . ($year - 1912) . '年';
	} elseif ($year == 1912) {
		$jpYear = '大正元年';
	} elseif ($year > 1867) {
		$jpYear = '明治' . ($year - 1867) . '年';
	} elseif ($year == 1867) {
		$jpYear = '明治元年';
	}
	if ($getYear) {
		return $jpYear . $md;
	} else {
		return $md;
	}
}

?>
