<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = intval($_POST['recipe_id']);
    $description = mysqli_real_escape_string($link, $_POST['description']);

    if (strlen($description) > 90) {
        die("Opis nie może przekraczać 90 znaków.");
    }

    $prefix_featured_recipes = "{$prefix}_featured_recipes";

    $sql_insert = "
        INSERT INTO $prefix_featured_recipes (recipe_id, description)
        VALUES ($recipe_id, '$description')";

    if (mysqli_query($link, $sql_insert)) {
        header("Location: featured.php");
        exit();
    } else {
        echo "Błąd podczas dodawania promowanego przepisu: " . mysqli_error($link);
    }
}
mysqli_close($link);

