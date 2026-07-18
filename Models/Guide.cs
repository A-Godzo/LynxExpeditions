namespace LynxExpeditions.Models
{
    /// <summary>
    /// A local guide. Used both on the "Meet the guides" team grid
    /// and inside each tour's detail panel.
    /// </summary>
    public class Guide
    {
        public string Name { get; set; } = string.Empty;
        public string Role { get; set; } = string.Empty;
        public string Avatar { get; set; } = string.Empty; // emoji avatar
    }
}
