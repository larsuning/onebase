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
class Inspection extends ApiBase
{
	public function getPurchase($data=[])
	{
		
		//判断当前采购单是否提交
		$map['record_type'] = $data['type'];
        $map['check_status'] = ['gt','0'];
		$map['status'] = 1;

		if($data['type'] == 2 || $data['type'] == 4){
			//去除当前类型已提交的订单id
			$erase = \think\Db::name('ps_inspection_record')
                            ->where($map)
                            ->column('purchase_id');
            $erase1 = \think\Db::name('ps_inspection_record')
            			    ->where('record_type','not in',$data['type'])
            			    ->column('purchase_id');
           	$erase = array_merge($erase,$erase1);

		}else{
			$erase = \think\Db::name('ps_inspection_record')
                                ->where($map)
                                ->column('purchase_id');
		}

		
       	$erase = implode($erase, ',');

        //1->标品 2->非标品
		$where['sign']   = ($data['type'] == 1 || $data['type'] == 3)?2:1;
		$where['status'] = 1;
		$where['id']     = ['not in',$erase];

		$data = \think\Db::name('ps_purchase')->where($where)->field('id,sn')->select();
		return $data?$data:[API_CODE_NAME => -1, API_MSG_NAME=>'当前表订单数据已完成。'];

	}

    public function getDataByPurchase($data = [])
    {
        unset($data['user_token']);
        $rdata = $this->modelPsInspection->getInspection($data);

        return $rdata?$rdata:[API_CODE_NAME => -1, API_MSG_NAME=>'当前订单内表数据为空。'];

    }

	public function getGoods($data=[])
	{
		$where['purchase_id'] = $data['purchase_id'];
		$where['status']  =1;

        //剔除已添加的商品
        $goods_ids = \think\Db::view('ps_inspection_record','id,purchase_id')
                                ->view('ps_inspection','goods_id','ps_inspection_record.id = ps_inspection.record_id')
                                ->where('purchase_id',$where['purchase_id'])
                                ->where('ps_inspection.status',$where['status'])
                                ->column('goods_id');

        $goods_ids = implode($goods_ids, ',');
        $where['goods_id'] = ['not in',$goods_ids];



        $data  = \think\Db::view('ps_purchase_goods','id,name,status,purchase_id,num,provider_id,goods_id')
                            ->view('provider',['name'=>'provider'],'ps_purchase_goods.provider_id = provider.id','Left')
                            ->where($where)
                            ->order('ps_purchase_goods.sort asc')
                            ->select();
        return $data; 
      	
	}

	public function inspectionAdd($data=[] )
	{  
        //非标品数据生成
        if( isset($data['good_id']) && $data['good_id'] !==''){
            $goods_id = explode(',', $data['good_id']);

            $result = [];
            foreach ($goods_id as $key => $value) {
                $good_info  = \think\Db::view('ps_purchase_goods','id,name,status,purchase_id,num,provider_id,goods_id')
                            ->view('provider',['name'=>'provider'],'ps_purchase_goods.provider_id = provider.id','Left')
                            ->where('id',$value)
                            ->find();

                $good_info['type'] = $data['type'];

                $result[] = $this->modelPsInspection->inspectionAdd($good_info);
            }
        }else if( isset($data['purchase_id']) && $data['purchase_id'] !=='' ){
        //标品数据生成
            $map['purchase_id'] = $data['purchase_id'];
            $map['record_type'] = $data['type'];
            $count = \think\Db::name('ps_inspection_record')->where($map)->count();
            if(!$count){
                $this->modelPsInspection->creatData($map['purchase_id'],$map['record_type']);
            }
            $result = $this->modelPsInspection->getInspection($map);
        }else{
            [API_CODE_NAME=> -1,API_MSG_NAME=>'请求参数错误'];
        }

        return $result?$result:CommonError::$mysqlConectFail;

	}

    public function addOne($data=[]){
        $info['id'] =$data['id'];
        $info['update_time'] = time();
        $info[$data['field']] = $data['value'];

        //根据表类型更新不同表
        $type = isset($data['type'])?$data['type']:1;
        switch ($type) {
                    case '5':
                        $result = \think\Db::name('ps_inspection_sorting')->update($info);
                        break;
                     case '6':
                        $result = \think\Db::name('ps_inspection_storage')->update($info);
                        break;
                    default:
                        $result = $this->modelPsInspection->setInfo($info);
                        break;
                }        
        
        
        return $result?[API_CODE_NAME=> 0,API_MSG_NAME=>'添加成功']:CommonError::$mysqlConectFail;
    }

    public function getAreaData($data=[])
    {
        $result = $this->modelPsInspectionPatrol->getAreaData($data);
        return $result?$result:CommonError::$mysqlConectFail;
    }

    public function finishRecord($data=[])
    {
        $update['check_status'] = 1;
        $update['member_id'] = $this->getMemberIdByToken($data['user_token']);
        $update['update_time'] = time();
        $result = \think\Db::name('ps_inspection_record')
                                ->where('id',$data['record_id'])
                                ->update($update);

        return $result?[API_CODE_NAME=> 0,API_MSG_NAME=>'提交成功']:CommonError::$mysqlConectFail;

    }

