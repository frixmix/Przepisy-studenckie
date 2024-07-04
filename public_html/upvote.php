<?php
session_start();
include('con.fig.php');

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby oceniać przepisy.");
}

if (isset($_POST['recipe_id'])) {
    $recipe_id = intval($_POST['recipe_id']);
    $prefix_recipes = "{$prefix}_recipes";

    $sql = "UPDATE $prefix_recipes SET upvotes = upvotes + 1 WHERE id = $recipe_id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }

    header("Location: przepis.php?id=$recipe_id");
    exit();
} else {
    die("Nieprawidłowy parametr!");
}

