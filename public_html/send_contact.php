<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieranie danych z formularza
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Debugowanie - sprawdzenie, czy dane są pobierane
    echo "Dane z formularza:<br>";
    echo "Imię: $firstName<br>";
    echo "Nazwisko: $lastName<br>";
    echo "Email: $email<br>";
    echo "Temat: $subject<br>";
    echo "Wiadomość: $message<br>";

    $to = "szymonekpl@op.pl"; // Zastąp swoim adresem e-mail
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $fullMessage = "<p>Wiadomość od: $firstName $lastName</p>";
    $fullMessage .= "<p>Email: $email</p>";
    $fullMessage .= "<p>Temat: $subject</p>";
    $fullMessage .= "<p>Wiadomość:</p>";
    $fullMessage .= "<p>$message</p>";

    // Debugowanie - sprawdzenie, czy wiadomość jest wysyłana
    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "Wiadomość została wysłana.";
    } else {
        echo "Wystąpił błąd podczas wysyłania wiadomości.";
        // Dodatkowe debugowanie
        if (!function_exists('mail')) {
            echo "Funkcja mail() nie jest włączona na serwerze.";
        } else {
            echo "Funkcja mail() jest włączona na serwerze, ale wiadomość nie została wysłana.";
        }
    }
} else {
    echo "Nieprawidłowe żądanie.";
}

