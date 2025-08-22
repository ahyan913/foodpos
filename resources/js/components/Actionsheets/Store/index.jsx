import React, {useState, useEffect, forwardRef} from 'react';
import ActionSheet from "actionsheet-react";
import { storeThumbnail } from '../../../utils/Url';
import axios from 'axios';
import { useTranslation } from 'react-i18next';
import { useLocale } from '../../Contexts/Locale';

export default forwardRef(function StoreActionSheet(props, ref){

    const [storeList, setStoreList] = useState([]);
    const [displayList, setDisplayList] = useState([]);
    const {t} = useTranslation();
    const _ = useLocale();

    useEffect(()=>{
        var init = async() => {
            const _storeList = await axios.get("/api/stores");
            setStoreList(_storeList.data);
            setDisplayList(_storeList.data);
        }
        init();
    },[]);

    const close = () => {
        ref.current.close();
    };

    const filterList = (value)=>{
        const _storeList  = storeList.filter(({name})=> value.length == 0 || name.indexOf(value) >=0 );
        setDisplayList(_storeList);
    }


    return (
        <ActionSheet ref={ref} touchEnable={false} sheetTransition="transform 0.5s ease-in-out">

            <div className="sticky justify-end top-0 shadow p-6 bg-white dark:bg-slate-800">
                <div className="flex justify-between mb-3">
                    <h2 className="text-2xl">{t("Store")}</h2>
                    <button onClick={close} className="w-8 mr-3" >
                    <svg fill="currentColor" data-name="Capa 1" id="Capa_1" viewBox="0 0 20 19.84" xmlns="http://www.w3.org/2000/svg"><path d="M10.17,10l3.89-3.89a.37.37,0,1,0-.53-.53L9.64,9.43,5.75,5.54a.37.37,0,1,0-.53.53L9.11,10,5.22,13.85a.37.37,0,0,0,0,.53.34.34,0,0,0,.26.11.36.36,0,0,0,.27-.11l3.89-3.89,3.89,3.89a.34.34,0,0,0,.26.11.35.35,0,0,0,.27-.11.37.37,0,0,0,0-.53Z"/></svg>
                    </button>
                </div>
                <div className="basis-full">
                    <input type="text" className="rounded w-full dark:bg-slate-800" onChange={(e)=>{ filterList(e.target.value);}} placeholder={t("Search :name").replace(":name", t("Store"))} />
                </div>
            </div>

            <div className="store-list overflow-y-auto max-h-96 grid gap-3 lg:grid-cols-4 4xl:grid-cols-6 p-6 dark:bg-slate-800" >
            { displayList.length > 0 ?
                displayList.map(({id, name, code, phone, image, locale}) => {
                    return (
                    <div key={"store-"+id} className="grid grid-cols-2 shadow border-2 rounded-lg" id={ "store-"+id }>
                        <div className="flex justify-content items-center bg-gray-400">
                            <img src={storeThumbnail(image)} className="w-full" alt={name} />
                        </div>
                        <div className="flex-col flex gap-1 p-3">
                            <div className="name">{_(locale, "name")}</div>
                            <div className="tel  flex flex-cols">

                            <svg fill='currentColor' className="w-3" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><path d="M222,158.4l-46.9-20a15.6,15.6,0,0,0-15.1,1.3l-25.1,16.7a76.5,76.5,0,0,1-35.2-35h0L116.3,96a15.9,15.9,0,0,0,1.4-15.1L97.6,34a16.3,16.3,0,0,0-16.7-9.6A56.2,56.2,0,0,0,32,80c0,79.4,64.6,144,144,144a56.2,56.2,0,0,0,55.6-48.9A16.3,16.3,0,0,0,222,158.4Z"/></svg>
                                <a href={"tel:"+phone}>+852 {phone}</a>
                            </div>
                        </div>
                    </div>
                    );
                }):
                <div>{t("No result found")}</div>
            }
            </div>


        </ActionSheet>
    );
});
