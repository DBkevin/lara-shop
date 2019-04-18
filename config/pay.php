<?php

return [
    'alipay' => [
        'app_id' => '',
        'ali_public' => '',
        'private_key' => '',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],
    'wechar' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_clien' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
