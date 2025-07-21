<?php

header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
error_reporting(0);

// 获取传入的 id 和 type 参数
$id = $_REQUEST["id"];
$type = $_REQUEST["type"];

// 如果是群聊或者机器人
if ($type == "group" or $type == "bot") {
    // 请求云湖服务器
    $ch = curl_init();
    $url = "https://chat-web-go.jwzhd.com/v1/{$type}/{$type}-info";
    $data = ["{$type}Id" => $id];
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true
    ]);
    $response = curl_exec($ch);
    // 检查 curl 返回是否正常
    if ($response === false) {
        // 如果 curl 返回错误
        $result = ["code" => -1, "msg" => "请求失败: " . curl_error($ch)];
    }
    else {
        // 尝试解析返回的 json
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $result = ["code" => -1, "msg" => "JSON 解析失败：" . $response];
        }
        else {
            $result = $decoded;
        }
    }
    curl_close($ch);
}
// 如果是用户
elseif ($type == "user") {
    // 请求云湖服务器
    $ch = curl_init();
    $url = "https://chat-web-go.jwzhd.com/v1/user/homepage?userId={$id}";
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    ]);
    $response = curl_exec($ch);
    // 检查 curl 返回是否正常
    if ($response === false) {
        // 如果 curl 返回错误
        $result = ["code" => -1, "msg" => "请求失败: " . curl_error($ch)];
    }
    else {
        // 尝试解析返回的 json
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $result = ["code" => -1, "msg" => "JSON 解析失败：" . $response];
        }
        else {
            // 官方获取用户信息的接口没做错误处理，这里通过判断返回的 userId 是否为空判断用户是否存在
            if (empty($decoded["data"]["user"]["userId"])) {
                $result = ["code" => -1, "msg" => "用户不存在"];
            }
            else {
                $result = $decoded;
            }
        }
    }
    curl_close($ch);
}
// 如果类型错了
else {
    $result = ["code" => -1, "msg" => "输入 type 错误，目前支持 user、group、bot"];
}

// 输出 json 数据
echo(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

?>