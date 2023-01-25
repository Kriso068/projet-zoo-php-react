import React from 'react'
import './Animal.css'
import Button from '../../../components/UI/Button/Button'

// const Animal = (props) => {}
export default function Animal(props) {
  return (
    <div>
        <div className="card mb-3">
            <h3 className="card-header">
                {props.id} - {props.nom}
            </h3>
            <div className="card-body">
                <div className='card-text'>
                    {props.description}
                </div>
            </div>
            <div className='images text-center'>
                <img src={props.image} alt={props.nom} className='img-fluid h-100'/>
            </div>
            <div className="card-body">
                <h3>Famille : 
                            <Button 
                                typeBtn='btn-dark' 
                                clic={() => props.filtreFamille(props.familles.idFamille)}
                            >
                                {props.familles.libelleFamille}
                            </Button>
                </h3>

                <div>
                    {props.familles.descriptionFamille}
                </div>

            </div>
            
            <div className="card-body">
                {
                    props.continents.map(continent => {

                        let colorBtn ='';
                        switch (continent.idContinent){
                            case '1' : colorBtn = 'btn-primary'; 
                            break;
                            case '2' : colorBtn = 'btn-danger'; 
                            break;
                            case '3' : colorBtn = 'btn-warning'; 
                            break;
                            case '4' : colorBtn = 'btn-success'; 
                            break;
                            case '5' : colorBtn = 'btn-info'; 
                            break;
                            default : colorBtn = 'btn-secondary';
                        }
                        
                        return <Button 
                                    typeBtn={colorBtn} 
                                    clic={() => props.filtreContinent(continent.idContinent)} 
                                    css='m-1' key={continent.idContinent}
                                >
                                    {continent.libelleContinent}
                                </Button>
                    })
                }  
            </div>
            
        </div>
    </div>
  )
}
