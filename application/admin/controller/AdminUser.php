<?php
namespace app\admin\controller;

use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthUser;
use think\Session;

class AdminUser extends Base {
    public function index() {
        //获取auth_user 所有数据并展示，注意分页的结合使用
        $authUser = new AuthUser();
        //超级管理员不显示（因为对自己可以通过个人信息设置编辑，对别人没有权限修改它，所以不可见）
        $authUser->where('id', '<>', 1);
        //分页的调用 无需要在使用select()
        $lists = $authUser->paginate();
        $page = $lists->render();
//        $this->assign("list", $lists);
//        $this->assign('page', $page);
        $this->assign([
            "list"=>$lists,
            'page'=>$page
        ]);
        return $this->fetch();
    }
    public function profile() {
        return $this->fetch();
    }

    public function add() {
        //要去auth_group 查询所有的角色
        $groupList = AuthGroup::all()->toArray();
        if ($this->request->isPost()) {
            $trans_result = true;
            $param = $this->request->param();
            $data = [];
            $authUser = new AuthUser();
            $authUser->startTrans();
            $authUser->data([
                'username' => $param["username"],
                'password' => md5($param["password"]),
                'email' => $param['email'],
                'phone' => $param["phone"],
            ]);
            if ($authUser->save() === false) {
                $trans_result = false;
            }
            $authGroupAccess = new AuthGroupAccess();
            $authGroupAccess->startTrans();
            //group_id 可能是一个数组(一个用户可能有多个角色)
            foreach ($param["group_id"] as $key => $value) {
                $data[$key]['uid'] = $authUser->id;
                $data[$key]['group_id'] = $value;
            }

            if ($authGroupAccess->saveAll($data) === false) {
                $trans_result = false;
            }
            if ($trans_result) {
                $authUser->commit();
                $authGroupAccess->commit();
                $this->success("添加成功！", "index");
            } else {
                $authUser->rollBack();
                $authGroupAccess->rollBack();
                //因为失败的时候要记住用户输入的信息，避免重新填写
                Session::set("form_info", $param);
                $this->error("添加失败！", "index");
            }
        } else {
            //添加的时候，不应该会有任何的form_info存在
            Session::set("form_info", '');
            $this->assign("groupList", $groupList);
            return $this->fetch();
        }

    }

    public function edit($id) {
        if ($this->request->isPost()) {
            $trans_result = true;
            $data = [];
            $param = $this->request->param();
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
            //用户角色表进行操作
            //两种方式  第一种修改已经有的 删除 没有的
            //第二种 直接删除原来的  添加现有的
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
                $this->error("修改失败！", "index");
            }

        } else {
            //修改的时候
            //获取用户的信息
            $authUser = AuthUser::get($id)->toArray();
            //放到session当中
            Session::set("form_info", $authUser);
            //获取角色分类
            $groupList = AuthGroup::all()->toArray();
            $groupIdObj = AuthGroupAccess::where(["uid" => $id])->field('group_concat(group_id) as group_id')->group('uid')->find();
            //考虑当前用户假设没有任何角色的时候返回的是null所以调用$groupIdObj->toArray()就会报错
            if ($groupIdObj) {
                $groupId = $groupIdObj->toArray();
            } else {
                $groupId = false;
            }
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
                "id" => $id,
                "groupList" => $groupList,
            ]);
        }
        return $this->fetch();
    }


    public function del($id){
        $trans_flag=true;
        $authUser=new AuthUser();
        $authUser->startTrans();
        $authGroupAccess=new AuthGroupAccess();
        $authGroupAccess->startTrans();
        if($authUser->where('id',$id)->delete()){
            if($authGroupAccess->where('uid',$id)->find() && !$authGroupAccess->where('uid',$id)->delete()){
                $trans_flag=false;
            }
        }else{
            $trans_flag=false;
        }

        if($trans_flag){
            $authUser->commit();
            $authGroupAccess->commit();
            $this->success("删除成功！", "index");
        }else{
            $authUser->rollback();
            $authGroupAccess->rollback();
            $this->error("删除失败！", "index");
        }


    }

}
?>