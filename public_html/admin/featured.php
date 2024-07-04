<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

$prefix_recipes = "{$prefix}_recipes";
$prefix_featured_recipes = "{$prefix}_featured_recipes";

$sql_recipes = "SELECT id, title FROM $prefix_recipes";
$result_recipes = mysqli_query($link, $sql_recipes);

if (!$result_recipes) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}

$sql_featured_recipes = "SELECT fr.id, r.title, fr.description FROM $prefix_featured_recipes fr JOIN $prefix_recipes r ON fr.recipe_id = r.id";
$result_featured_recipes = mysqli_query($link, $sql_featured_recipes);

if (!$result_featured_recipes) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Promowane przepisy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <link rel="stylesheet" href="./admincss/adminpanel.css">
  <script>
    function confirmDelete() {
      return confirm("Czy na pewno chcesz usunąć promowanie tego przepisu?");
    }
  </script>
</head>
<body>
  <?php include('sidebar.php'); ?>
  <div class="content">
    <div class="post-list">
      <h2>Dodaj promowany przepis</h2>
      <form action="savefeatured.php" method="post" class="add-featured-form">
        <div class="form-group">
          <label for="recipe">Wybierz przepis:</label>
          <select id="recipe" name="recipe_id" required>
            <?php while ($row = mysqli_fetch_assoc($result_recipes)): ?>
              <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="description">Opis (max 90 znaków):</label>
          <input type="text" id="description" name="description" maxlength="90" required>
        </div>
        <div class="form-group">
          <button type="submit" class="add-featured-btn">Dodaj promowany przepis</button>
        </div>
      </form>
    </div>
    <div class="post-list">
      <h2>Lista promowanych przepisów</h2>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($result_featured_recipes)): ?>
        <li>
          <?php echo htmlspecialchars($row['title']); ?> - <?php echo htmlspecialchars($row['description']); ?>
          <form action="deletefeatured.php" method="post" style="display:inline;" onsubmit="return confirmDelete();">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="delete-btn">Usuń</button>
          </form>
        </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
</body>
</html>
<?php
mysqli_close($link);
?>
