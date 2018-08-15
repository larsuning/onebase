<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\curdcreate\curdcreate_add.html";i:1531126278;s:72:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\edit_btn_group.html";i:1533087617;}*/ ?>
<form action="<?php echo url(); ?>" method="post" class="form_single">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>名称</label>
                        <span>（系统后台显示菜单名称）</span>
                        <input class="form-control" name="name" placeholder="请输入菜单名称" value="<?php echo (isset($info['name']) && ($info['name'] !== '')?$info['name']:''); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>排序值</label>
                        <span>（用户菜单的排序，默认为 0）</span>
                        <input class="form-control" name="sort" placeholder="请输入菜单排序值" value="<?php echo (isset($info['sort']) && ($info['sort'] !== '')?$info['sort']:'0'); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>模块</label>
                        <span>（系统模块：默认为admin；后台总模块目录名称（admin、api、source、gy、ps）</span>
                        <input class="form-control" name="module" placeholder="请输入模块名称" value="<?php echo (isset($info['module']) && ($info['module'] !== '')?$info['module']:'admin'); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                    <label>CURD标识</label>
                    <span>(模型标识；比如:输入land，会生成文件名为land的文件)</span>
                    <input class="form-control" name="url" placeholder="请输入模型标识" value="<?php echo (isset($info['url']) && ($info['url'] !== '')?$info['url']:''); ?>" type="text">
                </div>
            </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>数据表名称</label>
                        <span>(比如:输入land_post,生成前缀(ob_)+land_post的mysql表(ob_land_post),模型会生成为LandPost的model文件)</span>
                        <input class="form-control" name="tb_name" placeholder="请输入数据表名称" value="<?php echo (isset($info['tb_name']) && ($info['tb_name'] !== '')?$info['tb_name']:''); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>模板类型</label>
                        <span>（模板类型默认为default）</span>
                        <select name="style" class="form-control">
                            <?php $_result=parse_config_array('config_module_style');if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value ="<?php echo $vo; ?>"><?php echo $vo; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>上级菜单</label>
                        <span>（所属的上级菜单）</span>
                        <select name="pid" class="form-control">
                            <option value="0">顶级菜单</option>
                            <?php if(is_array($menu_select) || $menu_select instanceof \think\Collection || $menu_select instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_select;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>是否隐藏</label>
                        <span>（若隐藏则在菜单中不显示）</span>
                        <div>
                            <label class="margin-r-5"><input type="radio" name="is_hide" value="1"> 是</label>
                            <label><input type="radio" name="is_hide"  value="0"> 否</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>图标</label>
                        <span>（菜单小图标，为空则显示系统默认图标）</span>
                        <?php $icon = (isset($info['icon']) && ($info['icon'] !== '')?$info['icon']:''); ?>
                        <?php echo widget('icon/index', ['name' => 'icon', 'value' => $icon]); ?>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-6">
                        <div class="form-group">
                            <div >
                                <label class="zdmar-left-10">字段管理<span class="zdtishi">（选中该字段后提交，该表才会真正建立）</span></label>
                                <div class="zdguanli">
                                    <div class=" zdkuangjia" >
                                        <div class="zdliebiao " ><span><label class="zdmar-left-10">字段列表</label></span></div>
                                        <div class="zdgundong">
                                            <ul class="ulnone">
                                                <li class="zili">
                                                <input type="checkbox" class="zdmar-right-5" checked="checked" disabled="true" > 字段名：[id] | 备注： 表主键id | 字段定义：[int(10) unsigned NOT NULL AUTO_INCREMENT]
                                                </li>
                                                <li class="zili">
                                                    <input type="checkbox" class="zdmar-right-5" checked="checked" disabled="true" > 字段名：[name] | 备注： 名称 | 字段定义：[char(50) NOT NULL DEFAULT '']
                                                </li>
                                                <li class="zili">
                                                    <input type="checkbox" class="zdmar-right-5" checked="checked" disabled="true" > 字段名：[status] | 备注： 数据状态 | 字段定义：[tinyint(1) NOT NULL DEFAULT '1']
                                                </li>
                                                <li class="zili">
                                                    <input type="checkbox" class="zdmar-right-5" checked="checked" disabled="true" > 字段名：[create_time] | 备注： 创建时间 | 字段定义：[int(11) unsigned NOT NULL DEFAULT '0']
                                                </li>
                                                <li class="zili">
                                                    <input type="checkbox" class="zdmar-right-5" checked="checked" disabled="true" > 字段名：[update_time] | 备注： 更新时间 | 字段定义：[int(11) unsigned NOT NULL DEFAULT '0']
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>列表的显示定义</label>
                            <span class="zdtishi">(默认列表模板的展示规则)</span>

                            <textarea class="form-control width-" name="list_grid" rows="9" placeholder="例子：
id:编号
name:名称
status:状态
create_time:创建时间
" ><?php echo (isset($info['list_grid']) && ($info['list_grid'] !== '')?$info['list_grid']:'id:编号
name:名称
status:状态
create_time:创建时间'); ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>是否生成数据表</label>
                            <span>（默认为是，否则不生成）</span>

                            <label class="margin-r-5"><input type="radio" checked name="is_select" value="1"> 是</label>
                            <label><input type="radio" name="is_select"  value="2"> 否</label>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>是否显示生成api文档的表单</label>
                            <span>（默认为不显示）</span>

                            <label class="margin-r-5"><input type="radio" name="api_is_show" value="1"> 是</label>
                            <label><input type="radio" name="api_is_show" checked value="2"> 否</label>

                        </div>
                    </div>

                    </div>

            </div>
            <div class="row" id="api_form" style="border: #1ab7ea solid;display: none;">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>名称</label>
                        <span>（API接口名称；比如输入:土地，接口文档会生成土地列表,土地新增,土地编辑,土地信息,土地删除 ）</span>
                        <input class="form-control" name="api_name" placeholder="请输入API接口名称" value="" type="text">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>请求地址</label>
                        <span>（后台模块/控制器/方法名 比如:source/land/landaction,如果是api后台模块 比如:land/landaction）</span>
                        <input class="form-control" name="api_url" placeholder="请输入API请求地址" value="" type="text">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>分组</label>
                        <select name="group_id" class="form-control">
                            <option value="0">---请选择分组---</option>
                            <?php if(is_array($group_list) || $group_list instanceof \think\Collection || $group_list instanceof \think\Paginator): $i = 0; $__LIST__ = $group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>生成选择</label>
                        <div class="form-group">
                            <?php $abc = ['list','add','edit','del','info']; if(is_array($abc) || $abc instanceof \think\Collection || $abc instanceof \think\Paginator): $i = 0; $__LIST__ = $abc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            [<?php echo $vo; ?>]  <input type="checkbox" name="api_checkbox[]" value="<?php echo $vo; ?>">
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>请求类型</label>
                        <span>（POST | GET）</span>
                        <select name="request_type" class="form-control">
                            <option value="0">POST</option>
                            <option value="1">GET</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>是否验证用户令牌：user_token</label>
                        <span>（若为否则为无需验证身份的接口，若为是则需要登录后获取 user_token）</span>
                        <div>
                            <label class="margin-r-5"><input type="radio" checked="checked" name="is_user_token"  value="0"> 否</label>
                            <label><input type="radio" name="is_user_token" value="1"> 是</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>是否响应数据签名：data_sign</label>
                        <span>（若为否则无需验证数据签名，若为是则会返回 data_sign 用于验证数据是否安全）</span>
                        <div>
                            <label  class="margin-r-5"><input type="radio" checked="checked" name="is_response_sign"  value="0"> 否</label>
                            <label><input type="radio" name="is_response_sign" value="1"> 是</label>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">

                    <div class="form-group">
                        <label>是否验证请求数据签名：data_sign</label>
                        <span>（若为否则无需验证数据签名，若为是则需要请求中带 data_sign 字段 用于验证数据安全）</span>
                        <div>
                            <label  class="margin-r-5"><input type="radio" checked="checked" name="is_request_sign"  value="0"> 否</label>
                            <label><input type="radio" name="is_request_sign" value="1"> 是</label>
                        </div>
                    </div>
                </div>

                table表名:
                <input type="text" name="table_name" placeholder="请输入要解析的数据表名称">
                <input  type="submit" class="btn ladda-button ajax-post" id="api_doc_create" value="生成api接口文档" data-style="slide-up" target-form="form_single" />
            </div>
        </div>
        <div class="box-footer">

            <input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:'0'); ?>"/>

            <button  type="submit" class="btn ladda-button ajax-post" data-style="slide-up" target-form="form_single">
    <span class="ladda-label"><i class="fa fa-send"></i> 确 定</span>
