<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\common\Tree;
use think\Controller;
use think\Db;
use think\Paginator;
use think\Session;
use think\Validate;

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
        //这个是有问题的，假设有子集的时候

        //如果是提交表单的时候 这个时候要根据事务 把文章和标签对应放到tagmap
        if ($this->request->isPost()) {
            //对于文章的标签，那么插入的时候就要
            $params = $this->request->param();
            $result = $this->validate($params, 'ArticleAdd');
            $flag = true;
            date_default_timezone_set('PRC');
            if (true !== $result) {
                Session::set('form_info', $params);
                $this->error($result, "add");
            } else {
                //验证通过以后就插入到数据库中

                $insertData = [
                    'classifyid' => $params["classifyid"],
                    'title' => $params["title"],
                    'keyword' => $params["keyword"],
                    'description' => $params["description"],
                    'coverimg' => $params['coverimg'],
                    'content' => addslashes($params['content']),
                    'author' => $params["author"],
                    'tags' => $params["tags"],
                    'tagid' => $params["tagid"],
                    'iscomment' => $params["iscomment"],
                    'create_time' => time(),
                ];

                $insertResult = Db::table('think_article')->insertGetId($insertData);

                if ($insertResult) {

                    if ($params["tagid"]) {
                        $tagIdArray = explode(",", $params["tagid"]);
                        $tagData = Db::table("think_tag")->where("id", "in", $tagIdArray)->select();
                        foreach ($tagIdArray as $key => $value) {
                            $insertTagMap[$key]["tagid"] = $value;
                            $insertTagMap[$key]["aid"] = $insertResult;
                            Db::table("think_tag")->where("id", $tagData[$key]["id"])->update(["num" => $tagData[$key]["num"] + 1]);
                        }
                        $insertMapResult = Db::table('think_tagmap')->insertAll($insertTagMap);

                        if (!$insertMapResult) {
                            $flag = false;
                        }
                    }

                } else {
                    $flag = false;
                }

                if ($flag) {
                    Session::set('form_info', '');
                    $this->success("添加成功！", "articlelist");
                } else {
                    Session::set('form_info', $params);
                    $this->error("添加失败！", "add");
                }

            }

        } else {
            $resData = Db::table("think_category")->column("*", "id");
            $tree = new Tree();
            $tree->icon = ['&nbsp;&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;';
            $tree->init($resData);

            $pSelTpl = "<option  \$selected value='\$id'>\$spacer\$name</option>";

            $tplStr = $tree->getTree(0, $pSelTpl, "");

            $this->assign([
                "selOption" => $tplStr,
            ]);
            return $this->fetch();
        }

    }

    public function articlelist() {

        // $list = Db::table('think_article')->paginate(10);
        $list = Db::view("think_article", "*")->view('think_category', 'name as cname', 'think_article.classifyid=think_category.id')->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);

        $this->assign('page', $page);
        return $this->fetch();
    }
    public function tagList() {

        $resData = Db::table("think_tag")->field('id,name')->select();
        $aid = $this->request->param("aid");

        if ($aid) {
            //取得当前文章对应的分类id
            $atagId = Db::table("think_tagmap")->field('group_concat(tagid) as tagid')->where("aid", $aid)->group("aid")->select();

            if ($atagId) {
                $tagIdArr = explode(",", $atagId[0]["tagid"]);

                foreach ($resData as $key => $value) {
                    if (in_array($value["id"], $tagIdArr)) {

                        $resData[$key]["selected"] = 1;
                    }
                }
            }

        }

        return $resData;
    }

    public function del() {
        //删除文章记得删除对应标签中的数量，设计三个表article tagmap tag,
        //所以要启动事务
        $params = $this->request->param();
        if (!!$params["id"]) {
            $res = Db::table("think_article")->delete($params["id"]);
            if ($res) {
                $this->success("删除成功！", "articlelist");
            } else {
                $this->error("删除失败！", "articlelist");
            }
        } else {
            $this->error("删除失败！", "articlelist");
        }

    }
    public function edit() {
        $params = $this->request->param();

        if ($this->request->isPost()) {
            //涉及tagmap category article 表 所以启动事务
            date_default_timezone_set('PRC');
            //获取原来的tagId
            $oldTagId = Db::table("think_article")->where('id', $params["id"])->value("tagid");
            if ($oldTagId) {
                $oldTagIdArr = explode(",", $oldTagId);
            } else {
                $oldTagIdArr = [];
            }

            Db::startTrans();

            try {
                //更新article中的表
                Db::table("think_article")->where('id', $params["id"])->update([
                    'classifyid' => $params["classifyid"],
                    'title' => $params["title"],
                    'keyword' => $params["keyword"],
                    'description' => $params["description"],
                    'coverimg' => $params['coverimg'],
                    'content' => addslashes($params['content']),
                    'author' => $params["author"],
                    'tags' => $params["tags"],
                    'tagid' => $params["tagid"],
                    'iscomment' => $params["iscomment"],
                    'update_time' => time(),
                ]);
                Db::table("think_tagmap")->where("aid", $params["id"])->delete();
                if ($params["tagid"]) {
                    $newTagIdArray = explode(",", $params["tagid"]);
                    foreach ($newTagIdArray as $key => $value) {
                        $insertTagMap[$key]["tagid"] = $value;
                        $insertTagMap[$key]["aid"] = $params["id"];
                    }
                    Db::table('think_tagmap')->insertAll($insertTagMap);
                    $tagAllData = Db::table("think_tag")->select();
                    foreach ($tagAllData as $k => $v) {

                        if (!in_array($v["id"], $oldTagIdArr) && in_array($v["id"], $newTagIdArray)) {
                            Db::table("think_tag")->where("id", $v["id"])->update(["num" => ($v["num"] + 1)]);

                        }
                        if (in_array($v["id"], $oldTagIdArr) && !in_array($v["id"], $newTagIdArray)) {
                            Db::table("think_tag")->where("id", $v["id"])->update(["num" => ($v["num"] - 1)]);
                        }
                    }

                    Db::commit();

                }

            } catch (\Exception $e) {
                Db::rollback();
                $this->error("添加失败！", "articlelist", '', 3);
            }
            $this->success("更新成功！", "articlelist");

        } else {
            //生成分类的select
            $resData = Db::table("think_category")->column("*", "id");
            $tree = new Tree();
            $tree->init($resData);

            $tplFenLei = "<option \$selected  value='\$id'>\$spacer \$name</option>";
            $tplStr = $tree->getTree(0, $tplFenLei, "");

            $dataArticle = Db::table("think_article")->where("id", $params["id"])->find();
            $dataArticle['content'] = stripslashes($dataArticle['content']);

            $tagId = explode(",", $dataArticle["tagid"]);
            $tags = explode(",", $dataArticle["tags"]);

            foreach ($tagId as $key => $value) {
                $tagArr[$value] = $tags[$key];
            }

            $this->assign([
                "selOption" => $tplStr,
                "aid" => $params["id"],
                "data" => $dataArticle,
                "tags" => json_encode($tagArr),
            ]);

        }

        return $this->fetch();
    }
    public function fileImgDel() {
        $param = $this->request->param();
        $old = $param["filename"];
        if (@unlink($_SERVER['DOCUMENT_ROOT'] . $param["filename"])) {
            Db::table("think_article")->where("id", $param["id"])->update(["coverimg" => ""]);
            echo 1;
        } else {
            echo 0;
        }
    }
}
?>