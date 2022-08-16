<?php

namespace Test\Service;

class ProductHandler
{

    /**
     * Note: 计算商品总金额
     * @param array $products 商品数据
     * @return float|int
     * @Author: Wong
     * @Time: 2022/8/16 22:58
     */
    public function getTotalAmount($products)
    {
        return array_sum(array_column($products, 'price'));
    }

    /**
     * Note: 按商品金额排序并筛选类型
     * @param $products array 商品二维数据
     * @param $type string 类型筛选
     * @param $sort int 排序类型
     * @return array
     * @Author: Wong
     * @Time: 2022/8/16 23:09
     */
    public function getProductsOrderByPrice($products, $type = 'dessert', $sort = SORT_DESC)
    {
        if ($type) {
            $productsFiltered = array_filter($products, function ($product) use ($type) {
                return $product['type'] == $type;
            });
            $products = $productsFiltered;
        }
        $priceArr = array_column($products, 'price');
        array_multisort($priceArr, $sort, $products);
        return $products;
    }

    /**
     * Note: 商品创建时间转成时间戳
     * @param $products
     * @return array
     * @Author: Wong
     * @Time: 2022/8/16 23:32
     */
    public function convertToTime($products)
    {
        return Helper::ArrConvertToTime($products);
    }


}