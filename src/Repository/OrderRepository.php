<?php

namespace App\Repository;

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
     * @return array
     */
    public function findAll(): array
    {
        return $this->getOrders();
    }

    /**
     * Retrieve orders from loader
     *
     * @return array
     */
    private function getOrders(): array
    {
        return $this->loader->getOrders();
    }
}