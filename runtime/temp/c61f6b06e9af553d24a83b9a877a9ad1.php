<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\widget\editor\index.html";i:1533112952;}*/ ?>
<link rel="stylesheet" href="__STATIC__/widget/admin/editor/kindeditor/default/default.css" />
<script type="text/javascript">

    $(function(){
        
    var editor_<?php echo $widget_data['name']; ?>;
        editor_<?php echo $widget_data['name']; ?> = KindEditor.create('textarea[name="<?php echo $widget_data['name']; ?>"]', {
                allowFileManager : false,
                themesPath: KindEditor.basePath,
                width: '100%',
                height: '<?php echo $widget_config['editor_height']; ?>',
                resizeType: <?php if($widget_config['editor_resize_type'] == '1'): ?>1 <?php else: ?> 0 <?php endif; ?>,
                pasteType : 2,
                urlType : 'absolute',
                fileManagerJson : '<?php echo url('fileManagerJson'); ?>',
                uploadJson : "<?php echo url('file/editorPictureUpload'); ?>",
                items : [
                'source', 'undo', 'redo', 'cut', 'copy','paste', 'plainpaste', 'wordpaste','selectall',
                'justifyleft','justifycenter','justifyright','justifyfull','insertorderedlist','indent',
                'outdent','subscript','superscript','fontname','fontsize','forecolor','hilitecolor','bold',
                'italic','underline','strikethrough','removeformat','image','table',
                'link','unlink','fullscreen'
                ],
                extraFileUploadParams: { session_id : '<?php echo session_id(); ?>'}
            });
        
        //ajax提交之前同步
        $('button[type="submit"],#submit,.ajax-post,#autoSave').click(function(){
                editor_<?php echo $widget_data['name']; ?>.sync();
        });
    });
</script>
