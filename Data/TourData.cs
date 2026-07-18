using System.Collections.Generic;
using LynxExpeditions.Models;

namespace LynxExpeditions.Data
{
    public static class TourData
    {
        public static List<Tour> GetToursEn() => new()
        {
            new Tour { Id = 1, Name = "Matka Canyon Boat & Cave Tour", Region = "Skopje area", Category = "nature", Badge = "Bestseller", Emoji = "🚣", Desc = "Glide through one of Europe's deepest gorges. Explore prehistoric caves and spot rare cliff-nesting eagles.", Duration = "1 day", Difficulty = "Easy", Price = 65 },
            new Tour { Id = 2, Name = "Ohrid Lake Cultural Journey", Region = "Ohrid", Category = "cultural", Badge = "UNESCO", Emoji = "⛪", Desc = "A full day wandering the old town, ancient monasteries, and the crystal-clear shores of Lake Ohrid.", Duration = "2 days", Difficulty = "Easy", Price = 120 },
            new Tour { Id = 3, Name = "Mavrovo Winter Ski Week", Region = "Mavrovo", Category = "winter", Badge = "Seasonal", Emoji = "⛷️", Desc = "Fresh powder, pine forests, and uncrowded pistes. Macedonia's best-kept ski secret — until now.", Duration = "7 days", Difficulty = "Intermediate", Price = 680 },
            new Tour { Id = 4, Name = "Stobi Ancient City Walk", Region = "Gradsko", Category = "cultural", Badge = "Historian's pick", Emoji = "🏛️", Desc = "Walk among Roman mosaics, early Christian basilicas, and crumbling theatre walls at ancient Stobi.", Duration = "1 day", Difficulty = "Easy", Price = 55 },
            new Tour { Id = 5, Name = "Galicnik Village Escape", Region = "Mavrovo area", Category = "cultural", Badge = "Hidden gem", Emoji = "🏡", Desc = "Stay in a restored stone house in a near-abandoned mountain village. Stargazing, folk food, silence.", Duration = "3 days", Difficulty = "Moderate", Price = 210 },
            new Tour { Id = 6, Name = "Prespa Lake Pelican Watch", Region = "Prespa", Category = "nature", Badge = "Wildlife", Emoji = "🦢", Desc = "Watch Dalmatian pelicans at one of their last European strongholds. A birdwatcher's dream dawn trip.", Duration = "2 days", Difficulty = "Easy", Price = 140 },
            new Tour { Id = 7, Name = "Shar Mountain Summit Trek", Region = "Tetovo area", Category = "adventure", Badge = "Challenge", Emoji = "🏔️", Desc = "A two-day push to the roof of Macedonia. Glacial lakes, alpine meadows, and a summit above 2,700 m.", Duration = "2 days", Difficulty = "Hard", Price = 175 },
            new Tour { Id = 8, Name = "Tikveš Wine & Villages Ride", Region = "Central Macedonia", Category = "cultural", Badge = "Relaxed", Emoji = "🍷", Desc = "Cycle through vine-covered hills, taste award-winning Vranec wine, and visit traditional vintners.", Duration = "1 day", Difficulty = "Easy", Price = 80 },
        };

        public static List<Tour> GetToursMk() => new()
        {
            new Tour { Id = 1, Name = "Обиколка со брод и пештера во кањонот Матка", Region = "Скопски регион", Category = "природа", Badge = "Најпродаван", Emoji = "🚣", Desc = "Пловете низ еден од најдлабоките кањони во Европа. Истражете праисториски пештери и забележете ретки орли што гнездат по карпите.", Duration = "1 ден", Difficulty = "Лесна", Price = 65 },
            new Tour { Id = 2, Name = "Културно патување на Охридското Езеро", Region = "Охрид", Category = "културни", Badge = "УНЕСКО", Emoji = "⛪", Desc = "Целодневно шетање низ стариот град, древни манастири и кристално чистите брегови на Охридското Езеро.", Duration = "2 дена", Difficulty = "Лесна", Price = 120 },
            new Tour { Id = 3, Name = "Зимска ски недела во Маврово", Region = "Маврово", Category = "зима", Badge = "Сезонско", Emoji = "⛷️", Desc = "Свеж снег, борови шуми и ненатрупани стази. Најдобро чуваната ски тајна во Македонија — досега.", Duration = "7 дена", Difficulty = "Тешка", Price = 680 },
            new Tour { Id = 4, Name = "Прошетка низ античкиот град Стоби", Region = "Градско", Category = "културни", Badge = "Избор на историчари", Emoji = "🏛️", Desc = "Прошетајте меѓу римски мозаици, ранохристијански базилики и остатоци од антички театар во Стоби.", Duration = "1 ден", Difficulty = "Лесна", Price = 55 },
            new Tour { Id = 5, Name = "Бегство во село Галичник", Region = "Мавровски регион", Category = "културни", Badge = "Скриен скапоцен камен", Emoji = "🏡", Desc = "Престој во обновена камена куќа во речиси напуштено планинско село. Ѕвездено небо, традиционална храна, тишина.", Duration = "3 дена", Difficulty = "Средно", Price = 210 },
            new Tour { Id = 6, Name = "Набљудување на пеликани на Преспанското Езеро", Region = "Преспа", Category = "природа", Badge = "Див свет", Emoji = "🦢", Desc = "Гледајте далматински пеликани во една од нивните последни европски засолништа. Утринска тура за љубители на птици.", Duration = "2 дена", Difficulty = "Лесна", Price = 140 },
            new Tour { Id = 7, Name = "Планинарење до врвот на Шар Планина", Region = "Тетовски регион", Category = "авантура", Badge = "Предизвик", Emoji = "🏔️", Desc = "Дводневно искачување до врвот на Македонија. Глечерски езера, алпски ливади и врв над 2.700 метри.", Duration = "2 дена", Difficulty = "Тешка", Price = 175 },
            new Tour { Id = 8, Name = "Винска и селска тура во Тиквеш", Region = "Централна Македонија", Category = "културни", Badge = "Релаксирано", Emoji = "🍷", Desc = "Возете низ лозја, дегустирајте наградувано вино Вранец и посетете традиционални винарии.", Duration = "1 ден", Difficulty = "Лесна", Price = 80 },
        };
    }
}
