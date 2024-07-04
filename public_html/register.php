<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('con.fig.php');

// Dodajemy prefix do nazwy tabeli
$prefix_users = "{$prefix}_users";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($link, $_POST['confirm_password']);

    // Sprawdzenie, czy nazwa użytkownika zawiera wyłącznie dozwolone znaki i czy ma maksymalnie 20 znaków
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "Nazwa użytkownika może zawierać tylko litery, cyfry i znaki podkreślenia.";
    } elseif (strlen($username) > 20) {
        $error = "Nazwa użytkownika może mieć maksymalnie 20 znaków.";
    } elseif ($password !== $confirm_password) {
        $error = "Hasła nie są zgodne.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Sprawdzenie, czy użytkownik już istnieje
        $sql_check = "SELECT id FROM $prefix_users WHERE username = '$username' OR email = '$email'";
        $result_check = mysqli_query($link, $sql_check);

        if (!$result_check) {
            die("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }

        if (mysqli_num_rows($result_check) > 0) {
            $error = "Użytkownik o takiej nazwie lub e-mailu już istnieje.";
        } else {
            // Wstawianie użytkownika do bazy danych
            $sql = "INSERT INTO $prefix_users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
            if (mysqli_query($link, $sql)) {
                $success = "Rejestracja zakończona sukcesem!";
            } else {
                $error = "Błąd: " . mysqli_error($link);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - Przepisy studenckie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="wrapper">
        <div class="form-wrapper sign-in">
            <form action="register.php" method="post">
                <h2>Rejestracja</h2>
                <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                <?php if (isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
                <div class="input-group">
                    <input type="text" name="username" maxlength="20" required>
                    <label for="">Nazwa użytkownika</label>
                </div>
                <div class="input-group">
                    <input type="email" name="email" required>
                    <label for="">E-mail</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label for="">Hasło</label>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" required>
                    <label for="">Potwierdź hasło</label>
                </div>
                <button type="submit">Zarejestruj się</button>
                <div class="back">
                    <p><a href="index.php" class="backBtn">Powrót</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
