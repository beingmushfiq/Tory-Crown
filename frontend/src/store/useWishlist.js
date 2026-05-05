import { useState, useCallback, useEffect } from 'react';

const WISHLIST_KEY = 'Tori Crown_wishlist';

const getStoredWishlist = () => {
  try {
    return JSON.parse(localStorage.getItem(WISHLIST_KEY)) || [];
  } catch { return []; }
};

let listeners = [];
let wishlistState = getStoredWishlist();

const notify = () => {
  localStorage.setItem(WISHLIST_KEY, JSON.stringify(wishlistState));
  listeners.forEach(fn => fn(wishlistState));
};

export const useWishlist = () => {
  const [wishlist, setWishlist] = useState(wishlistState);

  useEffect(() => {
    const handler = (newWishlist) => setWishlist([...newWishlist]);
    listeners.push(handler);
    return () => { listeners = listeners.filter(l => l !== handler); };
  }, []);

  const toggleWishlist = useCallback((product) => {
    const isWished = wishlistState.some(item => item.id === product.id);
    if (isWished) {
      wishlistState = wishlistState.filter(item => item.id !== product.id);
    } else {
      wishlistState.push({
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.images[0],
        slug: product.slug,
      });
    }
    notify();
  }, []);

  const isInWishlist = useCallback((productId) => {
    return wishlist.some(item => item.id === productId);
  }, [wishlist]);

  return { wishlist, toggleWishlist, isInWishlist, wishlistCount: wishlist.length };
};
