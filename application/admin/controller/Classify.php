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
        $params = $this->request->param();
        $id = @$params["id"] ? $params["id"] : "";
        $resData = Db::table("think_category")->where("id", "<>", 1)->column("*", "id");
        $tree2 = new Tree2();

        $needData = $tree2::hTree2($resData, 0);

        $classifyTpl = "<option \$selected  value='\$id'>\$space \$name</option>";

        $classifyStr = $tree2->getTree($needData, $classifyTpl, $id, "", 1);

        $this->assign([
            "classifyStr" => $classifyStr,
        ]);
        return $this->fetch();
    }

    public function categorylist() {
        $resData = Db::table("think_category")->where("id", "<>", 1)->select();

        foreach ($resData as $key => $value) {
            $resData[$key]["add"] = '<a href="' . url('add', ["id" => $value["id"]]) . '">添加子分类</a>';
            $resData[$key]["edit"] = '<a href="' . url('edit', ["id" => $value["id"]]) . '">编辑</a>';
            $resData[$key]["del"] = '<a href="' . url('del', ["id" => $value["id"]]) . '">删除</a>';
        }
        $tree2 = new Tree2();
        $realData = $tree2::hTree2($resData);

        $realData = $tree2::sort($realData, "sort_id");
        $classifyTpl = "<tr>";
        $classifyTpl .= "<td>\$sort_id</td>";
        $classifyTpl .= "<td>\$id</td>";
        $classifyTpl .= "<td class='align-l'>\$space \$name</td>";
        $classifyTpl .= "<td>\$description</td>";
        $classifyTpl .= "<td class='hander'>";
        $classifyTpl .= "\$add \$edit \$del";
        $classifyTpl .= "</td>";
        $classifyTpl .= "</tr>";

        $classifyStr = $tree2->getTree($realData, $classifyTpl);
        $this->assign([
            "classifyStr" => $classifyStr,
        ]);
        return $this->fetch();
    }

    public function addpost() {
        $params = $this->request->param();

        $insertData["pid"] = $params["pid"];
        $insertData["name"] = $params["cname"];
        $insertData["description"] = $params["description"];
        $insertData["coverimg"] = $params["coverimg"];
        $insertData["sort_id"] = $params["sort_id"];
        $insertData["seo_title"] = $params["seotitle"];
        $insertData["seo_keyword"] = $params["seokeyword"];
        $insertData["seo_description"] = $params["seodescription"];

        $insertRes = Db::table("think_category")->insert($insertData);

        if ($insertRes) {
            $this->success("添加成功！", "categorylist");
        } else {
            $this->error("添加成功！", "categorylist");
        }
    }

    public function del() {
        //删除分类，要考虑到：
        //那么该分类的文章不应被删除，而是修改为未分类
        //该分类子分类是否要删除
        $params = $this->request->param();
        $id = $params["id"];

        $delRes = Db::table("think_category")->where("id", $id)->delete();
        if ($delRes) {
            $this->success("删除成功");
        }
    }
}
?>