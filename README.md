# Lynx Expeditions

A travel-agency website for **Lynx Expeditions**, a fictional small agency based in Skopje, North Macedonia (est. 2021). It offers carefully planned small-group trips of up to five days in four categories: Adventure, Nature, Cultural and City Escapes.

This is a university web-development project. Customers send booking *requests*; there is no online payment.

## Tech stack

- **Frontend:** HTML5, Tailwind CSS (CDN), vanilla JavaScript
- **Backend:** PHP 8+ (PDO)
- **Database:** MySQL or MariaDB

No frameworks, no Composer, no build step.

## Features

**Public site**
- Home, Expeditions, Destinations, Services, About & Contact, Journal, FAQ
- Expedition search and filters: text, category, destination, duration, difficulty, price, departure month
- Expedition pages with itinerary, quick facts, included / not included, gallery and reviews
- Contact form (no account needed), cookie banner, Privacy, Cookie and Terms pages, branded 404

**Customer account**
- Register / log in ("Remember me")
- Request to book, with a booking ID and Pending status
- My bookings, favorites, notifications (read/unread), profile and password change
- Reviews for booked expeditions, and posting to the Lynx Journal

**Admin area** (`/admin/`)
- Dashboard with active expeditions, pending bookings, unread messages, recent bookings and journal posts
- Manage expeditions (including gallery photos), destinations, bookings, reviews, journal posts and contact messages

## Business rules

- Pending **and** confirmed bookings count toward an expedition's capacity (`MaxGroupSize`).
- Customers cannot cancel; only admins can cancel a booking.
- Changing a booking's status creates an internal notification for the customer.
- A user can review an expedition once, and only after booking it. Reviews are public immediately.
- Journal posts are public immediately; admins can delete them.
- Categories are fixed (four); admins can edit their name and description only.
- Services, FAQ and team are static content.

## Project structure

```
index.php, expeditions.php, expedition.php, destinations.php, ...   public pages
auth.php, account.php, my-bookings.php, favorites.php, ...          customer pages
admin/                                                              admin area
includes/                                                           shared code (bootstrap, header, footer, cards)
assets/                                                             CSS, JS, images (team photos in assets/team/)
uploads/                                                            images uploaded through the admin area
schema.sql                                                          database structure
seed2.sql                                                           demo data for presentations
```

## Images

- Expedition and destination images are set in the admin area, by upload or by path/URL.
- The demo data may reference remote image URLs. These need an internet connection and can break.

## Notes

- Privacy Policy, Cookie Policy and Terms are fictional project texts, not legal advice.
- All company details, names and contact information are fictional and taken from random name generators.
- `seed2.sql` contains demo accounts and bookings for presentation purposes only.

**Academic project. Not intended for production use.**
