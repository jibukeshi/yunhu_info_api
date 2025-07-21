# 云湖信息获取 API

使用 PHP 编写的从云湖网页获取用户、群聊、机器人详细信息的 API。

采用单文件设计，直接将对应的 PHP 文件上传到主机即可使用。

### 请求说明

请求地址：`api.php`  
返回格式：`JSON`  
请求方式：`GET` 或 `POST`  
请求示例：`https://qingzhi.jibukeshi.dpdns.org/api/yunhu/api.php?type=user&id=7058262`

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
| `msg` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.user.userId` | `string` | 用户 ID |
| `data.user.nickname` | `string` | 昵称 |
| `data.user.avatarUrl` | `string` | 头像链接 |
| `data.user.registerTime` | `integer` | 注册时间戳 |
| `data.user.registerTimeText` | `string` | 注册时间 |
| `data.user.onLineDay` | `integer` | 在线天数 |
| `data.user.continuousOnLineDay` | `integer` | 连续在线 |
| `data.user.isVip` | `boolean` | 是否为 VIP |
| `data.user.medals` | `array` | 称号列表 |

#### 当 type 为 group 时

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `msg` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.group.id` | `integer` | 群聊序号 |
| `data.group.groupId` | `string` | 群聊 ID |
| `data.group.name` | `string` | 群聊名称 |
| `data.group.introduction` | `string` | 群聊简介 |
| `data.group.createBy` | `string` | 创建者 |
| `data.group.createTime` | `integer` | 创建时间戳 |
| `data.group.avatarId` | `integer` | 头像 ID |
| `data.group.avatarUrl` | `string` | 头像链接 |
| `data.group.headcount` | `integer` | 群人数 |
| `data.group.category` | `string` | 分类 |
| `data.group.checkChatInfoRecord.id` | `integer` | 聊天序号 |
| `data.group.checkChatInfoRecord.chatId` | `string` | 聊天 ID |
| `data.group.checkChatInfoRecord.chatType` | `string` | 聊天类型 |
| `data.group.checkChatInfoRecord.createTime` | `integer` | 聊天创建时间戳 |
| `data.group.checkChatInfoRecord.updateTime` | `integer` | 群聊信息更新时间戳 |

#### 当 type 为 bot 时

| 参数名称 | 参数类型 | 说明内容 |
| --- | --- | --- |
| `code` | `integer` | 状态码 |
| `msg` | `string` | 返回信息 |
| `data` | `array` | 返回数据 |
| `data.bot.id` | `integer` | 机器人序号 |
| `data.bot.botId` | `string` | 机器人 ID |
| `data.bot.nickname` | `string` | 昵称 |
| `data.bot.nicknameId` | `integer` | 昵称 ID |
| `data.bot.avatarId` | `integer` | 头像 ID |
| `data.bot.avatarUrl` | `string` | 头像链接 |
| `data.bot.introduction` | `string` | 机器人简介 |
| `data.bot.createBy` | `string` | 创建者 |
| `data.bot.createTime` | `integer` | 创建时间戳 |
| `data.bot.headcount` | `integer` | 使用者人数 |
| `data.bot.private` | `boolean` | 是否为私有 |
| `data.bot.checkChatInfoRecord.id` | `integer` | 聊天序号 |
| `data.bot.checkChatInfoRecord.chatId` | `string` | 聊天 ID |
| `data.bot.checkChatInfoRecord.chatType` | `string` | 聊天类型 |
| `data.bot.checkChatInfoRecord.createTime` | `integer` | 聊天创建时间戳 |

### 状态码说明

| 名称 | 说明 |
| --- | --- |
| `1` | 成功（只有此时才有 data 字段） |
| `-1` | 失败（原因详见 msg 字段） |