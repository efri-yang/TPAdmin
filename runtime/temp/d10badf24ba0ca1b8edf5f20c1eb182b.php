<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:101:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\public/../application/admin\view\admin_menu\index.html";i:1528332540;s:81:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\layout.html";i:1528332540;s:88:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\header.html";i:1528332540;s:90:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\sideMenu.html";i:1528332540;s:92:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\breadcrumb.html";i:1528332540;}*/ ?>
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
    <style type="text/css">
    .coms-table-bd td i.iconfont {
        margin-right: 5px;
        display: inline-block;
        vertical-align: middle;
        font-size: 18px;
        color: #666;
    }
    </style>
    <div class="coms-table-wrap  pl30 pr30 mb30">
        <!--  no-border  去掉头部就有边控了-->
        <div class="clearfix mb15">
            <a href="<?php echo url('add'); ?>" class="am-btn am-btn-success fr">添加菜单</a>
        </div>
        <div class="coms-table-bd">
            <table class="am-table am-table-bordered">
                <thead>
                    <tr>
                        <!-- th 中 复选框的宽度 写死 固定50  然后其他的用百分比，但是必须有一个是不要设置值得(这样可以自适应省去计算麻烦) -->
                        <th width="5%"><span>ID</span></th>
                        <th width="15%" class="align-l"><span>菜单名称</span></th>
                        <th width="15%" class="align-l"><span>URL</span></th>
                        <th width="8%"><span>父ID</span></th>
                        <th width="10%"><span>图标</span></th>
                        <th width="5%"><span>排序</span></th>
                        <th width="5%"><span>状态</span></th>
                        <th width="7%"><span>日志记录方式</span></th>
                        <th width="15%"><span>操作</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $menuadmin; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $(".coms-table-bd td .am-btn-danger").on("click", function(event) {
        event.preventDefault();
        var $this = $(this);
        var layerIndex;
        var href = $this.attr("href");
        var tipTxt;
        if ($this.data("roler") == "single") {
            tipTxt = "您确定删除该菜单项？";
        } else {
            tipTxt = "删除该菜单项,其包含的子菜单也将被删除！"
        }
        layerIndex=layer.confirm(tipTxt, {
            btn: ['取消', '确认'] //按钮
        }, function() {
            layer.close(layerIndex);
        }, function() {
            window.location.href = href;
        });

        
    })
})
</script>
<script type="text/javascript">
$(function() {
    var $checkboxAll = $('input[name="tblCheckAll"]');
    var $checkboxSingle = $('input[name="menus[]"]');
    var len = $checkboxSingle.length;
    var count = 0;

    $checkboxAll.on("click", function() {
        var $this = $(this);
        var isChecked = $this.prop("checked");

        $checkboxSingle.prop({
            checked: isChecked
        });
        $checkboxAll.prop("checked", isChecked);
        count = len;
    });
    $.each($checkboxSingle, function(index, el) {
        $(el).on("change", function() {
            var $this = $(this);
            var isChecked = $this.prop("checked");
            if (!isChecked) {
                $checkboxAll.prop("checked", isChecked);
                count--;
            } else {
                count++;
                if (count == len) {
                    $checkboxAll.prop("checked", true);
                }
            }
        })
    });
})
</script>
        </div>
    </div>
</body>

</html>