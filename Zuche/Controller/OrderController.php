<?php

/**
 * Description of OrderController
 * @copyright (c) xiayuanchaun
 * time 2015-11-30
 * @author xiayuanchuan<772321344@qq.com>
 */
class OrderController extends AppController{
    
    function OrderController(){
        $this->AppController();
        //登陆
        $this->isLogin($_SERVER['HOST_NAME'].$_SERVER['REQUEST_URI']);
    }
    function orderAddAction(){
        $carId=  $this->post("carid");
        $orderarr['start_time']=  $this->post('start_time');
        $orderarr['end_time']=  $this->post('end_time');
        $orderarr['o_dec']=  $this->post('o_dec');
        if(!$carId){
            $this->setSession("msg","请选择车型");
            $this->redirect("?c=index&a=index");
        }else{
            $carModel=$this->getModel("Car");
            $carinfo=$carModel->getCarById($carId);
            if(!$carinfo){
                $this->setSession("msg","车型没找到");
                $this->redirect("?c=index&a=index");
            }else{
                $rettimeH=  ceil((strtotime($orderarr['end_time']) - strtotime($orderarr['start_time']))/3600);
                $code=$this->load(EXTEND, "ModalCode");
                $orderarr['price']=$carinfo['price']*$rettimeH;
                $orderarr['car_id']=$carinfo['car_id'];
                $orderarr['car_name']=$carinfo['car_name'];
                $orderarr['u_id']=$this->user['u_id'];
                $orderarr['status']=0;
                
                $orderarr['o_no']=$code->getUuid();
                $orderModel=$this->getModel("Order");
                
                if($orderModel->addOrder($data)){
                    $msg="预约成功";
                    $this->setSession("msg", $msg);
                    $this->view->layout();
                    
                }else{
                    $msg="预约失败，请重新预约";
                    $this->setSession("msg", $msg);
                    $this->redirect($_SERVER['HOST_NAME'].$_SERVER['REQUEST_URI']);
                }
                    $this->setSession("msg","");
                    $this->redirect("?c=index&a=index");
            }

        }
    }
}
