import { Link } from 'react-router-dom';
import './Footer.css';

export const Footer = () => {
  return (
    <footer className="tory-footer">
      <div className="container">
        <div className="tory-footer__grid">
          
          <div className="tory-footer__brand">
            <div className="tory-footer__logo-container">
              <img src="/logo.png" alt="" className="tory-footer__logo-img" />
              <span className="tory-footer__logo-text">Tory Crown</span>
            </div>
            <p className="tory-footer__desc">
              Exquisite handcrafted jewelry, born from a century-old tradition of master craftsmanship. 
              Designed for eternity.
            </p>
            <div className="tory-footer__social">
              <a href="#" aria-label="Instagram">IG</a>
              <a href="#" aria-label="Facebook">FB</a>
              <a href="#" aria-label="Twitter">X</a>
              <a href="#" aria-label="Youtube">YT</a>
            </div>
          </div>

          <div className="tory-footer__links">
            <h3 className="tory-footer__heading">Shop</h3>
            <ul>
              <li><Link to="/collections">All Collections</Link></li>
              <li><Link to="/jewelry">High Jewelry</Link></li>
              <li><Link to="/bridal">Bridal & Engagement</Link></li>
              <li><Link to="/gifts">Gifts</Link></li>
              <li><Link to="/new">New Arrivals</Link></li>
            </ul>
          </div>

          <div className="tory-footer__links">
            <h3 className="tory-footer__heading">The Maison</h3>
            <ul>
              <li><Link to="/about">Our Story</Link></li>
              <li><Link to="/craftsmanship">Craftsmanship</Link></li>
              <li><Link to="/sustainability">Sustainability</Link></li>
              <li><Link to="/boutiques">Find a Boutique</Link></li>
              <li><Link to="/careers">Careers</Link></li>
            </ul>
          </div>

          <div className="tory-footer__links">
            <h3 className="tory-footer__heading">Client Care</h3>
            <ul>
              <li><Link to="/contact">Contact Us</Link></li>
              <li><Link to="/faq">FAQ</Link></li>
              <li><Link to="/shipping">Shipping & Returns</Link></li>
              <li><Link to="/care">Jewelry Care</Link></li>
              <li><Link to="/appointment">Book an Appointment</Link></li>
            </ul>
          </div>

        </div>

        <div className="tory-footer__bottom">
          <p>&copy; {new Date().getFullYear()} Tory Crown. All Rights Reserved.</p>
          <div className="tory-footer__legal">
            <Link to="/privacy">Privacy Policy</Link>
            <Link to="/terms">Terms of Service</Link>
          </div>
        </div>
      </div>
    </footer>
  );
};
