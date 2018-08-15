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

namespace app\source\logic;

use app\source\error\CodeBase;
use app\source\error\Common as CommonError;
use \Firebase\JWT\JWT;

/**
 * 接口基础逻辑
 */
class Common extends SourceBase
{

    /**
     * 登录接口逻辑
     */
    public function login($data = [])
    {

        $validate_result = $this->validateMember->scene('login')->check($data);
        
        if (!$validate_result) {

            return CommonError::$usernameOrPasswordEmpty;
        }

        begin:

        $member = $this->logicMember->getMemberInfo(['username' => $data['username']]);
        // 若不存在用户则注册
        if (empty($member))
        {
            $register_result = $this->register($data);
            
            if (!$register_result) {
                
                return CommonError::$registerFail;
            }
            
            goto begin;
        }
        
        if (data_md5_key($data['password'],$member['salt']) !== $member['password']) {
            
            return CommonError::$passwordError;
        }
        
        return $this->tokenSign($member);
    }
    
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
            $wbdata=['openid'=>$openid,'access_token'=>get_access_token()];
            $wx=$this->modelWechatFans->getInfo(['appid' =>$data['appid'],'openid' =>$openid], 'id');
            if($wx['id']){
                   $this->modelWechatFans->setInfo(['id'=>$wx['id'],'session_key'=>$user['session_key']]);
                   $wxbd=$this->modelWechatRelation->getInfo(['openid' =>$openid], 'id,member_id');
                   if($wxbd['member_id']){
                            $member = $this->modelMember->getInfo(['id' => $wxbd['member_id']]);
                            if($member['status']){
                                $jwt_data=$this->tokenSign($member);
                                $rdata['access_token']=get_access_token();
                                $rdata['user_token']= $jwt_data['user_token'];
                                $rdata['openid']= $openid;
                                $rdata['entrance']=$this->Entrance($member['id'],10);//蛙标小程序入口module id=10
                              //  $rdata['member'] = get_member_by_token($jwt_data['user_token']);
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
             return [API_CODE_NAME => 0, API_MSG_NAME=>'OPID未绑定','data'=>$wbdata];
         }
      }else{
             return CommonError::$appAuthFail;
      }
    }

    /**
     * 入口
     */
    public function Entrance($member_id,$module_id=0)
    {   
        $map['status']=1;
        if($module_id) $map['module_id']=$module_id;
        $entrancelist=$this->modelEntrance->where($map)->field('name,icon,url')->select();
        return $entrancelist;
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


    public function get_xcx_userinfo_by_authorize($data)
    {
            $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$data['appid'].'&secret='.$data['appsecret'].'&js_code='.$data['jscode'].'&grant_type=authorization_code';
            $res = get($url, 'json');
            return json_decode(json_encode($res), true);  
    }
     /**
     * 发短信服务
     */
    private function SendSmsCode($data=[])
    {

        $type=isset($data['type'])?$data['type']:1;//0登录 1注册  2修改密码 
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
        //$s=true;
        $s=$this->serviceSms->driverAlidy->sendSms($parameter);
        if($s){
            return CodeBase::$success;
            //return ['smscode'=>$sms['code']];
        }else{
            return CommonError::$sendSmsCodeFail;   
        }
    }

     /**
     * 登录处理
     */
    public function smscoderegister($data=[])
    {
               
        $mm['mobile']=$data['mobile'];
        $mm['type']=1;
        $mm['is_use']=0;
        $mm['create_time']=['gt',time()-600];
        $code=$this->modelSmsCode->where($mm)->order('id desc')->value('code');

        if($code==$data['code']){
               $this->modelSmsCode->setFieldValue(['code'=>$data['code'],'mobile'=>$data['mobile']],'is_use',1);
               $member = $this->modelMember->getInfo(['mobile' => $data['mobile']]);
               if(!$member){
                unset($data['code']);
                unset($data['access_token']);
                $data['is_bind_wechat']=1;
                $data['company_id']=3;
                $data['nickname']=$data['realname'];
                $data['username']=$data['mobile'];
                $salt=getsjstr();//默认获取8为随机数
                $data['salt']=$salt;
                $data['password']=data_md5_key($data['mobile'],$salt);
                $data['id']=$this->modelMember->addInfo($data);
                $member=$data;
               }
               $this->modelMember->setFieldValue(['id'=>$member['id']],'check_mobile',1);
               $Relation = $this->modelWechatRelation->getInfo(['member_id' => $member['id'],'openid'=>$data['openid']]);
               if(!$Relation){
                   $Relationdata['member_id']=$member['id'];
                   $Relationdata['openid']=$data['openid'];
                   $this->modelWechatRelation->setInfo($Relationdata);
               }
               $jwt_data=$this->tokenSign($member);
               $rdata['access_token']=get_access_token();
               $rdata['user_token']= $jwt_data['user_token'];
               $rdata['entrance']=$this->Entrance($member['id'],10);//蛙标小程序入口module id=10
             // $rdata['openid']= $data['openid'];
              return $rdata;
        }else{
             return  CommonError::$SmsCodeError;
        }
       
    }

    /**
     * 注册方法
     */
    public function register($data)
    {
        
        $data['nickname']  = $data['username'];
        $data['password']  = data_md5_key($data['password']);

        return $this->logicMember->setInfo($data);
    }
    
    /**
     * JWT验签方法
     */
    public static function tokenSign($member)
    {
        
        $key = API_KEY . JWT_KEY;
        
        //$jwt_data = ['member_id' => $member['id'], 'nickname' => $member['nickname'], 'username' => $member['username'], 'create_time' => $member['create_time']];
        $jwt_data = ['member_id' => $member['id'],'company_id' => $member['company_id']];
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
    
    /**
     * 友情链接
     */
    public function getBlogrollList($data)
    {
        /*try{
            $member = get_member_by_token($data['user_token']);
        }catch (\Exception $e)
        {
//            $this->apiError(['code'=>-1,'msg'=>'未知错误']);
        }
        return ['code'=>1,'msg'=>'ok'];*/
        $member = get_member_by_token($data['user_token']);
        return $this->modelBlogroll->getList([DATA_STATUS_NAME => DATA_NORMAL], true, 'sort desc,id asc', false);
    }

    /**
     * 省城县
     */
    public function getRegion($data)
    {

        isset($data['upid']) ? $where['upid'] =$data['upid'] : $where['upid'] = DATA_DISABLE;

        $cache_key = 'cache_region_'.md5(serialize($where));

        $cache_list = cache($cache_key);

        if($cache_list) return $cache_list;

        $list = $this->modelRegion->where($where)->select();

        !empty($list) && cache($cache_key,$list);

        return $list;
    }
}
