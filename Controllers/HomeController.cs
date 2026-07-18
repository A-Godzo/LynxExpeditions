using System.Text.Json;
using LynxExpeditions.Data;
using LynxExpeditions.Models;
using Microsoft.AspNetCore.Mvc;

namespace LynxExpeditions.Controllers
{
    public class HomeController : Controller
    {
        private static readonly JsonSerializerOptions JsonOptions = new()
        {
            PropertyNamingPolicy = JsonNamingPolicy.CamelCase
        };

        public IActionResult Index()
        {
            var toursEn = TourData.GetToursEn();
            var toursMk = TourData.GetToursMk();
            var tourDetailsEn = TourDetailData.GetTourDetailsEn();
            var tourDetailsMk = TourDetailDataMk.GetTourDetailsMk();
            var destinationsEn = DestinationData.GetDestinationsEn();
            var destinationsMk = DestinationData.GetDestinationsMk();
            var guidesEn = GuideData.GetGuidesEn();
            var guidesMk = GuideData.GetGuidesMk();

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
    }
}
