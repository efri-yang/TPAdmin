<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\common\Tree2;
use think\Controller;
use think\Db;
use think\Paginator;
use think\Session;
use think\Validate;

class Classify extends Base {
    public function index() {
        return "sdfasdfsadfasdfasdf阿斯顿发生地方我";
    }

    public function add() {
        //获取所有的分类
        $resData = Db::table("think_category")->column("*", "id");

        $tree2 = new Tree2();

        $needData = $tree2::hTree2($resData, 0);

        $classifyTpl = "<option  value='\$id'>\$name</option>";

        $classifyStr = $tree2->getTree($needData, $classifyTpl);

        $this->assign([
            "classifyStr" => $classifyStr,
        ]);
        return $this->fetch();
    }
}
?>