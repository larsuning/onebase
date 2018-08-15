<?php
namespace app\ps\logic;
use think\Db;
class Curdcreate extends PsBase
{
    /**
     * 获取Curdcreate列表
     */
    public function getCurdcreateList($where = [], $field = true, $order = '', $paginate = 0)
    {

        return $this->modelCurdcreate->getList($where, $field, $order, $paginate);
    }

    /**
     * 菜单CURD添加
     */
    public function curdcreateAddCurd($data = [])
    {

        $module = strtolower($data['module']);
        $data['url'] = strtolower($data['url']);
        $data['tb_name'] = trim(strtolower($data['tb_name']));
        $style = trim($data['style']);
        $key = $data['url'];
        $where['url'] = ['like', $key . SYS_DS_PROS . '%'];
        $where['module'] = $data['module'];
        $list_grid = $data['list_grid'];


        if (!is_dir(APP_PATH . DS . 'common' . DS . 'tpl' . DS . $style . DS)) return [RESULT_ERROR, $style . '模板不存在'];

        $validata_result_curd = $this->validateCurdcreate->scene('add')->check($data);

        if (!$validata_result_curd) {

            return [RESULT_ERROR, $this->validateCurdcreate->getError()];
        }
        $info = $this->modelMenu->getInfo($where, 'id');
        if ($info) return [RESULT_ERROR, 'CURD标识在menu中重复'];

        // 第一位不能为_
        $label = '/^_/';
        $db_name_error = preg_match($label, $data['tb_name'], $mc);
        if($db_name_error) return [RESULT_ERROR,'数据表名称第一位只能为字母'];
        // mysql表只能有字母和_
        $label = '/[^a-zA-Z_]/';
        $db_name_error = preg_match($label, $data['tb_name'], $mc);
        if($db_name_error) return [RESULT_ERROR,'数据表名称只能有字母或_'];
        // mysql表不能有'__'
        $label = '/__/';
        $db_name_error = preg_match($label, $data['tb_name'], $mc);
        if($db_name_error) return [RESULT_ERROR,'数据表名称不能有\'__\''];

        $where['url'] = $key;
        $info = $this->modelCurdcreate->getInfo($where, 'id');
        if ($info) {
            return [RESULT_ERROR, 'url在curdcreate中重复'];
        }
        // 菜单验证器验证下，要录入到菜单里
        $validate_result = $this->validateMenu->scene('add')->check($data);
        if (!$validate_result) {

            return [RESULT_ERROR, $this->validateMenu->getError()];
        }
        if (isset($data['attribute_list'])) {
            $attribute_list = implode(',', $data['attribute_list']);
        } else {
            $attribute_list = '';
        }
//        {$field['name']} {$field['field']}DEFAULT '{$field['value']}' COMMENT '{$field['title']}'
        // 过滤表名
        $data['tb_name'] = strip_tags(addslashes($data['tb_name']));

        $table_name = SYS_DB_PREFIX . $data['tb_name'];
        // is_select 存在且为1才判断表是否重复
        if (isset($data['is_select']) && $data['is_select'] == '1') {

            $msg = $this->logicCommon->table_is_exist($table_name);

            if ($msg) return [RESULT_ERROR, $table_name . '表已存在'];

        }
        // 是否创建数据表
        if (isset($data['is_select']) && $data['is_select'] == '1') {
            $this->create_sql($data['tb_name']);
        }

        // 模板目录是api
        if ($style == 'api') {

            $msg = $this->logicCommon->table_is_exist($table_name);

            if (!$msg) return [RESULT_ERROR, $table_name. '表不存在，无法生成api文件'];
            // 获取数据表所有字段信息
            $fields_arrs = $this->logicCommon->show_table_fields($table_name);
            // 获取所有字段类型
            foreach ($fields_arrs as $fields_arr) { $fields[] = $fields_arr['Field']; }
            // 字段 数组转换成字符串
            $fields = arr2str($fields);

            $path = APP_PATH . $module . SYS_DS_PROS . 'controller';
            $row = is_dir($path);
            $list = array();
            if($row) {
                // 组装处理好controller下的文件名
                foreach (scandir($path) as $item) {
                    if ($item != '.' && $item != '..') {
                        $list[] = strtolower(substr($item, 0, strpos($item, '.')));
                    }
                }
            }

            // 存在，则提示
            if (in_array($key, $list)) return [RESULT_ERROR, $key . '在' . $module . '的controller中已存在'];

            $this->creates($key, $module, $style,$fields,$data['tb_name']);

            action_log('新增', '新增api，name：' . $data['name']);

            $url = url('index/index');

            return [RESULT_SUCCESS,'生成api成功',$url];
        }

        // 模板目录不是api
        if ($style != 'api') {
//        生成模块
            $this->creates($key, $module, $style,$fields='*',$data['tb_name']);
            $datas = [
            'name' => $data['name'],
            'pid' => $data['pid'],
            'sort' => $data['sort'],
            'module' => strtolower($data['module']),
            'url' => $data['url'] . SYS_DS_PROS . 'index',
            'is_hide' => $data['is_hide'],
            'icon' => $data['icon'],
            'id' => $data['id'],
            'update_time' => time()
        ];
        $curddata = [
            'module' => strtolower($data['module']),
            'name' => $data['name'],
            'url' => $key,
            'tb_name' => $data['tb_name'],
            'attribute_list' => $attribute_list,
            'list_grid' => $list_grid,
            'id' => $data['id'],
            'update_time' => time()
        ];
        // 菜单入库
        $result = $this->modelMenu->addInfo($datas);
        // curdcreate 入库
        $this->modelCurdcreate->addInfo($curddata);
        // 添加其他
        $this->adds($datas, $result, $key);
//        $result = $this->modelMenu->setInfo($data);
        $result && action_log('新增', '新增菜单，name：' . $data['name']);
//      跳转到菜单列表
        $url = url('curdcreateList', ['pid' => $data['pid'] ? $data['pid'] : 0]);
        return $result ? [RESULT_SUCCESS, '菜单CURD添加成功', $url] : [RESULT_ERROR, $this->modelMenu->getError()];
        }
    }

