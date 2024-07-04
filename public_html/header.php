<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Przepisy studenckie</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <header>
    <div class="navbar">
      <div class="logo"><a href="index.php">Przepisy studenckie</a></div>
      <ul class="links">
        <li><a href="index.php" class="nav-link">Strona główna</a></li>
        <li><a href="przepisy.php" class="nav-link">Przepisy</a></li>
        <li><a href="about.php" class="nav-link">O mnie</a></li>
        <li><a href="contact.php" class="nav-link">Kontakt</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="ulubione.php" class="nav-link">Ulubione</a></li>
          <li><a href="profil.php" class="nav-link">Profil</a></li>
        <?php endif; ?>
      </ul>
      <div class="action-buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
          <span class="welcome-message">Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
          <a href="logout.php" class="action-btn">Wyloguj</a>
        <?php else: ?>
          <a href="login.php" class="action-btn">Login</a>
          <a href="register.php" class="action-btn">Rejestracja</a>
        <?php endif; ?>
      </div>
      <div class="toggle-btn">
        <i class="fa-solid fa-bars"></i>
      </div>
    </div>
    <div class="dropdown-menu">
      <ul>
        <li><a href="index.php" class="nav-link">Strona główna</a></li>
        <li><a href="przepisy.php" class="nav-link">Przepisy</a></li>
        <li><a href="about.php" class="nav-link">O mnie</a></li>
        <li><a href="contact.php" class="nav-link">Kontakt</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="ulubione.php" class="nav-link">Ulubione</a></li>
          <li><a href="profil.php" class="nav-link">Profil</a></li>
          <li><a href="logout.php" class="action-btn">Wyloguj</a></li>
        <?php else: ?>
          <li><a href="login.php" class="action-btn">Login</a></li>
          <li><a href="register.php" class="action-btn">Rejestracja</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </header>
  <script>
    const toggleBtn = document.querySelector('.toggle-btn'); 
    const toggleBtnIcon = document.querySelector('.toggle-btn i'); 
    const dropDownMenu = document.querySelector('.dropdown-menu');
    toggleBtn.onclick = function(){
      dropDownMenu.classList.toggle('open');
      const isOpen = dropDownMenu.classList.contains('open')
      toggleBtnIcon.classList = isOpen
        ? 'fa-solid fa-xmark'
        : 'fa-solid fa-bars'
    }
  </script>
</body>
</html>
