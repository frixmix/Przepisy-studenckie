<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="side-bar">
    <div class="name">
        <h1>Przepisy studenckie</h1>
    </div>
    <ul>
        <li class="<?= ($current_page == 'adminpanel.php') ? 'active' : '' ?>"><a href="adminpanel.php">Dashboard</a></li>
        <li class="<?= ($current_page == 'edycja.php') ? 'active' : '' ?>"><a href="edycja.php">Edycja postów</a></li>
        <li class="<?= ($current_page == 'featured.php') ? 'active' : '' ?>"><a href="featured.php">Promowane przepisy</a></li>
        <li class="<?= ($current_page == 'edituser.php') ? 'active' : '' ?>"><a href="edituser.php">Edycja użytkownika</a></li>
        <li><a href="../logout.php">Wyloguj</a></li>
    </ul>
</div>
