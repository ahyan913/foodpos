import React, { useState, useContext, createContext, useEffect } from 'react';
import { useTranslation } from 'react-i18next';


const LocaleContext = createContext(null);

export function useLocale(){
    return useContext(LocaleContext);
}

export default function LocaleContextProvider({children}){

    const { i18n } = useTranslation();
    const [locale, setLocale] = useState("");

    // useEffect(()=>{
    //     console.log(i18n.language, locale);
    // }, [i18n]);

    function t(locale, name){

        //console.log(i18n.language, locale);
        if(locale.length == 0){
            setLocale(locale);
        }
        try{
            return locale[i18n.language][name];
        }catch(e){
            return null;
        }
    }

    return (
        <LocaleContext.Provider value={t}>
            {children}
        </LocaleContext.Provider>
    );

}
