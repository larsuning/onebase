<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

namespace app\common\logic;

use Think\Db;
/**
 * pc端公共方法
 */
class Common extends LogicBase
{
    /** 递归、无限极分类
     * @param $arr 数据
     * @param $pid 父id
     * @param $step 级别
     * @return array 组装之后的数组
     */
    public function GetTree($arr,$pid,$step){
        global $tree;
        foreach($arr as $key=>$val) {
            if($val['pid'] == $pid) {
                $flg = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$step);
                $pid ==0 ? $val['name'] = $val['name'] : $val['name'] = $flg.'├'.$val['name'];
                $tree[] = $val;
                $this->GetTree($arr , $val['id'] ,$step+1);
            }
        }
        return $tree;
    }

    /**
     * 生成接口文档
     * @param $data 表单的数据
     * @return array
     */
    public function api_doc_create($data)
    {
        $data['api_name'] = trim($data['api_name']);
        $data['api_url'] = trim($data['api_url']);
        $data['table_name'] = trim($data['table_name']);

        $api_checkbox_name = ['list'=>'列表','add'=>'新增','edit'=>'编辑','del'=>'删除','info'=>'信息'];

        if(empty($data['api_name'])) return [RESULT_ERROR,'API接口名称不能为空'];

        if(!empty($data['api_checkbox'])) {
            foreach ($data['api_checkbox'] as $api_checkbox) {
//                d($api_checkbox_name[$api_checkbox]);
                if($this->modelApi->getInfo(['name'=>$data['api_name'].$api_checkbox_name[$api_checkbox]],'id')) return [RESULT_ERROR,'选择为'.$api_checkbox.'的API功能重复'];
            }
        }else{
            return [RESULT_ERROR,'请选择API功能'];
        }

//        $api_url_repeat = $this->modelApi->getInfo(['api_url'=>$data['api_url']],'id');

//        if($api_url_repeat) return [RESULT_ERROR,'请求地址重复'];

        if(empty($data['group_id'])) return [RESULT_ERROR,'请选择接口分组'];

        if(empty($data['table_name'])) return [RESULT_ERROR,'解析的表名为空'];

        $table_name = SYS_DB_PREFIX.$data['table_name'];

        $table_check = $this->table_is_exist($table_name);

        if(!$table_check) return [RESULT_ERROR,'输入的数据表不存在，无法解析'];
        // 读取表的所有字段属性信息
        $table_infos = $this->show_table_fields($table_name);

        if(!$table_infos) return [RESULT_ERROR,'读取字段信息失败'];

        $info = $this->api_data_assemble($data,$table_infos);

        $item = $this->modelApi->saveAll($info);

        if(!$item) return [RESULT_ERROR,'生成api接口文档失败'];
        
        if($item) return[RESULT_SUCCESS,'生成api接口文档成功'];

    }

    /**
     * 组装规范数据
     * @param $data 表单的数据
     * @param $table_infos 表名的所有字段信息
     * @return array 组装后的list/add/edit/info/del 的数据
     */
    public function api_data_assemble($data,$table_infos)
    {
        // 组装数据。字段名为键名，备注为键值
        foreach ($table_infos as $k=> $item) { $table_datas[$item['Field']] =$item['Comment']; }
        // 请求数据的参数
        $request_data = [
            'field_name'=>['action'],
            'data_type'=>['0'],
            'is_require'=>['1'],
        ];
        // 响应数据的参数
        foreach ($table_datas as $key=>$table_data) {

            $list_response_data['field_name'][] = $key;
            $list_response_data['data_type'][] = 0;
            if($key=='id'){
                $list_response_data['field_describe'][] = $data['api_name'].'的id';
            }else {
                $list_response_data['field_describe'][] = $table_data;
            }
            $datas[]= '"'.$key.'"'.':'.'****,';
        }
        // 组装数据 接口响应示例的data
        $das = implode("\n            ",$datas);
//        $api_arrs = ['list','add','edit','info','del'];
        $api_arrs = $data['api_checkbox'];

        foreach ($api_arrs as $api_arr) {
            switch ($api_arr)
            {
                case 'list':
                    $list_request_data = $request_data;
                    $list_request_data['field_describe'] = ['操作类型【'.$api_arr.'】'];
                    $api_list['name']=$data['api_name'].'列表';
                    $api_list['api_url']=$data['api_url'];
                    $api_list['request_type']=$data['request_type'];
                    $api_list['is_page']=1;
                    $api_list['is_request_data']=1;
                    $api_list['request_data']=transform_array_to_json($list_request_data);
                    $api_list['is_response_data']=1;
                    $api_list['response_data']=transform_array_to_json($list_response_data);
                    $api_list['group_id']=$data['group_id'];
                    $api_list['response_examples']=htmlspecialchars('{
    "code": 1,
    "msg": "操作成功",
    "data": [
        {
            '.$das.'
        },
        {
            '.$das.'
        }
        
    ],
    "exe_time": "0.003636"
}');
                    $api_list['describe_text']='';
                    $api_list['is_request_sign']=$data['is_request_sign'];
                    $api_list['is_response_sign']=$data['is_response_sign'];
                    $api_list['is_user_token']=$data['is_user_token'];
                    break;
                case 'add':
                    $table_add_datas = $table_datas;
                    $add_del_arrs = ['id','create_time','update_time','status'];
                    // 删除不需要的参数
                    foreach ($add_del_arrs as $add_del_arr) {
                        if(array_key_exists($add_del_arr,$table_add_datas)) unset($table_add_datas[$add_del_arr]);
                    }
                    // 请求数据的参数
                    foreach ($table_add_datas as $key=>$table_data) {
                        $add_request_data['field_name'][] = $key;
                        $add_request_data['data_type'][] = 0;
                        $add_request_data['is_require'][] = 1;
                        $add_request_data['field_describe'][] = $table_data;
                    }
                    array_unshift($add_request_data['field_name'],'action');
                    array_unshift($add_request_data['data_type'],0);
                    array_unshift($add_request_data['is_require'],1);
                    array_unshift($add_request_data['field_describe'],'操作类型【'.$api_arr.'】');
                    $api_add['name']=$data['api_name'].'新增';
                    $api_add['api_url']=$data['api_url'];
                    $api_add['request_type']=$data['request_type'];
                    $api_add['is_page']=0;
                    $api_add['is_request_data']=1;
                    $api_add['request_data']=transform_array_to_json($add_request_data);
                    $api_add['is_response_data']=0;
                    $api_add['response_data']='';
                    $api_add['group_id']=$data['group_id'];
                    $api_add['response_examples']=htmlspecialchars('{
    "code": 1,
    "msg": "操作成功",
    "exe_time": "0.003636"
}');
                    $api_add['describe_text']='';
                    $api_add['is_request_sign']=$data['is_request_sign'];
                    $api_add['is_response_sign']=$data['is_response_sign'];
                    $api_add['is_user_token']=$data['is_user_token'];
                    break;
                case 'edit':
                    $table_edit_datas = $table_datas;
                    $edit_del_arrs = ['id','create_time','update_time','status'];
                    // 删除不需要的参数
                    foreach ($edit_del_arrs as $edit_del_arr) {
                        if(array_key_exists($edit_del_arr,$table_edit_datas)) unset($table_edit_datas[$edit_del_arr]);
                    }
                    // 请求数据的参数
                    foreach ($table_edit_datas as $key=>$table_data) {
                        $edit_request_data['field_name'][] = $key;
                        $edit_request_data['data_type'][] = 0;
                        $edit_request_data['is_require'][] = 1;
                        $edit_request_data['field_describe'][] = $table_data;
                    }
                    array_unshift($edit_request_data['field_name'],'action','id');
                    array_unshift($edit_request_data['data_type'],0,0);
                    array_unshift($edit_request_data['is_require'],1,1);
                    array_unshift($edit_request_data['field_describe'],'操作类型【'.$api_arr.'】',$data['api_name'].'的id');
                    $api_edit['name']=$data['api_name'].'编辑';
                    $api_edit['api_url']=$data['api_url'];
                    $api_edit['request_type']=$data['request_type'];
                    $api_edit['is_page']=0;
                    $api_edit['is_request_data']=1;
                    $api_edit['request_data']=transform_array_to_json($edit_request_data);
                    $api_edit['is_response_data']=0;
                    $api_edit['response_data']='';
                    $api_edit['group_id']=$data['group_id'];
                    $api_edit['response_examples']=htmlspecialchars('{
    "code": 1,
    "msg": "操作成功",
    "exe_time": "0.003636"
}');
                    $api_edit['describe_text']='';
                    $api_edit['is_request_sign']=$data['is_request_sign'];
                    $api_edit['is_response_sign']=$data['is_response_sign'];
                    $api_edit['is_user_token']=$data['is_user_token'];
                    break;
                case 'info':
                    $info_request_data = $request_data;
                    array_push($info_request_data['field_name'],'id');
                    array_push($info_request_data['data_type'],0);
                    array_push($info_request_data['is_require'],1);
                    $info_request_data['field_describe'] = ['操作类型【'.$api_arr.'】',$data['api_name'].'的id'];
                    $api_info['name']=$data['api_name'].'信息';
                    $api_info['api_url']=$data['api_url'];
                    $api_info['request_type']=$data['request_type'];
                    $api_info['is_page']=0;
                    $api_info['is_request_data']=1;
                    $api_info['request_data']=transform_array_to_json($info_request_data);
                    $api_info['is_response_data']=1;
                    $api_info['response_data']=transform_array_to_json($list_response_data);
                    $api_info['group_id']=$data['group_id'];
                    $api_info['response_examples']=htmlspecialchars('{
    "code": 1,
    "msg": "操作成功",
    "data": [
        {
            '.$das.'
        },
    ],
    "exe_time": "0.003636"
}');
                    $api_info['describe_text']='';
                    $api_info['is_request_sign']=$data['is_request_sign'];
                    $api_info['is_response_sign']=$data['is_response_sign'];
                    $api_info['is_user_token']=$data['is_user_token'];
                    break;
                case 'del':
                    $del_request_data = $request_data;
                    array_push($del_request_data['field_name'],'id');
                    array_push($del_request_data['data_type'],0);
                    array_push($del_request_data['is_require'],1);
                    $del_request_data['field_describe'] = ['操作类型【'.$api_arr.'】',$data['api_name'].'的id'];
                    $api_del['name']=$data['api_name'].'删除';
                    $api_del['api_url']=$data['api_url'];
                    $api_del['request_type']=$data['request_type'];
                    $api_del['is_page']=0;
                    $api_del['is_request_data']=1;
                    $api_del['request_data']=transform_array_to_json($del_request_data);
                    $api_del['is_response_data']=0;
                    $api_del['response_data']='';
                    $api_del['group_id']=$data['group_id'];
                    $api_del['response_examples']=htmlspecialchars('{
    "code": 1,
    "msg": "操作成功",
    ],
    "exe_time": "0.003636"
}');
                    $api_del['describe_text']='';
                    $api_del['is_request_sign']=$data['is_request_sign'];
                    $api_del['is_response_sign']=$data['is_response_sign'];
                    $api_del['is_user_token']=$data['is_user_token'];
                    break;
            }
        }

        if(isset($api_list)) $types[] = $api_list;
        if(isset($api_add)) $types[] = $api_add;
        if(isset($api_edit)) $types[] = $api_edit;
        if(isset($api_info)) $types[] = $api_info;
        if(isset($api_del)) $types[] = $api_del;

        foreach ($types as $type) {
            if(isset($type)) $infos[] = $type;
        }

        return $infos;
    }

    /**
     * 获取该表的所有字段信息
     * @param $table_name 表名
     * @return bool|mixed true:返回数据；false:false
     */
    public function show_table_fields($table_name)
    {
        $sql = "show full fields from $table_name";

        $exist = Db::query($sql);

        if(empty($exist)) return false;

        return $exist;

    }

    /**
     * 解析该标识数据表的所有字段信息，完成入库更新
     * @param $data 表单的数据
     * @return array true:成功 ； false:失败返回失败原因
     */
    public function update_table_attributes($data)
    {
        $table_name = SYS_DB_PREFIX.$data['tb_name'];

        $item = $this->table_is_exist($table_name);

        if(!$item)  return [RESULT_ERROR,$table_name.'表不存在,无法读取字段信息'];

        $fields = $this->show_table_fields($table_name);

        if(!$fields) return [RESULT_ERROR,'读取字段信息失败'];
        // 组装数据 type类型为string
        foreach ($fields as $k=>$field) {
            $list[$field['Field']]['name'] = $field['Field'];
            $list[$field['Field']]['title'] = $field['Comment'];
            $field['Null']=='NO' ? $null = ' NOT NULL' : $null = '';
            $list[$field['Field']]['field'] = $field['Type'].$null;
            $list[$field['Field']]['type'] = 'string';
            $field['Default']===null ? $value = '' : $value=$field['Default'];
            $list[$field['Field']]['value'] = $value;
            $list[$field['Field']]['model_id']=$data['id'];
        }
        // 要删除的变量名
        $arr = ['id','name','status','create_time','update_time'];
        // 去重基础属性字段
        foreach ($arr as $v) { if(array_key_exists($v,$list)) unset($list[$v]); }

        $attrs = $this->modelAttribute->where(['model_id'=>$data['id']])->field('name,id')->select();

        // 如果在attribute表里 ，该字段在$list中存在，则去重
        foreach ($attrs as $items) {
            // 删除不存在的字段
            if(!array_key_exists($items['name'],$list)) $this->modelAttribute->deleteInfo(['id'=>$items['id']],true);
            if(array_key_exists($items['name'],$list)) unset($list[$items['name']]);
//            var_dump($items->toArray());
        }

        if(empty($list)) return [RESULT_ERROR,$table_name.'没有属性需要更新入库'];
        // 批量入库
        $msg = $this->modelAttribute->saveAll($list);

        if(!$msg) return [RESULT_ERROR,'更新'.$table_name.'属性入库失败'];

        // 更新CURDcreate表里view_add_set,view_edit_set字段的值
        $ids = $this->modelAttribute->getColumn(['model_id'=>$data['id']],'id');
        $view_attr_list = arr2str($ids);
        $this->modelCurdcreate->updateInfo(['id'=>$data['id']],['view_add_set'=>$view_attr_list,'view_edit_set'=>$view_attr_list]);

        if($msg) return [RESULT_SUCCESS,'更新'.$table_name.'属性入库成功'];
    }
    /**
     * 处理
     * @param $data 表单的数据
     * @return array true:提示成功  false:提示失败
     */
    public function create_table($data)
    {
        if(empty($data['table_name'])) return [RESULT_ERROR,'数据表不能为空'];
        $data['table_name']=addslashes(strip_tags($data['table_name']));
        $table_name = SYS_DB_PREFIX.$data['table_name'];

        $item = $this->table_is_exist($table_name);
        if($item)
        {
            return [RESULT_ERROR,$table_name.'已存在'];
        }else {
            if(!empty($data['attribute_list']) && is_array($data['attribute_list']) )
            {
                $info = $this->logicAttribute->getColumn(['model_id'=>$data['id']]);
                foreach ($data['attribute_list'] as $datum) {
                    foreach ($info as $v) {
                        if($datum==$v['id']){
                            // 如果是textarea或editor 则不能有default属性
                            if($v['type']=='textarea' || $v['type']=='editor'){
                                $sql[] = '`'.$v['name'].'` '.$v['field']." COMMENT '".$v['title']."' ";
                            }else{

                                $sql[] = '`'.$v['name'].'` '.$v['field']." DEFAULT '".$v['value']."' COMMENT '".$v['title']."' ";
                            }
                        }
                    }
                }
                $sql = implode(',',$sql).',';
            }else{
                $sql = '';
            }
            $this->create_sql($table_name,$sql);
            return [RESULT_SUCCESS,'创建'.$table_name.'表成功'];
        }
    }

    /**
     * @param $table_name 要生成表名
     * @param string $fields 要添加的sql字段语句
     */
    public function create_sql($table_name,$fields='')
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` char(50) NOT NULL DEFAULT '' COMMENT '名称',
        `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
        `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
        `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',$fields
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        Db::execute($sql);
    }

    /**
     * @param $table_name 表名
     * @return bool 存在：true 否则：false；
     */
    public function table_is_exist($table_name)
    {
        $sql = "show tables like '$table_name'";
        $exist = Db::query($sql);
        if(empty($exist))
        {
            return false;
        }else{
            return true;
        }
    }

    /**
     * 创建目录
     * @access protected
     * @param  array $list 目录列表
     * @return void
     */
    public function buildDir($dir)
    {

        if (!is_dir($dir)) {
            // 创建目录
            mkdir($dir, 0755, true);
        }
    }

    /**
     * @param $data 表单的数据
     * @param $item 列表要显示要显示的字段
     * @param $file_view_name '_list'
     * @return array
     */
    public function create_list_view($data,$item,$file_view_name,$module)
    {

        if(empty($module)) return [RESULT_ERROR,'模板目录不能为空'];

        $info = $this->logicCurdcreate->getInfo(['id'=>$data['id']],'id,module,url')->toArray();
        $url = $info['url'];
        $file_dir = APP_PATH.$module.DS.'view'.DS.$url;
        $this->buildDir($file_dir);
        $filename = $file_dir.DS.$url.$file_view_name.'.html';
        $viewname = $url.$file_view_name;

        if(empty(implode('',$item))){
            $tr ='';
            $td ='';
        }else{
            foreach ($item as $k =>$v)
            {
                $tr[] = "<th>$v</th>";
                if($k == 'status'){
                    $td[]='<td><ob_link><a class="ajax-get" href="{:url(\'setStatus\', array(\'ids\' => $vo[\'id\'], \'status\' => (int)!$vo[\'status\']))}">{$vo.status_text}</a></ob_link></td>';
                }else{
                    $td[] = '<td>{$vo.'."$k".'}</td>';
                }
            }

            $tr = implode('',$tr);
            $td = implode('',$td);
        }

        if (!is_file($filename)) {

            $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.'default'. DS . 'default_view_list_create.tpl');
            $content = str_replace(['{$tr}','{$td}','{$name}'],[$tr,$td,$url],$content);
            file_put_contents($filename,$content);
            return [RESULT_SUCCESS,'生成模板视图成功'];
        }else{

            return [RESULT_ERROR,$viewname.'模板视图文件已存在'];
        }

    }

    /**
     * @param array $data 表单传过来的数据
     * @param $view_name attribute表里要(view_add或view_edit)排序的字段
     * @param $file_view_name _add 或 _edit
     * @return array
     */
    public function create_tpl_view($data=[],$view_name,$file_view_name,$module)
    {

        if(empty($module)) return [RESULT_ERROR,'模板目录不能为空'];

        $info = $this->logicCurdcreate->getInfo(['id'=>$data['id']],'id,module,url')->toArray();
        $url = $info['url'];
        $file_dir = APP_PATH.$module.DS.'view'.DS.$url;
        $this->buildDir($file_dir);
        $filename = $file_dir.DS.$url.$file_view_name.'.html';
        $viewname = $url.$file_view_name;
        if(empty($data[$view_name])){
            $tpl='';
        }else {

            $type_form = SYS_DB_PREFIX . 'attribute_type';
            $attrss = $this->modelAttribute
                ->alias('a')
                ->join("$type_form b", "a.type=b.type")
                ->field('a.id,a.name,a.title,a.value,a.extra,b.type,b.form')
                ->where(['model_id' => $data['id']])
                ->select();
            foreach ($attrss as $k => $v) {
                $attrs[] = $v->data;
            }
            $sort_arrt_ids = $data[$view_name];
            $tpl = $this->view_data_show($sort_arrt_ids, $attrs);
        }
        if (!is_file($filename)) {

            $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.'default'. DS . 'default_view_AddOrEdit_create.tpl');
            $content = str_replace('{$data}',$tpl,$content);
            file_put_contents($filename,$content);
            return [RESULT_SUCCESS,'生成模板视图成功'];
        }else{

            return [RESULT_ERROR,$viewname.'模板视图文件已存在'];
        }
    }

    /**
     * @param $sort_arrt_ids array 排序好的ids
     * @param $attrs array 该模块所有的module属性
     * @return array|string 组装好要显示的html标签
     */
    public function view_data_show($sort_arrt_ids,$attrs){

        foreach ($sort_arrt_ids as $datum) {
            foreach ($attrs as $key => $vs) {
                if($datum==$vs['id'])
                {
                    switch ($vs['type'])
                    {
                        // !:title @:name #:value %:extra
                        case 'num':         $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'string':      $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'textarea':    $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'date':        $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'datetime':    $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'bool':        $vs['form']=str_replace(['!','@','#','%'],[$vs['title'],$vs['name'],$vs['value'],$vs['extra']],$vs['form']);break;
                        case 'select':      $vs['form']=str_replace(['!','@','#','%'],[$vs['title'],$vs['name'],$vs['value'],$vs['extra']],$vs['form']);break;
                        case 'radio':       $vs['form']=str_replace(['!','@','#','%'],[$vs['title'],$vs['name'],$vs['value'],$vs['extra']],$vs['form']);break;
                        case 'checkbox':    $vs['form']=str_replace(['!','@','#','%'],[$vs['title'],$vs['name'],$vs['value'],$vs['extra']],$vs['form']);break;
                        case 'editor':      $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'picture':     $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                        case 'file':        $vs['form']=str_replace(['!','@'],[$vs['title'],$vs['name']],$vs['form']);break;
                    }
                    $tpl[] = $vs['form'];
                }
            }
        }
        $tpl = implode('',$tpl);
        return $tpl;
    }

    /**
     * @return array 模块列表自定义显示
     */
    public function view_list($where=[])
    {
        $info = $this->logicCurdcreate->getCurdcreateInfo(['url'=>CONTROLLER_NAME],'list_grid');
        $model_name = str_replace('&',ucfirst(CONTROLLER_NAME),'model&');
        $title = $this->data_list($info)['title'];
        $fields = $this->data_list($info)['fields'];
        if(!empty($title)) {
            $info = $this->$model_name->getList($where, $fields);
            $infos = $info->toArray()['data'];
        }else{
            $infos = '';
        }
        return ['title'=>$title,'infos'=>$infos];
    }

    /**
     * @param $info 指定的数据
     * @return array title:定义的标题显示; infos:显示的数据列表;
     */
    public function data_list($info)
    {

        if(empty($info['list_grid']))
        {
            $title='';
            $fields='';
        }else {

            $grids = preg_split('/[;\r\n]+/s', trim($info['list_grid']));

            foreach ($grids as &$value) {
                $val = explode(':', $value);
                // 支持多个字段显示
                $field = explode(',', $val[0]);
                $value = array('field' => $field, 'title' => $val[1]);
                $title[] = $value['title'];
                foreach ($field as $val) {
                    $array = explode('|', $val);
                    $fields[] = $array[0];
                }
            }

            $fields = implode(',',$fields);
        }

        return ['title'=>$title,'fields'=>$fields];
    }
    /**
     * @return array 页面自定义显示
     */
    public function view_style($view_style)
    {

        $adds = $this->logicCurdcreate->getCurdcreateInfo(['url'=>CONTROLLER_NAME],$view_style);

        $field = $adds[$view_style];
        if(!empty($field)){
            is_string($field) ? $add = str2arr($field) : $add = $field;
            $data = $this->show_form(CONTROLLER_NAME);
            foreach ($add as $vs)
            {
                foreach ($data as $v)
                {
                    if($vs==$v['id'])
                    {
                        $datas[]=$v;
                    }
                }
            }
        }else{

            $datas ='';
        }

        return $datas;
    }

    /**
     * @return array 表单显示
     */
    public function show_form()
    {
        $info = $this->logicCurdcreate->getCurdcreateInfo(['url'=>CONTROLLER_NAME],'id');
        $model_id=$info['id'];
        
        $data = $this->logicAttribute->field('id,title,type,value,is_show,name,extra')->where(['model_id'=>$model_id])->select();
        foreach ($data as $v) {
            $datas[]=$v->toArray();
        }
        return $datas;
    }

    /**
     * @param $data 表单数据
     * @return mixed 重新组装数据
     */
    public function data_run($data,$field='*'){

        $info = $this->logicCurdcreate->getCurdcreateInfo(['url'=>CONTROLLER_NAME],'id');

        $model_id=$info['id'];

        $info = $this->logicAttribute->field($field)->where(['model_id'=>$model_id])->select();
        if(empty($info)) return $data;
        foreach ($info as $v) {
            $infos[]=$v->toArray();
        }

        foreach ($infos as $v) {
            switch ($v['type'])
            {
                case 'checkbox':    $checkbox_name = $v['name'];break;
                case 'editor':      $editor_name=$v['name'];break;
                case 'date':        $date_name=$v['name'];break;
                case 'datetime':    $datetime_name=$v['name'];break;
            }
        }
        if(isset($checkbox_name)) {
            if (isset($data[$checkbox_name]) && is_array($data[$checkbox_name])) {
                $data[$checkbox_name] = arr2str($data[$checkbox_name]);
            }
        }
        if(isset($editor_name))
        isset($data[$editor_name]) && $data[$editor_name]=html_entity_decode($data[$editor_name]);

        if(isset($date_name))
        isset($data[$date_name]) && $data[$date_name]=strtotime($data[$date_name]);

        if(isset($datetime_name))
        isset($data[$datetime_name]) && $data[$datetime_name]=strtotime($data[$datetime_name]);

        return $data;
    }
    // 分析枚举类型字段值 格式 a:名称1,b:名称2
