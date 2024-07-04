<?php
session_start();
include('con.fig.php');

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby dodawać lub usuwać przepisy z ulubionych.");
}

if (isset($_POST['recipe_id']) && isset($_POST['action'])) {
    $recipe_id = intval($_POST['recipe_id']);
    $user_id = intval($_SESSION['user_id']);
    $prefix_favorites = "{$prefix}_favorites";

    if ($_POST['action'] == 'add') {
        // Sprawdzenie, czy użytkownik już dodał ten przepis do ulubionych
        $check_sql = "SELECT * FROM $prefix_favorites WHERE user_id = $user_id AND recipe_id = $recipe_id";
        $check_result = mysqli_query($link, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            die("Ten przepis jest już w Twoich ulubionych.");
        }

        // Dodanie przepisu do ulubionych
        $insert_sql = "INSERT INTO $prefix_favorites (user_id, recipe_id) VALUES ($user_id, $recipe_id)";
        mysqli_query($link, $insert_sql);
    } elseif ($_POST['action'] == 'remove') {
        // Usunięcie przepisu z ulubionych
        $delete_sql = "DELETE FROM $prefix_favorites WHERE user_id = $user_id AND recipe_id = $recipe_id";
        mysqli_query($link, $delete_sql);
    }

    header("Location: przepis.php?id=$recipe_id");
    exit();
} else {
    die("Nieprawidłowy parametr!");
}

