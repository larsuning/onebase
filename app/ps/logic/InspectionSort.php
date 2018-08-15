<?php
namespace app\ps\logic;
/**
* 分拣数据逻辑控制
*/
class InspectionSort extends PsBase
{
	public function getForm($param=[]){
		//判断当天分拣巡查表是否存在
		$where['record_date'] = date('Y-m-d');
		$where['record_type'] = '5';
		$where['status'] = 1;
		
		$shift = $this->modelPsInspectionPatrol->getShift();
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

			$area = $this->modelPsInspectionArea->getArea(0);
			$record_last_id = \think\Db::name('ps_inspection_record')->order('id desc')->limit(1)->value('id');
			$i = $record_last_id == null?0:$record_last_id;

			foreach ($shifts as $key => $value) {
				$i++;

				$list[]= array(
						'id'          =>$i,
						'record_date' => date('Y-m-d'),
						'record_type' => '5',
						'check_status' => '0',
						'status'      => 1,
						'name'        => '分拣区巡查表',
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
				\think\Db::name('ps_inspection_sorting')->insertAll($d);
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

		return $this->modelPsInspectionPatrol->getShiftData($data,'sorting');

	}

	public function sortingAdd($data=[]){
		unset($data['shift']);

		$result = \think\Db::name('ps_inspection_sorting')->update($data);
		return $result ? [RESULT_SUCCESS, '操作成功'] : [RESULT_ERROR, $this->modelPsInspection->getError()];
	}

	public function getShift()
	{

		$shift = array(
				'1' =>'早班',
				'2' =>'中班',
				'3' =>'晚班',
				);
		$where['record_date'] = date('Y-m-d');
		$where['record_type'] = '5';	
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