<?php
namespace app\ps\validate;
/**
* Inspection验证器
*/
class Inspection extends PsBase
{

		// 验证规则
		protected $rule =   [

			'name'              => 'require',
			'record_type'       => 'require|number',
			'goods_id'          => 'require|number',
			'provider_id'       => 'require|number',
			'goods_batch'       => 'require',
			'inspect_time'      => 'require',
			'product_total'     => 'require|number',
			'product_select'    => 'require|number',
			'is_qualified'      => 'require',
			'is_certificate'    => 'require',
			'production_date'   => 'require',
			'expire_date'       => 'require',
	        'unqualified_rate'  => 'require',
		];

		// 验证提示
		protected $message  =   [

			'name.require'                 => '商品尚未选择',
			'provider_id.require'          => '供应商尚未选择',
			'goods_batch.require'          => '产品批次不能为空',
			'inspect_time.require'         => '检测时间不能为空',
			'product_total.require'        => '产品基数不能为空',
			'product_select.require'       => '抽检数量不能为空',
			'is_qualified.require'         => '是否合格不能为空',
			'is_certificate.require'       => '是否拥有合格证不能为空',
			'production_date.require'      => '生产日期不能为空',
			'expire_date.require'          => '保质期不能为空',
			'unqualified_rate.require'     => '不合格率不能为空',

		];

		// 应用场景的
		protected $scene = [

			'agri_add'    =>  ['name','record_type','goods_id','provider_id','goods_batch','inspect_time','product_total','product_select','is_qualified'],
			'mark_add'    =>  ['name','record_type','goods_id','provider_id','goods_batch','inspect_time','product_total','product_select','production_date','expure_date','unqualified_rate'],
			'fresh_add'   =>  ['name','record_type','goods_id','provider_id','goods_batch','inspect_time','product_total','product_select','is_certificate','unqualified_rate','mark'],
			'packing_add' =>  ['name','record_type','goods_id','provider_id','goods_batch','inspect_time','product_total','product_select','is_certificate','mark','unqualified_rate'],
			'add'  =>  ['name'],
		];

}
