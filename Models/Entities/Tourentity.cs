using System.ComponentModel.DataAnnotations;

namespace LynxExpeditions.Models.Entities
{
    /// <summary>
    /// EF Core / SQLite row for a tour card. One row per (TourId, Lang) —
    /// TourId is the original numeric id shared between the English and
    /// Macedonian version of the same tour (see the old TourData.cs).
    /// </summary>
    public class TourEntity
    {
        [Key]
        public int Id { get; set; }

        public int TourId { get; set; }
        public string Lang { get; set; } = "en";

        public string Name { get; set; } = string.Empty;
        public string Region { get; set; } = string.Empty;
        public string Category { get; set; } = string.Empty; // nature | cultural | adventure | winter
        public string Badge { get; set; } = string.Empty;
        public string Emoji { get; set; } = string.Empty; // image path, kept as-is from the original model
        public string Desc { get; set; } = string.Empty;
        public string Duration { get; set; } = string.Empty;
        public string Difficulty { get; set; } = string.Empty;
        public int Price { get; set; }
    }
}