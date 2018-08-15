<?php if (!defined('THINK_PATH')) exit(); /*a:10:{s:69:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\inspection\sorting.html";i:1534325241;s:57:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout.html";i:1533087617;s:61:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\top.html";i:1533783331;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\header.html";i:1533112952;s:34:"../app/common/view/fakeloader.html";i:1533087617;s:70:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\sidebar_left.html";i:1533112952;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\crumbs.html";i:1533087617;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\footer.html";i:1533112952;s:71:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\sidebar_right.html";i:1533087617;s:64:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\layout\bottom.html";i:1533112952;}*/ ?>
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
 <!--表格分页组件-->
    <script src="/static/module/common/datatable/js/jquery.dataTables.js"></script>
    <script src="/static/module/common/datatable/js/dataTables.select.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/module/common/datatable/css/jquery.dataTables.css">

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
    <div class="box">

    <div class="box-header">
        <?php if(empty($review) || (($review instanceof \think\Collection || $review instanceof \think\Paginator ) && $review->isEmpty())): ?>
            <h4 style="float:left">日期：<?php echo date('Y-m-d'); ?></h4>
        <?php else: ?>
            <h4 style="float:left;">日期：<span style="text-decoration: underline;"><?php echo $review['record_date']; ?></span></h4>
            <h4 style="float:left;margin-left: 20px;">巡检品管：<span style="text-decoration: underline;font-weight: bold"><?php echo $review['checker']; ?></span></h4>
        <?php endif; if(count($list) > '1'): ?>
         <select name=""   class="form-control" style="float:left;width: 150px;font-weight: bold;margin-left: 20px" id="round" >
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
            <option value="<?php echo $key; ?>">第<?php echo $k; ?>次巡查</option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <?php endif; if(empty($review) || (($review instanceof \think\Collection || $review instanceof \think\Paginator ) && $review->isEmpty())): if(empty(input('edit')) || ((input('edit') instanceof \think\Collection || input('edit') instanceof \think\Paginator ) && input('edit')->isEmpty())): ?>
            <select name=""   class="form-control" style="float:right;width: 150px;font-weight: bold" id="sorting_shift">
                <?php if(is_array($shift) || $shift instanceof \think\Collection || $shift instanceof \think\Paginator): $k = 0; $__LIST__ = $shift;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                    <option value="<?php echo $key; ?>" <?php if(!(empty($_GET['shift']) || (($_GET['shift'] instanceof \think\Collection || $_GET['shift'] instanceof \think\Paginator ) && $_GET['shift']->isEmpty()))): if($_GET['shift'] == $key): ?>selected<?php endif; endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>

            </select>
            <?php endif; else: ?>
            <select name=""   class="form-control" style="float:right;width: 150px;font-weight: bold" disabled='on'>
            <option value="1" <?php if($review['shift'] == '1'): ?>selected<?php endif; ?>>早班</option>
            <option value="2"  <?php if($review['shift'] == '2'): ?>selected<?php endif; ?>>中班</option>
            <option value="3" <?php if($review['shift'] == '3'): ?>selected<?php endif; ?> >晚班</option>
            </select>
        <?php endif; ?>


        
    </div>
        <div class="box-body">
            <div class="row">
              <table class="table table-bordered" style="margin: 5px" id='sorting'>
                <thead>
                    <tr>
                      <!-- <th>#</th> -->
                      <th>区域</th>
                      <th>时间（时/分）</th>
                      <th>员工规范</th>
                      <th>净重值(净重抽检)</th>
                      <th>实际值(净重抽检)</th>
                      <th>产品、包装外观</th>
                      <th>现场5S</th>

                    </tr>
                  </thead>
                  <?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>
                  <tbody>
                      <tr><td colspan="7" style="text-align: center;height: 100px;line-height: 100px">当天的分拣区巡查记录已经全部提交完毕!</td></tr>
                  </tbody>
                  <?php endif; if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?>

                  <tbody>
                    <?php if(is_array($li) || $li instanceof \think\Collection || $li instanceof \think\Paginator): $i = 0; $__LIST__ = $li;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr data-id="<?php echo $vo['id']; ?>">
                        <td> <?php echo $vo['area']; ?> </td>
                        <td> <input type="text" value="<?php echo $vo['inspectioned_at']; ?>" name="inspectioned_at"/> </td>
                        <td> <input type="text" value="<?php echo $vo['employee_action']; ?>" name="employee_action" /> </td>
                        <td> <input type="text" value="<?php echo $vo['product_standard']; ?>" name='product_standard'/> </td>
                        <td> <input type="text" value="<?php echo $vo['product_actual']; ?>" name="product_actual" /> </td>
                        <td> <input type="text" value="<?php echo $vo['on_site']; ?>" name="on_site" /> </td>
                        <td> <input type="text" value="<?php echo $vo['appearance']; ?>" name="appearance" /> </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
                <?php endforeach; endif; else: echo "" ;endif; ?>

             </table>
                
            </div>
        </div>
    </div>
    
 
    
    <div class="box-footer">

 
         <?php if(empty($review) || (($review instanceof \think\Collection || $review instanceof \think\Paginator ) && $review->isEmpty())): ?>
        
        <a class="btn finish" ><i class="fa fa-history"></i> 完 成</a>

        <a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
        <?php else: if(empty($review['reviewer']) || (($review['reviewer'] instanceof \think\Collection || $review['reviewer'] instanceof \think\Paginator ) && $review['reviewer']->isEmpty())): ?>
            <div class="col-md-6">
                <div class="form-group" >
                    <label>审核意见</label>
                    <span></span>
                        <input type="text" class="form-control" name="review_note" value="" >
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group" >
                   
                        <a class="btn review" ><i class="fa fa-check"></i> 确 认 审 核</a>
                        <a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-6">
                <div class="form-group" >
                    <label>品质主管：<span style="font-size: 20px;text-decoration: underline;"><?php echo $review['reviewer']; ?></span></label><br>
                    <label>审核时间：<span style="font-size: 18px;text-decoration: underline;"><?php echo date('Y-m-d H:i:s',$review['update_time']); ?></span></label><br>
                    <label>审核意见：<span style="font-size: 18px;font-weight: normal;"><?php echo $review['review_note']; ?></span></label><br>
                    <br>
                    <br>
                    <a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
                        
                </div>
            </div>
        <?php endif; endif; ?>
        
    </div>

