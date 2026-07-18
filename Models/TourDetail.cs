using System.Collections.Generic;

namespace LynxExpeditions.Models
{
    /// <summary>
    /// The expanded information shown in the slide-in detail panel
    /// when a visitor clicks a tour card. Keyed by Tour.Id.
    /// </summary>
    public class TourDetail
    {
        public int TourId { get; set; }
        public string LongDesc { get; set; } = string.Empty;
        public List<string> Highlights { get; set; } = new();
        public List<ItineraryDay> Itinerary { get; set; } = new();
        public List<string> Includes { get; set; } = new();
        public Guide Guide { get; set; } = new();
        public string BestSeason { get; set; } = string.Empty;
        public string GroupSize { get; set; } = string.Empty;
        public string MeetingPoint { get; set; } = string.Empty;
    }
}
