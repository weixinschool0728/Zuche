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

    function meditAction() {

        $carid = $this->get("carid", 0);
        if ($carid) {
            //编辑  查询后分配页面
            $carModel = $this->getModel("Car");
            $car = $carModel->getCarById($carid);
        }
        //获取分类列表
//        pr($car);

        $this->view->assign("classs", $classs);
        $this->view->assign("car", $car);
        $this->view->assign("car_images", unserialize($car['car_images']));
        $this->view->layout();
    }

    function mDoEditAction() {
        if (!$this->isAdmin()) {
            $this->redirect("index.php");
        }
        $carId = $this->get('carid');
        $carModel = $this->getModel("Car");
        $car = $carModel->getCarById($carId);
        if (empty($car)) {
            $this->redirect("index.php");
        }
        $data['car_name'] = $this->post('car_name');
        $data['car_dec'] = $this->post('car_dec');
        $data['sort'] = $this->post('sort');
        $data['description'] = $this->post('content1');
        $data['price'] = $this->post('price');


        //处理上图片
        $up = $this->load(EXTEND, "ModalUpload");

        $upconfig = array(
            'base' => APP_WEBROOT . 'upload' . DS,
            'fileimages[]' => array(
                'ext' => array('jpg', 'gif', 'png'),
                "base" => APP_WEBROOT . "upload" . DS,
            ),
            'imagehead[]' => array(
                'ext' => array('jpg', 'gif', 'png'),
                "base" => APP_WEBROOT . "upload" . DS,
            ),
        );
        $up->upload($upconfig);
        $images = array_merge(unserialize($car['car_images']), $this->uploadFiles("fileimages"));
        $data['car_images'] = serialize($images);
        $imagehead = $this->uploadFiles("imagehead");
        if (count($imagehead)) {
            $data['car_head'] = $imagehead[0];
        }

        if ($carModel->UpdateCar("car_id={$carId}", $data)) {
            $this->setSession("msg", "修改成功");
        } else {
            $this->setSession("msg", "修改失败");
        }
        $this->redirect("?c=Car&a=mindexlist");
    }

    function uploadFiles($postKey) {
        $count = count($_FILES[$postKey]['name']);
        $filenamearr = array();
        for ($i = 0; $i < $count; $i++) {
            if ($_POST[$postKey][$i]) {
                $filenamearr[$i] = APP_UPLOAD . $_POST[$postKey][$i];
            }
        }return $filenamearr;
    }

    //管理端 删除
    function moptionAction() {
        $carModel = $this->getModel("Car");
        $id = $this->get("carid", 0);
        $data = array("deleted" => 1);
        $where = "deleted=0 and car_id={$id}";
        if ($carModel->UpdateCar($where, $data)) {
            $return = array("status" => 1);
        } else {
            $return = array("status" => 0);
        }
        echo json_encode($return);
    }

    function imageajaxdelAction() {
        $id = $this->get('id', 0);
        $imageurl = $this->post('imgurl');
//       var_dump($_POST);
        $carModel = $this->getModel("Car");
        $cararr = $carModel->getCarById($id);
        $cararr['car_images'] = unserialize($cararr['car_images']);
        if (preg_match("/^\/.*/is", $imageurl)) {
            $imageurlunlink = "." . $imageurl;
        } else {
            $imageurlunlink = $imageurl;
        }
        if (file_exists($imageurlunlink)) {
            @unlink($imageurlunlink);

            $key = array_search($imageurl, $cararr['car_images']);
            if ($key != false) {
                array_splice($cararr['car_images'], $key, 1);
            }

            $data['car_images'] = serialize($cararr['car_images']);
            $carModel->UpdateCar("car_id={$id}", $data);
            echo json_encode(array('status' => true));
            exit;
        } else {
            $key = array_search($imageurl, $cararr['car_images']);
            if ($key != false) {
                array_splice($cararr['car_images'], $key, 1);
            }

            $data['car_images'] = serialize($cararr['car_images']);
            $carModel->UpdateCar("car_id={$id}", $data);
            echo json_encode(array('status' => false));
            exit;
        }
    }

}

?>