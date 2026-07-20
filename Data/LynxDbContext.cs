using LynxExpeditions.Models.Entities;
using Microsoft.EntityFrameworkCore;

namespace LynxExpeditions.Data
{
    /// <summary>
    /// EF Core context backed by SQLite. This is now the app's data source
    /// at runtime — HomeController reads from it instead of calling
    /// TourData / TourDetailData / TourDetailDataMk / DestinationData /
    /// GuideData directly. Those static classes still exist, but only as
    /// the one-time seed source used by DbSeeder.cs.
    /// </summary>
    public class LynxDbContext : DbContext
    {
        public LynxDbContext(DbContextOptions<LynxDbContext> options) : base(options)
        {
        }

        public DbSet<TourEntity> Tours => Set<TourEntity>();
        public DbSet<TourDetailEntity> TourDetails => Set<TourDetailEntity>();
        public DbSet<ItineraryDayEntity> ItineraryDays => Set<ItineraryDayEntity>();
        public DbSet<HighlightEntity> Highlights => Set<HighlightEntity>();
        public DbSet<IncludeEntity> Includes => Set<IncludeEntity>();
        public DbSet<DestinationEntity> Destinations => Set<DestinationEntity>();
        public DbSet<GuideEntity> Guides => Set<GuideEntity>();

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<TourEntity>()
                .HasIndex(t => new { t.TourId, t.Lang })
                .IsUnique();

            modelBuilder.Entity<TourDetailEntity>()
                .HasIndex(t => new { t.TourId, t.Lang })
                .IsUnique();

            modelBuilder.Entity<GuideEntity>()
                .HasIndex(g => new { g.GuideKey, g.Lang })
                .IsUnique();

            modelBuilder.Entity<TourDetailEntity>()
                .HasMany(td => td.Highlights)
                .WithOne()
                .HasForeignKey(h => h.TourDetailId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<TourDetailEntity>()
                .HasMany(td => td.Itinerary)
                .WithOne()
                .HasForeignKey(i => i.TourDetailId)
                .OnDelete(DeleteBehavior.Cascade);

            modelBuilder.Entity<TourDetailEntity>()
                .HasMany(td => td.Includes)
                .WithOne()
                .HasForeignKey(i => i.TourDetailId)
                .OnDelete(DeleteBehavior.Cascade);
        }
    }
}