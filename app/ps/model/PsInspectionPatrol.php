<?php
namespace app\ps\model;
/**
* PsInspection模型
*/
class PsInspectionPatrol extends PsBase
{
	public $shift = array(
				'1' =>'早班',
				'2' =>'中班',
				'3' =>'晚班',
				);				

	public function getShift(){
		return ($this->shift);
	}

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
}
