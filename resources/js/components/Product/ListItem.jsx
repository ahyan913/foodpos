import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';
import { useLocale } from '../Contexts/Locale';
import { useCart } from '../Contexts/Cart';
import PrimaryButton from '../Buttons/Default/PrimaryButton';

export default function ListItem({ product }){
    const { id, name, description, isMember, image_url, price, locale } = product
    const { t } = useTranslation()
    const [qty , setQty] = useState(1)
    const _ = useLocale();
    const { addToCart } = useCart();

    return (
    <div className="w-full lg:max-w-full rounded-lg overflow-hidden flex lg:flex-col border-gray-300 border shadow-lg" id={ "product-list-item"+id }>
        <div className="basis-1/3 lg:flex-none overflow-hidden">
            <img src={image_url} className="w-full" alt={name} />
        </div>
        <div className="basis-2/3 lg:flex-none p-3 flex flex-col">
            <div className="font-bold">{_(locale,"name")}</div>

            <div className="my-1">HKD${price}</div>

            {/* <input className="w-6 text-xs dark:bg-slate-800 basis-1/3 border-gray-300" type="number" value={qty} onChange={(e)=>{ setQty(e.target.value) }} /> */}
            <PrimaryButton onClick={()=>addToCart(product)} className="p-2" >{t("Add to cart")}</PrimaryButton>

        </div>
    </div>
    )

}
