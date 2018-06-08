<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:95:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\public/../application/admin\view\role\index.html";i:1528332540;s:81:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\layout.html";i:1528332540;s:88:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\header.html";i:1528332540;s:90:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\sideMenu.html";i:1528332540;s:92:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\breadcrumb.html";i:1528332540;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $webData["webtitle"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" type="text/css" href="/MyProject/src/MyPhpCms/TPAdmin/public/static/css/iconfont/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/MyProject/src/MyPhpCms/TPAdmin/public/static/AmazeUI/assets/css/amazeui.css">
    <link rel="stylesheet" type="text/css" href="/MyProject/src/MyPhpCms/TPAdmin/public/static/css/common.css">
    <script type="text/javascript" src="/MyProject/src/MyPhpCms/TPAdmin/public/static/js/common/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/MyProject/src/MyPhpCms/TPAdmin/public/static/AmazeUI/assets/js/amazeui.js"></script>
    <script type="text/javascript" src="/MyProject/src/MyPhpCms/TPAdmin/public/static/js/plugin/layer/layer.js"></script>
    <script type="text/javascript" src="/MyProject/src/MyPhpCms/TPAdmin/public/static/js/plugin/jquery.ba-throttle-debounce.min.js"></script>
    <script type="text/javascript" src="/MyProject/src/MyPhpCms/TPAdmin/public/static/js/common.js"></script>
</head>

<body>
    <div class="coms-layout-container theme-default">
        <!-- 头部  start****************************************************** -->
<div class="coms-layout-header">
    <a href="#" class="logo">小鱼生活消费大平台</a>
    <div class="header-userinfo">
        <a class="info-name" href="javascript:;"><?php echo $webData["userinfo"]['username']; ?><span class="arrow"></span></a>
        <ul class="dropdown-list">
            <li><a href="<?php echo url('admin/admin_user/profile'); ?>">修改资料</a></li>
            <li><a href="<?php echo url('login/loginout'); ?>">退出</a></li>
        </ul>
    </div>
</div>
<!-- 头部  end****************************************************** -->
        <!--  -->
        <!-- side  start****************************************************** -->
<div class="coms-layout-aside">
    <div class="aside-unfold"><i class="iconfont f18">&#xe6d4;</i></div>
    <div class="aside-menu-scroll">
        <ul class="aside-menu">
            <?php echo $webData["sidemenu"]; ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
(function($) {
    $(function() {
        var $a = $(".aside-menu").find('.treeview').children('a');
        var $parent;
        var $aside = $(".coms-layout-aside");
        var $body = $("#J_coms-layout-body");
        $.each($a, function(index, el) {
            $(el).on("click", function() {
                var $this = $(this);
                $parent = $this.parent("li");
                if ($parent.hasClass('hactive')) {
                    $parent.removeClass('hactive');
                } else {
                    $parent.addClass('hactive');
                }
            })
        });
        $(".aside-unfold").on("click", function() {
            if ($aside.hasClass('fold')) {
                $aside.removeClass('fold');
                $body.removeClass('unfold');
            } else {
                $aside.addClass('fold');
                $body.addClass('unfold');
                $aside.find(".treeview").removeClass('hactive');
            }
        })
    })
})(jQuery)
</script>
<!-- side  end****************************************************** -->
        <div class="coms-layout-body" id="J_coms-layout-body">
            <div class="p15">
    <div class="coms-elem-quote am-cf">
    <span class="fl f16"><?php echo $webData["webtitle"]; ?></span>
    <ol class="am-breadcrumb fr p0 m0">
        <?php echo $webData["crumb"]; ?>
    </ol>
</div>
    <div class="coms-table-wrap">
        <div class="coms-table-hd clearfix no-border">
            <a href="<?php echo url('add'); ?>" class="am-btn am-btn-success w100 fr">添加角色</a>
        </div>
    </div>
    <div class="coms-table-bd mt20">
        <table class="am-table am-table-bordered">
            <thead>
                <tr>
                    <th width="8%"><span>ID</span></th>
                    <th width="27%"><span>角色名</span></th>
                    <th width="20%"><span>描述</span></th>
                    <th width="10%"><span>状态</span></th>
                    <th><span>操作</span></th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($rolelist) || $rolelist instanceof \think\Collection || $rolelist instanceof \think\Paginator): $i = 0; $__LIST__ = $rolelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $vo['title']; ?></td>
                    <td><?php echo $vo['description']; ?></td>
                    <td>
                        <?php if($vo['status'] == '1'): ?> 正常 <?php else: ?> 禁用 <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo url('admin/role/access',array('id'=>$vo['id'])); ?>" class="am-btn am-btn-xs am-btn-success">授权</a>
                        <a href="<?php echo url('admin/role/del',array('id'=>$vo['id'])); ?>" class="am-btn am-btn-xs am-btn-danger">删除</a>
                        <a href="<?php echo url('admin/role/edit',array('id'=>$vo['id'])); ?>" class="am-btn am-btn-xs am-btn-default">编辑</a>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <?php echo $page; ?>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $(".coms-table-bd .am-btn-danger").on("click", function(event) {
        event.preventDefault();
        var $this = $(this);
        var layerIndex;
        var href = $this.attr("href");
        
        layerIndex = layer.confirm('您确定删除', {
            btn: ['取消', '确认'] //按钮
        }, function() {
            layer.close(layerIndex);
        }, function() {
            window.location.href = href;
        });

    })
})
</script>
        </div>
    </div>
</body>

</html>