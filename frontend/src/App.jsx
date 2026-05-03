import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { MainLayout } from './layouts/MainLayout';
import { Home } from './pages/Home';
import { ProductDetails } from './pages/ProductDetails';

import { Checkout } from './pages/Checkout';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<MainLayout />}>
          <Route index element={<Home />} />
          <Route path="product/:slug" element={<ProductDetails key={window.location.pathname} />} />
          <Route path="checkout" element={<Checkout />} />
          {/* Add more routes here as needed (Cart, Wishlist, Collections) */}
          <Route path="*" element={
            <div style={{padding: '20vh 0', textAlign: 'center', minHeight: '60vh'}}>
              <h2>Page Not Found</h2>
              <p>The page you are looking for does not exist.</p>
            </div>
          } />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
