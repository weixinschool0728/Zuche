<?php

class AppController extends ModalController {

    public $userModel = null;
    public $current_menu = 'no_1';
    public $user = array();

    function AppController() {
        $this->view = new AppView();
        $this->userModel = $this->getModel("User");
        $this->user = $this->getSession(USER);
        $this->view->assign("user", $this->user);
        $this->view->assign('msg', $this->getSession('msg', true));
        $this->view->assign('msg_title', $this->getSession('msg_title', true));
        //获取菜单
        $this->setMenu();
        $this->setCode();


//        $this->view->assign('msg_title', $this->getSession('msg_title', ture));
//        $this->view->assign('msg_ok', $this->getSession('msg_ok', ture));
//        $this->view->assign('msg_url', $this->getSession('msg_url', ture));
//        $this->view->assign('msgConfig', $this->getSession('msgConfig', ture));
//
//        $this->view->assign("copyYear", date("Y"));
//        $this->view->assign('user', $this->user);
    }

    public function layout($tpl = null) {
        $this->view->assign('current_menu', $this->current_menu);
        $this->view->layout($tpl);
    }

    function setCode($key = null) {
        $code = $this->code($key);
        $this->view->assign('code', $code);
    }

    /**
     * set Response
     */
    function setResponse(&$response) {
        $this->response = $response;
    }

    function isLogin($callback = "") {
        if ($callback) {
            $callback = urlencode($callback);
        }
        if (!isset($_SESSION[USER])) {
            $this->redirect("?c=Index&a=login&callback=" . $callback);
        } else {
            return true;
        }
    }

    function isAdmin() {
        if (!isset($_SESSION[USER]) || $_SESSION[USER]['u_type'] < 1) {
            $this->redirect("?c=Index&a=login&callback=" . $callback);
        } else {
            return true;
        }
    }

    function password($str) {
        return md5($str);
    }

    function setMenu() {
        $classfilename = "./classmenu.json";

        if (file_exists($classfilename)) {
            $classtem = json_decode(file_get_contents($classfilename), true);
            if (time() - $classtem['time'] > 1800) {

                $classModel = $this->getModel("Class");
                $classsArr = $classModel->getClassList();
                $classArrTree = $this->getTrees($classsArr, array('c_id', "p_id", "name"));
                $classfile = array('time' => time(), "classArrTree" => $classArrTree);
                file_put_contents($classfilename, json_encode($classfile));
            } else {
                $classArrTree = $classtem['classArrTree'];
            }
        } else {
            $classModel = $this->getModel("Class");
            $classsArr = $classModel->getClassList();
            $classArrTree = $this->getTrees($classsArr, array('c_id', "p_id", "name"));
            $classfile = array('time' => time(), "classArrTree" => $classArrTree);
            file_put_contents($classfilename, json_encode($classfile));
        }
        $this->view->assign("classArrTree", $classArrTree);
        if ($this->user['u_type'] > 0) {
            $this->view->assign("adminMenu", $this->code("adminMenu"));
        }
    }

    function getTree($items, $fields = array('c_id', 'p_id')) {
        foreach ($items as $item)
            $items[$item[$fields[1]]]['son'][$item[$fields[0]]] = &$items[$item[$fields[0]]];
        return isset($items[0]['son']) ? $items[0]['son'] : array();
    }

    function pr($var) {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    function getTrees($data, $fileds = array('c_id', "p_id", "name")) {
        foreach ($data as $value) {
            $json_data[$value[$fileds[0]]] = array($fileds[0] => $value[$fileds[0]], $fileds[2] => $value[$fileds[2]], $fileds[1] => $value[$fileds[1]]);
        }
        foreach ($json_data as $v) {
            unset($json_data[$v[$fileds[0]]][$fileds[1]]);
            if ($v[$fileds[1]] != 0) {
                $json_data[$v[$fileds[1]]]['son'][] = $json_data[$v[$fileds[0]]];
                unset($json_data[$v[$fileds[0]]]);
            }
        }
        ksort($json_data);
        return $json_data;
    }

}
