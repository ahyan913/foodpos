import React, { useState } from 'react'
import { useTranslation } from 'react-i18next';
import DefaultOption from './DefaultOption';
import ProductOption from './ProductOption';

export default function OptionSelections({ optionGroup, groupSelectedOptions, updateOption, isSubOptionSelection }) {

    const { t, i18n } = useTranslation();
    const title = optionGroup?.locale[i18n.language]?.name ?? "";
    const [error, setError] = useState(false);
    var quotaLeft = 0;
    var count = 0;

    //console.log(groupSelectedOptions);

    const _foundGroup = groupSelectedOptions.find(item=>(optionGroup.id === item.id));
    if(_foundGroup){
        //count = (_foundGroup.options.length);
        _foundGroup.options.forEach(item => { count +=  item.qty ?? 0; });
    }

    const onClick = (option, qty)=>{
        //console.log(selectedOptions, optionGroup.limit);
        //console.log(selected);
        setError("");
        var updated = false;
        if(!updated){
            updated = true;
            if(optionGroup.limit < count + qty){
                if(optionGroup.limit === 1){
                    updateOption(optionGroup, option, qty, true);
                }else{
                    setError(t("Your select is already reached the limit"));
                }
            }else{
                updateOption(optionGroup, option, qty, false);
            }
        }
    }

    return (
        <>
            <div className="option-group mb-3">
                <div className="mb-3 font-bold border-b-2 border-gray-300 pb-1 flex justify-between">
                    <small>{title}</small>
                    {
                        !isNaN(optionGroup.limit) ?
                        <small>{t("Available option(s): :selected").replace(":selected", (optionGroup.limit - count))}</small>
                        :null
                    }
                </div>
                <small className="text-red-700">{error}</small>
                <div className="options flex flex-col gap-3">
                {   optionGroup.options.map((option, index) => {
                        const key = "option-"+index;
                        return optionGroup.type == 1 ?
                        <DefaultOption key={key} limit={optionGroup.limit} option={option} onClick={onClick} groupSelectedOptions={groupSelectedOptions} isSubOptionSelection={isSubOptionSelection} /> :
                        <ProductOption key={key} limit={optionGroup.limit} option={option} onClick={onClick} groupSelectedOptions={groupSelectedOptions} />
                    })
                }
                </div>
            </div>
        </>
    );
}
