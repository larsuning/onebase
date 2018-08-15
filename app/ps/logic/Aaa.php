<?php
namespace app\ps\logic;

class Aaa extends PsBase
{
    /**
     * 获取aaa列表搜索条件
     */
    public function getWhere($data = [])
    {
        $where = [];

        !empty($data['search_data']) && $where['name'] = ['like', '%'.$data['search_data'].'%'];

        return $where;
    }

    /**
     * 获取Aaa列表
     */
    public function getAaaList($where = [], $field = '*', $order = '', $paginate = 0)
    {
//        $this->modelPsInspectionRecord->alias('a');
        $field = '*';
        return $this->modelPsInspectionRecord->getList($where, $field, $order, $paginate);
    }

    /**
    * Aaa添加
    */
    public function aaaAdd($data = [])
    {
        $data = $this->logicCommon->data_run($data,'title,type,value,is_show,name,extra');

        $validate_result = $this->validateAaa->scene('add')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateAaa->getError()];
        }

        $url = url('aaaList');

        $result = $this->modelPsInspectionRecord->setInfo($data);

        $result && action_log('Aaa' . '新增Aaa，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelPsInspectionRecord->getError()];
    }

    /**
    * Aaa信息编辑
    */
    public function aaaEdit($data = [])
    {
        $data=$this->logicCommon->data_run($data,'title,type,value,is_show,name,extra');

        $validate_result = $this->validateAaa->scene('edit')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateAaa->getError()];
        }

        $url = url('aaaList');

        $result = $this->modelPsInspectionRecord->setInfo($data);

        $result && action_log('Aaa' . '编辑Aaa，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelPsInspectionRecord->getError()];
    }

    /**
    * 获取Aaa信息
    */
    public function getAaaInfo($where = [], $field = true)
    {
        $field = '*';
        return $this->modelPsInspectionRecord->getInfo($where, $field);
    }

    /**
    * Aaa删除
    */
    public function aaaDel($where = [])
    {

        $result = $this->modelPsInspectionRecord->deleteInfo($where);

        $result && action_log('删除', 'Aaa删除' . '，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->modelPsInspectionRecord->getError()];
    }
}
