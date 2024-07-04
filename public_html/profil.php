<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('con.fig.php');

// Zmienna na komunikaty o błędach lub sukcesach
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = mysqli_real_escape_string($link, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($link, $_POST['new_password']);
    $confirm_new_password = mysqli_real_escape_string($link, $_POST['confirm_new_password']);

    // Sprawdzenie, czy nowe hasła są zgodne
    if ($new_password !== $confirm_new_password) {
        $message = "Nowe hasła nie są zgodne.";
    } else {
        // Pobranie obecnego hasła z bazy danych
        $sql = "SELECT password FROM {$prefix}_users WHERE id = $user_id";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            // Sprawdzenie, czy podane obecne hasło jest poprawne
            if (password_verify($current_password, $hashed_password)) {
                // Zapisanie nowego hasła do bazy danych
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update = "UPDATE {$prefix}_users SET password = '$new_hashed_password' WHERE id = $user_id";
                if (mysqli_query($link, $sql_update)) {
                    $message = "Hasło zostało zmienione.";
                } else {
                    $message = "Błąd podczas zmiany hasła: " . mysqli_error($link);
                }
            } else {
                $message = "Obecne hasło jest nieprawidłowe.";
            }
        } else {
            $message = "Błąd podczas pobierania hasła: " . mysqli_error($link);
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Zmiana hasła</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="contact-box">
        <form action="profil.php" method="post">
            <h1>Zmiana hasła</h1>
            <?php if (!empty($message)) { echo "<p style='color:red;'>$message</p>"; } ?>
            <input type="password" class="input-field" name="current_password" placeholder="Obecne hasło" required>
            <input type="password" class="input-field" name="new_password" placeholder="Nowe hasło" required>
            <input type="password" class="input-field" name="confirm_new_password" placeholder="Potwierdź nowe hasło" required>
            <button type="submit" class="btn">Zmień hasło</button>
        </form>
    </div>
</body>
</html>