// 暂时和 parse_config_attr功能相同
// 但请不要互相使用，后期会调整
   public static function parse_field_attr($string) {
        if(0 === strpos($string,':')){
            // 采用函数定义
            return   eval('return '.substr($string,1).';');
        }elseif(0 === strpos($string,'[')){
            // 支持读取配置参数（必须是数组类型）
            return C(substr($string,1,-1));
        }

        $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
        if(strpos($string,':')){
            $value  =   array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k]   = $v;
            }
        }else{
            $value  =   $array;
        }
        return $value;
    }

    /**
     * 选择类型，返回数字类型及创建sql字段类型
     * @param string $type
     * @return array
     */
    public static function get_attribute_type($type=''){
        // TODO 可以加入系统配置
        static $_type = array(
            'num'       =>  array('数字','int(10) UNSIGNED NOT NULL'),
            'string'    =>  array('字符串','varchar(255) NOT NULL'),
            'textarea'  =>  array('文本框','text NOT NULL'),
            'date'      =>  array('日期','int(10) NOT NULL'),
            'datetime'  =>  array('时间','int(10) NOT NULL'),
            'bool'      =>  array('布尔','tinyint(2) NOT NULL'),
            'select'    =>  array('枚举','char(50) NOT NULL'),
            'radio'     =>  array('单选','char(10) NOT NULL'),
            'checkbox'  =>  array('多选','varchar(100) NOT NULL'),
            'editor'    =>  array('编辑器','text NOT NULL'),
            'picture'   =>  array('上传图片','int(10) UNSIGNED NOT NULL'),
            'file'      =>  array('上传附件','int(10) UNSIGNED NOT NULL'),
        );
        return $type?$_type[$type][0]:$_type;
    }

}
