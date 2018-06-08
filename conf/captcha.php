<?php
return [
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
    ]
];


?>