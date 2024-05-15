<?php
 
// 判断,如果GET的参数非update,就报错
if(isset($_GET['update'])) {
    $update = $_GET['update'];
    // 判断,如果请求的文件不存在,就报错
} else {
    $update = err;
    
}
 
// 读取文件内容
$file = file_get_contents('filelist.txt');
 
// 按行分割文件内容
$lines = explode("\n", $file);
 
// 判断参数值是否有效
if($update <= 0 || $update > count($lines)) {
    $link = 1;
} else {
    // 根据参数值获取链接
    $link = $lines[$update - 1];
}
 
// 设置请求的URL
$url = 'https://Alist服务器.com/api/fs/get';
 
// 设置请求的body数据
$data = array(
    "path" => "$link",
    "password" => "",
    "page" => 1,
    "per_page" => 0,
    "refresh" => false
);
 
// 将body数据转换为json格式
$data_json = json_encode($data);
 
// 创建一个新cURL资源
$ch = curl_init();
 
// 设置cURL选项
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json))
);
 
// 执行cURL会话
$response = curl_exec($ch);
 
// 关闭cURL会话
curl_close($ch);
 
// 解析返回的json数据
$responseArray = json_decode($response, true);
 
// 检查response是否已成功解码
if ($responseArray && isset($responseArray['data']['modified'])) {
    $modified = $responseArray['data']['modified'];
 
    // 提取"name"字段的功能
    if(isset($responseArray['data']['name'])) {
        $name = $responseArray['data']['name'];
    } else {
        echo "<h2>未找到文件名字段</h2>";
    }
 
    // 提取"provider"字段的功能
    if(isset($responseArray['data']['provider'])) {
        $provider = $responseArray['data']['provider'];
    } else {
        echo "<h2>未找到存储类型字段</h2>";
    }
    
       // 提取"type"字段的功能
    if(isset($responseArray['data']['type'])) {
        $type = $responseArray['data']['type'];
    } else {
        echo "<h2>未找到文件类型字段</h2>";
    }
    
    // 提取"size"字段的功能
    if(isset($responseArray['data']['size'])) {
        $size = $responseArray['data']['size'];
        $size_mb = round($size / 1048576, 2);  //Byte转换MB
        echo "<p>最后更新于:$modified </p>";
        echo "<p>文件: $name 存储类型:$provider 类型:$type 大小:$size_mb MB</p>";
    } else {
        echo "<h2>未找到文件大小字段</h2>";
    }
} else {
    echo "<h2>错误发生!!,未找到字段 By:夏的博客</h2>";
}
?>
