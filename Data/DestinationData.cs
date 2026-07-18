using System.Collections.Generic;
using LynxExpeditions.Models;

namespace LynxExpeditions.Data
{
    public static class DestinationData
    {
        public static List<Destination> GetDestinationsEn() => new()
        {
            new Destination { Name = "Ohrid & Lake Ohrid", Icon = "🏛️", Tag = "UNESCO World Heritage · cultural & nature", Count = "6 tours", PinId = "pin0" },
            new Destination { Name = "Skopje & Matka Canyon", Icon = "🚣", Tag = "Capital region · day trips & gorge tours", Count = "4 tours", PinId = "pin1" },
            new Destination { Name = "Mavrovo National Park", Icon = "⛷️", Tag = "Mountain wilderness · skiing & trekking", Count = "5 tours", PinId = "pin2" },
            new Destination { Name = "Stobi & Tikveš Valley", Icon = "🏺", Tag = "Ancient ruins · archaeology & wine", Count = "3 tours", PinId = "pin3" },
            new Destination { Name = "Shar & Tetovo Range", Icon = "🏔️", Tag = "Alpine peaks · serious trekking above 2500m", Count = "2 tours", PinId = "pin4" },
            new Destination { Name = "Prespa Lake", Icon = "🦢", Tag = "Pelicans & border waters · wildlife & peace", Count = "2 tours", PinId = "pin5" },
        };

        public static List<Destination> GetDestinationsMk() => new()
        {
            new Destination { Name = "Охрид и Охридско Езеро", Icon = "🏛️", Tag = "УНЕСКО светско наследство · култура и природа", Count = "6 тури", PinId = "pin0" },
            new Destination { Name = "Скопје и Кањонот Матка", Icon = "🚣", Tag = "Главен градски регион · дневни излети и тури низ кањон", Count = "4 тури", PinId = "pin1" },
            new Destination { Name = "Национален парк Маврово", Icon = "⛷️", Tag = "Планинска дивина · скијање и планинарење", Count = "5 тури", PinId = "pin2" },
            new Destination { Name = "Стоби и Тиквешка Долина", Icon = "🏺", Tag = "Антички рушевини · археологија и вино", Count = "3 тури", PinId = "pin3" },
            new Destination { Name = "Шар Планина и Тетовскиот регион", Icon = "🏔️", Tag = "Алпски врвови · сериозно планинарење над 2500 м", Count = "2 тури", PinId = "pin4" },
            new Destination { Name = "Преспанско Езеро", Icon = "🦢", Tag = "Пеликани и гранични води · див свет и мир", Count = "2 тури", PinId = "pin5" },
        };
    }
}
