<?php

namespace Test\Service;

use App\Service\ProductHandler;
use PHPUnit\Framework\TestCase;

class ProductHandlerTest2 extends TestCase
{
    private $products = [
        [
            'id'        => 1,
            'name'      => 'Coca-cola',
            'type'      => 'Drinks',
            'price'     => 10,
            'create_at' => '2021-04-20 10:00:00',
        ],
        [
            'id'        => 2,
            'name'      => 'Persi',
            'type'      => 'Drinks',
            'price'     => 5,
            'create_at' => '2021-04-21 09:00:00',
        ],
        [
            'id'        => 3,
            'name'      => 'Ham Sandwich',
            'type'      => 'Sandwich',
            'price'     => 45,
            'create_at' => '2021-04-20 19:00:00',
        ],
        [
            'id'        => 4,
            'name'      => 'Cup cake',
            'type'      => 'Dessert',
            'price'     => 35,
            'create_at' => '2021-04-18 08:45:00',
        ],
        [
            'id'        => 5,
            'name'      => 'New York Cheese Cake',
            'type'      => 'Dessert',
            'price'     => 40,
            'create_at' => '2021-04-19 14:38:00',
        ],
        [
            'id'        => 6,
            'name'      => 'Lemon Tea',
            'type'      => 'Drinks',
            'price'     => 8,
            'create_at' => '2021-04-04 19:23:00',
        ],
    ];

    private $productHandler;

    protected function setUp(): void
    {
        $this->productHandler = new ProductHandler();
    }

    protected function tearDown(): void
    {
        $this->productHandler = null;
    }

    public function testGetTotalPrice()
    {
        $totalPrice = $this->productHandler->getTotalPrice($this->products);
        $this->assertSame(143.0, $totalPrice);
    }

    public function testSortPriceByProductType()
    {
        $products     = $this->data();
        $sortProducts = $this->productHandler->sortPriceByProductType($this->products, 'Dessert', 'DESC');
        $this->assertTrue($sortProducts == $products);
    }

    public function testFormatUnixTime()
    {
        $products = $this->productHandler->formatUnixTime($this->products);
        $this->assertTrue(1618912800 == $products[0]['create_at']);
    }

    private function data(): array
    {
        return [
            1 => [
                'id'        => 5,
                'name'      => 'New York Cheese Cake',
                'type'      => 'Dessert',
                'price'     => 40,
                'create_at' => '2021-04-19 14:38:00',
            ],
            0 => [
                'id'        => 4,
                'name'      => 'Cup cake',
                'type'      => 'Dessert',
                'price'     => 35,
                'create_at' => '2021-04-18 08:45:00',
            ],
        ];
    }
}
