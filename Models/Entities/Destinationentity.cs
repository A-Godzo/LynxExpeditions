using System.ComponentModel.DataAnnotations;

namespace LynxExpeditions.Models.Entities
{
    /// <summary>
    /// EF Core / SQLite row for an entry in the destinations list next to
    /// the SVG map. SortOrder preserves the original array order (also
    /// used as the "active on load" index in the front-end).
    /// </summary>
    public class DestinationEntity
    {
        [Key]
        public int Id { get; set; }

        public string Lang { get; set; } = "en";
        public int SortOrder { get; set; }

        public string Name { get; set; } = string.Empty;
        public string Icon { get; set; } = string.Empty;
        public string Tag { get; set; } = string.Empty;
        public string Count { get; set; } = string.Empty;
        public string PinId { get; set; } = string.Empty; // matches <g id="pinN"> in the SVG map
    }
}