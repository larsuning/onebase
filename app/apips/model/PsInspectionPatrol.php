<?php
namespace app\apips\model;
/**
* PsInspection模型
*/
class PsInspectionPatrol extends ApiBase
{
	public $shift = array(
				'1' =>'早班',
				'2' =>'中班',
				'3' =>'晚班',
				);				

	
	public function getShiftData($param,$which){

		$where['record_date'] = isset($param['record_date'])?$param['record_date']:date('Y-m-d');
		$where['shift']       = $param['shift'];
		$where['record_type'] = $which =='sorting'?'5':'6';
		$where['status']      =1;

		
		$record_id = \think\Db::name('ps_inspection_record')->where($where)->value('id');
		$max = \think\Db::name('ps_inspection_'.$which)->where('record_id',$record_id)->max('round');
		$data = array();
		for ($i=1; $i <$max+1 ; $i++) { 
			$data[] = \think\Db::view('ps_inspection_'.$which,'*')
						   ->view('ps_inspection_area',['name'=>'area'],'ps_inspection_'.$which.'.area_id = ps_inspection_area.id')   
						   ->where('record_id',$record_id)
						   ->where('round',$i)
						   ->select();
		}
		return $data?$data:false;
	}

	public function getAreaData($param=[]){
		
		//存储区表和分拣区判断
		$where['record_type'] = $param['type'];
		$table      = $param['type'] == 5?'sorting':'storage';
		$table_name = $param['type'] == 5?'分拣区巡查表':'存储区巡查表';
		$area_type  = $param['type'] == 5?'0':'1';

		$shift = $this->shift;	
		//判断当天分拣巡查表是否存在
		$where['record_date'] = isset($data['record_date'])?$data['record_date']:date('Y-m-d');
		$where['status'] = 1;
		//获取缺失的班次
		$shifts =[];
		foreach ($shift as $key => $value) {
			$where['shift'] = $key;
			$where['status'] = 1;
			$tem = \think\Db::name("ps_inspection_record")->where($where)->count();
			if(!$tem){
				$shifts[] = $key;
			}
		}

		//如果不存在某些班次记录则生产新的记录
		if($shifts){
			$list  = array(); $d = array();
			$area = $this->modelPsInspectionArea->getArea($area_type);

			$record_last_id = \think\Db::name('ps_inspection_record')->order('id desc')->limit(1)->value('id');
			$i = $record_last_id == null?0:$record_last_id;

			foreach ($shifts as $key => $value) {
				$i++;

				$list[]= array(
						'id'          => $i,
						'record_date' => $where['record_date'],
						'record_type' => $param['type'],
						'check_status'=> '0',
						'status'      => '1',
						'name'        => $table_name,
						'shift'       => $value,
						'create_time' => time(),
						'update_time' => time(),
					);

				foreach ($area as $k => $v) {
					foreach ($v as $k1 => $v1) {
						$d[] = array(
							'round'   => $k+1,
							'area_id' => $v1,
							'status'  => 1,
							'record_id'   =>$i,
							'update_time' =>time(),
							'create_time' =>time(),
						);
					}
					
				}
				// dd($d);
			}

			//事务处理
			\think\Db::startTrans();
			try {
				//生成表数据
				\think\Db::name("ps_inspection_record")->insertAll($list);
				\think\Db::name('ps_inspection_'.$table)->insertAll($d);
				\think\Db::commit();
			} catch (Exception $e) {
				\think\Db::rollback();
				return[RESULT_ERROR,$e->getMessage()];
				
			}
			

		}

		//获取当前早班分拣巡查表数据
		unset($where['shift']);
		$where['check_status'] = 0;
		$where['status']       = 1;
		$shift = \think\Db::name('ps_inspection_record')
								->where($where)
								->order('shift asc')
								->limit(1)
								->value('shift');
		
								
		$data['shift'] = isset($param['shift'])?$param['shift']:$shift;
		if(isset($param['review'])){
			$data = \think\Db::name('ps_inspection_record')
								->where('id',$param['review'])
								->where('status','1')
								->field('shift,record_date')
								->find();
		}

		return $this->getShiftData($data,$table);

	}


	public function getShift($type)
	{

		$shift = array(
				'1' =>'早班',
				'2' =>'中班',
				'3' =>'晚班',
				);

		$where['record_date'] = date('Y-m-d');
		$where['record_type'] = $type;	
		$where['check_status'] = ['gt','0'];	
		$where['status'] = 1;	

		$data = \think\Db::name('ps_inspection_record')
								->where($where)
								->order('shift asc')
								->column('shift');
		foreach ($data as $key => $value) {
			unset($shift[$value]);
		}

		return $shift;
	}
}
