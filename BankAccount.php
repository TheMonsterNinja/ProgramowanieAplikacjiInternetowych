<?php

class BankAccount {
    private float $balance;

    public function __construct(float $initial = 1000.00) {
        $this->balance = $initial;
    }

    public function deposit(float $amount) {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): bool {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }

    public function getBalance(): float {
        return $this->balance;
    }
}
