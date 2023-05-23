<?php

namespace App\Collection;
use App\Entity\Order;

class OrdersCollection extends \ArrayObject
{
    /**
     * Find orders using multiple properties, looking for part of a string
     *
     * @param array $search Map to search, with property as key and value to search
     * @return OrdersCollection Copy of filtered collection
     */
    public function findContainingAnyOf(array $search): OrdersCollection
    {
        $found = [];

        foreach ($this as $order) {
            foreach ($search as $property => $valuePar) {
                $searchValue = strtolower($valuePar);
                $propertyValue = strtolower((string)$order->$property);

                if (str_contains($propertyValue, $searchValue)) {
                    $found[] = $order;
                    break;
                }
            }
        }

        return new OrdersCollection($found);
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
