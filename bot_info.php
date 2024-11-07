<?php

header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
error_reporting(0);

$input_id = $_REQUEST['id']; // 获取请求中传入的 ID
$url = "https://www.yhchat.com/bot/homepage/{$input_id}"; // 拼接 URL

// 解析 UTF-8 编码，把 \u002F 解析成 /
function decode_utf8($text) {
    return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($matches) {
        return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UCS-2BE');
    }, $text);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); // 设置传输的 url
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
$response = curl_exec($ch);

// 检查 curl 返回是否正常
if ($response === false) {
    // 如果 curl 返回错误
    $result = array(
        "code" => -1,
        "msg" => "请求失败: " . curl_error($ch)
    );
}
else {
    // 通过检查网页中是否存在"ID "这个字符串判断这个 ID 是否存在
    if (strpos($response, "data-v-4f86f6dc>ID </span>") === false) {
        // 如果存在
        preg_match('/ID\s+(\w+)/', $response, $groupId); // ID
        preg_match('/id:(\d+)/', $response, $id); // 机器人序号
        preg_match('/nickname:"(.*?)"/', $response, $nickname); // 昵称
        preg_match('/nicknameId:(\d+)/', $response, $nicknameId); // 昵称 ID
        preg_match('/avatarId:(\d+)/', $response, $avatarId); // 头像 ID
        preg_match('/avatarUrl:"(.*?)"/', $response, $avatarUrl); // 头像链接
        preg_match('/<div[^>]*>\s*机器人简介\s*<\/div>\s*<div[^>]*>\s*([\s\S]*?)\s*<\/div>/', $response, $introduction); // 机器人简介，这里只能这样截取，因为当简介为空时 js 里的是 introduction:a，群聊的正常，就机器人的不行
        preg_match('/createBy:"(.*?)"/', $response, $createBy); // 创建者
        preg_match('/private:(.*?)}/', $response, $private); // 是否为私有，这里只能判断它是不是 1，因为当不是私有时会返回 private:b
        $result = array(
            "code" => 1,
            "msg" => "ok",
            "data" => array(
                "botId" => $groupId[1],
                "id" => intval($id[1]),
                "nickname" => $nickname[1],
                "nicknameId" => intval($nicknameId[1]),
                "avatarId" => intval($avatarId[1]),
                "avatarUrl" => decode_utf8($avatarUrl[1]),
                "introduction" => $introduction[1],
                "createBy" => $createBy[1],
                "private" => $private[1] == "1"
            )
        );
    }
    else {
        // 如果不存在
        $result = array(
            "code" => 2,
            "msg" => "机器人不存在，请检查输入的 ID 是否正确"
        );
    }
}

curl_close($ch);

// 输出 json 数据
exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));

?>