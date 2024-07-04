<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = intval($_POST['id']);
    $prefix_featured_recipes = "{$prefix}_featured_recipes";
    $prefix_favorites = "{$prefix}_favorites";
    $prefix_recipes = "{$prefix}_recipes";
    
    // Rozpocznij transakcję
    mysqli_begin_transaction($link);
    
    try {
        // Pobierz ścieżkę obrazu przed usunięciem rekordu
        $sql_get_image = "SELECT image FROM $prefix_recipes WHERE id = $recipe_id";
        $result_get_image = mysqli_query($link, $sql_get_image);
        if (!$result_get_image) {
            throw new Exception("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }
        $row = mysqli_fetch_assoc($result_get_image);
        $image_path = "../" . $row['image']; // Dodaj prefiks do ścieżki obrazu

        // Usuń powiązane rekordy z zal_featured_recipes
        $sql_delete_featured = "DELETE FROM $prefix_featured_recipes WHERE recipe_id = $recipe_id";
        if (!mysqli_query($link, $sql_delete_featured)) {
            throw new Exception("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }
        
        // Usuń powiązane rekordy z zal_favorites
        $sql_delete_favorites = "DELETE FROM $prefix_favorites WHERE recipe_id = $recipe_id";
        if (!mysqli_query($link, $sql_delete_favorites)) {
            throw new Exception("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }
        
        // Usuń przepis z zal_recipes
        $sql_delete_recipe = "DELETE FROM $prefix_recipes WHERE id = $recipe_id";
        if (!mysqli_query($link, $sql_delete_recipe)) {
            throw new Exception("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }
        
        // Usuń obraz z serwera
        if (file_exists($image_path)) {
            if (!unlink($image_path)) {
                throw new Exception("Nie można usunąć pliku obrazu.");
            }
        }
        
        // Zatwierdź transakcję
        mysqli_commit($link);
        
        // Zamknij połączenie
        mysqli_close($link);
        
        header("Location: edycja.php");
        exit();
    } catch (Exception $e) {
        // Cofnij transakcję w przypadku błędu
        mysqli_rollback($link);
        
        // Zamknij połączenie
        mysqli_close($link);
        
        die($e->getMessage());
    }
} else {
    header("Location: edycja.php");
    exit();
}

