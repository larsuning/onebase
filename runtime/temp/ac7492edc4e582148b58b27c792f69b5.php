<?php if (!defined('THINK_PATH')) exit(); /*a:11:{s:77:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\curdcreate\curdcreate_edit.html";i:1531723540;s:57:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout.html";i:1533087617;s:61:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\top.html";i:1533196293;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\header.html";i:1533112952;s:34:"../app/common/view/fakeloader.html";i:1533087617;s:70:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\sidebar_left.html";i:1533112952;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\crumbs.html";i:1533087617;s:72:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\edit_btn_group.html";i:1533087617;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\footer.html";i:1533112952;s:71:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\sidebar_right.html";i:1533087617;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\bottom.html";i:1533112952;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>OneBase <?php if(!(empty($ob_title) || (($ob_title instanceof \think\Collection || $ob_title instanceof \think\Paginator ) && $ob_title->isEmpty()))): ?> | <?php echo $ob_title; endif; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="__STATIC__/module/admin/ext/adminlte/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/dist/css/adminLTE.min.css">
    <!-- adminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/dist/css/skins/_all-skins.css">
    <link rel="stylesheet" href="__STATIC__/module/common/toastr/toastr.min.css">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/btnloading/dist/ladda-themeless.min.css">
    <link rel="stylesheet" href="__STATIC__/module/admin/css/onebase.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/module/admin/ext/remodal/remodal.css" media="all">
    <link rel="stylesheet" type="text/css" href="__STATIC__/module/admin/ext/remodal/remodal-default-theme.css" media="all">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/plugins/iCheck/all.css">
    <!-- jQuery 2.2.3 -->
    <script type="text/javascript" src="__STATIC__/module/common/jquery/jquery-2.2.3.min.js"></script>
    <!-- Pjax -->
    <script src="__STATIC__/module/admin/ext/jquerypjax/jquery.pjax.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="__STATIC__/module/admin/ext/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <script src="__STATIC__/module/admin/js/init.js"></script>
    <!-- <link rel="stylesheet" href="__STATIC__/ext/adminlte/dist/css/font-awesome.min.css">-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/dist/css/ionicons.min.css">
    
    <!-- Pjax Depend -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/datetimepicker/css/datetimepicker.css" type="text/css">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/datetimepicker/css/dropdown.css" type="text/css">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/edittable/jquery.edittable.min.css">
    <script type="text/javascript" src="__STATIC__/module/admin/ext/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="__STATIC__/module/admin/ext/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="__STATIC__/module/admin/ext/edittable/jquery.edittable.js"></script>
    <script charset="utf-8" src="__STATIC__/widget/admin/editor/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="__STATIC__/widget/admin/editor/kindeditor/zh_CN.js"></script>
    <script src="__STATIC__/widget/admin/file/jquery.Huploadify.js"></script>
    <script src="__STATIC__/module/admin/ext/echarts/echarts.min.js"></script>
    <!-- 选择框模块 -->
<script src="/static/module/common/datatable/js/selectpage.js"></script>
<link rel="stylesheet" href="/static/module/common/datatable/css/selectpage.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="fakeloader"></div>
<link href="__STATIC__/module/common/fakeloader/css/fakeLoader.css" rel="stylesheet">
<script src="__STATIC__/module/common/fakeloader/js/fakeLoader.min.js"></script>
<script type="text/javascript">
    
    $(".fakeloader").fakeLoader({
        timeToHide:99999,
        bgColor:"rgba(52, 52, 52, .0)",
        spinner:"spinner<?php echo $loading_icon; ?>"
    });
    
    $('.fakeloader').hide();
    
    var pjax_mode = "<?php echo $pjax_mode; ?>";
    
</script>
<script src="__STATIC__/module/admin/js/init_body.js"></script>
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo url('Index/index'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>OB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>OneBase</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">导航开关</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
              
<!--            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>-->
              
            <ul class="dropdown-menu">
              <li class="header">您有4个消息</li>
              
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                         张三
                        <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                      </h4>
                      <p>吃饭了吗？</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        李四
                        <small><i class="fa fa-clock-o"></i> 2 小时前</small>
                      </h4>
                      <p>麻烦发下今天的文章哦。</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">查看所有消息</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
<!--            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>-->
            <ul class="dropdown-menu">
              <li class="header">您有10个通知</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 今天有5个新成员加入
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> 这是一条系统警告通知。
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 销售了25个产品喔
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> 用户名修改通知
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">查看所有通知</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user3-128x128.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $member_info['nickname']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">

                <p>
                    <?php echo $member_info['nickname']; ?>
                  <small>上次登录时间：<?php echo $member_info['update_time']; ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat clear_cache" url="<?php echo url('Login/clearCache'); ?>">清理缓存</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat logout" url="<?php echo url('Login/logout'); ?>">安全退出</a>
                </div>
              </li>
            </ul>
          </li>
          
          <!-- 控制栏切换按钮 -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- 左侧导航栏 -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php echo $member_info['nickname']; ?></p>
            <?php echo $member_info['update_time']; ?>
          <!--<a href="#"><i class="fa fa-circle text-success"></i> 在线状态</a>-->
        </div>
      </div>
      
      
      <!-- search form -->
<!--      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="请输入搜索内容...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      
      <!-- 左侧菜单 -->
      <ul class="sidebar-menu">
        <?php echo $menu_view; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        
        <section class="content-header">
          <h1>
            <?php if(!(empty($ob_title) || (($ob_title instanceof \think\Collection || $ob_title instanceof \think\Paginator ) && $ob_title->isEmpty()))): ?><?php echo $ob_title; endif; if(!(empty($ob_describe) || (($ob_describe instanceof \think\Collection || $ob_describe instanceof \think\Paginator ) && $ob_describe->isEmpty()))): ?><small><?php echo $ob_describe; ?></small><?php endif; ?>
          </h1>
          <?php echo $crumbs_view; ?>
        </section>
<script type="text/javascript" src="__STATIC__/module/common/js/ddsort.js"></script>
<form action="<?php echo url(); ?>" method="post"  class="form_single">

    <div class="box">


        <div class="tab-content" id="contents">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>模型名称</label>
                        <span>（系统后台显示菜单名称）</span>
                        <input class="form-control" name="name" placeholder="请输入菜单名称" value="<?php echo (isset($info['name']) && ($info['name'] !== '')?$info['name']:''); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>模块目录</label>
                        <span>（系统模块：默认为admin）</span>
                        <input class="form-control" name="module" placeholder="请输入模块名称" value="<?php echo (isset($info['module']) && ($info['module'] !== '')?$info['module']:'admin'); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>CURD标示</label>
                        <span>（模型唯一标识）</span>
                        <input class="form-control" name="url" placeholder="请输入命名名称" value="<?php echo (isset($info['url']) && ($info['url'] !== '')?$info['url']:''); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>数据表名称</label>
                        <span>(比如:输入land_post,生成前缀(ob_)+land_post的mysql表(ob_land_post))</span>
                        <input class="form-control" name="tb_name" placeholder="请输入数据表名称" value="<?php echo (isset($info['tb_name']) && ($info['tb_name'] !== '')?$info['tb_name']:''); ?>" type="text">
                    </div>
                </div>
            </div>

            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <div >
                            <label class="zdmar-left-10">字段管理<span class="zdtishi"><br>(生成table按钮：选中该字段后提交,输入数据表名称,再点击生成)<br>(更新属性入库：更新后的字段全是string类型,若要生成addview或editview,需要自己更改属性的type再生成view)</span></label>
                            <div class="zdguanli">
                                <div class=" zdkuangjia" >
                                    <div class="zdliebiao " ><span><label class="zdmar-left-10">字段列表[ <a href="<?php echo url('attribute/attributeAdd?model_id='.$info['id']); ?>" target="_balnk">新增</a>
							<a href="<?php echo url('attribute/attributeList?model_id='.$info['id']); ?>" target="_balnk">管理</a> ]</label></span>
                                        <input type="checkbox" id="attribute_list_fanxuan"/> 反选|table表:
                                        <input type="text" name="table_name" placeholder="请输入要生成的数据表名称"><input  type="submit" class="btn ladda-button ajax-post" id="create_table" value="生成table" data-style="slide-up" target-form="form_single" />
                                        <input  type="submit" class="btn ladda-button ajax-post" id="update_table_attributes" value="更新属性字段入库" data-style="slide-up" target-form="form_single" />
                                    </div>
                                    <div class="zdgundong">
                                        <ul class="ulnone" id="attribute_list">
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
                                            <?php if(is_array($fields) || $fields instanceof \think\Collection || $fields instanceof \think\Paginator): if( count($fields)==0 ) : echo "" ;else: foreach($fields as $k=>$field): ?>
                                            <li class="zili">

                                                <input type="checkbox" class="zdmar-right-5" name="attribute_list[]" value="<?php echo $field['id']; ?>" <?php if(in_array($field['id'],$info['attribute_list'])): ?>checked="true"<?php endif; ?> />  [<?php echo $field['id']; ?>]字段名：[<?php echo $field['name']; ?>] | 备注： <?php echo $field['title']; ?> | 字段定义：[<?php echo $field['field']; ?> DEFAULT '<?php echo $field['value']; ?>']
                                                <?php if(empty($info['view_add_set']) || (($info['view_add_set'] instanceof \think\Collection || $info['view_add_set'] instanceof \think\Paginator ) && $info['view_add_set']->isEmpty())): ?>
                                                <input type="hidden" name="view_add_set[]" value="<?php echo $field['id']; ?>">
                                                <?php endif; if(empty($info['view_edit_set']) || (($info['view_edit_set'] instanceof \think\Collection || $info['view_edit_set'] instanceof \think\Paginator ) && $info['view_edit_set']->isEmpty())): ?>
                                                <input type="hidden" name="view_edit_set[]" value="<?php echo $field['id']; ?>">
                                                <?php endif; ?>
                                            </li>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>列表页面的显示定义</label>
                        <span class="zdtishi">(默认列表模板的展示规则)</span>
                        <input  type="submit" class="btn ladda-button ajax-post" id="list_tpl" value="生成list视图模板" data-style="slide-up" target-form="form_single" />
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

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div >
                            <label class="zdmar-left-10">新增页面的显示定义<span class="zdtishi">（选中该字段后提交，新增页面才会显示）</span></label>
                            <div class="zdguanli">
                                <div class=" zdkuangjia" >
                                    <div class="zdliebiao " ><span><label class="zdmar-left-10">字段列表</label>
                                    <input  type="submit" class="btn ladda-button ajax-post" id="add_tpl" value="生成add视图模板" data-style="slide-up" target-form="form_single" />
                                    </span>
                                        <input type="checkbox" id="add_fanxuan"/> 反选
                                    </div>
                                    <div class="zdgundong">
                                        <ul class="ulnone" id="view_add">
                                            <?php $_5b62cc8d41d74=str2arr($info['view_add_set']); if(is_array($_5b62cc8d41d74) || $_5b62cc8d41d74 instanceof \think\Collection || $_5b62cc8d41d74 instanceof \think\Paginator): if( count($_5b62cc8d41d74)==0 ) : echo "" ;else: foreach($_5b62cc8d41d74 as $key=>$vs): if(is_array($fields) || $fields instanceof \think\Collection || $fields instanceof \think\Paginator): if( count($fields)==0 ) : echo "" ;else: foreach($fields as $k=>$field): if($vs == $field['id']): ?>
                                            <li class="zili">
                                                <input type="checkbox" class="zdmar-right-5" name="view_add[]" value="<?php echo $field['id']; ?>" <?php if(in_array($field['id'],$info['view_add'])): ?>checked="checked"<?php else: endif; ?> />  [<?php echo $field['id']; ?>]字段名：[<?php echo $field['name']; ?>] | 备注： <?php echo $field['title']; ?> | 字段定义：[<?php echo $field['field']; ?> DEFAULT '<?php echo $field['value']; ?>']
                                                <input type="hidden" name="view_add_set[]" value="<?php echo $vs; ?>">
                                            </li>
                                            <?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="zdmar-left-10">编辑页面的显示定义<span class="zdtishi">（选中该字段后提交，编辑页面才会显示）</span></label>
                        <div class="zdguanli">
                            <div class=" zdkuangjia" >
                                <div class="zdliebiao " ><span><label class="zdmar-left-10">字段列表</label><input  type="submit" class="btn ladda-button ajax-post" id="edit_tpl" value="生成edit视图模板" data-style="slide-up" target-form="form_single" />
                                    </span>
                                    <input type="checkbox" id="edit_fanxuan"/> 反选
                                </div>
                                <div class="zdgundong">
                                    <ul class="ulnone" id="view_edit">
                                        <?php $_5b62cc8d41d33=str2arr($info['view_edit_set']); if(is_array($_5b62cc8d41d33) || $_5b62cc8d41d33 instanceof \think\Collection || $_5b62cc8d41d33 instanceof \think\Paginator): if( count($_5b62cc8d41d33)==0 ) : echo "" ;else: foreach($_5b62cc8d41d33 as $key=>$vs): if(is_array($fields) || $fields instanceof \think\Collection || $fields instanceof \think\Paginator): if( count($fields)==0 ) : echo "" ;else: foreach($fields as $k=>$field): if($vs == $field['id']): ?>
                                        <li class="zili">

                                            <input type="checkbox" class="zdmar-right-5" name="view_edit[]" value="<?php echo $field['id']; ?>" <?php if(in_array($field['id'],$info['view_edit'])): ?>checked="true"<?php endif; ?> />  [<?php echo $field['id']; ?>]字段名：[<?php echo $field['name']; ?>] | 备注： <?php echo $field['title']; ?> | 字段定义：[<?php echo $field['field']; ?> DEFAULT '<?php echo $field['value']; ?>']
                                            <input type="hidden" name="view_edit_set[]" value="<?php echo $vs; ?>">
                                        </li>
                                        <?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">

            <input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:'0'); ?>"/>

            <button  type="submit" class="btn ladda-button ajax-post" data-style="slide-up" target-form="form_single">
    <span class="ladda-label"><i class="fa fa-send"></i> 确 定</span>
</button>

<a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>

        </div>
</form>
<!--<script type="text/javascript" src="__STATIC__/jquery.dragsort-0.5.1.min.js"></script>-->
<script type="text/javascript">

    $(function () {
        $(".ladda-button").click(function () {
            var text = $(this).attr('id');
            if (text == "add_tpl") {
                $("form").attr("action", "<?php echo url('curdcreate/create_add_view'); ?>");
            }else if(text == "edit_tpl"){
                $("form").attr("action", "<?php echo url('curdcreate/create_edit_view'); ?>");
            } else if(text == "list_tpl") {
                $("form").attr("action", "<?php echo url('curdcreate/create_list_view'); ?>");
            }else if(text == 'create_table') {
                $("form").attr("action", "<?php echo url('curdcreate/create_sql_table'); ?>");
            }else if(text == 'update_table_attributes'){
                $("form").attr("action", "<?php echo url('curdcreate/update_table_attributes'); ?>");
            }else{
                $("form").attr("action", "<?php echo url("","",true,false);?>");
            }
        });


        $("input[name='api_is_show']").click(function(){
            var val = $(this).val();
           if(val==1){
               $('#api_form').show();
           }else if(val == 2){
               $('#api_form').hide();
           }
        });

        $("#add_fanxuan").click(function(){

            $("#view_add > li input:checkbox").each(function(){

                $(this).prop("checked",!$(this).prop("checked"));
            });

        });
        $("#edit_fanxuan").click(function(){

            $("#view_edit > li input:checkbox").each(function(){

                $(this).prop("checked",!$(this).prop("checked"));
            });
        });
        $("#attribute_list_fanxuan").click(function(){
            $("#attribute_list > li input[name='attribute_list[]']:checkbox").each(function(){
                $(this).prop("checked",!$(this).prop("checked"));
            });
        });
    })



    $('#view_add').DDSort();
    $('#view_edit').DDSort();
    ob.setValue("is_hide", <?php echo (isset($info['is_hide']) && ($info['is_hide'] !== '')?$info['is_hide']:0); ?>);
    ob.setValue("pid", <?php echo (isset($info['pid']) && ($info['pid'] !== '')?$info['pid']:0); ?>);

    /*    //拖曳插件初始化
        $(function(){
            $("#ceshi").dragsort();
            $(".needdragsort").dragsort({
                dragSelector:'div',
                // placeHolderTemplate: '<li class="draging-place">&nbsp;</li>',
                dragBetween:true,	//允许拖动到任意地方
                dragEnd:function(){
                    var self = $(this);
                    self.find('input').attr('name', 'field_sort[' + self.closest('ul').data('group') + '][]');
                }
            });
        })*/
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>版本号</b> 1.0.0
    </div>
    <strong>
        版权©2014 - 2016 OneBase .
    </strong>
      保留所有权利。
  </footer>
  
  <script src="__STATIC__/module/admin/js/pjax_init.js"></script>
  
  <!-- 控制栏 -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
