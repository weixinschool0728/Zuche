<?php

class AppView extends ModalView {

	function layout($tpl = null) {
		$loginAdmin = $this->getSession(SESSION_USER);
		$this->assign('loginAdmin', $loginAdmin);

		$this->assign('time', date('Y年n月d日'));
		$layout['main'] = $this->fetch($tpl);

//		$this->assign('menu', $this->menu());
		$layout['menu'] = $this->fetch('Common.menu');

		$this->autoAssign($layout);
		$this->display('Layout.default');
	}

	function layoutThickbox($tpl = null) {
		$layout['main'] = $this->fetch($tpl);

		$this->autoAssign($layout);
		$this->display('Layout.thickbox');
	}

	function layoutWindow($tpl = null) {
		$layout['main'] = $this->fetch($tpl);

		$this->autoAssign($layout);
		$this->display('Layout.window');
	}

	function layoutLogin($tpl = null) {
		$layout['main'] = $this->fetch($tpl);
		$this->autoAssign($layout);
		$this->display('Layout.login');
	}

	function layoutIndex($tpl = null) {
		$this->assign('login', $this->getSession(SESSION_USER));
		$layout['main'] = $this->fetch($tpl);

		$this->autoAssign($layout);
		$this->display('Layout.defaultIndex');
	}

	function display($tpl = null) {
		$tpl = $this->format($tpl);
		$this->assign('page', $this->page);
		$this->assign('css', $this->css);
		$this->assign('js', $this->js);
		$this->assign('data', $this->data);
		$this->smarty->display($tpl);
	}

}

?>
