<?php
namespace app\apips\model;
/**
* PsInspection模型
*/
class PsInspectionRecord extends ApiBase
{
	public function recordDel($id)
	{
		$r = model('ps_inspection_record');
		$i = model('ps_inspection');
		$del['status'] = -1;
		\think\Db::startTrans();
		try {
			$type = $r->where('id',$id)->value('record_type');
			$r->where('id',$id)->update($del);
			switch ($type) {
				case '5':
					\think\Db::name('ps_inspection_sorting')->where('record_id',$id)->update($del);
					break;
				case '6':
					\think\Db::name('ps_inspection_storage')->where('record_id',$id)->update($del);
					break;
				default:
					$i->where('record_id',$id)->update($del);
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
