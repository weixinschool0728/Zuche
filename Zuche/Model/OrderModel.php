<?php

/**
 * Description of OrderModel
 * @copyright (c) xiayuanchaun
 * time 2015-11-30
 * @author xiayuanchuan<772321344@qq.com>
 */
class OrderModel extends AppModel{
    var $table="tb_order";
    function addOrder($data){
        if(!is_array($data) || !$data){
            return false;
        }
        $data['created']=NOW;
        return $this->Insert($this->table, $data);
    }
    function getOrderList($sh = null) {


        $this->setSearch($sh);
        $sql = "select * from {$this->table}"
            . " where deleted =0 ";
        $this->paging('paging.admin');
        $res = $this->paginate($sql);
        return $res;
    }

}
