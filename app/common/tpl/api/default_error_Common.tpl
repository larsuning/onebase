<?php

namespace app\{$module}\error;

class {$class}
{

public static $passwordError            = [API_CODE_NAME => 1010001, API_MSG_NAME => '登录密码错误'];

public static $usernameOrPasswordEmpty  = [API_CODE_NAME => 1010002, API_MSG_NAME => '用户名或密码不能为空'];

public static $registerFail             = [API_CODE_NAME => 1010003, API_MSG_NAME => '注册失败'];

public static $oldOrNewPassword         = [API_CODE_NAME => 1010004, API_MSG_NAME => '旧密码或新密码不能为空'];

public static $changePasswordFail       = [API_CODE_NAME => 1010005, API_MSG_NAME => '密码修改失败'];

public static $idError                  = [API_CODE_NAME => 1020006, API_MSG_NAME => 'id为空或错误'];

public static $ParamEmpty               = [API_CODE_NAME => 1020007, API_MSG_NAME => '参数错误，参数不存在或值为空'];

public static $addFail                  = [API_CODE_NAME => 1020008, API_MSG_NAME => '新增失败'];

public static $editFail                 = [API_CODE_NAME => 1020009, API_MSG_NAME => '编辑失败'];

public static $delFail                  = [API_CODE_NAME => 1020010, API_MSG_NAME => '删除失败'];

public static $infoFail                 = [API_CODE_NAME => 1020011, API_MSG_NAME => '获取信息失败'];

public static $pathEmpty                = [API_CODE_NAME => 1020012, API_MSG_NAME => 'path_name不能为空'];

public static $fileSizeError            = [API_CODE_NAME => 1020013, API_MSG_NAME => '上传大小不符'];

public static $fileExtError             = [API_CODE_NAME => 1020014, API_MSG_NAME => '后缀不允许,文件格式错误'];

}
