<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('con.fig.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $prefix_recipes = "{$prefix}_recipes";
    $prefix_favorites = "{$prefix}_favorites";

    $sql = "SELECT * FROM $prefix_recipes WHERE id = $id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }

    $recipe = mysqli_fetch_assoc($result);

    if (!$recipe) {
        die("Przepis nie znaleziony!");
    }

    // Sprawdzenie, czy użytkownik już dodał do ulubionych
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    $already_favorited = false;

    if ($user_id) {
        $favorite_check_sql = "SELECT * FROM $prefix_favorites WHERE user_id = $user_id AND recipe_id = $id";
        $favorite_check_result = mysqli_query($link, $favorite_check_sql);
        $already_favorited = mysqli_num_rows($favorite_check_result) > 0;
    }
} else {
    die("Nieprawidłowy parametr!");
}
mysqli_close($link);
?>

<div class="recipe-container">
    <h1 class="recipe-heading"><?php echo htmlspecialchars($recipe['title']); ?></h1>
    <div class="recipe-meta">
        <p class="recipe-category"><?php echo htmlspecialchars($recipe['category']); ?></p>
        <p class="recipe-prep-time">Czas przygotowania: <?php echo htmlspecialchars($recipe['prep_time']); ?></p>
    </div>
    <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="recipe-image2">
    
    <div class="recipe-section ingredients-section">
        <h2 class="section-heading">Składniki</h2>
        <ul class="recipe-list">
            <?php
            $ingredients = explode("\\n", $recipe['ingredients']);
            foreach ($ingredients as $ingredient) {
                echo "<li>" . htmlspecialchars($ingredient) . "</li>";
            }
            ?>
        </ul>
    </div>
    
    <div class="recipe-section instructions-section">
        <h2 class="section-heading">Instrukcje</h2>
        <ol class="recipe-list">
            <?php
            $instructions = explode("\\n", $recipe['instructions']);
            foreach ($instructions as $instruction) {
                echo "<li>" . htmlspecialchars($instruction) . "</li>";
            }
            ?>
        </ol>
    </div>
    
    <div class="recipe-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="favorite.php" method="post" class="action-form">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                <?php if ($already_favorited): ?>
                    <input type="hidden" name="action" value="remove">
                    <button type="submit" class="action-btn">❌ Usuń z ulubionych</button>
                <?php else: ?>
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="action-btn add-to-favorites-btn">⭐ Dodaj do ulubionych</button>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</div>
