<?php

namespace App\Service;

class ProductHandler
{


    public function getTotalPrice(array $products = [])
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $price = intval($product['price'] ?? 0);
            $totalPrice += $price;
        }

        return $totalPrice;
    }

    public function getDessertSortList(array $products = [])
    {
        // 筛选类型
        $products = array_filter($products, function ($row) {
            return $row['type'] == 'Dessert';
        });


        $refer = [];
        foreach ($products as $i => $data) {
            $refer[$i] = $data['price'];
        }

        // 排序处理
        arsort($refer);

        $resultSet = [];
        foreach ($refer as $key => $val) {
            $resultSet[] = $products[$key];
        }
        return $resultSet;
    }

    public function createAtToTimestamp(array $products = [])
    {
        foreach ($products as $k => $product) {
            $products[$k]['create_at'] = strtotime($product['create_at'] ?? '');
        }

        return $products;
    }



}