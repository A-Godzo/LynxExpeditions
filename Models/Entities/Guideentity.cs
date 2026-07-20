using System.ComponentModel.DataAnnotations;

namespace LynxExpeditions.Models.Entities
{
    /// <summary>
    /// EF Core / SQLite row for one of the four "Meet the guides" team
    /// members. GuideKey (1-4) ties the English and Macedonian rows for
    /// the same person together, matching the order used in the old
    /// GuideData.cs.
    /// </summary>
    public class GuideEntity
    {
        [Key]
        public int Id { get; set; }

        public int GuideKey { get; set; }
        public string Lang { get; set; } = "en";

        public string Name { get; set; } = string.Empty;
        public string Role { get; set; } = string.Empty;
        public string Avatar { get; set; } = string.Empty; // emoji avatar
    }
}