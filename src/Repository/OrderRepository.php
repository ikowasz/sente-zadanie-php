<?php

namespace App\Repository;

use App\Entity\Order;

class OrderRepository
{
    public function __construct(
        private string $dataDirectory,
    ) {}

    public function findAll()
    {
        return $this->getOrders();
    }

    private function getOrders(): array
    {
        $orders = [];

        foreach ($this->getData() as $orderData) {
            $order = new Order($orderData);
            $orders[] = $order;
        }

        return $orders;
    }

    private function getData(): array
    {
        $json = $this->getDataFileContents();
        $data = \json_decode($json, true);

        return $data;
    }

    private function getDataFileContents(): string
    {
        return \file_get_contents("{$this->dataDirectory}/naglowki_zamowienia.json");
    }
}