    /**
     * 生成数据表
     * @param $key 关键标识
     */
    public function create_sql($key)
    {
        $table_name = SYS_DB_PREFIX.$key;
        $sql = "
        CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` char(50) NOT NULL DEFAULT '' COMMENT '名称',
        `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '数据状态',
        `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
        `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        Db::execute($sql);
    }
    /**
     * 相当于添加菜单路由，组装数据添加到menu表中，在admin系统menu中访问
     */
    public function adds($data,$pid,$key)
    {
        $name = $data['name'];
        $data['pid']=$pid;
        $list = array(
            ['url'=>$key.SYS_DS_PROS.$key.'list','name'=>$name.'列表','is_hide'=>0],
            ['url'=>$key.SYS_DS_PROS.$key.'add','name'=>$name.'添加','is_hide'=>0],
            ['url'=>$key.SYS_DS_PROS.$key.'edit','name'=>$name.'编辑','is_hide'=>1],
//            ['url'=>$key.SYS_DS_PROS.$key.'del','name'=>$name.'删除']
        );
        foreach ($list as $v) {
            $data['url']=$v['url'];
            $data['name']=$v['name'];
            $data['is_hide']=$v['is_hide'];
//            var_dump($data);
            $result = $this->modelMenu->addInfo($data);
        }
    }
    /**
     * 生成模块
     */
    public function creates($key,$module,$style,$fields='*',$table_name='')
    {
        // 转换tb_name 比如land_post = LandPost
        if(!empty($table_name) && is_string($table_name)) {
            $table_name_arrs = str2arr($table_name, '_');
            foreach ($table_name_arrs as $table_name_arr) {
                $item[]=ucfirst($table_name_arr);
            }
            $table_name = arr2str($item,'');
            unset($item);
        }else{
            $table_name = $key;
        }

        //      首字母转换成大写
        $key = ucfirst($key);
        if($style=='api'){
            $build = [
                // 生成应用公共文件
                '__file__' => ['common.php', 'config.php', 'database.php'],

                // 定义demo模块的自动生成 （按照实际定义的文件名生成）
                $module     => [
                    '__file__'   => ['common.php','config.php'],
                    '__dir__'    => [ 'controller','model','logic','validate','error'],
                    'controller' => [$key,ucfirst($module).'Base'],
                    'model'      => [$table_name,ucfirst($module).'Base'],
                    'logic'      =>[$key,ucfirst($module).'Base'],
                    'validate'   =>[$key,ucfirst($module).'Base'],
                    'error'      =>[$key,'CodeBase','Common'],
                ],
                // 其他更多的模块定义
            ];
        }else {
            $build = [
                // 生成应用公共文件
                '__file__' => ['common.php', 'config.php', 'database.php'],

                // 定义demo模块的自动生成 （按照实际定义的文件名生成）
                $module => [
                    '__file__' => ['common.php', 'config.php'],
                    '__dir__' => ['controller', 'model', 'view', 'logic', 'validate'],
                    'controller' => [$key, ucfirst($module) . 'Base'],
                    'model' => [$table_name, ucfirst($module) . 'Base'],
                    'view' => [strtolower($key) . SYS_DS_PROS . $key . '_list', strtolower($key) . SYS_DS_PROS . $key . '_edit'],
                    'logic' => [$key, ucfirst($module) . 'Base'],
                    'validate' => [$key, ucfirst($module) . 'Base'],
                ],
                // 其他更多的模块定义
            ];
        }

        \think\Builds::run($build,'app',false,$style,$fields);
    }

