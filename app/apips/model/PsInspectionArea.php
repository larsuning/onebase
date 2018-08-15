<?php
namespace app\apips\model;
/**
* PsInspection模型
*/
class PsInspectionArea extends ApiBase
{

	//获取当前区域数据并加以整理
	public function getArea($type){
		$where['area_type'] = $type;
		$where['status']    = '1';
		$area = \think\Db::name('ps_inspection_area');
		$max = $area->where($where)->max('times');
		$areas = $area->where($where)->field('id,times')->select();
		$data = array();
		for ($i=1; $i <=$max ; $i++) { 
			foreach ($areas as $key => $value) {
				if($i <= $value['times']){
					$data[$i-1][] = $value['id'];
				}
			}
		}
		return $data;
	}
}
