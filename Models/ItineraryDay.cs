namespace LynxExpeditions.Models
{
    /// <summary>
    /// A single day/step in a tour's itinerary.
    /// </summary>
    public class ItineraryDay
    {
        public string Title { get; set; } = string.Empty;
        public string Desc { get; set; } = string.Empty;
    }
}
