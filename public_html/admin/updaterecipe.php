<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

$prefix_recipes = "{$prefix}_recipes";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $category = mysqli_real_escape_string($link, $_POST['category']);
    $prep_time = mysqli_real_escape_string($link, $_POST['prep_time']);
    $image = mysqli_real_escape_string($link, $_POST['image']);
    $ingredients = mysqli_real_escape_string($link, str_replace("\r\n", "\\n", $_POST['ingredients']));
    $instructions = mysqli_real_escape_string($link, str_replace("\r\n", "\\n", $_POST['instructions']));

    $sql_update = "
        UPDATE $prefix_recipes
        SET title = '$title', category = '$category', prep_time = '$prep_time', image = '$image', ingredients = '$ingredients', instructions = '$instructions'
        WHERE id = $id";

    if (mysqli_query($link, $sql_update)) {
        header("Location: edycja.php");
    } else {
        echo "Błąd podczas aktualizacji przepisu: " . mysqli_error($link);
    }
}
mysqli_close($link);

