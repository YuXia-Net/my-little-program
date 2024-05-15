<?php
// 获取url中的参数
$title = isset($_GET['title']) ? $_GET['title'] : '';
$h1 = isset($_GET['h1']) ? $_GET['h1'] : '';
$link = isset($_GET['link']) ? $_GET['link'] : '';

// 判断参数是否为空
if(empty($title) || empty($h1) || empty($link)){
    echo "参数缺失，无法正常显示页面";
    exit;
}

// 设置跳转时间
$redirect_time = 3;

// 读取文件内的链接信息
$file = 'allowed_links.txt';
$allowedLinks = file_get_contents($file);

// 判断链接是否在允许的链接列表中
if(strpos($allowedLinks, $link) === false){
    echo "该链接不在允许的链接列表中，无法跳转";
        exit;
        }

// 输出HTML代码
echo '<!DOCTYPE html>
<html>
<head>
   <title>' . $title . '</title>
    <style>
        body {
           -family: monospace;
            background-color: black;
            color: white;
            text-align: center;
            padding-top: 20%;
        }
        a {
            color: white;
            text-decoration: none;
            border: 1px solid white;
            padding: 10px 20px;
            margin: 10px;
            display: inline-block;
        }
        a:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>
    <h1>' . $h1 . '</h1>';

// 读取跳转次数
$file = 'jump_count.txt';
$data = file_get_contents($file);
$jumpData = json_decode($data, true);

// 初始化跳转次数
$count = 0;

// 判断跳转链接是否存在于文件中
if(isset($jumpData[$link])){
    $count = $jumpData[$link];
}

echo '<p>跳转次数: ' . $count . '</p>';
echo '<p>页面将在 ' . $redirect_time . ' 秒后自动跳转...</p>';

echo '<a href="' . $link . '">点击这里立即跳转</a>';
echo '<p style="position: fixed; bottom: 10px; left: 10px; color: gray;">© Xiablog. All rights reserved.</p>';
echo '</body>
</html>';

// 增加跳转次数
$count++;
$jumpData[$link] = $count;

// 将更新后的数据写入文件
file_put_contents($file, json_encode($jumpData));

// 跳转到指定链接
header("refresh:$redirect_time;url=$link");
exit;
?>