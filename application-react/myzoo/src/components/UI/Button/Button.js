import React from 'react'

export default function Button(props) {

    let btnCss = `btn ${props.typeBtn} ${props.css}`
  return (
    <button className={btnCss} onClick={props.clic}>
      {props.children}
    </button>
  )
}
