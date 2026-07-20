using LynxExpeditions.Models;
using LynxExpeditions.Models.Entities;

namespace LynxExpeditions.Data
{
    /// <summary>
    /// One-time seed: copies the original static EN/MK data (TourData,
    /// TourDetailData, TourDetailDataMk, DestinationData, GuideData) into
    /// the SQLite database the first time the app runs against an empty
    /// database. Safe to call on every startup — it's a no-op once the
    /// Tours table has rows.
    /// </summary>
    public static class DbSeeder
    {
        public static void SeedIfEmpty(LynxDbContext db)
        {
            if (db.Tours.Any())
                return; // already seeded

            SeedTours(db);
            SeedGuides(db);
            SeedDestinations(db);
            SeedTourDetails(db, "en", TourDetailData.GetTourDetailsEn());
            SeedTourDetails(db, "mk", TourDetailDataMk.GetTourDetailsMk());

            db.SaveChanges();
        }

        private static void SeedTours(LynxDbContext db)
        {
            foreach (var t in TourData.GetToursEn())
            {
                db.Tours.Add(new TourEntity
                {
                    TourId = t.Id,
                    Lang = "en",
                    Name = t.Name,
                    Region = t.Region,
                    Category = t.Category,
                    Badge = t.Badge,
                    Emoji = t.Emoji,
                    Desc = t.Desc,
                    Duration = t.Duration,
                    Difficulty = t.Difficulty,
                    Price = t.Price
                });
            }

            foreach (var t in TourData.GetToursMk())
            {
                db.Tours.Add(new TourEntity
                {
                    TourId = t.Id,
                    Lang = "mk",
                    Name = t.Name,
                    Region = t.Region,
                    Category = t.Category,
                    Badge = t.Badge,
                    Emoji = t.Emoji,
                    Desc = t.Desc,
                    Duration = t.Duration,
                    Difficulty = t.Difficulty,
                    Price = t.Price
                });
            }
        }

        private static void SeedGuides(LynxDbContext db)
        {
            var en = GuideData.GetGuidesEn();
            var mk = GuideData.GetGuidesMk();

            for (var i = 0; i < en.Count; i++)
            {
                db.Guides.Add(new GuideEntity
                {
                    GuideKey = i + 1,
                    Lang = "en",
                    Name = en[i].Name,
                    Role = en[i].Role,
                    Avatar = en[i].Avatar
                });
            }

            for (var i = 0; i < mk.Count; i++)
            {
                db.Guides.Add(new GuideEntity
                {
                    GuideKey = i + 1,
                    Lang = "mk",
                    Name = mk[i].Name,
                    Role = mk[i].Role,
                    Avatar = mk[i].Avatar
                });
            }
        }

        private static void SeedDestinations(LynxDbContext db)
        {
            var en = DestinationData.GetDestinationsEn();
            var mk = DestinationData.GetDestinationsMk();

            for (var i = 0; i < en.Count; i++)
            {
                var d = en[i];
                db.Destinations.Add(new DestinationEntity
                {
                    Lang = "en",
                    SortOrder = i,
                    Name = d.Name,
                    Icon = d.Icon,
                    Tag = d.Tag,
                    Count = d.Count,
                    PinId = d.PinId
                });
            }

            for (var i = 0; i < mk.Count; i++)
            {
                var d = mk[i];
                db.Destinations.Add(new DestinationEntity
                {
                    Lang = "mk",
                    SortOrder = i,
                    Name = d.Name,
                    Icon = d.Icon,
                    Tag = d.Tag,
                    Count = d.Count,
                    PinId = d.PinId
                });
            }
        }

        private static void SeedTourDetails(LynxDbContext db, string lang, Dictionary<int, TourDetail> details)
        {
            foreach (var (tourId, detail) in details)
            {
                var entity = new TourDetailEntity
                {
                    TourId = tourId,
                    Lang = lang,
                    LongDesc = detail.LongDesc,
                    GuideName = detail.Guide.Name,
                    GuideRole = detail.Guide.Role,
                    GuideAvatar = detail.Guide.Avatar,
                    BestSeason = detail.BestSeason,
                    GroupSize = detail.GroupSize,
                    MeetingPoint = detail.MeetingPoint
                };

                for (var i = 0; i < detail.Highlights.Count; i++)
                {
                    entity.Highlights.Add(new HighlightEntity { SortOrder = i, Text = detail.Highlights[i] });
                }

                for (var i = 0; i < detail.Itinerary.Count; i++)
                {
                    entity.Itinerary.Add(new ItineraryDayEntity
                    {
                        SortOrder = i,
                        Title = detail.Itinerary[i].Title,
                        Desc = detail.Itinerary[i].Desc
                    });
                }

                for (var i = 0; i < detail.Includes.Count; i++)
                {
                    entity.Includes.Add(new IncludeEntity { SortOrder = i, Text = detail.Includes[i] });
                }

                db.TourDetails.Add(entity);
            }
        }
    }
}