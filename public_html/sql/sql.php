<?php
$create = [];

$create[] = "CREATE TABLE `PREFIX_favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] = "CREATE TABLE `PREFIX_featured_recipes` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] = "CREATE TABLE `PREFIX_recipes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `prep_time` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] = "CREATE TABLE `PREFIX_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] = "CREATE TABLE `PREFIX_visits` (
  `id` int(11) NOT NULL,
  `visit_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;";

$create[] = "ALTER TABLE `PREFIX_favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);";

$create[] = "ALTER TABLE `PREFIX_featured_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`);";

$create[] = "ALTER TABLE `PREFIX_recipes`
  ADD PRIMARY KEY (`id`);";

$create[] = "ALTER TABLE `PREFIX_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);";

$create[] = "ALTER TABLE `PREFIX_visits`
  ADD PRIMARY KEY (`id`);";

$create[] = "ALTER TABLE `PREFIX_favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;";

$create[] = "ALTER TABLE `PREFIX_featured_recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;";

$create[] = "ALTER TABLE `PREFIX_recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;";

$create[] = "ALTER TABLE `PREFIX_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;";

$create[] = "ALTER TABLE `PREFIX_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";

$create[] = "ALTER TABLE `PREFIX_favorites`
  ADD CONSTRAINT `PREFIX_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `PREFIX_users` (`id`),
  ADD CONSTRAINT `PREFIX_favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `PREFIX_recipes` (`id`);";

