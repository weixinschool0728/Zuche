<?php

class IndexController extends AppController {

    var $adminModel = null;

    function IndexController() {
        $this->AppController();
//		$this->adminModel = $this->getModel('Admin');
    }

    function indexAction() {
        $sh = $this->get("sh");
		$this->view->assign('sh', $sh);
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
    
    function ajaxuploadimgAction() {

        $img = trim($_POST["filename"]);
        if(empty($img)){
            echo json_encode(array("url"=>"",  'status' => "false"));
            exit;
        }
        $img = str_replace("data:image/png;base64,", "", $img);
        $img = str_replace(" ", "+", $img);
        $imgdata = base64_decode($img);
        $getupload_dir = "/assets/voteimg/" . date("Ymd");
        $upload_dir = "." . $getupload_dir;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 511, true);
        }

        $newfilename = "voteimg_" . date("YmdHis") . uniqid() . ".jpg";
        $save = file_put_contents($upload_dir . "/big_" . $newfilename, $imgdata);
        $returns = array(
            "url" => $upload_dir . "/big_" . $newfilename,
            'status' => "success",
        );
        echo json_encode($returns);
        exit;
    }

}

?>