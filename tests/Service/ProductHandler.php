<?php

namespace Test\Service;

class ProductHandler
{

    /**
     * 计算商品金额
     * @return int|mixed
     */
    public function getTotalPrice($products)
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }

        return $totalPrice;
    }

    /**
     * 筛选商品type类型并且按照金额倒序排序
     * @param $products
     * @param $type
     * @return array|mixed
     */
    public function getProductsOrderByPrice($products, $type = 'dessert')
    {
        //先过滤类型
        if ($type) {
            $products= array_filter($products,function($product) use($type){
                return isset($product['type']) && $product['type'] == $type;
            });
        }
        //金额按照价格倒序排序
        $priceArr = array_column($products, 'price');
        array_multisort($priceArr, SORT_DESC, $products);
        unset($priceArr);
        return $products;
    }

    /**
     * 商品的创建时间转成时间戳
     * @param $products
     * @return mixed
     */
    public function productsExchangeTime($products)
    {
        foreach($products as &$product) {
            $product['create_at'] = strtotime($product['create_at']);
        }
        unset($product);
        return $products;
    }
}