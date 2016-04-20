<?php

/**
 * Description of catModel
 * @copyright (c) xiayuanchaun
 * time 2015-11-27
 * @author xiayuanchuan<772321344@qq.com>
 */
class CarModel extends AppModel {

    //put your code here
    var $table = "tb_car";

    function getCarbyClass($classId = 0, $sh = null, $isAll = true) {
        $this->setSearch($sh);

        if ($classId == 0) {
            $sql = "select * from {$this->table}"
                    . " where deleted =0 ";
        } else {
            $sql = "select * from {$this->table}"
                    . " where deleted =0 and c_id='{$classId}' ";
        }
        $this->order($sql, 'order.car');
        $this->paging('paging.admin');
        if ($isAll) {
            $res = $this->getAll($sql);
        } else {
            $res = $this->paginate($sql);
        }
        return $res;
    }

    public function getCarById($carId = 0) {

        $sql = "select * from {$this->table}"
                . " where deleted =0 and car_id= '{$carId}' limit 1";
        return $this->getOne($sql);
    }
    
    public function getCar($sh){
        
        $this->setSearch($sh);
        $sql = "select * from {$this->table}"
                . " where deleted =0 ";
        $this->paging('paging.admin');
        $res = $this->paginate($sql);
        return $res;
    }
    
    public function UpdateCar($where,$data){
        return $this->Update($this->table, $data,$where);
    }
    public function InsertCar($data){
        
        return $this->Insert($this->table, $data);
    }

}
