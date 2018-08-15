<?php
namespace app\ps\controller;

class Aaa extends PsBase
{
    /**
     * aaa列表
     */
    public function aaaList()
    {
        $where = $this->logicAaa->getWhere($this->param);

        $this->assign('list', $this->logicAaa->getAaaList($where));

        return $this->fetch('aaa_list');
    }

    /**
    * aaa添加
    */
    public function aaaAdd()
    {
        $data=$this->logicCommon->view_style('view_add');

        IS_POST && $this->jump($this->logicAaa->aaaAdd($this->param));

        $this->assign('fields',$data);

        return $this->fetch('aaa_edit');
    }

    /**
    * aaa编辑
    */
    public function aaaEdit()
    {
        $data = $this->logicCommon->view_style('view_edit');

        IS_POST && $this->jump($this->logicAaa->aaaEdit($this->param));

        $info = $this->logicAaa->getAaaInfo(['id' => $this->param['id']]);

        $this->assign('fields',$data);

        $this->assign('info', $info);

        return $this->fetch('aaa_edit');
    }

    /**
    * aaa删除
    */
    public function aaaDel($id = 0)
    {

        $this->jump($this->logicAaa->aaaDel(['id' => $id]));
    }
    /**
    * 数据状态设置
    */
    public function setStatus()
    {

        $this->jump($this->logicPsBase->setStatus('PsInspectionRecord', $this->param));
    }
}
