<?php

class IndexController extends AppController {

    var $adminModel = null;

    function IndexController() {
        $this->AppController();
//		$this->adminModel = $this->getModel('Admin');
    }

    function indexAction() {
        $sh = $this->get("sh");
        $carModel = $this->getModel("Car");
        $classId = $this->get("classid", 0);

        $carList = $carModel->getCarbyClass($classId, $sh, false);

        $this->view->assign('paging', $carModel->paging);
        $this->view->assign('carList', $carList);

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
                $msg = "用户名错误";
                $this->setSession("msg", $msg);
                $this->redirect("?c=index&a=login&callback=" . $callback);
            } else {
                if ($users['password'] == $this->password($user['pass'])) {
                    $msg = "登陆成功";
                    unset($users['password'], $users['created']);
                    $this->setSession(USER, $users);
                    $this->userModel->UpdateUser(array('updated' => NOW), $users['u_id']);
                    $this->setSession("msg", $msg);
                    $this->redirect(urldecode($callback));
                } else {
                    $msg = "密码错误";
                    $this->setSession("msg", $msg);
                    $this->redirect("?c=index&a=login&callback=" . $callback);
                }
            }
        } else {
            $this->view->display();
        }
    }

    function logoutAction() {
        $this->unsetSession(USER);
        $this->redirect("?c=index&a=index");
    }

    function registerAction() {
        $register = $this->post();
        if (!$register) {
            $this->view->display();
        } else {
//            var_dump($register);
            $msg = "";
            if (!$register['email']) {
                $msg = "邮箱不能为空";
            } else if (!$register['name']) {
                $msg = "用户名不能为空";
            } else if (!$register['pass']) {
                $msg = "密码不能为空";
            } else if ($register['pass'] != $register['passre']) {
                $msg = "密码不一致";
            }

            if ($msg) {
                $this->setSession("msg", $msg);
                $this->view->display("register");
            } else {
                $userModel = $this->getModel("User");
                if ($userModel->getUserByEmail($register['email'])) {
                    $this->setSession("msg", "邮箱已存在");
                    $this->view->display("register");
                }else{
                    $data['name']=$register['name'];
                    $data['email']=$register['email'];
                    $data['phone']=$register['phone'];
                    $data['password']=  $this->password($register['pass']);
                    $res=$userModel->addUser($data);
                }

                $this->setSession("msg", "注册成功");
                $this->redirect("?c=index&a=index");
            }
        }
    }

}

?>