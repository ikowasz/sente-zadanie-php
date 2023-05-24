<?php

namespace App\Collection;

use App\Enum\SortDirection;

class OrdersCollection extends \ArrayObject
{
    /**
     * Filter orders using multiple properties, looking for part of a string
     *
     * @param array $search Map to search, with property as key and value to search
     * @return self
     */
    public function filterContainingAnyOf(array $search): self
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

        $this->exchangeArray($found);

        return $this;
    }

    /**
     * Sort collection by property
     * 
     * @param string $property Name of property to sort by
     * @return self
     */
    public function sortBy(string $property, SortDirection $direction = SortDirection::ASC): self
    {
        $orders = $this->getArrayCopy();

        usort($orders, fn($a, $b): int =>
            ($direction === SortDirection::ASC)
                ? $a->$property <=> $b->$property
                : $b->$property <=> $a->$property
        );

        $this->exchangeArray($orders);

        return $this;
    }
}
