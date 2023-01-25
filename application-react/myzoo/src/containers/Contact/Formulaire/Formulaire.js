import React from 'react';
import { validateYupSchema, withFormik } from 'formik';
import * as Yup from 'yup';

const Formulaire = (props) =>  {
  return (
    <>
        <form>
            <div className="form-group">
                <label htmlFor="nom" className="form-label">Nom</label>
                <input
                    name='nom' 
                    onChange={props.handleChange}
                    value={props.values.nom}
                    onBlur={props.handleBlur}
                    type="text" 
                    className="form-control" 
                    id="nom" 
                />
                    {
                        props.touched.nom && props.errors.nom ? <span style={{color:'red'}}>{props.errors.nom}</span> : ''
                    }
               
            </div>
            <div className="form-group">
                <label htmlFor="email" className="form-label">E-mail</label>
                <input
                    name='email' 
                    onChange={props.handleChange}
                    value={props.values.email} 
                    onBlur={props.handleBlur}
                    type="email" 
                    className="form-control" 
                    id="email"

                />
                
                    {
                        props.errors.email && props.errors.email ? <span style={{color:'red'}}>{props.errors.email}</span> : ''
                    }
                
            </div>
            <div className="form-group">
                <label htmlFor="message">Message :</label>
                <textarea 
                    name='message' 
                    onChange={props.handleChange}
                    value={props.values.message}
                    onBlur={props.handleBlur}
                    className="form-control" 
                    placeholder="Votre message" 
                    id="message"
                >

                </textarea>
                    {
                        props.errors.message && props.errors.message ? <span style={{color:'red'}}>{props.errors.message}</span> : ''
                    }
            </div>
            
            <button
                onClick={props.handleSubmit} 
                type="submit" 
                className="btn btn-primary m-2"
            >
                Envoyer
            </button>
        </form>
    </>
  )
}

export default withFormik({
    mapPropsToValues: () => ({
        nom: '',
        email:'',
        message:'',

    }),
    validationSchema: Yup.object().shape({
        nom: Yup.string()
                .min(5, 'Le nom doit comporter au moins cinq caractères')
                .required('Le nom est obligatoire !'),

        email: Yup.string()
                  .email('L\'e-mail n\'a pas le bon format')
                  .required('L\'e-mail est obligatoire !'),

        message: Yup.string()
                    .min(50, 'Le message doit faire plus de 50 caractères')
                    .max(200, 'Le message ne doit pas faire plus de 200 caractères')
                    .required('Le message est obligatoire !'),
    }),
    handleSubmit: (values,{props}) => {
        const message = {
            nom: values.nom,
            email: values.email,
            contenu: values.message
        }
        props.sendMail(message);
        
    }
})(Formulaire);
