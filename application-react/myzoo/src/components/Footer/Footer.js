import React from 'react'
import facebook from '../../assets/images/footer/fb.png'
import twitter from '../../assets/images/footer/twitter.png'
import youtube from '../../assets/images/footer/youtube.png'
import { NavLink } from 'react-router-dom'
import "./Footer.css"

export default function Footer(props) {
  return (
    <>
      <footer className='bg-primary'>
            <div className='text-light text-center'>
                MyZoo - Tout droits réservés
            </div>
            <div className='row no-gutters align-items-center text-center pt-2'>
                <div className='col-3'>
                    <a href='#' className='d-block' target='_blank'>
                        <img src={facebook} alt='Facebook' className='imgFb'/>
                    </a>
                </div>
                <div className='col-3'>
                    <a href='#' className='d-block' target='_blank'>
                        <img src={twitter} alt='twitter' className='imgTw'/>
                    </a>
                </div>
                <div className='col-3'>
                    <a href='#' className='d-block' target='_blank'>
                        <img src={youtube} alt='youtube' className='imgYt'/>
                    </a>
                </div>
                <div className='col-3'>
                    <NavLink to='/mentionLegales' className='nav-link m-0 p-0 p_footerLink'>
                        Mentions légales
                    </NavLink>
                    <NavLink to='mailto:contact@myZoo.ffr' className='nav-link m-0 p-0 p_footerLink'>
                        contact@myZoo.ffr
                    </NavLink>
                </div>
            </div>
      </footer>
    </>
  )
}
