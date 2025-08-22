import React from "react"
import { useCart } from "../../Contexts/Cart";
import PrimaryButton from "../../Buttons/Default/PrimaryButton";
import BinButton from "../../Buttons/Default/BinButton";
import { useTranslation } from "react-i18next";

export default function CartItem({ cartItem }){

    const { incrementItem ,decrementItem, removeItem } = useCart();
    const { product, qty } = cartItem;
    const { image_url, name, price, selectedOptions, locale, original_price } = product;
    const { i18n } = useTranslation();
    const productLabel = locale[i18n.language]?.name ?? "";
    // console.log(product);
    return (
        <div className="grid grid-cols-10 odd:bg-gray-100 py-3">
            <div className="col-span-2 p-1">
                <img src={image_url} alt={name} width="60" height="60" />
            </div>
            <div className="col-span-4 text-xs">
                <h3 className="mb-1git font-bold">{ productLabel }({"HKD$"+original_price.toFixed(2)})</h3>
                { selectedOptions.map((item, index) =>{
                    const { locale, options, type } = item;
                    const optionGroupLabel = locale[i18n.language].name ?? "";
                    return (
                        <div key={"group-"+index} className="grid grid-cols-1 items-start justify-start mb-2" >
                            <div className="font-bold mb-1">{optionGroupLabel}</div>
                            <div>
                            {
                                options.map((_option, index2)=>{
                                    var label = ""
                                    var _price = 0;
                                    var _qty = 0
                                    if(type == 1){
                                        const {locale, price, qty} = _option;
                                        label = locale[i18n.language] ?? "";
                                        _price = price;
                                        _qty = qty;
                                    }else{
                                        const {price, product, qty} = _option;
                                        label = product?.locale[i18n.language].name ?? "";
                                        _price = price;
                                        _qty = qty;
                                    }
                                    return (
                                        <div key={ "option"+index2 }>
                                            <div className="text-xs">
                                                 {label} x {_qty}{ (!isNaN(_price) && _price > 0) ? `($${(_price*_qty).toFixed(2)})`:""}
                                            </div>
                                            {
                                                _option?.product ?
                                                _option.product.option_groups.map(_group =>{
                                                    return _group.options.map((_groupOption, _index3) => {
                                                        const _label = _groupOption?.locale[i18n.language] ?? "";
                                                        const __qty = _groupOption?.qty ? parseFloat(_groupOption?.qty):0;
                                                        const __price = _groupOption?.price ? parseFloat(_groupOption?.price):0;
                                                        return __qty > 0 ?
                                                        (
                                                            <div key={ "option"+_index3 } className="ml-1">
                                                                - {( index2 > 0 ? "+":"")}{_label} x {__qty} { (!isNaN(__price) && __price > 0) ? `($${(__price*__qty).toFixed(2)})`:""}
                                                            </div>

                                                        ):null;

                                                    });
                                                }):null

                                            }
                                        </div>
                                    )
                                })
                            }
                            </div>
                        </div>
                    );
                })}
            </div>
            <div className="p-1 col-span-1 text-xs">

                { qty }

            </div>
            <div className="p-1 col-span-2 text-xs">
                ${ (price * qty).toFixed(2) }
            </div>
            <div className="p-1">
                <BinButton onClick={()=>removeItem(product)}></BinButton>
            </div>
        </div>
    );


}
