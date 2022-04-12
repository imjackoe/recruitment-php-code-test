<?php
namespace App\Service;
/**
 * 商品处理类
 *
 */
class ProductHandler implements \ArrayAccess, \Iterator
{
    /**
     * 数组下标
     * @var int
     */
    private $index = 0;
    /**
     * 商品列表
     * @var array
     */
    private $products = [];

    /**
     * 构造函数
     *
     * 如果不传商品，也可以通过数组赋值的方式添加
     *
     * $products = new ProductHandler;
     * $products[]  = [
        'id' => 1,
        'name' => 'Coca-cola',
        'type' => 'Drinks',
        'price' => 10,
        'create_at' => '2021-04-20 10:00:00',
     * ];
     * 商品列表
     * @param $products
     */
    public function __construct($products = [])
    {
        return $this->products  = $products;
    }

    /**
     * 统计总价
     *
     * @return float|int
     */
    public function totalPrice()
    {
        return array_sum(array_column($this->products, 'price'));
    }

    /**
     * 按照筛选商品，并且按照商品金额降序排列
     *
     * @param $type 类型
     * @return array|mixed
     */
    public function orderByPrice($type = “dessert”)
    {
        //忽略大小写
        $type = strtolower($type);
        //数组过滤
        $products   = array_filter($this->products, function($product) use ($type) {
            return strtolower($product['type']) == $type;
        });

        //数组排序
        uasort($products, function($product1, $product2) {
            if ($product1['price'] == $product2['price']) {
                return 0;
            }
            return ($product1['price'] < $product2['price']) ? 1 : -1;
        });

        return $products;
    }

    /**
     * 将商品创建日期，转换成时间戳
     *
     * @return void
     */
    public function toUnixTimestamp()
    {
        //这里需求中没有明确说明是对源数组转换，还是重新输出一个新数组。如果需要重新输出一个新数组，需要另做处理
        array_walk($this->products, function(&$product) {
            //避免重复转换
            if (!is_numeric($product['create_at'])) {
                $product['create_at']   = strtotime($product['create_at']);
            }
        });
    }

    /**
     * 设置一个偏移位置的值
     *
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->products[] = $value;
        } else {
            $this->products[$offset] = $value;
        }
    }

    /**
     * 检查一个偏移位置是否存在
     *
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->products[$offset]);
    }

    /**
     * 复位一个偏移位置的值
     *
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->products[$offset]);
    }

    /**
     * 获取一个偏移位置的值
     *
     * @param $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->products[$offset]) ? $this->products[$offset] : null;
    }

    /**
     * 返回到迭代器的第一个元素
     * @return void
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * 返回当前元素
     *
     * @return mixed
     */
    public function current()
    {
        return $this->products[$this->index];
    }

    /**
     * 返回当前元素的键
     *
     * @return bool|float|int|mixed|string|null
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * 向前移动到下一个元素
     * @return void
     */
    public function next() {
        ++$this->index;
    }

    /**
     * 检查当前位置是否有效
     * @return bool
     */
    public function valid()
    {
        return isset($this->products[$this->index]);
    }

    /**
     * 将对象转换成数组
     *
     * @return array|mixed
     */
    public function toArray()
    {
        return $this->products;
    }
}