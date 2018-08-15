<?php
namespace app\ps\model;
/**
* PsInspection模型
*/
class PsInspection extends PsBase
{
	public $type = array(
				'1' => '农残检测表',
				'2' => '标品收货记录表',
				'3' => '生鲜收货记录表',
				'4' => '包装易耗品收货记录表',
		);

	public function addInpsection($data=[],$type)
	{
        //判断当前订单内同类型的表是否已经建立
        $where['record_type'] = $type;
        $where['purchase_id'] = $data['purchase_id'];
        $where['status']      = 1;
        $count = \think\Db::name("ps_inspection_record")->where($where)->field('id,goods_batch')->find();
        $goods_batch = $this->inspectionBatch();
        $data['product_total'] = $data['num'];
        $provider = $data['provider'];
        unset($data['id']);
        unset($data['num']);
        unset($data['provider']);
        unset($data['purchase_id']);
        // dd($data);
       
        if(!$count){
            $record_last_id = \think\Db::name('ps_inspection_record')->order('id desc')->limit(1)->value('id');
            $id = $record_last_id + 1;
        }else{
            $id = $count['id'];
        }
        $recordData = array(
                    'id'          => $id,
                    'record_type' => $type,
                    'goods_batch' => $goods_batch,
                    'purchase_id' => $where['purchase_id'],
                    'record_date'  => date('Y-m-d'),
                    'update_time' => time(),
                    'create_time' => time(),
                    'check_status'      => '0',
                    'name'        => $this->type[$type]
        );

        
        \think\Db::startTrans();
        try {
            if(!$count){
                \think\Db::name('ps_inspection_record')->insert($recordData);
            }else{
                $goods_batch = $count['goods_batch'];
            }

            $data['record_id'] = $id;
            $ins = model('ps_inspection');
            $ins->save($data);
            \think\Db::commit();
            $data['id'] = $ins->id;
            $data['goods_batch'] = $goods_batch;
            $data['provider']    = $provider;
            return $data;
        } catch (Exception $e) {
            \think\Db::rollback();
            throw($e);
        }
	}


	/**
	* 生成表数据
	 */
	public function creatData($purchase_id,$type){

   		$inspectionData = [];$recordData =[];
        $record_last_id = \think\Db::name('ps_inspection_record')->order('id desc')->limit(1)->value('id');
        
        $goods_batch = $this->inspectionBatch();

        $recordData = array(
                        'id' => ($record_last_id+1),
                        'purchase_id' => $purchase_id,
                        'record_type' => $type,
                        'goods_batch' => $goods_batch,
                        'record_date' => date('Y-m-d'),
                        'update_time' => time(),
                        'create_time' => time(),
                        'status'      => '1',
                        'name'        => $this->type[$type],
                    );

        $goods = \think\Db::name('ps_purchase_goods')
                            ->where('purchase_id',$purchase_id)
                            ->field('name,provider_id,goods_id,num,unit')
                            ->select();



        foreach ($goods as $key => $value) {
            $inspectionData[] = array(
                        'name'        => $value['name'],
                        'goods_id'    => $value['goods_id'],
                        'provider_id' => $value['provider_id'],
                        'product_total'  => $value['num'],
                        'status'      => '1',
                        'update_time' => time(),
                        'create_time' => time(),
                        'product_unit' => $value['unit'],
                        'record_id'   => $recordData['id'],
                );
        }

        //事务处理
        \think\Db::startTrans();
        try {
            \think\Db::name('ps_inspection_record')->insert($recordData);
            \think\Db::name('ps_inspection')->insertAll($inspectionData);
            \think\Db::commit();
            return $recordData['id'];
        } catch (Exception $e) {
            \think\Db::rollback();
            return [RESULT_ERROR,$e->getMessage()];
            
        }
	}

	//根据表类型和订单号获取商品数据
	public function getInspection($where)
	{  
        //来源选择订单时的参数
        if(isset($where['type'])){
            $where['record_type']  = $where['type'];
            unset($where['type']);
        }
        //页面渲染参数
        if(isset($where['check_status']))
        {
            $where['ps_inspection_record.check_status'] = $where['check_status'];
            unset($where['check_status']);
        }

        $where['ps_inspection.status'] = '1';
		$data = \think\Db::view('ps_inspection_record','goods_batch,record_type,record_date')
                            ->view('ps_inspection','goods_id,id,name,inspect_time,product_total,product_select,production_date,expire_date,unqualified_rate,is_qualified,is_certificate,remark,product_unit,unqualified_num','ps_inspection_record.id=ps_inspection.record_id')
							->view('provider',['name'=>'provider'],'ps_inspection.provider_id = provider.id','LEFT')
							->where($where)
							->select();
                            // dd($data);
		if(!$data) \think\log::write('订单id为'.$where['purchase_id'].'的商品数据获取错误','error');
       
        // dd($data);
		return $data?$data:false;

	}

    /**
     * 生成质检商品批号
     */
    protected function inspectionBatch()
    {
        
        function unique(){
            return date('YmdHis') . str_shuffle(str_pad(mt_rand(1000, 999999), 6, '0', STR_PAD_LEFT));
        }

        do {
            $batchs = 'ZJ' . unique();
            // 1.查询订单编号是否重复
            $info = $this->modelPsInspectionRecord->getInfo(['goods_batch' => $batchs],'id');
        }
            // 2.存在->执行 do{}
        while($info);
            // 3.返回唯一单号
        return $batchs;


    }

}
