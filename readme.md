# 云湖信息获取 API

使用 PHP 编写的从云湖网页获取用户、群聊、机器人详细信息的 API。

采用单文件设计，直接将对应的 PHP 文件上传到主机即可使用。

### 请求说明

请求地址：`api.php`  
返回格式：`JSON`  
请求方式：`GET` 或 `POST`  
请求示例：`https://qingzhi.jibukeshi.us.kg/api/yunhu/api.php?type=user&id=7058262`

### 请求参数

| 参数名称 | 参数类型 | 是否必填 | 说明内容 |
| --- | --- | --- | --- |
| `id` | `string` | 是 | ID |
| `type` | `string` | 是 | 类型<br>用户：user<br>群聊：group<br>机器人：bot |

### 返回参数

#### 当 type 为 user 时

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `message` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.userId` | `string` | 用户 ID |
| `data.nickname` | `string` | 昵称 |
| `data.avatarUrl` | `string` | 头像链接 |
| `data.registerTime` | `integer` | 注册时间戳 |
| `data.registerTimeText` | `string` | 注册时间 |
| `data.onLineDay` | `integer` | 在线天数 |
| `data.continuousOnLineDay` | `integer` | 连续在线 |
| `data.isVip` | `boolean` | 是否为 VIP |
| `data.medals` | `array` | 称号列表 |

#### 当 type 为 group 时

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `message` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.id` | `integer` | 群聊序号 |
| `data.groupId` | `string` | 群聊 ID |
| `data.name` | `string` | 群聊名称 |
| `data.introduction` | `string` | 群聊简介 |
| `data.createBy` | `string` | 创建者 |
| `data.createTime` | `integer` | 创建时间戳 |
| `data.avatarId` | `integer` | 头像 ID |
| `data.avatarUrl` | `string` | 头像链接 |
| `data.headcount` | `integer` | 群人数 |
| `data.category` | `string` | 分类 |

#### 当 type 为 bot 时

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `message` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.id` | `integer` | 机器人序号 |
| `data.botId` | `string` | 机器人 ID |
| `data.nickname` | `string` | 昵称 |
| `data.nicknameId` | `integer` | 昵称 ID |
| `data.avatarId` | `integer` | 头像 ID |
| `data.avatarUrl` | `string` | 头像链接 |
| `data.introduction` | `string` | 机器人简介 |
| `data.createBy` | `string` | 创建者 |
| `data.createTime` | `integer` | 创建时间戳 |
| `data.headcount` | `integer` | 使用者人数 |
| `data.private` | `boolean` | 是否为私有 |

### 状态码说明

| 名称 | 说明 |
| --- | --- |
| `1` | 成功 |
| `2` | ID 不存在 |
| `3` | 输入 ID 为空 |
| `4` | 输入 type 错误 |
| `-1` | 请求失败 |
| `-2` | 解析失败 |
