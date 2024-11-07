<?php

header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
error_reporting(0);

$input_id = $_REQUEST['id']; // 获取请求中传入的 ID
$url = "https://www.yhchat.com/user/homepage/{$input_id}"; // 拼接 URL

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
    if (strpos($response, "data-v-34a9b5c4>ID </span>") === false) {
        // 如果存在
        preg_match('/userId:"(.*?)"/', $response, $userId); // ID
        preg_match('/nickname:"(.*?)"/', $response, $nickname); // 昵称
        preg_match('/avatarUrl:"(.*?)"/', $response, $avatarUrl); // 头像链接
        preg_match('/registerTime:(\d+)/', $response, $registerTime); // 注册时间戳
        preg_match('/registerTimeText:"(.*?)"/', $response, $registerTimeText); // 注册时间
        preg_match('/在线天数<\/span> <span[^>]*>(\d+)天<\/span>/', $response, $onLineDay); // 在线天数，这里只能这样截取，因为当在线天数为 1 时 js 里的是 onLineDay:b
        preg_match('/连续在线<\/span> <span[^>]*>(\d+)天<\/span>/', $response, $continuousOnLineDay); // 连续在线，这里只能这样截取，因为当连续在线在线为 1 时 js 里的是 continuousOnLineDay:b
        preg_match('/isVip:(.*?)}/', $response, $isVip); // 是否为 VIP，这里只能判断它是不是 0，因为当是 VIP 时会返回 isVip:b
        preg_match_all('/<div class="medal-container"[^>]*>\s*(.*?)\s*<\/div>/', $response, $medal); // 称号列表
        $result = array(
            "code" => 1,
            "msg" => "ok",
            "data" => array(
                "userId" => $userId[1],
                "nickname" => $nickname[1],
                "avatarUrl" => decode_utf8($avatarUrl[1]),
                "registerTime" => intval($registerTime[1]),
                "registerTimeText" => $registerTimeText[1],
                "onLineDay" => intval($onLineDay[1]),
                "continuousOnLineDay" => intval($continuousOnLineDay[1]),
                "isVip" => $isVip[1] != "0",
                "medal" => $medal[1]
            )
        );
    }
    else {
        // 如果不存在
        $result = array(
            "code" => 2,
            "msg" => "用户不存在，请检查输入的 ID 是否正确"
        );
    }
}

curl_close($ch);

// 输出 json 数据
exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

?>