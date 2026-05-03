import { motion } from 'framer-motion';
import './Loader.css';

export const Loader = ({ fullScreen = true }) => {
  return (
    <div className={`tory-loader ${fullScreen ? 'tory-loader--full' : ''}`}>
      <div className="tory-loader__content">
        {/* The Monogram/Logo Animation */}
        <motion.div 
          className="tory-loader__logo"
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 1, ease: "easeOut" }}
        >
          <div className="tory-loader__icon">
            <span className="tory-loader__tc">TC</span>
            <motion.div 
              className="tory-loader__sparkle"
              animate={{ 
                opacity: [0, 1, 0],
                scale: [0.5, 1.2, 0.5],
                rotate: [0, 45, 90]
              }}
              transition={{ duration: 2, repeat: Infinity, ease: "easeInOut" }}
            />
          </div>
          
          <motion.div 
            className="tory-loader__brand"
            initial={{ letterSpacing: '0.2em', opacity: 0 }}
            animate={{ letterSpacing: '0.5em', opacity: 1 }}
            transition={{ duration: 1.5, ease: "easeOut" }}
          >
            TORY CROWN
          </motion.div>
        </motion.div>

        {/* The Elegant Progress Line */}
        <div className="tory-loader__line-wrap">
          <motion.div 
            className="tory-loader__line"
            initial={{ scaleX: 0 }}
            animate={{ scaleX: [0, 1, 0] }}
            transition={{ 
              duration: 2.5, 
              repeat: Infinity, 
              ease: "easeInOut",
              times: [0, 0.5, 1]
            }}
          />
        </div>
      </div>
    </div>
  );
};
