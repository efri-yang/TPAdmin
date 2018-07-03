<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\common\Tree;
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
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;';
        $resData = Db::table("think_category")->where("id", "<>", 1)->column("*", "id");

        $tree->init($resData);
        $params = $this->request->param();
        if ($this->request->isPost()) {
            //添加分类
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
                $this->error("添加失败！", "categorylist");
            }

        } else {
            $sid = @$params["id"] ? @$params["id"] : "";
            $pSelTpl = "<option  \$selected value='\$id'>\$spacer\$name</option>";
            $pSelTplGroup = "<option \$selected  value='\$id'>&nbsp;&nbsp;├─ \$name</option>";
            $pSelStr = $tree->getTree(0, $pSelTpl, $sid, "", $pSelTplGroup);
            $pSelStr = "<option  value='0'>一级分类</option>" . $pSelStr;
            $this->assign([
                "classifyStr" => $pSelStr,
            ]);
            return $this->fetch();
        }

        //未分类是不可能有子分类的，所以要筛选数据的时候

        //如果没有选中任何的分类，证明这个分类的属于一级分类下，所以不需要任何处理了

    }

    public function categorylist() {
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $resData = Db::table("think_category")->order(["sort_id" => "desc", 'id' => 'asc'])->column("*", "id");
        foreach ($resData as $key => $value) {
            //未分类这个项不能删除和编辑的
            if ($key == 1) {
                $resData[$key]["add"] = false;
                $resData[$key]["edit"] = $resData[$key]["edit"] = '<a href="' . url('edit', ["id" => $value["id"]]) . '">编辑</a>';
                $resData[$key]["del"] = false;
            } else {
                $resData[$key]["add"] = '<a href="' . url('add', ["id" => $value["id"]]) . '">添加子分类</a>';
                $resData[$key]["edit"] = '<a href="' . url('edit', ["id" => $value["id"]]) . '">编辑</a>';
                $resData[$key]["del"] = '<a href="' . url('del', ["id" => $value["id"]]) . '">删除</a>';
            }
        }

        $tree->init($resData);

        $classifyTpl = "<tr>";
        $classifyTpl .= "<td>\$sort_id</td>";
        $classifyTpl .= "<td>\$id</td>";
        $classifyTpl .= "<td class='align-l'>\$spacer \$name</td>";
        $classifyTpl .= "<td>\$description</td>";
        $classifyTpl .= "<td class='hander'>";
        $classifyTpl .= "\$add \$edit \$del";
        $classifyTpl .= "</td>";
        $classifyTpl .= "</tr>";

        $classifyStr = $tree->getTree(0, $classifyTpl, "");

        $this->assign([
            "classifyStr" => $classifyStr,
        ]);

        return $this->fetch();
    }

    public function edit() {
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;';

        $params = $this->request->param();
        $id = $params["id"];

        if ($this->request->isPost()) {
            $data["pid"] = $params["pid"];
            $data["name"] = $params["name"];
            $data["coverimg"] = $params["coverimg"];
            $data["description"] = $params["description"];
            $data["sort_id"] = $params["sort_id"];
            $data["seo_title"] = $params["seotitle"];
            $data["seo_keyword"] = $params["seokeyword"];
            $data["seo_description"] = $params["seodescription"];

            $resUpdate = Db::table("think_category")->where("id", $id)->update($data);
            if ($resUpdate !== false) {
                $this->success("修改成功！", "categorylist");
            } else {
                $this->success("修改失败！", "categorylist");
            }
        } else {
            $classifyData = Db::table("think_category")->where("id", "<>", 1)->column("*", "id");
            $tree->init($classifyData);
            $data = Db::table("think_category")->where("id", $id)->find();

            $pSelTpl = "<option  \$selected value='\$id'>\$spacer\$name</option>";
            $pSelTplGroup = "<option \$selected value='\$id'>&nbsp;&nbsp;├─ \$name</option>";

            //未分类是不可能有子分类的，所以要筛选数据的时候

            $pSelStr = $tree->getTree(0, $pSelTpl, $data["pid"], "", $pSelTplGroup);
            //如果没有选中任何的分类，证明这个分类的属于一级分类下，所以不需要任何处理了
            $pSelStr = "<option  value='0'>一级分类</option>" . $pSelStr;
            $this->assign([
                "classifyStr" => $pSelStr,
                "data" => $data,
            ]);
            return $this->fetch();

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

    public function fileImgDel() {
        $param = $this->request->param();
        $old = $param["filename"];

        if (@unlink($_SERVER['DOCUMENT_ROOT'] . $param["filename"])) {
            Db::table("think_category")->where("id", $param["id"])->update(["coverimg" => ""]);
            echo 1;
        } else {
            echo 0;
        }
    }

}
?>