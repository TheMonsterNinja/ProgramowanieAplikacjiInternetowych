<?php
require_once 'BankAccount.php';
require_once 'db.php';
session_start();

$saldo = isset($_SESSION['account']) ? $_SESSION['account']->getBalance() : 1000.00;
$message = $_GET['message'] ?? '';
$clientName = $_COOKIE['client_name'] ?? '';

// Pobieranie historii transakcji
$transactions = [];
if ($clientName) {
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE client_name = ? ORDER BY operation_time DESC");
    $stmt->bind_param("s", $clientName);
    $stmt->execute();
    $transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>System Bankowy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, input, select, button {
            margin: 10px 0;
        }
        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .result, .saldo {
            margin-top: 20px;
            padding: 10px;
            background-color: #e7f3e7;
            border: 1px solid #c3e6c3;
            border-radius: 4px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>System Bankowy</h1>

        <div class="saldo">
            Aktualne saldo: <strong><?= number_format($saldo, 2) ?> PLN</strong>
        </div>

        <?php if ($message): ?>
        <div class="result">
            <?= htmlspecialchars($message) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="bank.php">
            <label for="name">Imię:</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($clientName) ?>">

            <label for="operation">Operacja:</label>
            <select name="operation" required>
                <option value="deposit">Wpłata</option>
                <option value="withdraw">Wypłata</option>
            </select>

            <label for="amount">Kwota (PLN):</label>
            <input type="number" name="amount" step="0.01" required>

            <button type="submit">Wykonaj</button>
        </form>

        <?php if (!empty($transactions)): ?>
            <h2>Historia transakcji</h2>
            <table>
                <tr>
                    <th>Data</th>
                    <th>Typ</th>
                    <th>Kwota</th>
                    <th>Saldo po operacji</th>
                </tr>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= $t['operation_time'] ?></td>
                    <td><?= $t['operation_type'] ?></td>
                    <td><?= number_format($t['amount'], 2) ?> PLN</td>
                    <td><?= number_format($t['balance_after'], 2) ?> PLN</td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
