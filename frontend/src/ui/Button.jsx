import { forwardRef } from 'react';
import './Button.css';

export const Button = forwardRef(({ 
  children, 
  variant = 'primary', 
  size = 'md', 
  fullWidth = false, 
  isLoading = false,
  className = '',
  ...props 
}, ref) => {
  const classes = [
    'tory-btn',
    `tory-btn--${variant}`,
    `tory-btn--${size}`,
    fullWidth ? 'tory-btn--full' : '',
    isLoading ? 'tory-btn--loading' : '',
    className
  ].filter(Boolean).join(' ');

  return (
    <button ref={ref} className={classes} disabled={isLoading} {...props}>
      <span className="tory-btn__content">
        {children}
      </span>
      {isLoading && (
        <span className="tory-btn__loader" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v2m0 12v2m8-8h-2M6 12H4m15.364 6.364l-1.414-1.414M7.05 7.05L5.636 5.636m12.728 0l-1.414 1.414M7.05 16.95l-1.414 1.414" />
          </svg>
        </span>
      )}
    </button>
  );
});

Button.displayName = 'Button';
