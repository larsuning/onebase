<?php
namespace app\admin\logic;
use think\Db;
class Attribute extends AdminBase
{
    /**
     * 获取attribute列表搜索条件
     */
    public function getWhere($data = [])
    {

        $where = [];

        !empty($data['search_data']) && $where['a.name'] = ['like', '%'.$data['search_data'].'%'];

        return $where;
    }

    /**
     * 获取Attribute列表
     */
    public function getAttributeList($where = [], $field = 'a.*', $order = '', $paginate = 0)
    {
        $this->modelAttribute->alias('a');

        $info = $this->modelAttribute->getList($where, $field, $order, $paginate);

        return $info;
    }

    /**
    * Attribute添加
    */
    public function attributeAdd($data = [])
    {
        $validate_result = $this->validateAttribute->scene('add')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateAttribute->getError()];
        }

        $check_name = $this->modelAttribute->getInfo(['model_id'=>$data['model_id'],'name'=>$data['name']],'id');

        if($check_name)
        {
            return [RESULT_ERROR,'字段重复'];
        }

        $table_name = $this->table_name($data);

        $this->mysqlAdd($table_name,$data['name'],$data['field'],$data['value'],$data['title']);

        $url = url('attributelist',['model_id'=>$data['model_id']]);

        $result = $this->modelAttribute->setInfo($data);
        // 更新CURDcreate表里view_add_set,view_edit_set字段的值
        $ids = $this->modelAttribute->getColumn(['model_id'=>$data['model_id']],'id');
        $view_attr_list = arr2str($ids);
        $this->modelCurdcreate->updateInfo(['id'=>$data['model_id']],['view_add_set'=>$view_attr_list,'view_edit_set'=>$view_attr_list]);

        $result && action_log('Attribute' . '新增Attribute，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelAttribute->getError()];
    }

    /** mysql增加
     * @param $table_name 表名
     * @param $name 修改的表字段名
     * @param $field 修改的字段定义
     * @param $value 默认值
     * @param $comment 备注
     */
    public function mysqlAdd($table_name,$name,$field,$value,$comment)
    {
        $a = substr($field,0,strpos($field,' '));
        if($a =='text')
        {
            $sql = "alter table `$table_name` add $name $field COMMENT '$comment' ";
        }else{

            $sql="alter table `$table_name` add $name $field DEFAULT '$value' COMMENT '$comment' ";
        }

        Db::execute($sql);
    }

    /**
    * Attribute信息编辑
    */
    public function attributeEdit($data = [])
    {
        $validate_result = $this->validateAttribute->scene('edit')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateAttribute->getError()];
        }

        $nm = $this->modelAttribute->getInfo(['id'=>$data['id']])['name'];

        $table_name = $this->table_name($data);
        dd($table_name);
        if(!isset($data['value'])){
            $data['value']='';
        }

        $this->mysqlEdit($table_name,$nm,$data['name'],$data['field'],$data['value'],$data['title']);

        $url = url('attributeList',['model_id'=>$data['model_id']]);

        $result = $this->modelAttribute->setInfo($data);

        // 更新CURDcreate表里view_add_set,view_edit_set字段的值
        $ids = $this->modelAttribute->getColumn(['model_id'=>$data['model_id']],'id');
        $view_attr_list = arr2str($ids);
        $this->modelCurdcreate->updateInfo(['id'=>$data['model_id']],['view_add_set'=>$view_attr_list,'view_edit_set'=>$view_attr_list]);

        $result && action_log('Attribute' . '編輯Attribute，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelAttribute->getError()];
    }

    /** mysql修改
     * @param $table_name 表名
     * @param $nm 表字段
     * @param $name 修改的表字段名
     * @param $field 修改的字段定义
     * @param $value 默认值
     * @param $comment 备注
     */
    public function mysqlEdit($table_name,$nm,$name,$field,$value,$comment)
    {
        $a = substr($field,0,4);

        if($a =='text')
        {
            $sql="alter table `$table_name` change $nm $name $field  COMMENT '$comment' ";
        }else{

            $sql="alter table `$table_name` change $nm $name $field DEFAULT '$value' COMMENT '$comment' ";
        }
        Db::execute($sql);
    }
    /**
    * 获取Attribute信息
    */
    public function getAttributeInfo($where = [], $field = true)
    {

        return $this->modelAttribute->getInfo($where, $field);
    }

    /**
    * Attribute删除
    */
    public function attributeDel($where = [])
    {
        $info = $this->modelAttribute->getInfo(['id'=>$where['id']],'name,model_id');

        $table_name = $this->table_name($info);

        $nm = $info['name'];

        $this->mysqlDel($table_name,$nm);

        $result = $this->modelAttribute->deleteInfo($where,true);

        // 更新CURDcreate表里view_add_set,view_edit_set字段的值
        $ids = $this->modelAttribute->getColumn(['model_id'=>$info['model_id']],'id');
        $view_attr_list = arr2str($ids);
        $this->modelCurdcreate->updateInfo(['id'=>$info['model_id']],['view_add_set'=>$view_attr_list,'view_edit_set'=>$view_attr_list]);

        $result && action_log('删除', 'Attribute删除' . '，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->modelAttribute->getError()];
    }

    /** mysql删除
     * @param $table_name 表名
     * @param $nm 表字段
     */
    public function mysqlDel($table_name,$nm)
    {
       $sql = "ALTER TABLE $table_name  DROP $nm";

       Db::execute($sql);
    }

    public function table_name($info)
    {
        return SYS_DB_PREFIX.$this->modelCurdcreate->getInfo(['id'=>$info['model_id']],'tb_name')['tb_name'];
    }
}
