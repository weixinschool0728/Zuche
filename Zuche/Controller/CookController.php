<?php

/**
 * Description of ApiClassController
 * @copyright (c) xiayuanchaun
 * time 2015-11-8
 * @author xiayuanchuan<772321344@qq.com>
 */
class CookController extends AppController {

    var $cookclassModel = "";
    var $returns = array();

    function CookController() {
        $this->AppController();
        $this->cookclassModel = $this->getModel("Cookclass");
    }

    /**
     * 获取分类
     */
    function classifyAction() {
        $classId = $this->post('id');
//        $classId=  $this->get('id');
        if (!$classId) {
            //返回所有一级分类
            $this->returns = $this->cookclassModel->getParClass();
        } else {
            $this->returns = $this->cookclassModel->getParClass($classId);
        }
        echo json_encode($this->returns);
        die;
    }

    function listAction() {
        $page = $this->post('page', 1);
        $rows = $this->post('rows', 20);
        $id = $this->post('id');
        if ($id < 0 || $page <= 0 || $rows < 0) {
           echo json_encode($this->returns);
            die;
        }
        if ($id) {
            $cookclassTemp = $this->cookclassModel->getCookclassById($id);
            if ($cookclassTemp) {
                if ($cookclassTemp['cookclass'] == 0) {
                    $classArr = $this->cookclassModel->getParClass($id);

                    foreach ($classArr as $classs) {
                        $ids[] = $classs['id'];
                    }
                    $ids[] = $id;
                    $id = implode("','", $ids);
                }
            }
        }
        $this->returns = $this->cookclassModel->getList($page, $rows, $id);
        echo json_encode($this->returns);
        die;
    }

    /*     * *
     * 通过名字获取菜谱
     */

    function nameAction() {
        $name = $this->post("name");
        $page = $this->post("page", 1);
        $rows = $this->post("rows", 20);

        if (!$name || $page <= 0 || $rows < 0 || empty($rows)) {
           echo json_encode($this->returns);
            die;
        }

        echo json_encode($this->cookclassModel->getCaipuByname($name, $page, $rows));
        die;
    }

    function showAction() {
        $id = $this->post("id", 1);
        if ($id < 0 || empty($id)) {
           echo json_encode($this->returns);
            die;
        }
        echo json_encode($this->cookclassModel->getCaipuByid($id));
        die;
    }

}
