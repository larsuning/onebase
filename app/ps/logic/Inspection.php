<?php
namespace app\ps\logic;

class Inspection extends PsBase
{
    /**
     * 获取inspection列表搜索条件
     */
    public function getWhere($data = [])
    {

        $where = [];

        !empty($data['search_data']) && $where['name'] = ['like', '%'.$data['search_data'].'%'];
        !empty($data['search_date']) && $where['record_date'] = $data['search_date'];
        !empty($data['search_table']) && $where['record_type'] = $data['search_table'];

        return $where;
    }

    /**
     * 获取record列表
     */
    public function getRecordList($where = [], $field = '*', $order = '', $paginate = '10')
    {
        $field = '*';
        $order = 'update_time desc';

        $datas= $this->modelPsInspectionRecord->getList($where, $field, $order, $paginate );
        foreach ($datas as $key => $value) {
            if($value['member_id'] !=='0'){
                $datas[$key]['member'] = \think\Db::name('member')->where('id',$value['member_id'])->value('username');
            }


            if($value['review_member_id'] !=='0'){
                $datas[$key]['reviewer'] = \think\Db::name('member')->where('id',$value['review_member_id'])->value('username');
            }
        }

        return $datas;
    }

    /**
    *删除record数据
    */
    public function recordDel($data=[])
    {
        $result = $this->modelPsInspectionRecord->recordDel($data);
        $result && action_log('删除','删除记录表'.'，id:'.$data['id']);
        return $result?[RESULT_SUCCESS,'操作成功']:[RESULT_ERROR,'网络异常'];
    }
   
   /**
    *更新record数据
    */
    public function recordEdit($data=[])
    {

        if(isset($data['inspection_id'])){
            $data['id'] = \think\Db::name('ps_inspection')->where('id',$data['inspection_id'])->value('record_id');
            $data['check_status'] = '1';
            $data['member_id'] = MEMBER_ID;

            unset($data['inspection_id']);
        }

        if(isset($data['sorting_id'])){
            $data['id'] = \think\Db::name('ps_inspection_sorting')->where('id',$data['sorting_id'])->value('record_id');
            $data['check_status'] = '1';
            $data['member_id'] = MEMBER_ID;

            unset($data['sorting_id']);
        }

        if(isset($data['storage_id'])){
            $data['id'] = \think\Db::name('ps_inspection_storage')->where('id',$data['storage_id'])->value('record_id');
            $data['check_status'] = '1';
            $data['member_id'] = MEMBER_ID;

            unset($data['storage_id']);
        }

        if(isset($data['review_note'])){
            $data['check_status'] = '2';
            $data['review_member_id'] = MEMBER_ID;
        }
        $url = url('recordlist');

        //防止重复审核
        if($data['check_status'] == '2'){
            $check_status = \think\Db::name('ps_inspection_record')->where('id',$data['id'])->value('check_status');

            if( $check_status == '2'){
                return [RESULT_ERROR,'该记录已通过审核',$url];
            }
        }
        // dd($data);

        $result = $this->modelPsInspectionRecord->recordEdit($data);
        if($result){
            if($data['check_status'] == '1'){
                action_log('提交', '提交记录表' . '，id：' . $data['id']);
            }
            
            if($data['check_status'] == '2'){
                action_log('审核', '审核通过记录表' . '，id：' . $data['id']);
            }
        }
        return $result?[RESULT_SUCCESS,'操作成功',$url]:[RESULT_ERROR,'网络异常'];
    }

    /**
     * 获取Inspection列表
     */
    public function getAreaList($where = [], $field = '*', $order = '', $paginate = 0)
    {
        //$this->modelPsInspection->alias('a');
        $field = 'id,name,create_time,status';
        $order = 'sort asc';
        return $this->modelPsInspectionArea->getList($where, $field, $order, $paginate);
    }


