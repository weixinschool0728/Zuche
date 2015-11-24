<?php

/**
 * Description of GetCookClassModel
 * @copyright (c) xiayuanchaun
 * time 2015-11-7
 * @author xiayuanchuan<772321344@qq.com>
 */
class GetCookClassModel extends AppModel {

    //put your code here
    var $table = "cookclass";

    function insertParClass($data) {
        //先查询id  有就更新   没有就插入
        if (!is_array($data) || !$data) {
            return FALSE;
        }
        if ($this->getCCByid($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            return $this->Update($this->table, $data, " id ='{$id}'");
        } else {
            $data['created'] = NOW;
            $data['deleted'] = 0;
            return $this->Insert($this->table, $data);
        }
    }

    function getCCByid($id) {
        if (!$id) {
            return false;
        }
        $sql = "select * from {$this->table} where id ='{$id}' and deleted = 0";
        return $this->getOne($sql);
    }

    function getCCListBypid($pid = 0) {
        $sql = "select * from {$this->table} where cookclass ='{$pid}' and deleted = 0";
        return $this->getAll($sql);
    }

    /*     * ***根据子类来获取菜谱 */

    function countClass() {
        $sql = "select count(id) count from {$this->table} where deleted =0 and cookclass!=0";
//        $sql = "select count(id) count from {$this->table} where deleted =0 and cookclass!=0";
        return $this->getOne($sql);
    }

    function getClasschild($start = 0, $per = 10) {
        $sql = "select * from {$this->table} where deleted =0 and cookclass!=0 " . " limit {$start},{$per} ";
        return $this->getAll($sql);
    }
    
    function insertCaipu($data,$cookclass=0) {
        //先查询id  有就更新   没有就插入
        if (!is_array($data) || !$data) {
            return FALSE;
        }
        $data['cookclass']=$cookclass;
        if ($this->getCaipuByid($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            return $this->Update("caipu", $data, " id ='{$id}'");
        } else {
            $data['created'] = NOW;
            $data['deleted'] = 0;
            return $this->Insert("caipu", $data);
        }
    }
    
    function updataCaipu($data,$id){
        if(!is_array($data) || !$id){
            return false;
        }
        unset($data['id']);
        return $this->Update("caipu", $data, " id ='{$id}'");
    }
    function getCaipuByid($id){
         if (!$id) {
            return false;
        }
        $sql = "select * from caipu where id ='{$id}' and deleted = 0";
        return $this->getOne($sql);
    }
    
    
        function countCaipu() {
        $sql = "select count(id) count from caipu where deleted =0";
//        $sql = "select count(id) count from {$this->table} where deleted =0 and cookclass!=0";
        return $this->getOne($sql);
    }

    function getCaipuListBypage($start = 0, $per = 10) {
        $sql = "select * from caipu where deleted =0 " . " limit {$start},{$per} ";
        return $this->getAll($sql);
    }

}
