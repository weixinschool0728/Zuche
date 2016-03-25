<?php

/**
 * Description of UserModel
 * @copyright (c) xiayuanchaun
 * time 2015-11-24
 * @author xiayuanchuan<772321344@qq.com>
 */
class UserModel extends AppModel {

    var $table = "tb_user";

    /**
     * 
     * @param type $type -1所有 0 前台用户 1 管理员
     * @param type $all  array('start'=>0,'limit'=>'10')
     */
    function getUserList($type = -1, $all = false) {
        $sql = " select * from {$this->table} where deleted=0 ";
        if ($type > -1) {
            $sql.=" and u_type='{$all}' ";
        }
        if (is_array($all)) {
            $sql.= "limit {$all['start']},{$all['limit']} ";
        }
        return $this->getAll($sql);
    }

    function getUserByEmail($email) {
        if (!$email) {
            return FALSE;
        }
        $sql = "select * from {$this->table} where email='{$email}' and deleted =0 limit 1";

        return $this->getOne($sql);
    }

    function updateUser($data, $id = 0) {
        if (!preg_match("/\d+/i", $id) || !is_array($data)) {
            return false;
        }
        return $this->Update($this->table, $data, "u_id");
    }

    function addUser($data = array()) {

        if (!is_array($data)) {
            return false;
        }
        $data['created'] = NOW;
        return $this->Insert($this->table, $data);
    }

}
