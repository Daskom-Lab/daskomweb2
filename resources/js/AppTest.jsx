import './App.css';
import { useState } from 'react';
import LandingPage from './Pages/PagesPraktikan/LandingPage.jsx'; 
import ContactPage from './Pages/PagesPraktikan/ContactPage.jsx';
import AboutPage from './Pages/PagesPraktikan/AboutPage.jsx';

export default function App() {
  const [currentPage, setCurrentPage] = useState('landing');

  const renderPage = () => {
      switch (currentPage) {
          case 'landing':
              return <LandingPage setCurrentPage={setCurrentPage} />;
          case 'contact':
              return <ContactPage setCurrentPage={setCurrentPage} />;
          case 'about':
              return <AboutPage setCurrentPage={setCurrentPage} />;
          default:
              return <div>Page Not Found</div>;
      }
  };

  return (
      <>
          {renderPage()}
      </>
  );
}