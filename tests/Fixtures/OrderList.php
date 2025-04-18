<?php

namespace OneMoreAngle\Marshaller\Test\Fixtures;

class OrderList {

    protected int $id;

    /**
     * @var Order[] $orders
     */
    protected array $orders;

    protected Order $mainOrder;
    protected string $status;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getOrders(): array {
        return $this->orders;
    }

    public function setOrders(array $orders): void {
        $this->orders = $orders;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getMainOrder(): Order {
        return $this->mainOrder;
    }

    public function setMainOrder(Order $mainOrder): void {
        $this->mainOrder = $mainOrder;
    }

    public function equals(OrderList $orderList): bool {
        if ($this->id !== $orderList->getId()) {
            return false;
        }
        if ($this->status !== $orderList->getStatus()) {
            return false;
        }
        if (count($this->orders) !== count($orderList->getOrders())) {
            return false;
        }
        if (!$this->mainOrder->equals($orderList->getMainOrder())) {
            return false;
        }
        foreach ($this->orders as $index => $order) {
            if (!$order->equals($orderList->getOrders()[$index])) {
                return false;
            }
        }
        return true;
    }
}