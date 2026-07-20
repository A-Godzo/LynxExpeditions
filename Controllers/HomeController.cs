using System.Text.Json;
using LynxExpeditions.Data;
using LynxExpeditions.Models;
using LynxExpeditions.Models.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;

namespace LynxExpeditions.Controllers
{
    public class HomeController : Controller
    {
        private readonly LynxDbContext _db;

        private static readonly JsonSerializerOptions JsonOptions = new()
        {
            PropertyNamingPolicy = JsonNamingPolicy.CamelCase
        };

        public HomeController(LynxDbContext db)
        {
            _db = db;
        }

        public IActionResult Index()
        {
            var toursEn = GetTours("en");
            var toursMk = GetTours("mk");
            var tourDetailsEn = GetTourDetails("en");
            var tourDetailsMk = GetTourDetails("mk");
            var destinationsEn = GetDestinations("en");
            var destinationsMk = GetDestinations("mk");
            var guidesEn = GetGuides("en");
            var guidesMk = GetGuides("mk");

            var model = new HomeViewModel
            {
                ToursEn = toursEn,
                DestinationsEn = destinationsEn,
                GuidesEn = guidesEn,

                ToursEnJson = JsonSerializer.Serialize(toursEn, JsonOptions),
                ToursMkJson = JsonSerializer.Serialize(toursMk, JsonOptions),
                TourDetailsEnJson = JsonSerializer.Serialize(tourDetailsEn, JsonOptions),
                TourDetailsMkJson = JsonSerializer.Serialize(tourDetailsMk, JsonOptions),
                DestinationsEnJson = JsonSerializer.Serialize(destinationsEn, JsonOptions),
                DestinationsMkJson = JsonSerializer.Serialize(destinationsMk, JsonOptions),
                GuidesEnJson = JsonSerializer.Serialize(guidesEn, JsonOptions),
                GuidesMkJson = JsonSerializer.Serialize(guidesMk, JsonOptions),
            };

            return View(model);
        }

        public IActionResult TourDetails(int id, string lang = "en")
        {
            lang = lang == "mk" ? "mk" : "en";

            var tourEntity = _db.Tours.AsNoTracking()
                .FirstOrDefault(t => t.TourId == id && t.Lang == lang);

            var detailEntity = _db.TourDetails.AsNoTracking()
                .Include(d => d.Highlights)
                .Include(d => d.Itinerary)
                .Include(d => d.Includes)
                .FirstOrDefault(d => d.TourId == id && d.Lang == lang);

            if (tourEntity == null || detailEntity == null)
                return NotFound();

            var model = new TourDetailsViewModel
            {
                Tour = ToTour(tourEntity),
                Detail = ToTourDetail(detailEntity),
                Lang = lang
            };
            return View(model);
        }

        private List<Tour> GetTours(string lang) =>
            _db.Tours.AsNoTracking()
                .Where(t => t.Lang == lang)
                .OrderBy(t => t.TourId)
                .ToList()
                .Select(ToTour)
                .ToList();

        private Dictionary<int, TourDetail> GetTourDetails(string lang)
        {
            var entities = _db.TourDetails.AsNoTracking()
                .Include(d => d.Highlights)
                .Include(d => d.Itinerary)
                .Include(d => d.Includes)
                .Where(d => d.Lang == lang)
                .ToList();

            return entities.ToDictionary(d => d.TourId, ToTourDetail);
        }

        private List<Destination> GetDestinations(string lang) =>
            _db.Destinations.AsNoTracking()
                .Where(d => d.Lang == lang)
                .OrderBy(d => d.SortOrder)
                .ToList()
                .Select(d => new Destination { Name = d.Name, Icon = d.Icon, Tag = d.Tag, Count = d.Count, PinId = d.PinId })
                .ToList();

        private List<Guide> GetGuides(string lang) =>
            _db.Guides.AsNoTracking()
                .Where(g => g.Lang == lang)
                .OrderBy(g => g.GuideKey)
                .ToList()
                .Select(g => new Guide { Name = g.Name, Role = g.Role, Avatar = g.Avatar })
                .ToList();

        private static Tour ToTour(TourEntity t) => new()
        {
            Id = t.TourId,
            Name = t.Name,
            Region = t.Region,
            Category = t.Category,
            Badge = t.Badge,
            Emoji = t.Emoji,
            Desc = t.Desc,
            Duration = t.Duration,
            Difficulty = t.Difficulty,
            Price = t.Price
        };

        private static TourDetail ToTourDetail(TourDetailEntity d) => new()
        {
            TourId = d.TourId,
            LongDesc = d.LongDesc,
            Highlights = d.Highlights.OrderBy(h => h.SortOrder).Select(h => h.Text).ToList(),
            Itinerary = d.Itinerary.OrderBy(i => i.SortOrder)
                .Select(i => new ItineraryDay { Title = i.Title, Desc = i.Desc }).ToList(),
            Includes = d.Includes.OrderBy(i => i.SortOrder).Select(i => i.Text).ToList(),
            Guide = new Guide { Name = d.GuideName, Role = d.GuideRole, Avatar = d.GuideAvatar },
            BestSeason = d.BestSeason,
            GroupSize = d.GroupSize,
            MeetingPoint = d.MeetingPoint
        };
    }
}