<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\widget\file\img.html";i:1533112952;}*/ ?>
<link rel="stylesheet" href="__STATIC__/widget/admin/file/Huploadify.css">

<div id="upload_picture_<?php echo $widget_data['name']; ?>"></div>

<input type="hidden" name="<?php echo $widget_data['name']; ?>" id="<?php echo $widget_data['name']; ?>" value="<?php echo $widget_data['value']; ?>"/>

<div class="upload-img-box<?php echo $widget_data['name']; ?>">
    <?php if(!(empty($info[$widget_data['name']]) || (($info[$widget_data['name']] instanceof \think\Collection || $info[$widget_data['name']] instanceof \think\Paginator ) && $info[$widget_data['name']]->isEmpty()))): ?>
    <div class="upload-pre-item">
        
        <div style="cursor:pointer;" class="pic_del"  onclick="picDel<?php echo $widget_data['name']; ?>(this)" ><img src="__STATIC__/widget/admin/file/uploadify-cancel.png" /></div> 
        
        <a target="_blank"
                                    href="<?php echo get_picture_url((isset($info[$widget_data['name']]) && ($info[$widget_data['name']] !== '')?$info[$widget_data['name']]:'0')); ?>"><img
            style="max-width: <?php echo $widget_config['maxwidth']; ?>;"
            src="<?php echo get_picture_url((isset($info[$widget_data['name']]) && ($info[$widget_data['name']] !== '')?$info[$widget_data['name']]:'0')); ?>"/></a></div>
    <?php endif; ?>
</div>

<script type="text/javascript">

    var maxwidth = "<?php echo $widget_config['maxwidth']; ?>";

    $("#upload_picture_<?php echo $widget_data['name']; ?>").Huploadify({
        auto: true,
        height: 30,
        fileObjName: "file",
        buttonText: "上传图片",
        uploader: "<?php echo url('File/pictureUpload',array('session_id'=>session_id())); ?>",
        width: 120,
        removeTimeout: 1,
        fileSizeLimit:"<?php echo $widget_config['max_size']; ?>",
        fileTypeExts: "<?php echo $widget_config['allow_postfix']; ?>",
        onUploadComplete: uploadPicture<?php echo $widget_data['name']; ?>
    });

    function uploadPicture<?php echo $widget_data['name']; ?>(file, data)
    {

        var data = $.parseJSON(data);

        $("#<?php echo $widget_data['name']; ?>").val(data.id);

        var src = !data['url'] ? "__ROOT__/upload/picture/" + data.path : data.url;

        $(".upload-img-box<?php echo $widget_data['name']; ?>").html('<div class="upload-pre-item">    <div style="cursor:pointer;" class="pic_del"  onclick="picDel<?php echo $widget_data['name']; ?>(this)" ><img src="__STATIC__/widget/admin/file/uploadify-cancel.png" /></div>        <a target="_blank" href="' + src + '"> <img style="max-width: ' + maxwidth + ';" src="' + src + '"/></a></div>');
    }
    
    function picDel<?php echo $widget_data['name']; ?>(obj)
    {
        
        var widget_name = "<?php echo $widget_data['name']; ?>";
        
        $("#" + widget_name).val(0);
        
        $(obj).parent().remove();
    }
</script>