</button>

<a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>

        </div>
    </div>
</form>

<script type="text/javascript">

    ob.setValue("is_hide", <?php echo (isset($info['is_hide']) && ($info['is_hide'] !== '')?$info['is_hide']:0); ?>);
    ob.setValue("pid", <?php echo (isset($info['pid']) && ($info['pid'] !== '')?$info['pid']:0); ?>);

    $(function () {
        $(".ladda-button").click(function () {
            var text = $(this).attr('id');
            if (text == 'api_doc_create') {
                $("form").attr("action", "<?php echo url('curdcreate/api_doc_create'); ?>");
            } else {
                $("form").attr("action", "<?php echo url("","",true,false);?>");
            }
        });

        $("input[name='api_is_show']").click(function () {
            var val = $(this).val();
            if (val == 1) {
                $('#api_form').show();
            } else if (val == 2) {
                $('#api_form').hide();
            }
        });
    })

</script>
<style type="text/css">
    .width-{
        width: 300px;
    }
    .draging-place{
        background-color: white !important;
        border: dashed 1px gray !important;
    }
    .zdmar-left-10{
        margin-left:10px;
    }
    .zdmar-right-5{
        margin-right: 5px;
    }
    .zdtishi{
        margin-left: 8px;color: #aaa;font-weight: normal;
    }
    .zdguanli{
        padding: 0px 0px 10px 10px;
    }
    .zdkuangjia{
        margin-bottom: 1px;    display: inline-block;
        border:1px solid #cdcdcd;
        background-color: #EDEDED;
        color: #404040;
        line-height: 35px;

        height: 435px;
        clear: both;    float: left;
        margin-right: 20px;
        margin-left: 0px;
    }
    .zdliebiao{
        border: 1px solid #cdcdcd;color: #404040;margin:0px 0px 1px 0px;padding:1px;
    }
    .zdgundong{
        height:375px;width: 640px;margin-left:0px;margin-top: 8px;padding-left: 10px;padding-bottom: 10px;overflow:auto;
    }
    .ulnone{
        list-style-type: none;

    }
    .zili{

        border: 1px solid #cdcdcd;margin-left: -50px;padding-left: 10px;background-color:#ffffff;margin-bottom: 5px;
    }
</style>