<?php

/**
 * Description of ClassModel
 * @copyright (c) xiayuanchaun
 * time 2015-11-26
 * @author xiayuanchuan<772321344@qq.com>
 */
class ClassModel extends AppModel {

    var $table = "tb_class";

    function getPrent() {
        $sql = "select name,c_id,p_id from {$this->table} where deleted=0 and p_id=0 order by tuijian desc,sort";
        return $this->getAll($sql);
    }

    function getClassList() {
        $sql = "select name,c_id,p_id from {$this->table} where deleted=0 order by tuijian desc,sort";
        return $this->getAll($sql);
    }

    function getClassById(int $classId) {
        $sql = "select * from {$this->table} where deleted=0 and c_id={$classId} limit 1";
        return $this->getOne($sql);
    }
    
    function getCLassByPid($pid=0){
        $sql="select * from {$this->table} where deleted=0 and p_id={$pid}";
        return $this->getAll($sql);
    }

}
