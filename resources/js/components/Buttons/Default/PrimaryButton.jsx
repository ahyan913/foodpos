import React from 'react'

export default function PrimaryButton({ onClick, className, children}) {

  const _className = "bg-orange-600 text-white hover:bg-orange-500 rounded "+className;

  return (
    <button onClick={onClick} className={_className}>{children}</button>
  )
}
