<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\common\Tree;
use app\admin\model\AdminMenus;
use app\admin\model\AuthGroup;
use app\admin\model\AuthRules;
use think\Db;
use think\Request;
use think\Session;
use think\Validate;

class AdminMenu extends Base {

    public function index() {
        //column( '字段列表', '数组键名'  )
        //理想的状态就是 当前控制器提供 template 和数据 然后通过方法返回
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = Db::table("think_admin_menus")->order(["sort_id" => "desc", 'id' => 'asc'])->column('*', 'id');
        $tree->init($result);
        foreach ($result as $k => $v) {
            $v["status"] == 1 ? $result[$k]["status"] = "正常" : $result[$k]["status"] = "禁用";
            $result[$k]["urldel"] = url("del", ["id" => $v["id"]]);
            $result[$k]["urledit"] = url("edit", ["id" => $v["id"]]);

            if ($tree->getChild($k)) {
                $result[$k]["parent"] = 1;
            } else {
                $result[$k]["parent"] = 0;
            }
            switch ($v["log_type"]) {
                case 0:
                    $result[$k]["log_type"] = "不记录日志";
                    break;
                case 1:
                    $result[$k]["log_type"] = "get";
                    break;
                case 2:
                    $result[$k]["log_type"] = "post";
                    break;
                case 3:
                    $result[$k]["log_type"] = "put";
                    break;
                case 4:
                    $result[$k]["log_type"] = "delete";
                    break;
                default:
                    $result[$k]["log_type"] = "不记录日志";
                    break;
            }
        }
        $tree->init($result);

        $strTpl = "<tr>";
        $strTpl .= "<td>\$id</td>";
        $strTpl .= "<td class='align-l'>\$spacer \$title</td>";
        $strTpl .= "<td class='align-l'>\$url</td>";
        $strTpl .= "<td>\$pid</td>";
        $strTpl .= "<td><i class='iconfont \$icon'></i>\$icon</td>";
        $strTpl .= "<td>\$sort_id</td>";
        $strTpl .= "<td>\$status</td>";
        $strTpl .= "<td>\$log_type</td>";
        $strTpl .= "<td><a data-parent='\$parent' href='\$urldel' class='am-btn am-btn-danger am-btn-sx'>删除</a> <a href='\$urledit' class='am-btn am-btn-primary am-btn-sx'>修改</a></td>";
        $strTpl .= "</tr>";

        $str = $tree->getTree(0, $strTpl, "");

        $this->assign([
            "menustr" => $str,
        ]);
        return $this->fetch();
    }

    public function add() {
        //超级管理员拥有全部的权限，所以添加的菜单要把id 添加到权限中
        //而且要考虑事务处理(设计到多个表的数据操作)
        //添加的时候需要处理think_auth_group中的超级管理员的rule

        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = Db::table("think_admin_menus")->order(["sort_id" => "desc", 'id' => 'asc'])->column('*', 'id');
        $tree->init($result);
        $pSelTpl = "<option  value='\$id'>\$spacer\$title</option>";
        $pSelTplGroup = "<option  value='\$id'>&nbsp;&nbsp;├─ \$title</option>";
        $pSelStr = $tree->getTree(0, $pSelTpl, "", "", $pSelTplGroup);
        $pSelStr = "<option selected value='0'>根目录</option>" . $pSelStr;
        $this->assign([
            "pSelStr" => $pSelStr,
        ]);
        return $this->fetch("add");

    }

    public function addPost() {
        $rule = [
            'pid' => 'require',
            'title' => 'require',
            'url' => 'require',
            'sort_id' => 'require|number',
            'log_type', 'require',

        ];
        $message = [
            'pid' => '上级菜单不能为空',
            'title' => '标题不能为空',
            'url' => 'url不能为空',
            'sort_id.require' => '请输入排序id',
            'sort_id.number' => '排序id必须是数字',
            'log_type' => '日志记录方式不能为空',
        ];

        if ($this->request->isPost()) {

            //判断是否通过验证 验证通过就提示添加成功 然后跳转到index 如果失败
            $params = $this->request->param();

            $validate = new Validate($rule, $message);
            if (!$validate->check($params)) {
                $this->error($validate->getError(), "add");
            } else {
                //验证通过 就要插入,这里要启用事务
                Db::startTrans();

                try {
                    $resInsertId = Db::table("think_admin_menus")->insertGetId($params);
                    $rule_data = [
                        'title' => $params['title'],
                        'name' => $params['url'],
                        'status' => $params['status'],
                        'menu_id' => $resInsertId,
                    ];
                    $resInsertRuleId = Db::table("think_auth_rules")->insertGetId($rule_data);
                    //去处理group中的rule，而且只处理超级管理员(超级管理员拥有全部的权限) id=1
                    $rule = Db::table("think_auth_group")->where("id", 1)->value("rules");
                    $ruleArr = explode(",", $rule);
                    //如果当前新增的id又在rule字段面就不管如果没有，就添加
                    if (!in_array($resInsertRuleId, $ruleArr)) {
                        //id加入
                        $ruleArr[] = $resInsertRuleId;
                        Db::table("think_auth_group")->where("id", 1)->update(["rules" => implode(",", $ruleArr)]);
                    }
                    Db::commit();

                } catch (\Exception $e) {
                    Db::rollback();
                    $this->error("添加失败！", "add", '', 3);
                }
                //不能放在try里面，不然会抛出catch错误
                $this->success("添加成功！", "index", '', 3);
            }

        }
    }

