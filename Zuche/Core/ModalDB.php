<?php

/**
 * Description of ModalDB
 * @copyright (c) xiayuanchaun
 * time 2015-11-19
 * @author xiayuanchuan<772321344@qq.com>
 */
class ModalDB extends Modal {

    var $logType = 'Database';
    var $dsnid = null;
    var $dbo = null;
    var $new = false;

    function ModalDB($dsnid = 1) {
        if (!empty($dsnid)) {
            $this->dsnid = $dsnid;
        }
        if (empty($this->dsnid)) {
            return false;
        }
        $this->dbo = $this->getDBO($this->dsnid, $this->new);
    }

    function formatData($data) {
        $ext = '';

        foreach ($data as $k => $v) {
            // null
            if ($v === null)
                $ext .= "`{$k}` = NULL, ";
            // now()
            elseif (preg_match('/^now\(\)$/i', $v))
                $ext .= "`{$k}` = {$v}, ";
            // operation
            elseif (preg_match('/^' . preg_quote($k) . '[\s]*[\+\-]{1}[\s]*/i', $v))
                $ext .= "`{$k}` = {$v}, ";
            // value
            else
                $ext .= "`{$k}` = '{$v}', ";
        }

        $ext = substr($ext, 0, -2);
        return $ext;
    }

    function buildSelect($table, $select, $where) {
        $sql = '';

        // empty?
        if (empty($select)) {
            return $sql;
        }

        $select = implode('`,`', $select);
        $sql = "SELECT `{$select}` FROM {$table} WHERE TRUE ";

        if (!empty($where)) {
            foreach ($where as $k => $v)
                $sql.= " AND {$k} = '{$v}' ";
        }

        return $sql;
    }

    function buildInsert($table, $data) {
        $sql = '';

        // empty?
        if (empty($data)) {
            return $sql;
        }

        $sql = "INSERT INTO {$table} SET ";
        $sql.= $this->formatData($data);
        return $sql;
    }

    function buildUpdate($table, $data, $where = '') {
        $sql = '';

        // empty?
        if (empty($data)) {
            return $sql;
        }

        if (strpos($table, '.'))
            $sql = "UPDATE {$table} SET ";
        else
            $sql = "UPDATE `{$table}` SET ";

        $sql.= $this->formatData($data);

        if (strlen($where)) {
            $sql.= ' WHERE ' . $where;
        }
        return $sql;
    }

    function buildReplace($table, $data) {
        $sql = '';

        // empty?
        if (empty($data)) {
            return $sql;
        }

        $sql = "REPLACE INTO {$table} SET ";
        $sql.= $this->formatData($data);
        return $sql;
    }

    function buildDelete($table, $where = null) {
        $sql = "DELETE FROM `{$table}`";

        if (strlen($where)) {
            $sql.= ' WHERE ' . $where;
        }

        return $sql;
    }

    function escape(&$var, $quote = false) {
        // escape
        if (is_array($var)) {
            foreach ($var as $k => $v) {
                $this->escape($v);
                $var[$k] = $v;
            }
        } else {
            if (is_null($var) || $quote)
                $var = $this->dbo->qstr($var);
            else
                $var = substr($this->dbo->qstr($var), 1, -1);
        }
    }

    function Insert($table, $data) {
        // empty?
        if (empty($data)) {
            return false;
        }

        // escape
        $this->escape($data);

        if ($rs = $this->Execute($this->buildInsert($table, $data)))
            return $this->dbo->Insert_ID();
        else
            return false;
    }

    function Update($table, $data, $where = '') {
        // empty?
        if (empty($data) || !is_array($data))
            return false;

        // escape
        $this->escape($data);

        if ($rs = $this->Execute($this->buildUpdate($table, $data, $where)))
            return $rs;
        else
            return false;
    }

    function Replace($table, $data) {
        // empty?
        if (empty($data)) {
            return false;
        }

        // escape
        $this->escape($data);

        if ($rs = $this->Execute($this->buildReplace($table, $data)))
            return $rs;
        else
            return false;
    }

    function Delete($table, $where = '') {
        // empty?

        if (empty($where)) {
            return false;
        }

        // escape
        $this->escape($data);

        if ($rs = $this->Execute($this->buildDelete($table, $where)))
            return $rs;
        else
            return false;
    }

    function Execute($sql = "") {
        if (!preg_match("/\;(\s*)$/is", $sql)) {
            $sql .= ";";
        }
        $this->log($sql);

        if ($rs = $this->dbo->Execute($sql)) {
            return $rs;
        } else {
            $msg = $this->dbo->ErrorMsg();
            $this->debug("{$msg}<br>{$sql}", E_USER_ERROR);
            return false;
        }
    }

    function getAll($sql, $field = null) {
        if (!$rs = $this->Execute($sql)) {
            return null;
        }

        // result
        $data = array();

        while ($array = $rs->FetchRow()) {
            $data[] = $array;
        }

        if (is_null($field))
            return $data;
        else
            return $this->unique($data, $field);
    }

    function getOne($sql) {
        if (!$rs = $this->Execute($sql)) {
            return null;
        }

        // result
        $data = null;

        while ($array = $rs->FetchRow()) {
            $data = $array;
            break;
        }

        return $data;
    }

    function getTable($table, $select = null, $where = null) {
        // empty?
        if (empty($select)) {
            $select = array('*');
        }

        // escape
        $this->escape($where);

        // get
        $sql = $this->buildSelect($table, $select, $where);
        return $this->getAll($sql);
    }

    function getTableFields($table) {
        $fields = array();
        if (!$table) {
            return array();
        }

        $rs = $this->getAll("DESC {$table}");
        return $this->unique($rs, 'Field', 'Field');
    }

}
