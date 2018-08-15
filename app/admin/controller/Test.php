<?php
namespace app\admin\controller;

class Test extends AdminBase
{
    /**
     * test列表
     */
    public function testList()
    {
        $where = $this->logicTest->getWhere($this->param);

        $this->assign('list', $this->logicTest->getTestList($where));

        return $this->fetch('test_list');
    }

    /**
    * test添加
    */
    public function testAdd()
    {
        $data=$this->logicCommon->view_style('view_add');

        IS_POST && $this->jump($this->logicTest->testAdd($this->param));

        $this->assign('fields',$data);

        return $this->fetch('test_edit');
    }

    /**
    * test编辑
    */
    public function testEdit()
    {
        $data = $this->logicCommon->view_style('view_edit');

        IS_POST && $this->jump($this->logicTest->testEdit($this->param));

        $info = $this->logicTest->getTestInfo(['id' => $this->param['id']]);

        $this->assign('fields',$data);

        $this->assign('info', $info);

        return $this->fetch('test_edit');
    }

    /**
    * test删除
    */
    public function testDel($id = 0)
    {

        $this->jump($this->logicTest->testDel(['id' => $id]));
    }
    /**
    * 数据状态设置
    */
    public function setStatus()
    {

        $this->jump($this->logicAdminBase->setStatus('Test', $this->param));
    }
}
