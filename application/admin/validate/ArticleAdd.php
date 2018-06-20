<?php
namespace app\admin\validate;
use think\Validate;

class ArticleAdd extends Validate {
    protected $rule = [
        'title' => 'require',
        'content' => 'require',
    ];
    //名称必须是message
    protected $message = [
        'title.require' => '请输入标题',
        'content.require' => '请输入文章内容',
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