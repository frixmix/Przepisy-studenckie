<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

$prefix_recipes = "{$prefix}_recipes";

if (isset($_GET['id'])) {
    $recipe_id = intval($_GET['id']);
    
    $sql_recipe = "SELECT * FROM $prefix_recipes WHERE id = $recipe_id";
    $result_recipe = mysqli_query($link, $sql_recipe);
    
    if (!$result_recipe) {
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }

    $recipe = mysqli_fetch_assoc($result_recipe);

    if (!$recipe) {
        die("Przepis nie znaleziony!");
    }
} else {
    die("Nieprawidłowy parametr!");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Edytuj przepis</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <link rel="stylesheet" href="./admincss/editrecipe.css"> <!-- Nowy plik CSS -->
</head>
<body>
  <?php include('sidebar.php'); ?>
  <div class="content">
    <div class="edit-recipe">
      <h2>Edytuj przepis: <?php echo htmlspecialchars($recipe['title']); ?></h2>
      <form action="updaterecipe.php" method="post" class="edit-recipe-form">
        <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
        <div class="form-group">
          <label for="title">Tytuł:</label>
          <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
        </div>
        <div class="form-group">
          <label for="category">Kategoria:</label>
          <select id="category" name="category" required>
            <option value="Dania główne" <?php if ($recipe['category'] == 'Dania główne') echo 'selected'; ?>>Dania główne</option>
            <option value="Desery" <?php if ($recipe['category'] == 'Desery') echo 'selected'; ?>>Desery</option>
            <option value="Przekąski" <?php if ($recipe['category'] == 'Przekąski') echo 'selected'; ?>>Przekąski</option>
            <option value="Drinki" <?php if ($recipe['category'] == 'Drinki') echo 'selected'; ?>>Drinki</option>
          </select>
        </div>
        <div class="form-group">
          <label for="prep_time">Czas przygotowania:</label>
          <input type="text" id="prep_time" name="prep_time" value="<?php echo htmlspecialchars($recipe['prep_time']); ?>">
        </div>
        <div class="form-group">
          <label for="image">URL obrazka:</label>
          <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($recipe['image']); ?>">
        </div>
        <div class="form-group">
          <label for="ingredients">Składniki:</label>
          <textarea id="ingredients" name="ingredients" rows="5" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
        </div>
        <div class="form-group">
          <label for="instructions">Instrukcje:</label>
          <textarea id="instructions" name="instructions" rows="5" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
        </div>
        <button type="submit" class="action-btn">Zapisz zmiany</button>
      </form>
    </div>
  </div>
</body>
</html>
<?php
mysqli_close($link);
?>
