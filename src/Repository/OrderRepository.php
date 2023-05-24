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
        return $this->getOrdersCollection();
    }

    /**
     * Get orders containing some text in either symbol or ref
     *
     * @param string $needle String to search for
     * @return OrdersCollection Collection of found orders
     */
    public function findBySymbolOrRef(string $needle): OrdersCollection
    {
        return $this->getOrdersCollection()
            ->filterContainingAnyOf([
                'symbol' => $needle,
                'ref' => $needle,
            ]);
    }

    /**
     * Retrieve orders from loader
     *
     * @return OrdersCollection
     */
    private function getOrdersCollection(): OrdersCollection
    {
        return new OrdersCollection($this->loader->getOrders());
    }
}
