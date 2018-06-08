<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;

/**
 * Index 和 Base（Index extends Base），都有定义 __construct，那么执行 Index里面的__construct(_initialize 则都没作用)
 * Index没有 __construct  而Base 有，那么就会执行 Base construct 和 Index 的 _initialize
 *
 * 结论 就是： _initialize 其实是在tp 中调用的，只会执行一次，从子元素向下搜索，找打第一个执行
 */
class Logs extends Base {

    public function handler() {

        return $this->fetch();
    }
    public function sys() {

        echo "Logs-sys";
    }
}
?>