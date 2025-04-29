<?php
class BankAccount {
    private $owner;
    private $balance;

    public function __construct($owner, $initialBalance = 0) {
        $this->owner = $owner;
        $this->balance = $initialBalance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Wpłacono: $amount PLN<br>";
        }
    }

    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Wypłacono: $amount PLN<br>";
        } else {
            echo "Błąd: niewystarczające środki lub nieprawidłowa kwota<br>";
        }
    }

    public function getBalance() {
        return $this->balance;
    }

    public function getOwner() {
        return $this->owner;
    }
}

// Przykład użycia:
$konto = new BankAccount("Mateusz", 1000);
echo "Właściciel konta: " . $konto->getOwner() . "<br>";
echo "Saldo początkowe: " . $konto->getBalance() . " PLN<br>";

$konto->deposit(500);
$konto->withdraw(300);

echo "Saldo końcowe: " . $konto->getBalance() . " PLN<br>";
?>
