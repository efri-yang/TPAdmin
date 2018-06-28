<?php
namespace app\admin\controller;

use app\admin\common\Auth;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthUser;
use think\Session;
use think\Validate;

class AdminUser extends Base {
    public function index() {
        //获取auth_user 所有数据并展示，注意分页的结合使用
        $authUser = new AuthUser();
        //超级管理员不显示（因为对自己可以通过个人信息设置编辑，对别人没有权限修改它，所以不可见）
        $authUser->where('id', '<>', 1);
        //分页的调用 无需要在使用select()
        $lists = $authUser->paginate();
        $page = $lists->render();
        $this->assign([
            "list" => $lists,
            'page' => $page,
        ]);
        return $this->fetch();
    }

    //修改个人资料
    public function profile() {
        return $this->fetch();
    }
    //添加的时候，只有超级管理员，其他不可以设置
    public function add() {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $rule = [
                'username' => 'require',
                'password' => 'require|min:6',
                'email' => 'email',
                'phone' => ['require', "regex" => '/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/'],

            ];
            $message = [
                'username' => '请输入用户名',
                'password.required' => '请输入密码',
                'password.min' => '密码至少6位',
                'email' => '请输入邮箱',
                'phone.required' => '请输入手机号码',
                'phone.regex' => '请输入正确的手机格式',
            ];
            $params = [
                'username' => $param["username"],
                'password' => md5($param["password"]),
                'email' => $param['email'],
                'phone' => $param["phone"],
            ];
            //用来存放插入authGroupAccess数据表数据
            $groupData = [];

            $validate = new Validate($rule, $message);
            if (!$validate->check($params)) {
                Session::set("data", $param);
                $this->error($validate->getError(), "add");
            } else {
                //验证通过的时候
                $trans_result = true;

                $authUser = new AuthUser();
                $authUser->startTrans();
                $authUser->data($params);
                if ($authUser->save() === false) {
                    $trans_result = false;
                }

                $authGroupAccess = new AuthGroupAccess();
                $authGroupAccess->startTrans();
                foreach ($param["group_id"] as $key => $value) {
                    $groupData[$key]['uid'] = $authUser->id;
                    $groupData[$key]['group_id'] = $value;
                }
                if ($authGroupAccess->saveAll($groupData) === false) {
                    $trans_result = false;
                }
                if ($trans_result) {
                    $authUser->commit();
                    $authGroupAccess->commit();
                    Session::set("form_info", "");
                    $this->success("添加成功！", "add", "", 20);
                } else {
                    $authUser->rollBack();
                    $authGroupAccess->rollBack();
                    //因为失败的时候要记住用户输入的信息，避免重新填写
                    Session::set("form_info", $param);
                    $this->error("添加失败！", "index");
                }
            }
        } else {
            $uid = $this->webData["userinfo"]['id'];
            $groupIdObj = AuthGroupAccess::where(["uid" => $uid])->field('group_concat(group_id) as group_id')->group('uid')->find();
            if ($groupIdObj) {
                $groupId = $groupIdObj->toArray();
            } else {
                $groupId = false;
            }
            if ($uid == 1 || in_array(1, $groupId)) {
                //超级管理员
                $data = AuthGroup::all()->toArray();
            } else {
                $data = AuthGroup::all(function ($query) {
                    $query->where("id", ">", 1);
                })->toArray();
            }
            $this->assign("data", $data);
            return $this->fetch();
        }

    }

    //添加用户的时候会关联到用户表和think_auth_group_access，因为用户是属于什么角色需要关联到其他表
    //两次密码不一样怎么办

    public function edit() {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $id = $param["id"];

            $trans_result = true;

            $authUser = AuthUser::get($id);
            $authUser->startTrans();
            $authUser->data([
                'username' => $param["username"],
                'password' => md5($param["password"]),
                'email' => $param['email'],
                'phone' => $param["phone"],
                'status' => $param["status"],
            ]);
            if ($authUser->save() === false) {
                $trans_result = false;
            }
            //用户角色表进行操作,一个用户有多个角色可能，
            //所以最好的方式就是删除原来用户的数据，然后重新添加

            $authGroupAccess = new AuthGroupAccess();
            $authGroupAccess->startTrans();
            if ($authGroupAccess->where('uid', $id)->delete() !== false) {
                foreach ($param["group_id"] as $key => $value) {
                    $data[$key]['uid'] = $id;
                    $data[$key]['group_id'] = $value;
                }
                if ($authGroupAccess->saveAll($data) === false) {
                    $trans_result = false;
                }
            } else {
                $trans_result = false;
            }
            if ($trans_result) {
                $authUser->commit();
                $authGroupAccess->commit();
                $this->success("修改成功！", "index");
            } else {
                $authUser->rollBack();
                $authGroupAccess->rollBack();
                $this->error("修改失败！", url("edit", ["id" => $id]));
            }
        } else {
            $id = $this->request->param("id");
            //获取用户信息
            $authUser = AuthUser::get($id)->toArray();

            //获取所有的角色
            $auth = new Auth();
            if ($auth->isSuperAdmin($this->webData['userinfo']["id"])) {
                $groupList = AuthGroup::all()->toArray();
            } else {
                $groupList = AuthGroup::all(function ($query) {
                    $query->where("id", '<>', 1);
                })->toArray();
            }

            //获取当前用户所拥有的角色
            $groupIdObj = AuthGroupAccess::where(["uid" => $id])->field('group_concat(group_id) as group_id')->group('uid')->find();
            //考虑当前用户假设没有任何角色的时候返回的是null所以调用$groupIdObj->toArray()就会报错
            if ($groupIdObj) {
                $groupId = $groupIdObj->toArray();
            } else {
                $groupId = false;
            }
            //编辑角色，标注哪些是选中
            foreach ($groupList as $key => $value) {
                if (!!$groupId) {
                    if (in_array($value["id"], explode(",", $groupId["group_id"]))) {
                        $groupList[$key]["checked"] = 1;
                    } else {
                        $groupList[$key]["checked"] = 0;
                    }
                } else {
                    $groupList[$key]["checked"] = 0;
                }
            }

            $this->assign([
                "data" => $authUser,
                "groupList" => $groupList,
            ]);

            return $this->fetch();
        }
    }

    //删除设计两个表 用户表和AuthGroupAccess表
    public function del() {

        $id = $this->request->param("id");
        $trans_flag = true;
        $authUser = new AuthUser();
        $authUser->startTrans();
        $authGroupAccess = new AuthGroupAccess();
        $authGroupAccess->startTrans();
        //删除user表中的数据
        if ($authUser->where('id', $id)->delete()) {
            //没有的时候删除返回的是0,所以才这么写
            if ($authGroupAccess->where('uid', $id)->find() && !$authGroupAccess->where('uid', $id)->delete()) {
                $trans_flag = false;
            }
        } else {
            $trans_flag = false;
        }

        if ($trans_flag) {
            $authUser->commit();
            $authGroupAccess->commit();
            $this->success("删除成功！", "index");
        } else {
            $authUser->rollback();
            $authGroupAccess->rollback();
            $this->error("删除失败！", "index");
        }

    }

}
?>