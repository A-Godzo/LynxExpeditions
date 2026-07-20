using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;

namespace LynxExpeditions.Models.Entities
{
    /// <summary>
    /// EF Core / SQLite row for the expanded information shown in the tour
    /// detail page. One row per (TourId, Lang). The guide is stored as a
    /// flat snapshot (name/role/avatar) rather than a foreign key, mirroring
    /// how the old Data/TourDetailData.cs embedded a Guide value directly —
    /// including the Macedonian tour-5 data slip described in README.md
    /// ("Кањонот Матка" instead of a person's name), which DbSeeder carries
    /// over as-is rather than silently fixing.
    /// </summary>
    public class TourDetailEntity
    {
        [Key]
        public int Id { get; set; }

        public int TourId { get; set; }
        public string Lang { get; set; } = "en";

        public string LongDesc { get; set; } = string.Empty;

        public string GuideName { get; set; } = string.Empty;
        public string GuideRole { get; set; } = string.Empty;
        public string GuideAvatar { get; set; } = string.Empty;

        public string BestSeason { get; set; } = string.Empty;
        public string GroupSize { get; set; } = string.Empty;
        public string MeetingPoint { get; set; } = string.Empty;

        public List<HighlightEntity> Highlights { get; set; } = new();
        public List<ItineraryDayEntity> Itinerary { get; set; } = new();
        public List<IncludeEntity> Includes { get; set; } = new();
    }
}