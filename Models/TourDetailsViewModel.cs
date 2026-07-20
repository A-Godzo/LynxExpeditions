namespace LynxExpeditions.Models
{
    public class TourDetailsViewModel
    {
        public Tour Tour { get; set; } = new();
        public TourDetail Detail { get; set; } = new();
        public string Lang { get; set; } = "en";
    }
}