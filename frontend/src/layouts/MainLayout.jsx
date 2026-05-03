import { Outlet, useLocation } from 'react-router-dom';
import { useEffect } from 'react';
import { Header } from './Header';
import { Footer } from './Footer';
import { BottomNav } from './BottomNav';
import './MainLayout.css';

export const MainLayout = () => {
  const { pathname } = useLocation();

  // Scroll to top on route change
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [pathname]);

  return (
    <div className="tory-layout">
      <Header />
      <main className="tory-layout__main">
        <Outlet />
      </main>
      <Footer />
      <BottomNav />
    </div>
  );
};
