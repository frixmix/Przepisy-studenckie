<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('con.fig.php');
$prefix_recipes = "{$prefix}_recipes";

$category = isset($_GET['category']) ? mysqli_real_escape_string($link, $_GET['category']) : '';

// Zapytanie SQL z filtrowaniem według kategorii
$sql = "SELECT * FROM $prefix_recipes";
if ($category) {
    $sql .= " WHERE category = '$category'";
}
$result = mysqli_query($link, $sql);

// Sprawdzenie wyników zapytania
if (!$result) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}
?>

<div class="recipes-container">
    <div class="tags-container">
        <h2>Kategorie:</h2>
        <ul class="tags">
            <li><a href="przepisy.php?category=Dania%20główne">Dania główne</a></li>
            <li><a href="przepisy.php?category=Desery">Desery</a></li>
            <li><a href="przepisy.php?category=Przekąski">Przekąski</a></li>
            <li><a href="przepisy.php?category=Drinki">Drinki</a></li>
        </ul>
    </div>
    <div class="recipes-content">
      <?php
      // Wyświetlanie przepisów
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
          echo "Brak przepisów";
      }
      mysqli_close($link);
      ?>
    </div>
</div>
