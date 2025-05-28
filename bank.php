<?php
require_once 'BankAccount.php';
require_once 'db.php';
session_start();

if (!isset($_SESSION['account'])) {
    $_SESSION['account'] = new BankAccount();
}

$account = $_SESSION['account'];

$name = $_POST['name'] ?? '';
$operation = $_POST['operation'] ?? '';
$amount = floatval($_POST['amount'] ?? 0);
$message = '';

if ($name && $operation && $amount > 0) {
    setcookie('client_name', $name, time() + (86400 * 30), "/");
    $success = false;

    if ($operation === 'deposit') {
        $account->deposit($amount);
        $message = "Cześć $name! Wpłacono $amount PLN.";
        $success = true;
    } elseif ($operation === 'withdraw') {
        if ($account->withdraw($amount)) {
            $message = "Cześć $name! Wypłacono $amount PLN.";
            $success = true;
        } else {
            $message = "Cześć $name! Brak środków na koncie.";
        }
    }

    if ($success) {
        $stmt = $conn->prepare("INSERT INTO transactions (client_name, operation_type, amount, balance_after) VALUES (?, ?, ?, ?)");
        $balance = $account->getBalance();
        $stmt->bind_param("ssdd", $name, $operation, $amount, $balance);
        $stmt->execute();
    }

    $_SESSION['account'] = $account;
} else {
    $message = "Nieprawidłowe dane.";
}

header("Location: index.php?message=" . urlencode($message));
exit();
