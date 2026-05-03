import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Heart } from 'lucide-react';
import { useWishlist } from '../store/useWishlist';
import { Badge } from './Badge';
import './ProductCard.css';

export const ProductCard = ({ product }) => {
  const { toggleWishlist, isInWishlist } = useWishlist();
  const wished = isInWishlist(product.id);

  const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'BDT',
      minimumFractionDigits: 0,
    }).format(price);
  };

  return (
    <motion.div 
      className="product-card"
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true, margin: "-50px" }}
      transition={{ duration: 0.9, ease: [0.25, 0.46, 0.45, 0.94] }}
    >
      <div className="product-card__image-wrap">
        <Link to={`/product/${product.slug}`} className="product-card__link">
          <img 
            src={product.images?.[0] || 'https://via.placeholder.com/600x800/0A1128/C5A059?text=Tory+Crown'} 
            alt={product.name} 
            className="product-card__img product-card__img--main"
            loading="lazy"
            onError={(e) => { e.target.src = 'https://via.placeholder.com/600x800/0A1128/C5A059?text=Tory+Crown'; }}
          />
          {product.images?.[1] && (
            <img 
              src={product.images[1]} 
              alt={`${product.name} alternate view`} 
              className="product-card__img product-card__img--hover"
              loading="lazy"
              onError={(e) => { e.target.style.display = 'none'; }}
            />
          )}
        </Link>
        
        <div className="product-card__badges">
          {product.badge && <Badge variant="dark">{product.badge}</Badge>}
        </div>

        <button 
          className={`product-card__wishlist ${wished ? 'is-active' : ''}`}
          onClick={(e) => {
            e.preventDefault();
            toggleWishlist(product);
          }}
          aria-label={wished ? "Remove from wishlist" : "Add to wishlist"}
        >
          <Heart size={18} fill={wished ? "currentColor" : "none"} strokeWidth={1.5} />
        </button>
      </div>

      <div className="product-card__info">
        <div className="product-card__meta">
          <span className="product-card__collection">{product.collection}</span>
        </div>
        <h3 className="product-card__title">
          <Link to={`/product/${product.slug}`}>{product.name}</Link>
        </h3>
        <div className="product-card__price-wrap">
          <span className="product-card__price">{formatPrice(product.price)}</span>
          {product.originalPrice && (
            <span className="product-card__price-original">{formatPrice(product.originalPrice)}</span>
          )}
        </div>
      </div>
    </motion.div>
  );
};