    /**
    * Curdcreate信息编辑
    */
    public function curdcreateEdit($data = [])
    {
        // 删除多余传过来的参数
        $arrs = ['table_name'];
        foreach ($arrs as $arr) { if(array_key_exists($arr,$data)) unset($data[$arr]); }

        !empty($data['view_add']) && is_array($data['view_add']) ? $data['view_add'] = arr2str($data['view_add']) : $data['view_add'] = '';
        !empty($data['view_edit']) && is_array($data['view_edit']) ? $data['view_edit'] = arr2str($data['view_edit']) :$data['view_edit'] = '';
        !empty($data['attribute_list']) && is_array($data['attribute_list']) ? $data['attribute_list'] = arr2str($data['attribute_list']) :$data['attribute_list'] = '';
        !empty($data['view_add_set']) && is_array($data['view_add_set']) ? $data['view_add_set'] = arr2str($data['view_add_set']) :$data['view_add_set'] = '';
        !empty($data['view_edit_set']) && is_array($data['view_edit_set']) ? $data['view_edit_set'] = arr2str($data['view_edit_set']) :$data['view_edit_set'] = '';

        $validate_result = $this->validateCurdcreate->scene('edit')->check($data);

        if (!$validate_result) {

        return [RESULT_ERROR, $this->validateCurdcreate->getError()];
        }

        $url = url('curdcreateList');

        $result = $this->modelCurdcreate->setInfo($data);

        $result && action_log('Curdcreate' . '編輯Curdcreate，name' . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelCurdcreate->getError()];
    }

    /**
    * 获取Curdcreate信息
    */
    public function getCurdcreateInfo($where = [], $field = true)
    {

        $info = $this->modelCurdcreate->getInfo($where, $field);
        $info['attribute_list'] = empty($info['attribute_list']) ? array() : str2arr($info['attribute_list']);
        $info['view_add']=empty($info['view_add']) ? array() : str2arr($info['view_add']);
        return $info;
    }


    /**
    * Curdcreate删除
    */
    public function curdcreateDel($where = [])
    {

        $result = $this->modelCurdcreate->deleteInfo($where);

        $result && action_log('删除', 'Curdcreate删除' . '，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, $this->modelCurdcreate->getError()];
    }
}