    public function edit() {
        //获取编辑的id
        $id = $this->request->param("id");
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;';
        //通过id 获取数据
        $currMenuData = Db::table("think_admin_menus")->where('id', $id)->find();

        //当前的菜单上级不可能数据它自己，所以取数据的时候就要忽略
        $menuData = Db::table("think_admin_menus")->where("id", "<>", $id)->order(["sort_id" => "asc", 'id' => 'asc'])->column('*', 'id');
        $tree->init($menuData);
        $menuTpl = "<option \$selected  value='\$id'>\$spacer\$title</option>";
        $menuFirstTpl = "<option \$selected  value='\$id'>&nbsp;&nbsp;├─\$title</option>";
        $menuStr = $tree->getTree(0, $menuTpl, $currMenuData["pid"], "", $menuFirstTpl);
        $menuStr = "<option value='0'>根目录</option>" . $menuStr;
        $this->assign([
            'optionList' => $menuStr,
            'data' => $currMenuData,
        ]);
        return $this->fetch();
    }

    //修改的时候不需要修改 group 里面的rule
    public function editPost() {
        if ($this->request->isPost()) {
            $rule = [
                'pid' => 'require',
                'title' => 'require',
                'url' => 'require',
                'sort_id' => 'require|number',
                'log_type', 'require',
            ];
            $message = [
                'pid' => '上级菜单不能为空',
                'title' => '标题不能为空',
                'url' => 'url不能为空',
                'sort_id.require' => '请输入排序id',
                'sort_id.number' => '排序id必须是数字',
                'log_type' => '日志记录方式不能为空',
            ];
            $params = $this->request->param();

            $validate = new Validate($rule, $message);
            if (!$validate->check($params)) {
                Session::set('data', $params);
                $this->error($validate->getError(), "edit");
            } else {
                $data["pid"] = $params["pid"];
                $data["title"] = $params["title"];
                $data["url"] = $params["url"];
                $data["icon"] = $params["icon"];
                $data["sort_id"] = $params["sort_id"];
                $data["is_show"] = $params["is_show"];
                $data["log_type"] = $params["log_type"];
                $data["status"] = $params["status"];

                Db::startTrans();

                try {
                    //update不报错就不会报错(数据完全一样，没有更新也不会抛出错误)
                    Db::table("think_admin_menus")->where("id", $params["id"])->update($data);
                    $resSel = Db::table("think_auth_rules")->where("menu_id", $params["id"])->find();
                    if ($resSel) {
                        $ruleData = [
                            'title' => $params["title"],
                            'name' => $params["url"],
                            'status' => $params["status"],
                        ];
                        Db::table("think_auth_rules")->where("menu_id", $params["id"])->update($ruleData);
                    } else {
                        //rule表中不存在就要插入
                        $ruleData = [
                            'title' => $params["title"],
                            'name' => $params["url"],
                            'status' => $params["status"],
                            'menu_id' => $params["id"],
                        ];
                        Db::table("think_auth_rules")->insert($ruleData);
                    }

                } catch (\Exception $e) {
                    Db::rollback();
                    $this->error("添加失败！", url("edit", ["id" => $params["id"]]));
                }

                $this->success("添加成功！", "index");
            }
        } else {
            $this->error("非法请求！", "index");
        }

    }

    public function del() {
        //考虑删除父元素怎么办，所以del按钮 需要提示删除所有子元素
        //删除了 要删除 menu 和rule中的对应的菜单
        //同时要考虑到 auth_group中的
        $id = $this->request->param("id");
        $arr = array($id);
        $tree = new Tree();
        $flag = true;
        //获取该菜单下的所有子菜单，因为删除了父菜单 那么子菜单也要跟着删除
        $menuData = Db::table("think_admin_menus")->select();
        $tree->init($menuData);
        $child = $tree->getChild($id);

        if ($child) {
            //如果有子元素
            foreach ($child as $key => $value) {
                $arr[] = $value["id"];
            }
        }
        Db::startTrans();

        $resDel = Db::table("think_admin_menus")->where("id", "in", $arr)->delete();

        if ($resDel) {

            //删除好menu 接着要删除rule
            $delRuleId = Db::table("think_auth_rules")->where("menu_id", "in", $arr)->column("id");
            $resDel = Db::table("think_auth_rules")->where("menu_id", "in", $arr)->delete();

            if ($resDel) {
                //紧接着删除think_auth_group  对应的对应的ruleid
                $resSel = Db::table("think_auth_group")->column("*", "id");

                foreach ($resSel as $key => $value) {
                    $groupRule = explode(",", $value["rules"]);
                    foreach ($groupRule as $k => $v) {
                        if (in_array($v, $delRuleId)) {
                            //如果在arr里面，那么就要删除
                            unset($groupRule[$k]);
                        }
                    }
                    $resUpdate = Db::table("think_auth_group")->where("id", $key)->update(["rules" => implode(",", $groupRule)]);
                    if ($resUpdate === false) {
                        $flag = false;
                        break;
                    }
                }

            } else {
                $flag = false;
            }
        } else {
            $flag = false;
        }

        if (!$flag) {
            Db::rollback();
            $this->error("删除失败！", "index");
        } else {
            Db::commit();
            $this->error("删除成功！", "index");
        }

    }
}
?>