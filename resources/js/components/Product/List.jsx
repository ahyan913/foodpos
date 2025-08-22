import React from 'react';
import ListItem from "./ListItem";
import { useTranslation } from 'react-i18next';


export default function List({ products, addCartItem }){
    const {t} = useTranslation();
    return (
        <div className="grid gap-6 lg:grid-cols-6">

            {
            products.length > 0 ?
            products.map(product=>{

                return <ListItem
                            key={"product-list-item-"+product.id}
                            product={product}
                            addCartItem={addCartItem}
                       />

            }):
            <div className="text-gray-700">{ t("No search results") }</div>
            }
        </div>
    );

}
