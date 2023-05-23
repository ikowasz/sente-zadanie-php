<?php

namespace App\Entity;

class Order
{
    /**
     * Reference identifier
     *
     * @var integer
     */
    public readonly int $ref;

    /**
     * Client name
     *
     * @var string
     */
    public readonly string $client_name;

    /**
     * Order registration date
     *
     * @var \DateTimeInterface
     */
    public readonly \DateTimeInterface $regdate;

    /**
     * Order symbol
     *
     * @var string
     */
    public readonly string $symbol;

    /**
     * Order send date
     *
     * @var \DateTimeInterface
     */
    public readonly \DateTimeInterface $send_date;

    /**
     * Is order invoiced
     *
     * @var boolean
     */
    public readonly bool $invoiced;

    public function __construct($data)
    {
        $this->set($data);
    }

    /**
     * Setinitial order data
     */
    private function set(array $data): void
    {
        $this->ref = intval($data['ref']);
        $this->client_name = $data['client_name'];
        $this->regdate = new \DateTime($data['regdate']);
        $this->symbol = $data['symbol'];
        $this->send_date = new \DateTime($data['send_date']);
        $this->invoiced = !!$data['invoiced'];
    }
}