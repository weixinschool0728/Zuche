<?php

class AppModel extends ModalModel {

    var $mansionId;
    var $mansionAdmin;
    var $log_file_name = 'upload_icon';
    var $_cookieFileLocation = 'cookie.txt';

    public function AppModel() {
        $this->ModalDB();
    }

    public function mytrim(&$mix) {
        if (is_string($mix)) {
            $mix = trim($mix);
        } elseif (is_array($mix)) {
            foreach ($mix as $key => &$val) {
                $this->mytrim($val);
            }
        }
    }

    public function jpYear2CalendarYear($yearStr = '') {
        if (!$yearStr) {
            return '0000-00-00';
        }

        $search = array(
            '０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
            '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9'
        );
        $keys = array_keys($search);
        $vals = array_values($search);
        $yearStr = str_replace($keys, $vals, $yearStr);
        $yearStr = trim($yearStr);
        preg_match('/^(明治|大正|昭和|平成)([\d]+|元)年([\d]+月)?([\d]+日)?/', $yearStr, $match);
        $num = $match[1];
        $year = $match[2];
        $month = str_replace('月', '', $match[3]);
        $day = str_replace('日', '', $match[4]);

        $y = $m = $d = '';
        switch ($num) {
            case '明治':
                $y = ($year == '元' || $year == '0') ? 1868 : (1868 + $year - 1);
                break;
            case '大正';
                $y = ($year == '元' || $year == '0') ? 1912 : (1912 + $year - 1);
                break;
            case '昭和';
                $y = ($year == '元' || $year == '0') ? 1926 : (1926 + $year - 1);
                break;
            case '平成';
                $y = ($year == '元' || $year == '0') ? 1989 : (1989 + $year - 1);
                break;
            default:
                break;
        }
        if (!$y) {
            return '0000-00-00';
        }

        $str = $y . '-';
        if ($month) {
            $str = $str . str_pad($month, 2, '0', STR_PAD_LEFT) . '-';
            if ($day) {
                $str = $str . str_pad($day, 2, '0', STR_PAD_LEFT);
            } else {
                $str = $str . '01';
            }
        } else {
            $str = $str . '01-01';
        }

        return $str;
    }

    //http request
    public function httpRequest($url, $params = array(), $request = 'GET', $is_cookie = false) {
        $search = array();
        foreach ($params as $k => $v) {
            $search[] = "{$k}=" . urlencode($v);
        }
        if ($request == 'GET') {
            $url .= (strpos($url, "?") ? "&" : '?') . implode("&", $search);
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'rw+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
//		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/x-www-form-urlencoded; charset=UTF-8"));

        if ($is_cookie == true) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, APP_WEBROOT . $this->_cookieFileLocation);
            curl_setopt($ch, CURLOPT_COOKIEFILE, APP_WEBROOT . $this->_cookieFileLocation);
        }

        if ($request == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        } else if ($request == 'PUT') {
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&", $search));
        } else if ($request == 'DELETED') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETED');
            curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&", $search));
        }

        $output = curl_exec($ch);
        !rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        $this->log($verboseLog, 'memo_api_log');
        if (curl_errno($ch)) {
            $this->log("CURL_ERROR_CODE:" . curl_error($ch), $this->log_file_name);
            curl_close($ch);
            return false;
        }
        $info = curl_getinfo($ch);
        if ($info['http_code'] != '200') {
            switch ($info['http_code']) {
                case 400:
                    $error = 'リクエストパラメータ不正';
                    break;
                case 404:
                    $error = 'リクエストURI不正';
                    break;
                case 405:
                    $error = 'HTTPメソッド不正';
                    break;
                case 500:
                    $error = 'サーバ内部エラー';
                    break;
            }
            $error = "request return status:  {$info['http_code']} {$error}";
            $this->log($error, $this->log_file_name);
            curl_close($ch);
            fclose($verbose);
            return false;
        }
        curl_close($ch);
        fclose($verbose);
        return $output;
    }

    function insertBatch($data, $table, $replace = false, $is_ignore = false) {
        if (count($data) < 1 || empty($table)) {
            return true;
        }
        $ignore = '';
        if ($is_ignore) {
            $ignore = 'IGNORE';
        }
        $sql = ($replace ? "REPLACE INTO " : "INSERT {$ignore} INTO ") . " {$table} ";
        $i = 0;
        foreach ($data as $value) {
            $i++;
            if ($i == 1) {
                $sql .= "(`" . implode("`,`", array_keys($value)) . "`) VALUES";
            }
            $sql .= ($i == 1 ? "" : ",") . "('" . implode("','", $value) . "')";
        }
//		echo $sql;die;
        $rs = $this->Execute($sql);
        return $rs;
    }

    function sendEmailInsert($sendto, $data, $tpl = "register", $user_id = 0, $se_id = 0) {
        if (!$sendto) {
            return false;
        }

        $emailData = array(
            'created' => NOW,
            "deleted" => 0,
            'status' => 1,
            "user_id" => $user_id, #
            'data' => serialize($data),
            'tpl' => $tpl,
            'send_to' => $sendto,
        );

        $sendMail = $this->load(EXTEND, "BraveMailer");
        if (!$sendMail->sendmail($sendto, $tpl, $data)) {
            $emailData['status'] = 0;
        }
        $res['se_id'] = 0;
        if ($se_id) {
            $res['se_id'] = $se_id;
        } 
//        else {
//
//            $sql = "select se_id from tb_send_email where deleted=0 and tpl='{$tpl}' and send_to='" . $sendto . "'";
//            $res = $this->getOne($sql);
//        }
        
        if ($res['se_id']) {

            unset($emailData['se_id'], $emailData['created']);
            $where = " deleted=0 and se_id='" . $res['se_id'] . "'";
            $this->Update("tb_send_email", $emailData, $where);
        } else {
            $this->Insert("tb_send_email", $emailData);
        }
    }

}
