<?php
namespace app\admin\controller;
use app\admin\common\Tree2;
use think\Controller;
use think\Db;

class Test extends Controller {
    public function index() {
        $arr = array(
            array('id' => 1, 'pid' => 0, 'name' => '福建省', 'sort' => 100),
            array('id' =>5, 'pid' => 1, 'name' => '漳州市', 'sort' => 60),
            array('id' =>2, 'pid' => 1, 'name' => '福州市', 'sort' => 90),
            array('id' =>3, 'pid' => 1, 'name' => '泉州市', 'sort' => 80),
            array('id' =>4, 'pid' => 1, 'name' => '厦门市', 'sort' => 70),

            array('id' =>7, 'pid' => 5, 'name' => '龙文', 'sort' => 90),
            array('id' =>8, 'pid' => 5, 'name' => '漳浦县', 'sort' => 80),
            array('id' =>9, 'pid' => 5, 'name' => '南靖县', 'sort' => 70),
            array('id' =>6, 'pid' => 5, 'name' => '龙海', 'sort' => 100)


        );


        $arr3=Tree2::hTree($arr);

        $arr2 = Tree2::sort($arr3, 'sort');

        print_r($arr2);

    }
}
?>