<?php

$targetDir = 'upload_tmp';
$uploadDir = 'upload';

$cleanupTargetDir = true; 


if (!file_exists($targetDir)) {
    @mkdir($targetDir);
}

if (!file_exists($uploadDir)) {
    @mkdir($uploadDir);
}

if (isset($_REQUEST["wangFile"])) {
    $fileName = $_REQUEST["wangfile"]["name"];
} elseif (!empty($_FILES)) {
    $fileName = $_FILES["wangfile"]["name"];
} else {
    $fileName = uniqid("file_");
}
$fileName = iconv('UTF-8', 'GB2312', $fileName);
$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;



$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


if ($cleanupTargetDir) {
    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
    }

    while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

        if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
            continue;
        }

        if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
            @unlink($tmpfilePath);
        }
    }
    closedir($dir);
}



if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
    if ($_FILES["wangfile"]["error"] || !is_uploaded_file($_FILES["wangfile"]["tmp_name"])) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }

    if (!$in = @fopen($_FILES["wangfile"]["tmp_name"], "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
} else {
    if (!$in = @fopen("php://input", "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
}

while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

$index = 0;
$done = true;
for( $index = 0; $index < $chunks; $index++ ) {
    if ( !file_exists("{$filePath}_{$index}.part") ) {
        $done = false;
        break;
    }
}
if ( $done ) {
    if (!$out = @fopen($uploadPath, "wb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    }

    if ( flock($out, LOCK_EX) ) {
        for( $index = 0; $index < $chunks; $index++ ) {
            if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                break;
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($in);
            @unlink("{$filePath}_{$index}.part");
        }

        flock($out, LOCK_UN);
    }
    @fclose($out);
}

$ext=@strtolower(end(explode(".",$fileName)));

$uniName=md5(uniqid(microtime(true),true)).".".$ext;

$destination=$uploadDir."/".$uniName;
if(!@move_uploaded_file($_FILES["wangfile"]["tmp_name"],$destination)){
      echo "上传失败！";
 }
 echo "http://localhost/BianJiQi/wangEditor/php/".$destination;