<?php
namespace app\ps\controller;

class Curdcreate extends PsBase
{
    /**
     * curdcreate列表
     */
    public function curdcreateList()
    {

        $this->assign('list', $this->logicCurdcreate->getCurdcreateList());

        return $this->fetch('curdcreate_list');
    }

    /**
     * curdcreate添加
     */
    public function curdcreateAdd()
    {

        $menu_select = $this->logicMenu->menuToSelect($this->authMenuTree);

        $this->assign('menu_select', $menu_select);

        $this->assign('group_list', $this->logicApi->getApiGroupList([], true, 'sort desc'));

        IS_POST && $this->jump($this->logicCurdcreate->curdcreateAddCurd($this->param));

        return $this->fetch('curdcreate_add');
    }

    /**
     * curdcreate编辑
     */
    public function curdcreateEdit()
    {

        IS_POST && $this->jump($this->logicCurdcreate->curdcreateEdit($this->param));

        $info = $this->logicCurdcreate->getCurdcreateInfo(['id' => $this->param['id']]);

        $info->view_edit = $this->logicCommon->parse_field_attr($info->view_edit);

        $fields = $this->logicAttribute->where(['model_id'=>$this->param['id']])->select();


        $this->assign('fields',$fields);

        $this->assign('info', $info);

        return $this->fetch('curdcreate_edit');
    }

    /**
     * @param $fields 属性列表
     * @param $info 模型列表
     * @return mixed  梳理属性的可见性
     */
    public function is_show($fields,$info)
    {
        $fields =  $this->logicCurdcreate->is_show($fields,$info);

        return $fields;
    }

    /**
     * curdcreate删除
     */
    public function curdcreateDel($id = 0)
    {

        $this->jump($this->logicCurdcreate->curdcreateDel(['id' => $id]));
    }
    /**
     * 数据状态设置
     */
    public function setStatus()
    {

        $this->jump($this->logicPsBase->setStatus('Curdcreate', $this->param));
    }

    /**
     * 列表模板视图
     */
    public function create_list_view()
    {
        if(empty($this->param['list_grid'])) {
            $list_grid = $this->logicCurdcreate->getCurdcreateInfo(['id' => $this->param['id']])['list_grid'];
        }else{
            $list_grid = $this->param['list_grid'];
        }
        $item  = $this->logicCommon->parse_field_attr($list_grid);

        $file_view_name = '_list';

        // 模块目录
        $module = $this->param['module'];

        IS_POST && $this->jump($this->logicCommon->create_list_view($this->param,$item,$file_view_name,$module));
    }

    /**
     * 新增模板视图
     */
    public function create_add_view()
    {

        $view_name = 'view_add';
        $file_view_add = '_add';

        // 模块目录
        $module = $this->param['module'];

        IS_POST && $this->jump($this->logicCommon->create_tpl_view($this->param,$view_name,$file_view_add,$module));
    }

    /**
     * 编辑模板视图
     */
    public function create_edit_view()
    {

        $view_name = 'view_edit';
        $file_view_edit = '_edit';

        // 模块目录
        $module = $this->param['module'];

        IS_POST && $this->jump($this->logicCommon->create_tpl_view($this->param,$view_name,$file_view_edit,$module));
    }

    /**
     * 执行生成mysql数据表
     */
    public function create_sql_table()
    {
        IS_POST && $this->jump($this->logicCommon->create_table($this->param));
    }

    /**
     * 读取标识的table的字段，更新入库
     */

    public function update_table_attributes()
    {
        IS_POST && $this->jump($this->logicCommon->update_table_attributes($this->param));
    }

    /**
     * 生成api接口文档
     */
    public function api_doc_create()
    {
        IS_POST && $this->jump($this->logicCommon->api_doc_create($this->param));
    }
}