$create[] = "ALTER TABLE `PREFIX_featured_recipes`
  ADD CONSTRAINT `PREFIX_featured_recipes_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `PREFIX_recipes` (`id`);";

$insert = [];

$insert[] = "INSERT INTO `PREFIX_recipes` (`id`, `title`, `category`, `prep_time`, `image`, `ingredients`, `instructions`, `created_at`) VALUES
(1, 'Ostre skrzydełka', 'Dania główne', '45 minut', 'images/skrzydelka.jpg', '" . addslashes('- 500 g skrzydełek kurczaka\n- 3 łyżki sosu sojowego\n- 2 łyżki miodu\n- 2 łyżki oleju\n- 2 ząbki czosnku, drobno posiekane\n- 1 łyżeczka sosu rybnego\n- 1 łyżeczka papryki chili (możesz dostosować ilość do swojego poziomu pikantności)\n- Sól i pieprz do smaku\n- 1 łyżeczka startego imbiru\n- Posiekana natka kolendry do dekoracji (opcjonalnie)') . "', '" . addslashes('1. Oczyść skrzydełka kurczaka i osusz je papierowym ręcznikiem. Posól i posyp pieprzem skrzydełka według własnego smaku.\n2. W misce połącz sos sojowy, miód, olej sezamowy, posiekany czosnek, sos rybny, paprykę chili i starty imbir. Dobrze wymieszaj, aby uzyskać jednolitą marynatę.\n3. Umieść skrzydełka w misce i równomiernie pokryj je przygotowaną marynatą. Pozostaw skrzydełka do marynowania przez co najmniej 30 minut. Możesz również zostawić je na dłużej, aby smaki lepiej się wchłonęły.\n4. Rozgrzej patelnię lub wok na średnim ogniu. Dodaj skrzydełka wraz z marynatą do rozgrzanej patelni. Smaż skrzydełka przez około 15-20 minut, często mieszając, aż staną się złociste i dobrze przypieczone.\n5. Podawaj ostre skrzydełka na talerzu, posypane posiekaną natką kolendry dla dodatkowego smaku i świeżości.') . "', '2024-05-15 19:05:17'),
(2, 'Owsianka z owocami', 'Przekąski', '15 minut', 'images/owsianka.jpg', '" . addslashes('- 1/2 szklanki płatków owsianych\n- 1 szklanka mleka (może być roślinne, mleko migdałowe, sojowe, czy owsiane)\n- 1/2 szklanki wody\n- Szczypta soli\n- 1/2 łyżeczki ekstraktu waniliowego (opcjonalnie)\n- 1 łyżeczka miodu lub syropu klonowego (opcjonalnie, do słodzenia)\n- Świeże owoce (np. truskawki, jagody, banan) lub suszone owoce (np. rodzynki, daktyle)\n- Orzechy lub migdały do posypania (opcjonalnie)\n- Jogurt naturalny (opcjonalnie, do podania)') . "', '" . addslashes('1. W garnku połącz płatki owsiane, mleko, wodę, sól i ewentualnie ekstrakt waniliowy.\n2. Podgrzewaj na średnim ogniu, często mieszając, aż płatki owsiane wchłoną płyny i owsianka zgęstnieje. To zajmie zazwyczaj około 5-7 minut.\n3. Dodaj miód lub syrop klonowy, jeśli chcesz owsiankę słodzić. Mieszaj, aż składniki się dobrze połączą.\n4. Gdy owsianka osiągnie pożądaną konsystencję, wyłącz gaz.\n5. Podawaj owsiankę na talerzu lub w misce, a następnie udekoruj świeżymi owocami, orzechami lub migdałami.\n6. Jeśli lubisz, możesz dodać łyżkę jogurtu na wierzch.\n7. Owsiankę można również przygotować wieczorem i schłodzić w lodówce na noc, aby rano cieszyć się owsianką na zimno.') . "', '2024-06-15 19:05:17'),
(3, 'Brownie', 'Desery', '50 minut', 'images/brownie.jpg', '" . addslashes('- 1/2 szklanki (115 g) masła\n- 1 szklanka (200 g) cukru\n- 2 jajka\n- 1 łyżeczka ekstraktu waniliowego\n- 1/3 szklanki (30 g) kakao\n- 1/2 szklanki (65 g) mąki pszennej\n- 1/4 łyżeczki soli\n- 1/4 łyżeczki proszku do pieczenia\n- 1/2 szklanki (60 g) orzechów włoskich lub laskowych (opcjonalnie)') . "', '" . addslashes('1. Nagrzej piekarnik do 175 stopni Celsjusza. Wyłóż formę do pieczenia (ok. 20x20 cm) papierem pergaminowym lub natłuszcz ją.\n2. W garnku rozpuść masło. Dodaj cukier i mieszaj do połączenia składników. Odstaw do lekkiego ostygnięcia.\n3. Dodaj jajka i ekstrakt waniliowy do masy masłowej, dokładnie mieszaj.\n4. Przesiej kakao, mąkę, sól i proszek do pieczenia. Dodaj do mokrych składników i delikatnie wymieszaj, aż składniki się połączą. Nie mieszaj zbyt długo.\n5. Dodaj opcjonalnie posiekane orzechy i wymieszaj.\n6. Przelej ciasto do przygotowanej formy.\n7. Piecz w nagrzanym piekarniku przez około 25-30 minut lub do momentu, gdy kawałek drewnianego patyczka włożonego do środka będzie miał kilka wilgotnych okruchów, ale nie surowego ciasta.\n8. Wyjmij z piekarnika i pozostaw do ostygnięcia w formie, a następnie pokrój na kwadraty.') . "', '2024-06-15 19:05:17'),
(25, 'Sałatka Cezar', 'Przekąski', '20 minut', 'images/1719063560_cezarsalad.jpg', '" . addslashes('- 1 główka sałaty rzymskiej\n- 2 piersi z kurczaka\n- 1/2 szklanki parmezanu\n- 1/2 szklanki grzanek\n- 1/4 szklanki majonezu\n- 2 łyżki soku z cytryny\n- 2 ząbki czosnku\n- 1 łyżeczka musztardy dijon\n- Sól i pieprz do smaku') . "', '" . addslashes('1. Kurczaka posolić, popieprzyć i usmażyć na złoto.\n2. W misce wymieszać majonez, sok z cytryny, czosnek, musztardę, sól i pieprz.\n3. Sałatę rzymską porwać na kawałki, dodać do miski z dressingiem.\n4. Dodać pokrojonego kurczaka, parmezan i grzanki. Dokładnie wymieszać.') . "', '2024-06-22 13:39:20'),
(26, 'Klasyczny Burger', 'Dania główne', '30 minut', 'images/1719063697_burger.jpg', '" . addslashes('- 500g mielonej wołowiny\n- 4 bułki hamburgerowe\n- 1 pomidor\n- 1 cebula\n- 4 plasterki sera cheddar\n- 4 liście sałaty\n- 4 łyżki majonezu\n- 4 łyżki ketchupu\n- Sól i pieprz do smaku') . "', '" . addslashes('1. Mięso doprawić solą i pieprzem, uformować 4 kotlety.\n2. Usmażyć kotlety na grillu lub patelni.\n3. Bułki przekroić na pół i zgrillować do zarumienienia.\n4. Na dolnej części bułki posmarować majonez, ułożyć sałatę, kotleta, ser, pomidor, cebulę i ketchup. Przykryć górną częścią bułki.') . "', '2024-06-22 13:41:37'),
(27, 'Koktajl Truskawkowy', 'Drinki', '10 minut', 'images/coctail.jpg', '" . addslashes('- 300g truskawek\n- 200ml mleka\n- 100ml jogurtu naturalnego\n- 2 łyżki miodu\n- Kostki lodu') . "', '" . addslashes('1. Truskawki umyć i oczyścić z szypułek.\n2. W blenderze zmiksować truskawki, mleko, jogurt i miód na gładką masę.\n3. Dodać kostki lodu i miksować do połączenia składników.\n4. Przelać do szklanek i podawać od razu.') . "', '2024-06-22 13:43:52'),
(28, 'Ciasto Marchewkowe', 'Desery', '60 minut', 'images/1719064392_carrotcake.jpg', '" . addslashes('- 2 szklanki mąki\n- 2 szklanki startej marchewki\n- 1,5 szklanki cukru\n- 1 szklanka oleju\n- 4 jajka\n- 2 łyżeczki proszku do pieczenia\n- 1 łyżeczka sody oczyszczonej\n- 1 łyżeczka cynamonu\n- 1/2 łyżeczki soli') . "', '" . addslashes('1. W misce wymieszać mąkę, proszek do pieczenia, sodę, cynamon i sól.\n2. W osobnej misce ubić jajka z cukrem, dodać olej.\n3. Do mokrych składników dodać suche składniki i startą marchewkę, dokładnie wymieszać.\n4. Przelać ciasto do formy i piec w 180°C przez 45-50 minut, aż wbity patyczek będzie suchy.') . "', '2024-06-22 13:53:12');";




$insert[] = "INSERT INTO `PREFIX_users` (`id`, `username`, `password`, `created_at`, `role`, `email`) VALUES
(1, 'ADMIN_LOGIN', 'ADMIN_PASSWD', NOW(), 'admin', 'admin@example.com');";

$insert[] = "INSERT INTO `PREFIX_featured_recipes` (`id`, `recipe_id`, `description`) VALUES
(1, 1, 'Kuszące ostre skrzydełka z kurczaka – chrupiące, pikantne, nieodparty smak w jednym kęsie!');";


$insert[] = "INSERT INTO `PREFIX_visits` (`id`, `visit_count`) VALUES
(1, 0);";



