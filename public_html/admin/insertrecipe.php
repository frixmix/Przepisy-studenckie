<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $category = mysqli_real_escape_string($link, $_POST['category']);
    $prep_time = mysqli_real_escape_string($link, $_POST['prep_time']);
    $image = mysqli_real_escape_string($link, $_POST['image']);
    $ingredients = mysqli_real_escape_string($link, str_replace("\r\n", "\\n", $_POST['ingredients']));
    $instructions = mysqli_real_escape_string($link, str_replace("\r\n", "\\n", $_POST['instructions']));

    $prefix_recipes = "{$prefix}_recipes";

    $sql_insert = "
        INSERT INTO $prefix_recipes (title, category, prep_time, image, ingredients, instructions)
        VALUES ('$title', '$category', '$prep_time', '$image', '$ingredients', '$instructions')";

    if (mysqli_query($link, $sql_insert)) {
        header("Location: edycja.php");
    } else {
        echo "Błąd podczas dodawania przepisu: " . mysqli_error($link);
    }
}
mysqli_close($link);

