<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $category = mysqli_real_escape_string($link, $_POST['category']);
    $prep_time = mysqli_real_escape_string($link, $_POST['prep_time']);
    $ingredients = mysqli_real_escape_string($link, str_replace("\r\n", "\\n", $_POST['ingredients']));
    $instructions = mysqli_real_escape_string($link, str_replace("\r\n", "\\n", $_POST['instructions']));
    
    $image = $_FILES['image'];
    $imageName = time() . '_' . basename($image['name']);
    $targetDir = "/home/students/inf2025/frixmix/public_html/images/";
    $targetFilePath = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Sprawdzenie, czy plik jest obrazkiem
    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        die("Plik nie jest obrazkiem.");
    }

    // Sprawdzenie rozmiaru pliku
    if ($image['size'] > 5000000) {
        die("Plik jest za duży.");
    }

    // Zezwalaj na określone formaty plików
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedTypes)) {
        die("Dozwolone są tylko pliki JPG, JPEG, PNG i GIF.");
    }

    // Debugowanie uprawnień katalogu
    if (!is_writable($targetDir)) {
        die("Katalog docelowy nie ma odpowiednich uprawnień do zapisu.");
    }

    // Przeniesienie pliku do katalogu docelowego
    if (!move_uploaded_file($image['tmp_name'], $targetFilePath)) {
        die("Wystąpił błąd podczas wgrywania pliku. Błąd: " . $_FILES['image']['error']);
    }

    $imagePath = "images/" . $imageName;

    $sql_insert = "
        INSERT INTO {$prefix}_recipes (title, category, prep_time, image, ingredients, instructions)
        VALUES ('$title', '$category', '$prep_time', '$imagePath', '$ingredients', '$instructions')";

    if (mysqli_query($link, $sql_insert)) {
        header("Location: edycja.php");
        exit();
    } else {
        echo "Błąd podczas dodawania przepisu: " . mysqli_error($link);
    }
}
mysqli_close($link);

