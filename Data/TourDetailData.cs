using System.Collections.Generic;
using LynxExpeditions.Models;

namespace LynxExpeditions.Data
{
    public static class TourDetailData
    {
        public static Dictionary<int, TourDetail> GetTourDetailsEn() => new()
        {
            [1] = new TourDetail
            {
                TourId = 1,
                LongDesc = "Matka Canyon is one of Europe's best-kept secrets — a sheer limestone gorge carved by the Treska River just 15 km from Skopje's city centre. You'll board a small wooden boat and glide past vertical cliffs draped in wild orchids and nesting eagles. Your guide will bring you into the Cathedral Cave, home to one of Europe's deepest underwater caves, where stalactites hang like chandeliers over an underground lake. No crowds, no tourist buses — just the sound of oars and water.",
                Highlights = new List<string>
                {
                    "Boat ride through the 1,000m-deep canyon",
                    "Guided entry into the prehistoric Cathedral Cave",
                    "Spot rare Egyptian vultures and cliff-nesting eagles",
                    "Visit the 14th-century Monastery of St. Andrew",
                    "Picnic lunch on the canyon's rocky banks",
                    "All equipment and life vests provided"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Morning departure", Desc = "Meet your guide at Skopje's main square at 8:30 AM. 30-minute transfer to Matka by private minibus." },
                    new() { Title = "Canyon boat tour", Desc = "Board the wooden boat and navigate the gorge. Your guide explains the canyon's ecology and geology." },
                    new() { Title = "Cathedral Cave visit", Desc = "Dock and enter on foot. Hard hats on — your guide leads you 200 metres into the cave system." },
                    new() { Title = "Monastery & lunch", Desc = "Visit the medieval monastery, then picnic lunch on the canyon's edge with views down the gorge." },
                    new() { Title = "Return to Skopje", Desc = "Depart at approximately 2:30 PM. Back in the city by 3:15 PM." },
                },
                Includes = new List<string> { "🚌 Private transport", "🚣 Boat ride", "🪨 Cave entry", "🥪 Picnic lunch", "🦺 Safety equipment", "👤 Local guide" },
                Guide = new Guide { Name = "Stefan Popovski", Role = "Lead Wilderness Guide", Avatar = "👨‍🦱" },
                BestSeason = "Apr – Oct",
                GroupSize = "Max 10",
                MeetingPoint = "Skopje Main Square"
            },
            [2] = new TourDetail
            {
                TourId = 2,
                LongDesc = "Lake Ohrid is one of Europe's oldest and deepest lakes — and a UNESCO World Heritage Site for both its nature and culture. Over two days, your guide Ana will take you through the old town's cobbled streets, past Byzantine churches layered with centuries of frescoes, to a secret 10th-century chapel that no guidebook mentions. You'll kayak the lake at dusk, eat freshwater trout at a family-run restaurant on the water, and wake up to a sunrise boat ride before the day-trippers arrive.",
                Highlights = new List<string>
                {
                    "Private tour of the 10th-century St. Naum Monastery",
                    "Guided fresco walk through 5 ancient churches",
                    "Dawn kayak across Lake Ohrid with a local fisherman",
                    "Sunset dinner at a lakeside restaurant on stilts",
                    "Visit the Church of St. John at Kaneo — Ohrid's icon",
                    "Boat transfer between old town and Kaneo cliff"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Day 1 – Old Town & Churches", Desc = "Arrive Ohrid by morning. Walk the old bazaar, visit the Amphitheatre and three Byzantine churches with Ana as your guide. Evening stroll along the lake promenade and dinner at a local restaurant." },
                    new() { Title = "Day 2 – Lake & St. Naum", Desc = "Pre-dawn kayak from town to Kaneo cliff for sunrise. Boat south to St. Naum Monastery. Afternoon free time for swimming or the archaeological museum. Depart by 5 PM." },
                },
                Includes = new List<string> { "🏨 1 night accommodation", "🥘 2 breakfasts", "🚤 Boat transfers", "🛶 Kayak rental", "⛪ Church entry fees", "👤 Local guide" },
                Guide = new Guide { Name = "Ana Nikolovska", Role = "Cultural Heritage Expert", Avatar = "👩" },
                BestSeason = "May – Oct",
                GroupSize = "Max 8",
                MeetingPoint = "Ohrid Old Town Gate"
            },
            [3] = new TourDetail
            {
                TourId = 3,
                LongDesc = "While Bansko and Borovets fill up, Mavrovo sits quietly under radar — 20+ pistes, a proper mountain village atmosphere, and lift queues measured in seconds. Bojan has been skiing these slopes since childhood and knows every powder stash, each off-piste run through the pine forests, and the mountain hut that serves the best tavce gravce after a long day. This week-long package includes ski hire, lift passes, instruction if you need it, and evenings in a family-run lodge with open fires.",
                Highlights = new List<string>
                {
                    "7 days of guided skiing on Mavrovo's best runs",
                    "Off-piste descents through old-growth pine forests",
                    "Evening snowshoe walk to a traditional mountain hut",
                    "Optional ski lessons with a certified instructor",
                    "Stay in a family-run mountain lodge with open fire",
                    "Traditional Macedonian mountain cuisine all week"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Day 1 – Arrival & orientation", Desc = "Transfer from Skopje. Equipment fitting, lodge check-in, and a gentle warm-up run to assess your level." },
                    new() { Title = "Days 2–5 – On the mountain", Desc = "Full ski days with Bojan. Route varies by snow and group level — from groomed pistes to tree runs and powder fields." },
                    new() { Title = "Day 6 – Off-piste & snowshoes", Desc = "Morning backcountry excursion, afternoon snowshoe trail to Mavrovo Lake, frozen and spectacular in winter." },
                    new() { Title = "Day 7 – Final run & departure", Desc = "Morning ski, pack up, and transfer back to Skopje. Depart by 2 PM." },
                },
                Includes = new List<string> { "🏨 6 nights lodge", "🍳 7 breakfasts + 6 dinners", "🎿 Ski hire + lift pass", "🚌 Airport transfers", "👤 Guide all week", "⛷️ Instruction (optional)" },
                Guide = new Guide { Name = "Bojan Risteski", Role = "Mountain Trekking Guide", Avatar = "👨‍🦳" },
                BestSeason = "Dec – Mar",
                GroupSize = "Max 10",
                MeetingPoint = "Skopje Airport"
            },
            [4] = new TourDetail
            {
                TourId = 4,
                LongDesc = "Stobi was once one of the most important cities in the Roman province of Macedonia — a crossroads of trade routes where emperors passed and early Christians built some of the Balkans' first basilicas. Today it's beautifully uncluttered: wide excavated streets, intricate floor mosaics still in situ, and a crumbling theatre where plays were staged 1,700 years ago. Your guide brings it to life with stories that no information board can tell.",
                Highlights = new List<string>
                {
                    "Expert-guided walk through the full excavation site",
                    "See Roman mosaic floors dating to the 3rd century AD",
                    "Visit the Early Christian basilica complex",
                    "Explore the Roman theatre and governor's palace",
                    "Entry to the on-site archaeological museum",
                    "Return via the Tikveš winery for a tasting (optional)"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Morning – Depart Skopje", Desc = "Depart at 8 AM by private car. 90-minute drive south through the Vardar valley to Stobi." },
                    new() { Title = "Site exploration – 3 hours", Desc = "Guided walk through the excavations. Your guide covers Stobi's founding, Roman peak, and early Christian transformation." },
                    new() { Title = "Museum & lunch", Desc = "Visit the site museum, then lunch at a local restaurant in nearby Gradsko." },
                    new() { Title = "Optional winery stop", Desc = "On the return, stop at a Tikveš winery for a cellar tour and tasting of Vranec. Back in Skopje by 6 PM." },
                },
                Includes = new List<string> { "🚌 Private transport", "🏛️ Site entry", "🏺 Museum entry", "🥗 Lunch", "👤 Local guide", "🍷 Optional wine tasting" },
                Guide = new Guide { Name = "Ana Nikolovska", Role = "Cultural Heritage Expert", Avatar = "👩" },
                BestSeason = "Mar – Nov",
                GroupSize = "Max 12",
                MeetingPoint = "Skopje Main Square"
            },
            [5] = new TourDetail
            {
                TourId = 5,
                LongDesc = "Galicnik sits at 1,400 metres in the mountains above Mavrovo — a village of 200 stone houses, almost all empty for most of the year. A handful of families still tend the land in summer; in winter it's you, the snow, and total silence. You'll stay in a restored 19th-century stone house with a wood-burning stove, eat food cooked on open embers, and learn to make the local cheese from a woman whose family has been doing it for five generations. The nights here — no light pollution, no noise — are something you carry home.",
                Highlights = new List<string>
                {
                    "Stay in an authentically restored stone house",
                    "Cheese-making lesson with a local family",
                    "Guided walk to the Galicnik Gorge viewpoint",
                    "Traditional Macedonian dinner cooked over open fire",
                    "World-class stargazing from the village terrace",
                    "Visit the 19th-century Church of St. Peter and Paul"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Day 1 – Arrival & village walk", Desc = "Transfer from Skopje via Mavrovo National Park. Arrive Galicnik early afternoon. Village walk with your guide and meet your hosts. Open-fire dinner." },
                    new() { Title = "Day 2 – Gorge & cheesemaking", Desc = "Morning hike to the gorge viewpoint. Return for a cheesemaking workshop with the village family. Afternoon free for walking or reading. Evening under the stars." },
                    new() { Title = "Day 3 – Church & departure", Desc = "Morning visit to the village church. Late breakfast, then transfer back to Skopje. Arrive by 1 PM." },
                },
                Includes = new List<string> { "🏠 2 nights stone house", "🍳 All meals", "🚌 Transport", "🧀 Cheesemaking workshop", "🥾 Guided hike", "👤 Local guide" },
                Guide = new Guide { Name = "Stefan Popovski", Role = "Lead Wilderness Guide", Avatar = "👨‍🦱" },
                BestSeason = "Jun – Sep",
                GroupSize = "Max 6",
                MeetingPoint = "Skopje Main Square"
            },
            [6] = new TourDetail
            {
                TourId = 6,
                LongDesc = "Prespa Lake straddles three countries — North Macedonia, Albania, and Greece — and its reedy shoreline is one of the last nesting grounds of the Dalmatian pelican in Europe. Elena has been documenting the lake's bird life for a decade; she knows which cove the pelicans gather in at dawn, which fisherman will take you out quietly on his flat-bottomed boat, and where to stand to watch a pelican dive from five metres and surface with a fish. This trip also takes in the forgotten Byzantine island of Golem Grad — a small island of ruins, snakes, and extraordinary silence.",
                Highlights = new List<string>
                {
                    "Dawn boat with a local fisherman to find the pelican colony",
                    "Ferry crossing to Golem Grad island's Byzantine ruins",
                    "Guided birdwatching walk: 40+ species documented",
                    "Visit the waterfront village of Stenje",
                    "Expert commentary on Dalmatian pelican conservation",
                    "Binoculars and field guide provided"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Day 1 – Transfer & afternoon walk", Desc = "Depart Skopje at 7 AM. 3-hour drive to Prespa. Afternoon birding walk along the lake reed beds with Elena. Sunset at the water. Overnight in a local guesthouse." },
                    new() { Title = "Day 2 – Dawn pelicans & Golem Grad", Desc = "5:30 AM boat departure to the pelican colony — this is the moment the trip is built for. Return for breakfast, then ferry to Golem Grad island. Afternoon drive back to Skopje." },
                },
                Includes = new List<string> { "🏨 1 night guesthouse", "🥞 2 breakfasts", "🚌 All transport", "⛵ Boat & ferry", "🔭 Binoculars", "👤 Expert wildlife guide" },
                Guide = new Guide { Name = "Elena Stojanovska", Role = "Bird & Wildlife Specialist", Avatar = "👩‍🦱" },
                BestSeason = "Apr – Jun, Sep",
                GroupSize = "Max 8",
                MeetingPoint = "Skopje Main Square"
            },
            [7] = new TourDetail
            {
                TourId = 7,
                LongDesc = "Shar Mountain marks the border between North Macedonia and Kosovo, and its highest peak — Titov Vrv — stands at 2,748 metres. The approach takes you through glacially carved valleys, past a chain of alpine lakes that reflect the sky in perfect blue, and up a final ridge walk with views into three countries. It's a genuine mountain challenge requiring good fitness, but it's not technical — no ropes or crampons needed in summer. Bojan sets an honest pace, knows every shelter, and will turn the group around if conditions change. The summit sunrise is worth every step.",
                Highlights = new List<string>
                {
                    "Two-day summit attempt on Titov Vrv (2,748m)",
                    "Walk the chain of glacial lakes: Belo Ezero & Crno Ezero",
                    "Overnight in a staffed mountain hut at 2,100m",
                    "Sunrise from the summit ridge into Kosovo",
                    "Alpine meadows carpeted in mountain wildflowers (summer)",
                    "Complete mountain kit and safety briefing included"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Day 1 – Trailhead to mountain hut", Desc = "Depart Tetovo at 7 AM. Drive to the trailhead, then 5–6 hours hiking to the hut at 2,100m. Dinner and overnight. Total ascent: ~1,100m." },
                    new() { Title = "Day 2 – Summit & descent", Desc = "Pre-dawn start at 4:30 AM. 2-hour push to the summit for sunrise. Descend via the lake chain. Return to Tetovo by early afternoon." },
                },
                Includes = new List<string> { "🏔️ Mountain hut overnight", "🍲 Dinner + breakfast", "🚌 Transfer from Tetovo", "🧭 Navigation kit", "⛑️ First aid equipment", "👤 Certified mountain guide" },
                Guide = new Guide { Name = "Bojan Risteski", Role = "Mountain Trekking Guide", Avatar = "👨‍🦳" },
                BestSeason = "Jun – Sep",
                GroupSize = "Max 8",
                MeetingPoint = "Tetovo Town Centre"
            },
            [8] = new TourDetail
            {
                TourId = 8,
                LongDesc = "The Tikveš valley is Macedonia's wine country — wide, sun-baked hills covered in Vranec and Smederevka vines. The tour runs by bicycle: flat enough for any fitness level, with a slow enough pace that you stop whenever something catches your eye. You'll visit two family wineries, one of which still treads grapes by foot during harvest, and have lunch under a pergola at a 200-year-old konoba with food that hasn't changed in generations. The afternoon ends with a proper tasting of six Macedonian wines — guided, unhurried, with food pairings.",
                Highlights = new List<string>
                {
                    "Guided cycling through 25 km of vineyard roads",
                    "Visit two family wineries — one still foot-treading in harvest",
                    "Guided tasting of 6 Macedonian wines with food pairing",
                    "Traditional lunch at a 200-year-old village restaurant",
                    "Learn the story of Vranec — Macedonia's signature grape",
                    "E-bike option available on request"
                },
                Itinerary = new List<ItineraryDay>
                {
                    new() { Title = "Morning – Depart Skopje", Desc = "Depart 8 AM by private van. 1.5-hour drive to Tikveš. Bikes assembled and route briefing." },
                    new() { Title = "Morning cycle – First winery", Desc = "25 km route through vineyard tracks. Mid-route stop at Popova Kula winery for a cellar tour and morning tasting." },
                    new() { Title = "Lunch at the konoba", Desc = "Traditional lunch with local wine. Unrushed — plan 90 minutes here." },
                    new() { Title = "Afternoon – Second winery & tasting", Desc = "Short cycle to a family winery for the main guided tasting. Depart for Skopje at 5 PM. Back by 6:30 PM." },
                },
                Includes = new List<string> { "🚴 Bike hire", "🚌 Return transport", "🍷 Wine tastings", "🥘 Traditional lunch", "🏛️ Winery tours", "👤 Local guide" },
                Guide = new Guide { Name = "Ana Nikolovska", Role = "Cultural Heritage Expert", Avatar = "👩" },
                BestSeason = "Apr – Oct",
                GroupSize = "Max 10",
                MeetingPoint = "Skopje Main Square"
            },
        };
    }
}
