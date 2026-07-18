namespace LynxExpeditions.Models
{
    /// <summary>
    /// A tour card shown in the "Choose your adventure" grid.
    /// </summary>
    public class Tour
    {
        public int Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public string Region { get; set; } = string.Empty;
        public string Category { get; set; } = string.Empty; // nature | cultural | adventure | winter
        public string Badge { get; set; } = string.Empty;
        public string Emoji { get; set; } = string.Empty;
        public string Desc { get; set; } = string.Empty;
        public string Duration { get; set; } = string.Empty;
        public string Difficulty { get; set; } = string.Empty;
        public int Price { get; set; }
    }
}
