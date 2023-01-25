import React, {Component} from 'react'
import './Accueil.css';
import TitreH1 from '../../Titres/TitreH1';
import banderole from '../../assets/images/banderole.png';
import logo from '../../assets/images/logo.png';


class Accueil extends Component {

  componentDidMount =() => {
    document.title = 'Parc MyZoo'
  }

  render (){
    return (
      <>
      <div>
        <img src={banderole} alt="banderole" className="img-fluid" />
        <TitreH1 bgColor='bg-success'>Venez visitez le parc d'animaux MyZoo</TitreH1>
        <div className="container">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend condimentum tincidunt. Pellentesque interdum erat ut hendrerit sollicitudin. Ut libero est, vehicula nec scelerisque eu, venenatis ac ex. Etiam ornare velit quis condimentum consequat. Cras eu justo ut nibh elementum blandit. Praesent vel condimentum urna. Aenean a tincidunt elit. Morbi sit amet turpis dapibus, pellentesque purus tincidunt, interdum purus. Nullam dapibus ultrices libero, vel posuere nisi semper at. Nulla eget lectus luctus, auctor urna nec, sodales enim. Donec varius sed sem ut faucibus. Aliquam scelerisque elementum erat ut tristique. Donec tincidunt mi vel quam tristique, id fermentum dui porttitor. Sed sit amet sagittis neque, at ullamcorper augue. Mauris ac auctor lectus. 
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend condimentum tincidunt. Pellentesque interdum erat ut hendrerit sollicitudin. Ut libero est, vehicula nec scelerisque eu, venenatis ac ex. Etiam ornare velit quis condimentum consequat. Cras eu justo ut nibh elementum blandit. Praesent vel condimentum urna. Aenean a tincidunt elit. Morbi sit amet turpis dapibus, pellentesque purus tincidunt, interdum purus. Nullam dapibus ultrices libero, vel posuere nisi semper at. Nulla eget lectus luctus, auctor urna nec, sodales enim. Donec varius sed sem ut faucibus. Aliquam scelerisque elementum erat ut tristique. Donec tincidunt mi vel quam tristique, id fermentum dui porttitor. Sed sit amet sagittis neque, at ullamcorper augue. Mauris ac auctor lectus. 
          </p>
          <div className="row no-gutters align-items-center ">
            <div className='col-12 col-md-6'>
              <img src={logo} alt='logo' className='img-fluid' />
            </div>
            <div className='col-12 col-md-6 justify'>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend condimentum tincidunt. Pellentesque interdum erat ut hendrerit sollicitudin. Ut libero est, vehicula nec scelerisque eu, venenatis ac ex. Etiam ornare velit quis condimentum consequat. Cras eu justo ut nibh elementum blandit. Praesent vel condimentum urna. Aenean a tincidunt elit. Morbi sit amet turpis dapibus, pellentesque purus tincidunt, interdum purus. Nullam dapibus ultrices libero, vel posuere nisi semper at. Nulla eget lectus luctus, auctor urna nec, sodales enim. Donec varius sed sem ut faucibus. Aliquam scelerisque elementum erat ut tristique. Donec tincidunt mi vel quam tristique, id fermentum dui porttitor. Sed sit amet sagittis neque, at ullamcorper augue. Mauris ac auctor lectus. 
              
  
            </div>
            <div className='col-12 col-md-6 justify'>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend condimentum tincidunt. Pellentesque interdum erat ut hendrerit sollicitudin. Ut libero est, vehicula nec scelerisque eu, venenatis ac ex. Etiam ornare velit quis condimentum consequat. Cras eu justo ut nibh elementum blandit. Praesent vel condimentum urna. Aenean a tincidunt elit. Morbi sit amet turpis dapibus, pellentesque purus tincidunt, interdum purus. Nullam dapibus ultrices libero, vel posuere nisi semper at. Nulla eget lectus luctus, auctor urna nec, sodales enim. Donec varius sed sem ut faucibus. Aliquam scelerisque elementum erat ut tristique. Donec tincidunt mi vel quam tristique, id fermentum dui porttitor. Sed sit amet sagittis neque, at ullamcorper augue. Mauris ac auctor lectus. 
            </div>
            <div className='col-12 col-md-6'>
              <img src={logo} alt='logo' className='img-fluid' />
            </div>
          </div>
  
        </div>
      </div>
      </>
    )
  }
  
}

export default Accueil;
