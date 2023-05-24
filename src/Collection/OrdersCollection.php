<?php

namespace App\Collection;

use App\Enum\SortDirection;

/**
 * Intermediate class for orders set management
 */
class OrdersCollection extends \ArrayObject
{
    /**
     * Remove from the set every order in which none of given properties contains given value
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
