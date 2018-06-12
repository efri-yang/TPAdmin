<?php
namespace app\admin\controller;
use app\admin\common\Tree2;
use think\Controller;
use think\Db;

class Test extends Controller {
    public function index() {
        $data = Db::table("think_admin_menus")->order(["sort_id" => "desc", 'menu_id' => 'asc'])->column('*', 'menu_id');

        $data = Tree2::hTree($data, 0);

        $strTpl = "";
        $strTpl .= "<tr class='\$selected'>";
        $strTpl .= "<td>\$menu_id</td>";
        $strTpl .= "<td>\$space\$title</td>";
        $strTpl .= "<td>\$url</td>";
        $strTpl .= "<td></td>";
        $strTpl .= "<td><i class='iconfont \$icon'></i>\$icon</td>";
        $strTpl .= "<td>\$status</td>";
        $strTpl .= "<td>\$log_type</td>";
        $strTpl .= "<td><a href='#' class='am-btn am-btn-danger am-btn-xs mr5'>删除</a><a href='#' class='am-btn am-btn-danger am-btn-xs mr5'>修改</a></td>";
        $strTpl .= "</tr>";

        $tree = new Tree2();
        $str = $tree->getTree($data, $strTpl);
        // $this->assign("str", $str);

        $strSelectTpl = "";
        $strSelectTpl .= "<option \$selected value='\$menu_id'>\$space\$title</option>";

        $strSelect = $tree->getTree($data, $strSelectTpl, 11);

        // $this->assign("strSelect",$strSelect);

        $this->assign([
            "str" => $str,
            "strSelect" => $strSelect,
        ]);

        return $this->fetch("index");

    }
}
?>