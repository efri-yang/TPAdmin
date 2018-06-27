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

        $result = Db::table("think_admin_menus")->order(["sort_id" => "desc", 'id' => 'asc'])->column('*', 'id');

        foreach ($result as $k => $v) {
            $v["status"] == 1 ? $result[$k]["status"] = "正常" : $result[$k]["status"] = "禁用";

            $result[$k]["urledit"] = url("del", ["id" => $v["id"]]);
            $result[$k]["urldel"] = url("edit", ["id" => $v["id"]]);
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

        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

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
        $strTpl .= "<td><a href='\$urldel' class='am-btn am-btn-danger am-btn-sx'>删除</a> <a href='\$urldel' class='am-btn am-btn-primary am-btn-sx'>修改</a></td>";
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
                $flag = true;
                Db::startTrans();

                $resInsertId = Db::table("think_admin_menus")->insertGetId($params);
                if (!$resInsertId) {

                    $flag = false;
                } else {

                    $rule_data = [
                        'title' => $params['title'],
                        'name' => $params['url'],
                        'menu_id' => $resInsertId,
                    ];
                    $resInsert = Db::table("think_auth_rules")->insert($rule_data);
                    if (!$resInsert) {
                        $flag = false;
                    }
                }

                //如果menus表中添加数据成功，那么就要往
                if (!$flag) {
                    Db::rollback();
                    $this->error("添加失败！", "add");
                } else {
                    Db::commit();
                    $this->error("添加成功！", "index");
                }
            }

        }
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

    public function del() {
        //考虑删除父元素怎么办，所以del按钮 需要提示删除所有子元素
        //删除了 要删除 menu 和rule中的对应的菜单
        //同时要考虑到 auth_group中的
        $params = $this->request->param();
        $id = $params["id"];
        $arr = array($id);
        //获取该菜单下的所有子菜单，因为删除了父菜单 那么子菜单也要跟着删除
        foreach ($this->menuList as $k => $v) {
            if ($v["parent_id"] == $id) {
                $arr[] = $v["menu_id"];
            }
        }

        $trans_result = true;

        $adminMenus = new AdminMenus();
        $adminMenus->startTrans();

        $res = AdminMenus::destroy($arr);

        if (!$res) {
            $trans_result = false;
        }

        $authRules = new AuthRules();
        $authRules->startTrans();

        $res = AuthRules::where('menu_id', 'IN', $arr)->delete();
        if (!$res) {
            $trans_result = false;
        }

        $authGroup = new AuthGroup();
        $authGroupList = AuthGroup::all()->toArray();
        $authGroup->startTrans();

        foreach ($authGroupList as $key => $value) {

            $rule = explode(",", $value["rules"]);
            if (($offfset = array_search($id, $rule)) !== false) {
                array_splice($rule, $offfset, 1);
                if ($authGroup->save(['rules' => implode(",", $rule)], ['id' => $value['id']]) === false) {

                    $trans_result = false;
                    break;
                }
            }
        }

        if ($trans_result) {
            $adminMenus->commit();
            $authRules->commit();
            $authGroup->commit();
            $this->success("删除成功！", "index");
        } else {
            $adminMenus->rollBack();
            $authRules->rollBack();
            $authGroup->rollBack();
            $this->error("删除失败！", "index");
        }

        // $adminRules->commit();

    }

    public function edit() {
        //获取编辑的id
        $id = $this->request->param("id");
        $tree = new Tree();
        //通过id 获取数据
        $currMenuInfo = Db::table("think_admin_menus")->where('id', $id)->find();

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
            $rule_data = [
                'title' => $this->post['title'],
                'name' => $this->post['url'],
            ];
            $validate = new Validate($rule, $message);
            $flag = true;
            if (!$validate->check($params)) {
                Session::set('form_info', $params);
                $this->error($validate->getError(), "edit");
            } else {

                $data["pid"] = $params["parent_id"];
                $data["title"] = $params["title"];
                $data["url"] = $params["url"];
                $data["icon"] = $params["icon"];
                $data["sort_id"] = $params["sort_id"];
                $data["is_show"] = $params["is_show"];
                $data["log_type"] = $params["log_type"];
                //更新数据库
                $adminM = new AdminMenus();
                $adminR = new AuthRules();

                $adminM->startTrans();
                $adminR->startTrans();

                if ($adminM->save($data, ['menu_id' => $id]) !== false) {

                    if ($adminR->save($rule_data, ['id' => $id]) === false) {
                        $flag = false;
                    }
                } else {

                    $flag = false;
                }

                if ($flag) {
                    $adminM->commit();
                    $adminR->commit();
                    return $this->success("修改成功！", "index");
                } else {
                    $adminM->rollback();
                    $adminR->rollback();
                    return $this->error("修改失败", "index");
                }

            }

        } else {
            function getParentId($pid, $data) {
                if ($pid == 0) {
                    return 0;
                }
                foreach ($data as $key => $value) {
                    if ($value['menu_id'] == $pid) {
                        return $value["menu_id"];
                    }
                }
            }

            $currMenuInfo = Db::table("think_admin_menus")->where('menu_id', $id)->find();

            Session::set('form_info', $currMenuInfo);
            $tree = new Tree();
            $result = Db::table("think_admin_menus")->order(["sort_id" => "asc", 'menu_id' => 'asc'])->column('*', 'menu_id');
            $parentId = getParentId($currMenuInfo["parent_id"], $result);
            $optionList = $tree->getOptions(0, $result, $parentId);
            $this->assign('optionList', $optionList);
        }

        return $this->fetch();
    }

    public function editPost() {

    }
}
?>