<?php

namespace OneMoreAngle\Marshaller\Test\Fixtures;

class Order {
    private int $id;
    private string $name;
    private float $price;
    private bool $paid;
    private ?string $description = null;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void {
        $this->price = $price;
    }

    /**
     * @return bool
     */
    public function paid(): bool {
        return $this->paid;
    }

    /**
     * @param bool $paid
     */
    public function setPaid(bool $paid): void {
        $this->paid = $paid;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function equals(Order $order): bool {
        return $this->id === $order->id && $this->name === $order->name && $this->price === $order->price && $this->paid === $order->paid && $this->description === $order->description;
    }
}