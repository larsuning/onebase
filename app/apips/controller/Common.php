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

namespace app\apips\controller;

/**
 * 公共基础接口控制器
 */
class Common extends ApiBase
{
    
    /**
     * 登录接口
     */
    public function login()
    {

        return $this->apiReturn($this->logicCommon->codeLogin($this->param));
    }
    

     /**
     * 验证微信用户绑定接口
     */
    public function wxidentity()
    {
        return $this->apiReturn($this->logicCommon->checkwx($this->param));
    }
    
     /**
     * 发送短信验证码
     */
    public function sendsmscode()
    {
        return $this->apiReturn($this->logicCommon->SendSms($this->param));
    }

    /**
     * 注册
     */
    public function register()
    {
        return $this->apiReturn($this->logicCommon->smscoderegister($this->param));
    }

    
    /**
     * 修改密码接口
     */
    public function changePassword()
    {

        return $this->apiReturn($this->logicCommon->changePassword($this->param));
    }
    
    /**
     * 友情链接
     */
    public function getBlogrollList()
    {

        return $this->apiReturn($this->logicCommon->getBlogrollList($this->param));
    }


    /**
     * 省城县
     */
    public function getRegion()
    {

        return $this->apiReturn($this->logicCommon->getRegion($this->param));
    }
}
