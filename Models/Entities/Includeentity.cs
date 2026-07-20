using System.ComponentModel.DataAnnotations;

namespace LynxExpeditions.Models.Entities
{
    public class IncludeEntity
    {
        [Key]
        public int Id { get; set; }

        public int TourDetailId { get; set; }
        public int SortOrder { get; set; }

        public string Text { get; set; } = string.Empty;
    }
}