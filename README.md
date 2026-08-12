# 🎮 GameVault — Game Library CRUD Web Application

**GameVault** is a clean, modern, beginner-to-intermediate Laravel CRUD web application where users can manage their personal video game collection. Built with **Laravel 13**, **Tailwind CSS v4**, **DaisyUI v5**, and **Supabase (Auth & PostgreSQL Database)**.

---

## ✨ Features

- **Supabase Server-Side Authentication**: Secure user registration, login, and logout via Supabase Auth REST API.
- **Per-User Game Collections**: Each user gets their own private game collection powered by PostgreSQL.
- **Empty Database Requirement**: Starts with zero fake/mock data — real records created entirely via the UI.
- **Full Game CRUD**:
  - **Create**: Add new games with title, genre, platform, developer, release date, status, price, description, and cover image upload.
  - **Read**: View paginated game cards with real-time title search, status filtering, and individual game detail pages.
  - **Update**: Edit game information pre-filled in forms with optional cover image replacement.
  - **Delete**: Remove games with confirmation modals and auto-cleanup of image storage.
- **Form Request Validation**: Robust server-side validation rules (`StoreGameRequest` & `UpdateGameRequest`) with clear inline error messages.
- **Modern Gaming Aesthetics**: Dark theme dashboard built with DaisyUI components, responsive sidebar navigation, badges, cards, and custom scrollbars.

---

## 🛠️ Tech Stack & Requirements

| Technology | Purpose |
|---|---|
| **PHP 8.3+ / Laravel 13** | Core backend framework |
| **Blade** | Templating engine for server-side views |
| **PostgreSQL (Supabase)** | Cloud database backend |
| **Supabase Auth** | User authentication service |
| **Eloquent ORM** | Database queries and model relationships |
| **Tailwind CSS v4** | Utility-first CSS framework |
| **DaisyUI v5** | Component library for UI elements |
| **Vite** | Frontend build tool |

---

## 📁 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php      # Supabase Login/Register/Logout
│   │   └── GameController.php      # Resource Controller (7 RESTful methods)
│   ├── Middleware/
│   │   └── SupabaseAuth.php        # Custom middleware protecting game routes
│   └── Requests/
│       ├── StoreGameRequest.php    # Form request validation for creation
│       └── UpdateGameRequest.php   # Form request validation for updates
├── Models/
│   └── Game.php                    # Eloquent model with casts & option constants
└── Services/
    └── SupabaseService.php         # REST API wrapper for Supabase Auth
config/
└── supabase.php                    # Supabase URL & Key configuration
database/
└── migrations/
    └── 2026_08_12_000000_create_games_table.php  # Schema migration with user_id index
resources/
├── css/
│   └── app.css                     # Tailwind v4 & DaisyUI theme setup
└── views/
    ├── auth/                       # Login & Register views
    ├── games/                      # Index, Create, Show, Edit views
    └── layouts/                    # Master layout with sidebar & flash alerts
routes/
└── web.php                         # Public auth & protected resource routes
```

---

## 🎓 Key Academic & Assignment Concepts

This project clearly demonstrates core Laravel and Web Development concepts:

1. **Forms & HTTP Methods**: GET, POST, PUT (`@method('PUT')`), DELETE (`@method('DELETE')`), `multipart/form-data` file uploads, and `@csrf` protection.
2. **Databases & Migrations**: Schema builder with typed columns, nullability, indices, and PostgreSQL driver integration.
3. **Eloquent ORM**: `$fillable` protection, attribute casting (`date`, `decimal`), and scoped queries (`Game::where('user_id', ...)`).
4. **RESTful Architecture**: `Route::resource('games', GameController::class)` mapping to 7 standard controller actions.
5. **Form Requests**: Dedicated validation classes keeping controllers slim and clean.
6. **Middleware & Auth**: Custom `SupabaseAuth` middleware for route protection and view sharing.
7. **DaisyUI UI Design**: Responsive drawer sidebar, badges, alert notices, drop shadows, and modal confirmation dialogs.
