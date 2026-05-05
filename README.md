# 👑 Tori Crown — Crafted for Eternity

<div align="center">
  <img src="frontend/public/logo.png" alt="Tori Crown Logo" width="180" />
  <p><em>Exquisite handcrafted jewelry. Certified gold, ethically sourced diamonds, and timeless designs.</em></p>

  [![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
  [![React](https://img.shields.io/badge/React-18-61DAFB?style=for-the-badge&logo=react)](https://reactjs.org)
  [![Filament](https://img.shields.io/badge/Filament-v3-EBB308?style=for-the-badge&logo=filament)](https://filamentphp.com)
  [![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)](https://mysql.com)
</div>

---

## 🏛️ Project Overview
Tori Crown is a high-end luxury jewelry e-commerce platform designed for a premium shopping experience. It features a sophisticated **Dynamic Pricing Engine** that adjusts product prices in real-time based on daily gold market fluctuations, ensuring transparency and accuracy for both the Maison and its clients.

---

## ✨ Key Features

### 💎 The Storefront (Frontend)
- **Luxury Aesthetic**: A bespoke design system built with a midnight blue and rich gold palette.
- **Fluid Motion**: High-end micro-interactions powered by **Framer Motion** for a seamless editorial feel.
- **Intelligent Search**: Real-time product discovery and filtering.
- **PWA Ready**: Installable application with offline resilience and fast loading.
- **Dynamic Layouts**: Server-driven UI components for home and collection pages.

### ⚙️ The Engine (Backend)
- **Dynamic Pricing**: Custom logic to calculate prices using `(Gold Weight × Daily Rate) + Making Charges + VAT`.
- **CMS Control**: Full **InvenTori** and Order management powered by **Filament PHP**.
- **Security First**: Protected API endpoints via Laravel Sanctum and RBAC.
- **CAPI Integration**: Facebook Conversion API with server-side SHA-256 data hashing.
- **Logistics Integration**: Seamless connectivity with **Steadfast** and **Pathao** couriers.

---

## 🛠️ Tech Stack

| Layer | Technology |
| :--- | :--- |
| **Frontend** | `React 18`, `Vite`, `Framer Motion`, `Zustand`, `Axios` |
| **Backend** | `Laravel 13`, `Filament v3`, `Sanctum` |
| **Database** | `MySQL 8+` |
| **Cache/Queue** | `Redis` + `Laravel Horizon` |
| **Styling** | `Vanilla CSS` (Luxury Design System Tokens) |
| **Integrations** | `bKash`, `Nagad`, `SSLCommerz`, `BulkSMSBD` |

---

## 📁 Project Structure

### 🏗️ Backend (Laravel)
```text
backend/app/
├── Filament/          # Admin Resources & Custom Pages
├── Http/Api/V1/       # Versioned API Controllers
├── Models/            # Database Models & Pricing Logic
├── Modules/           # Business Logic (Order, Payment, Courier)
└── Schemas/           # Filament UI Schema Definitions
```

### 🎨 Frontend (React)
```text
frontend/src/
├── layouts/           # Global Shell (Header, Footer, CartDrawer)
├── pages/             # Route Components (Home, ProductDetails, Checkout)
├── store/             # Zustand Global State (Cart, Wishlist)
├── ui/                # Reusable Luxury UI Primitives
└── services/          # API Integration Layer
```

---

## 🚀 Getting Started

### 1️⃣ Prerequisites
- PHP 8.2+ & Composer
- Node.js 20+ & npm
- MySQL 8+
- Redis

### 2️⃣ Backend Setup
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### 3️⃣ Frontend Setup
```bash
cd frontend
npm install
npm run dev
```

---

## 🗺️ Roadmap & Progress

- [x] **Phase 1**: Branding & UI Foundation
- [x] **Phase 2**: Core Backend Architecture & API
- [x] **Phase 3**: **InvenTori** Management & CMS
- [x] **Phase 4**: Business Settings (SMS, Courier, Payments)
- [ ] **Phase 5**: Barcode Generation (38x25mm) & Logistics Automation
- [ ] **Phase 6**: Advanced Analytics & Facebook CAPI Optimization

---

<div align="center">
  <p>© 2026 Tori Crown. Designed for Excellence.</p>
  <img src="https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/aqua.png" width="100%" />
</div>
