<?php
// Sprawdzenie, czy plik con.fig.php istnieje
if (!file_exists('con.fig.php')) {
    header('Location: install.php');
    exit();
}

include('con.fig.php');

$prefix_visits = "{$prefix}_visits";
$sql_get_visits = "SELECT visit_count FROM $prefix_visits WHERE id = 1";
$result = mysqli_query($link, $sql_get_visits);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $visit_count = $row['visit_count'] + 1;

    $sql_update_visits = "UPDATE $prefix_visits SET visit_count = $visit_count WHERE id = 1";
    mysqli_query($link, $sql_update_visits);
}

mysqli_close($link);

if (file_exists("header.php")) include("header.php");
if (file_exists("main.php")) include("main.php");
if (file_exists("footer.php")) include("footer.php");

