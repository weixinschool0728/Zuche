<?php

class IndexController extends AppController {

    var $adminModel = null;

    function IndexController() {
        $this->AppController();
//		$this->adminModel = $this->getModel('Admin');
    }

    function indexAction() {
        $this->view->layout('index');
//        $this->view->display();
    }

    function LoginAction() {
        $user = $this->post();
        $callback = $this->get('callback');
        $callback = $callback ? $callback : urlencode("?c=index&a=index");
        if ($user) {
            //处理登陆信息

            $users = $this->userModel->getUserByEmail($user['name']);

            if (!$users) {
                $msg="用户名错误";
                $this->setSession("msg", $msg);
                $this->redirect("?c=index&a=login&callback=" . $callback);
            } else {
                if ($users['password'] == $this->password($user['pass'])) {
                    $msg="登陆成功";
                    unset($users['password'], $users['created']);
                    $this->setSession(USER, $users);
                    $this->userModel->UpdateUser(array('updated' => NOW), $users['u_id']);
                    $this->setSession("msg", $msg);
                    $this->redirect(urldecode($callback));
                } else {
                    $msg= "密码错误";
                    $this->setSession("msg", $msg);
                    $this->redirect("?c=index&a=login&callback=" . $callback);
                }
            }
             
        } else {
            $this->view->display();
        }
    }
    
    function logoutAction(){
        $this->unsetSession(USER);
        $this->redirect("?c=index&a=index");
    }

}

?>