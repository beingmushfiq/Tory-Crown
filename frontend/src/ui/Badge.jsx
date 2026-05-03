import './Badge.css';

export const Badge = ({ children, variant = 'dark', className = '' }) => {
  if (!children) return null;
  return (
    <span className={`tory-badge tory-badge--${variant} ${className}`}>
      {children}
    </span>
  );
};
