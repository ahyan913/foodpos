import React, { useState, useContext, createContext, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import product from '../../apis/product';

const ProductContext = createContext();

export function useProduct(){
    return useContext(ProductContext);
}

export function ProductContextProvider({children}){

    const [ products, setProducts ] = useState([]);
    const [ searchText, setSearchText ] = useState("");
    const { i18n, t } = useTranslation();

    useEffect(()=>{
        var init = async()=>{
            try{
                const response = await product.list();
                setProducts(response.data);
            }catch(e){
                //console.error(e);
            }
        }
        init();
    },[]);

    const isProductMatched = (key) =>{

        if(typeof key == "string")
            return key.trim().toLowerCase().indexOf(searchText.trim().toLowerCase()) >= 0
        return false;
    }

    const getSearchResults = () => {
        //console.log("Search Text", searchText.trim().length);
        if(searchText.trim().length > 0){
            const results =  products.filter(item=> isProductMatched(item?.name) || Object.values(item.locale).find(item => isProductMatched(item?.name)));
            return results;
        }
        else
        {
            return products;
        }
    }

    const context = {
        products,
        searchText,
        getSearchResults,
        setSearchText
    };

    return (
        <ProductContext.Provider value={context}>
            {children}
        </ProductContext.Provider>
    )
}
