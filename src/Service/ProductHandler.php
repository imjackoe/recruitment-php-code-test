<?php

namespace App\Service;

class ProductHandler
{
    /**
     * 统计商品总额
     * @param $products
     * @return int|mixed
     */
    public static function countAllPrice($products)
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }
        return $totalPrice;
    }

    /**
     * 排序并归类
     * @param $products
     * @param string $type
     * @return array
     */
    public static function sortAndGroup($products, string $type = ''): array
    {
        if (!is_array($products)) {
            return [];
        }
        $array_column = array_column($products, 'price'); // 根据产品排序
        array_multisort($array_column, SORT_DESC, $products);
        if ($type) {
            $data = [];
            foreach ($products as $v) {
                if ($type == $v['type']) {
                    $data[] = $v;
                }
            }
            return $data;
        }
        return $products;
    }

    /**
     * 转换时间
     * @param $products
     * @param string $index
     * @return array
     */
    public static  function transformTime($products, string $index = 'create_at'): array
    {
        if (!is_array($products)) {
            return [];
        }
        foreach ($products as &$row) {
            $row[$index] = strtotime($row[$index]);
        }
        return $products;
    }

}