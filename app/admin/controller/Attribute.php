<?php
namespace app\admin\controller;

class Attribute extends AdminBase
{
    /**
     * attribute列表
     */
    public function attributeList()
    {
        $where = $this->logicAttribute->getWhere($this->param);

        
        if(isset($this->param['model_id'])){
            $model_id = $this->param['model_id'];
            $where['model_id']=$model_id;
            $this->assign('model_id',$model_id);
            
        }
        $this->assign('list', $this->logicAttribute->getAttributeList($where,'*','id desc'));
        return $this->fetch('attribute_list');
    }


    /**
    * attribute添加
    */
    public function attributeAdd()
    {
//        var_dump($this->param);
        IS_POST && $this->jump($this->logicAttribute->attributeAdd($this->param));

        return $this->fetch('attribute_edit');
    }

    /**
    * attribute编辑
    */
    public function attributeEdit()
    {
        IS_POST && $this->jump($this->logicAttribute->attributeEdit($this->param));

        $info = $this->logicAttribute->getAttributeInfo(['id' => $this->param['id']]);
//        var_dump($info->toArray());
        $this->assign('info', $info);

        return $this->fetch('attribute_edit');
    }

    /**
    * attribute删除
    */
    public function attributeDel($id = 0)
    {

        $this->jump($this->logicAttribute->attributeDel(['id' => $id]));
    }
    /**
    * 数据状态设置
    */
    public function setStatus()
    {

        $this->jump($this->logicAdminBase->setStatus('Attribute', $this->param));
    }
}
