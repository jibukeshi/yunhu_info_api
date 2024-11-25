<?php

header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
error_reporting(0);

// 预定义支持的类型列表
$types = [
    "user" => ["name" => "用户", "check" => 'data-v-34a9b5c4>ID </span>'],
    "group" => ["name" => "群聊", "check" => 'data-v-6eef215f>ID </span>'],
    "bot" => ["name" => "机器人", "check" => 'data-v-4f86f6dc>ID </span>']
];

// 获取传入的 id 和 type 参数
$id = $_REQUEST["id"];
$type = $_REQUEST["type"];

// 检查传入的 ID 是否为空
if (empty($id)) {
    $result = ["code" => 3, "msg" => "输入 ID 为空，请输入要查询的 ID"];
}
// 检查传入的类型是否合法
elseif (empty($type) or array_key_exists($type, $types) == false) {
    $result = ["code" => 4, "msg" => "输入 type 错误，目前支持：" . implode("、", array_keys($types))];
}
else {
    // 请求云湖服务器
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://www.yhchat.com/{$type}/homepage/{$id}", // 设置传输的 url
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // 对认证证书来源的检查
        CURLOPT_SSL_VERIFYHOST => false, // 从证书中检查SSL加密算法是否存在
        CURLOPT_TIMEOUT => 5 // 设置超时限制防止死循环
    ]);
    $response = curl_exec($ch);
    // 检查 curl 返回是否正常
    if ($response === false) {
        // 如果 curl 返回错误
        $result = ["code" => -1, "msg" => "请求失败: " . curl_error($ch)];
    }
    else {
        // 通过检查网页中是否存在"ID "这个字符串判断这个 ID 是否存在
        if (strpos($response, $types[$type]["check"]) === false) {
            // 先匹配 js 部分
            preg_match('/<script>window\.__NUXT__=\((.*?)\);<\/script>/', $response, $script);
            // 匹配变量名
            preg_match('/function\((.*?)\)/', $script[1], $param_name);
            $param_names = explode(',', $param_name[1]);
            // 匹配变量值
            preg_match('/}}\((.*?)\)/', $script[1], $param_value);
            $param_values = explode(',', $param_value[1]);
            // 匹配信息
            preg_match('/' . $type . ':(.*?)}],fetch/', $script[1], $content);
            // 解析 UTF-8 编码，把 \u002F 解析成 /
            $info = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($matches) {
                return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UCS-2BE');
            }, $content[1]);
            // 替换 js 变量为值
            // 创建关联数组
            $params = array_combine($param_names, $param_values);
            foreach ($params as $key => $value) {
                // 替换时，使用 JSON 编码的值，防止误匹配
                $value = json_encode(trim($value, '"'));
                $info = preg_replace('/\b' . preg_quote($key, '/') . '\b(?=[:,}])/', $value, $info);
            }
            // 修复键没有引号的 json
            $info = preg_replace('/(?<=\{|\[|\,)(\s*)([a-zA-Z_][a-zA-Z0-9_]*)(?=\s*:)/', '$1"$2"', $info);
            // 解析应该是正常的 json
            $decoded = json_decode($info, true);
            // 检查 json 解析是否正常
            if (json_last_error() !== JSON_ERROR_NONE) {
                $result = ["code" => -2, "msg" => "解析失败"];
            }
            $result = ["code" => 1, "msg" => "ok", "data" => $decoded];
        }
        else {
            $result = ["code" => 2, "msg" => $types[$type]["name"] . "不存在，请检查输入的 ID 是否正确"];
        }
    }
    curl_close($ch);
}

// 输出 json 数据
exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

?>