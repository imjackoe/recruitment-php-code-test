<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ProductHandler;

/**
 * Class ProductHandlerTest
 *
 */
class ProductHandlerTest extends TestCase
{
    /**
     * 测试商品数组
     *
     * @var array[]
     */
    private $products = [
        [
            'id' => 1,
            'name' => 'Coca-cola',
            'type' => 'Drinks',
            'price' => 10,
            'create_at' => '2021-04-20 10:00:00',
        ],
        [
            'id' => 2,
            'name' => 'Persi',
            'type' => 'Drinks',
            'price' => 5,
            'create_at' => '2021-04-21 09:00:00',
        ],
        [
            'id' => 3,
            'name' => 'Ham Sandwich',
            'type' => 'Sandwich',
            'price' => 45,
            'create_at' => '2021-04-20 19:00:00',
        ],
        [
            'id' => 4,
            'name' => 'Cup cake',
            'type' => 'Dessert',
            'price' => 35,
            'create_at' => '2021-04-18 08:45:00',
        ],
        [
            'id' => 5,
            'name' => 'New York Cheese Cake',
            'type' => 'Dessert',
            'price' => 40,
            'create_at' => '2021-04-19 14:38:00',
        ],
        [
            'id' => 6,
            'name' => 'Lemon Tea',
            'type' => 'Drinks',
            'price' => 8,
            'create_at' => '2021-04-04 19:23:00',
        ],
    ];

    /**
     * 测试商品总价
     *
     * @return void
     */
    public function testGetTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }

        $this->assertEquals(143, $totalPrice);
    }

    /**
     * 用商品处理类，foreach方式，测试商品总价
     *
     * @return void
     */
    public function testGetTotalPrice1()
    {
        $products   = new ProductHandler($this->products);

        $totalPrice = 0;
        foreach ($products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }
        // print_r($products[0]);
        // print_r($products[1]);
        $this->assertEquals(
            [
                'id' => 1,
                'name' => 'Coca-cola',
                'type' => 'Drinks',
                'price' => 10,
                'create_at' => '2021-04-20 10:00:00',
            ], $products[0]);

        $this->assertEquals(143, $totalPrice);
    }

    /**
     * 测试商品处理类totalPrice方法是否正确
     *
     * @return void
     */
    public function testGetTotalPrice2()
    {
        $products   = new ProductHandler($this->products);

        $this->assertEquals(143, $products->totalPrice());
    }

    /**
     * 测试商品处理类orderByPrice方法是否正确
     *
     * @return void
     */
    public function testOrderByPrice()
    {
        $products   = new ProductHandler($this->products);

        $this->assertEquals([
            4 => [
                'id' => 5,
                'name' => 'New York Cheese Cake',
                'type' => 'Dessert',
                'price' => 40,
                'create_at' => '2021-04-19 14:38:00',
            ],
            3 => [
                'id' => 4,
                'name' => 'Cup cake',
                'type' => 'Dessert',
                'price' => 35,
                'create_at' => '2021-04-18 08:45:00',
            ],
        ], $products->orderByPrice('dessert'));
    }

    /**
     * 测试商品处理类toUnixTimestamp方法是否正确
     *
     * @return void
     */
    public function testToUnixTimestamp()
    {
        $products   = new ProductHandler($this->products);
        $products->toUnixTimestamp();

        $this->assertEquals([
            [
                'id' => 1,
                'name' => 'Coca-cola',
                'type' => 'Drinks',
                'price' => 10,
                'create_at' => 1618905600,
            ],
            [
                'id' => 2,
                'name' => 'Persi',
                'type' => 'Drinks',
                'price' => 5,
                'create_at' => 1618988400,
            ],
            [
                'id' => 3,
                'name' => 'Ham Sandwich',
                'type' => 'Sandwich',
                'price' => 45,
                'create_at' => 1618938000,
            ],
            [
                'id' => 4,
                'name' => 'Cup cake',
                'type' => 'Dessert',
                'price' => 35,
                'create_at' => 1618728300,
            ],
            [
                'id' => 5,
                'name' => 'New York Cheese Cake',
                'type' => 'Dessert',
                'price' => 40,
                'create_at' => 1618835880,
            ],
            [
                'id' => 6,
                'name' => 'Lemon Tea',
                'type' => 'Drinks',
                'price' => 8,
                'create_at' => 1617556980,
            ],
        ], $products->toArray());
    }
}