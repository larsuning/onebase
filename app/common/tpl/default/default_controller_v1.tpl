<?php
namespace {$space};

class {$class} extends {$modules}Base
{
    /**
     * {$names}列表
     */
    public function {$names}List()
    {
        $where = $this->logic{$name}->getWhere($this->param);
        $this->assign('list', $this->logic{$name}->get{$name}List($where));

        return $this->fetch('{$names}_list');
    }

    /**
    * {$names}添加
    */
    public function {$names}Add()
    {

        IS_POST && $this->jump($this->logic{$name}->{$names}Add($this->param));

        return $this->fetch('{$names}_edit');
    }

    /**
    * {$names}编辑
    */
    public function {$names}Edit()
    {

        IS_POST && $this->jump($this->logic{$name}->{$names}Edit($this->param));

        $info = $this->logic{$name}->get{$name}Info(['id' => $this->param['id']]);

        $this->assign('info', $info);

        return $this->fetch('{$names}_edit');
    }

    /**
    * {$names}删除
    */
    public function {$names}Del($id = 0)
    {

        $this->jump($this->logic{$name}->{$names}Del(['id' => $id]));
    }
    /**
    * 数据状态设置
    */
    public function setStatus()
    {

        $this->jump($this->logicAdminBase->setStatus('{$name}', $this->param));
    }
}
