<div class="box">
    <div class="box-header">

        <ob_link><a class="btn" href="{:url('{$name}Add')}"><i class="fa fa-plus"></i> 新 增</a></ob_link>

        <div class="box-tools">
            <div class="input-group input-group-sm search-form">
                <input name="search_data" class="pull-right search-input" value="{:input('search_data')}" placeholder="支持名称" type="text">
                <div class="input-group-btn">
                    <button type="button" id="search" url="{:url('{$name}List')}" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="box-body table-responsive">
        <table  class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>名称</th>
                <th>创建时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>

            {notempty name='list'}
                <tbody>
                {volist name='list' id='vo'}
                    <tr>
                        <td>{$vo.name}</td>
                        <td>{$vo.create_time}</td>
                        <td><ob_link><a class="ajax-get" href="{:url('setStatus', array('ids' => $vo['id'], 'status' => (int)!$vo['status']))}">{$vo.status_text}</a></ob_link></td>
                        <td class="col-md-2 text-center">
                            <ob_link><a href="{:url('{$name}Edit', array('id' => $vo['id']))}" class="btn"><i class="fa fa-edit"></i> 编 辑</a></ob_link>
                            &nbsp;
                            <ob_link><a class="btn confirm ajax-get"  href="{:url('{$name}Del', array('id' => $vo['id']))}"><i class="fa fa-trash-o"></i> 删 除</a></ob_link>
                        </td>
                    </tr>
                {/volist}
                </tbody>
            {else/}
                <tbody><tr class="odd"><td colspan="7" class="text-center" valign="top">{:config('empty_list_describe')}</td></tr></tbody>
            {/notempty}
        </table>
    </div>

    <div class="box-footer clearfix text-center">
        {$list->render()}
    </div>

</div>