<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    'app_debug' => true,
    'captcha' => [
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
        'fontttf' => '4.ttf',
        // 验证码位数
        'length' => 4,
        'useNoise' => true,

        // 验证成功后是否重置
        'reset' => true,
    ],
    //伪静态设置
    'url_html_suffix' => false,

    'paginate' => [
        'type' => 'page\Page',
        'var_page' => 'page',
        'list_rows' => 10,
    ],
    'url_route_on' => true,
    'url_route_must' => false,
    //
    'url_common_param' => false,
];
