<?php

function readDirectory($path) {
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        //.和..这2个特殊目录
        if ($item != "." && $item != "..") {
            if (is_file($path . "/" . $item)) {
                $arr['file'][] = $item;
            }
            if (is_dir($path . "/" . $item)) {
                $arr['dir'][] = $item;
            }

        }
    }
    closedir($handle);
    return $arr;
}

function delFile($filename) {
    if (unlink($filename)) {
        $mes = "文件删除成功";
    } else {
        $mes = "文件删除失败";
    }
    return $mes;
}

$fileName = $_POST["filename"];

?>