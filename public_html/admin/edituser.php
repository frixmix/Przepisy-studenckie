<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../con.fig.php');

$prefix_users = "{$prefix}_users";
$prefix_favorites = "{$prefix}_favorites";

// Usuwanie użytkownika i jego ulubionych przepisów
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $user_id = intval($_POST['delete_user_id']);

    // Rozpocznij transakcję
    mysqli_begin_transaction($link);

    try {
        // Usuń powiązane rekordy z zal_favorites
        $sql_delete_favorites = "DELETE FROM $prefix_favorites WHERE user_id = $user_id";
        if (!mysqli_query($link, $sql_delete_favorites)) {
            throw new Exception("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }

        // Usuń użytkownika z zal_users
        $sql_delete_user = "DELETE FROM $prefix_users WHERE id = $user_id";
        if (!mysqli_query($link, $sql_delete_user)) {
            throw new Exception("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }

        // Zatwierdź transakcję
        mysqli_commit($link);

        $success = "Użytkownik został usunięty.";
    } catch (Exception $e) {
        // Cofnij transakcję w przypadku błędu
        mysqli_rollback($link);
        $error = $e->getMessage();
    }
}

// Zmiana roli użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_role_user_id'])) {
    $user_id = intval($_POST['change_role_user_id']);
    $new_role = $_POST['new_role'];

    // Sprawdź liczbę adminów
    if ($new_role === 'user') {
        $sql_check_admins = "SELECT COUNT(*) as admin_count FROM $prefix_users WHERE role = 'admin'";
        $result_check_admins = mysqli_query($link, $sql_check_admins);
        $row_check_admins = mysqli_fetch_assoc($result_check_admins);

        if ($row_check_admins['admin_count'] <= 1) {
            $error = "Nie można usunąć roli admina, ponieważ jest tylko jeden admin.";
        } else {
            $sql_update_role = "UPDATE $prefix_users SET role = '$new_role' WHERE id = $user_id";
            if (mysqli_query($link, $sql_update_role)) {
                $success = "Rola użytkownika została zmieniona.";
            } else {
                $error = "Błąd podczas zmiany roli: " . mysqli_error($link);
            }
        }
    } else {
        $sql_update_role = "UPDATE $prefix_users SET role = '$new_role' WHERE id = $user_id";
        if (mysqli_query($link, $sql_update_role)) {
            $success = "Rola użytkownika została zmieniona.";
        } else {
            $error = "Błąd podczas zmiany roli: " . mysqli_error($link);
        }
    }
}

$sql_users = "SELECT id, username, role FROM $prefix_users";
$result_users = mysqli_query($link, $sql_users);

if (!$result_users) {
    die("Błąd w zapytaniu SQL: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Edycja użytkowników</title>
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
      return confirm("Czy na pewno chcesz usunąć tego użytkownika?");
    }
    function confirmChangeRole() {
      return confirm("Czy na pewno chcesz zmienić rolę tego użytkownika?");
    }
  </script>
  <style>
    .user-actions {
      display: flex;
      gap: 10px;
    }
  </style>
</head>
<body>
  <?php include('sidebar.php'); ?>
  <div class="content">
    <div class="post-list">
      <h2>Lista użytkowników</h2>
      <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
      <?php if (isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($result_users)): ?>
        <li>
          <?php echo htmlspecialchars($row['username']); ?> - <?php echo htmlspecialchars($row['role']); ?>
          <div class="user-actions">
            <form action="edituser.php" method="post" style="display:inline;" onsubmit="return confirmDelete();">
              <input type="hidden" name="delete_user_id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="delete-btn">Usuń</button>
            </form>
            <?php if ($row['role'] != 'admin'): ?>
              <form action="edituser.php" method="post" style="display:inline;" onsubmit="return confirmChangeRole();">
                <input type="hidden" name="change_role_user_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="new_role" value="admin">
                <button type="submit" class="role-btn">Nadaj rolę admina</button>
              </form>
            <?php else: ?>
              <form action="edituser.php" method="post" style="display:inline;" onsubmit="return confirmChangeRole();">
                <input type="hidden" name="change_role_user_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="new_role" value="user">
                <button type="submit" class="role-btn">Usuń rolę admina</button>
              </form>
            <?php endif; ?>
          </div>
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
