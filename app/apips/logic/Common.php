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

namespace app\apips\logic;

use app\apips\error\CodeBase;
use app\apips\error\Common as CommonError;
use \Firebase\JWT\JWT;

/**
 * 接口基础逻辑
 */
class Common extends ApiBase
{
    /*
    是否注册微信
    */
    public function checkwx($data = [])
    {   
        if(!isset($data['appid']) || !isset($data['jscode'])){
            return CommonError::$ParamEmpty;
        }
        $wxapp=$this->modelWechatConfig->getInfo(['appid' =>$data['appid']], 'id,appid,appsecret');
        if($wxapp){
            $wxapp['jscode']=$data['jscode'];
            $user=$this->get_xcx_userinfo_by_authorize($wxapp);
            if(isset($user['errcode'])){
                return [API_CODE_NAME => -1, API_MSG_NAME=>$user['errmsg']];
            }
            if(!isset($user['openid'])){
               return CommonError::$appAuthFail; 
            }
            $openid =$user['openid'];
            \think\Session::set('openid',$openid);
            $wbdata=['access_token'=>get_access_token()];
            $wx=$this->modelWechatFans->getInfo(['appid' =>$data['appid'],'openid' =>$openid], 'id');
            if($wx['id']){
                   $this->modelWechatFans->setInfo(['id'=>$wx['id'],'session_key'=>$user['session_key']]);
                   $wxbd=$this->modelWechatRelation->getInfo(['openid' =>$openid], 'id,member_id');
                   if($wxbd['member_id']){
                            $member = $this->modelMember->getInfo(['id' => $wxbd['member_id']]);
                            if($member['status']){
                                $jwt_data=$this->tokenSign($member);
                                $rdata['data']         = ['id'=>$member['id'],'name'=>$member['realname'],'mobile'=>$member['mobile']];
                                $rdata['user_token']   = $jwt_data['user_token'];
                                $rdata['access_token'] = get_access_token();
                      
                                return $rdata;
                            }else{
                                return [API_CODE_NAME => -1, API_MSG_NAME=>'用户被禁用'];
                            }
                   }else{
                     return [API_CODE_NAME => 0, API_MSG_NAME=>'OPID未绑定','data'=>$wbdata];
                   }                            
           }else{
             $wxdata['appid']=$data['appid'];
             $wxdata['openid']=$openid;
             $wxdata['session_key']=$user['session_key'];
             $this->modelWechatFans->addInfo($wxdata);
             return [API_CODE_NAME => 0, API_MSG_NAME=>'OPID未绑定','data'=>['access_token'=>get_access_token()]];
         }
      }else{
             return CommonError::$appAuthFail;
      }
    }

  
    /**
     * 短信服务
     */
    public function SendSms($data=[])
    {
        
        $mm['mobile']=$data['mobile'];
        $data['is_check_member']=1;//验证用户
        if($mm['mobile']){
            //验证客户信息
           if(isset($data['is_check_member']) && $data['is_check_member']==1){
                $Member=$this->modelMember->getInfo(['mobile' =>$mm['mobile'],'status' => 1]);
                if($Member['id']){
                   return $this->sendsmscode($data);
                }else{
                  return CommonError::$memberFail; 
                }
           }else{
                 return $this->sendsmscode($data);
           }
        }else{
              return CommonError::$sendSmsCodeFail;
        }
    }


     /**
     * 发短信服务
     */
    private function SendSmsCode($data=[])
    {

        $type=isset($data['type'])?$data['type']:0;//0登录 1注册  2修改密码 
        $mm['mobile']=$data['mobile'];
        $mm['create_time']=['gt',time()-300];
        $mm['type']=$type; //0登录 1注册  2修改密码 
        $smscount=$this->modelSmsCode->where($mm)->count();
        if($smscount>3){
            return  ['code'=>-1,'msg'=>'获取验证码频繁，请稍后再试！'];  
        }
        $sms['code']=mt_rand(100000,999999);
        $sms['type']=$type; 
        $sms['mobile']=$data['mobile'];
        $sms['ip']=request()->ip();
        $sms['user_agent']=$_SERVER['HTTP_USER_AGENT'];
        $this->modelSmsCode->addInfo($sms);
        $parameter['sign_name']      = isset($data['sign_name'])?$data['sign_name']:'青蛙家';
        $parameter['template_code']  = isset($data['template_code'])?$data['template_code']:'SMS_136220052'; //身份验证
        $parameter['phone_number']   = $data['mobile'];
        $parameter['template_param'] = ['code' => $sms['code']];
        //print_r($parameter);
        $s=true;
        // $s=$this->serviceSms->driverAlidy->sendSms($parameter);
        if($s){
            // return CodeBase::$success;
            return ['smscode'=>$sms['code']];
        }else{
            return CommonError::$sendSmsCodeFail;   
        }
    }

