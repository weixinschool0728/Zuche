<?php

class ModalSystem extends Modal {

    function mkdirs($dir, $mode = 0777) {
        if (!is_dir($dir)) {
            $this->mkdirs(dirname($dir), $mode);

            if (mkdir($dir, $mode)) {
                chmod($dir, $mode);
                return true;
            }
            else {
                return false;
            }
        }

        return true;
    }
    
    function ds($data) {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = $this->ds($v);
            }
        }
        else {
            $data = str_replace('/', DS, $data);
            $data = str_replace('\\', DS, $data);
        }
        
        return $data;
    }
    
    function fileExt($fileName) {
        $tmp = explode(".", $fileName);
        $fileExt = $tmp[count($tmp) - 1];
        return strtolower($fileExt);
    }
    
    function fileInfo($file) {
        $file = $this->ds($file);
        $fileName = basename($file);
        
        $ext = $this->fileExt($fileName);
        $info = array(
            'name' => $fileName,
            'ext' => $ext,
            'size' => filesize($file),
            'type' => $ext,
        );
        
        return $info;
    }
}

?>
