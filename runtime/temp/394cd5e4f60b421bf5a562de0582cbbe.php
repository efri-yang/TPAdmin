<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:100:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\public/../application/admin\view\admin_user\edit.html";i:1528332540;s:81:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\layout.html";i:1528332540;s:88:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\header.html";i:1528332540;s:90:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\sideMenu.html";i:1528332540;s:92:"E:\Xampp\htdocs\MyProject\src\MyPhpCms\TPAdmin\application\admin\view\common\breadcrumb.html";i:1528332540;}*/ ?>
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
    <div class="pl30 pr30 mt20">
        <div class="am-form am-form-horizontal mt20 pr30">
            <form action="<?php echo url('edit',['id'=>$id]); ?>" method="post" data-am-validator>
                <div class="am-form-group">
                    <label class="am-para-label">角色：</label>
                    <div class="am-para-input lh-default">
                    	<?php if(is_array($groupList) || $groupList instanceof \think\Collection || $groupList instanceof \think\Paginator): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	                	<label class="pr15"><input type="checkbox" name="group_id[]" <?php echo !empty($vo['checked'])?"checked" :""; ?> value="<?php echo $vo['id']; ?>" required><?php echo $vo['title']; ?></label>
                		<?php endforeach; endif; else: echo "" ;endif; ?>
                        
                    </div>
                </div>
                <div class="am-form-group">
                    <label class="am-para-label">用户名：</label>
                    <div class="am-para-input">
                        <input type="text" name="username" value="<?php echo (\think\Session::get('form_info.username') ?: ''); ?>" required minlength="2" placeholder="输入用户名(至少2个字符)" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label class="am-para-label">密码：</label>
                    <div class="am-para-input">
                        <input type="password" name="password" value="<?php echo (\think\Session::get('form_info.password') ?: ''); ?>" required minlength="6" id="J_password" placeholder="输入密码(至少6个字符)" />
                    </div>
                </div>
                
                <div class="am-form-group">
                    <label class="am-para-label">邮箱：</label>
                    <div class="am-para-input">
                        <input type="text" name="email" value="<?php echo (\think\Session::get('form_info.email') ?: ''); ?>" required pattern="^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label class="am-para-label">电话：</label>
                    <div class="am-para-input">
                        <input type="text" name="phone" value="<?php echo (\think\Session::get('form_info.phone') ?: ''); ?>" required pattern="^1[3|4|5|8][0-9]\d{4,8}$" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label class="am-para-label">是否禁用：</label>
                    <div class="am-para-input">
                        <label class="am-radio-inline"><input type="radio" value="1" name="status"  <?php echo \think\Session::get('form_info.status')==1?"checked" :""; ?> /> 否</label>
                        <label class="am-radio-inline"><input type="radio" value="0" name="status" <?php echo \think\Session::get('form_info.status')==0?"checked" :""; ?>> 是</label>
                    </div>
                </div>
                <div class="am-form-group">
                    <label class="am-para-label"></label>
                    <div class="am-para-input">
                        <input type="submit" class="am-btn am-btn-lg am-btn-primary" value="提交" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</body>

</html>