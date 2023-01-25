import React, { Component } from 'react'
import TitreH1 from '../../Titres/TitreH1'
import Formulaire from './Formulaire/Formulaire';
import axios from 'axios';


class Contact extends Component {

  componentDidMount =() => {
    document.title = 'Page de contact'
  }

  handleEnvoiMail = (message) => {
    axios.post(`http://projet-zoo-php-react/front/sendMesssage`, message)
    .then(response => {
        console.log(response);

    })
    .catch(error => {
      console.log(error);
    })

  }

  render(){
    return (
      <>
      <TitreH1 bgColor='bg-success'>Contactez-nous</TitreH1>
      <div className='conatainers'>
        <h2>Adresse : </h2>
        <p>lorem</p>
        <h2>Téléphone: </h2>
        <p>00 00 00 00 00</p>
        <h2>Vous préférez nous écrire ?</h2>
        <Formulaire sendMail={this.handleEnvoiMail}/>
      </div>
    </>
    )
  }
}

export default Contact;
