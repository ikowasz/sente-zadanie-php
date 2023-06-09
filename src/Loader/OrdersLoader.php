<?php

namespace App\Loader;

use App\Entity\Order;

/**
 * Class responsible for loading orders from data file
 */
class OrdersLoader
{
    public function __construct(
        private string $dataDirectory,
        private string $ordersDataFilename,
    ) {}

    /**
     * Load data file to orders array
     *
     * @return array Array of orders
     */
    public function getOrders(): array
    {
        try {
            return array_map(fn($props): Order => new Order($props), $this->getData());
        } catch (\ErrorException) {
            return [];
        }
    }

    /**
     * Decode json from data file
     *
     * @return array Array with data from the file
     */
    private function getData(): array
    {
        $json = $this->getDataFileContents();
        $data = \json_decode($json, true);

        return $data;
    }

    /**
     * Load contents from data file
     *
     * @return string Data file contents
     */
    private function getDataFileContents(): string
    {
        return \file_get_contents("{$this->dataDirectory}/{$this->ordersDataFilename}");
    }
}
