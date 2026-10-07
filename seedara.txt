-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2026 at 09:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lynx`
--
CREATE DATABASE IF NOT EXISTS `lynx` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lynx`;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Id`, `UserId`, `ExpeditionId`, `NumberOfTravelers`, `BookingDate`, `Status`, `CustomerMessage`, `AdminMessage`) VALUES
(1, 2, 1, 4, '2026-10-05 22:05:54', 'Confirmed', 'Braat saka so nuki i boro i milanka da skita po pelister be braaat zimi sve. fiks??', 'ae za nasi fiks'),
(2, 2, 1, 6, '2026-10-05 22:06:24', 'Rejected', 'Braat us 7 gaseri saket da idet mojt. \r\n6*', 'ne be baat'),
(3, 4, 10, 3, '2026-10-06 21:00:41', 'Confirmed', 'I\'d love to go here', 'Booked have fun');

--
-- Dumping data for table `contactmessage`
--

INSERT INTO `contactmessage` (`Id`, `Name`, `Email`, `Subject`, `Message`, `SubmittedAt`, `IsRead`) VALUES
(1, 'Steve Irwin', 'irwinsteve@yahoo.com', 'Where do i pay', 'Can i film this trip for naional geographic chanel?', '2026-10-06 21:06:38', 1);

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`Id`, `Name`, `Country`, `Region`, `Description`, `Image`, `BestTimeToVisit`, `TravelTips`) VALUES
(1, 'Ohrid and Lake Ohrid', 'North Macedonia', 'Southwest', 'One of Europe\'s oldest and deepest lakes, with a medieval old town, lakeside monasteries and mountain views.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQM4cb2CihnoCSLzekjB_KEOJqbZSgGJCDdJ3w_n__uIw&s=10', 'May to September', 'Bring a swimsuit for the lake\r\nOld town streets are steep and cobbled\r\nTry the local Ohrid trout'),
(2, 'Pelister and Prespa', 'North Macedonia', 'Southwest', 'Pelister is the country\'s oldest national park, with alpine lakes called the Eyes of Pelister and rare five-needle pines.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVZvnEi8zXEB0qxHmhbnOLbGtait5MVnDMzgYBJH31jw&s=10', 'June to October', 'Weather changes quickly above 2000 m\r\nCarry water and layers\r\nTrail markings can be faint'),
(3, 'Sofia and Rila', 'Bulgaria', 'Southwest Bulgaria', 'A relaxed capital at the foot of Vitosha mountain, with the Seven Rila Lakes and Rila Monastery a short drive away.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTfZ5z04Wp3O0C_c2lLQvysCPbzXsUDl0IXbhBVEN2fqw&s=10', 'May to October', 'Sofia is very walkable\r\nRila Monastery asks for modest dress\r\nLakes can hold snow into June'),
(4, 'Belgrade', 'Serbia', 'Central Serbia', 'A lively city where the Sava meets the Danube, known for its fortress, river life, food and nightlife.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQc56Yx49Oku88aR6VUzLZtMOV1tIPh1lRyQfen0xSKFg&s=10', 'April to October', 'Cards are widely accepted\r\nEvenings start late\r\nTrams and buses are cheap'),
(5, 'Thessaloniki and Olympus', 'Greece', 'Northern Greece', 'A coastal city with Byzantine churches and a famous food scene, within reach of Mount Olympus and its gorges.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRs-KoHdTnS0KNLcB53K2_1SrRGyGRPz7LR_DmILOH4Q&s=10', 'April to June, September to October', 'Summer afternoons are hot\r\nRestaurants open late\r\nMountain huts need advance planning'),
(6, 'Durmitor', 'Montenegro', 'Žabljak and Durmitor National Park', 'Durmitor is one of Montenegro\'s most spectacular mountain regions, known for rugged peaks, glacial lakes, deep valleys and expansive alpine landscapes. Centered around the mountain town of Žabljak, the region is ideal for hiking, outdoor adventures and exploring some of the wildest scenery in the Balkans. Durmitor National Park offers a combination of dramatic mountain terrain and peaceful natural surroundings.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdMXnL32fGfKCAo4FCiHu1BvehWsmRefr8o1LJ-qt6gg&s=10', 'May to October', 'Mountain weather can change quickly, even during summer.\r\nBring sturdy walking shoes and layered clothing.\r\nEarly summer is especially good for seeing mountain lakes and green landscapes.\r\nKeep water and basic hiking supplies with you on longer trails.\r\nŽabljak is the main base for exploring the region.'),
(7, 'Meteora', 'Greece', 'Thessaly', 'Meteora is famous for its enormous sandstone rock formations and historic monasteries built high above the surrounding landscape. The area combines remarkable natural scenery with centuries of religious and cultural history. Nearby Kalabaka provides a convenient base for exploring the cliffs, monasteries and walking trails.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMX23BuKR7hqazMR-mMIXPurWpgJmPQR3JBvY784o9HQ&s=10', 'April to June and September to October', 'Wear comfortable shoes for walking and monastery visits.\r\nDress respectfully when visiting the monasteries.\r\nSummer afternoons can be very hot.\r\nStart outdoor activities earlier in the day during warmer months.\r\nBring water, especially when following the walking trails between viewpoints.'),
(8, 'Bay of Kotor', 'Montenegro', 'Kotor and Lovćen', 'The Bay of Kotor is a dramatic coastal region where historic towns sit between steep mountains and the Adriatic Sea. The UNESCO-listed old town of Kotor, coastal villages and nearby Lovćen mountains make the area ideal for combining cultural exploration with scenic outdoor activities. Visitors can move easily between historic streets, waterfronts and mountain viewpoints.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSd9e5Y0rEe3q5hu1sCFu7VZVn3uKuUVAwCQzZXbfhd3g&s=10', 'April to June and September to October', 'The old towns are best explored on foot.\r\nSummer is the busiest season, so expect larger crowds.\r\nWear comfortable shoes for cobbled streets and uphill walks.\r\nMountain temperatures can be noticeably cooler than at the coast.\r\nPlan additional travel time around the bay during busy periods.');

--
-- Dumping data for table `expedition`
--

INSERT INTO `expedition` (`Id`, `Name`, `ShortDescription`, `Description`, `Itinerary`, `Included`, `NotIncluded`, `Price`, `DurationDays`, `Difficulty`, `MaxGroupSize`, `DepartureLocation`, `FeaturedImage`, `StartDate`, `EndDate`, `CategoryId`, `DestinationId`, `IsFeatured`, `IsActive`) VALUES
(1, 'Pelister Lakes Traverse', 'Two days across alpine lakes and old pine forest.', 'Walk from the park edge up to the Eyes of Pelister and across the ridge, with a night in a mountain hut.', 'Day 1: Drive from Skopje, hike to the lakes\r\nDay 2: Ridge walk and descent, return to Skopje', 'Mountain guide\r\nHut accommodation\r\nTransport from Skopje\r\nBreakfast and trail lunch', 'Dinner\r\nPersonal gear\r\nTravel insurance', 149.00, 2, 'Moderate', 10, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMAof0tpr0m_zGADafDwoeVrZI3AElXqSebDnBc3CZ0g&s=10', '2026-11-04', '2026-11-05', 1, 2, 1, 1),
(2, 'Lake Ohrid Slow Weekend', 'Old town, monasteries and the lakeshore at an easy pace.', 'A relaxed weekend around Lake Ohrid with a local historian, a boat trip and time for swimming.', 'Day 1: Transfer to Ohrid, old town walk\r\nDay 2: Monastery visit and boat trip\r\nDay 3: Free morning, return to Skopje', 'Local guide\r\n2 nights in a guesthouse\r\nBoat trip\r\nTransport', 'Meals\r\nEntrance fees', 189.00, 3, 'Easy', 12, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFnr0ohnMhX86kPJdeX_qaVbDSVOe0ayqBnkTsJDRH5A&s=10', '2026-11-19', '2026-11-21', 2, 1, 1, 1),
(3, 'Seven Rila Lakes Day Hike', 'A full day among glacial lakes in the Rila mountains.', 'Take the chairlift and hike the circuit of the seven lakes with panoramic views.', 'Day 1: Early departure, lake circuit, evening return', 'Guide\r\nChairlift ticket\r\nTransport', 'Meals\r\nTravel insurance', 89.00, 1, 'Challenging', 8, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB_AZclPPHbT1SQKFqH8Beq8-OpZTPPkA1A0OaqJOepw&s=10', '2026-12-04', '2026-12-04', 1, 3, 1, 1),
(4, 'Belgrade City Escape', 'Fortress, rivers and late dinners in the Serbian capital.', 'Three days of walking tours, river life and food in Belgrade.', 'Day 1: Arrival and Kalemegdan fortress\r\nDay 2: Old town and food tour\r\nDay 3: Zemun and return', 'Local guide\r\n2 nights in a city hotel\r\nTransport', 'Meals\r\nDrinks', 229.00, 3, 'Easy', 12, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgr7juB-GEi3sEdn4Nur0gnKFU9carzl8lXQGqEQ-I_g&s=10', '2026-12-19', '2026-12-21', 4, 4, 0, 1),
(5, 'Mount Olympus Gorge Trek', 'Gorges, forest and the foothills of the home of the gods.', 'A strenuous trek through the Enipeas gorge with a hut night and a seaside finish in Thessaloniki.', 'Day 1: Drive to Litochoro, gorge walk\r\nDay 2: Ascent to the hut\r\nDay 3: Summit approach and descent\r\nDay 4: Thessaloniki and return', 'Mountain guide\r\nHut and hotel nights\r\nTransport', 'Meals\r\nPersonal gear', 299.00, 4, 'Challenging', 8, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxI3sDFkkIsPUDg-PKTz61cEmr-VbeREvB6biPcvuQLQ&s=10', '2027-01-03', '2027-01-06', 1, 5, 0, 1),
(6, 'Durmitor Peaks Escape', 'Four days of mountain trails, glacial lakes and dramatic peaks in Montenegro\'s Durmitor National Park.', 'Escape into the rugged landscapes of northern Montenegro on a small-group mountain adventure through Durmitor National Park. Walk alongside crystal-clear mountain lakes, explore quiet forest trails and experience the dramatic scenery of one of the Balkans\' most spectacular mountain regions. The trip combines active days outdoors with relaxed evenings in a traditional mountain setting.', 'Day 1 — Skopje to Žabljak\r\n\r\nDay 2 — Black Lake and Durmitor Trails\r\n\r\nDay 3 — Mountain Peaks and Hidden Lakes\r\n\r\nDay 4 — Tara Canyon and Return', 'Accommodation\r\nTransport from Skopje and back\r\nLocal guide\r\nNational park entrance\r\nBreakfast\r\nGuided hikes', 'Lunches and dinners\r\nPersonal expenses\r\nTravel insurance\r\nOptional activities', 295.00, 4, 'Moderate', 10, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHmz3RftD1Nmede0X7fjlPnr1R6eA-iB0jQm1LAJ0qlQ&s=10', '2027-05-14', '2027-05-17', 1, 6, 0, 1),
(7, 'Meteora & Mountain Monasteries', 'Discover the dramatic cliffs, historic monasteries and landscapes of Meteora on a three-day cultural escape.', 'Travel to one of Greece\'s most extraordinary landscapes, where centuries-old monasteries sit high above towering sandstone cliffs. This relaxed three-day expedition combines cultural discovery, scenic walks and time to explore the historic town of Kalabaka. It is designed for travelers who want to experience one of Greece\'s most iconic destinations without the pace of a traditional tour.', 'Day 1 — Skopje to Kalabaka\r\n\r\nDay 2 — Meteora Monasteries\r\n\r\nDay 3 — Final Views and Return', 'Accommodation\r\nTransport from Skopje and back\r\nLocal guide\r\nSelected monastery entrance fees\r\nBreakfast\r\nGuided walking tour', 'Lunches and dinners\r\nPersonal expenses\r\nTravel insurance\r\nAdditional entrance fees', 235.00, 3, 'Easy', 12, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXNmg9p5HqRcdTgCvnGZBJEklFU0egwMGUM805rsZkhg&s=10', '2027-06-04', '2027-06-06', 3, 7, 0, 1),
(8, 'Kotor Bay & Lovćen Escape', 'A four-day coastal escape combining the old streets of Kotor with mountain views above the Adriatic.', 'Experience two sides of Montenegro in one compact expedition. Explore the historic streets of Kotor, travel along the dramatic Bay of Kotor and head into the mountains of Lovćen for panoramic views over the Adriatic coastline. The trip balances relaxed city exploration with light outdoor activities.', 'Day 1 — Skopje to Kotor\r\n\r\nDay 2 — Bay of Kotor\r\n\r\nDay 3 — Lovćen National Park\r\n\r\nDay 4 — Kotor and Return', 'Accommodation\r\nTransport from Skopje and back\r\nBreakfast\r\nLocal guide\r\nGuided walking tours\r\nLovćen National Park entrance', 'Lunches and dinners\r\nPersonal expenses\r\nTravel insurance\r\nOptional activities', 320.00, 4, 'Easy', 12, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbRl4VB4LmTXLX8Q4SXqM8UMTphFj_i5EFB9qGe1qy0A&s=10', '2027-06-18', '2027-06-21', 4, 8, 0, 1),
(9, 'Belgrade After Dark', 'Discover Belgrade\'s historic center, riverside neighborhoods and lively evening atmosphere on a relaxed city escape.', 'Experience a different side of Belgrade through its historic streets, riverside promenades, local neighborhoods and vibrant evening atmosphere. This short city escape combines guided sightseeing with plenty of free time to explore independently, making it ideal for travelers who want culture, food and nightlife without a rushed schedule.', 'Day 1 — Skopje to Belgrade\r\n\r\nDay 2 — Historic Belgrade\r\n\r\nDay 3 — Local Belgrade\r\n\r\nDay 4 — Belgrade to Skopje', 'Accommodation\r\nTransport from Skopje and back\r\nBreakfast\r\nLocal guide\r\nGuided city tour\r\nSelected entrance fees', 'Lunches and dinners\r\nPersonal expenses\r\nTravel insurance\r\nOptional activities', 245.00, 4, 'Easy', 12, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwyUexj1Q5Abz0snLH8EyFkOQVpbhvFdvgnZzVcozDhQ&s=10', '2027-04-09', '2027-04-12', 4, 4, 0, 1),
(10, 'Ohrid Hidden Shores', 'A relaxed long weekend discovering quiet lakeside spots, historic villages and the lesser-known side of Lake Ohrid.', 'See Lake Ohrid beyond the classic landmarks with a slower-paced expedition focused on hidden viewpoints, peaceful lakeside areas and traditional settlements. The trip combines gentle outdoor activities with cultural exploration and plenty of time to enjoy the lake at your own pace.', 'Day 1 — Skopje to Ohrid\r\n\r\nDay 2 — Lakeside Discoveries\r\n\r\nDay 3 — Villages and Viewpoints\r\n\r\nDay 4 — Ohrid to Skopje', 'Accommodation\r\nTransport from Skopje and back\r\nBreakfast\r\nLocal guide\r\nGuided lakeside excursions\r\nSelected entrance fees', 'Lunches and dinners\r\nPersonal expenses\r\nTravel insurance\r\nOptional boat activities', 215.00, 4, 'Easy', 9, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_oY3jgydbpqRxcuJmm4OeLewfWdYlD8sdmUPSWW1N-Q&s=10', '2027-05-07', '2027-05-10', 2, 1, 0, 1),
(11, 'Pelister Wild Trails', 'Four days of mountain trails, forests and panoramic views around Pelister National Park and the Prespa region.', 'Explore the wilder side of Pelister through a combination of forest trails, mountain viewpoints and peaceful Prespa landscapes. This expedition is designed for travelers who enjoy active days outdoors while still having time to experience the villages and natural surroundings of southwestern North Macedonia.', 'Day 1 — Skopje to Pelister\r\n\r\nDay 2 — Pelister Mountain Trails\r\n\r\nDay 3 — Prespa Region\r\n\r\nDay 4 — Final Trail and Return', 'Accommodation\r\nTransport from Skopje and back\r\nBreakfast\r\nLocal guide\r\nNational park entrance\r\nGuided hikes', 'Lunches and dinners\r\nPersonal expenses\r\nTravel insurance\r\nOptional activities', 225.00, 4, 'Moderate', 10, 'Skopje', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0Hl9i6a9s0ITDIoFpRdLq9qSSL7I1_NxdibpBodpTew&s=10', '2027-06-11', '2027-06-14', 1, 2, 0, 1);

--
-- Dumping data for table `expeditionphoto`
--

INSERT INTO `expeditionphoto` (`Id`, `ExpeditionId`, `Image`) VALUES
(1, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToQMtkhQtJLWFzxQ-jFE1NIZMbcK1oW_sizM1l5pqVNA&s=10'),
(2, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCFGoKqnmPMx5C6v4eoZR39xzFxq8fK3gEwZFxBc-bDw&s=10');

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`Id`, `UserId`, `ExpeditionId`, `CreatedAt`) VALUES
(2, 4, 2, '2026-10-06 21:03:18'),
(3, 4, 3, '2026-10-06 21:03:19');

--
-- Dumping data for table `journalpost`
--

INSERT INTO `journalpost` (`Id`, `Title`, `Slug`, `Content`, `AuthorId`, `PublishedAt`) VALUES
(1, 'My advanture in the Hidden Shores of Ohrid', 'my-advanture-in-the-hidden-shores-of-ohrid', 'I went to the hidden Shores of Ohrid and saw a lot of fish and some harmless water snakes. Very enjoyable.', 4, '2026-10-06 21:04:20'),
(2, 'Lake Ohrid\'s Water', 'lake-ohrid-s-water', 'The water was calm and very warm. I loved the experience!', 4, '2026-10-06 21:05:28');

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`Id`, `UserId`, `Message`, `CreatedAt`, `IsRead`) VALUES
(1, 2, 'Your booking #2 for Pelister Lakes Traverse could not be accepted. Message from Lynx: ne be baat', '2026-10-05 22:07:01', 1),
(2, 2, 'Your booking #1 for Pelister Lakes Traverse has been confirmed. Message from Lynx: ae za nasi fiks', '2026-10-05 22:07:12', 1),
(3, 4, 'Your booking #3 for Ohrid Hidden Shores has been confirmed. Message from Lynx: Booked have fun', '2026-10-06 21:01:47', 1);

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Id`, `UserId`, `ExpeditionId`, `Rating`, `Comment`, `CreatedAt`) VALUES
(2, 4, 10, 4, 'Had a blast. Really enjoyed the lake.', '2026-10-06 21:02:51');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `FirstName`, `LastName`, `Email`, `PasswordHash`, `Role`) VALUES
(1, 'Andon', 'Godzo', 'andon3000@gmail.com', '$2y$10$DFQqniIH7ny1spmPfxdxuuUkhSKU2381XK1hIH4J/Bf1DnS0xSIDW', 'Admin'),
(2, 'Aleksandar', 'Grujevski', 'aleksandargrujevski@gmail.com', '$2y$10$qeNByiskp/ygbYsUnni4muOvytg7JbIxGI1A/gKQVfcGjjoG27ztm', 'Customer'),
(3, 'Elena', 'Trajkovska', 'etrajkovska@gmail.com', '$2y$10$V38rYaTRRKbsvP9wWpcBAOOWNI0uJfLB5iQw2Mj4emGbMVe6gfL/a', 'Admin'),
(4, 'Steve', 'Irwin', 'irwinsteve@yahoo.com', '$2y$10$BYcglvglLYGVOGuHn0bEau/wl3U2sJbLx6GwBgSqjl6tpHynnV5ue', 'Customer');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
