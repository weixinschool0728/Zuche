<?php

class AppValidator extends ModalValidator {

	function AppValidator() {
		$this->BraveDB();
		$this->mansionAdmin = $this->getSession(SESSION_USER);
		$this->mansionId = $this->mansionAdmin['mansion_id'];
	}

	function isValidExt($field, $vars) {
		$data = $this->data[$field];
		if (is_array($data) && $data['error_msg'] == 'file_ext_invalid') {
			return false;
		}

		return true;
	}

	function isValidSize($field, $vars) {
		$data = $this->data[$field];
		if (is_array($data) && $data['error_msg'] == 'file_size_invalid') {
			return false;
		}

		return true;
	}
    
    function isXLS($field, $vars) {
		$data = $this->data[$field];
		if (preg_match('/(xls|xlsx)$/i', $data)) {
			return true;
		}
		return false;
    }

	function fileMoveSucc($field, $vars) {
		$data = $this->data[$field];
		if (is_array($data) && $data['error_msg'] == 'file_move_failure') {
			return false;
		}

		return true;
	}

	function valiTimes($field, $vars) {
		$data = $this->data[$field];
		return is_numeric($data['num']) && $data > 0;
	}

	function validTime($field, $vars) {
		$data = $this->data[$field];
		$currentYear = date("Y");
		if (count($data)) {
			foreach ($data as $time) {
				$startDate = $time['start_date'];
				$endDate = $time['end_date'];
				$startTime = $time['start_time'];
				$endTime = $time['end_time'];
				if ($this->isValidDate($startDate) && $this->isValidDate($endDate) && $this->isValidDatePair($startDate, $endDate)) {
					if ($endTime <= $startTime) {
						return false;
					}
				} else {
					return false;
				}
			}

			$startDateArray = $endDateArray = array();
			foreach ($data as $key => $val) {
				$startDateArray[$key] = $val['start_date'];
				$enddateArray[$key] = $val['end_date'];
			}
			array_multisort($startDateArray, SORT_ASC, $enddateArray, SORT_ASC, $data);

			$compareData = $data;
			foreach ($data as $key => $time) {
				$startDate = $time['start_date'];
				$endDate = $time['end_date'];
				foreach ($compareData as $compareKey => $compareTime) {
					if ($compareKey > $key) {
						$compareStartDate = $compareTime['start_date'];
						if ($compareStartDate <= $endDate) {
							return false;
						}
					}
				}
			}
		}

		return true;
	}

	function valiMailContent($field, $vars) {
		$data = $this->data[$field];
		if (!isset($this->data['send_email'])) {
			if (!preg_match('/\<\%URL\%\>/', $data)) {
				return false;
			}
		} else if ($this->data['send_email'] == 1) {
			if (!preg_match('/\<\%URL\%\>/', $data)) {
				return false;
			}
		}

		return true;
	}

	function isPositiveNumber($field, $vars) {
		$data = $this->data[$field];
		return is_numeric($data) && $data > 0;
	}

	function isDate($field, $vars) {
		$data = $this->data[$field];
		if (preg_match('#^(\d{4})(?:-|/)(\d{1,2})(?:-|/)(\d{1,2})$#', $data, $m)) {
			return checkdate($m[2], $m[3], $m[1]);
		} else {
			return false;
		}
	}

	function isTime($field, $vars) {
		$data = $this->data[$field];
		if (preg_match('#^(\d{1,2}):(\d{1,2})$#', $data, $m)) {
			return (int) $m[1] <= 23 && (int) $m[2] <= 59;
		} else {
			return false;
		}
	}

	function isUserExists($field, $vars) {
		$id = $vars['id'];
		$account = $this->data[$field];
		$id ? $this->escape($id) : null;

		$sql = "SELECT id FROM tb_user 
                WHERE deleted = 0 AND account = '{$account}' AND id != '{$id}'";
		$rs = $this->getOne($sql);
		return $rs['id'] ? false : true;
	}

	function isSix($field, $vars) {
		$data = $this->data[$field];
		$regex = "/1(\d+)00/";
		if (strlen($data) == 6) {
			return preg_match($regex, $data);
		} else {
			return false;
		}
	}

