<?php
namespace app\admin\logic;

class Test extends AdminBase
{
    /**
     * 获取test列表搜索条件
     */
    public function getWhere($data = [])
    {
        $where = [];

        !empty($data['search_data']) && $where['name'] = ['like', '%'.$data['search_data'].'%'];

        return $where;
    }

    /**
     * 获取Test列表
     */
    public function getTestList($where = [], $field = '*', $order = '', $paginate = 0)
    {
//        $this->modelTest->alias('a');
        $field = '*';
        return $this->modelTest->getList($where, $field, $order, $paginate);
    }

    /**
    * Test添加
    */
    public function testAdd($data = [])
    {
        $data = $this->logicCommon->data_run($data,'title,type,value,is_show,name,extra');

        $validate_result = $this->validateTest->scene('add')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateTest->getError()];
        }

        $url = url('testList');

        $result = $this->modelTest->setInfo($data);

        $result && action_log('Test' . '新增Test，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelTest->getError()];
    }

    /**
    * Test信息编辑
    */
    public function testEdit($data = [])
    {
        $data=$this->logicCommon->data_run($data,'title,type,value,is_show,name,extra');

        $validate_result = $this->validateTest->scene('edit')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateTest->getError()];
        }

        $url = url('testList');

        $result = $this->modelTest->setInfo($data);

        $result && action_log('Test' . '编辑Test，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelTest->getError()];
    }

    /**
    * 获取Test信息
    */
    public function getTestInfo($where = [], $field = true)
    {
        $field = '*';
        return $this->modelTest->getInfo($where, $field);
    }

    /**
    * Test删除
    */
    public function testDel($where = [])
    {

        $result = $this->modelTest->deleteInfo($where);

        $result && action_log('删除', 'Test删除' . '，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->modelTest->getError()];
    }
}
