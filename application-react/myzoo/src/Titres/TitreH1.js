import React from 'react'
import './TitreH1.css'

export default function TitreH1(props) {

    let backgroundColor = props.bgColor ? props.bgColor : 'bg-primary';
    
    let monCss = `border dorbder-dark my-1 p-2 text-white text-center ${backgroundColor}`;


  return (


    <h1 className={monCss}>
        {props.children}
    </h1>
  )
}


