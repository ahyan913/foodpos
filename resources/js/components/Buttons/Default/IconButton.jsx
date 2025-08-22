import React from 'react'

export default function IconButton({onClick, children, className, badge}) {

    const _clasName = "text-sm cursor-pointer text-gray-500 basis-full inline-flex items-center justify-center p-2 hover:bg-gray-50 dark:hover:bg-gray-500 group dark:hover:text-white "+className;

    return (
        <a onClick={onClick} type="button" className={_clasName}>
            <div className="inline-flex relative flex-col items-center justify-center gap-1">
            { badge > 0 ?
                <div className="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-3 -right-3">{badge}</div>:null
            }
            {children}
            </div>
        </a>
    )
}
