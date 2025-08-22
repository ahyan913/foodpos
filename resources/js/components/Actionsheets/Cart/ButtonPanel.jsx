import React from 'react'
import { useCart } from "../../Contexts/Cart";

export default function ButtonPanel({ className, children}) {

    const _clasName = "absolute left-0 bottom-0 w-full p-3 bg-white dark:bg-slate-800 flex "+className
    const { getCount } = useCart();

  return (
    getCount() ? <div className={_clasName}>{children}</div>:null
  )
}
