<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Dodaj nowy przepis</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <link rel="stylesheet" href="./admincss/editrecipe.css">
</head>
<body>
  <?php include('sidebar.php'); ?>
  <div class="content">
    <div class="edit-recipe">
      <h2>Dodaj nowy przepis</h2>
      <form action="saverecipe.php" method="post" enctype="multipart/form-data" class="edit-recipe-form">
        <div class="form-group">
          <label for="title">Tytuł:</label>
          <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
          <label for="category">Kategoria:</label>
          <select id="category" name="category" required>
            <option value="Dania główne">Dania główne</option>
            <option value="Desery">Desery</option>
            <option value="Przekąski">Przekąski</option>
            <option value="Drinki">Drinki</option>
          </select>
        </div>
        <div class="form-group">
          <label for="prep_time">Czas przygotowania:</label>
          <input type="text" id="prep_time" name="prep_time">
        </div>
        <div class="form-group">
          <label for="image">Wybierz obrazek:</label>
          <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div class="form-group">
          <label for="ingredients">Składniki:</label>
          <textarea id="ingredients" name="ingredients" rows="5" required></textarea>
        </div>
        <div class="form-group">
          <label for="instructions">Instrukcje:</label>
          <textarea id="instructions" name="instructions" rows="5" required></textarea>
        </div>
        <button type="submit" class="action-btn">Dodaj przepis</button>
      </form>
    </div>
  </div>
</body>
</html>