    public function areaAdd($data =[])
    {
        //获取Info
        if( count($data) == 1 && isset($data['id'])){
            $where['id'] = $data['id'];
            return $this->getAreaInfo($where);
        } 
        $validate_result = $this->validateInspectionArea->scene('add')->check($data);

        if (!$validate_result) {

            return [RESULT_ERROR, $this->validateInspectionArea->getError()];
        }
        $data['member_id'] = MEMBER_ID;
        $data['status']    = 1;
        $result = $this->modelPsInspectionArea->setInfo($data);


        return $result ? [RESULT_SUCCESS, '操作成功'] : [RESULT_ERROR, $this->modelPsInspectionArea->getError()];
    }
  


    /**
    * 获取area信息
    */
    public function getAreaInfo($where = [], $field = true)
    {
        $field = 'name,times,id,sort';
        return [RESULT_DATA,$this->modelPsInspectionArea->getInfo($where, $field)];
    }


    /**
    * Inspection删除
    */
    public function inspectionDel($where = [])
    {

        $result = $this->modelPsInspection->deleteInfo($where);


        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->modelPsInspection->getError()];
    }

    /**
    * area删除
    */
    public function areaDel($where = [])
    {

        $result = $this->modelPsInspectionArea->deleteInfo($where);

        $result && action_log('删除', '区域删除' . '，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->modelPsInspection->getError()];
    }

    /**
    * 添加农残检测记录
    */
    public function agricultureAdd( $data=[] )
    {    

        if(isset($data['good_id'])){
             $data  = \think\Db::view('ps_purchase_goods','id,name,status,purchase_id,num,provider_id,goods_id')
                            ->view('provider',['name'=>'provider'],'ps_purchase_goods.provider_id = provider.id','Left')
                            ->where('id',$data['good_id'])
                            ->find();
        } 
        $result = $this->modelPsInspection->addInpsection($data,1);
        return $result?[RESULT_DATA,$result]:[RESULT_ERROR,'表数据添加错误'];
    }

    /**
    * 添加生鲜收货记录
    */
    public function freshAdd( $data=[] )
    {   
        if(isset($data['good_id'])){
             $data  = \think\Db::view('ps_purchase_goods','id,name,status,purchase_id,num,provider_id,goods_id')
                            ->view('provider',['name'=>'provider'],'ps_purchase_goods.provider_id = provider.id','Left')
                            ->where('id',$data['good_id'])
                            ->find();
        }    
        $result = $this->modelPsInspection->addInpsection($data,3);
        return $result?[RESULT_DATA,$result]:[RESULT_ERROR,'表数据添加错误'];
    }

    /**
    * 根据订单获取标品数据
    */
    public function getMarks($data=[],$type){
        if( isset($data['purchase_id'])){
            $data['record_type'] = $type;
            $data['status'] = 1;

            //判断当前质检数据是否存在
            $count = \think\Db::name('ps_inspection_record')->where($data)->count();
            if( !$count ){
                $res = $this->modelPsInspection->creatData($data['purchase_id'],$type);
                if(!$res) return [RESULT_ERROR,$res];
            }

            $data['record_type'] =$type;
            unset($data['status']);
            $result = $this->modelPsInspection->getInspection($data);

            return $result?[RESULT_DATA,$result]:[RESULT_ERROR,'采购单数据不完整，请先补充完整采购订单。'];

        }


        //已生成的商品数据中 
        if( !$data ){
            $data['purchase_id'] = \think\Db::name('ps_inspection_record')->order('purchase_id desc')->where('record_type',$type)->limit(1)->value('purchase_id');
            $data['record_type'] = $type;
        }

        //审核页参数转换
        if(isset($data['review'])){
            $data['purchase_id'] = \think\Db::name('ps_inspection_record')->where('id',$data['review'])->value('purchase_id');
            // $data['status'] = 1;
            if(isset($data['reviewer'])){
                unset($data['reviewer']);
                unset($data['review_time']);
            }
            unset($data['review']);
            unset($data['checker']);
        }

        $result= $this->modelPsInspection->getInspection($data);
        if(!$result) return false;

        $sn = \think\Db::name('ps_purchase')->where('id',$data['purchase_id'])->column('sn');
        $result = array_merge($sn,$result);

        return $result?$result:false;


        // dd($data['id']);
    }

    public function updateInspection($data = [])
    {
        $result = \think\Db::name('ps_inspection')->update($data);
        return $result?[RESULT_SUCCESS,'操作成功']:[RESULT_ERROR,'数据更新失败'];
    }

    /**
    * 获取订单信息
    */
    public function getPurchase($param)
    {
        //判断是否为标品 1->标品 2->非标品
        $where['sign'] = $param['mark'];
        // dd($param);
        $where['sn']  =['like','%'.$param['q_word'][0].'%'];
        $where['status'] = 1;
        if( $param['mark'] == '1' ){
            //去除标品类已完成记录表提交的订单
            $map['check_status'] = ['gt','0'];
            $map['record_type'] = ['in','2,4'];
            $map['status']      = 1;
            $complete_ids = \think\Db::name('ps_inspection_record')
                                ->where($map)
                                ->column('purchase_id');


            $purchase_ids = \think\Db::name('ps_inspection_record')
                                ->where("record_type",'not in',$param['type'])
                                ->where('status','1')
                                ->group('purchase_id')
                                ->column('purchase_id');
            $purchase_ids = array_merge($purchase_ids,$complete_ids);                    
            $purchase_ids = implode($purchase_ids, ',');

            $where['id'] = ['not in',$purchase_ids];

        }else{
            $map['check_status'] = ['gt','0'];
            $map['record_type'] = $param['type'];
            $map['status']      = 1;

            $purchase_ids = \think\Db::name('ps_inspection_record')
                                ->where($map)
                                ->column('purchase_id');
            $purchase_ids = implode($purchase_ids, ',');

            $where['id'] = ['not in',$purchase_ids];
        }

        $data = \think\Db::name('ps_purchase')->where($where)
                                        ->limit(($param['pageNumber']-1)*$param['pageSize'],$param['pageSize'])
                                        ->order('create_time desc')
                                        ->field('id,sn')
                                        ->select();
        $count=\think\Db::name('ps_purchase')->where($where)->count();
        
        $d['totalRow'] = $count;
        $d['list']     = $data;
        $d = json_encode($d);

        die($d);

    }

    /**
    *获取订单内商品信息
     */
    public function getGoods($data=[])
    {
        $where['purchase_id'] = $data['purchase_id'];
        if(isset($data['q_word'])){
            $where['name']        = ['like','%'.$data['q_word'][0].'%'];
            $page = ($data['pageNumber']-1)*$data['pageSize'];
            $pageSize = $data['pageSize'];
            $limit = $page.','.$pageSize;
        }else{
            $limit = '';
        }
        $where['status']      = 1;

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
                            ->limit($limit)
                            ->order('ps_purchase_goods.sort asc')
                            ->select();
        $count=\think\Db::name('ps_purchase_goods')->where($where)->count();


        $d['totalRow'] = $count;
        $d['list']     = $data;
        if(!$limit){
            $d = array();
            foreach ($data as $k => $v) {
                $d['data'][] = array_values($v);
            }
        }

        $d = json_encode($d);

        die($d);

    }

    //获取非标品数据
    public function getUnmarkData($data =[]){
        //审核参数转换;
        if( isset($data['review'])){
            $data['purchase_id'] = \think\Db::name('ps_inspection_record')->where('id',$data['review'])->value('purchase_id');
            unset($data['review']);
        }

        if(!isset($data['purchase_id'])){
            return false;
        }
        $result = $this->modelPsInspection->getInspection($data);

        return $result?[RESULT_DATA,$result]:[RESULT_ERROR,'获取数据为空'];

    }

    //根据record_id获取审核记录数据
    public function getReviewData($id)
    {
        $data = \think\Db::view("ps_inspection_record r",'update_time,review_note,record_date,shift,goods_batch')
                            ->view('member',['username'=>'checker'],'r.member_id = member.id','LEFT')
                            ->view('member m',['username'=>'reviewer'],'r.review_member_id = m.id','LEFT')
                            ->where('r.id',$id)
                            ->find();

        return $data?$data:false;
    }
    
}