    public function getRecord($data=[])
    {
        $times = isset($data['times'])?intval($data['times']):0;
        $start = $times*8;
        $where['record_type'] = $data['type'];
        //获取班次
        $shift = $this->modelPsInspectionPatrol->shift;

        // $where['check_status'] = '1';
        if( isset($data['key_words']) && $data['key_words']!=='' ){
            $where['goods_batch'] = ['like','%'.$data['key_words'].'%'];
        }

        if( isset($data['date_begin']) && $data['date_begin'] !=='' && isset($data['date_end']) && $data['date_end'] !== ''){
            $where['record_date'] = ['between time',[$data['date_begin'],$data['date_end']]];
        }


        //表数据获取
        $result = \think\Db::view('ps_inspection_record','goods_batch,id,record_type,shift,check_status')
                                    ->view('member',['realname'=>'checker'],'ps_inspection_record.member_id = member.id','left')
                                    ->where($where)
                                    ->limit($start,8)
                                    ->select();
        $check_status= array(
                        '0'=> '未提交',
                        '1'=> '待审核',
                        '2'=> '审核完成',
                    );

        $uid = $this->getMemberIdByToken($data['user_token']);
        $role = \think\Db::name('member')->where('id',$uid)->value('nickname');

        if($role =='质检主管' ){
            $review = '1';
        }else{
            $review = '0';
        }

        //质检表数据显示整理
            
        foreach ($result as $k => $v) {
            $result[$k]['check_status'] = $check_status[$v['check_status']];
            if($v['check_status'] == '1' && $review == '1'){
                $result[$k]['review'] = '1';
            }else{
                $result[$k]['review'] = '0';
            }

            if( in_array($data['type'], [1,2,3,4])){

                if($data['type'] == 1){
                    $inspection = \think\Db::name('ps_inspection')->where('record_id',$v['id'])->column('id,is_qualified');
                    if( in_array('0', $inspection) ){
                        $result[$k]['status'] = '检查有异常';
                    }else{
                        $result[$k]['status'] = '检查正常';
                    }
                }else{
                    $inspection = \think\Db::name('ps_inspection')->where('record_id',$v['id'])->column('id,unqualified_num');
                    $result[$k]['status'] = '检查无异常';
                    foreach ($inspection as $key => $value) {
                        if($value > 0){
                            $result[$k]['status'] = '检查有异常';
                            break;
                        }
                    }
                    
                }
            }else{
            //质检表数据显示整理
                foreach ($result as $k => $v) {
                   $result[$k]['shift'] = $shift[$v['shift']];
                }
                
            }
        }

        return $result?$rdata:[API_CODE_NAME=> -1,API_MSG_NAME=>'当前数据为空'];
    }

    public function getRecordDetail($data=[])
    {
        $rdata['data'] = \think\Db::name('ps_inspection')
                            ->where('record_id',$data['id'])
                            ->order('update_time desc')
                            ->select();
        $check_status = \think\Db::name('ps_inspection_record')->where('id',$data['id'])->value('check_status');
        $uid          = $this->getMemberIdByToken($data['user_token']);
        $role         = \think\Db::name('member')->where('id',$uid)->value('nickname');

        switch ($check_status) {
            case '0':
                $rdata['info'] = '';
                break;
            case '1':
               
                $rdata['info'] = \think\Db::view('ps_inspection_record','update_time')
                                    ->view('member',['realname'=>'checker'],'ps_inspection_record.member_id = member.id','left')
                                    ->where('ps_inspection_record.id',$data['id'])
                                    ->select();

                if($role == '质检主管'){
                    $rdata['review'] = '1';
                }else{
                    $rdata['review'] = '';
                }
                break;
            case '2':
                $rdata['info'] = \think\Db::view('ps_inspection_record','update_time,review_note')
                                    ->view('member',['realname'=>'checker'],'ps_inspection_record.member_id = member.id','left')
                                    ->view('member m',['username'=>'reviewer'],'r.review_member_id = m.id','LEFT')
                                    ->where('ps_inspection_record.id',$data['id'])
                                    ->select();
                break;
            
            default:
               $data['info'] = 'something went wrong';
                break;
        }
      

      
        return $rdata['data']?$rdata:[API_CODE_NAME=> -1,API_MSG_NAME=>'当前数据为空']; 
    }

    public function submitReview($data=[])
    {
        $update['review_member_id'] = $this->getMemberIdByToken($data['user_token']);
        $update['review_note']      = $data['note'];
        $update['update_time']      = time();
        $update['check_status']     = 2;

        if(\think\Db::name('member')->where('id',$update['review_member_id'])->value('nickname') !== '质检主管'){
            return [API_CODE_NAME=> -1,API_MSG_NAME=>'当前账号无权限审核'];
        }

        if(\think\Db::name('ps_inspection_record')->where('id',$data['record_id'])->value('check_status') == 0){
            return [API_CODE_NAME=> -1,API_MSG_NAME=>'当前表格尚未完成'];
        }

        $result = \think\Db::name('ps_inspection_record')->where('id',$data['record_id'])->where('status','1')->update($update);
        return $result?[API_CODE_NAME=> 0,API_MSG_NAME=>'审核完成']:CommonError::$mysqlConectFail;

    }

    public function recordDel($data = [])
    {
        $uid = $this->getMemberIdByToken($data['user_token']);

        if(\think\Db::name('member')->where('id',$uid)->value('nickname') !== '质检主管'){
            return [API_CODE_NAME=> -1,API_MSG_NAME=>'当前账号无权限删除'];
        }

      

        $result = $this->modelPsInspectionRecord->recordDel($data['record_id']);
        return $result?[API_CODE_NAME=> 0,API_MSG_NAME=>'删除成功']:CommonError::$mysqlConectFail;
    }

    private function getMemberIdByToken($token){
        
        $d = (decoded_user_token($token));
        $uid = $d['data']->member_id;
        return $uid;
    }
}