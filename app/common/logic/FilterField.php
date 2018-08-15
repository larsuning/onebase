<?php

namespace app\common\logic;

use Think\Db;

/**
 * 拓展
 */
class FilterField extends LogicBase
{
    // 起源：传过来的数据
    protected $origin=null;
    // 过滤后的数据
    protected $data=null;
    // 传过来的数据表信息
    protected $table_info=null;

    public function __construct($data='',$table_info='')
    {

        if(!empty($data) && !empty($table_info)) {
            $this->origin = $data;
            $this->table_info = $table_info;
            $data_keys = array_keys($data);
            // 获取数组中的交集、过滤数据
            $fields = array_intersect($table_info['fields'], $data_keys);
            // 类型集合
            $field_types = [
                'int' => ['tinyint', 'smallint', 'mediumint', 'int', 'integer', 'bigint'],
                'float' => ['double', 'float', 'decimal'],
                'string' => ['char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext'],
            ];
            foreach ($fields as $field) {
                // 字段类型 小写
                $field_type = strtolower(substr($table_info['type'][$field], 0, strpos($table_info['type'][$field], '(')));

                if (in_array($field_type, $field_types['int'])) {
                    // 如果int 有 unsigned， 不准有符号，则不能有"-"
                    if(preg_match("/unsigned/",$table_info['type'][$field])) $data[$field]=preg_replace("/[-]/",'',$data[$field]);
                    // 字段长度
                    $length = substr($table_info['type'][$field], strpos($table_info['type'][$field], '(')+1, strpos($table_info['type'][$field], ')')-(strpos($table_info['type'][$field], '(')+1));
                    $sub_data=substr($data[$field],0,$length);// 截取到指定长度后的数据
                    $num = preg_replace("/[^\d-]/",'',$sub_data); // 过滤非数字和非"-"的字符串
                    // 如果小于11位转换为整形，大于11位则转换为浮点型类型 为什么要转换浮点型 是因为如果遇到"--1234" 则可以转换为0
                    $num = (float)$num;
                    strlen($num)<11 ? $info[$field] = (int)$num : $info[$field]=$num;
                } elseif (in_array($field_type, $field_types['float'])) {
                    // 转换为浮点型
                    $info[$field] = (float)$data[$field];
                } elseif (in_array($field_type, $field_types['string'])) {
                    // 转换为字符串型
                    $info[$field] = (string)$data[$field];
                } else {
                    $info[$field] = $data[$field];
                }
            }
            // 过滤后的数据
            $this->data = $info;
        }

    }

    // 返回过滤后的数据
    public function getDatas()
    {
        return $this->data;
    }
}