<!--    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-bell-o"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>-->
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
<!--        <h3 class="control-sidebar-heading">通知开关</h3>
        
          <div class="form-group">
            <label class="control-sidebar-subheading">
              异常登录是否通知
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              不在常用地区或常用IP登录是否通知用户，默认为是。
            </p>
          </div>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              行为异常是否限制
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              用户行为异常是否限制其操作，默认为是。
            </p>
          </div>-->
        
      </div>
      
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
<!--        <form method="post">
          <h3 class="control-sidebar-heading">系统开关</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              是否允许注册
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              若勾选后则不允许用户注册，默认为是。
            </p>
          </div>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              是否调试模式
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              若为调试模式页面将显示Trace信息，默认为是。
            </p>
          </div>
        </form>-->
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script src="__STATIC__/module/admin/ext/adminlte/dist/js/app.min.js"></script>
<script src="__STATIC__/module/admin/ext/adminlte/dist/js/init.js"></script>
<script src="__STATIC__/module/common/toastr/toastr.min.js"></script>
<script src="__STATIC__/module/admin/ext/btnloading/dist/spin.min.js"></script>
<script src="__STATIC__/module/admin/ext/btnloading/dist/ladda.min.js"></script>
<script src="__STATIC__/module/admin/ext/remodal/remodal.min.js"></script>
<script src="__STATIC__/module/admin/ext/adminlte/plugins/iCheck/icheck.min.js"></script>
<script src="__STATIC__/module/admin/js/onebase.js"></script>
<link rel="stylesheet" href="__STATIC__/module/admin/css/ob_skin.css">
<?php echo hook('hook_view_admin'); ?>
</body>
</html>