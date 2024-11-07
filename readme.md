# 云湖信息获取 API

使用 PHP 编写的从云湖网页获取用户、群聊、机器人详细信息的 API。

采用单文件设计，直接将对应的 PHP 文件上传到主机即可使用。

## 用户信息获取

### 请求说明

请求地址：`user_info.php`  
返回格式：`JSON`  
请求方式：`GET` 或 `POST`  
请求示例：`https://qingzhi.jibukeshi.us.kg/api/yunhu/user_info.php?id=7058262`

### 请求参数

| 参数名称 | 参数类型 | 是否必填 | 说明内容 |
| --- | --- | --- | --- |
| `id` | `string` | 是 | 用户 ID |

### 返回参数

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `message` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.userId` | `string` | ID |
| `data.nickname` | `string` | 昵称 |
| `data.avatarUrl` | `string` | 头像链接 |
| `data.registerTime` | `integer` | 注册时间戳 |
| `data.registerTimeText` | `string` | 注册时间 |
| `data.onLineDay` | `integer` | 在线天数 |
| `data.continuousOnLineDay` | `integer` | 连续在线 |
| `data.isVip` | `boolean` | 是否为 VIP |
| `data.medal` | `array` | 称号列表 |

### 状态码说明

| 名称 | 说明 |
| --- | --- |
| `1` | 成功 |
| `2` | 用户不存在 |
| `-1` | 请求失败 |

## 群聊信息获取

### 请求说明

请求地址：`group_info.php`  
返回格式：`JSON`  
请求方式：`GET` 或 `POST`  
请求示例：`https://qingzhi.jibukeshi.us.kg/api/yunhu/group_info.php?id=big`

### 请求参数

| 参数名称 | 参数类型 | 是否必填 | 说明内容 |
| --- | --- | --- | --- |
| `id` | `string` | 是 | 群聊 ID |

### 返回参数

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `message` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.groupId` | `string` | ID |
| `data.id` | `integer` | 群聊序号 |
| `data.name` | `string` | 群聊名称 |
| `data.introduction` | `string` | 群聊简介 |
| `data.createBy` | `string` | 创建者 |
| `data.avatarId` | `integer` | 头像 ID |
| `data.avatarUrl` | `string` | 头像链接 |
| `data.headcount` | `integer` | 群人数 |
| `data.category` | `string` | 分类 |

### 状态码说明

| 名称 | 说明 |
| --- | --- |
| `1` | 成功 |
| `2` | 群聊不存在 |
| `-1` | 请求失败 |

## 机器人信息获取

### 请求说明

请求地址：`bot_info.php`  
返回格式：`JSON`  
请求方式：`GET` 或 `POST`  
请求示例：`https://qingzhi.jibukeshi.us.kg/api/yunhu/bot_info.php?id=13972254`

### 请求参数

| 参数名称 | 参数类型 | 是否必填 | 说明内容 |
| --- | --- | --- | --- |
| `id` | `string` | 是 | 机器人 ID |

### 返回参数

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `message` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.botId` | `string` | ID |
| `data.id` | `integer` | 机器人序号 |
| `data.nickname` | `string` | 昵称 |
| `data.nicknameId` | `integer` | 昵称 ID |
| `data.avatarId` | `integer` | 头像 ID |
| `data.avatarUrl` | `string` | 头像链接 |
| `data.introduction` | `string` | 机器人简介 |
| `data.createBy` | `string` | 创建者 |
| `data.private` | `boolean` | 是否为私有 |

### 状态码说明

| 名称 | 说明 |
| --- | --- |
| `1` | 成功 |
| `2` | 机器人不存在 |
| `-1` | 请求失败 |