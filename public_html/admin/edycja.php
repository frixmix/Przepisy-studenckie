<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

$prefix_recipes = "{$prefix}_recipes";

$sql_recipes = "SELECT id, title FROM $prefix_recipes";
$result_recipes = mysqli_query($link, $sql_recipes);

if (!$result_recipes) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Edycja postów</title>
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
      return confirm("Czy na pewno chcesz usunąć ten przepis?");
    }
  </script>
</head>
<body>
  <?php include('sidebar.php'); ?>
  <div class="content">
    <div class="post-list">
      <a href="addrecipe.php" class="action-btn">Dodaj nowy przepis</a>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($result_recipes)): ?>
        <li>
          <a href="editrecipe.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
          <a href="editrecipe.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edytuj</a>
          <form action="deleterecipe.php" method="post" style="display:inline;" onsubmit="return confirmDelete();">
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
