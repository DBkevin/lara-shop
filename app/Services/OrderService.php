<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Jobs\CloseOrder;
use App\Models\CouponCode;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\CouponCodeUnavailableException;

class OrderService
{
    //添加一个$coupon的参数,可以为null
    public function store(User $user, UserAddress $address, $remark, $items, CouponCode $coupon = null)
    {
        //如果传入了优惠券,则先检擦是否可用
        if ($coupon) {
            //但此时还没计算出订单的总金额,暂不校验
            $coupon->checkAvailable();
        }
        //开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $address, $remark, $items, $coupon) {
            //更新此地址的最后使用时间
            $address->update(['last_used_at' => Carbon::now()]);
            //创建一个订单
            $order = new Order([
                'address' => [
                    //将地址信息放入订单中
                    'address' => $address->FullAddress,
                    'zip' => $address->zip,
                    'contact_name' => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'type'=>Order::TYPE_NORMAL,
                'remark' => $remark,
                'total_amount' => 0,
            ]);
            //订单关联到当前用户
            $order->user()->associate($user);
            //写入数据库
            $order->save();

            $totalAmount = 0;
            //遍历用户提交的SKU
            foreach ($items as $data) {
                $sku = ProductSku::find($data['sku_id']);
                // 创建一个OrderItem直接关联当前订单
                $item = $order->items()->make([
                    'amount' => $data['amount'],
                    'price' => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                $totalAmount += $sku->price * $data['amount'];

                if ($sku->decreaseStock($data['amount']) <= 0) {
                    throw new InvalidRequestException('改商品库存不足');
                }
            }
            if ($coupon) {
                // 总金额已经计算出来了,检查是否符合优惠券规则
                $coupon->checkAvailable($totalAmount);
                //吧订单金额修改为优惠后的金额
                $totalAmount = $coupon->getAdjustedPrice($totalAmount);
                //将订单与优惠券关联
                $order->couponCode()->associate($coupon);
                // 增加优惠券的用量，需判断返回值
                if ($coupon->changeUsed() <= 0) {
                    throw new CouponCodeUnavailableException('该优惠券已被兑完');
                }
            }
            //更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            //将下单的商品从购物车中移除
            $skuIds = collect($items)->pluck('sku_id')->all();
            app(CartService::class)->remove($skuIds);

            return $order;
        });
        //这里之际使用dispatch函数下发队列删除未支付订单
        dispatch(new CloseOrder($order, config('app.order_ttl')));
        return $order;
    }


    //新建一个crowdfunding 方法用于众筹商品下单逻辑
    public function  crowdfunding(User $user, UserAddress $address, ProductSku $sku, $amount)
    {
        //开启事务,
        $order = \DB::transaction(function () use ($amount, $sku, $user, $address) {
            //更新地址最后使用时间
            $address->update(['last_used_at' => Carbon::now()]);
            //创建一个订单
            $order = new Order([
                'address' => [
                    'address' => $address->full_address,
                    'zip' => $address->zip,
                    'contact_name' => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'type'=>Order::TYPE_CROWDFUNDING,
                'remark' => '',
                'total_amount' => $sku->price * $amount,
            ]);
            //订单关联到当前用户
            $order->user()->associate($user);
            //写入数据库
            $order->save();
            //创建一个新的订单项并于SKU关联
            $item = $order->items()->make([
                'amount' => $amount,
                'price' => $sku->price,
            ]);
            $item->product()->associate($sku->product_id);
            $item->productSku()->associate($sku);
            $item->save();
            //扣减对应SKU库存
            if ($sku->decreaseStock($amount) <= 0) {
                throw new InvalidRequestException('该商品库存不足');
            }
            return $order;
        });

        //众筹结束时间减去当前时间得到的剩余描述
        $crowdfundingTtl = $sku->product->crowdfunding->end_at->getTimestamp()-time();
        //生育秒数与默认订单关闭时间取较小值作为订单关闭时间
        dispatch(new CloseOrder($order, min(config('app.order_ttl'), $crowdfundingTtl)));

        return $order;
    }
}
