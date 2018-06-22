<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\common\Tree2;
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
        //
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

                $tagIdArray = explode(",", $params["tagid"]);

                $insertResult = Db::table('think_article')->insertGetId($insertData);

                if ($insertResult) {

                    foreach ($tagIdArray as $key => $value) {
                        $insertTagMap[$key]["tagid"] = $value;
                        $insertTagMap[$key]["aid"] = $insertResult;
                    }

                    $insertMapResult = Db::table('think_tagmap')->insertAll($insertTagMap);

                    if (!$insertMapResult) {
                        $flag = false;
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
            $data = Db::table("think_admin_menus")->select();
            $tree2 = new Tree2();
            $realData = array();
            $realData = $tree2::hTree($data, $this->webData["parent_id"]);
            $needData = array();
            foreach ($realData as $key => $value) {
                if (!strrpos($value["url"], "add") && !strrpos($value["url"], "articlelist")) {
                    $needData[] = $value;
                }
            }
            $needData = $tree2::sort($needData, "sort_id");

            $tplFenLei = "<option  value='\$menu_id'>\$title</option>";

            $tplStr = $tree2->getTree($needData, $tplFenLei);

            $this->assign([
                "selOption" => $tplStr,
            ]);
            return $this->fetch();
        }

    }

    public function articlelist() {
        $list = Db::table('think_article')->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function tagList() {

        $resData = Db::table("think_tag")->field('id,name')->select();
        if ($aid = @$_POST["aid"]) {
            //取得当前文章对应的分类id
            $atagId = Db::table("think_tagmap")->field('group_concat(tagid) as tagid')->where("aid", $aid)->group("aid")->select();

            $tagIdArr = explode(",", $atagId[0]["tagid"]);

            foreach ($resData as $key => $value) {
                if (in_array($value["id"], $tagIdArr)) {
                    
                    $resData[$key]["selected"] = 1;
                }
            }
        }

        return $resData;
    }

    public function del() {
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
            date_default_timezone_set('PRC');
            $resCount = Db::table("think_article")->where('id', $params["id"])->update([
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
            if ($resCount) {
                //先删除 tapmap中对应aid 的值，然后重新插入
                Db::table("think_tagmap")->where("aid", $params["id"])->delete();
                $tagIdArray = explode(",", $params["tagid"]);
                foreach ($tagIdArray as $key => $value) {
                    $insertTagMap[$key]["tagid"] = $value;
                    $insertTagMap[$key]["aid"] = $params["id"];
                }

                $insertMapResult = Db::table('think_tagmap')->insertAll($insertTagMap);

                if ($insertMapResult) {
                    $this->success("更新成功！", "articlelist");
                } else {
                    $this->success("更新失败！", "articlelist");
                }

            } else {
                $this->success("更新失败！", "articlelist");
            }
        } else {
            $data = Db::table("think_admin_menus")->column("*", "menu_id");

            $tree2 = new Tree2();
            $realData = array();

            $realData = $tree2::hTree($data, $this->webData["parent_id"]);

            $needData = array();
            foreach ($realData as $key => $value) {

                if (!strrpos($value["url"], "add") && !strrpos($value["url"], "articlelist") && !strrpos($value["url"], "edit") && !strrpos($value["url"], "del")) {
                    $needData[$key] = $value;
                }
            }

            $tplFenLei = "<option \$selected  value='\$menu_id'>\$title</option>";

            $dataArticle = Db::table("think_article")->where("id", $params["id"])->find();

            $dataArticle['content'] = stripslashes($dataArticle['content']);
            $tplStr = $tree2->getTree($needData, $tplFenLei, $dataArticle["classifyid"]);
            Session::set('form_info', $dataArticle);
            $tagId = explode(",", $dataArticle["tagid"]);
            $tags = explode(",", $dataArticle["tags"]);

            foreach ($tagId as $key => $value) {
                $tagArr[$value] = $tags[$key];
            }

            $this->assign([
                "selOption" => $tplStr,
                "aid" => $params["id"],
                "article" => $dataArticle,
                "tags" => json_encode($tagArr),
            ]);

        }

        return $this->fetch();
    }
}
?>