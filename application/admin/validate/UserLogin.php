<?php
namespace app\admin\validate;
use think\Validate;

class UserLogin extends Validate {
    protected $rule = [
        'email' => 'require|email',
        'password' => 'require|min:6',
        'captcha' => 'require|captcha',
    ];
    //名称必须是message
    protected $message = [
        'email.require' => '邮箱不能为空',
        'email.email' => '请输入正确的邮箱',
        'password.require' => '密码不能为空',
        'password.min' => '密码的长度不能小于6位数',
        'captcha.require' => '请输入验证码',
        'captcha.captcha' => '验证码错误',
    ];

    //自定义验证规则  'email' => 'require|checkUserEmail',
    // protected function checkUserEmail($value, $rule) {
    //     $res = preg_match('/^\w+([-+.]\w+)*@' . $rule . '$/', $value);
    //     if (!$res) {
    //         return '邮箱只能是' . $rule . '域名';
    //     } else {
    //         return true;
    //     }
    // }
}
?>