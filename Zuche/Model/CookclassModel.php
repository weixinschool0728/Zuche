<?php

/**
 * Description of CaipuModel
 * @copyright (c) xiayuanchaun
 * time 2015-11-8
 * @author xiayuanchuan<772321344@qq.com>
 */
class CookclassModel extends AppModel {

    //put your code here
    var $table = "cookclass";

    function getParClass($cookclass = 0) {
        $sql = "select * from {$this->table} where deleted = 0 and cookclass='{$cookclass}'";
        return $this->getAll($sql);
    }

    function getCookclassById($id = 0) {
        if (!$id) {
            return FALSE;
        }
        $sql = "select * from {$this->table} where deleted =0 and id='{$id}'";
        return $this->getOne($sql);
    }

    function getList($page = 1, $rows = 20, $id = 0) {
        if ($page < 1) {
            return "";
        }
        if (!$id) {//取所有
            $sqlcount = "select count(id) total from caipu where deleted =0 ";
        } else {
            $sqlcount = "select count(id) total from caipu where cookclass in('{$id}') and deleted =0 ";
        }
        $counttemp = $this->getOne($sqlcount);
        $total = $counttemp['total'] ? $counttemp['total'] : 0;
        $start = (int) $page - 1;
        if (!$id) {//取所有
            $sql = "select * from caipu where deleted =0 limit {$start},{$rows}";
        } else {
            $sql = "select * from caipu where cookclass in('{$id}') and deleted =0 limit {$start},{$rows}";
        }
//        echo $sql;
//        die;
        $tngou = $this->getAll($sql);
        return array('total' => $total, 'tngou' => $tngou);
    }

    function getCaipuByname($name, $page = 1, $rows = 20) {
        $start = (int) $page - 1;
        $sql = "select * from caipu where deleted=0 and name like '%{$name}%' order by count desc limit {$start},{$rows} ";
        return $this->getAll($sql);
    }

    function getCaipuByid($id) {
        if (!$id) {
            return false;
        }
        $sql = "select * from caipu where id ='{$id}' and deleted = 0";
        return $this->getOne($sql);
    }

}
