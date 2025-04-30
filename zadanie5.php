<?php
session_start();

interface UzytkownikInterface {
    public function loguj($login);
    public function wyloguj();
    public function getLogin();
}

class Uzytkownik implements UzytkownikInterface {
    private $login;

    public function loguj($login) {
        $this->login = $login;
        $_SESSION['login'] = $login;
        setcookie("ostatni_login", $login, time() + 3600, "/"); // 1h
    }

    public function wyloguj() {
        unset($_SESSION['login']);
        $this->login = null;
    }

    public function getLogin() {
        return $this->login ?? $_SESSION['login'] ?? null;
    }
}

$uzytkownik = new Uzytkownik();

// Obsługa formularza logowania
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $uzytkownik->loguj(trim($_POST['login']));
    } elseif (isset($_POST['logout'])) {
        $uzytkownik->wyloguj();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sesja i Ciasteczka</title>
</head>
<body>

<h2>System logowania</h2>

<?php if ($login = $uzytkownik->getLogin()): ?>
    <p>Witaj, <strong><?= htmlspecialchars($login) ?></strong>!</p>
    <form method="post">
        <button type="submit" name="logout">Wyloguj się</button>
    </form>
<?php else: ?>
    <form method="post">
        <label>Login:
            <input type="text" name="login" required>
        </label>
        <button type="submit">Zaloguj się</button>
    </form>
<?php endif; ?>

<?php if (isset($_COOKIE['ostatni_login'])): ?>
    <p><em>Ostatnio logowałeś się jako: <?= htmlspecialchars($_COOKIE['ostatni_login']) ?></em></p>
<?php endif; ?>

</body>
</html>
