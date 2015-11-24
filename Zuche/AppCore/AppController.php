<?php

class AppController extends ModalController {

    public $userModel = null;
    public $current_menu = 'no_1';
    public $user=array();
    function AppController() {
        $this->view = new AppView();
        $this->userModel = $this->getModel("User");
        $this->user=$this->getSession(USER);
        $this->view->assign("user",  $this->user);
        $this->view->assign('msg', $this->getSession('msg', true));
        
        if($this->user['u_type']>0){
            $this->view->assign("adminMenu",$this->code("adminMenu"));
        }
        
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
        if (isset($_SESSION[USER])) {
            $this->redirect("?c=Index&a=login&callback=" . $callback);
        } else {
            return true;
        }
    }

    function password($str) {
        return md5($str);
    }

}
