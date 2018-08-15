<?php
namespace app\ps\model;
/**
* PsInspection模型
*/
class PsInspectionRecord extends PsBase
{
	public function recordDel($data=[])
	{
		$r = model('ps_inspection_record');
		$i = model('ps_inspection');
		\think\Db::startTrans();
		$del['status'] = -1;
		try {
			$type = $r->where('id',$data['id'])->value('record_type');
			$r->where('id',$data['id'])->update($del);
			switch ($type) {
				case '5':
					\think\Db::name('ps_inspection_sorting')->where('record_id',$data['id'])->update($del);
					break;
				case '6':
					\think\Db::name('ps_inspection_storage')->where('record_id',$data['id'])->update($del);
					break;
				default:
					$i->where('record_id',$data['id'])->update($del);
					break;
			}
			
			\think\Db::commit();
			return true;

		} catch (Exception $e) {
			\think\Db::rollback();
			throw $e->getMessage();			
			return false;
		}
	}

	public function recordEdit($data=[])
	{
		$r = model('ps_inspection_record');
		$res = $r->update($data);
		return $res?true:false;
	}

}
