<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Article extends Controller {
    public function index() {
        return 'xxx';
    }

    public function detail() {
        $request = Request::instance();
        $params = $request->param();
        $data = Db::table("think_article")->where("id", $params["id"])->find();
        $data["content"] = stripslashes($data["content"]);
        $this->assign([
            "article" => $data,
        ]);
        return $this->fetch();
    }
}
