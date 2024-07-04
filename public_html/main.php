<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('con.fig.php');

// Zapytanie SQL dla wszystkich proponowanych przepisów
$sql_featured = "
    SELECT 
        fr.id AS featured_id,
        fr.description AS featured_description,
        r.id AS recipe_id,
        r.title AS recipe_title,
        r.image AS recipe_image
    FROM 
        {$prefix}_featured_recipes fr
    JOIN 
        {$prefix}_recipes r ON fr.recipe_id = r.id";

$result_featured = mysqli_query($link, $sql_featured);

// Sprawdzenie wyników zapytania
if (!$result_featured) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}

// Pobranie wszystkich wyników do tablicy
$featured_recipes = mysqli_fetch_all($result_featured, MYSQLI_ASSOC);

// Wybór losowego przepisu
$random_recipe = $featured_recipes[array_rand($featured_recipes)];
?>

<!--Proponowany przepis-->
<?php if ($random_recipe) { ?>
<div class="recipe-promotion-container">
    <div class="recipe-promotion-card">
      <div class="recipe-promotion-image" style="background-image: url('<?php echo $random_recipe['recipe_image']; ?>');"></div>
      <div class="recipe-promotion-content">
        <h2 class="recipe-promotion-title"><?php echo htmlspecialchars($random_recipe['recipe_title']); ?></h2>
        <p class="recipe-promotion-description">
          <?php echo htmlspecialchars($random_recipe['featured_description']); ?>
        </p>
        <a href="przepis.php?id=<?php echo $random_recipe['recipe_id']; ?>" class="recipe-promotion-view-btn">Wyświetl przepis</a>
      </div>
    </div>
  </div>
<?php } ?>
<!--Proponowany przepis koniec-->
<div class="categories">
    <h2 class="section-title">Kategorie</h2>
    <div class="category-box">
        <div class="category category-first">
          <a href="przepisy.php?category=Dania%20główne">
            <div class="recipe-bg"></div>
            <h3 class="recipe-text">Dania główne</h3>
          </a>
        </div>
        <div class="category category-second">
          <a href="przepisy.php?category=Desery">
            <div class="recipe-bg"></div>
            <h3 class="recipe-text">Desery</h3>
          </a>
        </div>
        <div class="category category-third">
          <a href="przepisy.php?category=Przekąski">
            <div class="recipe-bg"></div>
            <h3 class="recipe-text">Przekąski</h3>
          </a>
        </div>
        <div class="category category-fourth">
          <a href="przepisy.php?category=Drinki">
            <div class="recipe-bg"></div>
            <h3 class="recipe-text">Drinki</h3>
          </a>
        </div>
    </div>
</div>
<div class="text-image-container">
    <div class="text">
      <h2>Odkryj kulinarną samodzielność z przepisami studenckimi!</h2>
      <p>Wchodzisz na teren smaków, ekonomii i kulinarnych przygód! Strona "Przepisy Studenckie" to nie tylko zbiór przepisów, ale także przewodnik do kulinarnego świata, gdzie gotowanie staje się zarówno przyjemnością, jak i oszczędnym rozwiązaniem.</p>
    </div>
    <div class="image-container">
      <img src="images/got.jpeg" alt="Sekcja naucz się gotować, aby oszczędzać" class="image">
    </div>
</div>
