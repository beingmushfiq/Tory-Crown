import { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { ShoppingBag, Heart, Search, Menu, X } from 'lucide-react';
import { useCart, selectCartCount } from '../store/useCart';
import { useWishlist } from '../store/useWishlist';
import './Header.css';

export const Header = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const location = useLocation();
  const cartCount = useCart(selectCartCount);
  const { wishlistCount } = useWishlist();

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const [prevPath, setPrevPath] = useState(location.pathname);

  if (location.pathname !== prevPath) {
    setPrevPath(location.pathname);
    setIsMobileMenuOpen(false);
  }


  return (
    <>
      <header className={`tory-header ${isScrolled ? 'is-scrolled' : ''}`}>
        <div className="container tory-header__inner">
          
          <button 
            className="tory-header__menu-btn"
            onClick={() => setIsMobileMenuOpen(true)}
            aria-label="Open menu"
          >
            <Menu size={24} strokeWidth={1.5} />
          </button>

          <nav className="tory-header__nav tory-header__nav--left">
            <Link to="/collections" className="tory-header__link">Collections</Link>
            <Link to="/jewelry" className="tory-header__link">High Jewelry</Link>
            <Link to="/bridal" className="tory-header__link">Bridal</Link>
          </nav>

          <Link to="/" className="tory-header__logo">
            <img src="/logo.png" alt="" className="tory-header__logo-img" />
            <span className="tory-header__logo-text">Tory Crown</span>
          </Link>

          <div className="tory-header__actions">
            <button className="tory-header__action-btn" aria-label="Search">
              <Search size={20} strokeWidth={1.5} />
            </button>
            <Link to="/wishlist" className="tory-header__action-btn" aria-label="Wishlist">
              <Heart size={20} strokeWidth={1.5} />
              {wishlistCount > 0 && <span className="tory-header__badge">{wishlistCount}</span>}
            </Link>
            <Link to="/checkout" className="tory-header__action-btn" aria-label="Cart">
              <ShoppingBag size={20} strokeWidth={1.5} />
              {cartCount > 0 && <span className="tory-header__badge">{cartCount}</span>}
            </Link>
          </div>
        </div>
      </header>

      {/* Mobile Menu Overlay */}
      <div className={`tory-mobile-menu ${isMobileMenuOpen ? 'is-open' : ''}`}>
        <div className="tory-mobile-menu__overlay" onClick={() => setIsMobileMenuOpen(false)} />
        <div className="tory-mobile-menu__content">
          <div className="tory-mobile-menu__header">
            <span className="tory-mobile-menu__title">Menu</span>
            <button onClick={() => setIsMobileMenuOpen(false)} aria-label="Close menu">
              <X size={24} strokeWidth={1.5} />
            </button>
          </div>
          <nav className="tory-mobile-menu__nav">
            <Link to="/collections">Collections</Link>
            <Link to="/jewelry">High Jewelry</Link>
            <Link to="/bridal">Bridal</Link>
            <Link to="/gifts">Gifts</Link>
            <Link to="/about">Maison</Link>
          </nav>
        </div>
      </div>
    </>
  );
};
