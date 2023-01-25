import React from 'react'
import {BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Navbar from '../../components/UI/NavBar/Navbar';
import Footer from '../../components/Footer/Footer';
import Accueil from '../Accueil/Accueil';
import Contact from '../Contact/Contact';
import Parc from '../Parc/Parc';
import NotFound from '../NotFound/NotFound';
import Error from '../../components/Error/Error';





export default function site() {
  return (
    
      
    <Router>
        <div className='site'>
            <Navbar/>

            <Routes>
                <Route path='/' exact element={<Accueil />} />
                <Route path='/contact' exact element={<Contact />} />
                <Route path='/animaux' exact element={<Parc />} /> 
                <Route path='*' element={<Error type='404'>La page n'hesiste pas</Error>} />
            </Routes>

        <div className='minSite'></div>
        </div>
            
        <Footer />
    </Router>
    
  )
}



