# Lynx Expeditions — ASP.NET Core port

This is a port of the original static `main.html` single-page site to an
**ASP.NET Core 8 MVC** app. Per your choice, it's a **hybrid** port:

- **Moved into C#:** tours, tour details (itinerary/highlights/includes),
  destinations, and guides — all now strongly-typed models populated in
  `Data/*.cs` and served by `Controllers/HomeController.cs`.
- **Left in JavaScript:** all interactivity — rendering the tour grid,
  filtering, the slide-in detail panel, the EN/МК language toggle, the
  save/cookies logic, and the booking form. `wwwroot/js/site.js` is the
  original script, only modified to read tour/destination/guide data off
  `window.__LYNX_DATA__` (injected server-side as JSON) instead of
  hardcoded JS arrays.

## Project layout

```
Models/            Tour, TourDetail, ItineraryDay, Guide, Destination, HomeViewModel
Data/              Static in-memory EN + MK data (TourData, TourDetailData,
                   TourDetailDataMk, DestinationData, GuideData)
Controllers/       HomeController — builds the view model and serializes
                   both languages of data to JSON for the page
Views/Home/Index.cshtml   The page body (ported 1:1 from main.html), with
                   the "Meet the guides" cards and the booking form's tour
                   dropdown rendered server-side from the C# models
Views/Shared/_Layout.cshtml   Minimal layout: fonts + site.css + scripts
wwwroot/css/site.css      Original stylesheet, unchanged
wwwroot/js/site.js        Original script, data-loading section only changed
```

## Running it

Requires the .NET 8 SDK.

```bash
dotnet restore
dotnet run
```

Then open the URL shown in the console (typically `http://localhost:5000`
or similar — check `Properties/launchSettings.json`).

## Notes

- The Macedonian tour-5 ("Galicnik Village Escape") detail guide name is
  `"Кањонот Матка"` in `Data/TourDetailDataMk.cs` — that's carried over
  verbatim from the original `tourDetailsMk` object in `main.html`, where
  it looks like a copy-paste slip (every other language/tour pairing uses
  a person's name, e.g. "Стефан Поповски"). Worth a look if you want it
  fixed.
- No NuGet packages are referenced, so `dotnet restore` only needs the
  SDK's built-in framework references — no special network setup required.
