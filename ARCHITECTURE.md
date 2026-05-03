# 💎 Tory Crown — Enterprise Architecture Blueprint

## 1. System Overview
A headless, premium jewelry eCommerce platform built for the Bangladesh market. 
- **Frontend:** React + Vite + React Router + Zustand (Headless SPA)
- **Backend API:** Laravel 11 (REST/GraphQL)
- **CMS/Admin:** Filament PHP
- **Database:** PostgreSQL / MySQL
- **Caching & Async:** Redis + Laravel Horizon (Queues)

## 2. Infrastructure & Performance
- **Caching Strategy:** 
  - Redis for frequent API responses (e.g., homepage layout, category trees).
  - Product catalog cached, invalidated on inventory/price updates.
- **Image Pipeline:** CDN integration (Cloudflare/AWS CloudFront) delivering WebP/AVIF.
- **Queue Workers:** Handling order confirmation emails, SMS notifications, and invoice generation asynchronously.

## 3. Core Database Schema (Jewelry Specific)

### `products`
- id, sku, name, slug, description
- is_active, is_featured
- category_id, collection_id

### `product_variants`
- id, product_id, sku
- size, karat (e.g., 18K, 21K, 22K, 24K)
- weight_in_grams (decimal)
- stone_type, stone_weight
- making_charge (fixed or percentage)
- base_price_override (nullable)

### `gold_rates` (Dynamic Pricing Engine)
- id, karat, price_per_gram, effective_date
- *Cron job/Admin updates this daily.*

### Price Calculation Formula (Real-time)
`Total Price = (gold_rates.price_per_gram * product_variants.weight_in_grams) + making_charge + VAT`

## 4. Filament CMS Structure
- **Content Builder:** Drag-and-drop page builder for the homepage (Hero, Banner, Carousel blocks).
- **Catalog Manager:** Deep variant management, image gallery, SEO metadata fields.
- **Order Management:** Status tracking (Pending, Processing, Shipped, Delivered).
- **Pricing Dashboard:** Daily gold rate update interface.
- **Marketing:** Flash sales, coupon generation (fixed/percent).

## 5. Bangladesh Localization integrations
- **Payments:**
  - SSLCommerz (Cards, Net Banking)
  - bKash & Nagad (Direct API integration for mobile wallets)
  - Cash on Delivery (COD) with partial advance logic.
- **Shipping:**
  - Inside Dhaka (Standard & Express delivery pricing)
  - Outside Dhaka (Pathao/RedX API integration for tracking)
- **SMS Notifications:** SSL Wireless or BulkSMSBD for order OTPs and delivery updates.

## 6. Frontend Architecture Upgrades
- **State Management:** Migrate from pure Context/React state to **Zustand** for complex cart, wishlist, and user session management.
- **Data Fetching:** Axios + React Query (TanStack Query) for caching API requests and smooth loading states.
- **Dynamic Content:** Connect React components to the Laravel API driven by the Filament Content Builder.

## 7. Security & SEO
- **Auth:** Laravel Sanctum for API token authentication (JWT/Cookies).
- **SEO:** React Helmet for dynamic meta tags; Server-Side Rendering (SSR) via Next.js or Laravel Prerender service if SEO becomes heavily reliant on crawlers without JS capability (though modern Googlebot handles SPAs well).
- **Rate Limiting:** Laravel standard API throttling on checkout and login endpoints.
