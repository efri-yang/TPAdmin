<?php
namespace app\admin\controller;
use app\admin\common\Auth;
use app\admin\model\AuthUser;
use think\captcha\Captcha;
use think\Controller;
use think\DB;
use think\Loader;
use think\Request;


class Login extends Controller {
    public function index() {
        return $this->redirect("login");
    }
    //验证码
    public function verify() {

        $config = [
            // 验证码字符集合
            'codeSet' => '0123456789',
            // 验证码字体大小(px)
            'fontSize' => 14,
            // 是否画混淆曲线
            'useCurve' => false,
            // 验证码图片高度
            'imageH' => 30,
            // 验证码图片宽度
            'imageW' => 100,
            //
            'fontttf' => '4.ttf',

            // 验证码位数
            'length' => 4,

            'useNoise' => true,

            // 验证成功后是否重置
            'reset' => true,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function login() {

        if ($this->request->isPost()) {
            $request = Request::instance();
            $params = $request->param();
            $params["password"] = md5($params["password"]);

            $result = $this->validate($params,'UserLogin');

            if (true !== $result){
                $this->error($result, "login/login");
            } else {

                //验证通过以后，就需要判断用户名或者密码是否正确！！！这里是模型
                $authUser = new AuthUser;
                //DB操作返回是数组。模型直接操作返回是对象
                //下面是使用模型数组查询的方式，也可以使用主键的方式get就是静态方法，查询单条数据！！
                //$user = $authUser::get(["email" => $params["email"], "password" => $params["password"]]);
                //$data=Db::table("think_auth_user")->where("email",$params["cemail"])->where("password",$params["password"])->find();
                $user = $authUser->where(["email" => $params["email"], "password" => $params["password"]])->find();

                //判断用户是否存在，存在判断是否已被禁用 也可以直接!!$user因为查询不到的时候返回false
                if (!!$user) {

                    //获取数据对象原始数据:getData()
                    //判断用户是否
                    if ($user->status != 1) {
                        $this->error("账户被冻结", "login/index");
                    }
                    //判断是否需要记住账号和密码(没有选中checkbox的时候是不在的)，记住账号和密码 那么就需要cookie 存在本地
                    if (@$params["remember"] == 1) {
                        Auth::login($user["id"], $user["username"], true);
                    } else {
                        Auth::login($user["id"], $user["username"], false);
                    }

                    $redirect_uri = isset($this->param['uri']) ? $this->param['uri'] : 'admin/index/index';
                    $this->success("登录成功！", $redirect_uri);
                } else {
                    $redirect_uri = isset($this->param['uri']) ? $this->param['uri'] : 'admin/index/index';
                    //用户不存在
                    $this->error("用户名或者密码错误！", url($redirect_uri));
                }
            }
        } else {

            $this->assign([
                'url' => isset($this->request->param['uri']) ? $this->request->param['uri'] : '',
            ]);
        }
        return $this->fetch("index");

    }

    public function loginOut() {
        if (Auth::loginOut()) {
            $this->success("成功退出！", "login/index");
        }
    }
}
?>