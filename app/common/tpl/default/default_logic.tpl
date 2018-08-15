<?php
namespace {$space};

class {$class} extends {$modules}Base
{
    /**
     * 获取{$names}列表搜索条件
     */
    public function getWhere($data = [])
    {
        $where = [];

        !empty($data['search_data']) && $where['name'] = ['like', '%'.$data['search_data'].'%'];

        return $where;
    }

    /**
     * 获取{$name}列表
     */
    public function get{$name}List($where = [], $field = '*', $order = '', $paginate = 0)
    {
//        $this->model{$tb_name}->alias('a');
        $field = '{$fields}';
        return $this->model{$tb_name}->getList($where, $field, $order, $paginate);
    }

    /**
    * {$name}添加
    */
    public function {$names}Add($data = [])
    {
        $data = $this->logicCommon->data_run($data,'title,type,value,is_show,name,extra');

        $validate_result = $this->validate{$name}->scene('add')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validate{$name}->getError()];
        }

        $url = url('{$names}List');

        $result = $this->model{$tb_name}->setInfo($data);

        $result && action_log('{$name}' . '新增{$name}，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->model{$tb_name}->getError()];
    }

    /**
    * {$name}信息编辑
    */
    public function {$names}Edit($data = [])
    {
        $data=$this->logicCommon->data_run($data,'title,type,value,is_show,name,extra');

        $validate_result = $this->validate{$name}->scene('edit')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validate{$name}->getError()];
        }

        $url = url('{$names}List');

        $result = $this->model{$tb_name}->setInfo($data);

        $result && action_log('{$name}' . '编辑{$name}，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->model{$tb_name}->getError()];
    }

    /**
    * 获取{$name}信息
    */
    public function get{$name}Info($where = [], $field = true)
    {
        $field = '{$fields}';
        return $this->model{$tb_name}->getInfo($where, $field);
    }

    /**
    * {$name}删除
    */
    public function {$names}Del($where = [])
    {

        $result = $this->model{$tb_name}->deleteInfo($where);

        $result && action_log('删除', '{$name}删除' . '，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->model{$tb_name}->getError()];
    }
}
