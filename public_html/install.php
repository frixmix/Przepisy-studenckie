<?php
session_start();
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$config_file = 'con.fig.php';

function form_install_1() {
    echo '<h2>Krok 1: Konfiguracja bazy danych</h2>';
    echo '<form method="POST" action="install.php?step=2">
            <label for="host">Host:</label><input type="text" name="host" required><br>
            <label for="user">Użytkownik:</label><input type="text" name="user" required><br>
            <label for="passwd">Hasło:</label><input type="password" name="passwd" required><br>
            <label for="dbname">Nazwa bazy danych:</label><input type="text" name="dbname" required><br>
            <label for="prefix">Prefiks:</label><input type="text" name="prefix" required><br>
            <label for="displayErrors">Wyświetlanie błędów (true/false):</label><input type="text" name="displayErrors" required><br>
            <label for="admin_login">Login admina:</label><input type="text" name="admin_login" required><br>
            <label for="admin_passwd">Hasło admina:</label><input type="password" name="admin_passwd" required><br>
            <button type="submit">Dalej</button>
          </form>';
}

function install_database($link, $prefix, $admin_login, $admin_passwd) {
    if (file_exists("sql/sql.php")) {
        include("sql/sql.php");
        echo "Tworzę tabele bazy.<br>\n";
        mysqli_select_db($link, $_POST['dbname']) or die(mysqli_error($link));
        foreach ($create as $query) {
            $query = str_replace('PREFIX_', $prefix . '_', $query);
            echo "<p><code>" . htmlspecialchars($query) . "</code></p>\n";
            if (!mysqli_query($link, $query)) {
                echo "Błąd w zapytaniu SQL: " . mysqli_error($link) . "<br>";
            }
        }
        echo "Tabele zostały utworzone.<br>";
        
        echo "Wstawiam dane początkowe.<br>\n";
        foreach ($insert as $query) {
            $query = str_replace('PREFIX_', $prefix . '_', $query);
            $query = str_replace('ADMIN_LOGIN', $admin_login, $query);
            $query = str_replace('ADMIN_PASSWD', password_hash($admin_passwd, PASSWORD_DEFAULT), $query);
            echo "<p><code>" . htmlspecialchars($query) . "</code></p>\n";
            if (!mysqli_query($link, $query)) {
                echo "Błąd w zapytaniu SQL: " . mysqli_error($link) . "<br>";
            }
        }
        echo "Dane początkowe zostały wstawione.<br>";
    } else {
        die("Plik SQL nie został znaleziony.");
    }
}

if (file_exists($config_file)) {
    if (is_writable($config_file)) {
        switch ($step) {
            case 2:
                $host = $_POST['host'];
                $user = $_POST['user'];
                $passwd = $_POST['passwd'];
                $dbname = $_POST['dbname'];
                $prefix = $_POST['prefix'];
                $displayErrors = $_POST['displayErrors'] === 'true' ? 'true' : 'false';
                $admin_login = $_POST['admin_login'];
                $admin_passwd = $_POST['admin_passwd'];

                $link = mysqli_connect($host, $user, $passwd, $dbname);
                if (!$link) {
                    die("Nie można się połączyć: " . mysqli_connect_error());
                }
                mysqli_query($link, "SET NAMES UTF8");

                $config = "<?php\n";
                $config .= "\$host = \"$host\";\n";
                $config .= "\$login = \"$user\";\n";
                $config .= "\$password = \"$passwd\";\n";
                $config .= "\$dbname = \"$dbname\";\n";
                $config .= "\$prefix = \"$prefix\";\n";
                $config .= "\$displayErrors = $displayErrors;\n\n";
                $config .= " \$link = mysqli_connect(\$host, \$login, \$password) or die (\"Nie można się połączyć\");\n";
                $config .= " mysqli_select_db (\$link, \$dbname) or die (\"Nie mozna wybrać bazy danych\");\n";
                $config .= " mysqli_query(\$link, \"SET NAMES UTF8\");\n\n";
                $config .= " if (\$displayErrors) {\n";
                $config .= "    ini_set('display_errors', 1);\n";
                $config .= "    ini_set('display_startup_errors', 1);\n";
                $config .= "    error_reporting(E_ALL);\n";
                $config .= " } else {\n";
                $config .= "    ini_set('display_errors', 0);\n";
                $config .= "    ini_set('display_startup_errors', 0);\n";
                $config .= "    error_reporting(0);\n";
                $config .= " }\n";
                $config .= "?>";

                $file = fopen($config_file, "w");
                if (fwrite($file, $config)) {
                    fclose($file);
                    install_database($link, $prefix, $admin_login, $admin_passwd);
                    echo "<p>Instalacja zakończona sukcesem. Plik konfiguracyjny został utworzony, a tabele i dane zostały zaimportowane. Usuń plik install.php</p>";
                } else {
                    echo "Nie można zapisać do pliku konfiguracyjnego.";
                }
                break;

            default:
                form_install_1();
                break;
        }
    } else {
        echo "<p>Zmień uprawnienia do pliku <code>" . $config_file . "</code><br>np. <code>chmod o+w " . $config_file . "</code></p>";
        echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
    }
} else {
    echo "<p>Stwórz plik <code>" . $config_file . "</code><br>np. <code>touch " . $config_file . "</code></p>";
    echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
}

