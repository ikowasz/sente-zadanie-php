<?php

namespace App\Repository;

use App\Collection\OrdersCollection;
use App\Loader\OrdersLoader;
use App\Entity\Order;

class OrderRepository
{
    public function __construct(
        private OrdersLoader $loader,
    ) {}

    /**
     * Get all orders
     *
     * @return OrdersCollection Collection with all orders
     */
    public function findAll(): OrdersCollection
    {
        return $this->getOrders();
    }

    /**
     * Find order symbols and reference ids using needle
     *
     * @param string $needle String to search for
     * @return Order|null Found order or null if nothing found
     */
    public function findBySymbolOrRef(string $needle): OrdersCollection
    {
        return $this->getOrders()->findContainingAnyOf([
            'symbol' => $needle,
            'ref' => $needle,
        ]);
    }

    /**
     * Retrieve orders from loader
     *
     * @return OrdersCollection
     */
    private function getOrders(): OrdersCollection
    {
        $orders = $this->loader->getOrders();

        return new OrdersCollection($orders);
    }
}
