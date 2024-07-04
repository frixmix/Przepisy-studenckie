
# Przepisy studenckie

Przepisy Studenckie to aplikacja internetowa stworzona z myślą o studentach, którzy chcą szybko i łatwo znaleźć przepisy na smaczne i proste dania. Aplikacja umożliwia użytkownikom przeglądanie przepisów, dodawanie ulubionych, a także zarządzanie swoim profilem.
Funkcje:
* Przeglądanie przepisów: Użytkownicy mogą przeglądać dostępne przepisy, posortowane według różnych kategorii.
* Zarządzanie kontem: Użytkownicy mogą się rejestrować, logować, zmieniać hasła.
* Ulubione przepisy: Zalogowani użytkownicy mogą dodawać przepisy do listy ulubionych, aby mieć do nich szybki dostęp.

## Wymagania systemowe

* wersja apache'a: Apache 2.4.41
* wersja PHP'a: 7.4.3-4ubuntu2.23
* wersja MySQL: 10.3.39-MariaDB-0ubuntu0.20.04.2

## Instalacja

Aby zainstalować i skonfigurować aplikację, postępuj zgodnie z poniższymi krokami:
1. Pobierz i rozpakuj projekt:
Skopiuj pliki projektu na swój serwer.

2. Utwórz plik konfiguracyjny:
W katalogu głównym projektu utwórz plik con.fig.php za pomocą polecenia: touch con.fig.php

3. Zmień uprawnienia do pliku konfiguracyjnego:
Aby umożliwić zapis do pliku konfiguracyjnego, zmień jego uprawnienia za pomocą polecenia: chmod o+w con.fig.php

4. Zmień uprawnienia do katalogu images:
Aby umożliwić zapis do katalogu images, zmień jego uprawnienia za pomocą polecenia: chmod o+w images

5. Uruchom skrypt instalacyjny:
Otwórz przeglądarkę internetową i przejdź do adresu URL odpowiadającego lokalizacji Twojego projektu, np. http://twoja-domena.pl/install.php. Postępuj zgodnie z instrukcjami wyświetlanymi na ekranie, aby skonfigurować połączenie z bazą danych i utworzyć niezbędne tabele.

6. Usuń skrypt instalacyjny:
Po zakończeniu instalacji usuń plik install.php z katalogu głównego projektu, aby zabezpieczyć swoją aplikację: rm install.php

7. Przywróć bezpieczne uprawnienia do pliku konfiguracyjnego:
Po zakończeniu instalacji możesz przywrócić bezpieczne uprawnienia do pliku con.fig.php, aby zapobiec przypadkowemu zapisowi: chmod o-w con.fig.php

## Autor

* **Szymon Pączyński** 

## Wykorzystane zewnętrzne biblioteki

* Google Fonts(najnowsza wersja)
* Font Awesome (6.5.1)
