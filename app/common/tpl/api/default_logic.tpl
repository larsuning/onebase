<?php
namespace {$space};

use app\{$module}\error\CodeBase;
use app\{$module}\error\Common as CommonError;
use app\{$module}\error\{$name} as {$name}Error;
class {$name} extends {$modules}Base
{
    // 要删除的参数名
    private $arrs =['list_rows','page','action','access_token','user_token'];

    private $limit = 2;

    private $page = 1;

    public function {$names}Action($data)
    {
        if(!isset($data['action'])) return CodeBase::$actionError;

        $action = trim($data['action']);

        isset($data['name']) && $data['name'] = trim($data['name']);

        isset($data['description']) && $data['description'] = trim($data['description']);
        // 默认显示2条数据
        (isset($data['list_rows']) && !empty($data['list_rows'])) ? $limit = trim($data['list_rows']) : $limit = $this->limit;
        // 默认为第1页
        isset($data['page']) ? $page = trim($data['page']) : $page = $this->page;
        // 处理需要删除的参数
        foreach ($this->arrs as $arr) { if(array_key_exists($arr,$data)) unset($data[$arr]); }

        $where = $this->getWhere($data);

        switch ($action)
        {
            case 'list':    return $this->get{$name}List($where,'*','',$limit,$page); break;
            case 'info':    return $this->get{$name}Info($data); break;
            case 'add':     return $this->{$names}Add($data); break;
            case 'edit':    return $this->{$names}Edit($data); break;
            case 'del':     return $this->{$names}Del($data); break;
            default:        return CodeBase::$actionError; break;
        }
    }
    /**
    * 获取{$names}列表搜索条件
    */
    protected function getWhere($data = [])
    {
        $where = [];

        !empty($data['search_data']) && $where['name'] = ['like', '%'.$data['search_data'].'%'];

        return $where;
    }

    /**
    * 获取{$name}列表
    */
    private function get{$name}List($where = [], $field = '*', $order = '', $limit, $page)
    {
        //        $this->model{$tb_name}->alias('a');
        $where[DATA_STATUS_NAME] = ['neq', DATA_DELETE];
        $field = '{$fields}';
        $info = $this->model{$tb_name}->where($where)->order($order)->field($field)->limit($limit)->page($page)->select();

        if(!$info) return CommonError::$infoFail;

        return $info;
    }

    /**
    * {$name}添加
    */
    private function {$names}Add($data = [])
    {
        if(isset($data['id'])) unset($data['id']);

        $validate_result = $this->validate{$name}->scene('add')->check($data);

        if(!$validate_result) return CommonError::$ParamEmpty;

        $isName = $this->model{$tb_name}->getValue(['name'=>$data['name']],'name');

        if($isName) return {$name}Error::$NameRepeat;

        $result = $this->model{$tb_name}->setInfo($data);

        if(!$result) return CommonError::$addFail;

        //        $result && action_log('{$name}' . '新增{$name}，name' . '，name：' . $data['name']);

        return CodeBase::$success;
    }

    /**
    * {$name}信息编辑
    */
    private function {$names}Edit($data = [])
        {
        if(!isset($data['id']) || empty($data['id'])) return CommonError::$idError;

        $validate_result = $this->validate{$name}->scene('edit')->check($data);

        if (!$validate_result) return CommonError::$ParamEmpty;

        $isName = $this->model{$tb_name}->getColumn([],'name','id');

        unset($isName[$data['id']]);

        if(in_array($data['name'],$isName)) return {$name}Error::$NameRepeat;

        $result = $this->model{$tb_name}->setInfo($data);

        if(!$result) return CommonError::$editFail;

        //        $result && action_log('{$name}' . '编辑{$name}，name' . '，name：' . $data['name']);

        return CodeBase::$success;
    }

    /**
    * 获取{$name}信息
    */
    private function get{$name}Info($data = [], $field = true)
    {

        if(!isset($data['id']) || empty($data['id'])) return CommonError::$idError;
//      $this->model{$tb_name}->alias('a');
//      $where['a.id'] = $data['id'];
//      $field= 'a.*';
//      $where['a.'.DATA_STATUS_NAME] = DATA_NORMAL;

//        $join = [[ SYS_DB_PREFIX.'{$names}base b','a.{$names}base_id = b.id']];

        $join = [];

        $where['id'] = $data['id'];

        $where[DATA_STATUS_NAME] = DATA_NORMAL;

        $field= '{$fields}';

        $result = $this->model{$tb_name}->getInfo($where, $field,$join);

        if(!$result) return CommonError::$infoFail;

        return $result;
    }

    /**
    * {$name}删除
    */
    private function {$names}Del($data = [])
    {

        if(!isset($data['id']) || empty($data['id'])) return CommonError::$idError;

        $where['id'] = $data['id'];

        $result = $this->model{$tb_name}->deleteInfo($where);

        if(!$result) return CommonError::$delFail;

        //        $result && action_log('删除', '{$name}删除' . '，where：' . http_build_query($where));

        return CodeBase::$success;
    }
}
