<?php

namespace App\Providers;

use Monolog\Logger;
use Yansongda\Pay\Pay;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //往服务容器中注入一个命为alipay的单例对象
        $this->app->singleton('alipay', function () {
            $config = config('pay.alipay');
            //$config['notify_url'] = route('payment.alipay.notify');
            $config['notify_url']='http://requestbin.fullcontact.com/17tfwxh1';
            $config['return_url'] = route('payment.alipay.return');
            // 判断当前环境是否为线上环境
            if (app()->environment() !== 'production') {
                $config['mode'] = 'dev';
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }

            // 调用Yansongda\pay 来创建一个支付宝支付对象
            return Pay::alipay($config);
        });

        //往服务容器注入一个微信单例对象
        $this->app->singleton('wechat_pay', function () {
            $config = config('apy.weichar');
            if (app()->environment() !== 'production') {
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }

            //调用Yansongda\pay来创建一个微信支付对象
            return Pay::wechat($config);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
