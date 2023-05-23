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
     * Find order symbols and reference ids using needle
     *
     * @param string $needle String to search for
     * @return Order|null Found order or null if nothing found
     */
    public function findBySymbolOrRef(string $needle): ?Order
    {
        foreach ($this->getOrders() as $order) {
            if (
                (string)$order->getRef() === $needle
                || $order->getSymbol() === $needle 
            ) {
                return $order;
            }
        }

        return null;
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