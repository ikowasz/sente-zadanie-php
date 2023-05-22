<?php

namespace App\Entity;

class Order
{
    /**
     * Reference identifier
     *
     * @var integer
     */
    private int $ref;

    /**
     * Client name
     *
     * @var string
     */
    private string $client_name;

    /**
     * Order registration date
     *
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $regdate;

    /**
     * Order symbol
     *
     * @var string
     */
    private string $symbol;

    /**
     * Order send date
     *
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $send_date;

    /**
     * Is order invoiced
     *
     * @var boolean
     */
    private bool $invoiced;

    public function __construct($data)
    {
        $this->set($data);
    }

    public function set($data)
    {
        $this->ref = intval($data['ref']);
        $this->client_name = $data['client_name'];
        $this->regdate = new \DateTime($data['regdate']);
        $this->symbol = $data['symbol'];
        $this->send_date = new \DateTime($data['send_date']);
        $this->invoiced = !!$data['invoiced'];
    }

    /**
     * Get the value of ref
     */
    public function getRef(): int
    {
        return $this->ref;
    }

    /**
     * Get the value of client_name
     */
    public function getClientName(): string
    {
        return $this->client_name;
    }

    /**
     * Get the value of regdate
     */
    public function getRegdate(): \DateTimeInterface
    {
        return $this->regdate;
    }

    /**
     * Get the value of symbol
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * Get the value of send_date
     */
    public function getSendDate(): \DateTimeInterface
    {
        return $this->send_date;
    }

    /**
     * Get the value of invoiced
     */
    public function isInvoiced(): bool
    {
        return $this->invoiced;
    }
}