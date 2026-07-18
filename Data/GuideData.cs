using System.Collections.Generic;
using LynxExpeditions.Models;

namespace LynxExpeditions.Data
{
    public static class GuideData
    {
        public static List<Guide> GetGuidesEn() => new()
        {
            new Guide { Name = "Stefan Popovski", Role = "Lead Wilderness Guide", Avatar = "👨‍🦱" },
            new Guide { Name = "Ana Nikolovska", Role = "Cultural Heritage Expert", Avatar = "👩" },
            new Guide { Name = "Bojan Risteski", Role = "Mountain Trekking Guide", Avatar = "👨‍🦳" },
            new Guide { Name = "Elena Stojanovska", Role = "Bird & Wildlife Specialist", Avatar = "👩‍🦱" },
        };

        public static List<Guide> GetGuidesMk() => new()
        {
            new Guide { Name = "Стефан Поповски", Role = "Главен водич за дивина", Avatar = "👨‍🦱" },
            new Guide { Name = "Ана Николовска", Role = "Експерт за културно наследство", Avatar = "👩" },
            new Guide { Name = "Бојан Ристески", Role = "Водич за планински туризам", Avatar = "👨‍🦳" },
            new Guide { Name = "Елена Стојановска", Role = "Специјалист за птици и див свет", Avatar = "👩‍🦱" },
        };
    }
}
