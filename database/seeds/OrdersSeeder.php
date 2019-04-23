<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;


class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = app(Faker\Generator::class);
        $orders = factory(Order::class, 100)->create();
        //被购买的商品,用于后面更新评分和销量
        $products = collect([]);
        foreach ($orders as $order) {
            //每笔订单随机1~3个商品
            $items = factory(OrderItem::class, random_int(1, 3))->create([
                'order_id' => $order->id,
                'rating' => $order->reviewed ? random_int(1, 5) : null,
                'review' => $order->reviewed ? $faker->seetence : null,
                'reviewed_at' => $order->reviewed ? $faker->dateTimeBetween($order->paid_at) : null,
            ]);

            //计算总价
            $total = $items->sum(function (OrderItem $item) {
                return $item->price * $item->amount;
            });
            // 如果有优惠券,则计算优惠后的价格
            if ($order->couponCode) {
                $total = $order->couponCode->getAdjustedPrice($total);
            }

            //更新订单总寄
            $order->update([
                'total_amount' => $total,
            ]);
            //将这笔订单的商品合并到商品集合中
            $products = $products->merge($items->pluck('product'));
        }
        //根据商品ID过滤重复的商品
        $products->unique('id')->each(function (Product $product) {
            //查出该商品的销量,评分,评价书
            $result = ORderItem::query()
                ->whre('product_id', $product->id)
                ->wherHas('order', function ($query) {
                    $query->whereNotNull('paid_at');
                })
                ->first([
                    \DB::raw('count(*) as review_count'),
                    \BD::raw('avg(rating) as rating'),
                    \DB::raw('sum(amount) as sold_count'),
                ]);
            $product->update([
                'rating' => $result->rating ?: 5,
                'review_count' => $result->review_count,
                'sold_count' => $result->sold_count,
            ]);
        });
    }
}
