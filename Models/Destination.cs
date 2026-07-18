namespace LynxExpeditions.Models
{
    /// <summary>
    /// An entry in the destinations list next to the SVG map.
    /// </summary>
    public class Destination
    {
        public string Name { get; set; } = string.Empty;
        public string Icon { get; set; } = string.Empty;
        public string Tag { get; set; } = string.Empty;
        public string Count { get; set; } = string.Empty;
        public string PinId { get; set; } = string.Empty; // matches the <g id="pinN"> in the SVG map
    }
}