	function isOdrExists($field, $vars) {
		$odr = $this->data[$field];
		$id = $vars['case_id'];
		$sql = "
            SELECT
                odr_no
            FROM
                tb_case_info
            WHERE
                deleted = 0 AND
                odr_no = '{$odr}' AND
                id != '{$id}'
        ";

		$rs = $this->getOne($sql);
		return $rs['odr_no'] ? false : true;
	}

	function isAdminExists($field, $vars) {
		$id = $vars['id'];
		$email = $this->data[$field];
		$id ? $this->escape($id) : null;

		$sql = "SELECT id FROM tb_admin 
    			WHERE deleted = 0 AND email = '{$email}' AND id != '{$id}'";
		$rs = $this->getOne($sql);
		return $rs['id'] ? false : true;
	}
    
    function isManagerExists($field, $vars) {
		$id = $vars['manager_id'];
		$account = $this->data[$field];
		$id ? $this->escape($id) : null;

		$sql = "SELECT manager_id FROM kt_user_manager 
    			WHERE deleted = 0 AND account = '{$account}' AND manager_id != '{$id}'";
		$rs = $this->getOne($sql);
		return $rs['manager_id'] ? false : true;
	}

	function isKeywordExists($field, $vars) {
		$id = $vars['id'];
		$title = $this->data[$field];
		$id ? $this->escape($id) : null;

		$sql = "SELECT id FROM tb_junshu_keyword 
    			WHERE deleted = 0 AND title = '{$title}' AND id != '{$id}'";
		$rs = $this->getOne($sql);
		return $rs['id'] ? false : true;
	}

	function isKeywordkanaExists($field, $vars) {
		$title = $this->data[$field];
		$id = $vars['id'];
		$sql = "
            SELECT
                title_kana
            FROM
                tb_junshu_keyword
            WHERE
                deleted = 0 AND
                title_kana = '{$title}' AND
                id != '{$id}'
        ";

		$rs = $this->getOne($sql);
		return $rs['title_kana'] ? false : true;
	}

	function isHanreiNameExists($field, $vars) {
		$name = $this->data[$field];
		$id = $vars['id'];
		$sql = "
            SELECT
                id
            FROM
                tb_hanrei_info
            WHERE
                deleted = 0 AND
                name = '{$name}' AND
                id != '{$id}'
        ";

		$rs = $this->getOne($sql);
		return $rs['id'] ? false : true;
	}

	function isTsutatsuTitleExists($field, $vars) {
		$title = $this->data[$field];
		$id = $vars['id'];
		$sql = "
            SELECT
                id
            FROM
                tb_tsutatsu_info
            WHERE
                deleted = 0 AND
                title = '{$title}' AND
                id != '{$id}'
        ";

		$rs = $this->getOne($sql);
		return $rs['id'] ? false : true;
	}

	function maxLength($field, $vars) {
		$maxLength = $vars['max_length'];
		return mb_strlen($this->data[$field], "utf-8") <= $maxLength;
	}

	function isNotNull($field, $vars) {
		$data = $this->data[$field];

		if (is_array($data))
			return empty($data) ? false : true;
		else
			return strlen(trim($data)) ? true : false;
	}

	function onlyOnePerMonth($field, $vars){
		$id = (int)$vars['id'];
		$date = date('Y-m', strtotime($this->data[$field]));
		$sql = "SELECT count(*) c 
				FROM tb_calendar
				WHERE `date` like '{$date}%'
				AND id != '{$id}'
				AND deleted = 0";
		$rs = $this->getOne($sql);
		return $rs['c'] == 0;
	}

    function isURL($field,$vars) {
        $url = (string)$this->data[$field];
        return preg_match('/^(http|https|ftp)\:\/\/.*/',$url);
    }
    
    function isKana($field, $vars) {
		$kana = trim($this->data['kana']);
        $first_str = mb_substr($kana, 0, 1,'utf8');
        $code = $this->code('kana');
        if(array_search($first_str, $code) === false){
            return false;
        }
		return true;
	}
}