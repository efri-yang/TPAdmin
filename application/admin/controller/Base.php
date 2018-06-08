<?php
namespace app\admin\Controller;
//很多页面需要继承Base.php
//判断是否登录
//是否是超级管理员
//判断权限
use app\admin\common\Auth;
use app\admin\common\Tree;
use app\admin\model\AuthUser;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use think\Session;

class Base extends Controller {
    protected $request, $param, $post, $get, $module, $controller, $action, $urlMCA, $urlMC, $webData, $sideMenuList, $menuList, $parentIds, $auth;
    public function __construct() {

        $this->request = Request::instance();
        //请求参数
        $this->param = $this->request->param();
        $this->post = $this->request->post();
        $this->get = $this->request->get();
        $this->module = $this->request->module();
        $this->controller = $this->request->controller();
        $this->action = $this->request->action();

        $this->urlMCA = $this->module . "/" . Loader::parseName($this->controller) . "/" . $this->action;

        $this->urlMC = $this->module . "/" . Loader::parseName($this->controller) . "/";

        parent::__construct();

    }
    public function _initialize() {

        $auth = new Auth();
        $this->auth = $auth;
        $tree = new Tree();
        if ($auth->isLogin()) {
            $uid = Session::get('user.user_id');
            if ($uid != 1) {
                //不是超级管理员，需要检查权限，url(处理 模块+控制器+方法+参数的处理)
                if (!$auth->check($this->urlMCA, $uid)) {
                    //提示错误的信息，并叫他联系管路员
                    $this->error("用户权限不存在！", "login/index");
                }
            }
            //获取用户的信息
            $this->webData["userinfo"] = $this->getUserInfo($uid);

            //获取当前url对应的menu的信息数组
            $currentMenuInfo = $this->getCurrentMenuInfo();

            //当前url的menu_id(来判断左侧菜单栏显示哪个项)
            $currentMenuId = $currentMenuInfo['menu_id'];
            $this->menuList = Db::table("think_admin_menus")->where('status', 1)->select();

            //获取侧边栏目录结构数据
            $this->sideMenuList = $auth->getMenuList($uid, 1);

            //获取当前url 的parent_id(这个parentid 的集合 是针对左侧栏)

            $this->parentIds = $this->getParentId($currentMenuId, $this->menuList);

            //获取当前的title
            $this->webData["webtitle"] = $currentMenuInfo["title"];

            //获取左侧菜单的信息
            $this->webData["sidemenu"] = $tree->getSideMenu(0, $currentMenuId, $this->parentIds, $this->sideMenuList);

            //获取面包导航屑
            $this->webData["crumb"] = $this->getBreadcrumb($currentMenuId, $this->menuList);

        } else {
            //没登录跳转到登录页面，跟上url
            $this->redirect("login/login", ['uri' => $this->urlMCA]);

        }
    }

    protected function getUserInfo($uid) {
        $userInfo = AuthUser::get($uid);
        return $userInfo;
    }

    public function getBreadcrumb($currentNavId, $menuList, $navStr = "") {
        if (is_array($menuList)) {
            foreach ($menuList as $key => $value) {
                if ($value['menu_id'] == $currentNavId) {
                    if (!$navStr) {
                        $bread = '<li class="am-active">' . $value["title"] . '</li>';
                    } else {
                        if (!!$value["url"]) {
                            $bread = '<li><a href="' . url($value["url"]) . '">' . $value["title"] . '</a></li>';
                        } else {
                            $bread = '<li>' . $value["title"] . '</li>';
                        }

                    }
                    $navStr = $bread . $navStr;
                    $navStr = $this->getBreadcrumb($value["parent_id"], $menuList, $navStr);

                }

            }
        }
        return $navStr;
    }

    public function getParentId($id, $data, $parentIds = array()) {
        foreach ($data as $key => $value) {
            if ($value["menu_id"] == $id) {
                $parentIds[] = $value["parent_id"];
                $parentIds = $this->getParentId($value["parent_id"], $data, $parentIds);
            }
        }
        return $parentIds;
    }

    protected function fetch($template = '', $vars = [], $replace = [], $config = []) {
        parent::assign(['webData' => $this->webData]);
        return $this->view->fetch($template, $vars, $replace, $config);
    }

    protected function getCurrentMenuInfo() {
        return Db::name('admin_menus')->where(['url' => $this->urlMCA])->find();
    }
}

?>