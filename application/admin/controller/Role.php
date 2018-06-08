<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\common\Tree;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRules;
use think\Db;
use think\Paginator;
use think\Session;
use think\Validate;

class Role extends Base {
    //因为要决定哪些是可以显示，哪些不能显示

    public function index() {

        $authgroup = new AuthGroup();
        // $result = $authgroup->select()->toArray();

        //如果是数据集查询的话有两种情况，由于默认的数据集返回结果的类型是一个数组因此无法调用 toArray 方法，必须先转成数据集对象然后再使用 toArray 方法，系统提供了一个 collection 助手函数实现数据集对象的转换

        //如果设置了模型的数据集返回类型的话，则可以简化使用  protected $resultSetType = 'collection';
        $lists = $authgroup->paginate();
        $page = $lists->render();
        $this->assign('page', $page);
        $this->assign("rolelist", $lists);
        return $this->fetch();
    }

    public function add() {
        $rule = [
            'title' => 'require',
        ];
        $message = [
            'title' => '角色名不能为空',
        ];

        if ($this->request->isPost()) {
            //如果是提交的时候
            $param = $this->request->param();
            //默认的就是只有首页和系统管理下的个人资料
            $param["rules"] = '1,2,23';

            Session::set('form_info', $param);
            $validate = new Validate($rule, $message);
            if (!$validate->check($param)) {
                $this->error($validate->getError(), "add");
            } else {
                //验证通过，那么就要插入到数据库中
                $authgroup = new AuthGroup();
                $authgroup->data($param);
                if ($authgroup->save()) {
                    Session::set('form_info', '');
                    $this->success("添加成功！", "index");
                } else {
                    $this->error("添加失败！", "add");
                }
            }
        } else {
            Session::set('form_info', '');
        }
        return $this->fetch();
    }

    public function del($id) {
        //删除一个角色的时候，think_auth_group_access表中所有用户拥有该角色的都要进行id删除
        //所以这个地方需要用到事务操作
        //问题来了，如果网站有很多用户，这下子要怎么办，需要遍历所有的用户然后对于每个进行删除
        $trans_flag=true;
        $authGroup=new AuthGroup();
        $authGroup->startTrans();

        $authGroupAccess=new AuthGroupAccess();
        $authGroupAccess->startTrans();

        if ($authGroup->where("id",$id)->delete()) {
            if(!!$authGroupAccess->where("group_id",$id)->find() && $authGroupAccess->where("group_id",$id)->delete()===0){
                $trans_flag=false;
            }
        }else{
            $trans_flag=false;
        }

        if($trans_flag){
            $authGroup->commit();
            $authGroupAccess->commit();
            $this->success('删除成功！', 'index');
        }else{
            $authGroup->rollback();
            $authGroupAccess->rollback();
            $this->error('删除失败！','index');
        }

    }
    public function access($id) {
        //$id角色id
        //获取角色id 对应的角色信息
        if ($this->request->isPost()) {
            //获取数据
            $param = $this->request->param();
            $rulesId = implode(",", $param["auth"]);

            //更新数据
            $authGroup = AuthGroup::get($id);
            $authGroup->rules = $rulesId;
            //save方法的更新判断失败用 false === 来判断， 否则执行都是成功的，只是如果为0 表示没有更新任何记录（就是你说的更新值和原来值相同的情况）。
            if ($authGroup->save() === false) {
                $url = url('access', ['id' => $id]);
                $this->error('更新失败！', $url);
            } else {
                $this->success('更新成功！', 'index');
            }

            //update group

        } else {

            $role = AuthGroup::get($id)->toArray();

            //获取角色 对应的权限id 数组
            $ruleCheck = explode(",", $role["rules"]);

            //获取表中所有的权限(为什么menu而不是rules),* 表示所有，column 第二个参数表示设置的键名
            $menuAll = Db::table("think_admin_menus")->order(["sort_id" => "asc", "menu_id" => "asc"])->column("*", "menu_id");

            //从auth_rules中判断哪些是在$ruleCheck 里面的，然后返回menu_id吗,然后在menus表中根据menu_id 整合数据
            $authRules = new AuthRules();
            //从auth_rules当中获取当前角色拥有的menu_id
            $roleRule = $authRules->whereIn('id', $ruleCheck)->column('menu_id');

            //从admin_menus 当中去

            //获取所有的权限规则(id作为键值)

            //进行字符窜操作
            function getStr($levelId, $ruleCheck, $data, $str = "", $first = true, $num = 0) {
                $tree = new Tree();
                $child = $tree->getChild($levelId, $data);

                foreach ($child as $key => $value) {
                    $subChild = $tree->getChild($value["menu_id"], $data);
                    $classFWStr = $num == 0 ? '' : 'fwnormal';
                    $checked = in_array($value["menu_id"], $ruleCheck) ? "checked" : "";
                    if ($subChild) {
                        $classStr = $num == 0 ? 'J_parent_top' : 'J_parent';
                        $str .= '<li class="treeview"><div class="item"><label class="' . $classFWStr . '"><input type="checkbox" value="' . $value["menu_id"] . '" name="auth[]" ' . $checked . ' class="mr5 J_checkbox ' . $classStr . '">' . $value["title"] . '</label><a href="#" class="fr J_toggleshow">收起</a></div><ul class="authadmin-item-list clearfix">';
                        $num++;
                        $str = getStr($value["menu_id"], $ruleCheck, $data, $str, false, $num);
                        $str .= "</ul></li>";

                    } else {
                        $classFWStr = !$first ? 'fwnormal' : "";
                        //如果没有子元素 且第一个元素的时候

                        $str .= '<li><div class="item"><label class="' . $classFWStr . '"><input type="checkbox" value="' . $value["menu_id"] . '" name="auth[]" ' . $checked . ' class="mr5 J_checkbox J_single">' . $value['title'] . '</label></div></li>';
                    }
                }

                return $str;
            }
            $str = getStr(0, $ruleCheck, $menuAll);

            $this->assign("ruleList", $str);
            $this->assign("roleId", $id);
            return $this->fetch();

        }
    }

    public function edit($id) {
        if ($this->request->isPost()) {
            $param = $this->request->param();

            $authGroup = AuthGroup::get($id);
            $authGroup->title = $param["title"];
            $authGroup->description = $param["description"];
            $authGroup->status = $param["status"];
            if ($authGroup->save() === false) {
                $url = url('edit', ['id' => $id]);
                $this->error("修改失败！", $url);
            } else {
                $this->success("修改成功！", "index");
            }
        } else {
            $role = AuthGroup::get($id)->toArray();
            Session::set('form_info', $role);
            return $this->fetch();
        }

    }
}
?>