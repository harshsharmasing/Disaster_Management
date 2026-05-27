# SafeGuard — Laravel Subject Project

A disaster preparedness platform built with Laravel 11. Covers the full MVC lifecycle, Eloquent ORM, resource controllers, form validation, sessions, localization, REST API, and more.

---

## Tech Stack

- **Laravel 11** — PHP framework
- **SQLite** — database (zero config, file-based)
- **Tailwind CSS** (CDN) — styling
- **Blade** — templating engine
- **Vanilla JS** — interactive checklist toggling

---

## Setup (VS Code / Local)

### Prerequisites

- PHP 8.2+
- Composer
- Node.js (optional, only if you want to compile assets)

### Steps

```bash
# 1. Clone / open folder in VS Code
cd disaster-ready

# 2. Install PHP dependencies
composer install

# 3. Create environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Create the SQLite database file
touch database/database.sqlite

# 6. Run migrations
php artisan migrate

# 7. Seed with demo data
php artisan db:seed

# 8. Start the development server
php artisan serve
```

Open **http://localhost:8000** in your browser.

---

## Demo Credentials

| Role  | Email                  | Password   |
|-------|------------------------|------------|
| Admin | admin@example.com      | password   |
| User  | user@example.com       | password   |

---

## Project Structure

```
disaster-ready/
├── app/
│   ├── Http/
│   │   ├── Controllers/       ← 6 controllers
│   │   ├── Middleware/        ← AdminMiddleware, LocaleMiddleware
│   │   └── Requests/          ← 5 FormRequest classes
│   ├── Models/                ← User, Disaster, Contact, Checklist, Tip
│   ├── Policies/              ← ChecklistPolicy
│   └── Rules/                 ← NoAllCaps (custom validation rule)
├── database/
│   ├── migrations/            ← 3 migration files
│   └── seeders/               ← DatabaseSeeder (users, disasters, contacts, tips)
├── lang/
│   ├── en/                    ← English translations
│   └── hi/                    ← Hindi translations
├── resources/views/
│   ├── layouts/app.blade.php  ← Main layout
│   ├── disasters/             ← index, show, create, edit, _card, _form
│   ├── checklists/            ← index, create, show (interactive JS)
│   ├── contacts/              ← index
│   ├── tips/                  ← index, create
│   ├── auth/                  ← login, register, profile
│   └── errors/                ← 404
└── routes/
    ├── web.php                ← All named web routes
    └── api.php                ← REST API endpoints
```

---

## Features & Laravel Concepts Demonstrated

### Routing
- Named routes (`route('disasters.show', $disaster)`)
- Route model binding by slug (`{disaster:slug}`)
- Resource routes (`Route::resource(...)`)
- Route groups with prefix, name prefix, middleware
- API routes with throttling
- Fallback route for 404

### Controllers
- Resource controller (DisasterController — full CRUD)
- Constructor middleware (`$this->middleware('auth')`)
- Policy authorization (`$this->authorize(...)`)

### Models & Eloquent
- Relationships: `hasMany`, `belongsTo`
- Scopes: `scopeActive()`, `scopeOfType()`, `scopeApproved()`
- Route model binding
- Accessors and helper methods
- `increment()`, `with()`, `paginate()`

### Blade
- Layout inheritance (`@extends`, `@section`, `@yield`)
- Partials (`@include`)
- Stacks (`@push`, `@stack`)
- Directives: `@auth`, `@guest`, `@foreach`, `@if`, `@error`

### Validation
- FormRequest classes for all forms
- Built-in rules: `required`, `email`, `unique`, `confirmed`, `min`, `max`, `in`
- Custom validation rule (`NoAllCaps`)
- Error display with `@error`
- Form repopulation with `old()`

### Sessions
- Flash messages (`session('success')`)
- Session store/read (`session(['locale' => ...])`, `session('locale')`)
- Session ID display in profile

### Cookies
- Attaching cookies to responses
- Reading cookies in middleware
- Forgetting cookies on logout

### Localization
- English + Hindi translation files
- `LocaleMiddleware` reads session → cookie → browser header
- `__('nav.home')` syntax in Blade

### REST API
- `/api/disasters` — paginated JSON
- `/api/contacts` — filterable JSON
- `/api/stats` — aggregated counts
- Throttle middleware (`throttle:60,1`)
- JSON responses with `response()->json()`

### Database
- 3 migration files with foreign keys
- SQLite (easy) or MySQL (swap in .env)
- Seeder with 6 disasters, 15 contacts, 5 tips, 3 users
- Eloquent ORM for all queries
- Query scopes

### Security
- CSRF on all forms (`@csrf`)
- Method spoofing (`@method('DELETE')`)
- `AdminMiddleware` for role-based access
- `ChecklistPolicy` for ownership authorization
- Password hashing (bcrypt, cost 12)

---

## API Endpoints

```
GET  /api/disasters              — list all disasters (paginated)
GET  /api/disasters/{slug}       — single disaster
GET  /api/contacts               — list contacts (filter: ?type= &city=)
GET  /api/stats                  — platform statistics
GET  /api/user                   — authenticated user (requires token)
GET  /api/my/checklists          — user's checklists (requires token)
```

---

## Artisan Commands Used

```bash
php artisan serve         # Start dev server
php artisan migrate       # Run migrations
php artisan db:seed       # Seed database
php artisan route:list    # List all routes
php artisan make:model    # Generate model
php artisan make:controller --resource  # Generate resource controller
php artisan make:migration  # Generate migration
php artisan make:request    # Generate FormRequest
php artisan tinker          # Interactive shell
```
