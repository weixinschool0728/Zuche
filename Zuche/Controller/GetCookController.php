<?php

/**
 * Description of GetCookController
 * @copyright (c) xiayuanchaun
 * time 2015-11-7
 * @author xiayuanchuan<772321344@qq.com>
 */
class GetCookController extends AppController {

    //put your code here
    var $getCookClassModel = '';
    var $tgapiurl = "http://www.tngou.net";
    var $tgimgurl = "http://tnfs.tngou.net/image";
    var $tgimageurl2 = "http://tnfs.tngou.net/img";

    function GetCookController() {
        set_time_limit(0);
        $this->AppController();
        $this->getCookClassModel = $this->getModel("GetCookClass");
    }

    function getparClassAction() {
        $url = $this->tgapiurl . "/api/cook/classify";
        $res = $this->httpsPost($url, $data);
        var_dump($res);
        foreach ($res as $value) {
            $this->getCookClassModel->insertParClass($value);
        }
    }

    function getClassAction() {
        $parCookArr = $this->getCookClassModel->getCCListBypid();
        $url = $this->tgapiurl . "/api/cook/classify";
        foreach ($parCookArr as $valuep) {
            $res = $this->httpGet($url, array('id' => $valuep['id']));
            foreach ($res as $value2) {
                $this->getCookClassModel->insertParClass($value2);
            }
        }
    }

    function getCaipuAction() {
        $url = $this->tgapiurl . "/api/cook/list";
        $postData = array("rows" => 1, "id" => "");
        $countArr = $this->getCookClassModel->countClass();
        $count = $countArr['count'];
        $per = 10;
        $pages = ceil($count / $per);
        for ($i = 0; $i < $pages; $i++) {
            $classArr = $this->getCookClassModel->getClasschild($i, $per);
            //请求 获得该分类下的数据   
            foreach ($classArr as $key => $class) {
                $postData['id'] = $class['id'];
                $catputemp = $this->httpGet($url, $postData);

                $catpucount = (int) $catputemp['total'];
                $postData['rows'] = $catpucount + 1;
                $caipuarr = $this->httpGet($url, $postData);
                foreach ($caipuarr['tngou'] as $caipuarrone) {
                    $this->getCookClassModel->insertCaipu($caipuarrone, $postData['id']);
                }
            }
        }
    }

    function updataCaipuAction() {
        $url = $this->tgapiurl . "/api/cook/show";
        $countArr = $this->getCookClassModel->countCaipu();
        $count = $countArr['count'];
        $per = 10;
        $pages = ceil($count / $per);
        for ($i = 0; $i < $pages; $i++) {
            $classArr = $this->getCookClassModel->getCaipuListBypage($i, $per);
            //请求 获得该分类下的数据   
            foreach ($classArr as $key => $class) {
                $postData['id'] = $class['id'];
                $caipuarr = $this->httpGet($url, $postData);
                $id = $caipuarr['id'];
                $this->getCookClassModel->updataCaipu($caipuarr, $id);
            }
        }
    }
//    
//        function updataCaipu2Action() {
//        $url = $this->tgapiurl . "/api/cook/show";
//          //有个 问题  就是 要是存在了 则更新 就会把 fenleiID 
//          // s更新为0  所以需要单独的做处理  现在数据也够了 就没必要了
//        for ($i = 1; $i < 111111; $i++) {
//            $caipuarr = $this->httpGet($url, array('id' => $i));
//            $this->getCookClassModel->insertCaipu($caipuarr, 0);
////                $this->getCookClassModel->insertCaipu($caipuarr, 0);
//        }
//    }
    
    function getCaiPuImageAction() {

        $countArr = $this->getCookClassModel->countCaipu();
        $count = $countArr['count'];
        $per = 10;
        $pages = ceil($count / $per);
        for ($i = 0; $i < $pages; $i++) {
            $classArr = $this->getCookClassModel->getCaipuListBypage($i, $per);
            foreach ($classArr as $class) {
                $imagestr = file_get_contents($this->tgimgurl . $class['img']);
                if (!$imagestr) {
                    $imagestr = file_get_contents($this->tgimageurl2 . $class['img']);
                }
                $this->handleImageAction($class['img'], $imagestr);

                $imagesarr = explode(",", $class['images']);
                foreach ($imagesarr as $caipuimages) {
                    $imagestr = file_get_contents($this->tgimgurl . $caipuimages);
                    if (!$imagestr) {
                        $imagestr = file_get_contents($this->tgimageurl2 . $caipuimages);
                    }
                    $this->handleImageAction($caipuimages, $imagestr);
                }

            }
        }
    }

    function handleImageAction($imagepath, $imageres) {
//        $uplaodimagepath = dirname(__FILE__."/upload/images");
        $uplaodimagepath=UPLOAD.DS."images";
        $imagesavepath = $uplaodimagepath.substr($imagepath,0,12);
                
//        $imagesavepath = str_replace("/", "\\", $imagesavepath);

        if (!file_exists($imagesavepath)) {
            echo mkdir($imagesavepath);
            echo "create".$imagesavepath."\n\t";
        }
        $imagefianlypath=$imagesavepath.substr($imagepath,12);
        echo $imagefianlypath."\n\t";
        file_put_contents($imagefianlypath, $imageres);
    }

}
