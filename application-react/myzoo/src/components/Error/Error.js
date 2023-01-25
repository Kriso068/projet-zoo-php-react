import React from 'react'
import TitreH1 from '../../Titres/TitreH1'

export default function Error(props) {
  return (

    <>
        <TitreH1 bgColor= 'bg-danger'>Error {props.type}</TitreH1>
        <div>
            {props.children}
        </div>
    </>
  )
}