<script type="text/javascript">
    $('.date').datetimepicker({
        language:"zh-CN",
        todayHighlight:true,
        todayBtn:true,
        format:'yyyy-mm-dd',
        minView:1,
        autoclose:true,
        minView:'3'

    });

    $('.datetime').datetimepicker({
        language:"zh-CN",
        todayHighlight:true,
        todayBtn:true,
        format:'yyyy-mm-dd hh:ii',
        minView:1,
        autoclose:true,

    });

    $('input').attr('autocomplete','off');
    if("<?php echo input('review'); ?>"){
        $('.table input,textarea').attr('disabled','on');
    }

     if("<?php echo input('edit'); ?>"){
        $('#sorting_shift').attr('disabled','on');
    }

    //完成当前表单数据并提交
    $('.finish').click(function(){
          var confirm = '';
        $('#sorting input').each(function(){
            if($(this).val() == ''){
                $(this).focus();
                confirm = false;
                d= {"code":0,"msg":"当前数据未填写完成"};
                $(this).parents('tbody').fadeIn();
                $(this).parents('tbody').siblings('tbody').fadeOut();
                _index = $(this).parents('tbody').index();
                $('#round').val(_index-1);
                obalert(d);
                return false;
            }
            confirm = true;
        })
        if(!confirm) return false;
        _id = $('#sorting tr').eq(1).attr('data-id');
        $.post('sorting?action=recordEdit',{sorting_id:_id},function(d){
            obalert(d);
        })
    })

     //审核提交
    $('.review').click(function(){
        _id = "<?php echo input('review'); ?>";
        _note = $('input[name="review_note"]').val();
        $(this).attr('disabled','on');
        $.post('recordEdit.html',{id:_id,review_note:_note},function(d){
            obalert(d);
            $(this).attr('disabled','off');

        })
    })


    //更换班次
    $('table tbody').eq('0').siblings('tbody').css('display','none');

    $("#round").change(function(){
        _index = $(this).val();
        $('table tbody').eq(_index).siblings('tbody').css('display','none');
        $('table tbody').eq(_index).fadeIn(100);
    })


    var mydate = new Date();
    h = mydate.getHours()<10? ('0')+mydate.getHours():mydate.getHours();
    i = mydate.getMinutes()<10?('0')+mydate.getMinutes():mydate.getMinutes();
    _time = h+':'+i;
    $('table').on('click','input[name="inspectioned_at"]',function(){
        $(this).val(_time);
        _id   = $(this).parents('tr').attr('data-id');
        $.post('sorting',{inspectioned_at:_time,id:_id},function(d){
            console.log(d);
        })
    })

    $('table').on('change','input',function(){
        _name = $(this).attr('name');
        _val  = $(this).val();
        _id   = $(this).parents('tr').attr('data-id');
        data  = _name+'='+_val+'&id='+_id;
        $.post('sorting',data,function(e){
            console.log(e);
        })
    })

    $('#sorting_shift').on('change',function(e){
        _val=$(this).val();
         url = window.location.href;
        _index =  url.indexOf('?');
        if(_index > -1){
            url = url.substr(0,_index);
        }
        window.location.href= url+'?shift='+_val;
    })

   
</script>
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