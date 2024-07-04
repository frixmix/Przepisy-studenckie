<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $featured_id = intval($_POST['id']);
    $prefix_featured_recipes = "{$prefix}_featured_recipes";

    // Sprawdź liczbę wpisów w tabeli promowanych przepisów
    $sql_count = "SELECT COUNT(*) as count FROM $prefix_featured_recipes";
    $result_count = mysqli_query($link, $sql_count);
    if (!$result_count) {
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }
    $count = mysqli_fetch_assoc($result_count)['count'];

    if ($count > 1) {
        // Usuń wpis tylko jeśli w tabeli jest więcej niż jeden wpis
        $sql_delete_featured = "DELETE FROM $prefix_featured_recipes WHERE id = $featured_id";

        if (mysqli_query($link, $sql_delete_featured)) {
            header("Location: featured.php");
            exit();
        } else {
            echo "Błąd podczas usuwania promowanego przepisu: " . mysqli_error($link);
        }
    } else {
        echo "Nie można tego usunąć, ponieważ musi być co najmniej jeden promowany przepis.";
    }
}
mysqli_close($link);

