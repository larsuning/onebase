<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

namespace app\apips\error;

class Common
{
    
    public static $passwordError            = [API_CODE_NAME => 1010001, API_MSG_NAME => '登录密码错误'];
    
    public static $usernameOrPasswordEmpty  = [API_CODE_NAME => 1010002, API_MSG_NAME => '用户名或密码不能为空'];
    
    public static $registerFail             = [API_CODE_NAME => 1010003, API_MSG_NAME => '注册失败'];
    
    public static $oldOrNewPassword         = [API_CODE_NAME => 1010004, API_MSG_NAME => '旧密码或新密码不能为空'];
    
    public static $changePasswordFail       = [API_CODE_NAME => 1010005, API_MSG_NAME => '密码修改失败'];
    
    public static $sendSmsCodeFail       = [API_CODE_NAME => 1000006,   API_MSG_NAME => '短信发送失败'];
    
    public static $SmsCodeError       = [API_CODE_NAME => 1000007,   API_MSG_NAME => '短信验证码失败'];

    public static $appAuthFail       = [API_CODE_NAME => 1000008,   API_MSG_NAME => '小程序验证失败'];

    public static $ParamEmpty       = [API_CODE_NAME => 1000009,   API_MSG_NAME => '请求参数错误'];

    public static $memberFail       = [API_CODE_NAME => 1000010,   API_MSG_NAME => '请求用户不存在'];

    public static $mysqlConectFail       = [API_CODE_NAME => 1000011,   API_MSG_NAME => '数据库连接错误，请稍后再试'];

    public static $dataImcomplete       = [API_CODE_NAME => 1000012,   API_MSG_NAME => '当前数据尚未填写完成'];

    
}
