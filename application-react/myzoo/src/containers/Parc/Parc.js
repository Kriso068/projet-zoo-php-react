import React, {Component} from 'react'
import TitreH1 from '../../Titres/TitreH1';
import axios from 'axios';
import Animal from './Animal/Animal';
import Button from '../../components/UI/Button/Button';



class Parc extends Component {

    state = {
        animaux : null,
        filtreFamille : null,
        filtreContinent: null,
        listeFamilles: null,
        listeContinents: null,
    }

    loadData = () => {

        const famille = this.state.filtreFamille ? this.state.filtreFamille : '-1';
        const continent = this.state.filtreContinent ? this.state.filtreContinent : '-1';

        axios.get(`http://projet-zoo-php-react/front/animaux/${famille}/${continent}`)
        .then((response) => {
            this.setState({animaux: Object.values(response.data)});
        })
    }

    componentDidMount= () =>{
       this.loadData();

       axios.get(`http://projet-zoo-php-react/front/familles`)
       .then((response) => {
           this.setState({listeFamilles: Object.values(response.data)});
       })

       axios.get(`http://projet-zoo-php-react/front/continents`)
        .then((response) => {
            this.setState({listeContinents: Object.values(response.data)});
        })

    }

    componentDidUpdate = (oldProps, oldState) =>{

        if(oldState.filtreFamille !== this.state.filtreFamille || oldState.filtreContinent !== this.state.filtreContinent){
            
            this.loadData();
        }
    }

    handleSelectionFamille = (idFamille) =>{
        if(idFamille == '-1') {
            this.handleResetFiltreFamille();
        }
        else {
            this.setState({filtreFamille: idFamille});
        }
        
        
    }

    handleSelectionContinent = (idContinent) =>{
        if(idContinent == '-1') {
            this.handleResetFiltreContinent();
        }else {
            this.setState({filtreContinent: idContinent});
        }
        
        

    }

    handleResetFiltreFamille = () =>{

        this.setState({filtreFamille : null})
    }
    handleResetFiltreContinent = () =>{

        this.setState({filtreContinent : null})
    }

  render () {

    let nomFamilleFiltre = '';
    if(this.state.filtreFamille) {
        const numCaseFamilleFiltre = this.state.listeFamilles.findIndex(famille => {
            return famille.famille_id === this.state.filtreFamille;
        })
        nomFamilleFiltre = this.state.listeFamilles[numCaseFamilleFiltre].famille_libelle
    }

    let nomContinentFiltre = '';
    if(this.state.filtreContinent) {
        const numCaseContinentFiltre = this.state.listeContinents.findIndex(continent => {
            return continent.continent_id === this.state.filtreContinent;
        })
        nomContinentFiltre = this.state.listeContinents[numCaseContinentFiltre].continent_libelle
    }


    return(
        <>
            <div>
                <TitreH1 bgColor='bg-success'>Les animaux du parc</TitreH1>
                
                    <div className='container-fluid'>
                        <span>Filtre :</span> 
                        <select onChange={(event) => this.handleSelectionFamille(event.target.value)}>
                            <option 
                                value='-1' 
                                selected={this.state.filtreFamille === null ? "selected" : ''}
                            >
                                Familles
                            </option>
                                {
                                    this.state.listeFamilles ? this.state.listeFamilles.map(famille => {
                                        return <option 
                                                    value={famille.famille_id}
                                                    selected={this.state.filtreFamille === famille.famille_id  ? "selected" : ''}
                                                >
                                                    {famille.famille_libelle}
                                                </option>
                                    }):''
                                }
                        </select>
                        <select onChange={(event) => this.handleSelectionContinent(event.target.value)}>
                            <option 
                                value='-1' 
                                selected={this.state.filtreContinent === null ? "selected" : ''}
                            >
                                Continents
                            </option>
                                {
                                    this.state.listeContinents ? this.state.listeContinents.map(continent => {
                                        return <option 
                                                    value={continent.continent_id}
                                                    selected={this.state.filtreContinent ===continent.continent_id ? "selected" : ''}
                                                >
                                                    {continent.continent_libelle}
                                                </option>
                                    }):''
                                }
                        </select>
                        {
                            this.state.filtreFamille 
                                ? 
                                <Button 
                                    typeBtn='btn-secondary'
                                    clic={this.handleResetFiltreFamille}
                                >
                                    {nomFamilleFiltre} &nbsp;
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                    </svg>
                                </Button> 
                                :''
                        }
                        {
                            this.state.filtreContinent 
                                ? 
                                <Button 
                                    typeBtn='btn-secondary'
                                    clic={this.handleResetFiltreContinent}
                                >
                                    {nomContinentFiltre} &nbsp;
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                    </svg>
                                </Button> 
                                :''
                        }
                    </div>
                    
                     
                
               
                
                <div className='container'>
                    <div className='row no-gutters'>

                        {
                            this.state.animaux ? 
                            this.state.animaux.map(animal => {
                                return(
                                    <div className='col-12 col-md-6 col-xl-4' key={animal.id}>
                                        <Animal 
                                            {...animal} 
                                            filtreFamille={this.handleSelectionFamille} 
                                            filtreContinent={this.handleSelectionContinent}

                                        />
                                    </div>

                                )
                                    
                            }):''
                              
                        }
                    </div>
                </div>
            
            </div>
        </>
    );
  }
}

export default Parc;
