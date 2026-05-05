import { motion, AnimatePresence } from 'framer-motion';
import { useWishlist } from '../store/useWishlist';
import { useCart } from '../store/useCart';
import { ProductCard } from '../ui/ProductCard';
import { Heart, ShoppingBag, Trash2, ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import './Wishlist.css';

export const Wishlist = () => {
  const { wishlist, removeFromWishlist, clearWishlist } = useWishlist();
  const { addToCart, openCart } = useCart();

  const handleMoveToCart = (product) => {
    addToCart(product);
    removeFromWishlist(product.id);
    openCart();
  };

  return (
    <div className="wishlist-page page-enter-active">
      <header className="wishlist-header">
        <div className="container">
          <motion.h1 
            className="wishlist-header__title"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
          >
            My Private Collection
          </motion.h1>
          <div className="gold-divider-center" />
          <p className="wishlist-header__desc">
            Your curated selection of Tori Crown pieces, saved for your next visit.
          </p>
        </div>
      </header>

      <div className="container">
        {wishlist.length > 0 ? (
          <div className="wishlist-content">
            <div className="wishlist-actions">
              <span>{wishlist.length} Pieces Saved</span>
              <button className="text-btn" onClick={clearWishlist}>Remove All</button>
            </div>

            <div className="wishlist-grid">
              <AnimatePresence mode="popLayout">
                {wishlist.map((product) => (
                  <motion.div 
                    key={product.id}
                    layout
                    initial={{ opacity: 0, scale: 0.9 }}
                    animate={{ opacity: 1, scale: 1 }}
                    exit={{ opacity: 0, scale: 0.8 }}
                    className="wishlist-item"
                  >
                    <ProductCard product={product} />
                    <div className="wishlist-item__overlay">
                      <button 
                        className="wishlist-move-btn"
                        onClick={() => handleMoveToCart(product)}
                      >
                        <ShoppingBag size={18} />
                        Move to Bag
                      </button>
                      <button 
                        className="wishlist-remove-icon"
                        onClick={() => removeFromWishlist(product.id)}
                        aria-label="Remove"
                      >
                        <Trash2 size={16} />
                      </button>
                    </div>
                  </motion.div>
                ))}
              </AnimatePresence>
            </div>
          </div>
        ) : (
          <motion.div 
            className="wishlist-empty"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
          >
            <div className="wishlist-empty__icon">
              <Heart size={64} strokeWidth={1} />
            </div>
            <h2>Your collection is currently empty</h2>
            <p>Begin your journey by exploring our latest high jewelry collections.</p>
            <Link to="/collections" className="gold-btn">
              Explore Collections <ArrowRight size={18} />
            </Link>
          </motion.div>
        )}
      </div>
    </div>
  );
};
