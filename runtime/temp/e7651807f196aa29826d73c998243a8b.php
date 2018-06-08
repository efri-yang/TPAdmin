<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:100:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\public/../application/admin\view\admin_menu\edit.html";i:1528332540;s:81:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\layout.html";i:1528332540;s:88:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\header.html";i:1528332540;s:90:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\sideMenu.html";i:1528332540;s:92:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\breadcrumb.html";i:1528332540;}*/ ?>
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
	<div class="am-form am-form-horizontal">
		<form data-am-validator  method="post" action="<?php echo url('edit',['id'=>\think\Session::get('form_info.menu_id')]); ?>">
			<div class="am-form-group">
				<label class="am-para-label">上级菜单：</label>
				<div class="am-para-input">
					<select name="parent_id">
						<?php echo $optionList; ?>
					</select>
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label">菜单名称：</label>
				<div class="am-para-input">
					<input type="text" required name="title" value="<?php echo (\think\Session::get('form_info.title') ?: ''); ?>" />
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label">URL：</label>
				<div class="am-para-input">
					<input type="text" required name="url"  pattern="^[0-9a-zA-Z//]+$" value="<?php echo (\think\Session::get('form_info.url') ?: ''); ?>"/>
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label">菜单图标：</label>
				<div class="am-para-input">
					<input type="text" required name="icon" value="<?php echo (\think\Session::get('form_info.icon') ?: ''); ?>" />
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label">排序：</label>
				<div class="am-para-input">
					<input type="text"  value="<?php echo (\think\Session::get('form_info.sort_id') ?: '1'); ?>" name="sort_id" />
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label">是否显示：</label>
				<div class="am-para-input">
					<label class="am-radio-inline">
						<input type="radio" name="is_show" value="1" <?php echo \think\Session::get('form_info.is_show')==1?"checked" :""; ?>>是</label>

					<label class="am-radio-inline"><input <?php echo \think\Session::get('form_info.is_show')==0?"checked" :""; ?>  type="radio" name="is_show" value="0">否</label>
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label">日志记录：</label>
				<div class="am-para-input">
					<select name="log_type">
						<option value="0">不记录日志</option>
						<option value="1">GET</option>
						<option value="2">POST</option>
						<option value="3">PUT</option>
						<option value="4">DELETE</option>
					</select>
				</div>
			</div>

			<div class="am-form-group">
				<label class="am-para-label"></label>
				<div class="am-para-input">
					<input type="submit" class="am-btn am-btn-primary">
					<input type="reset" class="am-btn am-btn-default">
				</div>
			</div>
		</form>
	</div>
</div>
        </div>
    </div>
</body>

</html>