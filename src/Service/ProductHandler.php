<?php

namespace App\Service;

class ProductHandler
{
    /**
     * Desc: get total price
     * Date: 2022/8/3
     *
     * @throws \Exception
     */
    public function getTotalPrice(array $products): float
    {
        $totalPrice = 0.0;
        try {
            $prices     = array_column($products, 'price');
            $totalPrice = array_sum($prices);
        } catch (\Exception $exception) {
            throw new \Exception('calculation mistake!');
        }

        return $totalPrice;
    }

    /**
     * Desc: sort product price
     * Date: 2022/8/3
     *
     * @return void
     */
    public function sortPriceByProductType(array $products, string $productType = 'Dessert', string $sort = 'DESC'): array
    {
        $products = $this->searchByProductType($products, $productType);
        $newArr   = [];
        foreach ($products as $key => $item) {
            $newArr[$key] = $item['price'];
        }
        'ASC' == $sort ? asort($newArr) : arsort($newArr);
        foreach ($newArr as $k => $item) {
            $newArr[$k] = $products[$k];
        }

        return $newArr;
    }

    /**
     * Desc: format unix timestamp
     * Date: 2022/8/3
     */
    public function formatUnixTime(array $products): array
    {
        $newArr = [];
        array_map(function ($product) use (&$newArr) {
            try {
                $product['create_at'] = strtotime($product['create_at']);
            } catch (\Exception $exception) {
                $product['create_at'] = 0;
            }

            $newArr[] = $product;
        }, $products);

        return $newArr;
    }

    /**
     * Desc: search product type
     * Date: 2022/8/3
     *
     * @throws \Exception
     */
    private function searchByProductType(array $products, string $searchValue): array
    {
        if (empty($searchValue)) {
            return [];
        }
        $newArr = [];
        try {
            foreach ($products as $item) {
                if ($item['type'] == $searchValue) {
                    $newArr[] = $item;
                }
            }
        } catch (\Exception $exception) {
            throw new \Exception('invalid property!');
        }

        return $newArr;
    }
}
