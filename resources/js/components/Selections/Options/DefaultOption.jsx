import React, { useState } from 'react'
import { useTranslation } from 'react-i18next';

export default function DefaultOption({ option, onClick, groupSelectedOptions, limit, isSubOptionSelection }) {

    const {i18n} = useTranslation();
    const label = option.locale[i18n.language] ?? "";

    //const [selected, setSelected] = useState(false);
    const selectedOption = groupSelectedOptions.find(_optionGroup=> (_optionGroup.id === option.option_group_id) && _optionGroup.options.find(_option => ( (_option.id === option.id && !isSubOptionSelection) || (isSubOptionSelection && _option.id === option.id && _option?.qty >= 0 )  )));
    const selected = selectedOption !== undefined;
    var qty = 0;
    if(selected){
        qty = selectedOption.options.find(item=>(item.id === option.id)).qty ?? 0;
    }

    const _className = "text-sm flex items-center p-1 cursor-pointer before:content-[''] before:rounded-full before:border-gray-300 before:inline-block before:w-4 before:h-4 before:border-2 before:mr-1 before:p-2 "+(selected ? "before:bg-orange-600":"");

    return (
        <div className="flex justify-between">
            <a onClick={()=>{ onClick(option,1)}} className={_className}>{ label } {option.price > 0 && !isNaN(option.price) ? `(+${option.price.toFixed(2)})`:""}</a>

            <div className="flex items-center gap-1">
                <span>{qty}</span>
                <div className="flex flex-col gap-1">
                    <a className="w-0 h-0 border-x-8 border-b-8 border-b-gray-300 border-x-transparent hover:border-b-gray-400" onClick={()=>{ onClick(option,1)}} ></a>
                    <a className="w-0 h-0 border-x-8 border-t-8 border-t-gray-300 border-x-transparent hover:border-t-gray-400" onClick={()=>{ onClick(option,-1)}}></a>
                </div>
            </div>
        </div>
    );
}
