CODE AUDIT — licence-api
=========================

Scope
-----
- Quick review of the repository areas relevant to license activation and authentication:
  - [app/Models/User.php](app/Models/User.php)
  - [database/seeders/AdminUserSeeder.php](database/seeders/AdminUserSeeder.php)
  - [app/Http/Controllers/LicenseController.php](app/Http/Controllers/LicenseController.php)
  - [app/Models/Licence.php](app/Models/Licence.php)
  - [app/Models/Appareil.php](app/Models/Appareil.php)
  - [routes/api.php](routes/api.php)

Executive Summary
-----------------
Code follows typical Laravel structure and is generally clear. The urgent issues are:
- Non-idempotent seeder causing duplicate-email failures (seen in logs).
- Race conditions / missing DB constraints allowing license activation limits to be bypassed under concurrency.
- A likely `User` model issue where casts are declared as a method (may prevent correct password hashing behaviour).

High Priority Issues & Fixes
---------------------------

- Seeder idempotency (critical)
  - Problem: `AdminUserSeeder` calls `User::create(...)` unconditionally. Re-running seeds causes UNIQUE constraint errors (storage/logs/laravel.log).
  - Fix: Replace create with `User::firstOrCreate(['email' => 'admin@...'], [...])` or `User::updateOrCreate(...)`.

- Concurrent activation / DB-level enforcement (critical)
  - Problem: `LicenseController::check` counts devices in PHP then creates an `Appareil`. Concurrent requests may exceed `nombre_utilisateurs`.
  - Fixes:
    - Add a DB unique index on `(licence_id, identifiant_machine)` in the appareils migration.
    - Wrap the check+create in a DB transaction and lock the licence row, or use `SELECT ... FOR UPDATE` to prevent concurrent approvals.
    - Consider `upsert()` or an atomic counter to enforce limits.

Medium Priority Issues
----------------------

- `User` model casting (medium)
  - Problem: `app/Models/User.php` defines `protected function casts(): array` rather than `protected $casts = [...]`. Laravel expects the latter for standard casting.
  - Risk: `'password' => 'hashed'` may not be applied; password may not be auto-hashed when set via attributes.
  - Fix: Replace with `protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];` or confirm the attribute approach is supported by your Laravel/PHP version.

- Public API rate-limiting (medium)
  - Problem: `POST /license/check` is public and unthrottled.
  - Fix: Apply `throttle` middleware (e.g., `Route::middleware('throttle:60,1')->post(...)`) or require an API key / signed request from clients.

Low Priority / Good-to-have
--------------------------
- Add feature tests for `LicenseController::check` including: valid activation, blocked license, expired license, and concurrent activation simulation.
- Ensure production logging avoids sensitive values; confirm `APP_DEBUG=false` in prod.

Concrete Next Steps (recommended order)
-------------------------------------
1. Make `AdminUserSeeder` idempotent (quick win).
2. Add DB unique index on `(licence_id, identifiant_machine)` migration and run migration.
3. Update `LicenseController::check` to perform the availability check + create inside a DB transaction with row locking.
4. Fix `User` model `casts` to use `protected $casts` or confirm attribute approach.
5. Add rate-limiting to `POST /license/check` and add monitoring/alerts for repeated failures.
6. Add tests covering basic flows and concurrency.

Appendix — Observed log error
----------------------------
- The provided log shows repeated `Integrity constraint violation: 1062 Duplicate entry 'admin@fleetlicense.com' for key 'users.users_email_unique'` during seeding; this matches the seeder non-idempotency issue above.

End of audit
