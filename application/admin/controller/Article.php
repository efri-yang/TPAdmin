<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use think\Controller;
use think\Db;
use think\Session;
use app\admin\common\Tree2;

/**
 * Index 和 Base（Index extends Base），都有定义 __construct，那么执行 Index里面的__construct(_initialize 则都没作用)
 * Index没有 __construct  而Base 有，那么就会执行 Base construct 和 Index 的 _initialize
 *
 * 结论 就是： _initialize 其实是在tp 中调用的，只会执行一次，从子元素向下搜索，找打第一个执行
 */
class Article extends Base {

    public function index() {
        return $this->fetch();
    }

    public function add() {
        echo $this->webData["menu_id"];
        $tree2=new Tree2();
        $tplFenLei='<option value="\menu_id">\title</option>';
        return $this->fetch();
    }
     public function addDo() {
        return $this->fetch();
    }

    public function articlelist() {
      return $this->fetch();
    }
    public function tagList() {
        $resData = Db::table("think_tag")->field('id,name')->select();
        return $resData;
    }
}
?>