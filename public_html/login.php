<?php
session_start();
include('con.fig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Przygotowanie zapytania
    $table = $prefix . "_users";
    $sql = "SELECT id, username, password, role FROM $table WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }
    
    $row = mysqli_fetch_assoc($result);
    
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        if ($row['role'] == 'admin') {
            header("Location: admin/adminpanel.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Przepisy studenckie</title>
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
            <form action="login.php" method="post">
                <h2>Login</h2>
                <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                <div class="input-group">
                    <input type="text" name="username" required>
                    <label for="">Nazwa użytkownika</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label for="">Hasło</label>
                </div>
                <div class="remember">
                    <label for=""><input type="checkbox">Zapamietaj hasło!</label>
                </div>
                <button type="submit">Zaloguj</button>
                <div class="back">
                    <p><a href="index.php" class="backBtn">Powrót</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
