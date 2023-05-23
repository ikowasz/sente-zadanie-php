<?php

namespace App\Collection;
use App\Entity\Order;

class OrdersCollection extends \ArrayObject
{
    /**
     * Find order using property name and it's value
     * 
     * @param string $property Name of property to compare
     * @param mixed $value Value to search for
     * @return Order|null Found order or null if nothing found
     */
    public function findBy(string $property, $value): ?Order
    {
        foreach ($this as $order) {
            if ($order->$property == $value) {
                return $order;
            }
        }

        return null;
    }

    /**
     * Sort collection by property
     * 
     * @param string $property Name of property to sort by
     * @return OrdersCollection Sorted collection copy
     */
    public function sortBy(string $property): OrdersCollection
    {
        $orders = $this->getArrayCopy();

        usort($orders, fn($a, $b): int => $a->$property <=> $b->$property);

        return new OrdersCollection($orders);
    }
}