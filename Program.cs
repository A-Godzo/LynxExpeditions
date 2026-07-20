using LynxExpeditions.Data;
using Microsoft.EntityFrameworkCore;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddControllersWithViews();

var connectionString = builder.Configuration.GetConnectionString("LynxDb") ?? "Data Source=lynx.db";
builder.Services.AddDbContext<LynxDbContext>(options => options.UseSqlite(connectionString));

var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Home/Error");
}
app.UseStaticFiles();

app.UseRouting();

app.UseAuthorization();

// Apply any pending EF Core migrations (creates lynx.db on first run,
// applies incremental schema changes on later runs — see Migrations/),
// then seed it from the original static EN/MK data in Data/*.cs the
// first time only.
using (var scope = app.Services.CreateScope())
{
    var db = scope.ServiceProvider.GetRequiredService<LynxDbContext>();
    db.Database.Migrate();
    DbSeeder.SeedIfEmpty(db);
}

app.MapControllerRoute(
    name: "default",
    pattern: "{controller=Home}/{action=Index}/{id?}");

app.Run();