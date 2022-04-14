<?php

namespace App\Service;

class ProductHandler
{
    /***
     * @param array $data
     * @return int|string
     */
    public function getTotalPrice(array $data){
        $totalPrice = 0;
        if($data){
            foreach ($data as $product) {
                $price = $product['price'] ?: 0;
                $totalPrice = bcadd($totalPrice,$price,2);
            }
        }
        return $totalPrice;
    }

    /***
     * @param array $data
     * @param string $sort_key
     * @param string $filter_type
     * @param string $filter_name
     * @param int $options
     * @param int $descending
     * @return array
     */
    public function sortProducts(array $data, string $sort_key='', string $filter_type='', string $filter_name='', int $options = SORT_REGULAR, int $descending = SORT_DESC): array
    {
        //cut array depend filter_key
        $results = [];
        if($data && $filter_type && $filter_name){
            foreach ($data as $datum) {
                if($datum[$filter_type] == $filter_name){
                    $results[] = $datum;
                }
            }
        }else{
            $results = $data;
        }
        //sort by sort_key on $return
        if($results && $sort_key){
            $data_key = array_column($results,$sort_key);
            array_multisort($data_key, $descending, $results, $options);
        }
        return $results;
    }

    /***
     * @param $data
     * @return mixed
     */
    public function productsMap($data){
        return map(function ($value, $key) {
            $value['create_at'] = strtotime($value['create_at']);
            return $value;
        },$data);
    }

    public function map(callable $callback,$data)
    {
        $keys = array_keys($data);
        $items = array_map($callback, $data, $keys);
        return array_combine($keys, $items);
    }
}