# 👑 Tory Crown — Crafted for Eternity

<div align="center">
  <img src="frontend/public/logo.png" alt="Tory Crown Logo" width="180" />
  <p><em>Exquisite handcrafted jewelry. Certified gold, ethically sourced diamonds, and timeless designs.</em></p>
</div>

---

## 🏛️ Project Overview
Tory Crown is a high-end luxury jewelry e-commerce platform designed for a premium shopping experience. It features a sophisticated **Dynamic Pricing Engine** that adjusts product prices in real-time based on daily gold market fluctuations, ensuring transparency and accuracy for both the Maison and its clients.

---

## ✨ Key Features

### 💎 The Storefront (Frontend)
- **Luxury Aesthetic**: A bespoke design system built with a midnight blue and rich gold palette.
- **Fluid Motion**: High-end micro-interactions powered by **Framer Motion** for a seamless editorial feel.
- **Intelligent Search**: Real-time product discovery and filtering.
- **PWA Ready**: Installable application with offline resilience and fast loading via Service Workers.
- **Responsive Navigation**: Mobile-first design with an elegant glassmorphism bottom navigation.

### ⚙️ The Engine (Backend)
- **Dynamic Pricing**: Custom logic to calculate prices using Gold Weight × Daily Rate + Making Charges + VAT.
- **CMS Control**: Full inventory and order management powered by **Filament PHP**.
- **Security First**: Protected API endpoints and secure payment integrations.
- **CAPI Integration**: Facebook Conversion API with server-side SHA-256 data hashing for privacy-compliant tracking.

---

## 🛠️ Tech Stack

| Layer | Technology |
| :--- | :--- |
| **Frontend** | React 19, Vite, Framer Motion, Zustand, React Query |
| **Backend** | Laravel 13, Eloquent ORM |
| **Admin Panel** | Filament v3 |
| **Database** | MySQL / PostgreSQL |
| **Styling** | Vanilla CSS (Luxury Design System) |

---

## 🚀 Getting Started

### 1. Prerequisites
- PHP 8.2+ & Composer
- Node.js 20+ & npm
- MySQL / PostgreSQL

### 2. Backend Setup
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### 3. Frontend Setup
```bash
cd frontend
npm install
npm run dev
```

---

## 📁 Project Structure

```text
├── backend/               # Laravel API & CMS
│   ├── app/               # Pricing & Business Logic
│   ├── database/          # Migrations & Gold Rate History
│   └── filament/          # Admin Resource Definitions
├── frontend/              # React Storefront
│   ├── src/
│   │   ├── layouts/       # UI Wrappers (Header, Footer)
│   │   ├── pages/         # Product, Collection, Checkout
│   │   ├── services/      # API & Analytics logic
│   │   └── ui/            # Reusable Luxury Components
└── implementation_plan.md # Roadmap & Feature Checklist
```

---

## 🗺️ Roadmap & Progress

- [x] Phase 1: Branding & UI Foundation
- [x] Phase 2: Core Backend Architecture
- [x] Phase 3: CMS & Inventory Management
- [ ] Phase 4: Financials & Logistics (In Progress)
- [ ] Phase 5: Advanced Analytics & Optimization

---

<div align="center">
  <p>© 2026 Tory Crown. Designed for Excellence.</p>
</div>
