# Tory Crown: Production Implementation Roadmap

This document outlines the end-to-end execution strategy for the Tory Crown luxury jewelry eCommerce platform.

## 🏛️ Project Structure
```text
Tory Crown/
├── frontend/           # React + Vite (Storefront)
├── backend/            # Laravel + Filament (API & CMS)
└── deployment/         # Docker/Nginx/CI-CD configs
```

---

## 📅 Phase 1: Branding & UI Foundation (COMPLETED)
- [x] **Brand Identity**: Logo integration, favicon setup, and luxury color palette (`#0A1128`, `#D4AF37`).
- [x] **Responsive Storefront**: Mobile-first design with bottom glass navigation and "screen slide" prevention.
- [x] **Animations**: Implementation of Framer Motion for high-end micro-interactions and smooth page transitions.
- [x] **PWA Support**: Manifest configuration and service worker registration for offline resilience.

## ⚙️ Phase 2: Core Backend Architecture (COMPLETED)
- [x] **Framework Setup**: Initialized Laravel 13 with API-first routing.
- [x] **Database Schema**: Migrations for Products, Variants, Gold Rates, Orders, and Settings.
- [x] **Pricing Engine**: `PricingService` logic to handle daily gold rate fluctuations and making charges.
- [x] **CMS Scaffolding**: Filament Admin panel installation and User creation.

## 💎 Phase 3: CMS & Inventory Management (IN PROGRESS)
- [x] **Resource Design**: Customized Filament resources for Products and Orders with nested repeaters.
- [x] **Gold Rate Control**: Manual daily update interface for 18K/21K/22K rates.
- [x] **Media Management**: Optimization of image uploads (S3/Local) with responsive placeholders.
- [x] **SEO Automation**: Automatic slug generation and metadata fields in CMS.

## 💳 Phase 4: Financials & Logistics (NEXT STEPS)
- [ ] **SSLCommerz Integration**: Secure payment gateway for local debit/credit cards.
- [ ] **Mobile Wallets**: Deep integration with bKash and Nagad payment URLs.
- [ ] **Steadfast Delivery**: Automated consignment creation and real-time tracking sync.
- [ ] **Partial Advance Flow**: Forced advance payment logic for high-value COD orders.

## 📊 Phase 5: Analytics & Server-Side Tracking
- [x] **CAPI Infrastructure**: `AnalyticsService` with SHA-256 backend hashing.
- [ ] **GTM & Pixel**: Frontend DataLayer push for PageView, ViewContent, and AddToCart.
- [ ] **Deduplication**: Synchronization of `event_id` between client-side Pixel and server-side CAPI.
- [ ] **Advanced Matching**: Passing hashed customer data (Email/Phone) to improve attribution.

## 🚀 Phase 6: Optimization & Launch
- [ ] **Redis Caching**: Caching product catalogs and gold rates for sub-100ms response times.
- [ ] **Queue Workers**: Moving SMS, CAPI, and Courier tasks to background jobs.
- [ ] **Production Build**: Vite optimization, Minification, and SSL certification.
- [ ] **Final QA**: End-to-end testing of the checkout flow on local mobile devices.

---

## 🛠️ Active Task List

### Immediate Actions
- [ ] Move frontend files to `/frontend` directory.
- [ ] Update `vite.config.js` and `package.json` paths.
- [ ] Configure Environment Variables (`.env`) for both apps.

### Backend Enhancements
- [ ] Refine `OrderResource` with "Dispatch" actions.
- [ ] Implement `CouponService` for promotional discounts.

### Frontend Enhancements
- [ ] Migrate state management to **Zustand**.
- [ ] Implement **TanStack Query** for robust data fetching and caching.
