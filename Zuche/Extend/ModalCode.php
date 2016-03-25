<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BraveUuid
 * www.aixianxing.com
 * @author xiaxiaxia
 */
class ModalCode {

    private $code = "";
    private $uuid = "";

    //随机数生成串生成
    function createRandom($length = 8) {
        $str = "qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKLZXCVBNM23456789";
        $tempstr = "";
        for ($i = 0; $i < $length; $i++) {
            $tempstr.=$str{rand(0, strlen($str) - 1)};
        }
        return $tempstr;
    }

    //处理email;
    function getEmail($email) {
        if (empty($email)) {
            return false;
        }
        $email = trim($email);
       return strtolower($email);
        
    }

    function createUuid($length = 8) {
        $rand = $this->createRandom($length);
        $mic = microtime(true);
        return md5($rand . $mic);
    }

    function getUuid() {
        if (!$this->uuid) {
            return $this->createUuid(8);
        }
        return $this->uuid;
    }

    function getCode($email, $length = "8") {
        if (!$this->uuid) {
            $this->uuid = $this->createUuid($length);
        }
        $email = $this->getEmail($email);
        $email = mb_convert_encoding($email, 'UTF-8');
        $email = md5($email);

        return $email . $this->uuid;
    }

}
