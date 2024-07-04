<?php
session_start();
include('con.fig.php');

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby przeglądać ulubione przepisy.");
}

$user_id = intval($_SESSION['user_id']);
$prefix_favorites = "{$prefix}_favorites";
$prefix_recipes = "{$prefix}_recipes";

$sql = "
    SELECT r.*
    FROM $prefix_favorites f
    JOIN $prefix_recipes r ON f.recipe_id = r.id
    WHERE f.user_id = $user_id";

$result = mysqli_query($link, $sql);

if (!$result) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Ulubione przepisy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include('header.php'); ?>
  <div class="recipes-container">
      <h1 class="recipe-heading">Twoje polubione przepisy</h1>
      <div class="recipes-content">
        <?php
        // Wyświetlanie ulubionych przepisów
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<a href="przepis.php?id=' . $row["id"] . '" class="recipe recipe-link">';
                echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '" class="recipe-image">';
                echo '<div class="recipe-content">';
                echo '<h3>' . $row["title"] . '</h3>';
                echo '<p>Czas przygotowania: ' . $row["prep_time"] . '</p>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo "Brak ulubionych przepisów.";
        }
        mysqli_close($link);
        ?>
      </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>
