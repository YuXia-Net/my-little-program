<?php
// 获取传入的link参数
$link = $_GET['link'] ?? '';
 
// 判断link参数是否为空
if(empty($link)){
    die('没有参数');
}
 
//白名单功能开始
// 读取文件内的链接信息
$file = 'allowed_links.txt';
$allowedLinks = file_get_contents($file);
 
// 判断链接是否在允许的链接列表中
if(strpos($allowedLinks, $link) === false){
    echo "该链接不在允许的链接列表中，无法跳转";
        exit;
        }
//白名单功能结束
 
// 读取存储跳转链接和次数的文件
$file = 'jump_count.txt';
$data = file_get_contents($file);
$jumpData = json_decode($data, true);
 
// 初始化跳转次数
$count = 0;
 
// 判断跳转链接是否存在于文件中
if(isset($jumpData[$link])){
    $count = $jumpData[$link];
}
 
// 增加跳转次数
$count++;
$jumpData[$link] = $count;
 
// 将更新后的数据写入文件
file_put_contents($file, json_encode($jumpData));
 
// 进行跳转
header('Location: ' . $link);
exit;
?>
