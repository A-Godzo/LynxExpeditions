using System.ComponentModel.DataAnnotations;

namespace LynxExpeditions.Models.Entities
{
    public class ItineraryDayEntity
    {
        [Key]
        public int Id { get; set; }

        public int TourDetailId { get; set; }
        public int SortOrder { get; set; }

        public string Title { get; set; } = string.Empty;
        public string Desc { get; set; } = string.Empty;
    }
}