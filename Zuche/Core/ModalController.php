<?php

/**
 * Description of ModalController
 * @copyright (c) xiayuanchaun
 * time 2015-11-19
 * @author xiayuanchuan<772321344@qq.com>
 */
class ModalController extends Modal{
    var $actionPostfix = 'Action';
    var $data = null;
    var $view = null;
    
    function getPky($name = DOMAIN_PKY_NAME, $radom = DOMAIN_PKY_RADOM) {
		$time = time();
		$cipher = DOMAIN_PKY_CIPHER;
		$vector = DOMAIN_PKY_VECTOR;
		$string = "{$time},{$name},{$radom}";
		$size = mcrypt_get_block_size(MCRYPT_BLOWFISH, 'cbc');
		$string = $this->pkcs5Pad($string, $size);

		$td = mcrypt_module_open(MCRYPT_BLOWFISH, '', 'cbc', '');
		mcrypt_generic_init($td, $cipher, $vector);
		$data = mcrypt_generic($td, $string);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return bin2hex($data);
	}

	function pkcs5Pad($string, $size) {
		$pad = $size - (strlen($string) % $size);
		return $string . str_repeat(chr($pad), $pad);
	}
    
    function hasAction($name) {
        $name.= $this->actionPostfix;
        return method_exists($this, $name);
    }

    function setData($data, $key = null) {
        if (is_null($key))
            $this->data = $data;
        else
            $this->setValue($this->data, $key, $data);

        global $page;
        
        if (!isset($this->data['page'])) {
            $this->data['page'] = $page;    
        }
        
        if ($this->view) {
            $this->view->setData($this->data);
        }
    }

    function execAction($name) {
        $actionName = $name . $this->actionPostfix;
        $this->$actionName();
    }

    function forward($forward, $data = null) {
        $dispatcher = $this->getGlobal('BraveDispatcher');
        $dispatcher->dispatch($forward, $data);
    }

    function isConfirm() {
        return $this->isPost('confirm');
    }
    
    function isComplete() {
        return $this->isPost('complete');
    }
    
    function execJs($js = '') {
    	if (!$js) {
    		return;
    	}
    	
    	$js = '<script type="text/javascript">' . $js . '</script>';
    	echo $js;
    }
}
