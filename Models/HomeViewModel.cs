using System.Collections.Generic;

namespace LynxExpeditions.Models
{
    /// <summary>
    /// Everything the Index view needs. The English-language collections are
    /// used to render the initial server-side markup (tours grid, destinations
    /// list, "Meet the guides" cards), while the JSON strings for both
    /// languages are embedded in the page so the existing client-side script
    /// can still drive the "EN / MK" language toggle, filtering, and the
    /// tour detail panel without a round trip to the server.
    /// </summary>
    public class HomeViewModel
    {
        public List<Tour> ToursEn { get; set; } = new();
        public List<Destination> DestinationsEn { get; set; } = new();
        public List<Guide> GuidesEn { get; set; } = new();

        public string ToursEnJson { get; set; } = "[]";
        public string ToursMkJson { get; set; } = "[]";
        public string TourDetailsEnJson { get; set; } = "{}";
        public string TourDetailsMkJson { get; set; } = "{}";
        public string DestinationsEnJson { get; set; } = "[]";
        public string DestinationsMkJson { get; set; } = "[]";
        public string GuidesEnJson { get; set; } = "[]";
        public string GuidesMkJson { get; set; } = "[]";
    }
}
