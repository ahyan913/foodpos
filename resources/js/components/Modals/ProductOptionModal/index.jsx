import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';
import OptionSelections from '../../Selections/Options';
import CloseButton from '../../Buttons/Default/CloseButton';
import PrimaryButton from '../../Buttons/Default/PrimaryButton';
import { useCart } from '../../Contexts/Cart';


export default function ProductOptionModal({ product, close }){

    const { t, i18n } = useTranslation();

    const { addItem, getSelectedProductsGrandTotal, updateSelectedProductOptions, selectedProductOptions, clearSelectedProductOptions } = useCart();

    var header = "";
    try{
        header = product?.locale[i18n.language].name;
    }catch(e){}

    const optionGroups = product?.option_groups ?? [];



    const validate = function(productOptionGroups){

        try{

            productOptionGroups.forEach((optionGroup, index) => {
                //console.log("here2", index);
                const limit = optionGroup?.limit ?? 0;
                const type = optionGroup.type;
                //console.log(limit, type);
                let count = 0;
                if(limit == 0){
                    return;
                }

                try{
                    // console.log(productOptionGroups);
                    // console.log(selectedProductOptions, index);
                    // console.log(selectedProductOptions[index]);
                    // selectedProductOptions[index].options.forEach(o => {
                    optionGroup.options.forEach(o=>{
                        count+= (o.qty ?? 0);
                        // console.log(o);
                        // console.log("count",count, "QTY",o.qty, "limit",limit);
                    });

                }catch(e){
                    // console.error(e);
                    // console.log("catch");
                    // console.log(selectedProductOptions);
                    throw t("Please select option in :name").replace(":name",optionGroup.locale[i18n.language].name);
                }

                if(limit > count){
                    // console.log(optionGroup)
                    // console.log("Limit",limit, "Count",count);
                    throw t("Please select option in :name").replace(":name",optionGroup.locale[i18n.language].name);
                }

            })
            return true;
        }catch(e){
            alert(e);
            return false;
        }
    }

    const submit = () =>{

        if(validate(product.option_groups)){
            var _product = {...product};
            var originalPrice = _product.price;
            _product.price = getSelectedProductsGrandTotal(_product.price);
            addItem({..._product, ...{ selectedOptions:selectedProductOptions,original_price:parseFloat(originalPrice) }}, 1);
            close();
            clearSelectedProductOptions();
        }
    }

    var cartItemPrice = getSelectedProductsGrandTotal(product.price) ?? 0;

    return (
        <div id="defaultModal" tabIndex="-1" aria-hidden="true" className="bg-black/80 animate-[fadein_0.2s_ease-in] flex justify-center items-center fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full h-screen">
            <div className="relative w-full max-w-2xl max-h-full">
                <div className="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div className="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 sticky top-0 bg-white shadow-lg">
                        <h3 className="text-md font-semibold text-gray-900 dark:text-white flex gap-3">
                            <img src={product.image_url} className="w-10 " />
                            <div className="block">
                                {header}<br/>
                                ${cartItemPrice.toFixed(2)}
                            </div>
                        </h3>
                        {/* text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white */}
                        <CloseButton onClick={close} />
                    </div>

                    <div className="p-6 space-y-6">
                        { optionGroups.map((item, index) =><OptionSelections key={"option-key-"+index} optionGroup={item}  groupSelectedOptions={selectedProductOptions} updateOption={updateSelectedProductOptions} isSubOptionSelection={false} />) }
                    </div>
                    <div className="flex items-center justify-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <PrimaryButton className="p-3" onClick={()=>{  submit();  }}>{ t("Confirm") }</PrimaryButton>

                    </div>
                </div>
            </div>
        </div>
    );

}
