<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Przepisy studenckie</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer">
  <!-- main css -->
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include('header.php'); ?>
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
  <!--Przykładowy przepis-->
  <div class="recipe-promotion-container">
    <div class="recipe-promotion-card">
      <div class="recipe-promotion-image" style="background-image: url('./images/chef.jpeg');"></div>
      <div class="recipe-promotion-content">
        <h2 class="recipe-promotion-title">Szymon Pączyński</h2>
        <p class="recipe-promotion-description">
          Nr indeksu: 406313<br>Nazwa przedmiotu: Aplikacje internetowe<br>Rok akademicki: 2023/2024<br>
          Przeglądarka Chrome wersja: 126.0.6478.63
        </p>
      </div>
    </div>
  </div>
</body>
</html>
