<?php

namespace app\{$module}\error;

class {$class}
{

    public static $success              = [API_CODE_NAME => 1,          API_MSG_NAME => '操作成功'];

    public static $accessTokenError     = [API_CODE_NAME => 1000001,    API_MSG_NAME => '访问Toekn错误'];

    public static $userTokenError       = [API_CODE_NAME => 1000002,    API_MSG_NAME => '用户Toekn错误'];

    public static $apiUrlError          = [API_CODE_NAME => 1000003,    API_MSG_NAME => '接口路径错误'];

    public static $dataSignError        = [API_CODE_NAME => 1000004,    API_MSG_NAME => '数据签名错误'];

    public static $actionError          = [API_CODE_NAME => 1000005,    API_MSG_NAME => 'action为空或者错误'];

}