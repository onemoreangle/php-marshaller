<?php

namespace OneMoreAngle\Marshaller\Test\Fixtures;

use OneMoreAngle\Marshaller\Attribute\Name;

class AnnotatedOrder {
    /**
     * @Name("orderId")
     * @var int
     */
    #[Name("orderId")]
    private int $id;

    /**
     * @Name("orderName")
     * @var string
     */
    #[Name("orderName")]
    private string $name;

    /**
     * @Name("orderPrice")
     * @var float
     */
    #[Name("orderPrice")]
    private float $price;

    /**
     * @Name("orderPaid")
     * @var bool
     */
    #[Name("orderPaid")]
    private bool $paid;

    /**
     * @Name("orderDescription")
     * @var string|null
     */
    #[Name("orderDescription")]
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
    public function isPaid(): bool {
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

    public function equals(AnnotatedOrder $order): bool {
        return $this->getId() === $order->getId()
            && $this->getName() === $order->getName()
            && $this->getPrice() === $order->getPrice()
            && $this->isPaid() === $order->isPaid() && $this->getDescription() === $order->getDescription();
    }
}