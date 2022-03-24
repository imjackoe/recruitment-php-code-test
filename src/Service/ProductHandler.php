<?php

namespace App\Service;

class ProductHandler
{


    /**
     * 检查类型是否为 Dessert
     * @param array $products 查找的数组
     * @param string $field 要比对的字段
     * @param string $value 字段值
     * @return array
     */
	public function findByTypeEqDessert($products, $field, $value)
	{
 		$data = array_filter($products, function($item) use ($field, $value) {
            if (isset($item[$field])) {
                return $item[$field] == $value;
            }
        });
 		return $data;
	}

	public function unixTimeStamp(&$item)
	{
        $item["create_at"] = strtotime($item["create_at"]);
        $item = $item;
	}

    /**
     * 计算商品总金额
     * @return array
     */
	public function getTotalPrice($products)
	{
		return array_sum(array_column($products, "price"));
	}

    /**
     * 商品价格由大到小排序
     * @return array
     */
	public function getSortPrice($products, $field, $value)
	{
		$dessertArray = $this->findByTypeEqDessert($products, $field, $value);
		array_multisort(array_column($dessertArray, "price"), SORT_DESC, $dessertArray);
		return $dessertArray;
	}

    /**
     * 转换为时间戳
     * @return array
     */
	public function formatToUnixTimeStamp($products)
	{
		array_walk($products, array($this, "unixTimeStamp"));
		return $products;
	}

}