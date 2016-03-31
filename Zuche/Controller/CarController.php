<?php

class CarController extends AppController {

    var $adminModel = null;

    function CarController() {
        $this->AppController();
//		$this->adminModel = $this->getModel('Admin');
    }

    /**
     * 首页的车展示
     */
    function indexAction() {

        $carModel = $this->getModel("Car");
        $carId = $this->get("carid", 1);
        $cararr = $carModel->getCarById($carId);
        $cararr['car_images'] = unserialize($cararr['car_images']);
        $this->view->assign('car', $cararr);
//        var_dump($cararr);
        $this->view->layout();
    }

    function addCarAction() {
        
    }

    //管理端
    function mindexlistAction() {
        if (!$this->isAdmin()) {
            $this->redirect("index");
        }
        $carModel = $this->getModel("Car");
        $sh = $this->get("sh");
        $cararr = $carModel->getCar($sh);
        $this->view->assign('paging', $carModel->paging);
        $this->view->assign('car', $cararr);
        $this->view->layout();
    }
    //管理端修改 添加
    
    function meditAction(){
        
        $carid=  $this->get("carid",0);
        if($carid){
            //编辑  查询后分配页面
            $carModel = $this->getModel("Car");
            $car=$carModel->getCarById($carid);
        }
        //获取分类列表
//        pr($car);
        
        $this->view->assign("classs",$classs);
        $this->view->assign("car",$car);
        $this->view->layout();
    }
    function mDoEditAction(){
        if (!$this->isAdmin()) {
            $this->redirect("index");
        }
        
        pr($_POST);
    }
    
    
    //管理端 删除
    function moptionAction() {
        $carModel = $this->getModel("Car");
        $id=$this->get("carid",0);
        $data = array("deleted" => 1);
        $where = "deleted=0 and car_id={$id}";
        if ($carModel->UpdateCar($where, $data)) {
            $return = array("status" => 1);
        } else {
            $return = array("status" => 0);
        }
        echo json_encode($return);
    }

}

?>