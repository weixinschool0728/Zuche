<?php

/**
 * Description of ClassController
 * @copyright (c) xiayuanchaun
 * time 2015-11-30
 * @author xiayuanchuan<772321344@qq.com>
 */
class ClassController extends AppController{
    var $classModel;
    function ClassController(){
        $this->AppController();
        $this->classModel=  $this->getModel("Class");
    }
    function getClassApiAction(){
        
        $pid=$this->post("pid",0);
        $data=  $this->classModel->getCLassByPid($pid);
        echo json_encode($data);
    }
}
