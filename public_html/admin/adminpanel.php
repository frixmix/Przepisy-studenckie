<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

// Pobranie liczby wizyt
$prefix_visits = "{$prefix}_visits";
$sql_get_visits = "SELECT visit_count FROM $prefix_visits WHERE id = 1";
$result = mysqli_query($link, $sql_get_visits);
$visit_count = 0;
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $visit_count = $row['visit_count'];
} else {
    echo "Błąd podczas pobierania liczby wizyt: " . mysqli_error($link);
}

// Pobranie liczby przepisów
$prefix_recipes = "{$prefix}_recipes";
$sql_recipes = "SELECT COUNT(*) as count FROM $prefix_recipes";
$result_recipes = mysqli_query($link, $sql_recipes);
$recipes_count = mysqli_fetch_assoc($result_recipes)['count'];

// Pobranie liczby przepisów dodanych w tym miesiącu
$current_year = date('Y');
$current_month = date('m');
$sql_monthly_recipes = "SELECT COUNT(*) as count FROM $prefix_recipes WHERE YEAR(created_at) = $current_year AND MONTH(created_at) = $current_month";
$result_monthly_recipes = mysqli_query($link, $sql_monthly_recipes);
$monthly_recipes_count = mysqli_fetch_assoc($result_monthly_recipes)['count'];

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <!-- main css -->
  <link rel="stylesheet" href="./admincss/adminpanel.css">
</head>
<body>
  <?php include('sidebar.php'); ?>
  <section class="dashboard-section">
    <div class="dashboard-box">
        <ul>
            <li class="active">Dashboard</li>
        </ul>
        <div class="dashboard-content">
            <div class="dashboard-content-box">
                <h3>Liczba wizyt:</h3>
                <p><?php echo $visit_count; ?></p>
                <i class="fa-solid fa-person"></i>
            </div>
            <div class="dashboard-content-box">
                <h3>Liczba przepisów: </h3>
                <p><?php echo $recipes_count; ?></p>
                <i class="fa-solid fa-folder-open"></i>                 
            </div>
            <div class="dashboard-content-box">
                <h3>Dodane w tym miesiącu:</h3>
                <p><?php echo $monthly_recipes_count; ?></p>
                <i class="fa-solid fa-calendar-alt"></i>
            </div>
        </div>
    </div>
  </section>   
</body>
</html>