    /**
    *短信验证码登陆
     */
    public function codeLogin($data = [])
    {
        $mm['mobile'] = $data['mobile'];
        $mm['type']   = 0;
        // $mm['is_use']  = 0;
        $code = $this->modelSmsCode->where($mm)->order('id desc')->value('code');
        if($code == $data['code']){
            //更新验证码使用状态
            $this->modelSmsCode->setFieldValue(['code'=>$data['code'],'mobile'=>$data['mobile']],'is_use',1);
            //根据手机号获取账户信息
            $member = $this->modelMember->getInfo(['mobile' => $data['mobile']]);
            if(!$member){
                return CommonError::$memberFail;
            }
            //设置手机号验证成功
            $this->modelMember->setFieldValue(['id'=>$member['id']],'check_mobile',1);
            $openid = $member['openid'];
            if(!$openid){
                $member_openid = \think\Session::get('openid');
                $this->modelMember->setFieldValue(['id'=>$member['id']],'openid',$member_openid);
            }
            
            
            // 设置用户与小程序之间的关联信息
            $Relation = $this->modelWechatRelation->getInfo(['member_id' => $member['id'],'openid'=>$openid]);
            if(!$Relation){
               $Relationdata['member_id'] = $member['id'];
               $Relationdata['openid']    = $openid;
               $this->modelWechatRelation->setInfo($Relationdata);
            }
            //返回user_token 信息
            $jwt_data=$this->tokenSign($member);
            $rdata['user_token'] =$jwt_data['user_token'];
            $rdata['data']       =['name'=>$member['realname'],'mobile'=>$member['mobile'],'id'=>$member['id']];
            return $rdata;

        }else{
             return  CommonError::$SmsCodeError;
        }

    }




    public function get_xcx_userinfo_by_authorize($data)
    {
            $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$data['appid'].'&secret='.$data['appsecret'].'&js_code='.$data['jscode'].'&grant_type=authorization_code';
            $res = get($url, 'json');
            return json_decode(json_encode($res), true);  
    }
    
    /**
     * JWT验签方法
     */
    public static function tokenSign($member)
    {
        
        $key = API_KEY . JWT_KEY;
        
        //$jwt_data = ['member_id' => $member['id'], 'nickname' => $member['nickname'], 'username' => $member['username'], 'create_time' => $member['create_time']];
        $jwt_data = ['member_id' => $member['id'], 'username' => $member['username'], 'nickname' => $member['nickname'],'company_id' => $member['company_id']];
        $token = [
            "iss"   => "QingWaJia JWT",         // 签发者
            "iat"   => TIME_NOW,               // 签发时间
            "exp"   => TIME_NOW + TIME_NOW,    // 过期时间
            "aud"   => 'QingWaJia',             // 接收方
            "sub"   => 'QingWaJia',             // 面向的用户
            "data"  => $jwt_data
        ];
        
        $jwt = JWT::encode($token, $key);
        
        $jwt_data['user_token'] = $jwt;
        
        return $jwt_data;
    }
    
    /**
     * 修改密码
     */
    public function changePassword($data)
    {

        try{
            $member = get_member_by_token($data['user_token']);
        }catch (\Exception $e){
            $this->apiError(['code'=>'-1','msg'=>'解密user_token错误']);
        }
//        $member = get_member_by_token($data['user_token']);

        $member_info = $this->logicMember->getMemberInfo(['id' => $member->member_id]);

        if (empty($data['old_password']) || empty($data['new_password'])) {
            
            return CommonError::$oldOrNewPassword;
        }
        
        if (data_md5_key($data['old_password']) !== $member_info['password']) {
            
            return CommonError::$passwordError;
        }

        $member_info['password'] = $data['new_password'];
        
        $result = $this->logicMember->setInfo($member_info);
        
        return $result ? CodeBase::$success : CommonError::$changePasswordFail;
    }
    
  
}
