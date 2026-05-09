# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Bike rental web application built with Laravel 12 (PHP 8.4) + Filament 3 admin panel. Live at rentabike.ro. The customer-facing site is bilingual (English/Romanian); the admin panel is at `/admin`.

## Development environment

The project runs via Docker Compose. All PHP/Composer/npm/artisan commands must run inside the `workspace` container — host PHP/Node may not match.

```bash
docker compose -f compose.dev.yaml up -d                      # start stack (web, php-fpm, workspace, postgres, redis)
docker compose -f compose.dev.yaml exec workspace bash        # enter workspace shell
docker compose -f compose.dev.yaml up -d --build              # rebuild after Dockerfile changes
```

Inside the workspace container:

```bash
composer install
npm install
npm run dev          # Vite dev server (proxied; container exposes 5173)
npm run build        # production assets
php artisan migrate
composer test        # clears config + runs phpunit (suites: tests/Unit, tests/Feature — currently empty)
php artisan test --filter=SomeTest    # run a single test
npx prettier --write resources/       # format Blade/CSS/JS
```

Site is served at http://localhost (nginx → php-fpm). Postgres on `:5432` (db `app`, user `laravel`, pass `secret`).

### Translations

Strings use `__()` and `@lang()`; canonical files are `lang/en.json` and `lang/ro.json`. After adding new translation keys in code, run:

```bash
php artisan translatable:export en
php artisan translatable:export ro
```

Eloquent model fields like `Item::$translatable = ['name', 'description']` use `spatie/laravel-translatable` and store JSON per locale in a single column — read/write through Eloquent normally and the package handles locale resolution.

## Architecture

### Request flow (customer site)

All public routes live in `routes/web.php` inside a `LaravelLocalization` group, so URLs are prefixed `/en/...` or `/ro/...`. The `localizedView()` helper picks `*-ro` vs `*-en` Blade files for static pages (about, contact, cookie-policy).

Three controllers:
- `HomeController` (single-action) — listing page; pulls available bikes filtered by date interval + category.
- `CartController` — `add-to-cart` / `remove-from-cart` (session-backed cart).
- `CheckoutController` — checkout form, order creation, success page (gated by order id + hash).

Two singleton services bound in `AppServiceProvider` parse query params from the current `Request`:
- `DateIntervalService` — extracts `fromDate`/`toDate` interval used for availability + pricing.
- `CategoryFilterService` — resolves the `category` query param to an `AttributeValues` row.

### Domain model

- **Item** — a rentable bike. Has `prices` (HasMany `ItemPrices`) and `bookings` (HasMany `ItemBooking`). `attributeValues` (BelongsToMany) drives category/feature filtering via `Attribute` + `AttributeValues` with `reference` strings (`AttributeReference::CATEGORY` etc.).
- **ItemPrices** — multiple price tiers per item, each with `duration` + `duration_unit` (DAY or HOUR, see `PriceDurationType`).
- **ItemBooking** — a reserved interval (`from_date`, `to_date`) for an item. Created when an order is saved.
- **LockedDay** — a globally blocked date (no rentals on that day). Checked in availability queries.
- **Order** + **OrderItem** — placed orders. Discounts are persisted as `OrderItem` rows with negative price.

### Repositories (in `app/Repository`)

This is where the non-trivial business logic lives — read these first when changing behavior:

- `ItemRepository::getAvailableItems()` — filters by status + active bookings overlap + locked days + category.
- `ItemRepository::calculatePriceForItem()` — picks the cheapest applicable tier; matrix of HOUR vs DAY durations. `DAY_IN_HOURS = 8` (a "day" in pricing terms is 8 hours, not 24).
- `CartRepository` — session-backed cart, key `cartItems`. Stores raw entries (id, itemId, fromDate, toDate strings); rehydrates into `CartItemDto` on read. `getCart()` returns `CartDto` with items, applied discounts, and total.
- `QuantityDiscount` — applied automatically by `CartRepository::getCart()`; produces `DiscountDto`s that are also persisted as order items at checkout.
- `OrderRepository::saveOrder()` — re-validates availability against current bookings before persisting (throws `UnavailableItemsInSelectionException` / `NoItemsSelectedException`), creates `Order` + `ItemBooking` + `OrderItem` rows, empties the cart, and sends two mails (customer `OrderConfirmation`, office `NewReservation` to `office@playbike.ro`).

### Status & enum constants

Enum-style constants (not native PHP enums) live in `app/Models/Constants/`:
`ItemStatus`, `OrderStatus`, `PaymentMethods`, `PriceDurationType`, `AttributeReference`, `CategoryReference`. Reach for these instead of bare strings.

### Admin panel (Filament)

`app/Filament/Resources/` contains `ItemResource`, `OrderResource`, `ItemBookingResource`, `AttributeResource`, `LockedDayResource`. Registered via `App\Providers\Filament\AdminPanelProvider`. Mounted at `/admin`.

### Frontend assets

Vite entrypoints are `resources/css/main.css` and `resources/js/main.js` (see `vite.config.ts`). Blade views in `resources/views/`; reusable components in `resources/views/components/` (cart preview, list filters, range selector, etc.). Layouts under `resources/views/layout/`. Mail templates under `resources/views/mail/`.

## Conventions

- New persistent business logic belongs in a Repository (see `app/Repository`), not in controllers. Controllers stay thin and delegate.
- For request-scoped derived state (parsed query params, current category, etc.), prefer a singleton Service in `app/Services` bound in `AppServiceProvider` so it can be injected.
- When adding a translatable field on a model, add it to the model's `$translatable` array and write/read normally; do not branch on `app()->getLocale()` in business code.
- Money/prices are stored as integers (cents/RON minor units depending on context) — preserve integer math in `calculatePriceForItem` and discount logic.
