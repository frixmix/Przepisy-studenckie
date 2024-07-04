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
    <?php include('header.php'); ?>
  </header>
  <script>
    window.onload = function() {
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

      document.querySelector('form').onsubmit = function(event) {
        event.preventDefault(); // Zapobiegaj domyślnej akcji formularza

        const name = document.querySelector('input[name="name"]').value;
        const surname = document.querySelector('input[name="surname"]').value;
        const email = document.querySelector('input[name="email"]').value;
        const subject = document.querySelector('input[name="subject"]').value;
        const message = document.querySelector('textarea[name="message"]').value;

        const mailtoLink = `mailto:szymonekpl@op.pl?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent("Imię: " + name + "\nNazwisko: " + surname + "\nEmail: " + email + "\n\nWiadomość:\n" + message)}`;

        console.log(mailtoLink);

        setTimeout(() => {
          window.location.href = mailtoLink;
        }, 100);
      }
    }
  </script>
<div class="contact-box">
    <form>
      <h1>Formularz kontaktowy</h1>
      <input type="text" class="input-field" placeholder="Imię" name="name" required>
      <input type="text" class="input-field" placeholder="Nazwisko" name="surname" required>
      <input type="email" class="input-field" placeholder="Email" name="email" required>
      <input type="text" class="input-field" placeholder="Temat" name="subject" required>
      <textarea type="text" class="input-field textarea-field" placeholder="Tu wpisz treść swojej wiadomości lub proponowanego przepisu" name="message" required></textarea>
      <button type="submit" class="btn">Wyślij wiadomość</button>
    </form>
</div>
</body>
</html>
