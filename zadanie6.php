<?php
/*
Struktura bazy danych (MySQL):

CREATE DATABASE szkola;
USE szkola;

CREATE TABLE uczniowie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(100) NOT NULL,
    nazwisko VARCHAR(100) NOT NULL
);
*/

$host = 'localhost';
$db = 'szkola';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Dodawanie nowego ucznia
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $imie = $conn->real_escape_string($_POST['imie']);
    $nazwisko = $conn->real_escape_string($_POST['nazwisko']);

    $sql = "INSERT INTO uczniowie (imie, nazwisko) VALUES ('$imie', '$nazwisko')";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM uczniowie");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Baza uczniów</title>
</head>
<body>

<h2>Dodaj ucznia</h2>
<form method="POST">
    <input type="text" name="imie" placeholder="Imię" required>
    <input type="text" name="nazwisko" placeholder="Nazwisko" required>
    <button type="submit">Zapisz</button>
</form>

<h2>Lista uczniów:</h2>
<ul>
<?php while($row = $result->fetch_assoc()): ?>
    <li><?= htmlspecialchars($row['imie']) . " " . htmlspecialchars($row['nazwisko']) ?></li>
<?php endwhile; ?>
</ul>

</body>
</html>

<?php
$conn->close();
?>
