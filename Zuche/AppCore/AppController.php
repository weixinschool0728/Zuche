<?php

class AppController extends ModalController {

    public $oAuthExtend = null;
    public $user = null;
    public $access_token = null;
    public $userModel = null;
    public $sep = "\n";
    public $response = null;
    public $current_menu = 'no_1';
    public $domain = '';

    function AppController() {
//        $this->view = new AppView();
//
//
//
//        $this->view->assign('msg', $this->getSession('msg', ture));
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

}
