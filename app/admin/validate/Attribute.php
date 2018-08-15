<?php
namespace app\admin\validate;
/**
* Attribute验证器
*/
    class Attribute extends AdminBase
{

// 验证规则
protected $rule =   [

    'name'              => 'alphaDash|regex:\D*|require|max:25|checkUrl',
    'title'             =>'require',
    'field'             =>'require',
    'type'              =>'require',
];

// 验证提示
protected $message  =   [
    'name.alphaDash'            =>  '名称必须为字母或_-',
    'name.regex'                =>  '名称不能为数字',
    'name.require'              =>  '名称不能为空',
    'name.max'                  =>  '名称最大长度不能超过25',
    'title.require'             =>  '字段标题不能为空',
    'field.require'             =>  '字段属性不能为空',
    'type.require'              =>  '字段类型不能为空',

];

// 应用场景
protected $scene = [

'edit' =>  ['name','title','field','type'],
'add'  =>  ['name','title','field','type'],
];

// 自定义
    protected function checkUrl($value,$rule,$data)
    {
        return in_array($value,['id','name','status','create_time','update_time']) ? '基础字段名已存在' : true;

    }
}
