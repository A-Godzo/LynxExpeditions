-- OPTIONAL demo data. Import after schema.sql. Dates are relative to today so trips stay bookable.
USE lynx;
INSERT INTO Destination(Name,Country,Region,Description,BestTimeToVisit,TravelTips) VALUES
('Ohrid and Lake Ohrid','North Macedonia','Southwest','One of Europe''s oldest and deepest lakes, with a medieval old town, lakeside monasteries and mountain views.','May to September','Bring a swimsuit for the lake
Old town streets are steep and cobbled
Try the local Ohrid trout'),
('Pelister and Prespa','North Macedonia','Southwest','Pelister is the country''s oldest national park, with alpine lakes called the Eyes of Pelister and rare five-needle pines.','June to October','Weather changes quickly above 2000 m
Carry water and layers
Trail markings can be faint'),
('Sofia and Rila','Bulgaria','Southwest Bulgaria','A relaxed capital at the foot of Vitosha mountain, with the Seven Rila Lakes and Rila Monastery a short drive away.','May to October','Sofia is very walkable
Rila Monastery asks for modest dress
Lakes can hold snow into June'),
('Belgrade','Serbia','Central Serbia','A lively city where the Sava meets the Danube, known for its fortress, river life, food and nightlife.','April to October','Cards are widely accepted
Evenings start late
Trams and buses are cheap'),
('Thessaloniki and Olympus','Greece','Northern Greece','A coastal city with Byzantine churches and a famous food scene, within reach of Mount Olympus and its gorges.','April to June, September to October','Summer afternoons are hot
Restaurants open late
Mountain huts need advance planning');
INSERT INTO Expedition(Name,ShortDescription,Description,Itinerary,Included,NotIncluded,Price,DurationDays,Difficulty,MaxGroupSize,DepartureLocation,StartDate,EndDate,CategoryId,DestinationId,IsFeatured,IsActive) VALUES
('Pelister Lakes Traverse','Two days across alpine lakes and old pine forest.','Walk from the park edge up to the Eyes of Pelister and across the ridge, with a night in a mountain hut.','Day 1: Drive from Skopje, hike to the lakes
Day 2: Ridge walk and descent, return to Skopje','Mountain guide\nHut accommodation\nTransport from Skopje\nBreakfast and trail lunch','Dinner\nPersonal gear\nTravel insurance',149.00,2,'Moderate',10,'Skopje',DATE_ADD(CURDATE(),INTERVAL 30 DAY),DATE_ADD(CURDATE(),INTERVAL 31 DAY),1,2,1,1),
('Lake Ohrid Slow Weekend','Old town, monasteries and the lakeshore at an easy pace.','A relaxed weekend around Lake Ohrid with a local historian, a boat trip and time for swimming.','Day 1: Transfer to Ohrid, old town walk
Day 2: Monastery visit and boat trip
Day 3: Free morning, return to Skopje','Local guide\n2 nights in a guesthouse\nBoat trip\nTransport','Meals\nEntrance fees',189.00,3,'Easy',12,'Skopje',DATE_ADD(CURDATE(),INTERVAL 45 DAY),DATE_ADD(CURDATE(),INTERVAL 47 DAY),2,1,1,1),
('Seven Rila Lakes Day Hike','A full day among glacial lakes in the Rila mountains.','Take the chairlift and hike the circuit of the seven lakes with panoramic views.','Day 1: Early departure, lake circuit, evening return','Guide\nChairlift ticket\nTransport','Meals\nTravel insurance',89.00,1,'Challenging',8,'Skopje',DATE_ADD(CURDATE(),INTERVAL 60 DAY),DATE_ADD(CURDATE(),INTERVAL 60 DAY),1,3,1,1),
('Belgrade City Escape','Fortress, rivers and late dinners in the Serbian capital.','Three days of walking tours, river life and food in Belgrade.','Day 1: Arrival and Kalemegdan fortress
Day 2: Old town and food tour
Day 3: Zemun and return','Local guide\n2 nights in a city hotel\nTransport','Meals\nDrinks',229.00,3,'Easy',12,'Skopje',DATE_ADD(CURDATE(),INTERVAL 75 DAY),DATE_ADD(CURDATE(),INTERVAL 77 DAY),4,4,0,1),
('Mount Olympus Gorge Trek','Gorges, forest and the foothills of the home of the gods.','A strenuous trek through the Enipeas gorge with a hut night and a seaside finish in Thessaloniki.','Day 1: Drive to Litochoro, gorge walk
Day 2: Ascent to the hut
Day 3: Summit approach and descent
Day 4: Thessaloniki and return','Mountain guide\nHut and hotel nights\nTransport','Meals\nPersonal gear',299.00,4,'Challenging',8,'Skopje',DATE_ADD(CURDATE(),INTERVAL 90 DAY),DATE_ADD(CURDATE(),INTERVAL 93 DAY),1,5,0,1);
