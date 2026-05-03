/* ============================================
   API SERVICE — Laravel Backend Integration
   ============================================ */

import { heroData, collections, products, storyContent, trustBadges, reviews, banners } from './mockData';

const API_BASE = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

/* Simulates network delay for realistic UX */
const delay = (ms = 300) => new Promise(resolve => setTimeout(resolve, ms));

/* When Laravel is connected, replace mock calls with fetch */
const apiFetch = async (endpoint) => {
  try {
    const res = await fetch(`${API_BASE}${endpoint}`);
    if (!res.ok) throw new Error('Network error');
    return await res.json();
  } catch {
    return null;
  }
};

/* --- Homepage --- */
export const getHeroData = async () => {
  await delay(200);
  return heroData;
};

export const getCollections = async () => {
  await delay(300);
  return collections;
};

export const getBestSellers = async () => {
  const result = await apiFetch('/products');
  if (result) return result.filter(p => p.is_featured);
  
  await delay(350);
  // Fallback to imported mockData 'products'
  return products.filter(p => p.badge === 'Best Seller' || p.rating >= 4.8);
};

export const getStoryContent = async () => {
  await delay(200);
  return storyContent;
};

export const getTrustBadges = async () => {
  await delay(100);
  return trustBadges;
};

export const getBanners = async () => {
  await delay(200);
  return banners;
};

export const getReviews = async () => {
  await delay(300);
  return reviews;
};

/* --- Products --- */
export const getProducts = async (filters = {}) => {
  const result = await apiFetch('/products');
  if (result) {
    let filtered = [...result];
    if (filters.category) {
      filtered = filtered.filter(p => p.category?.toLowerCase() === filters.category.toLowerCase());
    }
    if (filters.sort === 'price-asc') filtered.sort((a, b) => a.min_price - b.min_price);
    if (filters.sort === 'price-desc') filtered.sort((a, b) => b.min_price - a.min_price);
    return filtered;
  }

  await delay(400);
  let filtered = [...products];
  if (filters.category) {
    filtered = filtered.filter(p => p.category.toLowerCase() === filters.category.toLowerCase());
  }
  if (filters.collection) {
    filtered = filtered.filter(p => p.collection.toLowerCase().includes(filters.collection.toLowerCase()));
  }
  if (filters.search) {
    const q = filters.search.toLowerCase();
    filtered = filtered.filter(p =>
      p.name.toLowerCase().includes(q) ||
      p.category.toLowerCase().includes(q) ||
      p.description.toLowerCase().includes(q)
    );
  }
  if (filters.sort === 'price-asc') filtered.sort((a, b) => a.price - b.price);
  if (filters.sort === 'price-desc') filtered.sort((a, b) => b.price - a.price);
  if (filters.sort === 'rating') filtered.sort((a, b) => b.rating - a.rating);
  return filtered;
};

export const getProductBySlug = async (slug) => {
  const product = await apiFetch(`/products/${slug}`);
  if (product) return product;

  await delay(300);
  return products.find(p => p.slug === slug) || null;
};

/* --- Orders --- */
export const createOrder = async (orderData) => {
  try {
    const res = await fetch(`${API_BASE}/orders`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(orderData),
    });
    return await res.json();
  } catch (error) {
    console.error('Order creation failed:', error);
    return { success: false, error: error.message };
  }
};

/* --- Search --- */
export const searchProducts = async (query) => {
  const result = await apiFetch('/products');
  if (result) {
    const q = query.toLowerCase();
    return result.filter(p =>
      p.name.toLowerCase().includes(q) ||
      p.category?.toLowerCase().includes(q)
    ).slice(0, 5);
  }

  await delay(200);
  if (!query || query.length < 2) return [];
  const q = query.toLowerCase();
  return products.filter(p =>
    p.name.toLowerCase().includes(q) ||
    p.category.toLowerCase().includes(q)
  ).slice(0, 5);
};
export const getRelatedProducts = async (category, currentProductId) => {
  const result = await apiFetch('/products');
  if (result) {
    return result
      .filter(p => p.category === category && p.id !== currentProductId)
      .slice(0, 4);
  }

  await delay(400);
  return products
    .filter(p => p.category === category && p.id !== currentProductId)
    .slice(0, 4);
};

export const getProductReviews = async () => {
  // Reviews are currently mock-only in this implementation
  await delay(300);
  return reviews.slice(0, 3);
};
